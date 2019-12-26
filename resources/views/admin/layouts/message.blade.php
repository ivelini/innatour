<div class="d-flex align-items-start flex-column flex-md-row">
    <div class="col-md-12">
                @if(session('success'))
                    <div class="alert alert-success border-0 alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        <span class="font-weight-semibold">{{ session()->get('success') }}</span>
                    </div>
                @endif
                @if($errors->isNotEmpty())
                    <div class="alert alert-warning border-0 alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        @foreach($errors->all() as $error)
                            <span class="font-weight-semibold">{{ $error }}</span><br />
                        @endforeach
                    </div>
                @endif
            </div>
</div>