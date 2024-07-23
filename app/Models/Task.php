<?php

namespace App\Models;

use App\Trait\HasUuid;
use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Task extends Model
{
    use HasFactory, HasUuid;

    const TABLE_NAME = 'tasks';
    const TITLE = 'title';
    const DESCRIPTION = 'description';
    const DEADLINE = 'deadline';
    const STATUS = 'status';
    const PRIORITY = 'priority';
    const PROJECT = 'project_id';
    const USER = 'user_id';
    const DONE_BY = 'done_by';
    const ASSIGN_AT = 'assign_at';

    protected $fillable = [
        self::TITLE,
        self::DESCRIPTION,
        self::DEADLINE,
        self::USER,
        self::PROJECT,
        self::STATUS,
        self::PRIORITY,
        self::DONE_BY,
        self::ASSIGN_AT
    ];


    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, self::PROJECT);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, self::USER);
    }
    public function doneBy(): BelongsTo
    {
        return $this->belongsTo(User::class, self::DONE_BY);
    }
}
