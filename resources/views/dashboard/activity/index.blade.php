@extends ('layouts.app')
@section('title','Activity List')
@section('content')


    <div id="app">
        {{--@{{ message }}--}}

        <div class="container-fluid dashboard-default-sec">

            <div class="card">
                <div class="card-header bg-primary">
                    <h5 style="display: inline-block;">
                        <i class="fa fa-list"></i>
                        Activity List
                    </h5>
                    {{--<a href="{{ route('user.create') }}" class="btn btn-secondary">Add User</a>--}}
                    @if(auth()->user()->user_type == 'admin')
                    <div class="add-activity-button" style="float: right">
                        <a href="{{route('activity.create')}}" class="btn btn-secondary">Add Activity</a>
                    </div>
                        @endif
                </div>
                <div class="card-block" style="padding: 15px;">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-6 col-12" v-for="activity in activities">
                            <div class="card activity-card">
                                <!--secondary-->
                                <div class="card-header activity" :class="bgStatus(activity.status)"
                                     style="padding: 5px 10px;">
                                    @if(auth()->user()->user_type == 'admin')
                                    <button @click="activityDelete(activity.id)" style="float: left"><i class="fa fa-trash"></i></button>
                                    <a :href="'/activity/'+activity.id+'/edit'" style="float: right"><i class="fa fa-edit"></i></a>
                                    @endif
                                </div>
                                <div class="card-body" style="padding: 10px;">
                                    <div @click="activityDetails(activity)" style="cursor: pointer;">
                                        <ul>
                                            @if(auth()->user()->user_type == 'admin')
                                            <li>
                                                <span><i class="fa fa-location-arrow" aria-hidden="true"></i></span>
                                                <span v-if="activity.user != null">@{{activity.user.location}}</span>
                                            </li>
                                            @endif
                                            <li>
                                                <span><i class="fa fa-desktop" aria-hidden="true"></i></span>
                                                <span v-if="activity.device_type != null">@{{activity.device_type.name}}</span>
                                            </li>
                                            <li>
                                                <span><i class="fa fa-indent" aria-hidden="true"></i></span>
                                                <span>@{{activity.title}}</span>
                                            </li>
                                            <li>
                                                <span><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                                <span>@{{activity.start_date}}</span>
                                            </li>
                                            <li>
                                                <span><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                                <span>@{{activity.end_date}}</span>
                                            </li>
                                        </ul>
                                    </div>
                                    @if(auth()->user()->user_type == 'admin')
                                    <div>
                                        <button v-if="activity.status != 'completed'"
                                                class="btn btn-sm" :class="buttonBg(activity.status)"
                                                @click="updateStatus(activity)" style="float: right;">
                                            <span v-if="activity.status == 'planned'">
                                                <i class="fa fa-forward"></i> Mark as In Progress
                                            </span>
                                            <span v-else="activity.status == 'in_progress'">
                                                <i class="fa fa-check-circle"></i> Mark as Complete
                                            </span>
                                        </button>
                                        <span v-else class="btn btn-sm btn-success" style="float: right;">Completed</span>
                                    </div>
                                        @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Activity</h5>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="needs-validation">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">Title</label>
                                            <input class="form-control" v-model="form.title" type="text" autocomplete="off" required>
                                            <small class="text-danger" v-if="errors.title">@{{errors.title[0]}}</small>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">End Date</label>
                                            <div class="input-group">
                                                <input class="form-control" v-model="form.end_date" type="date" required>
                                            </div>
                                            <small class="text-danger" v-if="errors.end_date">@{{errors.end_date[0]}}</small>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Location</label>
                                            <select class="form-control" v-model="form.user_id" >
                                                <option :value="user.id" v-for="user in users">@{{user.location}}</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Status</label>
                                            <select class="form-control" v-model="form.status">
                                                <option value="planned">Planned</option>
                                                <option value="in_progress">In Progress</option>
                                                <option value="completed">Completed</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Details</label>
                                            <textarea class="form-control" v-model="form.description" cols="30" rows="10" id="editor"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button v-if="form.id == ''" class="btn btn-primary" @click.prevent="addActivity" type="submit" style="float: left">Save</button>
                        <button v-else class="btn btn-primary" @click.prevent="updateActivity(form.id)" type="submit" style="float: left">Update</button>
                        <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="details" class="modal fade activity-details" id="detailsActivity" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Activity Details</h5>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if(auth()->user()->user_type == 'admin')
                        <div class="row" v-if="details.user != null">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-4">
                                <h5>Location</h5>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-8">
                                <p>@{{details.user.location}}</p>
                            </div>
                        </div>
                        @endif

                        <div class="row" v-if="details.device_type != null">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-4">
                                <h5>Device</h5>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-8">
                                <p>@{{details.device_type.name}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-4">
                                <h5>Title</h5>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-8">
                                <p>@{{details.title}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-4">
                                <h5>Start Date</h5>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-8">
                                <p>@{{details.start_date}}</p>
                            </div>
                        </div>
                            <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-4">
                                <h5>End Date</h5>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-8">
                                <p>@{{details.end_date}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-4">
                                <h5>Details</h5>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-8">
                                <p v-html="details.description"></p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('required_css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.css" integrity="sha512-0p3K0H3S6Q4bEWZ/WmC94Tgit2ular2/n0ESdfEX8l172YyQj8re1Wu9s/HT9T/T2osUw5Gx/6pAZNk3UKbESw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

@endsection

@section('custom_css')
    <style>
        .activity-card, .activity-card .card-header{
            border-radius: 8px 8px 0 0;
        }
        .card.activity-card .card-body ul li span:first-child {
            margin-right: 15px;
        }
        .card.activity-card .card-body ul li span i {
            font-size: 18px;
        }
        .card.activity-card .card-body ul li {
            margin-bottom: 10px;
        }
        .activity-details .modal-body h5 {
            font-size: 18px;
            font-weight: 600;
        }
        .card-header.activity a i,
        .card-header.activity button i{color: #fff;}
        .card-header.activity button {
            background: none;
            border: navajowhite;
            outline: none;
        }
    </style>
@endsection

@section('required_js')
    <script src="https://unpkg.com/vue@3"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.js" integrity="sha512-lOrm9FgT1LKOJRUXF3tp6QaMorJftUjowOWiDcG5GFZ/q7ukof19V0HKx/GWzXCdt9zYju3/KhBNdCLzK8b90Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('backend') }}/js/editor/ckeditor/ckeditor.js"></script>
    <script src="{{ asset('backend') }}/js/editor/ckeditor/adapters/jquery.js"></script>
    <script src="{{ asset('backend') }}/js/editor/ckeditor/styles.js"></script>
@endsection

@section('custom_js')
    <script>
        Vue.createApp({
            data(){
                return{
                    users:[],
                    activities:[],
                    details:[],
                    form:{
                        id:'',
                        user_id:'',
                        title:'',
                        end_date:'',
                        description:'',
                        status:''
                    },
                    status:'',
                    id:'',
                    errors:{},
                }
            },
            mounted(){
                this.getActivity();
                this.getUser();
            },
            methods:{
                getUser(){
                    axios.get('user-list')
                        .then(({data})=>(this.users = data))
                        .catch(error => {
                            this.errors = error.response.data.errors

                        })
                },
                editActivity(activity){
                    this.form=activity;
                    setTimeout(function(){ $('#detailsModal').modal('show'); }, 500);
                },
                activityModal(){
                    setTimeout(function(){ $('#detailsModal').modal('show'); }, 500);
                },
                activityDetails(data){
                    this.details=data;
                    setTimeout(function(){ $('#detailsActivity').modal('show'); }, 500);
                },
                updateActivity(id){
                    axios.patch('/activity/'+id,this.form)
                            .then(res => {
                                console.log(res);
                                if(res.data.status=='success'){
                                    new Noty({
                                        type: 'success',
                                        timeout:2000,
                                        theme : 'metroui',
                                        text: 'Activity status updated',
                                    }).show();
                                    setTimeout(function(){ $('#detailsModal').modal('hide'); }, 500);
                                    this.getActivity();
                                    this.reset();
                                } else{
                                    new Noty({
                                        type: 'error',
                                        timeout:2000,
                                        theme : 'metroui',
                                        text: res.data.message,
                                    }).show();
                                    this.getActivity();
                                }
                            }).catch(error => this.errors = error.response.data.errors)

                },
                activityDelete(id){
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            axios.delete('/activity/'+id)
                                .then(() =>{
                                    this.activities = this.activities.filter(activitie=>{
                                        return activitie.id != id
                                    })
                                })
                                .catch(error => this.errors = error.response.data.errors)

                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                        }
                    })
                    // axios.delete('/activity/'+id)
                    //     .then(res => {
                    //         if(res.data.status=='success'){
                    //             new Noty({
                    //                 type: 'success',
                    //                 timeout:2000,
                    //                 theme : 'metroui',
                    //                 text: 'Activity Delete Success full',
                    //             }).show();
                    //             this.getActivity();
                    //         } else{
                    //             new Noty({
                    //                 type: 'error',
                    //                 timeout:2000,
                    //                 theme : 'metroui',
                    //                 text: res.data.message,
                    //             }).show();
                    //             this.getActivity();
                    //         }
                    //     }).catch(error => this.errors = error.response.data.errors)
                },

                updateStatus(data){
                    var request = {
                        status:data.status,
                    };
                    axios.post('/activity-status/'+data.id,request)
                        .then(res => {
                            if(res.data.status=='success'){
                                new Noty({
                                    type: 'success',
                                    timeout:2000,
                                    theme : 'metroui',
                                    text: 'Activity status updated',
                                }).show();
                                this.getActivity();
                            } else{
                                new Noty({
                                    type: 'error',
                                    timeout:2000,
                                    theme : 'metroui',
                                    text: res.data.message,
                                }).show();
                                this.getActivity();
                            }
                        }).catch(error => this.errors = error.response.data.errors)

                },
                getActivity(){
                    axios.get('/activity-list')
                        .then(({data})=>this.activities =data)
                        .catch(error=>{
                            this.errors = error.response.data.errors
                        })
                },
                bgStatus(status){
                    if (status == 'planned'){
                        return 'bg-info';
                    }
                    if(status == 'in_progress'){
                        return 'bg-warning';
                    }
                    if(status == 'completed'){
                        return 'bg-success';
                    }
                },
                buttonBg(status){
                    if (status == 'planned'){
                        return 'btn-secondary';
                    }
                    if(status == 'in_progress'){
                        return 'btn-success';
                    }
                    if(status == 'completed'){
                        return 'btn-success';
                    }
                },
                addActivity(){
                    axios.post('/activity',this.form)
                        .then(res => {

                            if(res.data.status=='success'){
                                new Noty({
                                    type: 'success',
                                    timeout:1000,
                                    text: 'Activity status updated',
                                }).show();
                                this.getActivity();
                                setTimeout(function(){ $('#detailsModal').modal('hide'); }, 500);
                                this.reset();
                            } else{
                                new Noty({
                                    type: 'error',
                                    timeout:1000,
                                    text: res.data.message,
                                }).show();
                                this.getActivity();
                            }
                        }).catch(error => this.errors = error.response.data.errors)
                },
                reset(){
                    this.form.id ='';
                    this.form.user_id ='';
                    this.form.title ='';
                    this.form.description ='';
                    this.form.end_date ='';
                    this.form.status ='';
                    this.errors=''
                }
            }
        }).mount('#app')
    </script>
    {{--<script>--}}
        {{--(function($) {--}}
            {{--CKEDITOR.replace( 'editor', {--}}
                {{--on: {--}}
                    {{--contentDom: function( evt ) {--}}
                        {{--// Allow custom context menu only with table elemnts.--}}
                        {{--evt.editor.editable().on( 'contextmenu', function( contextEvent ) {--}}
                            {{--var path = evt.editor.elementPath();--}}

                            {{--if ( !path.contains( 'table' ) ) {--}}
                                {{--contextEvent.cancel();--}}
                            {{--}--}}
                        {{--}, null, null, 5 );--}}
                    {{--}--}}
                {{--}--}}
            {{--} );--}}


        {{--})(jQuery);--}}

    {{--</script>--}}
@endsection
