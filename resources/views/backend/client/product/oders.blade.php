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

            <nav class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme"
                id="layout-navbar">
                <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0   d-xl-none ">
                    <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                        <i class="icon-base ti tabler-menu-2 icon-md"></i>
                    </a>
                </div>

                <div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">
                    <!-- Search -->
                    <div class="navbar-nav align-items-center">
                        <div class="nav-item navbar-search-wrapper px-md-0 px-2 mb-0">
                            <a class="nav-item nav-link search-toggler d-flex align-items-center px-0"
                                href="javascript:void(0);">
                                <span class="d-inline-block text-body-secondary fw-normal" id="autocomplete"></span>
                            </a>
                        </div>
                    </div>

                    <!-- /Search -->

                    <ul class="navbar-nav flex-row align-items-center ms-md-auto">
                        <li class="nav-item dropdown-language dropdown me-2 me-xl-0">
                            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                data-bs-toggle="dropdown">
                                <i class="icon-base ti tabler-language icon-22px text-heading"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0);" data-language="en"
                                        data-text-direction="ltr">
                                        <span>English</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0);" data-language="fr"
                                        data-text-direction="ltr">
                                        <span>French</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0);" data-language="ar"
                                        data-text-direction="rtl">
                                        <span>Arabic</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0);" data-language="de"
                                        data-text-direction="ltr">
                                        <span>German</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!--/ Language -->

                        <!-- Style Switcher -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle hide-arrow btn btn-icon btn-text-secondary rounded-pill"
                                id="nav-theme" href="javascript:void(0);" data-bs-toggle="dropdown">
                                <i class="icon-base ti tabler-sun icon-22px theme-icon-active text-heading"></i>
                                <span class="d-none ms-2" id="nav-theme-text">Toggle theme</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="nav-theme-text">
                                <li>
                                    <button type="button" class="dropdown-item align-items-center active"
                                        data-bs-theme-value="light" aria-pressed="false">
                                        <span><i class="icon-base ti tabler-sun icon-22px me-3"
                                                data-icon="sun"></i>Light</span>
                                    </button>
                                </li>
                                <li>
                                    <button type="button" class="dropdown-item align-items-center"
                                        data-bs-theme-value="dark" aria-pressed="true">
                                        <span><i class="icon-base ti tabler-moon-stars icon-22px me-3"
                                                data-icon="moon-stars"></i>Dark</span>
                                    </button>
                                </li>
                                <li>
                                    <button type="button" class="dropdown-item align-items-center"
                                        data-bs-theme-value="system" aria-pressed="false">
                                        <span><i class="icon-base ti tabler-device-desktop-analytics icon-22px me-3"
                                                data-icon="device-desktop-analytics"></i>System</span>
                                    </button>
                                </li>
                            </ul>
                        </li>
                        <!-- / Style Switcher-->

                        <!-- Quick links  -->
                        <li class="nav-item dropdown-shortcuts navbar-dropdown dropdown">
                            <a class="nav-link dropdown-toggle hide-arrow btn btn-icon btn-text-secondary rounded-pill"
                                href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                                aria-expanded="false">
                                <i class="icon-base ti tabler-layout-grid-add icon-22px text-heading"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end p-0">
                                <div class="dropdown-menu-header border-bottom">
                                    <div class="dropdown-header d-flex align-items-center py-3">
                                        <h6 class="mb-0 me-auto">Shortcuts</h6>
                                        <a href="javascript:void(0)"
                                            class="dropdown-shortcuts-add py-2 btn btn-text-secondary rounded-pill btn-icon"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Add shortcuts"><i
                                                class="icon-base ti tabler-plus icon-20px text-heading"></i></a>
                                    </div>
                                </div>
                                <div class="dropdown-shortcuts-list scrollable-container">
                                    <div class="row row-bordered overflow-visible g-0">
                                        <div class="dropdown-shortcuts-item col">
                                            <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                                <i class="icon-base ti tabler-calendar icon-26px text-heading"></i>
                                            </span>
                                            <a href="app-calendar.html" class="stretched-link">Calendar</a>
                                            <small>Appointments</small>
                                        </div>
                                        <div class="dropdown-shortcuts-item col">
                                            <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                                <i class="icon-base ti tabler-file-dollar icon-26px text-heading"></i>
                                            </span>
                                            <a href="app-invoice-list.html" class="stretched-link">Invoice App</a>
                                            <small>Manage Accounts</small>
                                        </div>
                                    </div>
                                    <div class="row row-bordered overflow-visible g-0">
                                        <div class="dropdown-shortcuts-item col">
                                            <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                                <i class="icon-base ti tabler-user icon-26px text-heading"></i>
                                            </span>
                                            <a href="app-user-list.html" class="stretched-link">User App</a>
                                            <small>Manage Users</small>
                                        </div>
                                        <div class="dropdown-shortcuts-item col">
                                            <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                                <i class="icon-base ti tabler-users icon-26px text-heading"></i>
                                            </span>
                                            <a href="app-access-roles.html" class="stretched-link">Role Management</a>
                                            <small>Permission</small>
                                        </div>
                                    </div>
                                    <div class="row row-bordered overflow-visible g-0">
                                        <div class="dropdown-shortcuts-item col">
                                            <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                                <i
                                                    class="icon-base ti tabler-device-desktop-analytics icon-26px text-heading"></i>
                                            </span>
                                            <a href="index.html" class="stretched-link">Dashboard</a>
                                            <small>User Dashboard</small>
                                        </div>
                                        <div class="dropdown-shortcuts-item col">
                                            <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                                <i class="icon-base ti tabler-settings icon-26px text-heading"></i>
                                            </span>
                                            <a href="pages-account-settings-account.html"
                                                class="stretched-link">Setting</a>
                                            <small>Account Settings</small>
                                        </div>
                                    </div>
                                    <div class="row row-bordered overflow-visible g-0">
                                        <div class="dropdown-shortcuts-item col">
                                            <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                                <i class="icon-base ti tabler-help-circle icon-26px text-heading"></i>
                                            </span>
                                            <a href="pages-faq.html" class="stretched-link">FAQs</a>
                                            <small>FAQs & Articles</small>
                                        </div>
                                        <div class="dropdown-shortcuts-item col">
                                            <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                                <i class="icon-base ti tabler-square icon-26px text-heading"></i>
                                            </span>
                                            <a href="modal-examples.html" class="stretched-link">Modals</a>
                                            <small>Useful Popups</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- Quick links -->

                        <!-- Notification -->
                        <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-2">
                            <a class="nav-link dropdown-toggle hide-arrow btn btn-icon btn-text-secondary rounded-pill"
                                href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                                aria-expanded="false">
                                <span class="position-relative">
                                    <i class="icon-base ti tabler-bell icon-22px text-heading"></i>
                                    <span
                                        class="badge rounded-pill bg-danger badge-dot badge-notifications border"></span>
                                </span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end p-0">
                                <li class="dropdown-menu-header border-bottom">
                                    <div class="dropdown-header d-flex align-items-center py-3">
                                        <h6 class="mb-0 me-auto">Notification</h6>
                                        <div class="d-flex align-items-center h6 mb-0">
                                            <span class="badge bg-label-primary me-2">8 New</span>
                                            <a href="javascript:void(0)"
                                                class="dropdown-notifications-all p-2 btn btn-icon"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Mark all as read"><i
                                                    class="icon-base ti tabler-mail-opened text-heading"></i></a>
                                        </div>
                                    </div>
                                </li>
                                <li class="dropdown-notifications-list scrollable-container">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item list-group-item-action dropdown-notifications-item">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar">
                                                        <img src="../../assets/img/avatars/1.png" alt
                                                            class="rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="small mb-1">Congratulation Lettie 🎉</h6>
                                                    <small class="mb-1 d-block text-body">Won the monthly best seller
                                                        gold badge</small>
                                                    <small class="text-body-secondary">1h ago</small>
                                                </div>
                                                <div class="flex-shrink-0 dropdown-notifications-actions">
                                                    <a href="javascript:void(0)"
                                                        class="dropdown-notifications-read"><span
                                                            class="badge badge-dot"></span></a>
                                                    <a href="javascript:void(0)"
                                                        class="dropdown-notifications-archive"><span
                                                            class="icon-base ti tabler-x"></span></a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item list-group-item-action dropdown-notifications-item">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar">
                                                        <span
                                                            class="avatar-initial rounded-circle bg-label-danger">CF</span>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1 small">Charles Franklin</h6>
                                                    <small class="mb-1 d-block text-body">Accepted your
                                                        connection</small>
                                                    <small class="text-body-secondary">12hr ago</small>
                                                </div>
                                                <div class="flex-shrink-0 dropdown-notifications-actions">
                                                    <a href="javascript:void(0)"
                                                        class="dropdown-notifications-read"><span
                                                            class="badge badge-dot"></span></a>
                                                    <a href="javascript:void(0)"
                                                        class="dropdown-notifications-archive"><span
                                                            class="icon-base ti tabler-x"></span></a>
                                                </div>
                                            </div>
                                        </li>
                                        <li
                                            class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar">
                                                        <img src="../../assets/img/avatars/2.png" alt
                                                            class="rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1 small">New Message ✉️</h6>
                                                    <small class="mb-1 d-block text-body">You have new message from
                                                        Natalie</small>
                                                    <small class="text-body-secondary">1h ago</small>
                                                </div>
                                                <div class="flex-shrink-0 dropdown-notifications-actions">
                                                    <a href="javascript:void(0)"
                                                        class="dropdown-notifications-read"><span
                                                            class="badge badge-dot"></span></a>
                                                    <a href="javascript:void(0)"
                                                        class="dropdown-notifications-archive"><span
                                                            class="icon-base ti tabler-x"></span></a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item list-group-item-action dropdown-notifications-item">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar">
                                                        <span class="avatar-initial rounded-circle bg-label-success"><i
                                                                class="icon-base ti tabler-shopping-cart"></i></span>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1 small">Whoo! You have new order 🛒</h6>
                                                    <small class="mb-1 d-block text-body">ACME Inc. made new order
                                                        $1,154</small>
                                                    <small class="text-body-secondary">1 day ago</small>
                                                </div>
                                                <div class="flex-shrink-0 dropdown-notifications-actions">
                                                    <a href="javascript:void(0)"
                                                        class="dropdown-notifications-read"><span
                                                            class="badge badge-dot"></span></a>
                                                    <a href="javascript:void(0)"
                                                        class="dropdown-notifications-archive"><span
                                                            class="icon-base ti tabler-x"></span></a>
                                                </div>
                                            </div>
                                        </li>
                                        <li
                                            class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar">
                                                        <img src="../../assets/img/avatars/9.png" alt
                                                            class="rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1 small">Application has been approved 🚀</h6>
                                                    <small class="mb-1 d-block text-body">Your ABC project application
                                                        has been approved.</small>
                                                    <small class="text-body-secondary">2 days ago</small>
                                                </div>
                                                <div class="flex-shrink-0 dropdown-notifications-actions">
                                                    <a href="javascript:void(0)"
                                                        class="dropdown-notifications-read"><span
                                                            class="badge badge-dot"></span></a>
                                                    <a href="javascript:void(0)"
                                                        class="dropdown-notifications-archive"><span
                                                            class="icon-base ti tabler-x"></span></a>
                                                </div>
                                            </div>
                                        </li>
                                        <li
                                            class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar">
                                                        <span class="avatar-initial rounded-circle bg-label-success"><i
                                                                class="icon-base ti tabler-chart-pie"></i></span>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1 small">Monthly report is generated</h6>
                                                    <small class="mb-1 d-block text-body">July monthly financial report
                                                        is generated </small>
                                                    <small class="text-body-secondary">3 days ago</small>
                                                </div>
                                                <div class="flex-shrink-0 dropdown-notifications-actions">
                                                    <a href="javascript:void(0)"
                                                        class="dropdown-notifications-read"><span
                                                            class="badge badge-dot"></span></a>
                                                    <a href="javascript:void(0)"
                                                        class="dropdown-notifications-archive"><span
                                                            class="icon-base ti tabler-x"></span></a>
                                                </div>
                                            </div>
                                        </li>
                                        <li
                                            class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar">
                                                        <img src="../../assets/img/avatars/5.png" alt
                                                            class="rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1 small">Send connection request</h6>
                                                    <small class="mb-1 d-block text-body">Peter sent you connection
                                                        request</small>
                                                    <small class="text-body-secondary">4 days ago</small>
                                                </div>
                                                <div class="flex-shrink-0 dropdown-notifications-actions">
                                                    <a href="javascript:void(0)"
                                                        class="dropdown-notifications-read"><span
                                                            class="badge badge-dot"></span></a>
                                                    <a href="javascript:void(0)"
                                                        class="dropdown-notifications-archive"><span
                                                            class="icon-base ti tabler-x"></span></a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item list-group-item-action dropdown-notifications-item">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar">
                                                        <img src="../../assets/img/avatars/6.png" alt
                                                            class="rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1 small">New message from Jane</h6>
                                                    <small class="mb-1 d-block text-body">Your have new message from
                                                        Jane</small>
                                                    <small class="text-body-secondary">5 days ago</small>
                                                </div>
                                                <div class="flex-shrink-0 dropdown-notifications-actions">
                                                    <a href="javascript:void(0)"
                                                        class="dropdown-notifications-read"><span
                                                            class="badge badge-dot"></span></a>
                                                    <a href="javascript:void(0)"
                                                        class="dropdown-notifications-archive"><span
                                                            class="icon-base ti tabler-x"></span></a>
                                                </div>
                                            </div>
                                        </li>
                                        <li
                                            class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar">
                                                        <span class="avatar-initial rounded-circle bg-label-warning"><i
                                                                class="icon-base ti tabler-alert-triangle"></i></span>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1 small">CPU is running high</h6>
                                                    <small class="mb-1 d-block text-body">CPU Utilization Percent is
                                                        currently at 88.63%,</small>
                                                    <small class="text-body-secondary">5 days ago</small>
                                                </div>
                                                <div class="flex-shrink-0 dropdown-notifications-actions">
                                                    <a href="javascript:void(0)"
                                                        class="dropdown-notifications-read"><span
                                                            class="badge badge-dot"></span></a>
                                                    <a href="javascript:void(0)"
                                                        class="dropdown-notifications-archive"><span
                                                            class="icon-base ti tabler-x"></span></a>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                                <li class="border-top">
                                    <div class="d-grid p-4">
                                        <a class="btn btn-primary btn-sm d-flex" href="javascript:void(0);">
                                            <small class="align-middle">View all notifications</small>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <!--/ Notification -->

                        <!-- User -->
                        <li class="nav-item navbar-dropdown dropdown-user dropdown">
                            <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);"
                                data-bs-toggle="dropdown">
                                <div class="avatar avatar-online">
                                    <img src="../../assets/img/avatars/1.png" alt class="rounded-circle" />
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item mt-0" href="pages-account-settings-account.html">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-2">
                                                <div class="avatar avatar-online">
                                                    <img src="../../assets/img/avatars/1.png" alt
                                                        class="rounded-circle" />
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-0">John Doe</h6>
                                                <small class="text-body-secondary">Admin</small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <div class="dropdown-divider my-1 mx-n2"></div>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="pages-profile-user.html">
                                        <i class="icon-base ti tabler-user me-3 icon-md"></i><span
                                            class="align-middle">My Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="pages-account-settings-account.html">
                                        <i class="icon-base ti tabler-settings me-3 icon-md"></i><span
                                            class="align-middle">Settings</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="pages-account-settings-billing.html">
                                        <span class="d-flex align-items-center align-middle">
                                            <i
                                                class="flex-shrink-0 icon-base ti tabler-file-dollar me-3 icon-md"></i><span
                                                class="flex-grow-1 align-middle">Billing</span>
                                            <span
                                                class="flex-shrink-0 badge bg-danger d-flex align-items-center justify-content-center">4</span>
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <div class="dropdown-divider my-1 mx-n2"></div>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="pages-pricing.html">
                                        <i class="icon-base ti tabler-currency-dollar me-3 icon-md"></i><span
                                            class="align-middle">Pricing</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="pages-faq.html">
                                        <i class="icon-base ti tabler-question-mark me-3 icon-md"></i><span
                                            class="align-middle">FAQ</span>
                                    </a>
                                </li>
                                <li>
                                    <div class="d-grid px-2 pt-2 pb-1">
                                        <a class="btn btn-sm btn-danger d-flex" href="auth-login-cover.html"
                                            target="_blank">
                                            <small class="align-middle">Logout</small>
                                            <i class="icon-base ti tabler-logout ms-2 icon-14px"></i>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <!--/ User -->
                    </ul>
                </div>
            </nav>

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
                      <img src="../../assets/img/pages/profile-banner.png" alt="Banner image" class="rounded-top" />
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
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-xl-12">
                            <!-- About User -->


                            {{-- TOP CONTEXT BAR (WHMCS style) --}}
                            <div class="card shadow-sm mb-3">
                                <div class="card-body">
                                    <div class="row g-3 align-items-center">

                                        {{-- Service Selector --}}
                                        <div class="col-lg-7">
                                            <form method="get" action="/admin/clientsservices.php" id="frm2"
                                                class="d-flex gap-2 flex-wrap">
                                                <input type="hidden" name="userid" value="{{ $userid ?? 7 }}">

                                                @php
                                                    $latestId = collect($productsclient)->last()['id'] ?? null;
                                                @endphp

                                                <select name="productselect"
                                                        class="form-select"
                                                        style="max-width: 560px;"
                                                        onchange="this.form.submit()">

                                                    @foreach($productsclient as $s)
                                                        <option value="{{ $s['id'] }}"
                                                                @selected($s['id'] == $latestId)>
                                                            {{ $s['name'] }} - {{ $s['domain'] }}
                                                        </option>
                                                    @endforeach

                                                </select>


                                                <button type="submit" class="btn btn-outline-secondary">
                                                    Go
                                                </button>
                                            </form>
                                        </div>

                                        {{-- Right Area: SSL + Actions --}}
                                        <div class="col-lg-5">
                                            <div
                                                class="d-flex justify-content-lg-end align-items-center gap-2 flex-wrap">

                                                {{-- SSL State --}}
                                                @php $domain = $service['domain'] ?? 'abcgmail.com'; @endphp
                                                <span
                                                    class="badge rounded-pill bg-danger-subtle text-danger border border-danger-subtle px-3 py-2"
                                                    data-bs-toggle="tooltip" data-bs-title="No SSL Detected.">
                                                    <i class="fa-solid fa-lock me-1"></i> SSL Inactive
                                                </span>

                                                <button type="button" class="btn btn-primary"
                                                    onclick="runModuleCommand('singlesignon'); return false;">
                                                    <i class="fa-solid fa-right-to-bracket me-1"></i> Login to Control
                                                    Panel
                                                </button>

                                                <a href="clientsservices.php?userid={{ $userid ?? 7 }}&id={{ $serviceId ?? 5 }}&aid=add"
                                                    class="btn btn-outline-secondary">
                                                    <i class="fa-solid fa-plus me-1"></i> New Addon
                                                </a>

                                                <div class="dropdown">
                                                    <button class="btn btn-outline-secondary dropdown-toggle"
                                                        data-bs-toggle="dropdown">
                                                        More
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="clientsinvoices.php?userid={{ $userid ?? 7 }}&serviceid={{ $serviceId ?? 5 }}">
                                                                <i class="fa-solid fa-file-invoice me-2"></i> View
                                                                Invoices
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="clientsupgrade.php?id={{ $serviceId ?? 5 }}">
                                                                <i class="fa-solid fa-circle-up me-2"></i>
                                                                Upgrade/Downgrade
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="#"
                                                                onclick="window.open('clientsmove.php?type=hosting&id={{ $serviceId ?? 5 }}','movewindow','width=500,height=500,top=100,left=100,scrollbars=yes');return false">
                                                                <i class="fa-solid fa-shuffle me-2"></i> Transfer
                                                                Ownership
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>

                                                        <li>
                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                                data-bs-target="#modalSendEmail">
                                                                <i class="fa-solid fa-envelope me-2"></i> Send Message
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="#"
                                                                id="btnResendWelcomeEmail">
                                                                <i class="fa-solid fa-star me-2"></i> Resend Welcome
                                                                Email
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>

                                                        <li>
                                                            <a class="dropdown-item text-danger" href="#"
                                                                data-bs-toggle="modal" data-bs-target="#modalDelete">
                                                                <i class="fa-solid fa-trash me-2"></i> Delete
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            {{-- MAIN LAYOUT: Left Form + Right Sidebar --}}
                            <div class="row g-3">

                                {{-- LEFT: SERVICE FORM --}}
                                <div class="col-xl-8">

                                    <form method="post" action="?userid={{ $userid ?? 7 }}&id={{ $serviceId ?? 5 }}"
                                        id="frm1">
                                        @csrf

                                        {{-- Service Details --}}
                                        <div class="card shadow-sm mb-3">
                                            <div
                                                class="card-header bg-white d-flex align-items-center justify-content-between">
                                                <div class="fw-semibold">
                                                    Service Details
                                                </div>
                                                <div class="small text-muted">
                                                    Service ID: <span class="fw-semibold">{{ $serviceId ?? 5 }}</span>
                                                </div>
                                            </div>

                                            <div class="card-body">
                                                <div class="row g-3">

                                                    {{-- Order --}}
                                                    <div class="col-md-6">
                                                        <label class="form-label">Order</label>
                                                        <div class="form-control bg-light">
                                                            {{ $service['orderid'] ?? 7 }}
                                                            -
                                                            <a
                                                                href="orders.php?action=view&id={{ $service['orderid'] ?? 7 }}">View
                                                                Order</a>
                                                        </div>
                                                    </div>

                                                    {{-- Reg Date --}}
                                                    <div class="col-md-6">
                                                        <label class="form-label">Registration Date</label>
                                                        <input type="text" name="regdate"
                                                            value="{{ $service['regdate'] ?? '17/02/2026' }}"
                                                            class="form-control">
                                                    </div>

                                                    {{-- Product --}}
                                                    <div class="col-md-6">
                                                        <label class="form-label">Product / Service</label>
                                                        <select name="packageid" class="form-select"
                                                            onchange="submitServiceChange()">
                                                            @foreach(($productsGrouped ?? ['Drew Ashley'=>[
                                                            ['pid'=>1,'name'=>'Olga Hudson'],
                                                            ['pid'=>2,'name'=>'Maxwell Clark'],
                                                            ]]) as $group => $items)
                                                            <optgroup label="{{ $group }}">
                                                                @foreach($items as $p)
                                                                <option value="{{ $p['pid'] }}"
                                                                    @selected(($service['packageid'] ?? 2)==$p['pid'])>
                                                                    {{ $p['name'] }}
                                                                </option>
                                                                @endforeach
                                                            </optgroup>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    {{-- Qty --}}
                                                    <div class="col-md-6">
                                                        <label class="form-label">Quantity</label>
                                                        <input type="number" value="{{ $service['qty'] ?? 1 }}"
                                                            class="form-control" disabled>
                                                        <input type="hidden" name="qty"
                                                            value="{{ $service['qty'] ?? 1 }}">
                                                    </div>

                                                    {{-- First Payment --}}
                                                    <div class="col-md-6">
                                                        <label class="form-label">First Payment Amount</label>
                                                        <input type="text" name="firstpaymentamount"
                                                            value="{{ $service['firstpaymentamount'] ?? '1.00' }}"
                                                            class="form-control">
                                                    </div>

                                                    {{-- Recurring --}}
                                                    <div class="col-md-6">
                                                        <label class="form-label">Recurring Amount</label>
                                                        <div class="input-group">
                                                            <input type="text" name="amount"
                                                                value="{{ $service['amount'] ?? '0.00' }}"
                                                                class="form-control">
                                                            <span class="input-group-text bg-white">
                                                                <div class="form-check form-switch m-0">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        id="inputAutorecalc" name="autorecalc"
                                                                        value="1">
                                                                    <label class="form-check-label small"
                                                                        for="inputAutorecalc">Auto</label>
                                                                </div>
                                                            </span>
                                                        </div>
                                                        <div class="form-text">Recalculate on Save</div>
                                                    </div>

                                                    {{-- Domain --}}
                                                    <div class="col-md-6">
                                                        <label class="form-label">Domain</label>
                                                        <div class="input-group">
                                                            <input type="text" name="domain"
                                                                value="{{ $service['domain'] ?? 'abcgmail.com' }}"
                                                                class="form-control">
                                                            <button class="btn btn-outline-secondary dropdown-toggle"
                                                                type="button" data-bs-toggle="dropdown"></button>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <li><a class="dropdown-item"
                                                                        href="https://{{ $domain }}"
                                                                        target="_blank">www</a></li>
                                                                <li><a class="dropdown-item" href="#"
                                                                        onclick="document.getElementById('frmWhois').submit();return false;">whois</a>
                                                                </li>
                                                                <li><a class="dropdown-item"
                                                                        href="https://intodns.com/{{ $domain }}"
                                                                        target="_blank">intoDNS</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>

                                                    {{-- Next Due --}}
                                                    <div class="col-md-6">
                                                        <label class="form-label">Next Due Date</label>
                                                        <input type="text" name="nextduedate"
                                                            value="{{ $service['nextduedate'] ?? '17/02/2026' }}"
                                                            class="form-control">
                                                    </div>

                                                    {{-- Billing Cycle --}}
                                                    <div class="col-md-6">
                                                        <label class="form-label">Billing Cycle</label>
                                                        <select name="billingcycle" class="form-select">
                                                            @foreach([
                                                            'Free Account'=>'Free',
                                                            'One Time'=>'One Time',
                                                            'Monthly'=>'Monthly',
                                                            'Quarterly'=>'Quarterly',
                                                            'Semi-Annually'=>'Semi-Annually',
                                                            'Annually'=>'Annually',
                                                            'Biennially'=>'Biennially',
                                                            'Triennially'=>'Triennially',
                                                            ] as $val => $label)
                                                            <option value="{{ $val }}"
                                                                @selected(($service['billingcycle'] ?? 'One Time'
                                                                )==$val)>
                                                                {{ $label }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    {{-- Payment Method --}}
                                                    <div class="col-md-6">
                                                        <label class="form-label">Payment Method</label>
                                                        <select name="paymentmethod" class="form-select">
                                                            {{-- @foreach(($paymethodMethods ?? [
                                        'mailin'=>'Mail In Payment',
                                        'paypal_ppcpv'=>'PayPal',
                                        'banktransfer'=>'Bank Transfer',
                                    ]) as $k => $label)
                                        <option value="{{ $k }}" @selected(($service['paymentmethod'] ??
                                                            'paypal_ppcpv') == $k)>
                                                            {{ $label }}
                                                            </option>
                                                            @endforeach --}}
                                                        </select>
                                                    </div>

                                                    {{-- Status --}}
                                                    <div class="col-md-6">
                                                        <label class="form-label">Status</label>
                                                        <select name="domainstatus" class="form-select">
                                                            @foreach(['Pending','Active','Completed','Suspended','Terminated','Cancelled','Fraud']
                                                            as $st)
                                                            <option value="{{ $st }}" @selected(($service['status']
                                                                ?? 'Pending' )==$st)>{{ $st }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    {{-- Dedicated IP --}}
                                                    <div class="col-md-6">
                                                        <label class="form-label">Dedicated IP</label>
                                                        <input type="text" name="dedicatedip"
                                                            value="{{ $service['dedicatedip'] ?? '' }}"
                                                            class="form-control">
                                                    </div>

                                                    {{-- Notes --}}
                                                    <div class="col-12">
                                                        <label class="form-label">Admin Notes</label>
                                                        <textarea name="notes" rows="4"
                                                            class="form-control">{{ $service['notes'] ?? '' }}</textarea>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="card-footer bg-white d-flex justify-content-end gap-2">
                                                <button class="btn btn-primary" type="submit">
                                                    Save Changes
                                                </button>
                                                <button class="btn btn-outline-secondary" type="reset">
                                                    Cancel Changes
                                                </button>
                                            </div>
                                        </div>

                                        {{-- Module Commands --}}
                                        <div class="card shadow-sm mb-3">
                                            <div class="card-header bg-white fw-semibold">Module Commands</div>
                                            <div class="card-body">
                                                <div class="d-flex flex-wrap gap-2">
                                                    <button type="button" class="btn btn-outline-secondary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalModuleCreate">Create</button>
                                                    <button type="button" class="btn btn-outline-secondary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalModuleSuspend">Suspend</button>
                                                    <button type="button" class="btn btn-outline-secondary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalModuleUnsuspend">Unsuspend</button>
                                                    <button type="button" class="btn btn-outline-secondary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalModuleTerminate">Terminate</button>
                                                    <button type="button" class="btn btn-outline-secondary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalModuleChangePackage">Change
                                                        Package</button>
                                                    <button type="button" class="btn btn-outline-secondary"
                                                        onclick="runModuleCommand('changepw')">Change Password</button>
                                                </div>

                                                <div class="mt-3 small text-muted">
                                                    Module output will appear here...
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Addons Table --}}
                                        <div class="card shadow-sm">
                                            <div class="card-header bg-white fw-semibold">Addons</div>
                                            <div class="card-body p-0">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-hover mb-0">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Reg Date</th>
                                                                <th>Name</th>
                                                                <th>Pricing</th>
                                                                <th>Status</th>
                                                                <th>Next Due Date</th>
                                                                <th style="width:60px"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse(($addons ?? []) as $ad)
                                                            <tr>
                                                                <td>{{ $ad['regdate'] ?? '-' }}</td>
                                                                <td>{{ $ad['name'] ?? '-' }}</td>
                                                                <td>{{ $ad['pricing'] ?? '-' }}</td>
                                                                <td><span
                                                                        class="badge bg-secondary">{{ $ad['status'] ?? '-' }}</span>
                                                                </td>
                                                                <td>{{ $ad['nextduedate'] ?? '-' }}</td>
                                                                <td class="text-end">
                                                                    <a class="btn btn-sm btn-outline-secondary"
                                                                        href="#">View</a>
                                                                </td>
                                                            </tr>
                                                            @empty
                                                            <tr>
                                                                <td colspan="6" class="text-center text-muted py-4">
                                                                    No Records Found
                                                                </td>
                                                            </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                    </form>

                                </div>

                                {{-- RIGHT: SIDEBAR --}}
                                <div class="col-xl-4">

                                    {{-- Summary --}}
                                    <div class="card shadow-sm mb-3">
                                        <div class="card-header bg-white fw-semibold">Summary</div>
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <span class="text-muted">Domain</span>
                                                <span
                                                    class="fw-semibold">{{ $service['domain'] ?? 'abcgmail.com' }}</span>
                                            </div>
                                            <hr>
                                            <div class="d-flex justify-content-between">
                                                <span class="text-muted">Status</span>
                                                <span
                                                    class="badge bg-warning text-dark">{{ $service['status'] ?? 'Pending' }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between mt-2">
                                                <span class="text-muted">Billing</span>
                                                <span
                                                    class="fw-semibold">{{ $service['billingcycle'] ?? 'One Time' }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between mt-2">
                                                <span class="text-muted">Payment</span>
                                                <span
                                                    class="fw-semibold">{{ $service['paymentmethod'] ?? 'paypal_ppcpv' }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Subscription --}}
                                    <div class="card shadow-sm mb-3">
                                        <div class="card-header bg-white fw-semibold">Subscription</div>
                                        <div class="card-body">
                                            <label class="form-label">Subscription ID</label>
                                            <input type="text" class="form-control" name="subscriptionid"
                                                value="{{ $service['subscriptionid'] ?? '' }}">
                                        </div>
                                    </div>

                                    {{-- Auto Suspend --}}
                                    <div class="card shadow-sm mb-3">
                                        <div class="card-header bg-white fw-semibold">Auto Suspend</div>
                                        <div class="card-body">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" id="overrideautosuspend"
                                                    name="overideautosuspend" value="1">
                                                <label class="form-check-label" for="overrideautosuspend">Do not suspend
                                                    until</label>
                                            </div>
                                            <input type="text" class="form-control" name="overidesuspenduntil"
                                                value="{{ $service['overidesuspenduntil'] ?? '' }}"
                                                placeholder="YYYY-MM-DD">
                                        </div>
                                    </div>

                                    {{-- Auto Terminate --}}
                                    <div class="card shadow-sm">
                                        <div class="card-header bg-white fw-semibold">Auto Terminate</div>
                                        <div class="card-body">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox"
                                                    id="autoterminateendcycle" name="autoterminateendcycle" value="1">
                                                <label class="form-check-label"
                                                    for="autoterminateendcycle">Auto-Terminate End of Cycle</label>
                                            </div>
                                            <label class="form-label">Reason</label>
                                            <input type="text" class="form-control" name="autoterminatereason"
                                                value="{{ $service['autoterminatereason'] ?? '' }}">
                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{-- WHOIS Form --}}
                            <form method="post" action="whois.php" target="_blank" id="frmWhois" class="d-none">
                                @csrf
                                <input type="hidden" name="domain" value="{{ $service['domain'] ?? 'abcgmail.com' }}">
                            </form>
                        </div>

                    </div>
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
