<header id="header">
    <ul class="header-inner">
        <li id="menu-trigger" data-trigger="#sidebar">
            <div class="line-wrap">
                <div class="line top"></div>
                <div class="line center"></div>
                <div class="line bottom"></div>
            </div>
        </li>

        <li class="logo hidden-xs">
            <a href="{{ url('/') }}"><img src="{{ asset('/favicon.ico') }}" alt="Logo" class="m-r-5"/>Color Nations</a>
        </li>
        @if(Auth::check())
            <li>
                <span class="navbar-text"><i
                            class="fa fa-dollar"></i> {{ number_format(Auth::user()->resources->gold) }}</span>
            </li>

            <li>
                <span class="navbar-text">Ranking: {{ Auth::user()->ranking ? Auth::user()->ranking->overall_rank : "Unranked"}}</span>
            </li>

            <li>
                <span class="navbar-text">Turns: {{ Auth::user()->resources->turns }}/{{GameInfo::maxTurns()}}</span>
            </li>
        @endif
        <li class="pull-right">
            <ul class="top-menu">
                <li id="toggle-width">
                    <div class="toggle-switch">
                        <input id="tw-switch" type="checkbox" hidden="hidden">
                        <label for="tw-switch" class="ts-helper"></label>
                    </div>
                </li>
                <li style="width:1px; height:39px">
                </li>
            </ul>
        </li>
    </ul>
</header>
