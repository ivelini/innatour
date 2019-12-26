<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">

    <!-- Sidebar mobile toggler -->
    <div class="sidebar-mobile-toggler text-center">
        <a href="#" class="sidebar-mobile-main-toggle">
            <i class="icon-arrow-left8"></i>
        </a>
        Navigation
        <a href="#" class="sidebar-mobile-expand">
            <i class="icon-screen-full"></i>
            <i class="icon-screen-normal"></i>
        </a>
    </div>
    <!-- /sidebar mobile toggler -->


    <!-- Sidebar content -->
    <div class="sidebar-content">
        <!-- Main navigation -->
        <div class="card card-sidebar-mobile">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                <!-- Main -->
                <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Основное</div> <i class="icon-menu" title="Main"></i></li>
                <li class="nav-item">
                    <a href="{{ route('manager.dashboard') }}" class="nav-link"><i class="icon-home4"></i> <span>Главная страница</span></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('manager.page.index') }}" class="nav-link"><i class="icon-magazine"></i> <span>Управление страницами</span></a>
                </li>
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-stack"></i> <span>Управление турами</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Управление турами">
                        <li class="nav-item"><a href="{{ route('manager.tour.index') }}" class="nav-link">Все туры</a></li>
                        <li class="nav-item"><a href="{{ route('manager.tour.create') }}" class="nav-link">Добавить новый тур</a></li>
                        <li class="nav-item"><a href="{{ route('manager.category.index') }}" class="nav-link">Категории</a></li>
                        <li class="nav-item"><a href="{{ route('manager.scope.index') }}" class="nav-link">Направления</a></li>

                    </ul>
                </li>
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-envelop3"></i> <span>Заявки от клиентов</span>
                        {{ Widget::run('CountClientSidebar', 'new') }}
                    </a>

                    <ul class="nav nav-group-sub" data-submenu-title="Заявки от клиентов">
                        <li class="nav-item">
                            <a href="{{ route('manager.client.new') }}" class="nav-link">
                                Новые
                                {{ Widget::run('CountClientSidebar', 'new') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('manager.client.active') }}" class="nav-link">
                                Активные
                                {{ Widget::run('CountClientSidebar', 'active') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('manager.client.closed') }}" class="nav-link">
                                Закрытые
                                {{ Widget::run('CountClientSidebar', 'closed') }}
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Системные</div> <i class="icon-menu" title="Main"></i></li>
                <li class="nav-item">
                    <a href="{{ route('manager.system.main') }}" class="nav-link"><i class="icon-crown"></i> <span>Главная страница</span></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('manager.system.users') }}" class="nav-link"><i class="icon-users4"></i> <span>Пользователи</span></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('manager.system.settings') }}" class="nav-link"><i class="icon-users4"></i> <span>Основные</span></a>
                </li>
                <!-- /main -->

            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>