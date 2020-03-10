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
															<h4>{{ $category->title }}</h4>
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
													<td><a class="link-info" href="{{ route('tour.show', $date['tour_id']) }}">{{ $date['tour_title'] }}</a></td>
													<td><a href="{{ route('category.indexCurrentCategory', $date['cat_id']) }}">{{ $date['cat_title'] }}</td></td>
													<td>
														@if($date['scope_id'] > 0)
															<a href="{{ route('scope.indexCurrentScope', $date['scope_id']) }}">{{ $date['scope_title'] }}
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

{{--	<div class="overflow-hidden">--}}

{{--		<div class="GridLex-grid-noGutter-equalHeight">--}}

{{--			<div class="GridLex-col-6_sm-6_xs-12_xss-12 bg-primary">--}}

{{--				<div class="sell-or-buy">--}}

{{--					<div class="icon">--}}
{{--						<i class="et-line-briefcase"></i>--}}
{{--					</div>--}}

{{--					<div class="clear"></div>--}}

{{--					<div class="content">--}}

{{--						<h3 class="uppercase">Traveller</h3>--}}

{{--						<p>Denote simple fat denied add worthy little use. As some he so high down am week. Conduct esteems by cottage to pasture we winding. On assistance he cultivated considered frequently. </p>--}}

{{--						<a href="#">Sign-up</a>--}}

{{--					</div>--}}

{{--				</div>--}}

{{--			</div>--}}

{{--			<div class="GridLex-col-6_sm-6_xs-12_xss-12 bg-warning">--}}

{{--				<div class="sell-or-buy">--}}

{{--					<div class="icon">--}}
{{--						<i class="et-line-map"></i>--}}
{{--					</div>--}}

{{--					<div class="clear"></div>--}}

{{--					<div class="content">--}}

{{--						<h3 class="uppercase">Property Owner</h3>--}}

{{--						<p>Pasture he invited mr company shyness. But when shot real her. Chamber her observe visited removal six sending himself boy. At exquisite existence if an oh dependent excellent.</p>--}}

{{--						<a href="#">Become a host</a>--}}

{{--					</div>--}}

{{--				</div>--}}

{{--			</div>--}}

{{--		</div>--}}

{{--	</div>--}}

{{--	<div class="clear"></div>--}}

{{--	<div class="container pt-50 pb-50">--}}

{{--		<div class="container">--}}

{{--			<div class="row">--}}

