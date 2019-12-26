@extends('admin.layouts.main')
@section('scripts-for-page')
	<script src="/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script src="/global_assets/js/plugins/notifications/bootbox.min.js"></script>
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
								<li class="nav-item"><a href="#basic-tab1" class="nav-link active" data-toggle="tab">Настройки</a></li>
							</ul>

							<div class="tab-content">
								<div class="tab-pane fade show active" id="basic-tab1">
									<form action="{{ route('manager.system.settings.update') }}" method="POST" enctype="multipart/form-data">
										@csrf
										<div class="card-body">
											<fieldset class="field mb-3">
												<legend class="text-uppercase font-size-sm font-weight-bold">Основные</legend>

												<div class="form-group row">
													<label class="col-form-label col-lg-2">Название сайта</label>
													<div class="col-lg-10">
														<input name="siteName"
															   type="text" class="form-control"
															   value="{{ old('siteName', !empty($data['siteName']) ? $data['siteName'] : '' ) }}">
													</div>
												</div>

												<div class="form-group row">
													<label class="col-form-label col-lg-2">Описание сайта</label>
													<div class="col-lg-10">
														<input name="siteDescription"
															   type="text" class="form-control"
															   value="{{ old('siteDescription', !empty($data['siteDescription']) ? $data['siteDescription'] : '' ) }}">
													</div>
												</div>
											</fieldset>

											<fieldset class="field mb-3">
												<legend class="text-uppercase font-size-sm font-weight-bold">Контактная информация</legend>

												<div class="form-group row">
													<label class="col-form-label col-lg-2">Адресс</label>
													<div class="col-lg-10">
														<input name="siteAddress"
															   type="text" class="form-control"
															   value="{{ old('siteAddress', !empty($data['siteAddress']) ? $data['siteAddress'] : '' ) }}">
													</div>
												</div>

												<div class="form-group row">
													<label class="col-form-label col-lg-2">Телефоны</label>
													<div class="col-lg-10">
														<input name="sitePhones"
															   type="text" class="form-control"
															   value="{{ old('sitePhones', !empty($data['sitePhones']) ? $data['sitePhones'] : '' ) }}">
													</div>
												</div>

												<div class="form-group row">
													<label class="col-form-label col-lg-2">Часы работы</label>
													<div class="col-lg-10">
														<input name="siteClockWork"
															   type="text" class="form-control"
															   value="{{ old('siteClockWork', !empty($data['siteClockWork']) ? $data['siteClockWork'] : '' ) }}">
													</div>
												</div>
											</fieldset>

                                            <fieldset class="field mb-3">
                                                <legend class="text-uppercase font-size-sm font-weight-bold">Социальные сети</legend>

                                                <div class="form-group row">
                                                    <label class="col-form-label col-lg-2">Вконтакте</label>
                                                    <div class="col-lg-10">
                                                        <input name="siteVk"
                                                               type="text" class="form-control"
                                                               value="{{ old('siteVk', !empty($data['siteVk']) ? $data['siteVk'] : '' ) }}">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-form-label col-lg-2">Одноклассники</label>
                                                    <div class="col-lg-10">
                                                        <input name="siteOk"
                                                               type="text" class="form-control"
                                                               value="{{ old('siteOk', !empty($data['siteOk']) ? $data['siteOk'] : '' ) }}">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-form-label col-lg-2">Facebook</label>
                                                    <div class="col-lg-10">
                                                        <input name="siteFb"
                                                               type="text" class="form-control"
                                                               value="{{ old('siteFb', !empty($data['siteFb']) ? $data['siteFb'] : '' ) }}">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-form-label col-lg-2">Instagramm</label>
                                                    <div class="col-lg-10">
                                                        <input name="siteInsta"
                                                               type="text" class="form-control"
                                                               value="{{ old('siteInsta', !empty($data['siteInsta']) ? $data['siteInsta'] : '' ) }}">
                                                    </div>
                                                </div>
                                            </fieldset>
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