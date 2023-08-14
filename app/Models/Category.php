<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'slug', 'image', 'meta_description', 'meta_title', 'type'];


    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
