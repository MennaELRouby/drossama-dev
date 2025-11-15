<?php

namespace App\Services\Dashboard\Domains;

use App\Helper\Media;
use App\Models\Dashboard\Plan;
use App\Models\Dashboard\PlanAttribute;
use Illuminate\Support\Facades\DB;

class PlanService
{

  public function store($request , $data )
  {


    DB::beginTransaction();
    try {
          // Generate slugs
      $data['slug_ar'] = preg_replace('/[\/\\\ ]/', '-', $data['name_ar']);
      $data['slug_en'] = preg_replace('/[\/\\\ ]/', '-', $data['name_en']);

        if ($request->hasFile('image')) {
            $data['image'] =   Media::uploadAndAttachImage($request->file('image'),  'plans');
        }
        if ($request->hasFile('icon')) {
            $data['icon'] =  Media::uploadAndAttachImage($request->file('icon'),  'plans');
        }

        $plan = Plan::create($data);

        if ($data['attributes_IDS']) {
            foreach ($data['attributes_IDS'] as $attribute) {
              PlanAttribute::create([
                'plan_id' => $plan->id,
                'attribute_id' => $attribute,
              ]);
            }
          }

        DB::commit();

        return true;
    } catch (\Exception $e) {

        DB::rollBack();

        return false;
    }
  }

  public function update($request, $data, $plan)
  {

    DB::beginTransaction();

    try {

      $data['status'] = $data['status'] ?? 0;
      $data['home'] = $data['home'] ?? 0;

      $plan->planAttributes()->delete();

     
      if ($data['attributes_IDS']) {
        foreach ($data['attributes_IDS'] as $attribute) {
          PlanAttribute::create([
            'plan_id' => $plan->id,
            'attribute_id' => $attribute,
          ]);
        }
      }

      if ($request->hasFile('icon')) {
        if ($plan->icon) {
          Media::removeFile('plans', $plan->icon);
        }
        $data['icon'] =   Media::uploadAndAttachImage($request->file('icon'),  'plans');
      }

      if ($request->hasFile('image')) {
        if ($plan->image) {
          Media::removeFile('plans', $plan->image);    
        }
        $data['image'] =   Media::uploadAndAttachImage($request->file('image'),  'plans');
      }

      $plan->update($data);

      DB::commit();
    } catch (\Exception $e) {

      DB::rollBack();

      return false;
    }
  }

  public function storeAttributeValues($request, $plan)
  {
    DB::beginTransaction();
    try {
      $request->validate([
        'attribute_values' => 'required|array',
        'attribute_values.*' => 'array', // Each attribute can have multiple values
      ]);

      // Detach all existing values for the plan (you may detach specific attributes if needed)
      $plan->attributeValues()->detach();

      // Loop through the selected attribute values
      foreach ($request->input('attribute_values', []) as $attributeId => $valueIds) {
        // Prepare the data for attach (attribute_id => value_id) mapping
        $attachData = collect($valueIds)->mapWithKeys(function ($valueId) use ($attributeId) {
          return [$valueId => ['attribute_id' => $attributeId]];
        })->toArray();

        // Attach the new values with their corresponding attribute_id
        $plan->attributeValues()->attach($attachData);
      }

      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();

      throw $e;
    }
  }


  public function deletePlan($request)
  {
    $selectedIds = $request->input('selectedIds');

    $request->validate([
      'selectedIds' => ['array', 'min:1'],
      'selectedIds.*' => ['exists:plans,id']
    ]);

    $plans = Plan::whereIn('id', $selectedIds)->get();

    DB::beginTransaction();

    try {
      foreach ($plans as $plan) {
        // Delete associated image if it exists
        if ($plan->image) {
          Media::removeFile('plans', $plan->image);
        }
        // Delete associated Icon if it exists
        if ($plan->icon) {
          Media::removeFile('plans', $plan->icon);
        }
      }
      $deleted = Plan::whereIn('id', $selectedIds)->delete();

      DB::commit();

      return $deleted > 0;
    } catch (\Exception $e) {

      DB::rollBack();

      return false;
    }
  }
}
