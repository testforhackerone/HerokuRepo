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
                            @if(isset($user))
                                {{ Form::open(['route' => 'userUpdateProcess', 'files' => 'true']) }}
                            @else
                                {{ Form::open(['route' => 'userAddProcess', 'files' => 'true']) }}
                            @endif
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                        <label>{{__('User Name')}}<span class="text-danger">*</span></label>
                                        <input type="text" name="name" @if(isset($user)) value="{{$user->name}}" @else value="{{old('name')}}" @endif
                                            class="form-control" placeholder="User Name">
                                        <span class="text-danger"><strong>{{ $errors->first('name') }}</strong></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label>{{__('Email')}}<span class="text-danger">*</span></label>
                                        @if(isset($user))
                                            <span class="form-control for-email">{{$user->email}}</span>
                                        @else
                                            <input type="email" name="email" value="{{old('email')}}" class="form-control" placeholder="Email Address">
                                        @endif
                                        <span class="text-danger"><strong>{{ $errors->first('email') }}</strong></span>
                                    </div>
                                </div>
                                @if(empty($user))
                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                                            <label>{{__('Password')}}<span class="text-danger">*</span></label>
                                            <input type="password" name="password" class="form-control" placeholder="Password">
                                            <span class="text-danger"><strong>{{ $errors->first('password') }}</strong></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                            <label>{{__('Confirm Password')}}<span class="text-danger">*</span></label>
                                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
                                            <span class="text-danger"><strong>{{ $errors->first('password_confirmation') }}</strong></span>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('role') ? ' has-error' : '' }}">
                                        <label>{{__('Role')}}<span class="text-danger">*</span></label>
                                        <div class="qz-question-category">
                                            <select name="role" class="form-control">
                                                <option value="">{{__('Select Role')}}</option>
                                                @foreach(role() as $key => $value)
                                                    <option @if(isset($user) && ($user->role == $key)) selected
                                                            @elseif((old('role') != null) && (old('role') == $key)) selected @endif
                                                            value="{{ $key }}">{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <span class="text-danger"><strong>{{ $errors->first('role') }}</strong></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('country') ? ' has-error' : '' }}">
                                        <label>{{__('Country')}}<span class="text-danger"></span></label>
                                        <input type="text" name="country" @if(isset($user)) value="{{$user->country}}" @else value="{{old('country')}}" @endif
                                        class="form-control" placeholder="Country">
                                        {{--<div class="qz-question-category">--}}
                                            {{--<select name="country" class="form-control">--}}
                                                {{--<option value="">{{__('Select Country')}}</option>--}}
                                                {{--@foreach(country() as $key => $value)--}}
                                                    {{--<option @if(isset($user) && ($user->country == $key)) selected--}}
                                                            {{--@elseif((old('country') != null) && (old('country') == $key)) selected @endif--}}
                                                            {{--value="{{ $key }}">{{$value}}</option>--}}
                                                {{--@endforeach--}}
                                            {{--</select>--}}
                                        {{--</div>--}}
                                        <span class="text-danger"><strong>{{ $errors->first('country') }}</strong></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    @if(isset($user))
                                        <input type="hidden" name="edit_id" value="{{$user->id}}">
                                        @endif
                                    <button type="submit" class="btn btn-primary btn-block add-category-btn">
                                        @if(isset($user)) {{__('Update')}} @else {{__('Add New')}} @endif
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