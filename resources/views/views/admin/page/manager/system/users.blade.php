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
								<th>Имя</th>
								<th>Почта</th>
								<th>Роль</th>
								<th class="text-center">Действие</th>
							</tr>
							</thead>
							<tbody>
							@if($users->count() > 0)
								@foreach($users as $user)
									<tr>
										<td>{{ $user->name }}</td>
										<td>{{ $user->email }}</td>
										<td>{{ !empty($user->roles->first()->name) ? $user->roles->first()->name : print ('Роль не назначена') }}</td>
										<td class="text-center">
											<div class="list-icons">
												<div class="dropdown">
													<a href="#" class="list-icons-item" data-toggle="dropdown">
														<i class="icon-menu9"></i>
													</a>

													<div class="dropdown-menu dropdown-menu-right">
														<a href="#" class="dropdown-item"
														   data-toggle="modal"
														   data-target="#change_role"
														   data-id = "{{ $user->id }}"
														   data-name = {{ $user->name }}
														><i class="icon-user-plus"></i> Изменить роль</a>
														<a href="#" class="dropdown-item"
														   data-toggle="modal"
														   data-target="#delete"
														   data-id = "{{ $user->id }}"
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

		<!-- modal_published_false -->
		<div id="change_role" class="modal fade">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Роль пользователя</h5>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>

					<form id="formmodal_change_role" action="" method="post" class="modal-body form-inline justify-content-center">
						@method('PUT')
						@csrf

						<label>Имя:</label>
						<input type="text" id="name" name="name" disabled value="" class="form-control mb-2 mr-sm-2 ml-sm-2 mb-sm-0">

						<label class="ml-sm-2">Роль:</label>
						<select name="role" class="form-control mb-2 mr-sm-2 ml-sm-2 mb-sm-0">
							<option value="000">Без роли</option>
							@foreach($roles as $role)
								<option value="{{ $role->id }}">{{ $role->name }}</option>
							@endforeach
						</select>

						<button type="submit" class="btn bg-primary ml-sm-2 mb-sm-0">Сохранить <i class="icon-plus22"></i></button>
					</form>
				</div>
			</div>
		</div>
		<!-- /modal_published_true -->
		<!-- Basic modal delete-->
		<div id="delete" class="modal fade" tabindex="-1">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="card">
						<div class="card-header bg-light header-elements-inline">
							<h6 class="card-title">Удалить пользователя?</h6>
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
		$('#change_role').on('shown.bs.modal', function (event) {
			var data_id = $( event.relatedTarget ).data( "id" );
			var data_name = $( event.relatedTarget ).data( "name" );
			user_name = data_name;
			route = "/manager/system/user/" + data_id;
			$("#formmodal_change_role").attr("action", route);
			$("#name").attr("value", user_name)
		});
	</script>
	<script>
		$('#delete').on('shown.bs.modal', function (event) {
			var data_id = $( event.relatedTarget ).data( "id" );
			route = "/manager/system/user/" + data_id;
			$("#formmodaldelete").attr("action", route)
		});
	</script>
@endsection