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
                        <h2>@if(isset($question)) {{__('Edit Question')}} @else {{__('Add Question')}} @endif</h2>
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
                        <div class="col-lg-12">
                            {{ Form::open(['route' => 'questionSave', 'files' => 'true']) }}
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{__('Question Title')}} <span class="text-danger"></span></label>
                                            <input type="text" name="title" @if(isset($question)) value="{{ $question->title }}" @else value="{{ old('title') }}" @endif class="form-control" placeholder="Question">
                                            @if ($errors->has('title'))
                                                <span class="text-danger">
                                                        <strong>{{ $errors->first('title') }}</strong>
                                                    </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label>{{__('Point')}} <span class="text-danger">*</span></label>
                                            <input type="text" @if(isset($question)) value="{{ $question->point }}" @else value="{{ old('point') }}" @endif name ="point" class="form-control" placeholder="Point">
                                            @if ($errors->has('point'))
                                                <span class="text-danger">
                                                        <strong>{{ $errors->first('point') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        {{--<div class="form-group">--}}
                                            {{--<label>{{__('Video Link')}} <span class="text-danger"></span></label>--}}
                                            {{--<input type="text" name="video_link" @if(isset($question)) value="{{ $question->video_link }}" @else value="{{ old('video_link') }}" @endif class="form-control" placeholder="Video link">--}}
                                            {{--@if ($errors->has('video_link'))--}}
                                                {{--<span class="text-danger">--}}
                                                        {{--<strong>{{ $errors->first('video_link') }}</strong>--}}
                                                    {{--</span>--}}
                                            {{--@endif--}}
                                        {{--</div>--}}
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{__('Question image')}}<span class="text-danger"></span></label>
                                            <div id="file-upload" class="section">
                                                <!--Default version-->
                                                <div class="row section">
                                                    <div class="col s12 m12 l12">
                                                        <input name="image" type="file" id="input-file-now" class="dropify"
                                                               data-default-file="{{isset($question) && !empty($question->image) ? asset(path_question_image().$question->image) : ''}}" />
                                                    </div>
                                                </div>
                                                <!--Default value-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{__('Category')}} <span class="text-danger">*</span></label>
                                            <div class="qz-question-category">
                                                @if(isset($categories[0]))
                                                    <select name="category_id" class="form-control">
                                                        <option value="">{{__('Select Category')}}</option>
                                                        @foreach($categories as $category)
                                                            <option @if(isset($question) && ($question->category_id == $category->id)) selected
                                                                    @elseif((old('category_id') != null) && (old('category_id') == $category->id))  @endif value="{{$category->id}}">{{$category->name}}</option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                                @if ($errors->has('category_id'))
                                                    <span class="text-danger">
                                                        <strong>{{ $errors->first('category_id') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{__('Sub Category')}} <span class="text-danger"></span></label>
                                            <div class="qz-question-category">
                                                <select name="sub_category_id" class="form-control">
                                                    <option value="">{{__('Select Sub Category')}}</option>
                                                    @if(isset($sub_categories[0]))
                                                        @foreach($sub_categories as $sub_category)
                                                            <option @if(isset($question) && isset($question->sub_category_id) && ($question->sub_category_id == $sub_category->id)) selected
                                                                    @elseif((old('sub_category_id') != null) && (old('sub_category_id') == $sub_category->id)) selected @endif value="{{$sub_category->id}}">{{$sub_category->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @if ($errors->has('sub_category_id'))
                                                    <span class="text-danger">
                                                        <strong>{{ $errors->first('sub_category_id') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{__('Time Limit')}}</label>
                                            <input type="text" @if(isset($question)) value="{{ $question->time_limit }}" @else value="{{ old('time_limit') }}" @endif name="time_limit" class="form-control" placeholder="Time limit in Minute">
                                            @if ($errors->has('time_limit'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('time_limit') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{__('Coin')}} <span class="text-danger"></span></label>
                                            <input type="text" @if(isset($question)) value="{{ $question->coin }}" @else value="{{ old('coin') }}" @endif name ="coin" class="form-control" placeholder="Coin">
                                            @if ($errors->has('coin'))
                                                <span class="text-danger">
                                                        <strong>{{ $errors->first('coin') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{__('Coin for skip')}} <span class="text-danger">*</span></label>
                                            <input type="text" @if(isset($question)) value="{{ $question->skip_coin }}" @else value="{{ old('skip_coin') }}" @endif name ="skip_coin" class="form-control" placeholder="Coin for skip">
                                            @if ($errors->has('skip_coin'))
                                                <span class="text-danger">
                                                        <strong>{{ $errors->first('skip_coin') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{__('Hints')}} <span class="text-danger"></span></label>
                                            <input type="text" name="hints" @if(isset($question)) value="{{ $question->hints }}" @else value="{{ old('hints') }}" @endif class="form-control" placeholder=" Hints">
                                            @if ($errors->has('hints'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('hints') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{__('Question Type')}} <span class="text-danger">*</span></label>
                                            <div class="qz-question-category">
                                                <select class="form-control" name="type" id="question_type">
                                                    @foreach(option_type() as $key => $value)
                                                        <option @if(isset($question) && ($question->type == $key)) selected
                                                                @endif value="{{ $key }}">{{$value}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('type'))
                                                    <span class="text-danger">
                                                        <strong>{{ $errors->first('type') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{__('Activation Status')}}</label>
                                            <div class="qz-question-category">
                                                <select name="status" class="form-control">
                                                    @foreach(active_statuses() as $key => $value)
                                                        <option @if(isset($question) && ($question->status == $key)) selected
                                                                @elseif((old('status') != null) && (old('status') == $key)) @endif value="{{ $key }}">{{$value}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('status'))
                                                    <span class="text-danger">
                                                        <strong>{{ $errors->first('status') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                    </div>
                                    <div class="col-md-6">
                                    </div>
                                </div>
                                <div class="row" id="multiple_choise">
                                    <div class="col-lg-12">
                                        <div class="row" id="">
                                            <div class="col-md-8 qz-label-hide">
                                                <div class="form-group">
                                                    <label>{{__('Options')}}<span class="text-danger"></span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 qz-label-hide">
                                                <div class="form-group">
                                                    <label>{{__('Answer Type')}}</label>
                                                </div>
                                            </div>
                                            {{--<div class="col-md-2 offset-lg-1">--}}
                                                {{--<label for=""></label>--}}
                                                {{--<button type="button" class="btn btn-primary btn-block" name="add" id="add">{{__('Add More')}}</button>--}}
                                            {{--</div>--}}
                                        </div>
                                        <div class="row" id="">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    @if(isset($qsOptions) && (isset($question)) && (isset($qsOptions[0])))
                                                        <input type="hidden" name="text_option1" value="{{$qsOptions[0]->id}}">
                                                    @endif
                                                    <input type="text"  name="option_text1" class="form-control" placeholder="Answer"
                                                    @if(isset($qsOptions) && (isset($question)) && (isset($qsOptions[0]))) value="{{$qsOptions[0]->option_title}}" @else value="{{old('option_text1')}}" @endif>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-md-0 mb-2">
                                                @if(isset($qsOptions) && (isset($question)) && (isset($qsOptions[0])))
                                                    <input type="hidden" name="option1" value="{{$qsOptions[0]->id}}">
                                                    <img width="50" @if(isset($qsOptions[0]->option_image) && !empty($qsOptions[0]->option_image)) src="{{ asset(path_question_option1_image().$qsOptions[0]->option_image)}}" @endif alt="">
                                                @endif
                                                <input type="file" name="option_image1">
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="qz-question-category">
                                                        <select name="ans_type1" class="form-control" >
                                                            <option @if(isset($qsOptions) && (isset($question)) && (isset($qsOptions[0])) &&  ($qsOptions[0]->is_answer == 0)) selected @endif value="0">{{__('Wrong')}}</option>
                                                            <option @if(isset($qsOptions) && (isset($question)) && (isset($qsOptions[0])) &&  ($qsOptions[0]->is_answer == 1)) selected @endif  value="1">{{__('Right')}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" id="dynamic_field">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    @if(isset($qsOptions) && (isset($question)) && (isset($qsOptions[1])))
                                                        <input type="hidden" name="text_option2" value="{{$qsOptions[1]->id}}">
                                                    @endif
                                                    <input type="text"  name="option_text2" class="form-control" placeholder="Answer"
                                                           @if(isset($qsOptions) && (isset($question)) && (isset($qsOptions[1]))) value="{{$qsOptions[1]->option_title}}" @else value="{{old('option_text2')}}" @endif>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-md-0 mb-2">
                                                @if(isset($qsOptions) && (isset($question)) && (isset($qsOptions[1])))
                                                    <input type="hidden" name="option2" value="{{$qsOptions[1]->id}}">
                                                    <img width="50" @if(isset($qsOptions[1]->option_image) && !empty($qsOptions[1]->option_image)) src="{{ asset(path_question_option2_image().$qsOptions[1]->option_image)}}" @endif alt="">
                                                @endif
                                                <input type="file" name="option_image2">
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="qz-question-category">
                                                        <select name="ans_type2" class="form-control" >
                                                            <option @if(isset($qsOptions) && (isset($question)) && (isset($qsOptions[1])) &&  ($qsOptions[1]->is_answer == 0)) selected @endif value="0">{{__('Wrong')}}</option>
                                                            <option @if(isset($qsOptions) && (isset($question)) && (isset($qsOptions[1])) &&  ($qsOptions[1]->is_answer == 1)) selected @endif  value="1">{{__('Right')}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" id="">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    @if(isset($qsOptions) && (isset($question)) && (isset($qsOptions[2])))
                                                        <input type="hidden" name="text_option3" value="{{$qsOptions[2]->id}}">
                                                    @endif
                                                    <input type="text"  name="option_text3" class="form-control" placeholder="Answer"
                                                           @if(isset($qsOptions) && (isset($question)) && (isset($qsOptions[2]))) value="{{$qsOptions[2]->option_title}}" @else value="{{old('option_text3')}}" @endif>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-md-0 mb-2">
                                                @if(isset($qsOptions) && (isset($question)) && (isset($qsOptions[2])))
                                                    <input type="hidden" name="option3" value="{{$qsOptions[2]->id}}">
                                                    <img width="50" @if(isset($qsOptions[2]->option_image) && !empty($qsOptions[2]->option_image)) src="{{ asset(path_question_option3_image().$qsOptions[2]->option_image)}}" @endif alt="">
                                                @endif
                                                <input type="file" name="option_image3">
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="qz-question-category">
                                                        <select name="ans_type3" class="form-control" >
                                                            <option @if(isset($qsOptions) && (isset($question)) && (isset($qsOptions[2])) &&  ($qsOptions[2]->is_answer == 0)) selected @endif value="0">{{__('Wrong')}}</option>
                                                            <option @if(isset($qsOptions) && (isset($question)) && (isset($qsOptions[2])) &&  ($qsOptions[2]->is_answer == 1)) selected @endif  value="1">{{__('Right')}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" id="">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    @if(isset($qsOptions) && (isset($question)) && (isset($qsOptions[3])))
                                                        <input type="hidden" name="text_option4" value="{{$qsOptions[3]->id}}">
                                                    @endif
                                                    <input type="text"  name="option_text4" class="form-control" placeholder="Answer"
                                                           @if(isset($qsOptions) && (isset($question)) && (isset($qsOptions[3]))) value="{{$qsOptions[3]->option_title}}" @else value="{{old('option_text4')}}" @endif>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-md-0 mb-2">
                                                @if(isset($qsOptions) && (isset($question)) && (isset($qsOptions[3])))
                                                    <input type="hidden" name="option4" value="{{$qsOptions[3]->id}}">
                                                    <img width="50" @if(isset($qsOptions[3]->option_image) && !empty($qsOptions[3]->option_image)) src="{{ asset(path_question_option4_image().$qsOptions[3]->option_image)}}" @endif alt="">
                                                @endif
                                                <input type="file" name="option_image4">
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="qz-question-category">
                                                        <select name="ans_type4" class="form-control" >
                                                            <option @if(isset($qsOptions) && (isset($question)) && (isset($qsOptions[3])) &&  ($qsOptions[3]->is_answer == 0)) selected @endif value="0">{{__('Wrong')}}</option>
                                                            <option @if(isset($qsOptions) && (isset($question)) && (isset($qsOptions[3])) &&  ($qsOptions[3]->is_answer == 1)) selected @endif  value="1">{{__('Right')}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" id="">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    @if(isset($qsOptions) && (isset($question)) && (isset($qsOptions[4])))
                                                        <input type="hidden" name="text_option5" value="{{$qsOptions[4]->id}}">
                                                    @endif
                                                    <input type="text"  name="option_text5" class="form-control" placeholder="Answer"
                                                           @if(isset($qsOptions) && (isset($question)) && (isset($qsOptions[4]))) value="{{$qsOptions[4]->option_title}}" @else value="{{old('option_text5')}}" @endif>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-md-0 mb-2">
                                                @if(isset($qsOptions) && (isset($question)) && (isset($qsOptions[4])))
                                                    <input type="hidden" name="option5" value="{{$qsOptions[4]->id}}">
                                                    <img width="50" @if(isset($qsOptions[4]->option_image) && !empty($qsOptions[4]->option_image)) src="{{ asset(path_question_option5_image().$qsOptions[4]->option_image)}}" @endif alt="">
                                                @endif
                                                <input type="file" name="option_image5">
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="qz-question-category">
                                                        <select name="ans_type5" class="form-control" >
                                                            <option @if(isset($qsOptions) && (isset($question)) && (isset($qsOptions[4])) &&  ($qsOptions[4]->is_answer == 0)) selected @endif value="0">{{__('Wrong')}}</option>
                                                            <option @if(isset($qsOptions) && (isset($question)) && (isset($qsOptions[4])) &&  ($qsOptions[4]->is_answer == 1)) selected @endif  value="1">{{__('Right')}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        @if(isset($question))
                                            <input type="hidden" name="edit_id" value="{{$question->id}}">
                                        @endif
                                        <button type="submit" class="btn btn-primary btn-block add-category-btn mt-4">
                                            @if(isset($question)) {{__('Update')}} @else {{__('Add New')}} @endif
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
    <script type="text/javascript">
        $(document).ready(function(){
            $("#puzzle").hide();
            var i=1;

            $('#add').click(function () {
                // alert(1);
                i++;
                $('#dynamic_field').append(
                    '<div class="col-md-6 dynamic-added" id="row'+i+'" >' +
                        '<div class="form-group">' +
                            '<input type="text" name="options[]" placeholder="Answer" class="form-control name_list" />' +
                        '</div>' +
                    '</div>' +
                    '<div class="col-md-3 dynamic-added" id="rows'+i+'" >' +
                        '<div class="form-group">' +
                            '<div class="qz-question-category">' +
                            '<select name="ans_type[]" class="form-control">' +
                                '<option value="0"> Wrong </option>' +
                                '<option value="1"> Right </option>' +
                            '</select>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                    '<div class="col-md-1 remove-btn">' +
                        '<div class="form-group">' +
                            '<button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button>' +
                        '</div>' +
                    '</div>'
                    );
            });

            $(document).on('click', '.btn_remove', function(){
                var button_id = $(this).attr("id");
                $('#row'+button_id+'').remove();
                $('#rows'+button_id+'').remove();
                $(this).closest('.remove-btn').remove();
            });

            $(document).on('click', '.btn_remove2', function(){
                var button_id = $(this).attr("id");
                $('#optTitle'+button_id+'').remove();
                // $('#optAns'+button_id+'').remove();
                // $(this).remove();
            });

            $('#question_type').change(function () {
                var type = $('#question_type :selected').val();
                if (type == 2) {
                    $("#puzzle").show();
                    $("#multiple_choise").hide();
                } else {
                    $("#multiple_choise").show();
                    $("#puzzle").hide();
                }

            });

            var url = window.location.pathname.split( '/' );

            if (url[1] == 'question-edit') {
                var type = $('#question_type :selected').val();
                if (type == 2) {
                    $("#puzzle").show();
                    $("#multiple_choise").hide();
                } else {
                    $("#multiple_choise").show();
                }
            }

        });

        $(document.body).on('change', 'select[name=category_id]', function () {
            var id = $(this).val();
            $.ajax({
                url: "{{route('questionCreate')}}?val=" + id,
                type: "get",
                success: function (data) {
                    console.log(data);
                    $('select[name=sub_category_id]').html(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {

                }
            });
        });
    </script>
@endsection