<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Product extends Model
{
    use HasSlug;

    protected $fillable = ['name', 'description', 'body', 'price', 'slug'];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    // Slug manual

    // public function getThumbAttribute()
    // {
    //     return $this->photos->first()->image;
    // }

    // public function setNameAttribute($value)
    // {
    //     $this->attributes['name'] = $value;
    //     $this->attributes['slug'] = $this->uniqueSlug($value);
    // }

    // public function uniqueSlug($name)
    // {
    //     $slug = Str::slug($name);
    //     $slugCount = count($this->whereRaw("slug REGEXP '^{$slug}(-[0-9]*)?$'")->get());
    //     return ($slugCount > 0) ? "{$slug}-{$slugCount}" : $slug;
    // }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function photos()
    {
        return $this->hasMany(ProductPhoto::class);
    }
}
