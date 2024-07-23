<?php

namespace App\ENUM;

enum TaskStatusEnum : string
{

    case PENDING = "pending";
    case IN_PROGRESS = "in_progress";
    case ENDED = "ended";

}
