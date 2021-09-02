@extends('layout.master')
@section('title','Admin | Dashboard')
{{--@section('title') @if (isset($pageTitle)) {{ $pageTitle }} @endif @endsection--}}

@section('left-sidebar')
    @include('layout.include.sidebar')
@endsection

@section('header')
    @include('layout.include.header')
@endsection

@section('main-body')
    <!-- Start page title -->
    <div class="qz-page-title">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2>{{__('Dashboard')}}</h2>
                        <span class="sidebarToggler">
                            <i class="fa fa-bars d-lg-none d-block"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End page title -->

    <!-- Start content area  -->
    <div class="qz-content-area">
        <div class="card">
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-6 text-center">
                            <div class="qz-status-bar qz-status-bar1">
                                <h4 class="qz-blance">{{$totalQuestion}}</h4>
                                <h5 class="qz-total-qustions">{{__('Total Questions')}}</h5>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 text-center">
                            <div class="qz-status-bar qz-status-bar2">
                                <h4 class="qz-blance">{{ $totalCategory }}</h4>
                                <h5 class="qz-total-qustions">{{__('Total Categories')}}</h5>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 text-center">
                            <div class="qz-status-bar qz-status-bar3">
                                <h4 class="qz-blance">{{ $totalUser }}</h4>
                                <h5 class="qz-total-qustions">{{__('Active Users')}}</h5>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 text-center">
                            <div class="qz-status-bar qz-status-bar-b">
                                <div class="das-img">
                                    <img src="{{asset('assets/images/icon/total_coin.svg')}}" alt="">
                                </div>
                                <div class="dash-text">
                                    <h4 class="qz-blance">{{ $totalCoin }}</h4>
                                    <h5 class="qz-total-qustions">{{__('Total Coin')}}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 text-center">
                            <div class="qz-status-bar qz-status-bar-b">
                                <div class="das-img">
                                    <img src="{{asset('assets/images/icon/total_sold_coin.svg')}}" alt="">
                                </div>
                                <div class="dash-text">
                                    <h4 class="qz-blance">{{ $totalSale }}</h4>
                                    <h5 class="qz-total-qustions">{{__('Total Sold Coin')}}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 text-center">
                            <div class="qz-status-bar qz-status-bar-b">
                                <div class="das-img">
                                    <img src="{{asset('assets/images/icon/todays_sold_coin.svg')}}" alt="">
                                </div>
                                <div class="dash-text">
                                    <h4 class="qz-blance">{{ $todaySale }}</h4>
                                    <h5 class="qz-total-qustions">{{__('Today\'s Sold Coin')}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="qz-sec-title">
                                <h5>{{__('Monthly Played User')}}</h5>
                            </div>
                            <p class="subtitle">{{__('Current Year')}}</p>
                            <canvas id="myChart"></canvas>
                            <div class="row mt-5">
                                <div class="col-12">
                                    <div class="qz-sec-title">
                                        <h5>{{__('Recently Added Category')}}</h5>
                                    </div>
                                    <div class="table-responsive category-table">
                                        <table class="table category-table text-center rounded">
                                            <thead>
                                            <tr>
                                                <th>{{__('SL.')}}</th>
                                                <th>{{__('Title')}}</th>
                                                <th>{{__('Question')}}</th>
                                                <th>{{__('Added On')}}</th>
                                                <th>{{__('Status')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(isset($categories[0]))
                                                @php ($sl = 1)
                                                @foreach($categories as $item)
                                                    <tr>
                                                        <td>{{$sl++}}</td>
                                                        <td>{{$item->name}}</td>
                                                        <td>{{ count_question($item->id) }}</td>
                                                        <td>{{ date('d M y', strtotime($item->created_at)) }}</td>
                                                        <td><span class="text-success">{{ statusType($item->status) }}</span></td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            <tr class="qz-table-footer">
                                                <td colspan=""><a href="{{ route('qsCategoryCreate') }}"><button class="btn btn-primary px-md-3 px-1">{{__('Add New')}}</button></a></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td colspan=""><h5><a href="{{ route('qsCategoryList') }}">{{__('See All')}}</a></h5></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="qz-laderboard-area">
                                <div class="qz-laderboard-title">
                                    <h4>{{__('Leaderboard')}}</h4>
                                </div>
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>{{__('People')}}</th>
                                        <th>{{__('Score')}}</th>
                                        <th>{{__('Rank')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($leaders[0]))
                                        @php ($sl = 1)
                                        @foreach($leaders as $item)
                                            <tr>
                                                <td align="left">
                                                    <div class="people">
                                                        <img @if(isset($item->user->photo)) src="{{ asset(pathUserImage().$item->user->photo)}}" @else src="{{asset('assets/images/avater.jpg')}}" @endif alt="" class="img-fluid mr-2">
                                                        {{ $item->user->name }}
                                                    </div>
                                                </td>
                                                <td>{{ $item->score }}</td>
                                                <td class="text-center"><span class="text-success">{{ $sl++ }}</span></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                                <div class="qz-laderboard-footer">
                                    <a href="{{ route('leaderBoard') }}">{{__('See More')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-lg-12">
                            <div class="qz-sec-title">
                                <h5>{{__('Monthly Added Question')}}</h5>
                            </div>
                            <p class="subtitle">{{__('Current Year')}}</p>
                            <canvas id="myBarChart"></canvas>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="qz-sec-title">
                                        <h5>{{__('Recently Added Question')}}</h5>
                                    </div>
                                    <div class="table-responsive category-table">
                                        <table class="table category-table text-center rounded">
                                            <thead>
                                            <tr>
                                                <th>{{__('SL.')}}</th>
                                                <th>{{__('Question')}}</th>
                                                <th>{{__('Category')}}</th>
                                                <th>{{__('Added On')}}</th>
                                                <th>{{__('Status')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(isset($questions[0]))
                                                @php ($sl = 1)
                                                @foreach($questions as $question)
                                                    <tr>
                                                        <td>{{$sl++}}</td>
                                                        <td>{{str_limit($question->title,35)}}</td>
                                                        <td>{{$question->qsCategory->name }}</td>
                                                        <td>{{ date('d M y', strtotime($question->created_at)) }}</td>
                                                        <td><span class="text-success">{{ statusType($question->status) }}</span></td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            <tr class="qz-table-footer">
                                                <td colspan=""><a href="{{ route('questionCreate') }}"><button class="btn btn-primary px-md-3 px-1">{{__('Add New')}}</button></a></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td class="" colspan=""><h5><a href="{{ route('questionList') }}">{{__('See All')}}</a></h5></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="qz-sec-title">
                                        <h5>{{__('Monthly Sales Report')}}</h5>
                                    </div>
                                    <p class="subtitle">{{__('Current Year')}}</p>
                                    <canvas id="mySalesChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End content area  -->
@endsection

@section('script')
    <script src="{{asset('assets/js/revenue-chart.js')}}"></script>
    <script>
        var ctx = document.getElementById('myChart').getContext("2d")
        var myChart = new Chart(ctx, {
            type: 'line',
            yaxisname: "Average Monthly Played User",

            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul","Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Played User",
                    borderColor: "#3865f6",
                    pointBorderColor: "#3865f6",
                    pointBackgroundColor: "#3865f6",
                    pointHoverBackgroundColor: "#3865f6",
                    pointHoverBorderColor: "#D1D1D1",
                    pointBorderWidth: 4,
                    pointHoverRadius: 2,
                    pointHoverBorderWidth: 1,
                    pointRadius: 3,
                    fill: false,
                    borderWidth: 1,
                    data: {!! json_encode($monthly_user) !!}
                }]
            },
            options: {
                legend: {
                    position: "bottom",
                    display: true,
                    labels: {
                        fontColor: '#928F8F'
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            fontColor: "#928F8F",
                            fontStyle: "bold",
                            beginAtZero: true,
                            maxTicksLimit: 5,
                            padding: 20
                        },
                        gridLines: {
                            drawTicks: false,
                            display: false
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            zeroLineColor: "transparent"
                        },
                        ticks: {
                            padding: 20,
                            fontColor: "#928F8F",
                            fontStyle: "bold"
                        }
                    }]
                }
            }
        });
    </script>
    <script>
        var ctx = document.getElementById('myBarChart').getContext("2d")
        var myBarChart = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul","Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Questions",
                    backgroundColor: "#007bff",
                    borderColor: "#3865f6",
                    pointBorderColor: "#3865f6",
                    pointBackgroundColor: "#3865f6",
                    pointHoverBackgroundColor: "#3865f6",
                    pointHoverBorderColor: "#D1D1D1",
                    pointBorderWidth: 10,
                    pointHoverRadius: 10,
                    pointHoverBorderWidth: 1,
                    pointRadius: 3,
                    fill: true,
                    borderWidth: 1,
                    data: {!! json_encode($all_questions) !!}
                }]
            },
            options: {
                legend: {
                    position: "bottom",
                    display: true,
                    labels: {
                        fontColor: '#928F8F'
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            fontColor: "#928F8F",
                            fontStyle: "bold",
                            beginAtZero: true,
                            maxTicksLimit: 5,
                            padding: 20
                        },
                        gridLines: {
                            drawTicks: false,
                            display: false
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            zeroLineColor: "#3865f6"
                        },
                        ticks: {
                            padding: 20,
                            fontColor: "#928F8F",
                            fontStyle: "bold"
                        }
                    }]
                }
            }
        });
    </script>
    <script>
        var ctx = document.getElementById('mySalesChart').getContext("2d")
        var mySalesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul","Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Sold Coin",
                    backgroundColor: "#007bff",
                    borderColor: "#3865f6",
                    pointBorderColor: "#3865f6",
                    pointBackgroundColor: "#3865f6",
                    pointHoverBackgroundColor: "#3865f6",
                    pointHoverBorderColor: "#D1D1D1",
                    pointBorderWidth: 10,
                    pointHoverRadius: 10,
                    pointHoverBorderWidth: 1,
                    pointRadius: 3,
                    fill: true,
                    borderWidth: 1,
                    data: {!! json_encode($all_sales) !!}
                }]
            },
            options: {
                legend: {
                    position: "bottom",
                    display: true,
                    labels: {
                        fontColor: '#928F8F'
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            fontColor: "#928F8F",
                            fontStyle: "bold",
                            beginAtZero: true,
                            maxTicksLimit: 5,
                            padding: 20
                        },
                        gridLines: {
                            drawTicks: false,
                            display: false
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            zeroLineColor: "#3865f6"
                        },
                        ticks: {
                            padding: 20,
                            fontColor: "#928F8F",
                            fontStyle: "bold"
                        }
                    }]
                }
            }
        });
    </script>
@endsection