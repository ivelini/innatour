@extends('admin.layouts.main')
@section('scripts-for-page')
	<script src="/global_assets/js/plugins/editors/summernote/summernote.min.js"></script>
	<script src="/global_assets/js/plugins/forms/styling/uniform.min.js"></script>

	<script src="/global_assets/js/plugins/uploaders/fileinput/plugins/purify.min.js"></script>
	<script src="/global_assets/js/plugins/uploaders/fileinput/plugins/sortable.min.js"></script>
	<script src="/global_assets/js/plugins/uploaders/fileinput/fileinput.min.js"></script>

	<script src="/global_assets/js/demo_pages/uploader_bootstrap.js"></script>

	<script src="/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js"></script>
	<script src="/global_assets/js/plugins/forms/selects/select2.min.js"></script>
	<script>
		$(document).ready(function(){
			var i = $('#data_inputs .form-control').length;
			if (i == 0) {
				i = 1;
			}
			else {
				i = i / 2 + 1;
			}
			$('#add').click(function() {
				$('<div class="field form-group row"><div class="col-3"><div class="form-group row"><div class="col-form-label col-12">Начало тура  / Конец тура</div></div></div><div class="col-9"><div class="form-group row"><div class="col-3"><input class="form-control" type="date" name="dates[' + i + '][start]" value=""></div><div class="col-3"><input class="form-control" type="date" name="dates[' + i + '][finish]" value=""></div><div class="col-6"><input class="form-control" type="text" name="comment[' + i + '][finish]" value=""></div></div></div></div>').fadeIn('slow').appendTo('.inputs');
				i++;
			});

			$('#remove').click(function() {
				if(i > 1) {
					$('.field:last').remove();
					i--;
				}
			});
		});
	</script>
