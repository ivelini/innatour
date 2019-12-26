@extends('frontend.layouts.main')
@section('head-component')
	<title>{{ $scope->title }}</title>
	<meta name="description" content="{{ $scope->title }}" />
	<meta name="keywords" content="{{ $scope->title }}" />
@endsection
@section('main-content')
	<div class="two-tone-layout left-sidebar">

		<div class="equal-content-sidebar">

			<div class="container">

				<div class="content-wrapper">

					<div class="mb-10"></div>

					<div class="top-hotel-grid-wrapper">

						<div class="row gap-20 min-height-alt">

							@foreach($tours as $tour)
								<div class="col-xss-12 col-xs-12 col-sm-6 col-mdd-6 col-md-4" data-match-height="result-grid">
									<div class="hotel-item-grid">
										<a href="{{ route('tour.show', $tour->id) }}">
											<div class="image">
												<img src="{{ asset('/storage/' .$tour->gallery->first()->path) }}">
											</div>
											<div class="heading">
												<h4>{{ $tour->title }}</h4>
											</div>
										</a>
											<div class="content">
												<div class="row gap-5">
													<div class="col-xs-6 col-sm-6">
														<div class="tripadvisor-module">
															<div class="hover-underline" style="height: 12px"></div>
															<div class="texting">
																<a class="alert-link" href="{{ route('tour.show', $tour->id) }}">Подробнее</a>
															</div>

														</div>
													</div>
													<div class="col-xs-6 col-sm-6">
														<p class="price"><span class="block">Стоимость</span><span class="number">{{ $tour->price }}</span> / тур</p>
													</div>
												</div>
											</div>
									</div>
								</div>
							@endforeach
						</div>

					</div>

					<div class="result-paging-wrapper">

						<div class="row">

							<div class="col-sm-6"></div>

							<div class="col-sm-6">
								@if ($paginate['toursCount'] > $paginate['countToursForPage'])
									<ul class="paging">
										@if(!empty($_GET['page']) && $_GET['page'] == 1)
											<li class="disable"><a href="#">&laquo;</a></li>
										@elseif(!empty($_GET['page']) && $_GET['page'] != 1)
											<li><a href="{{ route('category.indexCurrentCategory', $category->id) }}?page={{ $_GET['page'] - 1 }}">&laquo;</a></li>
										@elseif(empty($_GET['page']))
											<li class="disable"><a href="{{ route('category.indexCurrentCategory', $category->id) }}">&laquo;</a></li>
										@endif
										@if(empty($_GET['page']))
											@for($i = 1; $i <= $paginate['countPaginate']; $i++)
												<li {{ $i == 1 ? printf('class="active"') : ''}}><a href="{{ route('category.indexCurrentCategory', $category->id) }}?page={{ $i }}">{{ $i }}</a></li>
											@endfor
										@elseif(!empty($_GET['page']))
											@for($i = 1; $i <= $paginate['countPaginate']; $i++)
												<li {{ $i == $_GET['page'] ? printf('class="active"') : ''}}><a href="{{ route('category.indexCurrentCategory', $category->id) }}?page={{ $i }}">{{ $i }}</a></li>
											@endfor
										@endif
										@if(!empty($_GET['page']) && $_GET['page'] == $paginate['countPaginate'])
											<li class="disable"><a href="#">&raquo;</a></li>
										@elseif(!empty($_GET['page']) && $_GET['page'] != $paginate['countPaginate'])
											<li><a href="{{ route('category.indexCurrentCategory', $category->id) }}?page={{ $_GET['page'] + 1 }}">&raquo;</a></li>
										@elseif(empty($_GET['page']))
											<li><a href="{{ route('category.indexCurrentCategory', $category->id) }}?page=2">&raquo;</a></li>
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