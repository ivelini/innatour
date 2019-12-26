<?php

namespace App\Observers;

use App\Models\Tour;

class TourObserver
{
    /**
     * Handle the tour "created" event.
     *
     * @param  \App\Models\Tour  $tour
     * @return void
     */
    public function created(Tour $tour)
    {
//        dd(__METHOD__,$tour);
    }

    /**
     * Handle the tour "updated" event.
     *
     * @param  \App\Models\Tour  $tour
     * @return void
     */
    public function updated(Tour $tour)
    {
        //
    }

    /**
     * Handle the tour "deleted" event.
     *
     * @param  \App\Models\Tour  $tour
     * @return void
     */
    public function deleted(Tour $tour)
    {
        //
    }

    /**
     * Handle the tour "restored" event.
     *
     * @param  \App\Models\Tour  $tour
     * @return void
     */
    public function restored(Tour $tour)
    {
        //
    }

    /**
     * Handle the tour "force deleted" event.
     *
     * @param  \App\Models\Tour  $tour
     * @return void
     */
    public function forceDeleted(Tour $tour)
    {
        //
    }
}
