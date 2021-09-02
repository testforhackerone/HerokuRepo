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
                        <h2>{{__('Question')}}</h2>
                        <div class="d-flex align-items-center">
                            <a href="{{asset('assets/demo-file.xlsx')}}" download class="btn btn-warning px-3" style="color:#fff;">
                                <i class="fa fa-download"></i><span class="ml-1">{{__('Demo File')}}</span>
                            </a>
                            <a href="{{ route('qsExcelUpload') }}" class="ml-2 btn btn-success px-3">
                                <i class="fa fa-upload"></i><span class="ml-1">{{__('Excel Upload')}}</span>
                            </a>
                            <a href="{{ route('questionCreate') }}" class="ml-2 btn btn-primary px-3">{{__('Add New')}}</a>
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
                            <div class="">
                                <table id="qz-question-table" class="table category-table table-bordered  text-center mb-0">
                                    <thead>
                                    <tr>
                                        <th>{{__('Sl.')}}</th>
                                        <th>{{__('Category')}}</th>
                                        <th>{{__('Question')}}</th>
                                        <th>{{__('Answer')}}</th>
                                        <th>{{__('Point')}}</th>
                                        <th>{{__('Status')}}</th>
                                        <th>{{__('Action')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($items[0]))
                                        @php ($sl = 1)
                                        @foreach($items as $item)
                                            <tr>
                                                <td>{{ $sl++ }}</td>
                                                <td>{{ $item->qsCategory->name }}</td>
                                                <td>{{ str_limit($item->title,30) }}</td>
                                                <td>{{ answers($item->id) }}</td>
                                                <td>{{ $item->point }}</td>
                                                <td><span @if($item->status == 1) class="text-success" @else class="text-danger" @endif>{{ statusType($item->status) }}</span></td>
                                                <td>
                                                    <ul class="d-flex justify-content-center">
                                                        <a href="{{ route('questionEdit', $item->id) }}" data-toggle="tooltip" title="Edit"><li class="qz-edit"><span class="flaticon-pencil"></span></li></a>
                                                        @if($item->status == STATUS_INACTIVE)
                                                            <a href="{{ route('questionActivate', $item->id) }}" data-toggle="tooltip" title="Activate">
                                                                <li class="ml-2 qz-deactive"><span class="flaticon-check-mark"></span></li>
                                                            </a>
                                                        @else
                                                            <a href="{{ route('questionDectivate', $item->id) }}" data-toggle="tooltip" title="Dectivate">
                                                                <li class="ml-2 qz-check"><span class="flaticon-check-mark"></span></li>
                                                            </a>
                                                        @endif
                                                        <a href="{{ route('questionDelete', $item->id) }}" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure to delete this ?');"><li class="ml-2 qz-close"><span class="flaticon-error"></span></li></a>
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
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
@endsection