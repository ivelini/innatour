<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = "pages";
    protected $fillable = ['nav_name',
        'title',
        'slug',
        'description',
        'location',
        'is_published'];

    public function gallery()
    {
        return $this->hasOne(Gallery::class, 'page_id', 'id');
    }
}
