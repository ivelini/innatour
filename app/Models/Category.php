<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "categories";
    protected $fillable = ['parent_id', 'user_id', 'title', 'slug', 'description', 'description_img'];

    public function tours()
    {
        return $this->belongsToMany(Tour::class, 'category_tour',
            'category_id', 'tour_id');
    }

    public function gallery()
    {
        return $this->hasMany(Gallery::class, 'category_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

}
