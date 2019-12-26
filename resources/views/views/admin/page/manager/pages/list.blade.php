@extends('admin.layouts.main')
@section('scripts-for-page')
	<script src="/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script src="/global_assets/js/plugins/notifications/bootbox.min.js"></script>
@endsection
@section('content-area')
	<div class="content">

		<!-- Inner container -->
		@include('admin.layouts.message')
		<div class="d-flex align-items-start flex-column flex-md-row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="text-right">
							<a href="{{ route('manager.page.create') }}" type="submit" class="btn btn-primary">Добавить новую страницу <i class="icon-paperplane ml-2"></i></a>
						</div>
						<table class="table datatable-basic">
							<thead>
							<tr>
								<th>Фото</th>
								<th>Заголовок</th>
								<th>Расположение</th>
								<th>Статус</th>
								<th class="text-center">Действие</th>
							</tr>
							</thead>
							<tbody>
								@if($pages->isNotEmpty())
									@foreach($pages as $page)
										<tr>
											<td>
												<div class="card-img-actions m-1">
													<img style="max-width: 250px; max-height: 150px;" src="
																@if(!empty($page->gallery->path))
																	{{ asset('storage/' .$page->gallery->path) }}
																@endif">
												</div>
											</td>
											<td>{{ $page->title }}</td>
											<td>{{ $page->location }}</td>
											<td>
												@if($page->is_published == true)
													<span class="badge badge-flat border-success text-success-600">Опубликован</span>
												@else
													<span class="badge badge-flat border-grey text-grey-600">Не опубликован</span>
												@endif
											</td>
											<td class="text-center">
												<div class="list-icons">
													<div class="dropdown">
														<a href="#" class="list-icons-item" data-toggle="dropdown">
															<i class="icon-menu9"></i>
														</a>

														<div class="dropdown-menu dropdown-menu-right">
															<a href="{{ route('manager.page.edit', $page->id) }}" class="dropdown-item"><i class="icon-pencil3"></i> Редактировать</a>
															<a href="#" class="dropdown-item"
															   data-toggle="modal"
															   data-target="#modal_delete"
															   data-id = "{{ $page->id }}"
															><i class="icon-bin"></i> Удалить</a>
														</div>
													</div>
												</div>
											</td>
										</tr>
									@endforeach
								@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<!-- /inner container -->

		<!-- modal_published_true -->
		<div id="modal_published_true" class="modal fade" tabindex="-1">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="card">
						<div class="card-header bg-light header-elements-inline">
							<h6 class="card-title">Опубликовать?</h6>
						</div>

						<div class="card-body">
							<form method="POST" id="formmodal_true" action="">
								@method('PUT')
								@csrf
								<input name="is_published" type="hidden" value="1">
								<div class="text-right">
									<button type="button" class="btn btn-link" data-dismiss="modal">Нет</button>
									<button type="submit" class="btn btn-primary">Да</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /modal_published_true -->
		<!-- modal_published_false -->
		<div id="modal_published_false" class="modal fade" tabindex="-1">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="card">
						<div class="card-header bg-light header-elements-inline">
							<h6 class="card-title">Снять с публикации?</h6>
						</div>

						<div class="card-body">
							<form method="POST" id="formmodal_false" action="">
								@method('PUT')
								@csrf
								<input name="is_published" type="hidden" value="0">
								<div class="text-right">
									<button type="button" class="btn btn-link" data-dismiss="modal">Нет</button>
									<button type="submit" class="btn btn-primary">Да</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /modal_published_true -->
		<!-- Basic modal delete-->
		<div id="modal_delete" class="modal fade" tabindex="-1">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="card">
						<div class="card-header bg-light header-elements-inline">
							<h6 class="card-title">Удалить тур?</h6>
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
		$('.datatable-basic').DataTable({
			autoWidth: false,
			dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
			language: {
				search: '<span>Фильтр:</span> _INPUT_',
				lengthMenu: '<span>Количество элементов :</span> _MENU_',
				paginate: { 'first': 'Вперед', 'last': 'Назад', 'next': '→', 'previous': '←' },
				info: 'Записи с _START_ по _END_ из _TOTAL_ записей'
			}
		});
	</script>
	<script>
		$('#modal_published_true').on('shown.bs.modal', function (event) {
			var data_id = $( event.relatedTarget ).data( "id" );
			route = "/manager/tour/" + data_id + "/publishing";
			$("#formmodal_true").attr("action", route)
		});
	</script>
	<script>
		$('#modal_published_false').on('shown.bs.modal', function (event) {
			var data_id = $( event.relatedTarget ).data( "id" );
			route = "/manager/tour/" + data_id + "/publishing";
			$("#formmodal_false").attr("action", route)
		});
	</script>
	<script>
		$('#modal_delete').on('shown.bs.modal', function (event) {
			var data_id = $( event.relatedTarget ).data( "id" );
			route = "/manager/page/" + data_id;
			$("#formmodaldelete").attr("action", route)
		});
	</script>
@endsection