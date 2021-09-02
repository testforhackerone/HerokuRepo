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
                    <div class="d-flex justify-content-between">
                        <h2>{{__('Search Result')}}</h2>
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
                            <ul class="qz-src-result">
                                @if(isset($questions) && (!$questions->isEmpty()))
                                    @foreach($questions as $item)
                                        <li><a href="{{ route('questionEdit', $item->id) }}">{{$item->title}}</a></li>
                                    @endforeach
                                @endif
                                @if(isset($users) && (!$users->isEmpty()))
                                    @foreach($users as $item)
                                        <li><a href="{{ route('userDetails', $item->id) }}">{{$item->name}}</a></li>
                                    @endforeach
                                @endif
                                @if(isset($categories) && (!$categories->isEmpty()))
                                    @foreach($categories as $item)
                                        <li><a href="{{ route('categoryQuestionList', $item->id) }}">{{$item->name}}</a></li>
                                    @endforeach
                                @endif
                                @if(($categories->isEmpty()) && ($users->isEmpty()) && ($questions->isEmpty()))
                                    <li class="text-center text-danger">{{__('Data Not Found')}}</li>
                                @endif

                            </ul>
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