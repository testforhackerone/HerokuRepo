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
                            {{ Form::open(['route' => 'qsCategorySave', 'files' => 'true']) }}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                        <label>{{__('Title')}}<span class="text-danger">*</span></label>
                                        <input type="text" name="name" @if(isset($category)) value="{{$category->name}}" @else value="{{old('name')}}" @endif class="form-control" placeholder="Title">
                                        @if ($errors->has('name'))
                                            <span class="text-danger">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('Parent Category')}}<span class="text-danger"></span></label>
                                        <div class="qz-question-category">
                                            <select name="parent_id" class="form-control">
                                                <option value="">{{__('Parent Category')}}</option>
                                                @if (isset($parentCategories[0]))
                                                    @foreach($parentCategories as $value)
                                                        <option @if(isset($category) && ($category->parent_id == $value->id)) selected
                                                                @elseif(isset($parentId) && ($parentId->id == $value->id)) selected
                                                                @elseif((old('parent_id') != null) && (old('parent_id') == $value->id)) selected @endif value="{{ $value->id }}">{{$value->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('Coin')}}<span class="text-danger"></span></label>
                                        <input type="text" @if(isset($category)) value="{{$category->coin}}" @else value="{{old('coin')}}" @endif name="coin" class="form-control" placeholder="Coin">
                                        @if ($errors->has('coin'))
                                            <span class="text-danger">
                                            <strong>{{ $errors->first('coin') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('Question limit')}}<span class="text-danger">*</span></label>
                                        <input type="text" @if(isset($category)) value="{{$category->max_limit}}" @else value="{{old('max_limit')}}" @endif name="max_limit" class="form-control" placeholder="Question Limit for category">
                                        @if ($errors->has('max_limit'))
                                            <span class="text-danger">
                                            <strong>{{ $errors->first('max_limit') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('Quiz limit')}}<span class="text-danger">*</span></label>
                                        <input type="text" @if(isset($category)) value="{{$category->qs_limit}}" @else value="{{old('qs_limit')}}" @endif name="qs_limit" class="form-control" placeholder="Question limit for per Quiz test">
                                        @if ($errors->has('qs_limit'))
                                            <span class="text-danger">
                                            <strong>{{ $errors->first('qs_limit') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('Time limit')}}<span class="text-danger">*</span></label>
                                        <input type="text" @if(isset($category)) value="{{$category->time_limit}}" @else value="{{old('time_limit')}}" @endif name="time_limit" class="form-control" placeholder="Time limit(in minute) for per question in category">
                                        @if ($errors->has('time_limit'))
                                            <span class="text-danger">
                                            <strong>{{ $errors->first('time_limit') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('Serial')}}<span class="text-danger">*</span></label>
                                        <input type="text" @if(isset($category)) value="{{$category->serial}}" @else value="{{old('serial')}}" @endif name="serial" class="form-control" placeholder="Priority">
                                        @if ($errors->has('serial'))
                                            <span class="text-danger">
                                            <strong>{{ $errors->first('serial') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('Activation Status')}}<span class="text-danger">*</span></label>
                                        <div class="qz-question-category">
                                            <select name="status" class="form-control">
                                                @foreach(active_statuses() as $key => $value)
                                                    <option @if(isset($category) && ($category->status == $key)) selected
                                                            @elseif((old('status') != null) && (old('status') == $key)) @endif value="{{ $key }}">{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{__('Description')}}</label>
                                        <textarea name="description" id="" rows="6" class="form-control">@if(isset($category)){{$category->description}}@else{{old('description')}}@endif</textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{__('Thumbnail Image')}}<span class="text-danger"></span></label>
                                        <div id="file-upload" class="section">
                                            <!--Default version-->
                                            <div class="row section">
                                                <div class="col s12 m12 l12">
                                                    <input name="image" type="file" id="input-file-now" class="dropify" data-default-file="{{isset($category) && !empty($category->image) ? asset(path_category_image().$category->image) : ''}}" />
                                                    @if ($errors->has('image'))
                                                        <div class="text-danger">{{ $errors->first('image') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                            <!--Default value-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    @if(isset($category))
                                        <input type="hidden" name="edit_id" value="{{$category->id}}">
                                    @endif
                                    <button type="submit" class="btn btn-primary btn-block add-category-btn">
                                        @if(isset($category)) {{__('Update')}} @else {{__('Add New')}} @endif
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