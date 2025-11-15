<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Models\Dashboard\Menu;
use App\Models\Product;
use App\Models\Service;
use App\Helper\SocialMediaHelper;
use Illuminate\Support\Facades\Cache;

class FooterMenuComposer
{
    public function compose(View $view): void
    {
        try {
            $footerMenus = Cache::remember('footer_menus', 3600, function () {
                return $this->buildFooterMenus();
            });

            // Get products that should show in footer
            $products = Product::active()
                ->footer()
                ->orderBy('order')
                ->take(6)
                ->get();

            // Get services that should show in footer (if needed)
            $services = Service::active()
                ->footer()
                ->orderBy('order')
                ->take(6)
                ->get();

            $view->with([
                'footerMenus' => $footerMenus,
                'products' => $products,
                'services' => $services,
                'socialMediaLinks' => SocialMediaHelper::getSocialMediaLinks(),
            ]);
        } catch (\Exception $e) {
            $simpleMenus = Menu::active()->whereNull('parent_id')->orderBy('order', 'asc')->get()->map(function ($menu) {
                return [
                    'id' => $menu->id,
                    'name' => $menu->name,
                    'link' => $menu->link,
                    'segment' => $menu->segment,
                ];
            })->toArray();

            $view->with([
                'footerMenus' => $simpleMenus,
                'products' => collect([]),
                'services' => collect([]),
                'socialMediaLinks' => SocialMediaHelper::getSocialMediaLinks(),
            ]);
        }
    }

    private function buildFooterMenus(): array
    {
        // جلب جميع القوائم النشطة
        $allMenus = Menu::active()->orderBy('order', 'asc')->get();

        if ($allMenus->isEmpty()) {
            return [];
        }

        $menuTree = [];

        // جلب القوائم الرئيسية فقط
        $parentMenus = $allMenus->filter(function ($menu) {
            return is_null($menu->parent_id);
        });

        foreach ($parentMenus as $parentMenu) {
            // التحقق من عدم وجود أطفال لهذه القائمة
            $hasChildren = $allMenus->where('parent_id', $parentMenu->id)->count() > 0;

            // إضافة القائمة فقط إذا لم يكن لها أطفال
            if (!$hasChildren) {
                $menuTree[] = [
                    'id' => $parentMenu->id,
                    'name' => $parentMenu->name,
                    'link' => $parentMenu->link,
                    'segment' => $parentMenu->segment,
                ];
            }
        }

        return $menuTree;
    }
}
