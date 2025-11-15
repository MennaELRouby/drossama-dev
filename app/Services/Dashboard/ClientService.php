<?php

namespace App\Services\Dashboard;

use App\Helper\Media;
use App\Models\Client;
use Illuminate\Support\Facades\DB;

class ClientService
{
    public function store($request)
    {
    
        DB::beginTransaction();
        try {

            $data = $request->validated();
       
            if ($request->hasFile('logo')) {
                $data['logo'] = Media::uploadAndAttachImageStorage($request->file('logo'), 'clients');
            }
          
            $client = Client::create($data);


            DB::commit();

            return $client;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($request, $client)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
         
            $data['status'] = $data['status'] ?? 0;
            if ($request->hasFile('logo')) {
                if ($client->logo) {
                    Media::removeFile('clients', $client->logo);
                }
                $data['logo'] = Media::uploadAndAttachImageStorage($request->file('logo'), 'clients');
            }

            $client->update($data);

            DB::commit();
            return $client;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete($selectedIds) 
    {
     $clients = Client::whereIn('id', $selectedIds)->get();
 
         DB::beginTransaction();
         try {
             foreach ($clients as $client) {
                 // Delete associated logo if it exists
                 if ($client->logo) {
                     Media::removeFile('clients', $client->logo);
                 }
                
             }
             $deleted = Client::whereIn('id', $selectedIds)->delete();
 
             DB::commit();
 
             return $deleted > 0;
 
         } catch (\Exception $e) {
           
             DB::rollBack();
 
             throw $e;
         }
     
    }
}
