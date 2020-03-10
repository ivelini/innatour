@extends('admin.layouts.main')
@section('scripts-for-page')
	<script src="/global_assets/js/plugins/editors/ckeditor/ckeditor.js"></script>
	<script src="/global_assets/js/plugins/forms/styling/uniform.min.js"></script>

	<script src="/global_assets/js/plugins/uploaders/fileinput/plugins/purify.min.js"></script>
	<script src="/global_assets/js/plugins/uploaders/fileinput/plugins/sortable.min.js"></script>
	<script src="/global_assets/js/plugins/uploaders/fileinput/fileinput.min.js"></script>

	<script src="/global_assets/js/demo_pages/uploader_bootstrap.js"></script>

	<script src="/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js"></script>
	<script src="/global_assets/js/plugins/forms/selects/select2.min.js"></script>
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
						<form method="post" action="{{ route('manager.tour.store') }}" enctype="multipart/form-data">
							@csrf
							<div class="form-group mb-3 mb-md-2 text-right">
								<div class="form-check form-check-inline form-check-right">
									<label class="form-check-label">
										Опубликовать:
										<input name="is_published"
											   type="checkbox"
											   class="form-check-input-styled" {{ old('is_published') ? 'checked' : '' }} data-fouc>
									</label>
								</div>
							</div>
							@include('admin.layouts.message')
							<fieldset class="mb-3">
								<legend class="text-uppercase font-size-sm font-weight-bold">Основные данные</legend>

								<div class="form-group row">
									<label class="col-form-label col-lg-2">Название</label>
									<div class="col-lg-10">
										<input name="title"
											   type="text"
											   class="form-control"
												value="{{ old('title') }}">
									</div>
								</div>

								<div class="form-group row">
									<label class="col-form-label col-lg-2">Описание</label>
									<div class="col-lg-10">
										<textarea name="description"
												  rows="5"
												  cols="3"
												  class="form-control"
												  id="editor-full">{{ old('description') }}</textarea>
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
										@php
											$scopeId = old('scopeId');
										@endphp
										<select name="scope_id"
												class="form-control select-multiple-drag"
												data-fouc>
											@if($allScopes->isNotEmpty())
												@php
													$scopeId = old('scope_id');
												@endphp
												@foreach($allScopes as $scope)
													<option value="{{ $scope->id }}"
															@if($scope->id == $scopeId)
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
												  class="form-control">{{ old('description_cat') }}</textarea>
									</div>
								</div>
							</fieldset>

							<fieldset class="mb-3">
								<legend class="text-uppercase font-size-sm font-weight-bold">Галерея</legend>

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
											   value="{{ old('file_name') }}">
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
											   value="{{ old('price') }}">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-2">Распродажа</label>
									<div class="col-lg-10">
										<input name="sale"
											   type="text"
											   class="form-control"
											   value="{{ old('sale') }}">
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
									<input type="text" class="form-control" readonly value="">
								</div>

								<div class="form-group">
									<label>Дата обновления</label>
									<input type="text" class="form-control" readonly value="">
								</div>

								<div class="form-group">
									<label>Менеджер</label>
									<input type="text" class="form-control" readonly value="">
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
		var CKEditor = function() {
			var _componentCKEditor = function() {
				if (typeof CKEDITOR == 'undefined') {
					console.warn('Warning - ckeditor.js is not loaded.');
					return;
				}
				CKEDITOR.replace('editor-full', {
					height: 250,
					extraPlugins: 'forms',
					toolbar: [
						{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'RemoveFormat' ] },
						{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
						{ name: 'insert', items: [ 'Image', 'Table', 'Link', 'Unlink', 'SpecialChar', '-', 'Undo', 'Redo' ] },
						'/',
						{ name: 'styles', items: [ 'Format', 'Font', 'FontSize' ] },
						{ name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
						{ name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source' ] },
						{ name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: ['PasteText' ] }
					]
				});
			};

			return {
				init: function() {
					_componentCKEditor();
				}
			}
		}();
		document.addEventListener('DOMContentLoaded', function() {
			CKEditor.init();
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