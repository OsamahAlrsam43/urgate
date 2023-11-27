<!-- BEGIN: Header -->
<header class="m-grid__item m-header " data-minimize-offset="200" data-minimize-mobile-offset="200">
    <div class="m-container m-container--fluid m-container--full-height">
        <div class="m-stack m-stack--ver m-stack--desktop">
            <!-- BEGIN: Brand -->
            <div class="m-stack__item m-brand  m-brand--skin-dark ">
                <div class="m-stack m-stack--ver m-stack--general">
                    <div class="m-stack__item m-stack__item--middle m-stack__item--center m-brand__logo">
                        <a href="{{ route('front-home') }}" class="m-brand__logo-wrapper">
                            <img alt="" src="{{ asset('front-assets/images/basic/logo.png') }}"
                                 style="width: 66px;height: auto;"/>
                        </a>
                    </div>
                    <div class="m-stack__item m-stack__item--middle m-brand__tools">
                        <!-- BEGIN: Responsive Aside Left Menu Toggler -->
                        <a href="javascript:;" id="m_aside_left_offcanvas_toggle"
                           class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
                            <span></span>
                        </a>
                        <!-- END -->
                        <!-- BEGIN: Responsive Header Menu Toggler -->
                        <a id="m_aside_header_menu_mobile_toggle" href="javascript:;"
                           class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
                            <span></span>
                        </a>
                        <!-- END -->
                        <!-- BEGIN: Topbar Toggler -->
                        <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;"
                           class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
                            <i class="flaticon-more"></i>
                        </a>
                        <!-- BEGIN: Topbar Toggler -->
                    </div>
                </div>
            </div>
            <!-- END: Brand -->
            <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
                <div class="m-stack__item pull-left p-4">
                    @if(Auth::user()->hasParent())
                        <h3><span class="text-info">{{Auth::user()->parent_company->company}}</span> Company</h3>
                    @endif

                    @hasSection('header')
                        <h3>@yield('header')</h3>
                    @endif
                </div>

                <!-- BEGIN: Topbar -->
                <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
                    <div class="m-stack__item m-topbar__nav-wrapper">
                        <ul class="m-topbar__nav m-nav m-nav--inline">
                            <li class="m-nav__item m-topbar__quick-actions m-topbar__quick-actions--img m-dropdown m-dropdown--large m-dropdown--header-bg-fill m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push m-dropdown--mobile-full-width m-dropdown--skin-light"
                                data-dropdown-toggle="click">
                                <a href="#" class="m-nav__link m-dropdown__toggle" id="m_topbar_notification_icon">
                                    <span id="alert"
                                          class="m-nav__link-badge m-badge m-badge--dot m-badge--dot-small {{ Auth::user()->unreadNotifications->count() ?  'm-badge--danger' : ''}}"></span>
                                    <span class="m-nav__link-icon">
                                        <i class="flaticon-music-2"></i>
                                    </span>
                                </a>
                                <div class="m-dropdown__wrapper">
                                    <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                    <div class="m-dropdown__inner">
                                        <div class="m-dropdown__header m--align-center"
                                             style="background: url(/assets/app/media/img/misc/notification_bg.jpg); background-size: cover;">
                                            <span class="m-dropdown__header-title">
                                                <span id="notification-counter"
                                                      class="{{ Auth::user()->unreadNotifications->count() ? '' : 'm--hide'}}">{{ Auth::user()->unreadNotifications->count() }}</span>
                                                <span id="notification-text"
                                                      class="{{ Auth::user()->unreadNotifications->count() ? '' : 'm--hide'}}">new</span>
                                                <span id="no-notifications"
                                                      class="{{ Auth::user()->unreadNotifications->count() ? 'm--hide' : ''}}">no new notifications</span>
                                            </span>
                                            <span class="m-dropdown__header-subtitle">
                                                User Notifications
                                            </span>
                                        </div>
                                        <div class="m-dropdown__body" style="height: 290px !important;overflow: scroll;">
                                            <div class="m-dropdown__content">
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="topbar_notifications_notifications"
                                                         role="tabpanel">
                                                        <div class="m-scrollable" data-scrollable="true"
                                                             data-max-height="250" data-mobile-max-height="200">
                                                            <div class="m-list-timeline m-list-timeline--skin-light">
                                                                <div class="m-list-timeline__items"
                                                                     id="notificationsArea">
                                                                    @foreach(Auth::user()->notifications()->limit(20)->get() as $notification)
                                                                        <div class="m-list-timeline__item">
                                                                            <span class="m-list-timeline__badge -m-list-timeline__badge--state-success"></span>
                                                                            <span class="m-list-timeline__text message"
                                                                                  @if($notification->read_at === null)
                                                                                  data-notification-id="{{ $notification->id }}"
                                                                                  data-url="{{ $notification->data['data']['url'] }}"
                                                                                    @endif>
                                                                                @if($notification->read_at === null)
                                                                                    {{ $notification->data['data']['message'] }}
                                                                                @else
                                                                                    <a href="{{ $notification->data['data']['url'] }}"
                                                                                       style="text-decoration: none;color: #575962;">
                                                                                        {{ $notification->data['data']['message'] }}
                                                                                    </a>
                                                                                @endif
                                                                                @if($notification->read_at === null)
                                                                                    <span class="m-badge m-badge--danger m-badge--wide">new</span>
                                                                                @endif
                                                                            </span>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>


                            <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light"
                                data-dropdown-toggle="click">
                                <a href="#" class="m-nav__link m-dropdown__toggle">
                                    <span class="m-topbar__userpic">
                                        <img src="{{ Auth::user()->avatar ? url('/storage/app/public/'.Auth::user()->avatar) : asset('custom/images/avatar.jpg') }}" alt=""/>
                                    </span>
                                </a>
                                <div class="m-dropdown__wrapper">
                                    <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                    <div class="m-dropdown__inner">
                                        <div class="m-dropdown__header m--align-center"
                                             style="background: url(/assets/app/media/img/misc/user_profile_bg.jpg); background-size: cover;">
                                            <div class="m-card-user m-card-user--skin-dark">
                                                <div class="m-card-user__pic">
                                                    <img src="{{ asset('custom/images/avatar.jpg') }}"
                                                         alt=""/>
                                                </div>
                                                <div class="m-card-user__details">
                                                    <span class="m-card-user__name m--font-weight-500">
                                                        {{ Auth::user()->name }}
                                                    </span>
                                                    <a href="" class="m-card-user__email m--font-weight-300 m-link">
                                                        {{ Auth::user()->email }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-dropdown__body">
                                            <div class="m-dropdown__content">
                                                <ul class="m-nav m-nav--skin-light">
                                                    <li class="m-nav__section m--hide">
                                                        <span class="m-nav__section-text">
                                                            Section
                                                        </span>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="{{ Auth::user()->type === 'Super Admin' ? route('user-profile') : route('user-profile')}}"
                                                           class="m-nav__link">
                                                            <i class="m-nav__link-icon flaticon-profile-1"></i>
                                                            <span class="m-nav__link-title">
                                                                <span class="m-nav__link-wrap">
                                                                    <span class="m-nav__link-text">
                                                                        My Profile
                                                                    </span>
                                                                </span>
                                                            </span>
                                                        </a>
                                                    </li>
                                                    <li class="m-nav__separator m-nav__separator--fit"></li>
                                                    <li class="m-nav__item">
                                                        <a href="{{ Auth::user()->type === 'Super Admin' ? route('logout') : route('front-logout') }}"
                                                           class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">
                                                            Logout
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- END: Topbar -->
            </div>
        </div>
    </div>
</header>

<style>.nav-options {
    background: gold;
    padding: 5px 88px 1px 88px;
    margin-bottom: 0;
}@media screen and (min-width: 768px){.btn-group-sm>.btn, .btn-sm {
    padding: .2rem .1rem;
    font-size: .475rem;
    line-height: 1.5;
    border-radius: .2rem;
}}</style>
<!-- END: Header -->