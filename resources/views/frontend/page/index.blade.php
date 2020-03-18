@extends('frontend.layouts.main')
@section('head-component')
	<title>Иннатур</title>
	<meta name="description" content="Иннатур - туристическое агенство, Чеябинск" />
	<meta name="keywords" content="Иннатур - туристическое агенство, Чеябинск" />
@endsection
@section('main-content')
	<div class="slick-hero-slider-wrapper">

		<div class="slider slick-hero-slider slick-slider-center-mode slick-animation slick-inner-dot alt-dot-position">

			@if($caruselItems->count() > 0)
				@foreach($caruselItems as $item)
					<div class="slick-item">

						<div class="image-bg" style="background-image:url('{{ asset('/storage/' .$item->path) }}');">

							<div class="container">

								<div class="row">

									<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">

										<div class="slick-hero-slider-caption">
											<h2 class="animation fromBottom transitionDelay2 transitionDuration4">{{ $item->title }}</h2>
											<p class="animation fromBottom transitionDelay4 transitionDuration6">{{ $item->description }}</p>
											@if(!empty($item->link))
												<a href="{{ $item->link }}" class="animation fromBottom transitionDelay6 transitionDuration8"><span class="bg-primary">Подробнее</span></a>
											@endif
										</div>

									</div>

								</div>

							</div>

						</div>

					</div>
				@endforeach
			@endif

		</div>

	</div>

	@if(!empty($tourSearchForm))
		<div class="main-search-wrapper-2 absolute-in-hero-slider">
			<div class="container">
				{!! $tourSearchForm !!}
			</div>
		</div>
	@endif

	<div class="clear"></div>

	@if(!empty($categories))
		<div class="pt-50 pb-60">

			<div class="container">

				<div class="row">

					<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">

						<div class="section-title">
							<h2>Направления по категориям</h2>
						</div>

					</div>

				</div>

				<div class="top-hotel-grid-wrapper">

					<div class="GridLex-gap-20-wrapper">

						<div class="GridLex-grid-noGutter-equalHeight GridLex-grid-center">

								@foreach($categories as $category)
										<div class="GridLex-col-3_sm-4_xs-6_xss-12 mb-20">

											<div class="hotel-item-grid alt-no-rating">
												<a href="{{ route('category.indexCurrentCategory', $category->slug) }}">
													<div class="image">
														<img src="{{ asset('/storage/') }}{{ !empty($category->gallery->first()->path) ? '/' .$category->gallery->first()->path : '' }}">
													</div>
													<div class="heading">
															<div class="class-h4">{{ $category->title }}</div>
													</div>

												</a>
											</div>

										</div>
								@endforeach

						</div>

					</div>

				</div>

			</div>

		</div>

		<div class="clear"></div>
	@endif

	<div class="post-hero">

		<div class="container mb-5">

			<div class="row">
				<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
					<div class="section-title">
						<h2>Расписание туров</h2>
					</div>
				</div>
			</div>

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

		</div>

	</div>
	<div class="clear"></div>
@endsection