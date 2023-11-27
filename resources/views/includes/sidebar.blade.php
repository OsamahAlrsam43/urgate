<!-- BEGIN: Left Aside -->
<button class="m-aside-left-close m-aside-left-close--skin-dark" id="m_aside_left_close_btn">
    <i class="la la-close"></i>
</button>
<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">
    <!-- BEGIN: Aside Menu -->
    <div id="m_ver_menu"
         class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark m-aside-menu--dropdown "
         data-menu-vertical="true"
         data-menu-dropdown="true" data-menu-scrollable="true" data-menu-dropdown-timeout="500">
        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
            @if(Auth::user()->type === 'Super Admin')
                <li class="m-menu__item @if(session('sidebar') === 'home') m-menu__item--active @endif"
                    aria-haspopup="true">
                    <a href="{{ route('home') }}" class="m-menu__link ">
                        <span class="m-menu__item-here"></span>
                        <i class="m-menu__link-icon flaticon-line-graph"></i>
                        <span class="m-menu__link-text">
                        Dashboard
                    </span>
                    </a>
                </li>
                <li class="m-menu__item @if(session('sidebar') === 'countries') m-menu__item--active @endif"
                    aria-haspopup="true">
                    <a href="{{ route('listCountries') }}" class="m-menu__link ">
                        <span class="m-menu__item-here"></span>
                        <i class="m-menu__link-icon fa fa-map"></i>
                        <span class="m-menu__link-text">
                        Airports
                    </span>
                    </a>
                </li>
                <li class="m-menu__item @if(session('sidebar') === 'aircrafts') m-menu__item--active @endif"
                    aria-haspopup="true">
                    <a href="{{ route('listAircraft') }}" class="m-menu__link ">
                        <span class="m-menu__item-here"></span>
                        <i class="m-menu__link-icon fa fa-map"></i>
                        <span class="m-menu__link-text">
                        Aircrafts
                    </span>
                    </a>
                </li>
                <li class="m-menu__item @if(session('sidebar') === 'travels') m-menu__item--active @endif"
                    aria-haspopup="true">
                    <a href="{{ route('listTravels') }}" class="m-menu__link ">
                        <span class="m-menu__item-here"></span>
                        <i class="m-menu__link-icon flaticon-rocket"></i>
                        <span class="m-menu__link-text">
                        Travels
                    </span>
                    </a>
                </li>
                <li class="m-menu__item @if(session('sidebar') === 'flights') m-menu__item--active @endif"
                    aria-haspopup="true">
                    <a href="{{ route('listFlights') }}" class="m-menu__link ">
                        <span class="m-menu__item-here"></span>
                        <i class="m-menu__link-icon fa fa-plane"></i>
                        <span class="m-menu__link-text">
                        Flights
                    </span>
                    </a>
                </li>
                <li class="m-menu__item m-menu__item--submenu @if(session('sidebar') === 'charter' or session('sidebar') === 'charter-archive') m-menu__item--active @endif"
                    aria-haspopup="true" data-menu-submenu-toggle="hover">
                    <a href="{{ route('listCharter') }}" class="m-menu__link m-menu__toggle ">
                        <span class="m-menu__item-here"></span>
                        <i class="m-menu__link-icon fa fa-plane"></i>
                        <span class="m-menu__link-text">
                        Charter
                    </span>
                    </a>

                    <div class="m-menu__submenu">
                        <span class="m-menu__arrow m-menu__arrow--adjust"></span>
                        <ul class="m-menu__subnav">
                            <li class="m-menu__item @if(session('sidebar') === 'charter') m-menu__item--active @endif">
                                <a href="{{ route('listCharter') }}" class="m-menu__link ">
                                    <span class="m-menu__link-text">Active Flights</span>
                                </a>
                            </li>
                            <li class="m-menu__item @if(session('sidebar') === 'charter-archive') m-menu__item--active @endif">
                                <a href="{{ route('listCharter', ['show' => 'archive']) }}" class="m-menu__link ">
                                    <span class="m-menu__link-text">Archived Flights</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                </li>
                <li class="m-menu__item @if(session('sidebar') === 'visa') m-menu__item--active @endif"
                    aria-haspopup="true">
                    <a href="{{ route('listVisas') }}" class="m-menu__link ">
                        <span class="m-menu__item-here"></span>
                        <i class="m-menu__link-icon fa fa-money"></i>
                        <span class="m-menu__link-text">
                        Visa
                    </span>
                    </a>
                </li>
                <li class="m-menu__item @if(session('sidebar') === 'users') m-menu__item--active @endif"
                    aria-haspopup="true">
                    <a href="{{ route('listUsers') }}" class="m-menu__link ">
                        <span class="m-menu__item-here"></span>
                        <i class="m-menu__link-icon fa fa-users"></i>
                        <span class="m-menu__link-text">
                        Users
                    </span>
                    </a>
                </li>
                <li class="m-menu__item @if(session('sidebar') === 'invoices') m-menu__item--active @endif"
                    aria-haspopup="true">
                    <a href="{{ route('listInvoices') }}" class="m-menu__link ">
                        <span class="m-menu__item-here"></span>
                        <i class="m-menu__link-icon fa fa-money"></i>
                        <span class="m-menu__link-text">
                        Invoices
                    </span>
                    </a>
                </li>
                <li class="m-menu__item @if(session('sidebar') === 'news') m-menu__item--active @endif"
                    aria-haspopup="true">
                    <a href="{{ route('listNews') }}" class="m-menu__link ">
                        <span class="m-menu__item-here"></span>
                        <i class="m-menu__link-icon fa fa-users"></i>
                        <span class="m-menu__link-text">
                        News
                    </span>
                    </a>
                </li>
                <li class="m-menu__item @if(session('sidebar') === 'settings') m-menu__item--active @endif"
                    aria-haspopup="true">
                    <a href="{{ route('settings-page') }}" class="m-menu__link ">
                        <span class="m-menu__item-here"></span>
                        <i class="m-menu__link-icon fa fa-pencil"></i>
                        <span class="m-menu__link-text">
                        Settings
                    </span>
                    </a>
                </li>
                <li class="m-menu__item @if(session('sidebar') === 'about') m-menu__item--active @endif"
                    aria-haspopup="true">
                    <a href="{{ route('about-page') }}" class="m-menu__link ">
                        <span class="m-menu__item-here"></span>
                        <i class="m-menu__link-icon fa fa-drupal"></i>
                        <span class="m-menu__link-text">
                        About
                    </span>
                    </a>
                </li>
                <li class="m-menu__item @if(session('sidebar') === 'contact') m-menu__item--active @endif"
                    aria-haspopup="true">
                    <a href="{{ route('contact-page') }}" class="m-menu__link ">
                        <span class="m-menu__item-here"></span>
                        <i class="m-menu__link-icon fa fa-anchor"></i>
                        <span class="m-menu__link-text">
                        Contact
                    </span>
                    </a>
                </li>
                <li class="m-menu__item @if(session('sidebar') === 'user-portal-history') m-menu__item--active @endif"
                    aria-haspopup="true">
                    <a href="{{ route('history') }}" class="m-menu__link ">
                        <span class="m-menu__item-here"></span>
                        <i class="m-menu__link-icon fa fa-history"></i>
                        <span class="m-menu__link-text">
                        history
                    </span>
                    </a>
                </li>
                <li class="m-menu__item @if(session('sidebar') === 'pages') m-menu__item--active @endif"
                    aria-haspopup="true">
                    <a href="{{ route('listPages') }}" class="m-menu__link ">
                        <span class="m-menu__item-here"></span>
                        <i class="m-menu__link-icon la la-pagelines"></i>
                        <span class="m-menu__link-text">
                        Pages
                    </span>
                    </a>
                </li>
                <li class="m-menu__item @if(session('sidebar') === 'messages') m-menu__item--active @endif"
                    aria-haspopup="true">
                    <a href="{{ route('messages') }}" class="m-menu__link ">
                        <span class="m-menu__item-here"></span>
                        <i class="m-menu__link-icon la la-pagelines"></i>
                        <span class="m-menu__link-text">
                        Messages
                    </span>
                    </a>
                </li>
            @elseif(Auth::user()->type === 'Ticket')
                <li class="m-menu__item @if(session('sidebar') === 'ticket-charter') m-menu__item--active @endif"
                    aria-haspopup="true">
                    <a href="{{ route('ticketCharter') }}" class="m-menu__link ">
                        <span class="m-menu__item-here"></span>
                        <i class="m-menu__link-icon fa fa-plane"></i>
                        <span class="m-menu__link-text">
                        Charter
                    </span>
                    </a>
                </li>
            @elseif (Auth::user()->type === 'GSA')
              <li class="m-menu__item @if(session('sidebar') === 'users') m-menu__item--active @endif"
                    aria-haspopup="true">
                    <a href="{{ route('listUsers') }}" class="m-menu__link ">
                        <span class="m-menu__item-here"></span>
                        <i class="m-menu__link-icon fa fa-users"></i>
                        <span class="m-menu__link-text">
                        Users
                    </span>
                    </a>
                </li>
                <li class="m-menu__item @if(session('sidebar') === 'user-portal-travels') m-menu__item--active @endif"
                    aria-haspopup="true">
                    <a href="{{ route('listUserTravels') }}" class="m-menu__link ">
                        <span class="m-menu__item-here"></span>
                        <i class="m-menu__link-icon flaticon-rocket"></i>
                        <span class="m-menu__link-text">
                        Travels
                    </span>
                    </a>
                </li>
                <li class="m-menu__item @if(session('sidebar') === 'user-portal-flights') m-menu__item--active @endif"
                    aria-haspopup="true">
                    <a href="{{ route('listUserFlights') }}" class="m-menu__link ">
                        <span class="m-menu__item-here"></span>
                        <i class="m-menu__link-icon fa fa-plane"></i>
                        <span class="m-menu__link-text">
                        Flights
                    </span>
                    </a>
                </li>
                <li class="m-menu__item @if(session('sidebar') === 'user-portal-charter') m-menu__item--active @endif"
                    aria-haspopup="true">
                    <a href="{{ route('listUserCharter') }}" class="m-menu__link ">
                        <span class="m-menu__item-here"></span>
                        <i class="m-menu__link-icon fa fa-plane"></i>
                        <span class="m-menu__link-text">
                        Charter
                    </span>
                    </a>
                </li>
                <li class="m-menu__item @if(session('sidebar') === 'user-portal-visa') m-menu__item--active @endif"
                    aria-haspopup="true">
                    <a href="{{ route('listUserVisas') }}" class="m-menu__link ">
                        <span class="m-menu__item-here"></span>
                        <i class="m-menu__link-icon fa fa-money"></i>
                        <span class="m-menu__link-text">
                        Visa
                    </span>
                    </a>
                </li>
          
          
          
           <li class="m-menu__item @if(session('sidebar') === 'user-portal-index') m-menu__item--active @endif"
                    aria-haspopup="true">
                    <a href="{{ route('user-profile') }}" class="m-menu__link ">
                        <span class="m-menu__item-here"></span>
                        <i class="m-menu__link-icon flaticon-line-graph"></i>
                        <span class="m-menu__link-text">
                        Profile
                    </span>
                    </a>
                </li>
          
           <li class="m-menu__item @if(session('sidebar') === 'user-portal-history') m-menu__item--active @endif"
                    aria-haspopup="true">
                    <a href="{{ route('history') }}" class="m-menu__link ">
                        <span class="m-menu__item-here"></span>
                        <i class="m-menu__link-icon fa fa-history"></i>
                        <span class="m-menu__link-text">
                        history
                    </span>
                    </a>
                </li>
                <li class="m-menu__item @if(session('sidebar') === 'messages') m-menu__item--active @endif"
                    aria-haspopup="true">
                    <a href="{{ route('user.messages') }}" class="m-menu__link ">
                        <span class="m-menu__item-here"></span>
                        <i class="m-menu__link-icon la la-pagelines"></i>
                        <span class="m-menu__link-text">
                        Messages
                    </span>
                    </a>
                </li>
            @else
                <li class="m-menu__item @if(session('sidebar') === 'user-portal-index') m-menu__item--active @endif"
                    aria-haspopup="true">
                    <a href="{{ route('user-profile') }}" class="m-menu__link ">
                        <span class="m-menu__item-here"></span>
                        <i class="m-menu__link-icon flaticon-line-graph"></i>
                        <span class="m-menu__link-text">
                        Profile
                    </span>
                    </a>
                </li>
                <li class="m-menu__item @if(session('sidebar') === 'user-portal-travels') m-menu__item--active @endif"
                    aria-haspopup="true">
                    <a href="{{ route('listUserTravels') }}" class="m-menu__link ">
                        <span class="m-menu__item-here"></span>
                        <i class="m-menu__link-icon flaticon-rocket"></i>
                        <span class="m-menu__link-text">
                        Travels
                    </span>
                    </a>
                </li>
                <li class="m-menu__item @if(session('sidebar') === 'user-portal-flights') m-menu__item--active @endif"
                    aria-haspopup="true">
                    <a href="{{ route('listUserFlights') }}" class="m-menu__link ">
                        <span class="m-menu__item-here"></span>
                        <i class="m-menu__link-icon fa fa-plane"></i>
                        <span class="m-menu__link-text">
                        Flights
                    </span>
                    </a>
                </li>
                <li class="m-menu__item @if(session('sidebar') === 'user-portal-charter') m-menu__item--active @endif"
                    aria-haspopup="true">
                    <a href="{{ route('listUserCharter') }}" class="m-menu__link ">
                        <span class="m-menu__item-here"></span>
                        <i class="m-menu__link-icon fa fa-plane"></i>
                        <span class="m-menu__link-text">
                        Charter
                    </span>
                    </a>
                </li>
                <li class="m-menu__item @if(session('sidebar') === 'user-portal-visa') m-menu__item--active @endif"
                    aria-haspopup="true">
                    <a href="{{ route('listUserVisas') }}" class="m-menu__link ">
                        <span class="m-menu__item-here"></span>
                        <i class="m-menu__link-icon fa fa-money"></i>
                        <span class="m-menu__link-text">
                        Visa
                    </span>
                    </a>
                </li>
                @if(Auth::user()->showInvoices === 1)
                    <li class="m-menu__item @if(session('sidebar') === 'invoices') m-menu__item--active @endif"
                        aria-haspopup="true">
                        <a href="{{ route('listUserInvoices') }}" class="m-menu__link ">
                            <span class="m-menu__item-here"></span>
                            <i class="m-menu__link-icon fa fa-money"></i>
                            <span class="m-menu__link-text">
                        Invoices
                    </span>
                        </a>
                    </li>
                @endif
                <li class="m-menu__item @if(session('sidebar') === 'user-portal-history') m-menu__item--active @endif"
                    aria-haspopup="true">
                    <a href="{{ route('history') }}" class="m-menu__link ">
                        <span class="m-menu__item-here"></span>
                        <i class="m-menu__link-icon fa fa-history"></i>
                        <span class="m-menu__link-text">
                        history
                    </span>
                    </a>
                </li>
                <li class="m-menu__item @if(session('sidebar') === 'messages') m-menu__item--active @endif"
                    aria-haspopup="true">
                    <a href="{{ route('user.messages') }}" class="m-menu__link ">
                        <span class="m-menu__item-here"></span>
                        <i class="m-menu__link-icon la la-pagelines"></i>
                        <span class="m-menu__link-text">
                        Messages
                    </span>
                    </a>
                </li>

            @endif
        </ul>
    </div>
    <!-- END: Aside Menu -->
</div>
<!-- END: Left Aside -->