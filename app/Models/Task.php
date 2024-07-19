<?php

namespace App\Models;

use App\Trait\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory, HasUuid;

    const TITLE = 'title';
    const DESCRIPTION = 'description';
    const START_AT = 'start_at';
    const PREVIEW_END_AT = 'preview_end_at';
    const END_AT = 'end_at';
    const FILE = 'media_id';
    const USER = 'user_id';

}
