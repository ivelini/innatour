<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scope extends Model
{
    protected $table = "scopes";
    protected $fillable = ['title', 'slug'];

    public function tours()
    {
        return $this->hasMany(Tour::class, 'scope_id', 'id');
    }
}
