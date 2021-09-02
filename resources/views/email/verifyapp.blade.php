@include('email.header_new')

<h3>{{__('Hello')}}, {{ $data->name }} </h3>

<p>
  Your {{allsetting()['app_title']}} email verification code is {{$key}}.</p>
<p>
  {{__('Thanks a lot for being with us.')}} <br/>
  {{allsetting()['app_title']}}
</p>
@include('email.footer_new')

