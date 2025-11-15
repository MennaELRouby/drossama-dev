<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerformanceController extends Controller
{
    public function index()
    {
        // جلب البيانات الحقيقية من قاعدة البيانات
        $metrics = DB::table('performance_metrics')
            ->select('metric', 'rating', DB::raw('COUNT(*) as count'))
            ->groupBy('metric', 'rating')
            ->get();

        // تحضير البيانات للإحصائيات
        $performanceData = [
            'cls' => ['good' => 0, 'needs_improvement' => 0, 'poor' => 0],
            'fid' => ['good' => 0, 'needs_improvement' => 0, 'poor' => 0],
            'lcp' => ['good' => 0, 'needs_improvement' => 0, 'poor' => 0],
            'fcp' => ['good' => 0, 'needs_improvement' => 0, 'poor' => 0],
            'ttfb' => ['good' => 0, 'needs_improvement' => 0, 'poor' => 0]
        ];

        foreach ($metrics as $metric) {
            if (isset($performanceData[strtolower($metric->metric)])) {
                $performanceData[strtolower($metric->metric)][$metric->rating] = $metric->count;
            }
        }

        // جلب آخر 10 قياسات
        $recentMetrics = DB::table('performance_metrics')
            ->select('page', 'metric', 'value', 'rating', 'created_at')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->groupBy('created_at')
            ->map(function ($group) {
                $first = $group->first();
                return [
                    'page' => $first->page,
                    'cls' => $group->where('metric', 'CLS')->first()->value ?? 0,
                    'fid' => $group->where('metric', 'FID')->first()->value ?? 0,
                    'lcp' => $group->where('metric', 'LCP')->first()->value ?? 0,
                    'fcp' => $group->where('metric', 'FCP')->first()->value ?? 0,
                    'ttfb' => $group->where('metric', 'TTFB')->first()->value ?? 0,
                    'timestamp' => $first->created_at
                ];
            })
            ->values()
            ->toArray();

        $message = count($recentMetrics) > 0 ? null : "لا توجد بيانات أداء متاحة حالياً. سيتم جمع البيانات تلقائياً عند زيارة الصفحات.";

        return view('Dashboard.Performance.index', compact('performanceData', 'recentMetrics', 'message'));
    }

    public function store(Request $request)
    {
        // حفظ بيانات الأداء من JavaScript
        $data = $request->validate([
            'metric' => 'required|string',
            'value' => 'required|numeric',
            'rating' => 'required|string',
            'page' => 'required|string'
        ]);

        // حفظ البيانات في قاعدة البيانات
        DB::table('performance_metrics')->insert([
            'metric' => $data['metric'],
            'value' => $data['value'],
            'rating' => $data['rating'],
            'page' => $data['page'],
            'user_agent' => $request->header('User-Agent'),
            'ip_address' => $request->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json(['success' => true]);
    }
}