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
                        <h2>@if (isset($pageTitle)) {{ $pageTitle }} @endif</h2>
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
                        <div class="col-lg-12">
                            <div class="table-responsive category-table">
                                <table class="table category-table text-center rounded">
                                    <thead>
                                    <tr>
                                        <th>{{__('SL.')}}</th>
                                        <th>{{__('Method Name')}}</th>
                                        <th>{{__('Action')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($items[0]))
                                        @php ($sl = 1)
                                        @foreach($items as $item)
                                            <tr>
                                                <td>{{$sl++}}</td>
                                                <td>{{$item->name}}</td>
                                                <td>
                                                    <div>
                                                        <label class="switch">
                                                            <input type="checkbox" onclick="return processForm('{{$item->id}}')"
                                                                   id="notification" name="security" @if($item->status == 1) checked @endif>
                                                            <span class="slider" for="status"></span>
                                                        </label>
                                                        <input type="hidden" name="active_id" value="{{$item->id}}">
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="3">{{__('No data found')}}</td>
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
    </div>
    <!-- End content area  -->
@endsection

@section('script')
    <script>
        function processForm(active_id) {
            console.log(active_id)
            $.ajax({
                type: "POST",
                url: "{{ route('changePaymentMethodStatus') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'active_id': active_id
                },
                success: function (data) {
                    console.log(data);
                }
            });
        }
    </script>
@endsection