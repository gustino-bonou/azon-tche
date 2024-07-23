<?php

namespace App\Jobs;

use Exception;
use App\Models\Task;
use App\Models\User;
use App\Mail\AssignTaskEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendAssignTaskJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public Task $task;
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $doneBy = User::findOrFail($this->task->done_by);
        $data = [
            "donby_email" => $doneBy->email,
            "donby_name" => $doneBy->name,
            "author_name" => $this->task->user->name,
            "task_id" => $this->task->id,
            "task_title" => $this->task->title,
        ];
        try {
            Mail::to($doneBy->email)->send(new AssignTaskEmail($data));
        } catch (Exception $e) {
            Log::info($e->getMessage());
        }
    }
}