@endsection
@section('content-area')
	<div class="content">

		<!-- Inner container -->
		<div class="d-flex align-items-start flex-column flex-md-row">

			<!-- Left content -->
			<div class="w-100 order-2 order-md-1">

				<!-- Form inputs -->
				<div class="card">
					<div class="card-body">
						<form method="post" action="{{ route('manager.tour.update', $tour->id) }}" enctype="multipart/form-data">
							@method('PATCH')
							@csrf
							<div class="form-group mb-3 mb-md-2 text-right">
								<div class="form-check form-check-inline form-check-right">
									<label class="form-check-label">
										Опубликовать:
										<input name="is_published"
											   type="checkbox"
											   class="form-check-input-styled" {{ old('is_published', $tour->is_published) ? 'checked' : '' }} data-fouc>
									</label>
								</div>
							</div>
							@include('admin.layouts.message')
							<fieldset class="mb-3">
								<div id="accordion-styled">
									<div class="card">
										<div class="card-header {{ ($dates->count() > 0) ? 'bg-info-300' : 'bg-default' }} ">
											<h6 class="card-title">
												<a data-toggle="collapse" class="text-dark" href="#raspisanie">Расписание</a>
											</h6>
										</div>

										<div id="raspisanie" class="collapse" data-parent="#accordion-styled">
											<div class="card-body">
												<a href="#" id="add">Добавить</a> | <a href="#" id="remove">Удалить</a>
												@if($dates->count() > 0)
													<div class="inputs" id="data_inputs">
														@php $i = 1 @endphp
														@foreach($dates as $date)
															<div class="field form-group row">
																<div class="col-3">
																	<div class="form-group row">
																		<div class="col-form-label col-12">Начало тура  / Конец тура</div>
																	</div>
																</div>
																<div class="col-9">
																	<div class="form-group row">
																		<div class="col-3">
																			<input class="form-control"
																				   id="dates"
																				   type="date"
																				   name="dates[{{ $i }}][start]"
																				   value="{{ $date->start }}">
																		</div>
																		<div class="col-3">
																			<input class="form-control"
																				   id="dates"
																				   type="date"
																				   name="dates[{{ $i }}][finish]"
																				   value="{{ $date->finish }}">
																		</div>
																		<div class="col-6">
																			<input class="form-control"
																				   id="comment"
																				   type="text"
																				   name="dates[{{ $i }}][comment]"
																				   value="{{ $date->comment }}">
																		</div>
																	</div>
																</div>
															</div>
															@php $i++ @endphp
														@endforeach
													</div>
												@elseif(empty($dates) == false)
													<div class="inputs"></div>
												@endif
											</div>
										</div>
									</div>
								</div>
							</fieldset>
							<fieldset class="mb-3">
								<legend class="text-uppercase font-size-sm font-weight-bold">Основные данные</legend>

								<div class="form-group row">
									<label class="col-form-label col-lg-2">Название</label>
									<div class="col-lg-10">
										<input name="title"
											   type="text"
											   class="form-control"
											   value="{{ old('title', $tour->title) }}">
									</div>
								</div>

								<div class="form-group row">
									<label class="col-form-label col-lg-2">Описание</label>
									<div class="col-lg-10">
										<textarea name="description"
												  rows="5"
												  cols="3"
												  class="form-control"
												  id="summernote">{{ old('description', $tour->description) }}</textarea>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-2">Категории</label>
									<div class="col-lg-10">
										<select name="categoriesId[]"
												class="form-control select-multiple-drag"
												multiple="multiple" data-fouc>
											@include('admin.page.manager.tour._categories')
										</select>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-2">Направления</label>
									<div class="col-lg-10">
										<select name="scope_id"
												class="form-control select-multiple-drag"
												data-fouc>
											@if($allScopes->isNotEmpty())
												{{--												<option value="0">Не задано</option>--}}
												@foreach($allScopes as $scope)
													<option value="{{ $scope->id }}"
															@php
																$scopeId = old('scope_id');
															@endphp
															@if($scope->id == $selectScope->id)
															{{--																	@dd($scope->id, $selectScope->id)--}}
															selected
															@endif
													>{{ $scope->title }}</option>
												@endforeach
											@else
												<option selected disabled>Направления не заданы</option>
											@endif
										</select>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-2">Описание в категории</label>
									<div class="col-lg-10">
										<textarea name="description_cat"
												  rows="2"
												  cols="3"
												  class="form-control">{{ old('description_cat', $tour->description_cat) }}</textarea>
									</div>
								</div>
							</fieldset>

							<fieldset class="mb-3">
								<legend class="text-uppercase font-size-sm font-weight-bold">Галерея</legend>

								<div class="row">

									@if($photos->isNotEmpty())
										@foreach($photos as $photo)
											<div class="col-sm-6 col-xl-3">
												<div class="card">
													<div class="card-img-actions mx-1 mt-1">
														<img class="card-img img-fluid" src="{{ asset('storage/' .$photo->path) }}" alt="">
													</div>

													<div class="card-body">
														<div class="d-flex align-items-start flex-nowrap">
															<div class="list-icons list-icons-extended ml-left">
																	<div class="form-check form-check-inline">
																		<label class="form-check-label ">
																			<input type="radio"
																				   name="GalleryHeaderPhotoId"
																				   class="form-check-input-styled"
																				   value="{{ $photo->id }}"
																				   	@php
																				   		$GalleryHeaderPhotoId = old('GalleryHeaderPhotoId');
																				   	@endphp
																					@if($GalleryHeaderPhotoId == true && $GalleryHeaderPhotoId == $photo->id)
																				   		checked
																				   	@else
																						@if($photo->is_header == true)
																				   			checked
																				   		@endif
																				   	@endif
																				   data-fouc>
																		</label>
																	</div>
															</div>
															<div class="list-icons list-icons-extended ml-auto">
																<i class="icon-bin top-0"></i>
																<div class="form-check form-check-inline">
																	<label class="form-check-label">
																		<input type="checkbox"
																			   class="form-check-input-styled"
																			   name="deletePhoto[]"
																			   value="{{ $photo->id }}"
																			   data-fouc>
																	</label>
																</div>
															</div>
														</div>
													</div>

												</div>
											</div>
										@endforeach
									@endif

								</div>

								<div class="form-group row">
									<label class="col-lg-2 col-form-label font-weight-semibold">Загрузка фото:</label>
									<div class="col-lg-10">
										<input name="uploadPhotos[]"
											   type="file"
											   class="file-input-ajax"
											   multiple="multiple" data-fouc>
									</div>
								</div>
							</fieldset>

							<fieldset class="mb-3">
								<legend class="text-uppercase font-size-sm font-weight-bold">Документация</legend>

								@if(!empty($tour->file_name))
									<div class="form-group row">
										<div class="col-lg-2"></div>
										<div class="col-lg-10">
											<a href="{{ asset('storage/' .$tour->file_path) }}">{{ $tour->file_name }}</a>
										</div>
									</div>
								@endif

								<div class="form-group row">
									<label class="col-lg-2 col-form-label font-weight-semibold">Загрузка файла:</label>
									<div class="form-group row">
										<div class="col-lg-10">
											<input name="file_path"
												   type="file" class="form-control h-auto">
										</div>
									</div>

								</div>

								<div class="form-group row">
									<label class="col-form-label col-lg-2">Название файла</label>
									<div class="col-lg-10">
										<input name="file_name"
											   type="text"
											   class="form-control"
											   value="{{ old('file_name', $tour->file_name) }}">
									</div>


								</div>
							</fieldset>

							<fieldset class="mb-3">
								<legend class="text-uppercase font-size-sm font-weight-bold">Цена</legend>

								<div class="form-group row">
									<label class="col-form-label col-lg-2">Полная стоимтость</label>
									<div class="col-lg-10">
										<input name="price"
											   type="text"
											   class="form-control"
											   value="{{ old('price', $tour->price) }}">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-2">Распродажа</label>
									<div class="col-lg-10">
										<input name="sale"
											   type="text"
											   class="form-control"
											   value="{{ old('sale', $tour->sale) }}">
									</div>
								</div>
							</fieldset>
							<div class="text-right">
								<button type="submit" class="btn btn-primary">Сохранить<i class="icon-paperplane ml-2"></i></button>
							</div>
						</form>
					</div>
				</div>
				<!-- /form inputs -->


			</div>
			<!-- /left content -->


			<!-- Right sidebar component -->
			<div class="sidebar sidebar-light sidebar-component sidebar-component-right order-1 order-md-2 sidebar-expand-md bg-transparent border-0 shadow-0">

				<!-- Sidebar content -->
				<div class="sidebar-content">

					<!-- Form sample -->
					<div class="card">
						<div class="card-header bg-transparent header-elements-inline">
							<span class="text-uppercase font-size-sm font-weight-semibold">Информация</span>
							<div class="header-elements">
								<div class="list-icons">
									<a class="list-icons-item" data-action="collapse"></a>
								</div>
							</div>
						</div>

						<div class="card-body">
							<div class="form-group">
								<label>Дата создания</label>
								<input type="text" class="form-control" readonly value="{{ $tour->created_at }}">
							</div>

							<div class="form-group">
								<label>Дата обновления</label>
								<input type="text" class="form-control" readonly value="{{ $tour->updated_at }}">
							</div>

							<div class="form-group">
								<label>Менеджер</label>
								<input type="text" class="form-control" readonly value="{{ $user->name }}">
							</div>
						</div>
					</div>

					<div class="card">
						<div class="card-header bg-transparent header-elements-inline">
							<span class="text-uppercase font-size-sm font-weight-semibold">Действие</span>
							<div class="header-elements">
								<div class="list-icons">
									<a class="list-icons-item" data-action="collapse"></a>
								</div>
							</div>
						</div>

						<div class="card-body">
							<div class="form-group">
								<a target="_blank" href="{{ route('tour.show', $tour->id) }}" class="btn bg-green btn-block">Просмотр</a>
							</div>
						</div>
					</div>
					<!-- /form sample -->

				</div>
				<!-- /sidebar content -->

			</div>
			<!-- /right sidebar component -->

		</div>
		<!-- /inner container -->

	</div>
