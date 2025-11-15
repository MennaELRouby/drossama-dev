<?php

namespace App\Services\Dashboard;

use App\Models\Dashboard\Domain;

class DomainService
{
    public function store($data)
    {
        // Generate slugs
        $data['slug_ar'] = preg_replace('/[\/\\\ ]/', '-', $data['title_ar']);
        $data['slug_en'] = preg_replace('/[\/\\\ ]/', '-', $data['title_en']);

        return Domain::create($data);
    }

    public function update($data,$domain)
    {
        $data['status'] = $data['status'] ?? 0;
        $data['index'] = $data['index'] ?? 0;

        
        $domain->update($data);
    }

    public function delete($selectedIds)
    {

        try {
            return  Domain::whereIn('id', $selectedIds)->delete();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
