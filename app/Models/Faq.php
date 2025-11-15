<?php

namespace App\Models;

use App\Traits\HasJsonTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory, HasJsonTranslations;
    protected $table = 'faqs';

    protected $fillable = [
        'faqable_id',
        'faqable_type',
        'status',
        'order',
        'question_en',
        'question_ar',
        'answer_en',
        'answer_ar',
    ];
    public function faqable()
    {
        return $this->morphTo();
    }

    public function getQuestionAttribute()
    {
        $locale = app()->getLocale();
        return $this->{'question_' . $locale} ?? $this->question_ar ?? $this->question_en;
    }

    public function getAnswerAttribute()
    {
        $locale = app()->getLocale();
        return $this->{'answer_' . $locale} ?? $this->answer_ar ?? $this->answer_en;
    }

    public static function getTypeSelect()
    {
        return [
            null          => __('website.general'),
            'technical_issue'   => __('website.technical_issue'),
            'domains' => __('website.domains'),
            'hostings'   => __('website.hostings'),
            'help_support' => __('website.help_support'),
        ];
    }


    public function getTypeNameAttribute()
    {
        return $this->faqable_type ? $this->faqable_type : __('dashboard.general');
    }
    public function getTypeAttribute()
    {
        return $this->faqable_type ? $this->faqable_type : __('dashboard.general');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeGeneral($query)
    {
        return $query->where('faqable_type', null);
    }
    public function scopeHostings($query)
    {
        return $query->where('faqable_type', 'hostings');
    }
    public function scopeTechnicalIssue($query)
    {
        return $query->where('faqable_type', 'technical_issue');
    }
    public function scopeDomains($query)
    {
        return $query->where('faqable_type', 'domains');
    }
    public function scopeSupport($query)
    {
        return $query->where('faqable_type', 'help_support');
    }
}
