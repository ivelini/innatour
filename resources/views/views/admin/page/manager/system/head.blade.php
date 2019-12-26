@extends('admin.layouts.main')
@section('scripts-for-page')
	<script src="/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script src="/global_assets/js/plugins/notifications/bootbox.min.js"></script>
	<script>
		$(document).ready(function(){
			var i = $('#data_inputs .form-control').length;
			if (i == 0) {
				i = 1;
			}
			else {
				i = i / 4 + 1;
			}
			$('#add').click(function() {
				$('<fieldset class="field mb-3"><legend class="text-uppercase font-size-sm font-weight-bold">Банер ' + i + '</legend><div class="form-group row"><label class="col-form-label col-lg-2">Заголовок</label><div class="col-lg-10"><input name="title[]" type="text" class="form-control" value=""></div></div><div class="form-group row"><label class="col-form-label col-lg-2">Описание</label><div class="col-lg-10"><textarea name="description[]" rows="3" cols="3" class="form-control" placeholder="Описание"></textarea></div></div><div class="form-group row"><label class="col-form-label col-lg-2">Фото</label><div class="col-lg-10"><input name="photo[]" type="file" class="form-control h-auto"></div></div><div class="form-group row"><label class="col-form-label col-lg-2">Ссылка</label><div class="col-lg-10"><input name="link[]" type="text" class="form-control" value=""></div></div></fieldset>').fadeIn('slow').appendTo('.inputs');
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
		@include('admin.layouts.message')
			<!-- Basic tabs -->
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-body">
							<ul class="nav nav-tabs">
								<li class="nav-item"><a href="#basic-tab1" class="nav-link active" data-toggle="tab">Карусель</a></li>
								<li class="nav-item"><a href="#basic-tab2" class="nav-link" data-toggle="tab">Поиск туров</a></li>
							</ul>

							<div class="tab-content">
								<div class="tab-pane fade show active" id="basic-tab1">
									<form action="{{ route('manager.system.main.updateCarusel') }}" method="POST" enctype="multipart/form-data">
										@csrf
										<div class="card-body">
											<a href="#" id="add">Добавить</a> | <a href="#" id="remove">Удалить</a>
											@if($caruselItems->count() > 0)
												<div class="inputs" id="data_inputs">
													@php $i = 1 @endphp
													@foreach($caruselItems as $item)
														<fieldset class="field mb-3">
															<legend class="text-uppercase font-size-sm font-weight-bold">Банер {{ $i }}</legend>

															<div class="form-group row">
																<label class="col-form-label col-lg-2">Заголовок</label>
																<div class="col-lg-10">
																	<input name="title[]"
																		   type="text" class="form-control"
																		   value="{{ $item->title }}">
																</div>
															</div>

															<div class="form-group row">
																<label class="col-form-label col-lg-2">Описание</label>
																<div class="col-lg-10">
														<textarea name="description[]"
																  rows="3" cols="3" class="form-control" placeholder="Описание">{{ $item->description }}</textarea>
																</div>
															</div>

															<div class="form-group row">
																<label class="col-form-label col-lg-2">Фото</label>
																<div class="col-lg-10">
																	@if(!empty($item->path))
																		<img style="width: 300px; height: 150px;" src="{{ asset('/storage/' .$item->path) }}">
																	@endif
																	<input name="photo[]"
																		   type="file" class="form-control h-auto">
																</div>
															</div>

															<div class="form-group row">
																<label class="col-form-label col-lg-2">Ссылка</label>
																<div class="col-lg-10">
																	<input name="link[]"
																		   type="text" class="form-control"
																		   value="{{ $item->link }}">
																</div>
															</div>
														</fieldset>
														@php $i++ @endphp
													@endforeach
												</div>
											@elseif(empty($caruselItems) == false)
												<div class="inputs"></div>
											@endif
										</div>

										<div class="text-right">
											<button type="submit" class="btn btn-primary">Сохранить <i class="icon-paperplane ml-2"></i></button>
										</div>
									</form>
								</div>
								<div class="tab-pane fade show" id="basic-tab2">
									<form action="{{ route('manager.system.main.updateTourSearch') }}" method="POST">
										@csrf
										<div class="card-body">
											<textarea name="tourSearchForm"
													  rows="15"
													  cols="3"
													  class="form-control"
													  placeholder="Код поиска туров">{{ $tourSearchForm }}</textarea>

										</div>

										<div class="text-right">
											<button type="submit" class="btn btn-primary">Сохранить <i class="icon-paperplane ml-2"></i></button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	</div>
@endsection
@section('script')
@endsection