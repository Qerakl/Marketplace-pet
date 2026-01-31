<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Преобразует товар в массив.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->when($this->relationLoaded('images'), $this->description),
            'price' => $this->price,
            'formatted_price' => $this->formatted_price,
            'old_price' => $this->old_price,
            'formatted_old_price' => $this->formatted_old_price,
            'has_discount' => $this->has_discount,
            'location' => $this->location,
            'status' => $this->status,
            'rating' => $this->rating,
            'views_count' => $this->views_count,
            'reviews_count' => $this->whenCounted('reviews'),
            'url' => $this->url,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'user' => new UserResource($this->whenLoaded('user')),
            'main_image' => new ProductImageResource($this->whenLoaded('mainImage')),
            'images' => ProductImageResource::collection($this->whenLoaded('images')),
            'reviews' => ReviewResource::collection($this->whenLoaded('reviews')),
            'created_at' => $this->created_at?->format('d.m.Y'),
        ];
    }
}
