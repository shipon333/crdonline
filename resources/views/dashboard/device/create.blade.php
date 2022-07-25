@extends ('layouts.app')
@section('title','Add Device')
@section('content')

    <div class="container-fluid dashboard-default-sec">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-header bg-primary">
                        <h5>
                            <i class="fa fa-plus-circle"></i>
                            Add Device
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('assignDevice.store') }}" method="post" class="needs-validation">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="form-label"><span class="text-danger">If ( Cabled pin Terminal / Mobile Pinterminal ) </span></label>
                                            <input type="checkbox" name="check_cable" id="check_cable">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Device</label> <span class="text-danger"> *</span>
                                            <select class="form-control" name="device_id" id="type" required>
                                                <option value="">Select Device</option>
                                                @foreach($devices as $device)
                                                    <option value="{{ $device->id }}" {{ old('device')==$device->id?'selected':'' }}>{{ $device->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">{{ $errors->first('device') }}</span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Assign To</label> <span class="text-danger"> *</span>
                                            <select class="form-control" name="user_id" id="" required>
                                                <option value="">Select location</option>
                                                @foreach($users as $user)
                                                <option value="{{ $user->id }}" {{ old('user_id')==$user->id?'selected':'' }}>{{ $user->name }} - {{ $user->location }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">{{ $errors->first('user_id') }}</span>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6 not_cable_mobile">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">IP Address</label>
                                            <input class="form-control" name="ip_address" type="text" value="{{ old('ip_address') }}" autocomplete="off">
                                            <span class="text-danger">{{ $errors->first('ip_address') }}</span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Subnet Mask</label>
                                            <input class="form-control" name="subnet_mask" type="text" value="{{ old('subnet_mask') }}" autocomplete="off" >
                                            <span class="text-danger">{{ $errors->first('subnet_mask') }}</span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Standard Gateway</label>
                                            <input class="form-control" name="gateway" value="{{ old('gateway') }}" type="text" autocomplete="off" >
                                            <span class="text-danger">{{ $errors->first('gateway') }}</span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">DNS-achtervoegsellijst</label>
                                            <input class="form-control" name="dns_achtervoegesl" value="{{ old('dns_achtervoegesl') }}" type="text" autocomplete="off" >
                                            <span class="text-danger">{{ $errors->first('dns_achtervoegesl') }}</span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">DNS Server</label>
                                            <input class="form-control" name="dns_1" value="{{ old('dns_1') }}" type="text" autocomplete="off" >
                                            <span class="text-danger">{{ $errors->first('dns_1') }}</span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Alternative DNS server</label>
                                            <input class="form-control" name="dns_2" value="{{ old('dns_2') }}" type="text" autocomplete="off" >
                                            <span class="text-danger">{{ $errors->first('dns_2') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 cable_mobile">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">Terminal Model</label>
                                            <input type="text" class="form-control" name="terminal_model">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Serial Number</label>
                                            <input type="text" class="form-control" name="serial_number">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">SIM Card </label>
                                            <select class="form-control" name="sim_card">
                                                <option value="">Select Sim Card</option>
                                                <option value="Local">Local</option>
                                                <option value="Dutch">Dutch</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Sim Serial Number</label>
                                            <input type="text" class="form-control" name="sim_serial_number">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 text-center">
                                    <button class="btn btn-primary" type="submit">Save</button>
                                    <a href="{{ route('assignDevice.index') }}" class="btn btn-danger">Cancel</a>
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
    <style>
        .cable_mobile {
            display: none;
        }
    </style>
@endsection

@section('required_js')
@endsection

@section('custom_js')
    <script>
        $(document).ready(function() {
            $('#check_cable').on('change', function() {
                if (this.checked) {
                    $('.not_cable_mobile').hide();
                    $('.cable_mobile').show();
                } else {
                    $('.cable_mobile').hide();
                    $('.not_cable_mobile').show();
                }
            });
        });
    </script>
@endsection
