<!-- Start top bar -->
<div class="qz-topbar">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-9 col-lg-8 col-md-7 col-12">
                <form action="{{route('qsSearch')}}" class="qz-search-from">
                    <button type="submit" class="btn btn-primary qz-search-btn">
                        <span class="flaticon-magnifying-glass"></span>
                    </button>
                    <div class="form-group">
                        <input type="text" required name="item" class="form-control" placeholder="Search here anything">
                    </div>
                </form>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-5 col-12 mt-md-0 mt-5">
                <div class="btn-group d-md-inline-flex d-flex justify-content-left">
                    <button type="button" class="btn btn-secondary dropdown-toggle qz-user-profile-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @if(isset(Auth::user()->name)) {{ Auth::user()->name }} @endif
                        <span class="flaticon-angle-arrow-down"></span>
                        <span class="qz-user-avater">
                            <img @if(isset(Auth::user()->photo)) src="{{ asset(pathUserImage().Auth::user()->photo)}}" @else src="{{asset('assets/images/avater.jpg')}}" @endif alt="" class="img-fluid">

                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="{{route('passwordChange')}}" class="dropdown-item">{{__('Change Password')}}</a>
                        <a href="{{ route('logOut') }}" class="dropdown-item">{{__('Logout')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>