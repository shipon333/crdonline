@extends ('layouts.app')
@section('title','Add Device')
@section('content')

    <div id="app">
        <div class="container-fluid dashboard-default-sec">
            <form>
                <div class="row">
                    <!-- Zero Configuration Starts-->
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header bg-primary">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="device-title">
                                            <h5 style="display: inline-block">
                                                Version List of :
                                                <span class="text-warning">{{$device->name}}</span>
                                            </h5>
                                            <button @click="versionAdd" class="btn btn-secondary" type="button" style="float: right;display: inline-block"><i class="fa fa-plus"></i> Add Version </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body" style="margin-top: 20px;">
                                <div class="table-responsive">
                                    <table class="table table-bordered display device">
                                        <thead class="table-primary">
                                        <tr>
                                            <th>Version Name</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="divr in version">
                                            <td>@{{divr.name}}</td>
                                            <td>
                                                <button @click="editVersion(divr)" type="button" title="Version Edit"><i class="fa fa-edit"></i></button>

                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="modal fade" id="versionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form class="add-device">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Version</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label">Version Name*</label>
                                    <input class="form-control" v-model="form.name" type="text" autocomplete="off" required>
                                    <small class="text-danger" v-if="errors.name">@{{errors.name[0]}}</small>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer text-center">
                            <button v-if="form.id == ''" class="btn btn-primary" type="button" @click="storeVersion">Save</button>
                            <button v-else class="btn btn-primary" type="button" @click="updateVersion">Update</button>
                            <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection

@section('required_css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.css" integrity="sha512-0p3K0H3S6Q4bEWZ/WmC94Tgit2ular2/n0ESdfEX8l172YyQj8re1Wu9s/HT9T/T2osUw5Gx/6pAZNk3UKbESw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('custom_css')
    <style>
        .card-block {
            padding: 0px 20px;
        }
        .dashboard-default-sec .card.income-card.card-primary:hover .round-box i {
            color: #fff;
        }
        .device-title {
            margin-bottom: 10px;
        }

        .device-title h5 i {
            font-size: 25px!important;
            margin-right: 20px;
        }
        form.add-device > .row {
            padding: 0px 30px!important;
        }
        table.device tbody tr td button {border: navajowhite;background: no-repeat;outline: none;margin-right: 10px;}

    </style>
@endsection

@section('required_js')
    <script src="https://unpkg.com/vue@3"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.js" integrity="sha512-lOrm9FgT1LKOJRUXF3tp6QaMorJftUjowOWiDcG5GFZ/q7ukof19V0HKx/GWzXCdt9zYju3/KhBNdCLzK8b90Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

@endsection

@section('custom_js')
    <script>
        Vue.createApp({
            data(){
                return{
                    devices:[],
                    version:[],
                    form:{
                        name:'',
                        id:'',
                        device_id:"{{$device->id}}",
                    },
                    pageSelected:false,
                    errors:{}
                }
            },
            mounted(){
                this.getDevice();
                this.getVersion();

            },
            methods:{
                storeVersion(){
                    axios.post('/version',this.form)
                        .then(res=>{
                            if(res.data.status=='success'){
                                new Noty({
                                    type: 'success',
                                    timeout:1000,
                                    text: res.data.message,
                                }).show();
                                this.getVersion();
                                setTimeout(function(){ $('#versionModal').modal('hide'); }, 500);
                                this.reset();
                            } else{
                                new Noty({
                                    type: 'error',
                                    timeout:1000,
                                    text: res.data.message,
                                }).show();

                            }
                        })
                        .catch(error=>{
                            this.errors = error.response.data.errors
                        })
                },
                getVersion(){
                    axios.get('/version?device_id='+this.form.device_id)
                        .then(({data})=>{this.version = data;})
                        .catch(error=>{this.errors = error.response.data.errors})
                },
                getDevice(){
                    axios.get('/all-device-list')
                        .then(({data})=>{
                            this.devices = data;
                        })
                        .catch(error=>{
                            this.errors = error.response.data.errors
                        })
                },
                versionAdd(){
                    setTimeout(function(){ $('#versionModal').modal('show'); }, 500);
                },
                editVersion(data){
                    this.form = data;
                    setTimeout(function(){ $('#versionModal').modal('show'); }, 500);
                },
                updateVersion(){
                    var id = this.form.id;
                    axios.patch('/version/'+id,this.form)
                        .then(res=>{
                            if(res.data.status=='success'){
                                new Noty({
                                    type: 'success',
                                    timeout:1000,
                                    text: res.data.message,
                                }).show();
                                this.getVersion();
                                setTimeout(function(){ $('#versionModal').modal('hide'); }, 500);
                                this.reset();
                            } else{
                                new Noty({
                                    type: 'error',
                                    timeout:1000,
                                    text: res.data.message,
                                }).show();

                            }
                        })
                        .catch(error=>{
                            this.errors = error.response.data.errors
                        })
                },
                reset(){
                    this.form.id = '';
                    this.form.name = '';
                    this.form.device_type_id = '';
                }

            }
        }).mount('#app')
    </script>
@endsection

