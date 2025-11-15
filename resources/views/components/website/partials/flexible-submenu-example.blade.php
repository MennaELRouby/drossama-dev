{{-- 
    Template مرن لصب منيو الخدمات - يمكن تطبيقه على أي موقع
    
    المتغيرات المطلوبة:
    - $menuCssClass: كلاس CSS للقائمة الرئيسية
    - $dropdownClass: كلاس CSS للعناصر المنسدلة  
    - $submenuClass: كلاس CSS للقائمة الفرعية
    - $servicesData: مصدر بيانات الخدمات
    - $servicesRoute: رابط صفحة جميع الخدمات
    - $serviceKeywords: الكلمات المفتاحية لكشف الخدمات
--}}

@php
    // إعدادات قابلة للتخصيص
    $config = [
        'menu_class' => $menuCssClass ?? 'main-menu',
        'dropdown_class' => $dropdownClass ?? 'has-dropdown',
        'submenu_class' => $submenuClass ?? 'submenu',
        'services_data' => $servicesData ?? ($headerServices ?? []),
        'services_route' => $servicesRoute ?? 'website.services',
        'services_limit' => $servicesLimit ?? 5,
        'keywords' => $serviceKeywords ?? ['services', 'خدم', 'service', 'servicio'],
    ];
@endphp

<ul class="{{ $config['menu_class'] }}">
    @foreach ($menus as $menu)
        @php
            $hasChildren = isset($menu['children']) && count($menu['children']);

            // كشف مرن للخدمات
            $isServices = false;
            foreach ($config['keywords'] as $keyword) {
                if (str_contains($menu['link'], $keyword) || str_contains(strtolower($menu['name']), $keyword)) {
                    $isServices = true;
                    break;
                }
            }
        @endphp

        <li class="{{ $hasChildren || $isServices ? $config['dropdown_class'] : '' }}">
            <a href="{{ $menu['link'] }}">{{ $menu['name'] }}</a>

            @if ($hasChildren)
                {{-- قائمة فرعية عادية --}}
                <ul class="{{ $config['submenu_class'] }}">
                    @foreach ($menu['children'] as $child)
                        <li><a href="{{ $child['link'] }}">{{ $child['name'] }}</a></li>
                    @endforeach
                </ul>
            @elseif ($isServices && count($config['services_data']) > 0)
                {{-- قائمة فرعية للخدمات --}}
                <ul class="{{ $config['submenu_class'] }}">
                    @foreach (collect($config['services_data'])->take($config['services_limit']) as $service)
                        <li><a
                                href="{{ $service->link ?? $service['link'] }}">{{ $service->name ?? $service['name'] }}</a>
                        </li>
                    @endforeach
                    <li><a href="{{ route($config['services_route']) }}">{{ __('website.view_all_services') }}</a></li>
                </ul>
            @endif
        </li>
    @endforeach
</ul>
