<?php

namespace App\Http\Controllers\Api\Project;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Repository\UserRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repository\ProjectRepository;
use App\DataObjectTransfert\ProjectData;
use App\Http\Response\CollectionResponse;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Project\ProjectResource;
use App\Http\Resources\Project\ProjectCollection;

class ProjectController extends Controller
{
    protected ProjectRepository $projectRepository;
    protected UserRepository $userRepository;

    public function __construct(ProjectRepository $repository, UserRepository $userRepository)
    {
        $this->projectRepository = $repository;
        $this->userRepository = $userRepository;
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            Project::NAME => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 422);
        }

        $projectData = new ProjectData(
            name: $request->input(Project::NAME),
            user: Auth::id()
        );

        $project = $this->projectRepository->store($projectData->toArray());
        return $this->success(ProjectResource::make($project));
    }

    public function update(Request $request, $projectId)
    {

        $validator = Validator::make($request->all(), [
            Project::NAME => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 422);
        }

        $project = $this->projectRepository->getProject($projectId);

        $this->authorize('update', $project);

        $projectData = [
            Project::NAME => $request->input(Project::NAME)
        ];

        $project = $this->projectRepository->update($projectData, $project->id);
        return $this->success(ProjectResource::make($project));
    }

    public function index()
    {
        $user = $this->userRepository->getUser(Auth::id());

        $projects = Project::where('user_id', $user->id)
            ->orWhereHas('tasks.doneBy', function ($query) use ($user) {
                $query->where('done_by', $user->id);
            })
            ->orderBy("created_at", "desc")
            ->get();

        $data = ProjectCollection::make($projects)->response()->getData();

        return new CollectionResponse($data);
    }
}
