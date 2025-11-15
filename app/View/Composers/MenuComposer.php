<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Models\Dashboard\Menu;
use Illuminate\Support\Facades\Cache;

class MenuComposer
{
    public function compose(View $view): void
    {
        try {
            $hierarchicalMenus = Cache::remember('hierarchical_menus', 3600, function () {
                return $this->buildMenuHierarchy();
            });

            $view->with('menus', $hierarchicalMenus);
        } catch (\Exception $e) {
            $simpleMenus = Menu::active()->orderBy('order', 'asc')->get();

            $view->with('menus', $simpleMenus);
        }
    }

    private function buildMenuHierarchy()
    {
        $parentMenus = Menu::with('children')->active()->whereNull('parent_id')->orderBy('order', 'asc')->get();

        if ($parentMenus->isEmpty()) {
            return collect([]);
        }

        // Add active status to each menu
        $currentPath = request()->path();
        $currentLocale = app()->getLocale();

        return $parentMenus->map(function ($menu) use ($currentPath, $currentLocale) {
            $menu->active = $this->isMenuActive($menu, $currentPath, $currentLocale);

            // Also check children
            if ($menu->children) {
                $menu->children = $menu->children->map(function ($child) use ($currentPath, $currentLocale) {
                    $child->active = $this->isMenuActive($child, $currentPath, $currentLocale);
                    return $child;
                });
            }

            return $menu;
        });
    }

    private function isMenuActive($menu, $currentPath, $currentLocale)
    {
        // Remove locale prefix from current path for comparison
        $pathWithoutLocale = preg_replace('/^' . $currentLocale . '\//', '', $currentPath);

        // Check if menu segment matches current path
        if ($menu->segment && $menu->segment !== '#') {
            // Remove leading slash and compare
            $menuSegment = ltrim($menu->segment, '/');

            // Direct match
            if ($pathWithoutLocale === $menuSegment) {
                return true;
            }

            // Check if current path starts with menu segment
            if (str_starts_with($pathWithoutLocale, $menuSegment . '/')) {
                return true;
            }
        }

        // Check children for active status
        if ($menu->children && $menu->children->count() > 0) {
            foreach ($menu->children as $child) {
                if ($this->isMenuActive($child, $currentPath, $currentLocale)) {
                    return true;
                }
            }
        }

        return false;
    }
}
