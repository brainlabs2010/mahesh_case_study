<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, Sluggable, SoftDeletes;

    protected $fillable = ['name', 'category_id', 'price', 'description', 'product_image'];

    protected $casts = ['price' => 'int'];

    public function sluggable(): array
    {
        return [
            'slug' => ['source' => 'name'],
        ];
    }

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the price
     *
     * @return Attribute
     */
    public function price(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value / 100,
            set: fn($value) => $value * 100
        );
    }

    /**
     * Get the image path for file
     *
     * @return Attribute
     */
    public function productImage(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return asset(Storage::url($value)) ?? null;
            }
        );
    }
}
