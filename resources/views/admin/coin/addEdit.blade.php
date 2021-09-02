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
                        <span class="sidebarToggler">
                            <i class="fa fa-bars d-lg-none d-block"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End page title -->
    @include('layout.message_new')
    <!-- Start content area  -->
    <div class="qz-content-area">
        <div class="card add-category">
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            {{ Form::open(['route' => 'coinAddProcess', 'files' => 'true']) }}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                        <label>{{__('Coin Name')}}<span class="text-danger">*</span></label>
                                        <input type="text" name="name" @if(isset($coin)) value="{{$coin->name}}" @else
                                            value="{{old('name')}}" @endif class="form-control" placeholder="{{__('Coin Name')}}">
                                        <span class="text-danger"><strong>{{ $errors->first('name') }}</strong></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('amount') ? ' has-error' : '' }}">
                                        <label>{{__('Amount')}}<span class="text-danger">*</span></label>
                                        <input type="text" @if(isset($coin)) value="{{$coin->amount}}" @else
                                            value="{{old('amount')}}" @endif name="amount" class="form-control" placeholder="{{__('Coin Amount')}}">
                                        <span class="text-danger"><strong>{{ $errors->first('amount') }}</strong></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('price') ? ' has-error' : '' }}">
                                        <label>{{__('Price')}}<span class="text-danger">*</span></label>
                                        <input type="text" @if(isset($coin)) value="{{$coin->price}}" @else
                                            value="{{old('price')}}" @endif name="price" class="form-control" placeholder="{{__('Coin Price')}}">
                                        <span class="text-danger"><strong>{{ $errors->first('price') }}</strong></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    @if(isset($coin))
                                        <input type="hidden" name="edit_id" value="{{$coin->id}}">
                                    @endif
                                    <button type="submit" class="btn btn-primary btn-block add-category-btn">
                                        @if(isset($coin)) {{__('Update')}} @else {{__('Add New')}} @endif
                                    </button>
                                </div>
                            </div>
                            {{ Form::close() }}
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