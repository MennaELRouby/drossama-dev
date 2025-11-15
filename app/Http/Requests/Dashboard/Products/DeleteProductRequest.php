<?php

namespace App\Http\Requests\Dashboard\Products;

use App\Http\Requests\Dashboard\BaseDeleteRequest;

class DeleteProductRequest extends BaseDeleteRequest
{
    protected function getTable(): string
    {
        return 'products';
    }
}