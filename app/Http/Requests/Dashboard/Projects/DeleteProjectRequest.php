<?php

namespace App\Http\Requests\Dashboard\Projects;

use App\Http\Requests\Dashboard\BaseDeleteRequest;

class DeleteProjectRequest extends BaseDeleteRequest
{
    protected function getTable(): string
    {
        return 'projects';
    }
}