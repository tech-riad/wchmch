@extends('backend.layouts.app')

@section('content')

<div class="layout-wrapper layout-content-navbar  ">
    <div class="layout-container">
        <!-- Menu -->
        <div class="menu-mobile-toggler d-xl-none rounded-1">
            <a href="javascript:void(0);"
                class="layout-menu-toggle menu-link text-large text-bg-secondary p-2 rounded-1">
                <i class="ti tabler-menu icon-base"></i>
                <i class="ti tabler-chevron-right icon-base"></i>
            </a>
        </div>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->

            <!-- / Navbar -->

            <!-- Content wrapper -->

            <div class="content-wrapper">
                <!-- Content -->
                <div class="container-xxl flex-grow-1 container-p-y">
                    <!-- Header -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-6">
                                {{-- <div class="user-profile-header-banner">
                                    <img src="../../assets/img/pages/profile-banner.png" alt="Banner image"
                                        class="rounded-top" />
                                </div> --}}
                                <div
                                    class="user-profile-header d-flex flex-column flex-lg-row text-sm-start text-center mb-5">
                                    <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                                        <img src="../../assets/img/avatars/1.png" alt="user image"
                                            class="d-block h-auto ms-0 ms-sm-6 rounded user-profile-img" />
                                    </div>
                                    <div class="flex-grow-1 mt-3 mt-lg-5">
                                        <div
                                            class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-5 flex-md-row flex-column gap-4">
                                            <div class="user-profile-info">
                                                <h4 class="mb-2 mt-lg-6">John Doe</h4>
                                                <ul
                                                    class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-4 my-2">
                                                    <li class="list-inline-item d-flex gap-2 align-items-center">
                                                        <i class="icon-base ti tabler-palette icon-lg"></i><span
                                                            class="fw-medium">UX Designer</span>
                                                    </li>
                                                    <li class="list-inline-item d-flex gap-2 align-items-center">
                                                        <i class="icon-base ti tabler-map-pin  icon-lg"></i><span
                                                            class="fw-medium">Vatican City</span>
                                                    </li>
                                                    <li class="list-inline-item d-flex gap-2 align-items-center">
                                                        <i class="icon-base ti tabler-calendar  icon-lg"></i><span
                                                            class="fw-medium"> Joined April 2021</span>
                                                    </li>
                                                </ul>
                                            </div>
                                            <a href="javascript:void(0)" class="btn btn-primary mb-1">
                                                <i class="icon-base ti tabler-user-check icon-xs me-2"></i>Connected
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Header -->

                    <!-- Navbar pills -->
                    @include('backend.client.nav')
                    <!--/ Navbar pills -->

                    <!-- User Profile Content -->
                    {{-- @php
                    dd($products);
                    @endphp --}}
                    @if ($products !== null && count($products) > 0)
                    <h2>Hello</h2>

                    @else
                    <div class="row">
                        <div class="card mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="context-btn-container">
                                        <div class="gracefulexit"
                                            style="min-height: 200px; display: flex; align-items: center; justify-content: center; text-align: center;">
                                            No products/services found for this user.
                                            <a href="#">Click here</a> to place a new order.
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif


                    <!--/ User Profile Content -->
                </div>
                <!-- / Content -->

                <!-- Footer -->
                <footer class="content-footer footer bg-footer-theme">
                    <div class="container-xxl">
                        <div
                            class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                            <div class="text-body">
                                &#169;
                                <script>
                                    document.write(new Date().getFullYear());

                                </script>
                                , made with ❤️ by <a href="https://pixinvent.com" target="_blank"
                                    class="footer-link">Pixinvent</a>
                            </div>
                            <div class="d-none d-lg-inline-block">
                                <a href="https://themeforest.net/licenses/standard" class="footer-link me-4"
                                    target="_blank">License</a>
                                <a href="https://themeforest.net/user/pixinvent/portfolio" target="_blank"
                                    class="footer-link me-4">More Themes</a>

                                <a href="https://demos.pixinvent.com/vuexy-html-admin-template/documentation/"
                                    target="_blank" class="footer-link me-4">Documentation</a>

                                <a href="https://pixinvent.ticksy.com/" target="_blank"
                                    class="footer-link d-none d-sm-inline-block">Support</a>
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- / Footer -->

                <div class="content-backdrop fade"></div>
            </div>

            <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>
</div>


@endsection
