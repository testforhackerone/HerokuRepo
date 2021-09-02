@if(Session::has('success'))
    <div class="myalert alert-float alert alert-success alert-dismissable" id="notification_box">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
    {{Session::get('success')}}
    </div>
@endif

@if(Session::has('dismiss'))
    <div class="myalert alert-float alert alert-danger alert-dismissable" id="notification_box">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        {!! Session::get('dismiss') !!}
    </div>
@endif
