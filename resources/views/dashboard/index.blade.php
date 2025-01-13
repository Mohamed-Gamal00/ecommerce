<!doctype html>
<html lang="en" dir="rtl">

@include('layouts.header')

<body data-sidebar="dark">

    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <div class="navbar-brand-box">
                        <a href="index.html" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="17">
                            </span>
                        </a>

                        <x-dashboard.sidebarlogo />
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect"
                        id="vertical-menu-btn">
                        <i class="mdi mdi-menu"></i>
                    </button>

                    {{-- <div class="d-none d-sm-block">
					<div class="pt-3 d-inline-block">
						<a class="btn btn-secondary dropdown-toggle" target="_blank" href="{{route('front.home')}}">
							الذهاب للموقع
						</a>
					</div>
				</div> --}}

                </div>

                <div class="d-flex">
                    <div class="dropdown d-none d-lg-inline-block">
                        <button type="button" class="btn header-item noti-icon waves-effect"
                            data-bs-toggle="fullscreen">
                            <i class="mdi mdi-fullscreen"></i>
                        </button>
                    </div>

                    <x-dashboard.notificationmenu count="28" />

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @if (auth()->guard('admin')->user()->image)
                                <img class="rounded-circle header-profile-user"
                                    src="{{ asset('storage/' . auth()->guard('admin')->user()->image) }}"
                                    alt="Header Avatar">
                            @else
                                <img class="rounded-circle header-profile-user"
                                    src="{{ asset('assets/images/admin.jpg') }}" alt="Header Avatar">
                            @endif
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a class="dropdown-item" href="{{ route('profile.index') }}"><i
                                    class="mdi mdi-account-circle font-size-17 align-middle me-1"></i>البيانات
                                الشخصيه</a>

                            <a class="dropdown-item d-flex align-items-center"
                                href="{{ route('profile.settings.index') }}"><i
                                    class="mdi mdi-cog font-size-17 align-middle me-1"></i>الاعدادات</a>

                            <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item d-flex align-items-center">
                                    <a><i class="mdi mdi-logout font-size-17 align-middle me-1"></i>تسجيل خروج</a>
                                </button>
                            </form>
                            {{-- <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.logout') }}"><i
                                    class="mdi mdi-logout font-size-17 align-middle me-1"></i>تسجيل خروج</a> --}}
                        </div>
                    </div>

                </div>
            </div>
        </header>

        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">
            <div data-simplebar class="h-100">
                <!--- Sidemenu -->
                <x-dashboard.side-bar />
                <!-- Sidebar -->
            </div>
        </div>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->

        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                    <div class="page-title-box">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h3 class="page-title">@yield('title')</h3>
                                <ol class="breadcrumb m-0">
                                    @if (!request()->routeIs('dashboard.index'))
                                        <li class="breadcrumb-item"><a
                                                href="{{ route('dashboard.index') }}">الرئيسية</a></li>
                                        @yield('breadcrumb')
                                    @endif
                                </ol>
                            </div>
                        </div>
                    </div>

                    @yield('section')

                    <!-- End Page-content -->

                </div>
            </div>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    @include('layouts.scripts')

</body>

</html>
