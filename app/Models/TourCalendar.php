<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourCalendar extends Model
{
    protected $table = 'tour_calendar';
    protected $fillable = ['tour_id', 'start', 'finish', 'comment'];

    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tour_id', 'id');
    }
}
