<?php

namespace App\Services\Dashboard;

use App\Models\Statistic;
use Illuminate\Support\Facades\DB;

class StatisticService
{
    public function store($request)
    {
        $data = $request->validated();
       
        DB::beginTransaction();
        try {
           
            $statistic = Statistic::create($data);

            DB::commit();

            return $statistic;

        } catch (\Exception $e) {

            DB::rollback();

            throw $e;
        }
    }

    public function update($request, $statistic)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $data['status'] = $data['status'] ?? 0;
        
            $statistic->update($data);

            DB::commit();

            return $statistic;

        } catch (\Exception $e) {

            DB::rollback();

            throw $e;
        }
    }


    public function delete($selectedIds) 
    {
     $statistics = statistic::whereIn('id', $selectedIds)->get();
 
         DB::beginTransaction();
         try {
            
             $deleted = statistic::whereIn('id', $selectedIds)->delete();
 
             DB::commit();
 
             return $deleted > 0;
 
         } catch (\Exception $e) {
           
             DB::rollBack();
 
             throw $e;
         }
     
    }
 
}
