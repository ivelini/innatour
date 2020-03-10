@extends('frontend.layouts.main')
@section('head-component')
	<title>{{ $category->title }}</title>
	<meta name="description" content="{{ \Illuminate\Support\Str::limit($category->description, 200) }}" />
	<meta name="keywords" content="{{ $category->title }}" />
@endsection
@section('main-content')
		<div class="slick-item">

			<div class="image-bg" style="background-image:url('{{ asset('/storage/') }}{{ !empty($category->gallery->first()->path) ? '/' .$category->gallery->first()->path : '' }}');">
				<div class="container">

					<div class="row">

						<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">

							<div class="slick-hero-slider-caption">
								<h2 class="animation fromBottom transitionDelay2 transitionDuration4">{{ $category->title }}</h2>
								<p class="animation fromBottom transitionDelay4 transitionDuration6">@if (!empty($category->description_img)) {{ $category->description_img }} @else <span style="opacity: 0;">0</span> @endif</p>

							</div>

						</div>

					</div>

				</div>


			</div>

		</div>
	<div class="two-tone-layout left-sidebar">

		<div class="equal-content-sidebar">

			<div class="container">

				<div class="content-wrapper">

					<div class="mb-10"></div>

					@if ($childCats->count() > 0)
						<div class="top-hotel-grid-wrapper">
							<div class="row gap-20 min-height-alt">
								@foreach($childCats as $catItem)
									@if ($catItem->children->count() > 0 || $catItem->tours->count() > 0)
										<div class="col-xss-12 col-xs-12 col-sm-6 col-mdd-6 col-md-4" data-match-height="result-grid">
											<div class="hotel-item-grid">
												<a href="{{ route('category.indexCurrentCategory', $catItem->slug) }}">
													<div class="image">
														@if(!empty($catItem->gallery->first()->path))
															<img src="{{ asset('/storage/') }}{{ !empty($catItem->gallery->first()->path) ? '/' .$catItem->gallery->first()->path : '' }}">
														@endif
													</div>
													<div class="head" style="padding: 20px">
														<h4>{{ $catItem->title }}</h4>
													</div>
													<div style="padding: 20px">{{ $catItem->description }}</div>
												</a>
											</div>
										</div>
									@endif
								@endforeach
							</div>
						</div>
					@endif

					@if ($tours->count() > 0)

						<div class="top-hotel-grid-wrapper">
								<div class="row gap-20 min-height-alt">
										@foreach($tours as $tour)
											<div class="col-xss-12 col-xs-12 col-sm-6 col-mdd-6 col-md-4" data-match-height="result-grid">
												<div class="hotel-item-grid">
													<a href="{{ route('tour.show', $tour->slug) }}">
														<div class="image">
															@if(!empty($tour->gallery->first()->path))
																<img src="{{ asset('/storage/' .$tour->gallery->first()->path) }}">
															@endif
														</div>
														<div class="heading">
															<h4>{{ $tour->title }}</h4>
															<div style="padding: 20px">{{ $tour->description_cat }}</div>
														</div>

													</a>
														<div class="content">
															<div class="row gap-5">
																<div class="col-xs-6 col-sm-6">
																	<div class="tripadvisor-module">
																		<div class="hover-underline" style="height: 12px"></div>
																		<div class="texting">
																			<a class="alert-link" href="{{ route('tour.show', $tour->slug) }}">Подробнее</a>
																		</div>

																	</div>
																</div>
																<div class="col-xs-6 col-sm-6">
																	<p class="price"><span class="block">Стоимость от</span>@php !empty($tour->sale) ? printf('<del>' .$tour->price. '</del> <span class="number">' .$tour->sale. '</span>') : printf('<span class="number">'.$tour->price.'</span>') @endphp/ тур</p>
																</div>
															</div>
														</div>
												</div>
											</div>
										@endforeach
								</div>
						</div>
					@endif

					<div class="result-paging-wrapper">

						<div class="row">

							<div class="col-sm-6"></div>

							<div class="col-sm-6">
								@if ($paginate['toursCount'] > $paginate['countToursForPage'])
									<ul class="paging">
										@if(!empty($_GET['page']) && $_GET['page'] == 1)
											<li class="disable"><a href="#">&laquo;</a></li>
										@elseif(!empty($_GET['page']) && $_GET['page'] != 1)
											<li><a href="{{ route('category.indexCurrentCategory', $category->slug) }}?page={{ $_GET['page'] - 1 }}">&laquo;</a></li>
										@elseif(empty($_GET['page']))
											<li class="disable"><a href="{{ route('category.indexCurrentCategory', $category->slug) }}">&laquo;</a></li>
										@endif
										@if(empty($_GET['page']))
											@for($i = 1; $i <= $paginate['countPaginate']; $i++)
												<li {{ $i == 1 ? printf('class="active"') : ''}}><a href="{{ route('category.indexCurrentCategory', $category->slug) }}?page={{ $i }}">{{ $i }}</a></li>
											@endfor
										@elseif(!empty($_GET['page']))
											@for($i = 1; $i <= $paginate['countPaginate']; $i++)
												<li {{ $i == $_GET['page'] ? printf('class="active"') : ''}}><a href="{{ route('category.indexCurrentCategory', $category->slug) }}?page={{ $i }}">{{ $i }}</a></li>
											@endfor
										@endif
										@if(!empty($_GET['page']) && $_GET['page'] == $paginate['countPaginate'])
											<li class="disable"><a href="#">&raquo;</a></li>
										@elseif(!empty($_GET['page']) && $_GET['page'] != $paginate['countPaginate'])
											<li><a href="{{ route('category.indexCurrentCategory', $category->slug) }}?page={{ $_GET['page'] + 1 }}">&raquo;</a></li>
										@elseif(empty($_GET['page']))
											<li><a href="{{ route('category.indexCurrentCategory', $category->slug) }}?page=2">&raquo;</a></li>
										@endif
									</ul>
								@endif
							</div>

						</div>

					</div>

					<div class="mb-20"></div>

				</div>

			</div>

		</div>

	</div>

	<div class="clear"></div>

	<div class="clear"></div>
@endsection