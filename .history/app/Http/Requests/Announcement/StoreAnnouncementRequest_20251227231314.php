<?php

namespace App\Http\Requests\Announcement;

use App\Enums\AnnouncementCategory;
use App\Enums\AnnouncementPriority;
use App\Enums\AnnouncementTargetAudience;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreAnnouncementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'category' => ['required', new Enum(AnnouncementCategory::class)],
            'priority' => ['required', new Enum(AnnouncementPriority::class)],
            'target_audience' => ['required', new Enum(AnnouncementTargetAudience::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Başlık gerekli.',
            'title.max' => 'Başlık en fazla 255 karakter olabilir.',
            'content.required' => 'İçerik gerekli.',
            'category.required' => 'Kategori gerekli.',
            'priority.required' => 'Öncelik gerekli.',
            'target_audience.required' => 'Hedef kitle gerekli.',
        ];
    }
}
