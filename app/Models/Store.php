<?php

namespace App\Models;

use App\Notifications\StoreReceiveNewOrder;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Store extends Model
{
    use HasSlug;

    protected $fillable = ['name', 'description', 'phone', 'mobile_phone', 'slug', 'logo'];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    public function notifyStoreOwners(array $storeIds = [], Order $order)
    {
        $stores = $this->whereIn('id', $storeIds)->get();

        $stores->map(function ($store) {
            return $store->user;
        })->each->notify(new StoreReceiveNewOrder($order));
    }
}
