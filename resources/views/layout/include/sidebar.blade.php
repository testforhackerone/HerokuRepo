<!-- Start sidebar -->
<div class="qz-sidebar">

    <div class="qz-logo">
        <a href="{{ route('adminDashboardView') }}">
            <img @if(!empty(allsetting('logo'))) src ="{{ asset(path_image().allsetting('logo')) }}"
                 @else src="{{asset('assets/images/logo.png')}}" @endif alt="" class="img-fluid">
        </a>
    </div>

    <nav>

        <ul id="metismenu">
            <li class="@if(isset($menu) && $menu == 'dashboard') qz-active @endif"><a href="{{ route('adminDashboardView') }}"><span class="flaticon-dashboard"></span>{{__('Dashboard')}} </a></li>
            <li class="@if(isset($menu) && $menu == 'category') qz-active @endif"><a href="{{ route('qsCategoryList') }}"><span class="flaticon-menu"></span>{{__('Category')}} </a></li>
            <li class="@if(isset($menu) && $menu == 'question') qz-active @endif"><a href="{{ route('questionList') }}"><span class="flaticon-info"></span>{{__('Question')}} </a></li>
            <li class="@if(isset($menu) && $menu == 'leaderboard') qz-active @endif"><a href="{{ route('leaderBoard') }}"><span class="flaticon-statistics"></span>{{__('Leaderboard')}} </a></li>
            <li class="@if(isset($menu) && $menu == 'payment') qz-active @endif">
                <a href="{{ route('paymentMethods') }}">
                    <span class="mr-2"><img src="{{asset('assets/images/sidebar/payment.png')}}" alt=""></span>{{__('Payment Methods')}}
                </a>
            </li>
            <li class="@if(isset($menu) && $menu == 'coin') qz-active @endif">
                <a href="{{ route('coinList') }}">
                    <span class="mr-2"><img src="{{asset('assets/images/sidebar/coin.png')}}" alt=""></span>{{__('Coins')}}
                </a>
            </li>
            <li class="@if(isset($menu) && $menu == 'sale') qz-active @endif">
                <a href="{{ route('saleReport') }}">
                    <span class="mr-2"><img src="{{asset('assets/images/sidebar/report.png')}}" alt=""></span>{{__('Sales Report')}}
                </a>
            </li>
            <li class="@if(isset($menu) && $menu == 'userlist') qz-active @endif"><a class="userlist-image" href="{{ route('userList') }}"><img src={{asset('assets/images/friend.jpg')}}>{{__('User Management')}} </a></li>
            <li class="@if(isset($menu) && $menu == 'profile') qz-active @endif"><a href="{{ route('userProfile') }}"><span class="flaticon-user"></span>{{__('Profile')}} </a></li>
            <li class="@if(isset($menu) && $menu == 'setting') qz-active @endif"><a href="{{ route('generalSetting') }}"><span class="flaticon-settings-work-tool"></span>{{__('Settings')}} </a></li>
        </ul>

    </nav>

</div>
<!-- End sidebar -->
