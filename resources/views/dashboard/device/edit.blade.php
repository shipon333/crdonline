@extends ('layouts.app')
@section('title','Edit Device')
@section('content')

    <div class="container-fluid dashboard-default-sec">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-header bg-primary">
                        <h5>
                            <i class="fa fa-edit"></i>
                            Edit Device
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('assignDevice.update',$assignes->id) }}" method="post" class="needs-validation">
                            @csrf @method('put')
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">

                                            <label class="form-label"><span class="text-danger">If ( Cabled pin Terminal / Mobile Pinterminal ) </span></label>
                                            <input type="checkbox" name="check_cable" value="{{$assignes->cable_mobile}}" id="check_cable" {{ $assignes->cable_mobile == 1 ? 'checked':'' }}>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Device</label>
                                            <select class="form-control" name="device_id" id="type" required>
                                                <option value="">Select Device</option>
                                                @foreach($devices as $device)
                                                    <option value="{{ $device->id }}" {{ $assignes->device_id ==$device->id?'selected':'' }}>{{ $device->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">{{ $errors->first('device') }}</span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Assign To</label>
                                            <select class="form-control" name="user_id" id="" required>
                                                <option value="">Select location</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}" {{ $assignes->user_id == $user->id?'selected':'' }}>{{ $user->name }} - {{ $user->location }}</option>
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
                                            <input class="form-control" name="ip_address" type="text" value="{{ $assignes->ip_address }}" autocomplete="off">
                                            <span class="text-danger">{{ $errors->first('ip_address') }}</span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Subnet Mask</label>
                                            <input class="form-control" name="subnet_mask" type="text" value="{{ $assignes->subnet_mask }}" autocomplete="off" >
                                            <span class="text-danger">{{ $errors->first('subnet_mask') }}</span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Standard Gateway</label>
                                            <input class="form-control" name="gateway" value="{{ $assignes->gateway }}" type="text" autocomplete="off" >
                                            <span class="text-danger">{{ $errors->first('gateway') }}</span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">DNS-achtervoegsellijst</label>
                                            <input class="form-control" name="dns_achtervoegesl" value="{{ $assignes->dns_achtervoegesl}}" type="text" autocomplete="off" >
                                            <span class="text-danger">{{ $errors->first('dns_achtervoegesl') }}</span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">DNS Server</label>
                                            <input class="form-control" name="dns_1" value="{{ $assignes->dns_1 }}" type="text" autocomplete="off" >
                                            <span class="text-danger">{{ $errors->first('dns_1') }}</span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Alternative DNS server</label>
                                            <input class="form-control" name="dns_2" value="{{ $assignes->dns_2 }}" type="text" autocomplete="off" >
                                            <span class="text-danger">{{ $errors->first('dns_2') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 cable_mobile">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">Terminal Model</label>
                                            <input type="text" class="form-control" value="{{ $assignes->terminal_model }}" name="terminal_model">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Serial Number</label>
                                            <input type="text" value="{{ $assignes->serial_number }}" class="form-control" name="serial_number">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">SIM Card </label>
                                            <select class="form-control" name="sim_card">
                                                <option value="">Select Sim Card</option>
                                                <option value="Local"  {{ $assignes->sim_card == 'Local'?'selected':'' }}>Local</option>
                                                <option value="Dutch"  {{ $assignes->sim_card == 'Dutch'?'selected':'' }}>Dutch</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Sim Serial Number</label>
                                            <input type="text" class="form-control" value="{{ $assignes->sim_serial_number }}" name="sim_serial_number">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 text-center">
                                    <button class="btn btn-primary" type="submit">Update</button>
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
        var check = $('#check_cable').val();
        console.log(check);
        if (check == 1) {
            $('.not_cable_mobile').hide();
            $('.cable_mobile').show();
        } else {
            $('.cable_mobile').hide();
            $('.not_cable_mobile').show();
        }
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
