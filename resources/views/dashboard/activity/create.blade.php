@extends ('layouts.app')
@section('title','Add Activity')
@section('content')

    <div class="container-fluid dashboard-default-sec">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-header bg-primary">
                        <h5>
                            <i class="fa fa-plus-circle"></i>
                            Add Activity
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('activity.store') }}" method="post" class="needs-validation">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="form-label">Title</label>
                                            <input class="form-control" name="title" type="text" autocomplete="off">
                                            <span class="text-danger">{{ $errors->first('title') }}</span>
                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-label">Start Date</label>
                                            <div class="input-group">
                                                <input class="form-control" name="start_date" type="date">
                                            </div>
                                            <span class="text-danger">{{ $errors->first('start_date') }}</span>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">End Date</label>
                                            <div class="input-group">
                                                <input class="form-control" name="end_date" type="date">
                                            </div>
                                            <span class="text-danger">{{ $errors->first('end_date') }}</span>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Location</label>
                                            <select class="form-control" name="user_id" >
                                                <option value="">Select Location</option>
                                                @foreach($locations as $location)
                                                    <option value="{{$location->id}}">{{$location->location}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">{{ $errors->first('user_id') }}</span>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Device Type</label>
                                            <select class="form-control" name="device_type_id">
                                                <option value="">Select Device Type</option>
                                                @foreach($devices as $device)
                                                    <option value="{{$device->id}}">{{$device->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">{{ $errors->first('device_id') }}</span>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Status</label>
                                            <select class="form-control" name="status">
                                                <option value="planned">Planned</option>
                                                <option value="in_progress">In Progress</option>
                                                <option value="completed">Completed</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Details</label>
                                    <textarea class="form-control" name="description" cols="30" rows="10" id="editor"></textarea>
                                </div>
                                <div class="col-md-12 text-center">
                                    <button class="btn btn-primary" type="submit">Save</button>
                                    <a href="{{ route('activity.index') }}" class="btn btn-danger">Cancel</a>
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
    <script src="{{ asset('backend') }}/js/editor/ckeditor/ckeditor.js"></script>
    <script src="{{ asset('backend') }}/js/editor/ckeditor/adapters/jquery.js"></script>
    <script src="{{ asset('backend') }}/js/editor/ckeditor/styles.js"></script>
@endsection

@section('custom_js')
    <script>
        (function($) {
            CKEDITOR.replace( 'editor', {
                on: {
                    contentDom: function( evt ) {
                        // Allow custom context menu only with table elemnts.
                        evt.editor.editable().on( 'contextmenu', function( contextEvent ) {
                            var path = evt.editor.elementPath();

                            if ( !path.contains( 'table' ) ) {
                                contextEvent.cancel();
                            }
                        }, null, null, 5 );
                    }
                }
            } );


            setTimeout(function() {
                $(".select2").select2();
            },300);

        })(jQuery);

    </script>
@endsection
