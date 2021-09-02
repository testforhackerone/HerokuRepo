@extends('layout.master')
@section('title') @if (isset($pageTitle)) {{ $pageTitle }} @endif @endsection

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
                        <h2>{{__('Leader Board')}}</h2>
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
                        <div class="col-12">
                            <!-- <div class="table-responsive"> -->
                            <table id="category-table" class="table category-table table-bordered  text-center mb-0">
                                <thead>
                                <tr>
                                    <th>{{__('SL.')}}</th>
                                    <th>{{__('People')}}</th>
                                    <th>{{__('Score')}}</th>
                                    <th>{{__('Coin')}}</th>
                                    <th>{{__('Rank')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($leaders))
                                    @php ($sl = 1)
                                    @php ($rank = 1)
                                    @foreach($leaders as $item)
                                        <tr>
                                            <td>{{ $sl++ }}</td>
                                            <td align="left">
                                                <div class="people">
                                                    <img @if(isset($item->user->photo)) src="{{ asset(pathUserImage().$item->user->photo)}}" @else src="{{asset('assets/images/avater.jpg')}}" @endif alt="" class="img-fluid mr-2">
                                                    {{ $item->user->name }}
                                                </div>
                                            </td>
                                            <td>{{ $item->score }}</td>
                                            <td>@if(isset($item->user->userCoin->coin)){{ $item->user->userCoin->coin }} @else 0 @endif</td>
                                            <td class="text-center"><span class="text-success">{{ $rank++ }}</span></td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                            <!-- </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End content area  -->
@endsection

@section('script')
@endsection