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
                        <h2>{{ isset($pageTitle) ? $pageTitle : 'Users' }}</h2>
                        <div class="d-flex align-items-center">
                            <a href="{{route('addUser')}}" class="btn btn-primary px-3">{{__('Add New')}}</a>
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
                                    <th class="teblet">{{__('Name')}}</th>
                                    <th class="desktop">{{__('Email')}}</th>
                                    <th class="desktop">{{__('Role')}}</th>
                                    <th class="desktop">{{__('Added On')}}</th>
                                    <th class="teblet">{{__('Status')}}</th>
                                    <th class="all">{{__('Action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($users[0]))
                                    @php ($sl = 1)
                                    @foreach($users as $item)
                                <tr>
                                    <td>{{ $sl++ }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ role($item->role) }}</td>
                                    <td>{{ date('d M y', strtotime($item->created_at)) }}</td>
                                    <td><span @if($item->active_status == 1) class="text-success" @else class="text-danger" @endif>{{ statusAction($item->active_status) }}</span></td>
                                    <td>
                                        <ul class="d-flex justify-content-center">
                                            <a href="{{ route('userDetails', $item->id) }}" data-toggle="tooltip" title="User Details"><li class="qz-details"><span class="flaticon-pencil"></span></li></a>
                                            <a href="{{ route('editUser', encrypt($item->id)) }}" data-toggle="tooltip" title="Edit"><li class=" ml-2 qz-edit"><span class="flaticon-pencil"></span></li></a>
                                            @if($item->role == USER_ROLE_USER)
                                                <a href="{{ route('userMakeAdmin', $item->id) }}" data-toggle="tooltip" title="Make Admin" onclick="return confirm('Are you sure to make his/her admin ?');">
                                                    <li class="ml-2 qz-admin"><span class="flaticon-check-mark"></span></li>
                                                </a>
                                            @else
                                                <a href="{{ route('userMakeUser', $item->id) }}" data-toggle="tooltip" title="Make User" onclick="return confirm('Are you sure to make his/her user ?');">
                                                    <li class="ml-2 qz-deactive"><span class="flaticon-check-mark"></span></li>
                                                </a>
                                            @endif
                                            @if($item->active_status == STATUS_DELETED)
                                                <a href="{{ route('userActivate', encrypt($item->id)) }}" data-toggle="tooltip" title="Activate" onclick="return confirm('Are you sure to active ?');">
                                                    <li class="ml-2 qz-check"><span class="flaticon-check-mark"></span></li>
                                                </a>
                                            @else
                                                <a href="{{ route('userDelete', encrypt($item->id)) }}" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure to delete this ?');">
                                                    <li class="ml-2 qz-close"><span class="flaticon-error"></span></li>
                                                </a>
                                            @endif
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