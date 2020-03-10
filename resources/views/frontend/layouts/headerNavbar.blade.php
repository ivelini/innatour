<header id="header" class="overflow-x-hidden-xss">

    <!-- start Navbar (Header) -->
    <nav class="navbar navbar-default navbar-fixed-top with-slicknav">

        <div class="container">

            <div class="navbar-header">
                <a class="navbar-brand" href="/"><img style="height: 1.6em; float: left; margin-right: 20px;" src="/global_assets/images/logo.png"></a>
            </div>

            <div id="navbar" class="collapse navbar-collapse navbar-arrow pull-left">

                <ul class="nav navbar-nav" id="responsive-menu">
                    @if($pageItems->count() > 0)
                        @foreach($pageItems as $page)
                            <li>
                                <a href="{{ route('page.show', $page->slug) }}" style="color:#ff8c5e; font-weight:bold;">{{ $page->nav_name }}</a>
                            </li>
                        @endforeach
                    @endif
                </ul>

            </div><!--/.nav-collapse -->

            <div class="pull-right">

                <div class="navbar-mini">
                    <ul class="clearfix">
                        <div class="tv-free-button tv-moduleid-984239"></div>
{{--                        <script type="text/javascript" src="//tourvisor.ru/module/init.js"></script>--}}
                        <li class="dropdown bt-dropdown-click user-action" style="float: right;">
                            @guest
                                <a href="{{ route('login') }}" class="btn btn-primary btn-inverse">Вход / Регистрация</a>
                            @endguest
                            @auth
                                <a id="currency-dropdown"
                                   class="dropdown-toggle btn btn-primary btn-inverse"
                                   data-toggle="dropdown"
                                   role="button"
                                   aria-haspopup="true"
                                   aria-expanded="false">
                                    {{ Auth::user()->name }}
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="currency-dropdown">
                                    <li><a href="{{ route('manager.dashboard') }}"> Панель управления</a></li>
                                    <li><a href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();"> Выход</a></li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </ul>
                            @endauth
                        </li>

                    </ul>
                </div>

            </div>

        </div>

        <div id="slicknav-mobile"></div>

    </nav>
    <!-- end Navbar (Header) -->

</header>