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
                            <a href="{{route('coinAdd')}}" class="btn btn-primary px-3">{{__('Add New')}}</a>
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
                                    <th class="teblet">{{__('Coin Name')}}</th>
                                    <th class="desktop">{{__('Amount')}}</th>
                                    <th class="desktop">{{__('Available Amount ')}}</th>
                                    <th class="desktop">{{__('Price')}}</th>
                                    <th class="desktop">{{__('Added On')}}</th>
                                    <th class="teblet">{{__('Status')}}</th>
                                    <th class="all">{{__('Action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($items[0]))
                                    @php ($sl = 1)
                                    @foreach($items as $item)
                                <tr>
                                    <td>{{ $sl++ }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->amount }}</td>
                                    <td>{{ $item->amount - $item->sold_amount }}</td>
                                    <td>{{ $item->price }}</td>
                                    <td>{{ date('d M y', strtotime($item->created_at)) }}</td>
                                    <td><span @if($item->is_active == STATUS_ACTIVE) class="text-success" @else class="text-danger" @endif>{{ statusType($item->is_active) }}</span></td>
                                    <td>
                                        <ul class="d-flex justify-content-center">
                                            <a href="{{ route('coinEdit', encrypt($item->id)) }}" data-toggle="tooltip" title="Edit"><li class=" ml-2 qz-edit"><span class="flaticon-pencil"></span></li></a>
                                            @if($item->is_active != STATUS_ACTIVE)
                                                <a href="{{ route('coinActive', encrypt($item->id)) }}" data-toggle="tooltip" title="Make Active" onclick="return confirm('At a time one coin is active. Are you sure to active this coin ?');">
                                                    <li class="ml-2 qz-admin"><span class="flaticon-check-mark"></span></li>
                                                </a>
                                            @endif
                                        </ul>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                    <tr>
                                        <td colspan="4">{{__('No data found')}}</td>
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