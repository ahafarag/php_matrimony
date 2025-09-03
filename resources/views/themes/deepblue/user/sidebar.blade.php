<div class="col-lg-3">
    <div class="sidebar">
        <div class="profile">
            @if(auth()->user()->image != NULL)
                <img src="{{getFile(config('location.user.path').auth()->user()->image)}}" class="img-fluid" alt="@lang('user profile')"/>
            @else
                <img src="{{getFile(config('location.default'))}}" class="img-fluid" alt="@lang('default image')">
            @endif
            <h5>@lang(auth()->user()->username)</h5>
        </div>

        <ul>
            <li class="{{menuActive('user.home')}}">
                <a href="{{ route('user.home') }}">
                    <i class="fal fa-home-alt"></i>@lang('dashboard')
                </a>
            </li>

            <li class="{{menuActive('user.gallery')}}">
                <a href="{{ route('user.gallery') }}">
                    <i class="fal fa-image"></i>@lang('gallery')
                </a>
            </li>

            <li class="{{menuActive(['user.story', 'user.story.create', 'user.story.edit*'])}}">
                <a href="{{route('user.story')}}">
                    <i class="fal fa-calendar-star"></i>@lang('Manage story')
                </a>
            </li>

            <li class="{{menuActive(['user.myPlans', 'user.purchased.plan.search'])}}">
                <a href="{{route('user.myPlans')}}">
                    <i class="far fa-cart-plus"></i>@lang('Purchased Packages')
                </a>
            </li>

            <li class="{{menuActive(['user.fund-history', 'user.fund-history.search'])}}">
                <a href="{{route('user.fund-history')}}">
                    <i class="fas fa-money-check-alt"></i>@lang('Payment History')
                </a>
            </li>

            <li class="{{menuActive(['user.shortlist.show','user.shortlist.search'])}}">
                <a href="{{route('user.shortlist.show')}}">
                    <i class="fal fa-list-ul"></i>@lang('shortlist')
                </a>
            </li>

            <li class="{{menuActive(['user.interest.show', 'user.interest.search'])}}">
                <a href="{{route('user.interest.show')}}">
                    <i class="fal fa-heart"></i>@lang('My Interest')
                </a>
            </li>

            <li class="{{menuActive(['user.ignore.show', 'user.ignore.search'])}}">
                <a href="{{route('user.ignore.show')}}">
                    <i class="fal fa-ban"></i>@lang('Ignored List')
                </a>
            </li>

            <li class="{{menuActive('user.matched.profile')}}">
                <a href="{{route('user.matched.profile')}}">
                    <i class="fas fa-handshake"></i>@lang('Matched Profile')
                </a>
            </li>

            <li class="{{menuActive('user.profile')}}">
                <a href="{{route('user.profile')}}">
                    <i class="far fa-user-cog"></i>@lang('Manage Profile')
                </a>
            </li>

            <li class="{{menuActive('user.messenger')}}">
                <a href="{{route('user.messenger')}}">
                    <i class="fal fa-envelope"></i>@lang('Messages')
                </a>
            </li>

            <li class="{{menuActive(['user.ticket.list', 'user.ticket.create', 'user.ticket.view*'])}}">
                <a href="{{route('user.ticket.list')}}">
                    <i class="fas fa-user-headset"></i>@lang('Support Ticket')
                </a>
            </li>

            <li class="{{menuActive('user.change.password')}}">
                <a href="{{route('user.change.password')}}">
                    <i class="fas fa-lock-alt"></i>@lang('Change password')
                </a>
            </li>

            <li class="{{menuActive(['user.twostep.security'])}}">
                <a href="{{route('user.twostep.security')}}">
                    <i class="fas fa-user-lock"></i>@lang('2FA Security')
                </a>
            </li>

            <li class="">
                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                document.getElementById('userLogout-form').submit();">
                    <i class="far fa-power-off"></i>@lang('Logout')
                </a>
            </li>
            <form id="userLogout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>

        </ul>
    </div>
</div>
