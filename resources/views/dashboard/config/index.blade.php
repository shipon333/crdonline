@extends ('layouts.app')
@section('title','Site Settings')
@section('content')

    <div class="container-fluid dashboard-default-sec">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">

                    <div class="card-header bg-primary">
                        <h5>
                            <i class="fa fa-cogs"></i>
                            General Settings
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('config.store') }}" method="post" class="needs-validation" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="col-form-label" for="company_name">Company Name</label>
                                    <input name="company_name" value="{{ setting('company_name') }}" class="form-control" id="company_name" type="text">
                                    <span class="text-danger">{{ $errors->first('company_name') }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label" for="logo">Logo</label>
                                    <img src="{{ asset('backend') }}/images/{{ setting('logo') }}" alt="" width="100">
                                    <input name="logo" class="form-control" type="file">
                                    <span class="text-danger">{{ $errors->first('logo') }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label" for="favicon">Favicon</label>
                                    <img src="{{ asset('backend') }}/images/{{ setting('favicon') }}" alt="" width="32">
                                    <input name="favicon" class="form-control" id="favicon" type="file">
                                    <span class="text-danger">{{ $errors->first('favicon') }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label" for="email">Email</label>
                                    <input name="email" value="{{ setting('email') }}" class="form-control" id="email" type="email">
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label" for="phone">Phone</label>
                                    <input name="phone" value="{{ setting('phone') }}" class="form-control" id="phone" type="text">
                                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                                </div>
                                <div class="col-md-12">
                                    <label class="col-form-label" for="address">Address</label>
                                    <input name="address" value="{{ setting('address') }}" class="form-control" id="address" type="text">
                                    <span class="text-danger">{{ $errors->first('address') }}</span>
                                </div>
                                <div class="col-md-12 text-center">
                                    <button class="btn btn-success" type="submit">Save Settings</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('required_css')
@endsection

@section('custom_css')
@endsection

@section('required_js')
@endsection

@section('custom_js')
@endsection
