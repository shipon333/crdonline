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
                                    <div class="col-sm-12 col-md-12 col-12">
                                        <div class="device-title">
                                            <h5 style="display: inline-block">
                                                Device List
                                            </h5>

                                        </div>
                                    </div>
                                    <div class="col-sm-8 col-md-8 col-8">
                                        <div class="dropdown" v-if="isselected == true || selectAll == true">
                                            <button @click="statusUpdate(selected)" class="btn btn-secondary button-update" type="button">Update</button>
                                            <button @click="statusNotUpdate(selected)" class="btn btn-danger button-update" type="button">Not Update</button>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-4 col-4">
                                        @if(auth()->user()->user_type != 'user')
                                            <button @click="deviceAdd" class="btn btn-secondary add-device-button" type="button" style="float: right;display: inline-block"><i class="fa fa-plus"></i> Add Device </button>
                                        @endif
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-6">
                                        <select v-model="type" class="form-control">
                                            <option value="">Select device type</option>
                                            <option v-for="type in device_types" :value="type.id">@{{ type.name }}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-6">
                                        <input type="text" v-model="search_text" placeholder="type to search" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="card-body" style="margin-top: 20px;">
                                <div class="table-responsive">
                                    <table class="table table-bordered display device">
                                        <thead class="table-primary">
                                        <tr>
                                            @if(auth()->user()->user_type != 'user')
                                                <th style="width: 15%;">Location</th>
                                            @endif
                                            <th style="width: 15%;">Device Name</th>
                                            <th>Device Type</th>
                                            <th>Status</th>
                                            @if(auth()->user()->user_type != 'user')
                                                <th>
                                                    <input type="checkbox" :disabled="emptyData()" @click="selectAllid"  v-model="selectAll">
                                                    All Select
                                                </th>
                                            @endif
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="device in devices" :key="device.id">
                                            @if(auth()->user()->user_type != 'user')
                                                <td v-if="device.user != null">@{{device.user.location}}</td>
                                            @endif
                                            <td>@{{device.name}}</td>
                                            <td v-if="device.device_type != null">@{{device.device_type.name}}</td>
                                            <td>
                                                <span v-if="device.condition == 1" class="text-success">Update</span>
                                                <span v-else class="text-danger">Not Update</span>
                                            </td>
                                            @if(auth()->user()->user_type != 'user')
                                                <td>
                                                    <input type="checkbox" :value="device.id" v-model="selected">
                                                </td>
                                            @endif
                                            <td>
                                                <button @click="deviceDetails(device)" type="button" title="Device View"><i class="fa fa-eye"></i></button>
                                                @if(auth()->user()->user_type != 'user')
                                                    <button @click="editDevice(device)" type="button" title="Device Edit"><i class="fa fa-edit"></i></button>
                                                    <button @click="deviceDelete(device.id)" type="button" title="Device Delete"><i class="fa fa-trash text-danger"></i></button>
                                                @endif
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

        <div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form class="add-device">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Device</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Device Name </label><span class="text-danger"> *</span>
                                    <input class="form-control" v-model="form.name" type="text" autocomplete="off" required>
                                    <small class="text-danger" v-if="errors.name">@{{errors.name[0]}}</small>

                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Device Type </label><span class="text-danger"> *</span>
                                    <select class="form-control" v-model="form.device_type_id" id="type" required>
                                        <option value="">Select device type</option>
                                        <option :value="device_type.id" v-for="device_type in device_types">@{{ device_type.name }}</option>
                                    </select>
                                    <small class="text-danger" v-if="errors.device_type_id">@{{errors.device_type_id[0]}}</small>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Location</label><span class="text-danger"> *</span>
                                    <select class="form-control" v-model="form.user_id" id="type" required>
                                        <option :value="user.id" v-for="user in users">@{{ user.location }}</option>
                                    </select>
                                    <small class="text-danger" v-if="errors.user_id">@{{errors.user_id[0]}}</small>
                                </div>
                                <div class="col-md-4" v-if="form.device_type_id == 1 || form.device_type_id == 2">
                                    <label class="form-label">IP Address</label>
                                    <input class="form-control" v-model="form.ip_address" type="text" autocomplete="off" >
                                    <small class="text-danger" v-if="errors.ip_address">@{{errors.ip_address[0]}}</small>
                                </div>
                                <div class="col-md-4" v-if="form.device_type_id == 1 || form.device_type_id == 2">
                                    <label class="form-label">Subnet Mask</label>
                                    <input class="form-control" v-model="form.subnet_mask" type="text" autocomplete="off" >
                                    <small class="text-danger" v-if="errors.subnet_mask">@{{errors.subnet_mask[0]}}</small>
                                </div>
                                <div class="col-md-4" v-if="form.device_type_id == 1 || form.device_type_id == 2">
                                    <label class="form-label">DNS Server</label>
                                    <input class="form-control" v-model="form.dns_1" type="text" autocomplete="off" >
                                    <small class="text-danger" v-if="errors.dns_1">@{{errors.dns_1[0]}}</small>
                                </div>
                                <div class="col-md-4" v-if="form.device_type_id == 1 || form.device_type_id == 2">
                                    <label class="form-label">Alternative DNS server</label>
                                    <input class="form-control" v-model="form.dns_2" type="text" autocomplete="off" >
                                    <small class="text-danger" v-if="errors.dns_2">@{{errors.dns_2[0]}}</small>
                                </div>
                                <div class="col-md-4" v-if="form.device_type_id == 1 || form.device_type_id == 2">
                                    <label class="form-label">Standard Gateway</label>
                                    <input class="form-control" v-model="form.gateway" type="text" autocomplete="off" >
                                    <small class="text-danger" v-if="errors.gateway">@{{errors.gateway[0]}}</small>
                                </div>
                                <div class="col-md-4" v-if="form.device_type_id == 1 || form.device_type_id == 2">
                                    <label class="form-label">DNS-achtervoegsellijst</label>
                                    <input class="form-control" v-model="form.dns_achtervoegesl" type="text" autocomplete="off" >
                                    <small class="text-danger" v-if="errors.dns_achtervoegesl">@{{errors.dns_achtervoegesl[0]}}</small>
                                </div>
                                <div class="col-md-6" v-if="form.device_type_id == 3 || form.device_type_id == 4">
                                    <label class="form-label">Terminal Model</label>
                                    <input class="form-control" v-model="form.terminal_model" type="text" autocomplete="off" >
                                    <small class="text-danger" v-if="errors.terminal_model">@{{errors.terminal_model[0]}}</small>
                                </div>
                                <div class="col-md-6" v-if="form.device_type_id == 3 || form.device_type_id == 4">
                                    <label class="form-label">Serial Number</label>
                                    <input class="form-control" v-model="form.serial_number" type="text" autocomplete="off" >
                                    <small class="text-danger" v-if="errors.serial_number">@{{errors.serial_number[0]}}</small>
                                </div>
                                <div class="col-md-6" v-if="form.device_type_id == 3 || form.device_type_id == 4">
                                    <label class="form-label">SIM Card</label>
                                    <input class="form-control" v-model="form.sim_card" type="text" autocomplete="off" >
                                    <small class="text-danger" v-if="errors.sim_card">@{{errors.sim_card[0]}}</small>
                                </div>
                                <div class="col-md-6" v-if="form.device_type_id == 3 || form.device_type_id == 4">
                                    <label class="form-label">Sim Serial Number</label>
                                    <input class="form-control" v-model="form.sim_serial_number" type="text" autocomplete="off" >
                                    <small class="text-danger" v-if="errors.sim_serial_number">@{{errors.sim_serial_number[0]}}</small>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer text-center">
                            <button v-if="form.id == ''" class="btn btn-primary" type="button" @click="storeDevice">Save</button>
                            <button v-else class="btn btn-primary" type="button" @click="updateDevice">Update</button>
                            <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div v-if="details" class="modal fade" id="deviceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Device Information</h5>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <table class="table table-sm table-striped table-bordered">
                            <tr>
                                <td><i class="fa fa-laptop"></i> <strong>Name : </strong></td>
                                <td>@{{ details.name }}</td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-tag"></i> <strong>Type : </strong></td>
                                <td v-if="details.device_type != null">@{{ details.device_type.name }}</td>
                            </tr>
                            <tr v-if="details.device_type_id == 3 || details.device_type_id == 4">
                                <td><i class="fa fa-tag"></i> <strong>Terminal Model : </strong></td>
                                <td>@{{ details.terminal_model }}</td>
                            </tr>
                            <tr v-if="details.device_type_id == 3 || details.device_type_id == 4">
                                <td><i class="fa fa-tag"></i> <strong>Serial Number : </strong></td>
                                <td>@{{ details.serial_number }}</td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-adjust"></i> <strong>Condition : </strong></td>
                                <td>
                                    <span v-if="details.condition == 1" class="text-success">Updated</span>
                                    <span v-else class="text-danger">Not Updated</span>
                                </td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-calendar"></i> <strong>Last Updated : </strong></td>
                                <td v-if="details.condition == 1">@{{ details.last_updated }}</td>
                            </tr>
                            <tr v-if="details.device_type_id == 3 || details.device_type_id == 4">
                                <td><i class="fa fa-calendar"></i> <strong>Sim Card : </strong></td>
                                <td>@{{ details.sim_card }}</td>
                            </tr>
                            <tr v-if="details.device_type_id == 3 || details.device_type_id == 4">
                                <td><i class="fa fa-calendar"></i> <strong>Sim Serial Number : </strong></td>
                                <td>@{{ details.sim_serial_number }}</td>
                            </tr>
                            <tr v-if="details.device_type_id == 1 || details.device_type_id == 2">
                                <td><i class="fa fa-wifi"></i> <strong>IP Adres : </strong></td>
                                <td>@{{ details.ip_address }}</td>
                            </tr>
                            <tr v-if="details.device_type_id == 1 || details.device_type_id == 2">
                                <td><i class="fa fa-circle-o-notch"></i> <strong>Subnet mask : </strong></td>
                                <td>@{{ details.subnet_mask }}</td>
                            </tr>
                            <tr v-if="details.device_type_id == 1 || details.device_type_id == 2">
                                <td><i class="fa fa-neuter"></i> <strong>Standard Gateway : </strong></td>
                                <td>@{{ details.gateway }}</td>
                            </tr>
                            <tr v-if="details.device_type_id == 1 || details.device_type_id == 2">
                                <td><i class="fa fa-server"></i> <strong>DNS Server : </strong></td>
                                <td>@{{ details.dns_1 }}</td>
                            </tr>
                            <tr v-if="details.device_type_id == 1 || details.device_type_id == 2">
                                <td><i class="fa fa-server"></i> <strong>Alternative DNS Server : </strong></td>
                                <td>@{{ details.dns_2 }}</td>
                            </tr>
                            <tr v-if="details.device_type_id == 1 || details.device_type_id == 2">
                                <td><i class="fa fa-server"></i> <strong>DNS-achtervoegsellijst : </strong></td>
                                <td>@{{ details.dns_achtervoegesl }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Close</button>
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
        .card-block {
            padding: 0px 20px;
        }
        .dashboard-default-sec .card.income-card.card-primary:hover .round-box i {
            color: #fff;
        }
        .device-title {
            margin-bottom: 10px;
        }
        .add-device-button {
            padding: 6px 10px;
        }
        .device-title h5 i {
            font-size: 25px!important;
            margin-right: 20px;
        }
        .button-update {padding: 6px 9px;}

        .button-update:first-child {margin-right: 15px;}
        table.device tbody tr td button {border: navajowhite;background: no-repeat;outline: none;margin-right: 10px;}
        form.add-device > .row {
            padding: 0px 30px!important;
        }
        .button-update {
            margin-right: 15px;
            margin-bottom: 11px;
        }
        .add-device-button {
            margin-bottom: 11px;
        }
        @media only screen and (min-width: 1200px){
            .button-update {
                margin-right: 15px;
                margin-bottom: 11px;
            }
            .add-device-button {
                margin-bottom: 11px;
            }
        }

        @media (min-width: 992px) and (max-width: 1199.98px){
            .button-update {
                margin-right: 15px;
                margin-bottom: 11px;
            }
            .add-device-button {
                margin-bottom: 11px;
            }
        }
        @media (min-width: 768px) and (max-width: 991.98px){
            .button-update {
                margin-right: 15px;
                margin-bottom: 11px;
            }
            .add-device-button {
                padding: 6px 6px;
                font-size: 12px;
            }
        }

        @media (min-width: 576px) and (max-width: 767.98px) {
            .button-update {
                margin-right: 15px;
                margin-bottom: 11px;
            }
            .add-device-button {
                padding: 6px 6px;
                font-size: 12px;
            }
            .button-desktop-device {
                display: none;
            }
            .button-mobile-device {
                display: block;
                margin-bottom: 14px;
            }
        }
        @media (min-width: 480px) and (max-width: 575.98px){
            .button-update {
                margin-right: 15px;
                margin-bottom: 11px;
            }
            .add-device-button {
                padding: 6px 6px;
                font-size: 12px;
            }
            .button-desktop-device {
                display: none;
            }
            .button-mobile-device {
                display: block;
                margin-bottom: 14px;
            }
        }
        @media (min-width: 420px) and (max-width: 479px){
            .button-update {
                margin-right: 15px;
                margin-bottom: 11px;
            }
            .add-device-button {
                padding: 6px 6px;
                font-size: 12px;
            }
            .button-desktop-device {
                display: none;
            }
            .button-mobile-device {
                display: block;
                margin-bottom: 14px;
            }

        }
        @media (min-width: 320px) and (max-width: 419px){

            .button-update {
                margin-right: 15px;
                margin-bottom: 11px;
            }
            .add-device-button {
                padding: 6px 6px;
                font-size: 12px;
            }
            .button-desktop-device {
                display: none;
            }
            .button-mobile-device {
                display: block;
                margin-bottom: 14px;
            }
        }

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
                    selected: [],
                    selectAll: false,
                    isselected: false,
                    devices:[],
                    details:[],
                    allDevices:[],
                    users:[],
                    device_types:'',
                    search_text:'',
                    type:'',
                    form:{
                        name:'',
                        id:'',
                        device_type_id:'',
                        user_id:'',
                        ip_address:'',
                        subnet_mask:'',
                        gateway:'',
                        dns_1:'',
                        dns_2:'',
                        dns_achtervoegesl:'',
                        terminal_model:'',
                        serial_number:'',
                        sim_card:'',
                        sim_serial_number:''
                    },
                    pageSelected:false,
                    errors:{}
                }
            },
            mounted(){
                this.getTypes();
                this.getDevice();
                this.getUsers()
            },
            watch:{
                type:function(val){
                    this.getDevice();
                },
                search_text:function(val){
                    this.getDevice();
                },
                pageSelected:function(value){
                    if(value){
                        this.devices.data.forEach(device =>{
                            this.select.push(device.id)
                        });
                    }
                    else{
                        this.select = [];
                    }
                },
                selected: function(select){
                    this.isselected = (select.length > 0);
                    this.selectAll =(select.length === this.devices.length);
                },
            },
            methods:{
                storeDevice(){
                    axios.post('/device',this.form)
                        .then(res=>{
                            if(res.data.status=='success'){
                                new Noty({
                                    type: 'success',
                                    timeout:1000,
                                    text: res.data.message,
                                }).show();
                                this.getDevice();
                                setTimeout(function(){ $('#detailsModal').modal('hide'); }, 500);
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
                getTypes(){
                    axios.get('/device-types')
                        .then(({data})=>{
                            this.device_types = data;
                        })
                        .catch(error=>{
                            this.errors = error.response.data.errors
                        })
                },
                getUsers(){
                    axios.get('/user-list')
                        .then(({data})=>{
                            this.users = data;
                        })
                        .catch(error=>{
                            this.errors = error.response.data.errors
                        })
                },
                deviceAdd(){
                    setTimeout(function(){ $('#detailsModal').modal('show'); }, 500);
                },
                deviceDetails(data){
                    this.details=data;
                    console.log(this.details);
                    setTimeout(function(){ $('#deviceModal').modal('show'); }, 500);


                },
                getDevice(){
                    var request = {
                        type:this.type,
                        search_text: this.search_text
                    }
                    axios.get('/all-device-list',{params:request})
                        .then(({data})=>this.devices =data)
                        .catch(error=>{
                            this.errors = error.response.data.errors
                        })
                },
                editDevice(data){
                    this.form = data;
                    setTimeout(function(){ $('#detailsModal').modal('show'); }, 500);
                },
                emptyData(){
                    return (this.devices.length < 1)
                },
                selectAllid(event) {
                    if(event.target.checked === false){
                        this.selected= [];
                    }else{
                        this.devices.forEach((device)=>{
                            if (this.selected.indexOf()=== -1){
                                this.selected.push(device.id);
                            }

                        })
                    }
                },
                statusUpdate(select){
                    axios.post('/device-update',{data: select})
                        .then(res=>{
                            if(res.data.status=='success'){
                                new Noty({
                                    type: 'success',
                                    timeout:1000,
                                    text: res.data.message,
                                }).show();
                                this.selected= [];
                                this.selectAll= false;
                                this.isselected= false;
                                this.getDevice();
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
                statusNotUpdate(select){
                    axios.post('/device-not-update',{data: select})
                        .then(res=>{
                            if(res.data.status=='success'){
                                new Noty({
                                    type: 'success',
                                    timeout:1000,
                                    text: res.data.message,
                                }).show();
                                this.selected= [];
                                this.selectAll= false;
                                this.isselected= false;
                                this.getDevice();
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
                updateDevice(){
                    var id = this.form.id;
                    axios.patch('/device/'+id,this.form)
                        .then(res=>{
                            if(res.data.status=='success'){
                                new Noty({
                                    type: 'success',
                                    timeout:1000,
                                    text: res.data.message,
                                }).show();
                                this.reset();
                                this.getDevice();
                                setTimeout(function(){ $('#detailsModal').modal('hide'); }, 500);
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
                deviceDelete(id){
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
                            axios.delete('/device/'+id)
                                .then(() =>{
                                    this.devices = this.devices.filter(device=>{
                                        return device.id != id
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
                },
                reset(){
                    this.form.id = '';
                    this.form.name = '';
                    this.form.device_type_id = '';
                    this.user_id='';
                    this.ip_address='';
                    this.subnet_mask='';
                    this.gateway='';
                    this.dns_1='';
                    this.dns_2='';
                    this.dns_achtervoegesl='';
                    this.terminal_model='';
                    this.serial_number='';
                    this.sim_card='';
                    this.sim_serial_number='';                }

            }
        }).mount('#app')
    </script>
@endsection

