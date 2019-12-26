@extends('admin.layouts.main')
@section('scripts-for-page')
	<script src="/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
@endsection
@section('content-area')
	<div class="content">

		<!-- Inner container -->
		@include('admin.layouts.message')
		<div class="d-flex align-items-start flex-column flex-md-row">

			<div class="col-md-4">
				<div class="card">
					<div class="card-header bg-light header-elements-inline">
						<h6 class="card-title">Добавить новое направление</h6>
						<div class="header-elements">
							<div class="list-icons">
								<a class="list-icons-item" data-action="collapse"></a>
							</div>
						</div>
					</div>

					<div class="card-body">
						<form method="POST" action="{{ route('manager.scope.store') }}">
                            @csrf
							<div class="form-group">
								<label>Название</label>
								<input name="title"
                                       type="text"
                                       class="form-control"
                                        value="{{ old('title') }}">
							</div>

							<div class="text-right">
								<button type="submit" class="btn btn-primary">Добавить новое направление <i class="icon-paperplane ml-2"></i></button>
							</div>
						</form>
					</div>
				</div>
			</div>

			<div class="col-md-8">
				<div class="card">
					<div class="card-header bg-light header-elements-inline">
						<h6 class="card-title">Список направлений</h6>
					</div>
					<div class="card-body">
						<table class="table datatable-basic">
							<thead>
							<tr>
								<th style="width: 25%">Направление</th>
								<th style="width: 25%">Количество туров</th>
								<th style="width: 10%" class="text-center">Действие</th>
							</tr>
							</thead>
							<tbody>
							@if($scopes->isNotEmpty())
								@foreach($scopes as $scope)
									<tr>
										<td>{{ $scope->title }}</td>
										<td class="text-center"><a href="{{ route('manager.tour.indexCurrentScope', $scope->id) }}">{{ $scope->tours->count() }}</a></td>
										<td class="text-center">
											<div class="list-icons">
												<div class="dropdown">
													<a href="#" class="list-icons-item" data-toggle="dropdown">
														<i class="icon-menu9"></i>
													</a>

													<div class="dropdown-menu dropdown-menu-right">
														<a href="#" class="dropdown-item"
														   data-toggle="modal"
														   data-target="#modal_default"
														   data-id = "{{ $scope->id }}"
														   data-title="{{ $scope->title }}"
															><i class="icon-pencil3"></i> Редактировать</a>
														<a href="#" class="dropdown-item"
														   data-toggle="modal"
														   data-target="#modal_delete"
														   data-id = "{{ $scope->id }}"
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
		<!-- Basic modal -->
		<div id="modal_default" class="modal fade" tabindex="-1">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="card">
						<div class="card-header bg-light header-elements-inline">
							<h6 class="card-title">Редактировать направление</h6>
						</div>

						<div class="card-body">
							<form method="POST" id="formmodal" action="">
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
							<h6 class="card-title">Удалить направление?</h6>
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
				info: 'Записи с _START_ по _END_ из _TOTAL_ записей',
				sEmptyTable: 'Категории не найдены'
			}
		});
	</script>
	<script>
		$('#modal_default').on('shown.bs.modal', function (event) {
			var data_id = $( event.relatedTarget ).data( "id" );
			route = "/manager/scope/" + data_id;
			data_title = $( event.relatedTarget ).data( "title" );
			$('input[id="modal_title"]').val(data_title);
			$("#formmodal").attr("action", route)
		});
	</script>
	<script>
		$('#modal_delete').on('shown.bs.modal', function (event) {
			var data_id = $( event.relatedTarget ).data( "id" );
			route = "/manager/scope/" + data_id;
			$("#formmodaldelete").attr("action", route)
		});
	</script>
@endsection