@extends ('layouts.app')
@section('title','Compose Email')
@section('content')

    <div id="app">
        <div class="container-fluid dashboard-default-sec">

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">

                        <div class="card-header bg-primary">
                            <h5>
                                <i class="fa fa-envelope"></i>
                                Mail Send
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('email.store') }}" method="post" class="needs-validation">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <div class="email-wrapper">
                                            <form class="theme-form">
                                                <div class="form-group m-t-15 m-checkbox-inline mb-0 custom-radio-ml">
                                                    <h6 class="mb-2">Email Type</h6>
                                                    <div class="radio radio-primary">
                                                        <input id="general" type="radio" name="type" onclick="switchType2()" value="general" checked>
                                                        <label class="mb-0" for="general">General</label>
                                                    </div>
                                                    <div class="radio radio-primary">
                                                        <input id="aanvraagstation" type="radio" onclick="switchType2()" name="type" value="aanvraagstation">
                                                        <label class="mb-0" for="aanvraagstation">Aanvraagstation</label>
                                                    </div>
                                                    <div class="radio radio-primary">
                                                        <input id="pinterminal" type="radio" onclick="switchType2()" name="type" value="pinterminal">
                                                        <label class="mb-0" for="pinterminal">Pinterminal</label>
                                                    </div>
                                                    <div class="radio radio-primary">
                                                        <input id="specific" type="radio" onclick="switchType1()" name="type" value="specific">
                                                        <label class="mb-0" for="specific">Specific Users</label>
                                                    </div>
                                                </div>
                                                <div class="form-group select2-drpdwn" id="user-dropdown"  style="display: none;">
                                                    <label class="col-form-label">To</label>
                                                    <select name="to[]" class="col-sm-12 select2" multiple="multiple">
                                                        @foreach($users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->location }}</option>
                                                        @endforeach
                                                    </select>
                                                    {{--<v-select multiple name="ids" :options="users" />--}}
                                                    <!--<v-select :options="users" taggable multiple name="to"></v-select>-->
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label" for="subject">Subject</label>
                                                    <input class="form-control" id="subject" type="text" name="subject" value="{{ old('subject') }}" required>
                                                    <span class="text-danger">{{ $errors->first('subject') }}</span>
                                                </div>
                                                <div class="form-group">
                                                    <label>Message</label>
                                                    <textarea class="form-control" rows="10" name="message" id="editor" required></textarea>
                                                    <span class="text-danger">{{ $errors->first('message') }}</span>
                                                </div>
                                                <button class="btn btn-success" type="submit">Send Email</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
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


        function switchType1(){
            $('#user-dropdown').show();
        }
        function switchType2(){
            $('#user-dropdown').hide();
        }
    </script>

@endsection
