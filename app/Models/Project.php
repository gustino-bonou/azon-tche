<?php

namespace App\Models;

use App\Trait\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory, HasUuid;

    const TABLE_NAME = 'projects';
    const NAME = 'name';
    const USER = 'user_id';

    protected $fillable = [
        self::NAME,
        self::USER
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