@endsection
@section('script')
	<script>
		$(document).ready(function() {
			$('#summernote').summernote();
		});
	</script>
	<script>
		var InputsCheckboxesRadios = function () {
			// Uniform
			var _componentUniform = function() {
				if (!$().uniform) {
					console.warn('Warning - uniform.min.js is not loaded.');
					return;
				}
				// Default initialization
				$('.form-check-input-styled').uniform();
			};

			return {
				initComponents: function() {
					_componentUniform();
					_componentSwitchery();
					_componentBootstrapSwitch();
				}
			}
		}();

		// Initialize module
		// ------------------------------

		document.addEventListener('DOMContentLoaded', function() {
			InputsCheckboxesRadios.initComponents();
		});
	</script>
	<script>
		var Select2Selects = function() {
			var _componentSelect2 = function() {
				if (!$().select2) {
					console.warn('Warning - select2.min.js is not loaded.');
					return;
				}

				// Initialize with tags
				$('.select-multiple-drag').select2({
					containerCssClass: 'sortable-target'
				});

				// Add jQuery UI Sortable support
				$('.sortable-target .select2-selection__rendered').sortable({
					containment: '.sortable-target',
					items: '.select2-selection__choice:not(.select2-search--inline)'
				});
			};

			return {
				init: function() {
					_componentSelect2();
				}
			}
		}();

		document.addEventListener('DOMContentLoaded', function() {
			Select2Selects.init();
		});
	</script>

@endsection