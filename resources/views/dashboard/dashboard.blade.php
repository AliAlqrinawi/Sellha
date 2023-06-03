@extends('dashboard.layouts.master')

@section('title', 'Dashborad')


@section('content')
    <div class="row row-sm">
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-primary-gradient">
                <div class="px-3 pt-3  pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">{{ __('USERS COUNT') }}</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 fw-bold mb-1 text-white">{{ App\Models\User::count() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <span id="compositeline" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-danger-gradient">
                <div class="px-3 pt-3  pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">{{ __('ORDERS COUNT') }}</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 fw-bold mb-1 text-white">{{ App\Models\Order::count() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <span id="compositeline2" class="pt-1">3,2,4,6,12,14,8,7,14,16,12,7,8,4,3,2,2,5,6,7</span>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-success-gradient">
                <div class="px-3 pt-3  pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">{{ __('PRODUCTS COUNT') }}</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 fw-bold mb-1 text-white">{{ App\Models\Product::count() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <span id="compositeline3" class="pt-1">5,10,5,20,22,12,15,18,20,15,8,12,22,5,10,12,22,15,16,10</span>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-warning-gradient">
                <div class="px-3 pt-3  pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">{{ __('PRODUCT SOLD') }}</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 fw-bold mb-1 text-white">{{ App\Models\Order::sum('total') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <span id="compositeline4" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
            </div>
        </div>
    </div>
    <div class="row row-sm">
        <div class="col-lg-12 col-md-12">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="main-content-label mg-b-5">
                        {{ __('Scheme of requests and users') }}
                    </div>
                    <p class="mg-b-20">{{ __('The number of requests and users that were completed within a week...') }}</p>
                    <div id="echart2" class="ht-400"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <!--Internal Sparkline js -->
    <script src="{{ asset('dashboard/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <!--Internal Echart Plugin -->
    <script src="{{ asset('dashboard/plugins/echart/echart.js') }}"></script>
    <script src="{{ asset('dashboard/js/echarts.js') }}"></script>
    <script>
        var chartdata2 = [{
            name: 'Users',
            type: 'line',
            smooth: true,
            data: @json($users),
            color: ['#285cf7']
        }, {
            name: 'Orders',
            type: 'line',
            smooth: true,
            size: 10,
            data: @json($orders),
            color: ['#f7557a']
        }];
        var chart2 = document.getElementById('echart2');
        var barChart2 = echarts.init(chart2);
        var option2 = {
            grid: {
                top: '6',
                right: '0',
                bottom: '17',
                left: '25',
            },
            xAxis: {
                data: @json($date),
                splitLine: {
                    lineStyle: {
                        color: 'rgba(171, 167, 167,0.2)'
                    }
                },
                axisLine: {
                    lineStyle: {
                        color: 'rgba(171, 167, 167,0.2)'
                    }
                },
                axisLabel: {
                    fontSize: 10,
                    color: '#5f6d7a'
                }
            },
            tooltip: {
                trigger: 'axis',
                position: ['35%', '32%'],
            },
            yAxis: {
                splitLine: {
                    lineStyle: {
                        color: 'rgba(171, 167, 167,0.2)'
                    }
                },
                axisLine: {
                    lineStyle: {
                        color: 'rgba(171, 167, 167,0.2)'
                    }
                },
                axisLabel: {
                    fontSize: 10,
                    color: '#5f6d7a'
                }
            },
            series: chartdata2,
            color: ['#285cf7', '#f7557a']
        };
        barChart2.setOption(option2);
        window.addEventListener('resize', function() {
            barChart2.resize();
        })
    </script>
@stop
