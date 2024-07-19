<?php

namespace App\Models;

use App\Trait\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory, HasUuid;

    const TABLE_NAME = 'projects';
    const NAME = 'name';

    protected $fillable = [
        self::NAME
    ];
}
