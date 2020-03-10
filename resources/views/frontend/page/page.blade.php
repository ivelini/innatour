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

                <div class="content-wrapper">

                    <div class="mb-10"></div>

                    <div class="blog-wrapper blog-single">

                        <article class="blog-item-full">
                            @if($page->gallery->count() > 0)
                                <div class="image">
                                    <img src="{{ asset('/storage/' .$page->gallery->path) }}" />
                                </div>
                            @endif
                            <div class="content">
                                <h1 class="blog-title">{{ $page->title }}</h1>

                                <div class="blog-entry">
                                    {!! $page->description !!}
                                </div>

                                <div class="clear mb-40"></div>

                            </div>

                        </article>

                    </div>

                    <div class="clear"></div>

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