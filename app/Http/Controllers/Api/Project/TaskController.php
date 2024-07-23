<?php

namespace App\Http\Controllers\Api\Project;

use Carbon\Carbon;
use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use App\ENUM\TaskStatusEnum;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\DataObjectTransfert\TaskData;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\Project\ProjectCollection;
use App\Http\Resources\Project\ProjectResource;
use App\Repository\ProjectRepository;
use App\Http\Resources\Task\TaskResource;
use App\Http\Response\CollectionResponse;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Task\TaskCollection;
use App\Jobs\SendAssignTaskJob;
use App\Mail\AssignTaskEmail;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    protected ProjectRepository $projectRepository;
    protected UserRepository $userRepository;
    protected TaskRepository $taskRepository;

    public function __construct(
        ProjectRepository $repository,
        UserRepository $userRepository,
        TaskRepository $taskRepository
    ) {
        $this->projectRepository = $repository;
        $this->userRepository = $userRepository;
        $this->taskRepository = $taskRepository;
    }
    public function store(TaskRequest $request)
    {

        $data = $request->validated();

        $deadline = $data[Task::DEADLINE] ?? null;
        if ($deadline) {
            $deadline = Carbon::make(((string) $deadline));
        }

        $taskData = new TaskData(
            title: $data[Task::TITLE],
            description: $data[Task::DESCRIPTION] ?? null,
            deadline: $deadline,
            priority: $data[Task::PRIORITY],
            status: TaskStatusEnum::PENDING->value,
            project: $data[Task::PROJECT],
            user: Auth::id(),
        );

        $task = $this->taskRepository->store($taskData->toArray());

        return $this->success(TaskResource::make($task), "Tache créée avec succès");
    }

    public function update(UpdateTaskRequest $request, $taskId)
    {

        $data = $request->validated();

        $task = $this->taskRepository->getTask($taskId);

        $deadline = $data[Task::DEADLINE] ?? null;
        if ($deadline) {
            $deadline = Carbon::make((string) $deadline);
        }

        $data = [
            Task::TITLE => $data[Task::TITLE],
            Task::DESCRIPTION => $data[Task::DESCRIPTION],
            Task::PRIORITY => $data[Task::PRIORITY],
            Task::STATUS => $data[Task::STATUS],
            Task::DEADLINE => $deadline,
        ];

        $task = $this->taskRepository->update($data, $task->id);

        return $this->success(TaskResource::make($task), "Tache modifiée avec succès");
    }

    public function assignTask(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'task_id' => 'required|string|exists:tasks,id',
            'email' => 'required|string|exists:users,email',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 422);
        }

        $user = $this->userRepository->getUserByEmail($request->input('email'));
        $task = $this->taskRepository->getTask($request->input('task_id'));

        $authorEmail = $task->user->email;
        $newUserEmail = $user->email;

        if ($authorEmail && $authorEmail === $newUserEmail) {
            return $this->error("L'email est le meme que celui de l'auteur", 422);
        }

        if ($task->doneBy !== null && $task->doneBy->email === $newUserEmail) {
            return $this->error("Tache déjà assignée à l'utilisateur", 422);
        }

        $data = [
            Task::DONE_BY => $user->id,
            Task::ASSIGN_AT => now(),
        ];

        $this->taskRepository->update($data, $task->id);
        SendAssignTaskJob::dispatch($task);
        Log::info("Email envoyée");
        return $this->success([], "Tache assignée avec succès");
    }

    public function homeData(Request $request)
    {
        $user = $this->userRepository->getUser(Auth::id());

        $projects = Project::where('user_id', $user->id)
            ->orWhereHas('tasks.doneBy', function ($query) use ($user) {
                $query->where('done_by', $user->id);
            })
            ->orderBy("created_at", "desc")
            ->get();

        $lastProject = null;

        if ($projects !== null) {
            $lastProject = $projects->first();
        }

        if ($lastProject) {
            $tasks = $lastProject->tasks()->where(function ($query) {
                $query->where(Task::DONE_BY, Auth::id())
                    ->orWhere(Task::USER, Auth::id());
            })->orderBy('created_at', 'desc')->with("doneBy", "user")->paginate($request->per_page ?? 20);

            $data = TaskCollection::make($tasks)->response()->getData();

            $result = [
                'projects' => ProjectCollection::make($projects) ?? [],
                'tasks' => $data ?? [],
                'defualt_project' => $lastProject
            ];
            return new CollectionResponse($result);
        }

        return $this->success([
            "projects" => [],
            "tasks" => []
        ]);
    }

    public function getProjectTasks(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_id' => 'required|string|exists:projects,id',
            'per_page' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 422);
        }

        $project = $this->projectRepository->getProject($request->input('project_id'));
        $tasks = $project->tasks()
            ->where(function ($query) {
                $query->where(Task::DONE_BY, Auth::id())
                    ->orWhere(Task::USER, Auth::id());
            })
            ->orderBy('created_at', 'desc')
            ->with(["doneBy", "user"]);

        if ($request->input(Task::PRIORITY)) {
            $tasks = $tasks->where(Task::PRIORITY, $request->input(Task::PRIORITY));
        }

        if ($request->input(Task::STATUS)) {
            $tasks = $tasks->where(Task::STATUS, $request->input(Task::STATUS));
        }

        $taskData = $tasks->paginate($request->per_page ?? 20);

        $data = TaskCollection::make($taskData)->response()->getData();

        return new CollectionResponse($data);
    }

    function getInvolvedProjects()
    {
        $userId = Auth::id();

        $projects = Project::where('user_id', $userId)
            ->orWhereHas('tasks.users', function ($query) use ($userId) {
                $query->where('users.id', $userId);
            })
            ->orderBy("created_at", "desc")
            ->get();

        return $projects;
    }

    public function getTask($id)
    {
        $task = $this->taskRepository->getTask($id);

        return $this->success(TaskResource::make($task->load('doneBy')));
    }
}
