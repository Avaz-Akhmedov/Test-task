<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Product extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'price',
        'slug',
        'attributes'
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }


    public function scopeFilterByPrice(Builder $query, $priceFrom, $priceTo)
    {
        $query
            ->when($priceFrom, function (Builder $query) use ($priceFrom) {
                $query->where('price', '>=', $priceFrom);
            })
            ->when($priceTo, function (Builder $query) use ($priceTo) {
                $query->where('price', '<=', $priceTo);
            });
    }

    public function scopeFilterByCategory(Builder $query, $categories)
    {
        $query->when($categories, function (Builder $query) use ($categories) {
            $query->whereIn('category_id', $categories);
        });
    }

    public function attributes(): Attribute
    {
        return new Attribute(fn($value) => json_decode($value));
    }
}
