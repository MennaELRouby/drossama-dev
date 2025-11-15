<?php

namespace App\Services\Dashboard;

use App\Models\Redirect;
use Illuminate\Support\Facades\Cache;

class RedirectService
{
    public function list(int $perPage = 20)
    {
        return Redirect::orderByDesc('id')->paginate($perPage);
    }

    public function create(array $data): Redirect
    {
        $redirect = Redirect::create($data);
        Cache::forget('redirects.map');
        return $redirect;
    }

    public function update(Redirect $redirect, array $data): Redirect
    {
        $redirect->update($data);
        Cache::forget('redirects.map');
        return $redirect;
    }

    public function delete(Redirect $redirect): void
    {
        $redirect->delete();
        Cache::forget('redirects.map');
    }
}


