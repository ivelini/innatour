<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    protected $table = "tours";
    protected $fillable = ['user_id',
        'title',
        'slug',
        'description',
        'price',
        'sale',
        'file_path',
        'file_name',
        'scope_id',
        'description_cat',
        'is_published'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_tour',
            'tour_id', 'category_id');
    }

    public function gallery()
    {
        return $this->hasMany(Gallery::class, 'tour_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function calendar()
    {
        return $this->hasMany(TourCalendar::class, 'tour_id', 'id');
    }

    public function scope()
    {
        return $this->belongsTo(Scope::class, 'scope_id', 'id');
    }
}