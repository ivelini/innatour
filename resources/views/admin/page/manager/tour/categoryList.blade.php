@extends('admin.layouts.main')
@section('scripts-for-page')
	<script src="/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
@endsection
@section('content-area')
	<div class="content">

		<!-- Inner container -->
		@include('admin.layouts.message')
		<div class="d-flex align-items-start flex-column flex-md-row">

			<div class="col-md-12">
				<div class="card card-collapsed">
					<div class="card-header bg-light header-elements-inline">
						<h6 class="card-title">Добавить новую категорию</h6>
						<div class="header-elements">
							<div class="list-icons">
								<a class="list-icons-item" data-action="collapse"></a>
							</div>
						</div>
					</div>

					<div class="card-body">
						<form method="POST" action="{{ route('manager.category.store') }}" enctype="multipart/form-data">
                            @csrf
							<div class="form-group">
								<label>Название</label>
								<input name="title"
                                       type="text"
                                       class="form-control"
                                        value="{{ old('title') }}">
							</div>

							<div class="form-group">
								<label>Описание</label>
								<textarea name="description"
                                          rows="5"
                                          cols="5"
                                          class="form-control">{{ old('description') }}</textarea>
							</div>

							<div class="form-group row">
								<label class="col-form-label col-lg-2">Родительская категория</label>
								<div class="col-lg-10">
                                    <select name="parent_id" class="form-control">
                                        <option value="0">-- без родительской категории --</option>
                                        @include('admin.page.manager.tour._categories')
                                    </select>
								</div>
							</div>

							<div class="form-group row">
								<div class="col-lg-10">
									<input name="cat_img"
											type="file" class="form-control h-auto">
								</div>
							</div>

							<div class="form-group">
								<label>Описание на изображении</label>
								<input name="description_img"
									   type="text"
									   class="form-control"
									   value="{{ old('description_img') }}">
							</div>

							<div class="text-right">
								<button type="submit" class="btn btn-primary">Добавить новую категорию <i class="icon-paperplane ml-2"></i></button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="d-flex align-items-start flex-column flex-md-row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header bg-light header-elements-inline">
						<h6 class="card-title">Список категорий</h6>
					</div>
					<div class="card-body">
						<table class="table">
							<thead>
							<tr>
								<th style="width: 25%">Изображение</th>
								<th style="width: 25%">Название</th>
								<th style="width: 40%" class="text-center">Описание</th>
								<th style="width: 15%" class="text-center">Количество туров</th>
								<th style="width: 10%" class="text-center">Действие</th>
							</tr>
							</thead>
							<tbody>
								@include('admin.page.manager.tour._categoriesIndex')
							</tbody>
						</table>
					</div>
				</div>

			</div>



		</div>
		<!-- /inner container -->
		<!-- Basic modal -->
		<div id="modal_default" class="modal fade" tabindex="-1">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="card">
						<div class="card-header bg-light header-elements-inline">
							<h6 class="card-title">Редактировать категорию</h6>
						</div>

						<div class="card-body">
							<form method="POST" id="formmodal" action="" enctype="multipart/form-data">
								@method('PATCH')
								@csrf
								<div class="form-group">
									<label>Название</label>
									<input name="title"
										   id="modal_title"
										   type="text"
										   class="form-control"
											value="">
								</div>

								<div class="form-group">
									<label>Описание</label>
									<textarea name="description"
											  id="modal_description"
											  rows="5"
											  cols="5"
											  class="form-control"></textarea>
								</div>

								<div class="form-group row">
									<label>Родительская категория</label>
									<div class="col-lg-12">
										<select id="parent_id" name="parent_id" class="form-control">
											<option value="0">-- без родительской категории --</option>
											@include('admin.page.manager.tour._categories')
										</select>
									</div>
								</div>

								<img id="modal_path" style="max-width: 350px; max-height: 250px; margin-bottom: 15px" src="">

								<div class="form-group row">
									<div class="col-lg-10">
										<input name="cat_img"
											   type="file" class="form-control h-auto">
									</div>
								</div>

								<div class="form-group">
									<label>Описание на изображении</label>
									<input name="description_img"
										   id="modal_description_img"
										   type="text"
										   class="form-control"
										   value="">
								</div>

								<div class="text-right">
									<button type="button" class="btn btn-link" data-dismiss="modal">Закрыть</button>
									<button type="submit" class="btn btn-primary">Сохранить <i class="icon-floppy-disk ml-2"></i></button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /basic modal -->
		<!-- Basic modal delete-->
		<div id="modal_delete" class="modal fade" tabindex="-1">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="card">
						<div class="card-header bg-light header-elements-inline">
							<h6 class="card-title">Удалить категорию?</h6>
						</div>

						<div class="card-body">
							<form method="POST" id="formmodaldelete" action="">
								@method('DELETE')
								@csrf
								<div class="text-right">
									<button type="button" class="btn btn-link" data-dismiss="modal">Нет</button>
									<button type="submit" class="btn bg-warning">Да <i class="icon-bin ml-2"></i></button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /basic modal -->
	</div>
@endsection
@section('script')
	<script>
		$('#modal_default').on('shown.bs.modal', function (event) {
			var data_id = $( event.relatedTarget ).data( "id" );
			var parent_id = $( event.relatedTarget ).data( "parent_id" );
			var img = document.getElementById("modal_path");
			route = "/manager/category/" + data_id;
			data_title = $( event.relatedTarget ).data( "title" );
			data_description = $( event.relatedTarget ).data( "description" );
			data_description_img = $( event.relatedTarget ).data( "description_img" );
			data_path = $( event.relatedTarget ).data( "path" );
			$('input[id="modal_title"]').val(data_title);
			$('select[id="parent_id"]').val(parent_id);
			$('textarea[id="modal_description"]').val(data_description);
			$('input[id="modal_description_img"]').val(data_description_img);
			img.src = data_path;
			$("#formmodal").attr("action", route)
		});
	</script>
	<script>
		$('#modal_delete').on('shown.bs.modal', function (event) {
			var data_id = $( event.relatedTarget ).data( "id" );
			route = "/manager/category/" + data_id;
			$("#formmodaldelete").attr("action", route)
		});
	</script>
@endsection