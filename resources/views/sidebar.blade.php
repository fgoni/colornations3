<aside id="sidebar">
    <div class="sidebar-inner">
        <div class="si-inner">
            @if (Auth::check())
                <div class="profile-menu">
                    <a href="">
                        <div class="profile-info">
                            {{ Auth::user()->name }}
                            <i class="md md-arrow-drop-down"></i>
                        </div>
                    </a>

                    <ul class="main-menu">
                        <li @if (Request::is('dashboard/profile')) class="active" @endif>
                            <a href="{{ url('dashboard/profile') }}"><i class="md md-person"></i> View Profile</a>
                        </li>
                    </ul>
                </div>
            @endif
            <ul class="main-menu">
                <li @if (Request::is('/')) class="active" @endif>
                    <a href="{{ url('/') }}">Home</a>
                </li>
                <li @if (Request::is('battlefield')) class="active" @endif>
                    <a href="{{ url('battlefield') }}">Battlefield</a>
                </li>
                <li @if (Request::is('gameinfo')) class="active" @endif>
                    <a href="{{ url('gameinfo') }}">Game Info</a>
                </li>
                <li @if (Request::is('history')) class="active" @endif>
                    <a href="{{ url('history') }}">History</a>
                </li>
                @if (Auth::check())
                    <li class="sub-menu toggled">
                        <a href=""><i class="zmdi zmdi-widgets"></i> General Info</a>
                        <ul style="display: block;">
                            <li @if (Request::is('dashboard/headquarters')) class="active" @endif>
                                <a href="{{ url('dashboard/headquarters') }}">Headquarters</a>
                            </li>
                            <li @if (Request::is('dashboard/rankings')) class="active" @endif>
                                <a href="{{ url('dashboard/rankings') }}">Rankings</a>
                            </li>
                            <li @if (Request::is('dashboard/settings')) class="active" @endif>
                                <a href="{{ url('dashboard/settings') }}">Settings</a>
                            </li>
                            <li @if (Request::is('dashboard/events')) class="active" @endif>
                                <a href="{{ url('dashboard/events') }}">Events History</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sub-menu toggled">
                        <a href=""><i class="zmdi zmdi-widgets"></i> Techs & Training</a>
                        <ul style="display: block;">
                            <li @if (Request::is('dashboard/techs')) class="active" @endif>
                                <a href="{{ url('dashboard/techs') }}">Techs</a>
                            </li>
                            <li @if (Request::is('dashboard/training')) class="active" @endif>
                                <a href="{{ url('dashboard/training') }}">Training</a>
                            </li>
                            <li @if (Request::is('dashboard/intelligence')) class="active" @endif>
                                <a href="{{ url('dashboard/intelligence') }}">Intelligence</a>
                            </li>
                        </ul>
                    </li>
                    <li @if (Request::is('dashboard/combat-log')) class="active" @endif>
                        <a href="{{ url('dashboard/combat-log') }}">Combat Log</a>
                    </li>
                    <li @if (Request::is('dashboard/economy')) class="active" @endif>
                        <a href="{{ url('dashboard/economy') }}">Economy</a>
                    </li>
                    <li @if (Request::is('auth/logout')) class="active" @endif>
                        <a href="{{ url('auth/logout') }}" id="logout">Logout</a>
                    </li>
                @else
                    <li @if (Request::is('auth/login')) class="active" @endif>
                        <a href="{{ url('auth/login') }}">Login</a>
                    </li>
                    <li @if (Request::is('auth/register')) class="active" @endif>
                        <a href="{{ url('auth/register') }}">Register</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</aside>
