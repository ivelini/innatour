<?php

namespace App\Repositories;

use App\Models\TourCalendar as Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Date;

class TourCalendarRepository extends CoreRepository
{
    public function getModelClass()
    {
        return Model::class;
    }

    public function getAllDatesForTour($id)
    {
        $dates = $this->startConditions()
            ->select('id', 'tour_id', 'start', 'finish', 'comment')
            ->where('tour_id', $id)
            ->orderBy('start')
            ->get();

        return $dates;
    }

    /**
     *
     */
    public function getCalendarForIndexPage()
    {
        $dates = $this->startConditions()
            ->select('id', 'tour_id', 'start', 'finish', 'comment')
            ->where('start', '>=', Date::now())
            ->orderBy('start')
            ->with(['tour' => function ($query) {
                $query->select('id', 'title', 'price', 'sale', 'scope_id', 'is_published')
                    ->where('is_published', true);
                },
                'tour.categories:id,title'])
            ->get();

        Carbon::setLocale('ru');

        $select_year = 0;
        $select_months = 0;
        foreach ($dates as $date) {

            if(empty($date->tour)) {
                continue;
            }

            $dtStart = Carbon::create($date->start);
            $dtFinish = Carbon::create($date->finish);
            $count_days = $dtStart->diffInDays($dtFinish) + 1;
            $month = $dtStart->monthName;
            $year = $dtStart->year;
            $tour_id = $date->tour_id;
            $tour_title = $date->tour->title;
            $price = $date->tour->price;
            $sale = $date->tour->sale;
            $cat_id = $date->tour->categories->first()->id;
            $cat_title = $date->tour->categories->first()->title;
            $scope_id = $date->tour->scope->id;
            $scope_title = $date->tour->scope->title;
            $rasspisanie = $dtStart->isoFormat('D MMMM'). ' - ' .$dtFinish->isoFormat('D MMMM');
            $comment = $date->comment;

            $calendar[$year][$month][] = [
                'date' => $rasspisanie,
                'tour_id' => $tour_id,
                'tour_title' => $tour_title,
                'price' => $price,
                'sale' => $sale,
                'count_days' => $count_days,
                'cat_id' => $cat_id,
                'cat_title' => $cat_title,
                'scope_id' => $scope_id,
                'scope_title' => $scope_title,
                'comment' => $comment
            ];

            if($select_year != $year) {
                $calendar['years'][] = $year;
                $select_year = $year;
            }

            if($select_months !== $month) {
                $calendar['months'][] = $month;
                $select_months = $month;
            }

        }

        if(empty($calendar)) {
            $calendar = null;
        }

        return $calendar;
    }

    public function getCalendarForTour($id)
    {
        $dates = $this->startConditions()
            ->select('id', 'tour_id', 'start', 'finish')
            ->where('start', '>=', Date::now())
            ->orderBy('start')
            ->with(['tour' => function ($query) use ($id) {
                $query->select('id', 'title', 'price', 'sale', 'scope_id', 'is_published')
                    ->where('id', $id);
            },
                'tour.categories:id,title'])
            ->get();

        Carbon::setLocale('ru');

        $select_year = 0;
        $select_months = 0;
        foreach ($dates as $date) {

            if(empty($date->tour)) {
                continue;
            }

            $dtStart = Carbon::create($date->start);
            $dtFinish = Carbon::create($date->finish);
            $count_days = $dtStart->diffInDays($dtFinish) + 1;
            $month = $dtStart->monthName;
            $year = $dtStart->year;
            $tour_id = $date->tour_id;
            $tour_title = $date->tour->title;
            $price = $date->tour->price;
            $sale = $date->tour->sale;
            $cat_id = $date->tour->categories->first()->id;
            $cat_title = $date->tour->categories->first()->title;
            $scope_id = $date->tour->scope->id;
            $scope_title = $date->tour->scope->title;
            $rasspisanie = $dtStart->isoFormat('D MMMM'). ' - ' .$dtFinish->isoFormat('D MMMM');

            $calendar[$year][$month][] = [
                'date' => $rasspisanie,
                'tour_id' => $tour_id,
                'tour_title' => $tour_title,
                'price' => $price,
                'sale' => $sale,
                'count_days' => $count_days,
                'cat_id' => $cat_id,
                'cat_title' => $cat_title,
                'scope_id' => $scope_id,
                'scope_title' => $scope_title
            ];

            if($select_year != $year) {
                $calendar['years'][] = $year;
                $select_year = $year;
            }

            if($select_months !== $month) {
                $calendar['months'][] = $month;
                $select_months = $month;
            }

        }

        if(empty($calendar)) {
            $calendar = null;
        }

        return $calendar;
    }
}
