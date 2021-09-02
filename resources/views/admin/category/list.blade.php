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
                        <h2>{{ isset($pageTitle) ? $pageTitle : '' }}</h2>
                        <div class="d-flex align-items-center">
                            <a href="@if(isset($parentId)) {{route('qsSubCategoryCreate', encrypt($parentId->id))}} @else {{route('qsCategoryCreate')}} @endif" class="btn btn-primary px-3">{{__('Add New')}}</a>
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
                            <!-- <div class="table-responsive"> -->
                            <table id="category-table" class="table category-table table-bordered  text-center mb-0">
                                <thead>
                                <tr>
                                    <th class="all">{{__('SL.')}}</th>
                                    <th class="all">{{__('Id')}}</th>
                                    <th class="teblete">{{__('Title')}}</th>
                                    @if(empty($parentId)) <th class="teblete">{{__('Sub Category')}}</th> @endif
                                    <th class="desktop">{{__('Questions')}}</th>
                                    <th class="desktop">{{__('Coin')}}</th>
                                    <th class="desktop">{{__('Priority')}}</th>
                                    <th class="desktop">{{__('Added On')}}</th>
                                    <th class="teblete">{{__('Status')}}</th>
                                    <th class="all">{{__('Action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($categories[0]))
                                    @php ($sl = 1)
                                    @foreach($categories as $item)
                                <tr>
                                    <td>{{ $sl++ }}</td>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    @if(empty($parentId))
                                        <td><a href="{{ route('qsSubCategoryList', encrypt($item->id)) }}">
                                                {{ $item->count_sub_category->count() }}
                                            </a>
                                        </td>
                                    @endif
                                    <td>{{ count_question($item->id) }}</td>
                                    <td>{{ $item->coin }}</td>
                                    <td>{{ $item->serial }}</td>
                                    <td>{{ date('d M y', strtotime($item->created_at)) }}</td>
                                    <td><span @if($item->status == 1) class="text-success" @else class="text-danger" @endif>{{ statusType($item->status) }}</span></td>
                                    <td>
                                        <ul class="d-flex justify-content-center">
                                            <a href="{{ route('qsCategoryEdit', $item->id) }}" data-toggle="tooltip" title="Edit"><li class="qz-edit"><span class="flaticon-pencil"></span></li></a>
                                            @if($item->status == STATUS_INACTIVE)
                                                <a href="{{ route('qsCategoryActivate', $item->id) }}" data-toggle="tooltip" title="Activate">
                                                    <li class="ml-2 qz-deactive"><span class="flaticon-check-mark"></span></li>
                                                </a>
                                            @else
                                                <a href="{{ route('qsCategoryDeactivate', $item->id) }}" data-toggle="tooltip" title="Dectivate">
                                                    <li class="ml-2 qz-check"><span class="flaticon-check-mark"></span></li>
                                                </a>
                                            @endif
                                            <a href="{{ route('qsCategoryDelete', $item->id) }}" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure to delete this ?');"><li class="ml-2 qz-close"><span class="flaticon-error"></span></li></a>
                                        </ul>
                                    </td>
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