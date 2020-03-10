@extends('frontend.layouts.main')
@section('head-component')
    <title>{{ $page->title }}</title>
    <meta name="description" content="{{ \Illuminate\Support\Str::limit($page->description, 200) }}" />
    <meta name="keywords" content="{{ $page->title }}" />
    <link rel="stylesheet" type="text/css" href="/frontend/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="/frontend/slick/slick-theme.css"/>
    <link rel="stylesheet" type="text/css" href="/frontend/fancybox/jquery.fancybox.css">
@endsection
@section('main-content')
    <div class="equal-content-sidebar-wrapper">

        <div class="equal-content-sidebar-by-js right-sidebar">

            <div class="container">

                <div style="background-color: white; padding: 20px 40px;">

                    <div class="mb-10"></div>

                    <div class="blog-wrapper blog-single">

                        <article class="blog-item-full">
                            @if($page->gallery->count() > 0)
                                <div class="image">
                                    <img src="{{ asset('/storage/' .$page->gallery->path) }}" />
                                </div>
                            @endif
                            <div class="content">
                                <h3 class="blog-title">{{ $page->title }}</h3>

                                <div class="top-hotel-grid-wrapper">
                                    <div class="GridLex-gap-20-wrapper">
                                        <div class="table-calendar">
                                            <table class="table table-hover table-sm table-bordered">
                                                <thead>
                                                <tr class="bg-primary">
                                                    <th scope="col">Дата</th>
                                                    <th scope="col">Название</th>
                                                    <th scope="col">Категория</th>
                                                    <th scope="col">Направление</th>
                                                    <th scope="col">Дней</th>
                                                    <th scope="col">Цена</th>
                                                    <th scope="col">Кол-во мест</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if(!empty($dates['years']))
                                                    @foreach($dates['years'] as $year)
                                                        @foreach($dates['months'] as $month)
                                                            @if(!empty($dates[$year][$month]))
                                                                <tr>
                                                                    <td colspan="6" style="text-align:center; font-weight: bold">{{ $month }}, {{ $year }}</td>
                                                                </tr>
                                                                @foreach($dates[$year][$month] as $date)
                                                                    <tr>
                                                                        <th scope="row">{{ $date['date'] }}</th>
                                                                        <td><a class="link-info" href="{{ route('tour.show', $date['tour_slug']) }}">{{ $date['tour_title'] }}</a></td>
                                                                        <td><a href="{{ route('category.indexCurrentCategory', $date['cat_slug']) }}">{{ $date['cat_title'] }}</td></td>
                                                                        <td>
                                                                            @if($date['scope_id'] > 0)
                                                                                <a href="{{ route('scope.indexCurrentScope', $date['scope_slug']) }}">{{ $date['scope_title'] }}
                                                                            @endif
                                                                        </td>
                                                                        <td>{{ $date['count_days'] }}</td>
                                                                        <td>@php !empty($date['sale']) ? printf('<del>' .$date['price']. '</del> <span class="badge badge-danger">' .$date['sale']. '</span>') : printf($date['price']) @endphp</td>
                                                                        <td>@php !empty($date['comment']) ? printf($date['comment']) : printf('') @endphp</td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>

                                </div>

                                <div class="clear mb-40"></div>

                            </div>

                        </article>

                    </div>

                    <div class="clear"></div>

                </div>

        </div>

    </div>
    <div class="clear"></div>
@endsection
@section('js-component')
    <script type="text/javascript" src="/frontend/slick/slick.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.center').slick({
                centerMode: true,
                centerPadding: '190px',
                slidesToShow: 3,
                responsive: [
                    {
                        breakpoint: 768,
                        settings: {
                            arrows: false,
                            centerMode: true,
                            centerPadding: '40px',
                            slidesToShow: 3
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            arrows: false,
                            centerMode: true,
                            centerPadding: '40px',
                            slidesToShow: 1
                        }
                    }
                ]
            });
        });
    </script>
    <script src="/frontend/fancybox/jquery.fancybox.js"></script>
    <script src="/frontend/js/jquery.maskedinput.min.js"></script>
    <script>
        $(function(){
            $("#clientPhone").mask("8(999) 999-99-99");
        });
    </script>
@endsection