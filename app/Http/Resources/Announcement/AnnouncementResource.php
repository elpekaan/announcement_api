<?php

namespace App\Http\Resources\Announcement;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnnouncementResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'category' => $this->category->value,
            'priority' => $this->priority->value,
            'target_audience' => $this->target_audience->value,
            'author_id' => $this->author_id,
            'author_name' => $this->author->name,
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
