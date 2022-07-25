@extends ('layouts.app')
@section('title','Submit Ticket')
@section('content')

    <div class="container-fluid dashboard-default-sec">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">

                    <div class="card-header bg-primary">
                        <h5>
                            <i class="fa fa-support"></i>
                            Support Ticket
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('ticket.store') }}" method="post" class="theme-form row" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="email-wrapper">
                                            <div class="form-group">
                                                <label>Subject</label>
                                                <input class="form-control" type="text" name="subject">
                                                <span class="text-danger">{{ $errors->first('subject') }}</span>
                                            </div>
                                            <div class="form-group">
                                                <label>Upload File</label>
                                                <input class="form-control" name="file" type="file">
                                                <span class="text-danger">{{ $errors->first('file') }}</span>
                                            </div>
                                            <div class="form-group">
                                                <label>Message</label>
                                                <textarea class="form-control" rows="5" name="description" id="editor"></textarea>
                                                <span class="text-danger">{{ $errors->first('description') }}</span>
                                            </div>
                                            <button class="btn btn-success" type="submit">Submit Ticket</button>
                                    </div>
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

