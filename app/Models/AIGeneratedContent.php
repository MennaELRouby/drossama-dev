<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class AIGeneratedContent extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'ai_generated_contents';

    protected $fillable = [
        'title',
        'content',
        'type',
        'prompt',
        'options',
        'usage_data',
        'model_used',
        'status',
        'generated_by',
        'target_model',
        'target_id',
        'meta_description',
        'keywords',
        'word_count',
        'generation_time',
        'cost',
    ];

    protected $casts = [
        'options' => 'array',
        'usage_data' => 'array',
        'generation_time' => 'datetime',
        'cost' => 'decimal:6',
    ];

    /**
     * العلاقة مع المستخدم الذي أنشأ المحتوى
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'generated_by');
    }

    /**
     * العلاقة مع المقال المرتبط
     */
    public function blog()
    {
        return $this->belongsTo(\App\Models\Blog::class, 'target_id')
            ->where('target_model', 'Blog');
    }

    /**
     * الحصول على النموذج المرتبط
     */
    public function targetModel()
    {
        if ($this->target_model && $this->target_id) {
            return $this->target_model::find($this->target_id);
        }
        return null;
    }

    /**
     * نطاق للمحتوى النشط
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * نطاق للمحتوى حسب النوع
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * نطاق للمحتوى المُنشأ بواسطة مستخدم معين
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('generated_by', $userId);
    }

    /**
     * نطاق للمحتوى المُنشأ في فترة زمنية
     */
    public function scopeInPeriod($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * الحصول على إحصائيات الاستخدام
     */
    public static function getUsageStats($period = 'month')
    {
        $query = self::query();

        switch ($period) {
            case 'day':
                $query->whereDate('created_at', today());
                break;
            case 'week':
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'month':
                $query->whereMonth('created_at', now()->month);
                break;
            case 'year':
                $query->whereYear('created_at', now()->year);
                break;
        }

        return [
            'total_generations' => $query->count(),
            'total_cost' => $query->sum('cost'),
            'average_generation_time' => $query->avg('generation_time'),
            'by_type' => $query->groupBy('type')
                ->selectRaw('type, COUNT(*) as count, SUM(cost) as total_cost')
                ->get(),
        ];
    }

    /**
     * الحصول على التكلفة الإجمالية
     */
    public static function getTotalCost($period = null)
    {
        $query = self::query();

        if ($period) {
            $query->inPeriod($period['start'], $period['end']);
        }

        return $query->sum('cost');
    }

    /**
     * تحديث حالة المحتوى
     */
    public function updateStatus($status)
    {
        $this->update(['status' => $status]);

        // إذا تم تحديث الحالة إلى "active" والنوع هو "article"، قم بنقل المحتوى إلى جدول المقالات
        if ($status === 'active' && $this->type === 'article') {
            $this->moveToBlogs();
        }
    }

    /**
     * نقل المحتوى إلى جدول المقالات
     */
    public function moveToBlogs()
    {
        // التحقق من عدم وجود مقال مرتبط بالفعل
        if ($this->target_model === 'Blog' && $this->target_id) {
            return \App\Models\Blog::find($this->target_id);
        }

        // إنشاء slug من العنوان
        $slug_en = \Illuminate\Support\Str::slug($this->title ?: 'ai-generated-article');
        // Keep Arabic text as is, only replace spaces and special characters
        $arabic_title = $this->title ?: 'مقال-مولد-بالذكاء-الاصطناعي';
        $slug_ar = str_replace([' ', '/', '\\', '?', '#', '[', ']', '@', '!', '$', '&', "'", '(', ')', '*', '+', ',', ';', '=', '%'], '-', $arabic_title);
        $slug_ar = preg_replace('/-+/', '-', $slug_ar); // Remove multiple dashes
        $slug_ar = trim($slug_ar, '-'); // Remove leading/trailing dashes

        // إنشاء مقال جديد
        $blog = \App\Models\Blog::create([
            'name_en' => $this->title ?: 'AI Generated Article',
            'name_ar' => $this->title ?: 'مقال مولد بالذكاء الاصطناعي',
            'short_desc_en' => $this->meta_description ?: \Illuminate\Support\Str::limit(strip_tags($this->content), 160),
            'short_desc_ar' => $this->meta_description ?: \Illuminate\Support\Str::limit(strip_tags($this->content), 160),
            'long_desc_en' => $this->content,
            'long_desc_ar' => $this->content,
            'meta_title_en' => $this->title ?: 'AI Generated Article',
            'meta_title_ar' => $this->title ?: 'مقال مولد بالذكاء الاصطناعي',
            'meta_desc_en' => $this->meta_description ?: \Illuminate\Support\Str::limit(strip_tags($this->content), 160),
            'meta_desc_ar' => $this->meta_description ?: \Illuminate\Support\Str::limit(strip_tags($this->content), 160),
            'slug_en' => $this->ensureUniqueSlug($slug_en, 'en'),
            'slug_ar' => $this->ensureUniqueSlug($slug_ar, 'ar'),
            'status' => true,
            'show_in_home' => false,
            'show_in_header' => false,
            'show_in_footer' => false,
            'index' => true,
            'date' => now()->format('Y-m-d'),
            'order' => 0,
        ]);

        // ربط المحتوى المولد بالمقال
        $this->update([
            'target_model' => 'Blog',
            'target_id' => $blog->id
        ]);

        return $blog;
    }

    /**
     * التأكد من أن السلج فريد
     */
    private function ensureUniqueSlug($slug, $language)
    {
        $originalSlug = $slug;
        $counter = 1;

        while (\App\Models\Blog::where("slug_{$language}", $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * الحصول على المحتوى المختصر
     */
    public function getExcerptAttribute()
    {
        return \Illuminate\Support\Str::limit(strip_tags($this->content), 200);
    }

    /**
     * الحصول على عدد الكلمات
     */
    public function getCalculatedWordCountAttribute()
    {
        if ($this->attributes['word_count']) {
            return $this->attributes['word_count'];
        }

        return str_word_count(strip_tags($this->content));
    }

    /**
     * الحصول على التكلفة المنسقة
     */
    public function getFormattedCostAttribute()
    {
        return number_format($this->cost, 4) . ' $';
    }

    /**
     * الحصول على وقت التوليد المنسق
     */
    public function getFormattedGenerationTimeAttribute()
    {
        if (!$this->generation_time) {
            return 'غير محدد';
        }

        return $this->generation_time->diffForHumans();
    }
}