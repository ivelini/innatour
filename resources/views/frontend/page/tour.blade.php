@extends('frontend.layouts.main')
@section('head-component')
	<title>{{ $tour->title }}</title>
	<meta name="description" content="{{ $tour->head_description }}" />
	<meta name="keywords" content="{{ $tour->title }}" />
	<link rel="stylesheet" type="text/css" href="/frontend/slick/slick.css"/>
	<link rel="stylesheet" type="text/css" href="/frontend/slick/slick-theme.css"/>
	<link rel="stylesheet" type="text/css" href="/frontend/fancybox/jquery.fancybox.css">
@endsection
@section('main-content')
<div class="equal-content-sidebar-wrapper">

	<div class="equal-content-sidebar-by-js right-sidebar">

		<div class="container">

			<div class="sidebar-wrapper">

				<aside>

					<div class="mb-10"></div>

					<div class="section-title">
						<h3><span>Информация</span></h3>
					</div>

					<ul class="sidebar-cat clearfix mb-30 mmt">
						<li><a href="#">Стоимость <span class="absolute">@php !empty($tour->sale) ? printf('<del>' .$tour->price. '</del> <span style="font-weight: 500; font-size: 21px; color: #005294; font-family: Roboto;">' .$tour->sale. '</span>') : printf('<span style="font-weight: 500; font-size: 21px; color: #005294; font-family: Roboto;">'.$tour->price.'</span>') @endphp</span></a></li>
						@if(!empty($tour->file_name))
							<li><a href="{{ asset('storage/' .$tour->file_path) }}"><span style="font-weight: 500; font-size: 16px; color: #005294; font-family: Roboto;">{{ $tour->file_name }}</span></a></li>
						@endif
					</ul>

				</aside>
				<aside>
					<div class="section-title">
						<h3><span>Расписание</span></h3>
					</div>
					<table class="table table-hover table-sm table-bordered">
						<tbody>
							@if(!empty($dates['years']))
								@foreach($dates['years'] as $year)
									@foreach($dates['months'] as $month)
										@if(!empty($dates[$year][$month]))
											<tr>
												<td style="text-align:center; font-weight: bold">{{ $month }}, {{ $year }}</td>
											</tr>
											@foreach($dates[$year][$month] as $date)
												<tr>
													<td scope="row">{{ $date['date'] }}</td>
												</tr>
											@endforeach
										@endif
									@endforeach
								@endforeach
							@endif
						<tbody>
					</table>
				</aside>
				<aside>
					<div class="section-title">
						<h3><span>Забронировать</span></h3>
					</div>
					<form class="contact-form" method="POST" action="{{ route('tour.show.sendMessage', $tour->id) }}">
						@csrf

						@include('admin.layouts.message')

						<div class="row">

							<div class="col-sm-12">

								<div class="form-group mb-25">
									<input type="text"
										   class="form-control"
										   placeholder="Ваше имя *"
										   name="clientName"
											value="{{ old('clientName') }}">
								</div>

								<div class="form-group mb-25">
									<input id="clientPhone"
										   type="text"
										   class="form-control"
										   placeholder="Ваш номер телефона *"
										   name="clientPhone">
								</div>

								<div class="form-group mb-25">
									<input type="email"
										   class="form-control"
										   placeholder="Ваше почта"
										   name="clientEmail"
										   value="{{ old('clientEmail') }}">
								</div>

								<div class="form-group">
									<textarea class="form-control"
											  rows="5"
											  placeholder="Сообщение *"
											  name="clientMessage"></textarea>
								</div>

							</div>

						</div>

						<div class="clear"></div>

						<div class="pull-right">
							<input type="submit" class="btn btn-danger" value="Отправить">
						</div>

					</form>

					<div class="clear"></div>

				</aside>

			</div>

			<div class="content-wrapper">

				<div class="mb-10"></div>

				<div class="blog-wrapper blog-single">

					<article class="blog-item-full">
						@if($tour->gallery->count() > 0)
							<div class="image">
									<img src="{{ asset('/storage/' .$tour->gallery->filter(function ($value) {return $value['is_header'] == true;})->first()->path) }}" />
							</div>
						@endif
						<div class="content">
							<div class="center slider">
								@foreach($tour->gallery->filter(function ($value) {return $value['is_header'] == false;}) as $img)
									<div>
										<div class="h3">
											<a href="{{ asset('/storage/' .$img->path) }}" data-fancybox>
												<img src="{{ asset('/storage/' .$img->path) }}" />
											</a>
										</div>
									</div>
								@endforeach
							</div>
							<div class="tag-cloud-wrapper clearfix mb-40">
								<div class="tag-cloud-heading">Категории: </div>
								<div class="tag-cloud tags clearfix">
									@foreach($tour->categories as $category)
										<a href="{{ route('category.indexCurrentCategory', $category->id) }}">{{ $category->title }}</a>
									@endforeach
								</div>
							</div>
							<h3 class="blog-title">{{ $tour->title }}</h3>

							<div class="blog-entry">
								{!! $tour->description !!}
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