@extends ('layouts.app')
@section('title','Create User')
@section('content')

    <div class="container-fluid dashboard-default-sec">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">

                    <div class="card-header bg-primary">
                        <h5>
                            <i class="fa fa-user-plus"></i>
                            Add User Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('user.store') }}" method="post" class="needs-validation" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Location </label><span class="text-danger"> *</span>
                                    <input class="form-control" name="location" type="text" value="{{ old('location') }}" placeholder="User Location" autocomplete="off" required>
                                    <span class="text-danger">{{ $errors->first('location') }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Profile Image</label>
                                    <input class="form-control" name="profile" type="file" autocomplete="off">
                                    <span class="text-danger">{{ $errors->first('profile') }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email </label><span class="text-danger"> *</span>
                                    <input class="form-control" name="email" type="email" value="{{ old('email') }}" placeholder="User Email" autocomplete="off" required>
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Password </label><span class="text-danger">*</span>
                                    <input class="form-control" name="password" type="password" value="{{ old('password') }}" placeholder="Password" autocomplete="off" required>
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Contact Person One </label><span class="text-danger"> *</span>
                                    <input class="form-control" name="name" type="text" value="{{ old('name') }}" placeholder="Contact Person One" autocomplete="off">
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone One</label>
                                    <input class="form-control" name="phone_one" type="text" value="{{ old('phone_one') }}" placeholder="Phone One" autocomplete="off">
                                    <span class="text-danger">{{ $errors->first('phone_one') }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Contact Person Two</label>
                                    <input class="form-control" name="person_two" type="text" value="{{ old('person_two') }}" placeholder="Contact Person Two" autocomplete="off">
                                    <span class="text-danger">{{ $errors->first('person_two') }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone Two</label>
                                    <input class="form-control" name="phone_two" type="text" value="{{ old('phone_two') }}" placeholder="Phone Two" autocomplete="off">
                                    <span class="text-danger">{{ $errors->first('phone_two') }}</span>
                                </div>
                                <div class="col-md-12 text-center">
                                    <button class="btn btn-primary" type="submit">Save</button>
                                    <a href="{{ route('user.index') }}" class="btn btn-danger">Cancel</a>
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
