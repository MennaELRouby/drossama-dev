<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\SeoAssistant;
use Illuminate\Http\Request;

class SeoAssistantController extends Controller
{
    public function index()
    {
        $this->authorize('seo_assistants.view');

        $seo = SeoAssistant::firstOrNew();

        return view('Dashboard.SeoAssistant.index', compact('seo'));
    }

    public function edit()
    {
        $this->authorize('seo_assistants.edit');

        $seo = SeoAssistant::firstOrNew();

        return view('Dashboard.SeoAssistant.edit', compact('seo'));
    }

    public function update(Request $request)
    {
        $this->authorize('seo_assistants.edit');

        $pages = ['home', 'about', 'contact', 'blog', 'service', 'products'];
        $langs = ['en', 'ar'];
        $rules = [];
        foreach ($pages as $page) {
            foreach ($langs as $lang) {
                $rules["{$page}_meta_title_{$lang}"] = 'nullable|string|max:255';
                $rules["{$page}_meta_desc_{$lang}"] = 'nullable|string|max:500';
            }
        }
        $request->validate($rules);

        $seo = SeoAssistant::firstOrNew();
        $seo->fill($request->all());
        $seo->save();

        return redirect()->route('dashboard.seo-assistants.index')
            ->with('success', __('dashboard.seo_assistant_updated_successfully'));
    }
}
