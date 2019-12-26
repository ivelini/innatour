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
						<table class="table datatable-basic">
							<thead>
							<tr>
								<th>Дата</th>
								<th>Имя</th>
								<th>Телефон</th>
								<th>Почта</th>
								<th>Сообщение</th>
								<th>URL адрес</th>
								<th class="text-center">Действие</th>
							</tr>
							</thead>
							<tbody>
							@if($clients->count() > 0)
								@foreach($clients as $client)
									<tr>
										<td>{{ $client->created_at }}</td>
										<td>{{ $client->name }}</td>
										<td>{{ $client->phone }}</td>
										<td>{{ $client->email }}</td>
										<td>{{ $client->message }}</td>
										<td>
											@php
												foreach ($toursSendMessages as $tour) {
													if($client->tour_id == $tour['id']) {
														printf('<a target = "_blank" href="'.route('tour.show', $tour['id']).'">'.$tour['title'].'</a>');
													}
												}
											@endphp
										</td>
										<td class="text-center">
											<div class="list-icons">
												<div class="dropdown">
													<a href="#" class="list-icons-item" data-toggle="dropdown">
														<i class="icon-menu9"></i>
													</a>

													<div class="dropdown-menu dropdown-menu-right">
														<a href="#" class="dropdown-item"
														   data-toggle="modal"
														   data-target="#modal_client_active"
														   data-id = "{{ $client->id }}"
														><i class="icon-user-plus"></i> В активные</a>
														<a href="#" class="dropdown-item"
														   data-toggle="modal"
														   data-target="#modal_client_delete"
														   data-id = "{{ $client->id }}"
														><i class="icon-user-cancel"></i> Удалить</a>
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
		<div id="modal_client_active" class="modal fade" tabindex="-1">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="card">
						<div class="card-header bg-light header-elements-inline">
							<h6 class="card-title">Переместить в активные?</h6>
						</div>

						<div class="card-body">
							<form method="POST" id="formmodal_active" action="">
								@method('PUT')
								@csrf
								<input name="status" type="hidden" value="active">
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
		<div id="modal_client_delete" class="modal fade" tabindex="-1">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="card">
						<div class="card-header bg-light header-elements-inline">
							<h6 class="card-title">Удалить клиента?</h6>
						</div>

						<div class="card-body">
							<form method="POST" id="formmodal_delete" action="">
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
		$('#modal_client_active').on('shown.bs.modal', function (event) {
			var data_id = $( event.relatedTarget ).data( "id" );
			route = "/manager/client/" + data_id + "/active";
			$("#formmodal_active").attr("action", route)
		});
	</script>
	<script>
		$('#modal_client_delete').on('shown.bs.modal', function (event) {
			var data_id = $( event.relatedTarget ).data( "id" );
			route = "/manager/client/" + data_id;
			$("#formmodal_delete").attr("action", route)
		});
	</script>
@endsection