{{--				<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">--}}

{{--					<div class="section-title">--}}
{{--						<h2>Отзывы наших туристов</h2>--}}
{{--					</div>--}}

{{--				</div>--}}

{{--			</div>--}}

{{--			<div class="row">--}}

{{--				<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">--}}

{{--					<div class="slick-gallery-slideshow slick-testimonial-wrapper">--}}

{{--						<div class="slider gallery-slideshow slick-testimonial">--}}

{{--							<div class="slick-item">--}}

{{--								<div class="testimonial-long">--}}

{{--									<p class="saying">--}}
{{--										If we landlord stanhill mr whatever pleasure supplied concerns so. Exquisite by it admitting cordially september newspaper an. Acceptance middletons am it favourable. It it oh happen lovers afraid.--}}
{{--									</p>--}}

{{--									<h4 class="uppercase text-primary">Frank Abagnale</h4>--}}
{{--									<p class="he">New York, USA</p>--}}

{{--								</div>--}}

{{--							</div>--}}

{{--							<div class="slick-item">--}}

{{--								<div class="testimonial-long">--}}

{{--									<p class="saying">--}}
{{--										Sympathize did now preference unpleasing mrs few. Mrs for hour game room want are fond dare. For detract charmed add talking age.--}}
{{--									</p>--}}

{{--									<h4 class="uppercase text-primary">Charles Ponzi</h4>--}}
{{--									<p class="he">Rome, Italy</p>--}}

{{--								</div>--}}

{{--							</div>--}}

{{--							<div class="slick-item">--}}

{{--								<div class="testimonial-long">--}}

{{--									<p class="saying">--}}
{{--										Who connection imprudence middletons too but increasing celebrated principles joy. Herself too improve gay winding ask expense are compact.--}}
{{--									</p>--}}

{{--									<h4 class="uppercase text-primary">Joseph Weil</h4>--}}
{{--									<p class="he">Berlin, German</p>--}}

{{--								</div>--}}

{{--							</div>--}}

{{--							<div class="slick-item">--}}

{{--								<div class="testimonial-long">--}}

{{--									<p class="saying">--}}
{{--										Dashwood contempt on mr unlocked resolved provided of of. Stanhill wondered it it welcomed oh. Hundred no prudent he however smiling at an offence.--}}
{{--									</p>--}}

{{--									<h4 class="uppercase text-primary">Victor Lustig</h4>--}}
{{--									<p class="he">Paris, France</p>--}}

{{--								</div>--}}

{{--							</div>--}}

{{--							<div class="slick-item">--}}

{{--								<div class="testimonial-long">--}}

{{--									<p class="saying">--}}
{{--										Preference imprudence contrasted to remarkably in on. Taken now you him trees tears any. Her object giving end sister except oppose.--}}
{{--									</p>--}}

{{--									<h4 class="uppercase text-primary">George Parker</h4>--}}
{{--									<p class="he">New York, USA</p>--}}

{{--								</div>--}}

{{--							</div>--}}

{{--							<div class="slick-item">--}}

{{--								<div class="testimonial-long">--}}

{{--									<p class="saying">--}}
{{--										Simplicity end themselves increasing led day sympathize yet. General windows effects not are drawing man garrets. Common indeed garden you his ladies out yet.--}}
{{--									</p>--}}

{{--									<h4 class="uppercase text-primary">Soapy Smith</h4>--}}
{{--									<p class="he">Alaska, USA</p>--}}

{{--								</div>--}}

{{--							</div>--}}

{{--							<div class="slick-item">--}}

{{--								<div class="testimonial-long">--}}

{{--									<p class="saying">--}}
{{--										Ladyship it daughter securing procured or am moreover mr. Put sir she exercise vicinity cheerful wondered. Continual say suspicion provision you neglected sir curiosity unwilling.--}}
{{--									</p>--}}

{{--									<h4 class="uppercase text-primary">Eduardo de Valfierno</h4>--}}
{{--									<p class="he">Berlin, German</p>--}}

{{--								</div>--}}

{{--							</div>--}}

{{--							<div class="slick-item">--}}

{{--								<div class="testimonial-long">--}}

{{--									<p class="saying">--}}
{{--										Far quitting dwelling graceful the likewise received building. An fact so to that show am shed sold cold. Unaffected remarkably get yet introduced excellence terminated led.--}}
{{--									</p>--}}

{{--									<h4 class="uppercase text-warning">James Hogue</h4>--}}
{{--									<p class="he">Utah, USA</p>--}}

{{--								</div>--}}

{{--							</div>--}}

{{--						</div>--}}

{{--						<div class="clear"></div>--}}

{{--						<div class="slider gallery-nav slick-testimonial-nav alt">--}}
{{--							<div class="slick-item">--}}
{{--								<div class="testimonial-man">--}}
{{--									<div class="image">--}}
{{--										<img src="/frontend/images/man/01.jpg" alt="image"/>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--							</div>--}}
{{--							<div class="slick-item">--}}
{{--								<div class="testimonial-man">--}}
{{--									<div class="image">--}}
{{--										<img src="/frontend/images/man/02.jpg" alt="image"/>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--							</div>--}}
{{--							<div class="slick-item">--}}
{{--								<div class="testimonial-man">--}}
{{--									<div class="image">--}}
{{--										<img src="/frontend/images/man/03.jpg" alt="image"/>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--							</div>--}}
{{--							<div class="slick-item">--}}
{{--								<div class="testimonial-man">--}}
{{--									<div class="image">--}}
{{--										<img src="/frontend/images/man/04.jpg" alt="image"/>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--							</div>--}}
{{--							<div class="slick-item">--}}
{{--								<div class="testimonial-man">--}}
{{--									<div class="image">--}}
{{--										<img src="/frontend/images/man/05.jpg" alt="image"/>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--							</div>--}}
{{--							<div class="slick-item">--}}
{{--								<div class="testimonial-man">--}}
{{--									<div class="image">--}}
{{--										<img src="/frontend/images/man/06.jpg" alt="image"/>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--							</div>--}}
{{--							<div class="slick-item">--}}
{{--								<div class="testimonial-man">--}}
{{--									<div class="image">--}}
{{--										<img src="/frontend/images/man/07.jpg" alt="image"/>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--							</div>--}}
{{--							<div class="slick-item">--}}
{{--								<div class="testimonial-man">--}}
{{--									<div class="image">--}}
{{--										<img src="/frontend/images/man/08.jpg" alt="image"/>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--							</div>--}}
{{--							<div class="slick-item">--}}
{{--								<div class="testimonial-man">--}}
{{--									<div class="image">--}}
{{--										<img src="/frontend/images/man/09.jpg" alt="image"/>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--							</div>--}}
{{--							<div class="slick-item">--}}
{{--								<div class="testimonial-man">--}}
{{--									<div class="image">--}}
{{--										<img src="/frontend/images/man/10.jpg" alt="image"/>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--							</div>--}}
{{--						</div>--}}

{{--						<div class="clear mb-5"></div>--}}

{{--					</div>--}}

{{--				</div>--}}

{{--			</div>--}}

{{--		</div>--}}

{{--	</div>--}}

{{--	<div class="clear"></div>--}}

{{--	<div class="bg-white pt-50 pb-60">--}}

{{--		<div class="container">--}}

{{--			<div class="row">--}}

{{--				<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">--}}

{{--					<div class="section-title">--}}
{{--						<h2>Путеводители и советы</h2>--}}
{{--						<p>Feelings laughing at no wondered repeated provided finished. Possession her thoroughly remarkably terminated man continuing. Can friendly laughter goodness man him appetite.</p>--}}
{{--					</div>--}}

{{--				</div>--}}

{{--			</div>--}}

{{--			<div class="recent-post-wrapper">--}}

{{--				<div class="GridLex-gap-20-wrapper">--}}

{{--					<div class="GridLex-grid-noGutter-equalHeight GridLex-grid-center">--}}

{{--						<div class="GridLex-col-6_sm-6_xs-12_xss-12 mb-20">--}}

{{--							<div class="recent-post">--}}

{{--								<div class="image" style="background-image:url('/frontend/images/blog/01.jpg');"></div>--}}

{{--								<div class="content">--}}

{{--									<div class="meta"><i class="fa fa-calendar"></i> <a href="#">Nov 17, 2015</a> <span class="mh-5">|</span> <i class="fa fa-user"></i> <a href="#"> admin</a></div>--}}

{{--									<h4>Five Essential Items for Your Next Cruise </h4>--}}

{{--									<p>Say ferrars demands besides her address. Blind going you merit few fancy their...</p>--}}

{{--									<a href="#" class="btn-read-more">read more <i class="fa fa-long-arrow-right"></i></a>--}}

{{--								</div>--}}

{{--							</div>--}}

{{--						</div>--}}

{{--						<div class="GridLex-col-6_sm-6_xs-12_xss-12 mb-20">--}}

{{--							<div class="recent-post">--}}

{{--								<div class="image" style="background-image:url('/frontend/images/blog/02.jpg');"></div>--}}

{{--								<div class="content">--}}

{{--									<div class="meta"><i class="fa fa-calendar"></i> <a href="#">Nov 17, 2015</a> <span class="mh-5">|</span> <i class="fa fa-user"></i> <a href="#"> admin</a></div>--}}

{{--									<h4>Family Reunion Planning During the Holidays</h4>--}}

{{--									<p>Six started far placing saw respect females old. Civilly why how end viewing...</p>--}}

{{--									<a href="#" class="btn-read-more">read more <i class="fa fa-long-arrow-right"></i></a>--}}

{{--								</div>--}}

{{--							</div>--}}

{{--						</div>--}}

{{--						<div class="GridLex-col-6_sm-6_xs-12_xss-12 mb-20">--}}

{{--							<div class="recent-post clearfix">--}}

{{--								<div class="image" style="background-image:url('/frontend/images/blog/03.jpg');"></div>--}}

{{--								<div class="content">--}}

{{--									<div class="meta"><i class="fa fa-calendar"></i> <a href="#">Nov 17, 2015</a> <span class="mh-5">|</span> <i class="fa fa-user"></i> <a href="#"> admin</a></div>--}}

{{--									<h4>Dental Care While Travel & Dental Tourism</h4>--}}

{{--									<p>Man particular insensible celebrated conviction stimulated principles day. Sure fail...</p>--}}

{{--									<a href="#" class="btn-read-more">read more <i class="fa fa-long-arrow-right"></i></a>--}}

{{--								</div>--}}

{{--							</div>--}}

{{--						</div>--}}

{{--						<div class="GridLex-col-6_sm-6_xs-12_xss-12 mb-20">--}}

{{--							<div class="recent-post">--}}

{{--								<div class="image" style="background-image:url('/frontend/images/blog/04.jpg');"></div>--}}

{{--								<div class="content">--}}

{{--									<div class="meta"><i class="fa fa-calendar"></i> <a href="#">Nov 17, 2015</a> <span class="mh-5">|</span> <i class="fa fa-user"></i> <a href="#"> admin</a></div>--}}

{{--									<h4>Packing Lists - Create Your Own Packing List</h4>--}}

{{--									<p>Greatest properly off ham exercise all. Unsatiable invitation its possession nor...</p>--}}

{{--									<a href="#" class="btn-read-more">read more <i class="fa fa-long-arrow-right"></i></a>--}}

{{--								</div>--}}

{{--							</div>--}}

{{--						</div>--}}

{{--					</div>--}}

{{--				</div>--}}

{{--			</div>--}}

{{--		</div>--}}

{{--	</div>--}}

{{--	<div class="clear"></div>--}}

{{--	<div class="instagram-full-wrapper">--}}

{{--		<div class="container">--}}

{{--			<div class="row">--}}

{{--				<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">--}}

{{--					<div class="section-title">--}}

{{--						<p class="p-top">Наш интаграмм</p>--}}
{{--						<h4>Instagram <a href="#"><i class="fa fa-at"></i> EXTRETION</a></h4>--}}

{{--					</div>--}}

{{--				</div>--}}

{{--			</div>--}}

{{--		</div>--}}

{{--		<div class="instagram-wrapper">--}}
{{--			<div id="instagram" class="instagram"></div>--}}
{{--		</div>--}}

{{--	</div>--}}

{{--	<div class="clear"></div>--}}

{{--	<div class="bg-primary newsletter-wrapper">--}}

{{--		<div class="container">--}}

{{--			<div class="GridLex-grid-middle">--}}

{{--				<div class="GridLex-col-6_sm-12_xs-12 pt-0 pb-0">--}}
{{--					<div class="text-holder">--}}
{{--						<h3>Подпишитесь на рассылку</h3>--}}
{{--						<p>Подпишитесь для получения от нас актуальных предложений по горячим турам</p>--}}
{{--					</div>--}}
{{--				</div>--}}

{{--				<div class="GridLex-col-6_sm-12_xs-12 pt-0 pb-0">--}}
{{--					<form class="footer-newsletter row gap-10">--}}

{{--						<div class="col-xss-12 col-xs-8 col-sm-8">--}}

{{--							<input type="email" placeholder="Ваша почта" class="form-control mb-0" name="email">--}}

{{--						</div>--}}

{{--						<div class="col-xss-12 col-xs-4 col-sm-4 mt-10-xss">--}}
{{--							<input type="submit" class="btn btn-block btn-danger" value="Подписаться">--}}
{{--						</div>--}}

{{--					</form>--}}
{{--				</div>--}}

{{--			</div>--}}

{{--		</div>--}}

{{--	</div>--}}

	<div class="clear"></div>
@endsection