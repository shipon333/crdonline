@extends ('layouts.app')
@section('title','Dashboard')
@section('content')
<div class="container-fluid dashboard-default-sec">
    <div class="row">
        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
            <div class="row">
                <div class="col-xl-6 col-md-6 col-sm-12 col-12">
                    <div class="card profile-greeting">
                        <div class="card-body text-center welcome-back">
                            <h3 class="font-dark">Welcome Back!</h3>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6 col-sm-12 col-12">
                    <div class="card total-device">
                        <div class="row">
                            <div class="col-12">
                                <div class="knob-block text-center text-success mt-4 p-0">
                                    <?php
                                    if($device['total']>0){
                                        $updated = round($device['updated']/$device['total'] * 100);
                                    } else {
                                        $updated=0;
                                    }
                                    ?>
                                    <input class="knob" data-width="150" data-thickness=".3"
                                           data-fgcolor="#008140" data-min="0"
                                           data-displayprevious="false" value="{{ $updated }}"
                                           data-angleOffset="90"
                                           data-linecap="round"
                                           readonly>
                                </div>
                            </div>
                            <div class="col-12 text-center mb-2">
                                <h6><strong>Total Devices : </strong>{{ $device['total'] }}</h6>
                                <h6><strong>Updated Devices : </strong>{{ $device['updated'] }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
            <div class="row individual-device">
                @foreach($device_types as $device_type)

                    <?php
                    if($device_type['total']>0){
                        $_updated = round($device_type['updated']/$device_type['total'] * 100);
                    } else {
                        $_updated=0;
                    }
                    ?>
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12 chart_data_right">
                        <div class="card income-card card-secondary four-device">
                            <div class="card-body align-items-center">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="round-progress knob-block text-center">
                                            <div class="progress-circle">
                                                <input class="knob1" data-width="50" data-height="700"
                                                       data-thickness=".3" data-angleoffset="0"
                                                       data-linecap="round" data-fgcolor="#008140"
                                                       data-bgcolor="#e0e9ea" value="{{ $_updated }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <a href="{{ route('device.category.show',$device_type['id']) }}">
                                            <h6>{{ $device_type['name'] }}</h6>
                                            <p class="total-device"><strong>Total : </strong> {{ $device_type['total'] }}</p>
                                            <p class="update-device"><strong> Updated : </strong>{{ $device_type['updated'] }}</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
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
    <script src="{{ asset('backend') }}/js/chart/knob/knob.min.js"></script>
@endsection

@section('custom_js')
    <script>
        (function($) {
            "use strict";
            $(".knob").knob({
                change : function (value) {
                    //console.log("change : " + value);
                },
                release : function (value) {
                    //console.log(this.$.attr('value'));
                    console.log("release : " + value);
                },
                cancel : function () {
                    console.log("cancel : ", this);
                },
                format : function (value) {
                    return value + '%';
                },
                draw : function () {

                    // "tron" case
                    if(this.$.data('skin') == 'tron') {

                        this.cursorExt = 0.3;

                        var a = this.arc(this.cv)  // Arc
                            , pa                   // Previous arc
                            , r = 1;

                        this.g.lineWidth = this.lineWidth;

                        if (this.o.displayPrevious) {
                            pa = this.arc(this.v);
                            this.g.beginPath();
                            this.g.strokeStyle = this.pColor;
                            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, pa.s, pa.e, pa.d);
                            this.g.stroke();
                        }

                        this.g.beginPath();
                        this.g.strokeStyle = r ? this.o.fgColor : this.fgColor ;
                        this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, a.s, a.e, a.d);
                        this.g.stroke();

                        this.g.lineWidth = 2;
                        this.g.beginPath();
                        this.g.strokeStyle = this.o.fgColor;
                        this.g.arc( this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
                        this.g.stroke();

                        return false;
                    }
                }
            });

            $(".knob1").knob({

                'width':85,
                'height':85,
                'max':100,

                change : function (value) {
                    //console.log("change : " + value);
                },
                release : function (value) {
                    //console.log(this.$.attr('value'));
                    console.log("release : " + value);
                },
                cancel : function () {
                    console.log("cancel : ", this);
                },
                format : function (value) {
                    return value + '%';
                },
                draw : function () {

                    // "tron" case
                    if(this.$.data('skin') == 'tron') {

                        this.cursorExt = 1;

                        var a = this.arc(this.cv)  // Arc
                            , pa                   // Previous arc
                            , r = 1;

                        this.g.lineWidth = this.lineWidth;

                        if (this.o.displayPrevious) {
                            pa = this.arc(this.v);
                            this.g.beginPath();
                            this.g.strokeStyle = this.pColor;
                            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, pa.s, pa.e, pa.d);
                            this.g.stroke();
                        }

                        this.g.beginPath();
                        this.g.strokeStyle = r ? this.o.fgColor : this.fgColor ;
                        this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, a.s, a.e, a.d);
                        this.g.stroke();

                        this.g.lineWidth = 2;
                        this.g.beginPath();
                        this.g.strokeStyle = this.o.fgColor;
                        this.g.arc( this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
                        this.g.stroke();

                        return false;
                    }
                }
            });

        })(jQuery);
    </script>
@endsection
