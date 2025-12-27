<?php

namespace App\Models;

use App\Enums\AnnouncementCategory;
use App\Enums\AnnouncementPriority;
use App\Enums\AnnouncementTargetAudience;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'content',
        'category',
        'priority',
        'target_audience',
        'author_id',
    ];

    protected function casts(): array
    {
        return [
            'category' => AnnouncementCategory::class,
            'priority' => AnnouncementPriority::class,
            'target_audience' => AnnouncementTargetAudience::class,
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
