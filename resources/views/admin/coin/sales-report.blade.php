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
                        <h2>{{ isset($pageTitle) ? $pageTitle : '' }}</h2>
                        <div class="d-flex align-items-center">
                            <span class="sidebarToggler ml-4">
                                <i class="fa fa-bars d-lg-none d-block"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End page title -->
    @include('layout.message')
    <!-- Start content area  -->
    <div class="qz-content-area">
        <div class="card">
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <table id="category-table" class="table category-table table-bordered  text-center mb-0">
                                <thead>
                                <tr>
                                    <th class="all">{{__('SL.')}}</th>
                                    <th class="teblet">{{__('User Name')}}</th>
                                    <th class="desktop">{{__('Coin Name')}}</th>
                                    <th class="desktop">{{__('Amount')}}</th>
                                    <th class="desktop">{{__('Price')}}</th>
                                    <th class="desktop">{{__('Payment Method')}}</th>
                                    <th class="desktop">{{__('Date')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($items[0]))
                                    @php ($sl = 1)
                                    @foreach($items as $item)
                                <tr>
                                    <td>{{ $sl++ }}</td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>{{ $item->coin->name }}</td>
                                    <td>{{ $item->amount }}</td>
                                    <td>{{ $item->price }}$</td>
                                    <td>{{ $item->payment->name }}</td>
                                    <td>{{ date('d M y', strtotime($item->created_at)) }}</td>
                                </tr>
                                @endforeach
                                @else
                                    <tr>
                                        <td colspan="7">{{__('No data found')}}</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
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