<?php

namespace App\Services\Dashboard;

use App\Helper\Media;
use App\Models\CareerApplication;
use Illuminate\Support\Facades\DB;

class SaveApplicationService
{
    public function saveApplication($request)
    {
        DB::beginTransaction();
        try {
            $data =  $request->validated();

            if ($request->hasFile('cv')) {
              
                $data['cv'] = Media::uploadAndAttachFile($request->file('cv'), 'career-applications' , $data['name'] );
              
            }
           
            $application = CareerApplication::create($data);
            DB::commit();
            return $application;
        } catch (\Exception $e) {
            DB::rollBack();
           throw $e;
        }
      
    }
}
