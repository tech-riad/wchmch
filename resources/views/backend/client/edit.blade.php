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
                                <div class="user-profile-header-banner">
                                    <img src="../../assets/img/pages/profile-banner.png" alt="Banner image"
                                        class="rounded-top" />
                                </div>
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="nav-align-top">
                                <ul class="nav nav-pills flex-column flex-sm-row mb-6 gap-sm-0 gap-2">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="javascript:void(0);"><i
                                                class="icon-base ti tabler-user-check icon-sm me-1_5"></i> Profile</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('admin.users.edit', $client['id'])}}"><i
                                                class="icon-base ti tabler-users icon-sm me-1_5"></i> Teams</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="pages-profile-projects.html"><i
                                                class="icon-base ti tabler-layout-grid icon-sm me-1_5"></i> Projects</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="pages-profile-connections.html"><i
                                                class="icon-base ti tabler-link icon-sm me-1_5"></i> Connections</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--/ Navbar pills -->

                    <!-- User Profile Content -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <!-- Activity Timeline -->
                            <form method="POST" action="{{ route('admin.users.update', $client['id']) }}"
                                class="needs-validation">
                                @csrf
                                @method('PUT')

                                {{-- Personal Information Card --}}
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="ti ti-user me-2"></i>Personal Information
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label class="form-label" for="firstname">First Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('firstname') is-invalid @enderror"
                                                    id="firstname" name="firstname"
                                                    value="{{ old('firstname', $client['firstname']) }}"
                                                    placeholder="Enter first name" required>
                                                @error('firstname')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label" for="lastname">Last Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('lastname') is-invalid @enderror"
                                                    id="lastname" name="lastname"
                                                    value="{{ old('lastname', $client['lastname']) }}"
                                                    placeholder="Enter last name" required>
                                                @error('lastname')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label" for="companyname">Company Name</label>
                                                <input type="text"
                                                    class="form-control @error('companyname') is-invalid @enderror"
                                                    id="companyname" name="companyname"
                                                    value="{{ old('companyname', $client['companyname']) }}"
                                                    placeholder="Enter companyname name (optional)">
                                                @error('companyname')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label" for="email">Email Address <span
                                                        class="text-danger">*</span></label>
                                                <input type="email"
                                                    class="form-control @error('email') is-invalid @enderror" id="email"
                                                    name="email" value="{{ old('email', $client['email']) }}"
                                                    placeholder="Enter email address" required>
                                                @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label" for="phone">Phone Number <span
                                                        class="text-danger">*</span></label>
                                                <input type="tel"
                                                    class="form-control @error('phone') is-invalid @enderror" id="phone"
                                                    name="phone" value="{{ old('phone', $client['phonenumber']) }}"
                                                    placeholder="Enter phone number" required>
                                                @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Address Information Card --}}
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="ti ti-map-pin me-2"></i>Address Information
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label" for="address1">Address Line 1 <span
                                                        class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('address1') is-invalid @enderror"
                                                    id="address1" name="address1"
                                                    value="{{ old('address1', $client['address1']) }}"
                                                    placeholder="Street address, P.O. box" required>
                                                @error('address1')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label" for="address2">Address Line 2</label>
                                                <input type="text"
                                                    class="form-control @error('address2') is-invalid @enderror"
                                                    id="address2" name="address2"
                                                    value="{{ old('address2', $client['address2']) }}"
                                                    placeholder="Apartment, suite, unit, etc. (optional)">
                                                @error('address2')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label" for="city">City <span
                                                        class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('city') is-invalid @enderror" id="city"
                                                    name="city" value="{{ old('city', $client['city']) }}"
                                                    placeholder="Enter city" required>
                                                @error('city')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label" for="state">State/Region <span
                                                        class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('state') is-invalid @enderror" id="state"
                                                    name="state" value="{{ old('state', $client['state']) }}"
                                                    placeholder="Enter state or region" required>
                                                @error('state')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label" for="postcode">Postal Code <span
                                                        class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('postcode') is-invalid @enderror"
                                                    id="postcode" name="postcode"
                                                    value="{{ old('postcode', $client['postcode']) }}"
                                                    placeholder="Enter postal code" required>
                                                @error('postcode')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label" for="country">Country <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select @error('country') is-invalid @enderror"
                                                    id="country" name="country" required>
                                                    <option value="">Select Country</option>
                                                    <option value="US"
                                                        {{ old('country', $client['country']) == 'US' ? 'selected' : '' }}>
                                                        United States</option>
                                                    <option value="GB"
                                                        {{ old('country', $client['country']) == 'GB' ? 'selected' : '' }}>
                                                        United Kingdom</option>
                                                    <option value="CA"
                                                        {{ old('country', $client['country']) == 'CA' ? 'selected' : '' }}>
                                                        Canada</option>
                                                    <option value="AU"
                                                        {{ old('country', $client['country']) == 'AU' ? 'selected' : '' }}>
                                                        Australia</option>
                                                    <option value="BD"
                                                        {{ old('country', $client['country']) == 'BD' ? 'selected' : '' }}>
                                                        Bangladesh</option>
                                                    {{-- Add more countries as needed --}}
                                                </select>
                                                @error('country')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label" for="tax_id">Tax ID/VAT Number</label>
                                                <input type="text"
                                                    class="form-control @error('tax_id') is-invalid @enderror"
                                                    id="tax_id" name="tax_id"
                                                    value="{{ old('tax_id', $client['tax_id']) }}"
                                                    placeholder="Enter tax ID (optional)">
                                                @error('tax_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Account Settings Card --}}
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="ti ti-settings me-2"></i>Account Settings
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label" for="currency">Currency</label>
                                                <select class="form-select @error('currency') is-invalid @enderror"
                                                    id="currency" name="currency">

                                                    @foreach ($currencies as $item)
                                                    <option value="{{ $item['id'] }}"
                                                        {{ old('currency', $client['currency']) == $item['id'] ? 'selected' : '' }}>
                                                        {{ $item['code'] }} ({{ $item['prefix'] }})</option>
                                                    @endforeach

                                                </select>
                                                @error('currency')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label" for="group">Client Group</label>
                                                <select class="form-select @error('group') is-invalid @enderror"
                                                    id="group" name="group">
                                                    <option value="">Select Group</option>
                                                    @php $selectedGroup = old('group', $client['groupid'] ?? '');
                                                    @endphp
                                                    @foreach ($groups as $item)
                                                    <option value="{{ $item['id'] }}"
                                                        {{ (string)$selectedGroup === (string)$item['id'] ? 'selected' : '' }}>
                                                        {{ $item['groupname'] }}
                                                    </option>
                                                    @endforeach



                                                </select>
                                                @error('group')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label" for="status">Account Status</label>
                                                <select class="form-select @error('status') is-invalid @enderror"
                                                    id="status" name="status">
                                                    <option value="Active"
                                                        {{ old('status', $client['status']) == 'Active' ? 'selected' : '' }}>
                                                        Active
                                                    </option>
                                                    <option value="Inactive"
                                                        {{ old('status', $client['status']) == 'Inactive' ? 'selected' : '' }}>
                                                        Inactive
                                                    </option>
                                                    <option value="Closed"
                                                        {{ old('status', $client['status']) == 'Closed' ? 'selected' : '' }}>
                                                        Closed
                                                    </option>
                                                </select>
                                                @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">


                                            </div>

                                            {{-- <div class="col-12">
                                                <div class="form-check form-switch mt-2">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="send_welcome_email" name="send_welcome_email" value="1"
                                                        {{ old('send_welcome_email', $client['send_welcome_email']) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="send_welcome_email">
                                                Send welcome email to client with login details
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="email_verification"
                                                name="email_verification" value="1"
                                                {{ old('email_verification', $client['email_verification']) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="email_verification">
                                                Require email verification
                                            </label>
                                        </div>
                                    </div> --}}
                                </div>
                        </div>
                    </div>
                    @php
                    $prefs = $client['email_preferences'] ?? [];
                    @endphp

                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="ti ti-mail me-2"></i>Email Preferences
                            </h5>
                        </div>

                        <div class="card-body">
                            <div class="row g-3">

                                @php
                                    $prefs = $client['email_preferences'] ?? [];
                                @endphp

                                <div class="col-md-6">
                                    <div class="form-check form-switch">

                                        {{-- ✅ unchecked হলে 0 যাবে --}}
                                        <input type="hidden" name="email_preferences[general]" value="0">

                                        <input class="form-check-input" type="checkbox" id="email_pref_general"
                                            name="email_preferences[general]" value="1"
                                            {{ old('email_preferences.general', (int)($prefs['general'] ?? 0)) ? 'checked' : '' }}>

                                        <label class="form-check-label" for="email_pref_general">
                                            General Emails
                                        </label>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-check form-switch">

                                        {{-- ✅ unchecked হলে 0 যাবে --}}
                                        <input type="hidden" name="email_preferences[invoice]" value="0">

                                        <input class="form-check-input" type="checkbox" id="email_pref_invoice"
                                            name="email_preferences[invoice]" value="1"
                                            {{ old('email_preferences.invoice', (int)($prefs['invoice'] ?? 0)) ? 'checked' : '' }}>

                                        <label class="form-check-label" for="email_pref_invoice">
                                            Invoice Emails
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- Additional Notes Card --}}
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="ti ti-notes me-2"></i>Additional Notes
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <label class="form-label" for="notes">Internal Notes</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes"
                                        name="notes" rows="3"
                                        placeholder="Add any internal notes about this client (optional)">{{ old('notes', $client['notes']) }}</textarea>
                                    @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">These notes are only visible to staff members.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Form Actions --}}
                    <div class="d-flex justify-content-end gap-2 mb-5">
                        <button type="reset" class="btn btn-outline-secondary">
                            <i class="ti ti-refresh me-1"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-1"></i> Save Client
                        </button>
                        <button type="button" class="btn btn-outline-primary" onclick="saveAndContinue()">
                            <i class="ti ti-device-floppy me-1"></i> Save & Add Another
                        </button>
                    </div>
                    </form>
                    <!--/ Activity Timeline -->
                    <div class="row">
                        <!-- Connections -->
                        <div class="col-lg-12 col-xl-6">
                            <div class="card card-action mb-6">
                                <div class="card-header align-items-center">
                                    <h5 class="card-action-title mb-0">Connections</h5>
                                    <div class="card-action-element">
                                        <div class="dropdown">
                                            <button type="button"
                                                class="btn btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow p-0 text-body-secondary"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i
                                                    class="icon-base ti tabler-dots-vertical icon-md text-body-secondary"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="javascript:void(0);">Share
                                                        connections</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0);">Suggest
                                                        edits</a></li>
                                                <li>
                                                    <hr class="dropdown-divider" />
                                                </li>
                                                <li><a class="dropdown-item" href="javascript:void(0);">Report
                                                        bug</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-4">
                                            <div class="d-flex align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar me-2">
                                                        <img src="../../assets/img/avatars/2.png" alt="Avatar"
                                                            class="rounded-circle" />
                                                    </div>
                                                    <div class="me-2">
                                                        <h6 class="mb-0">Cecilia Payne</h6>
                                                        <small>45 Connections</small>
                                                    </div>
                                                </div>
                                                <div class="ms-auto">
                                                    <button class="btn btn-label-primary btn-icon">
                                                        <i class="icon-base ti tabler-user-check icon-22px"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="mb-4">
                                            <div class="d-flex align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar me-2">
                                                        <img src="../../assets/img/avatars/3.png" alt="Avatar"
                                                            class="rounded-circle" />
                                                    </div>
                                                    <div class="me-2">
                                                        <h6 class="mb-0">Curtis Fletcher</h6>
                                                        <small>1.32k Connections</small>
                                                    </div>
                                                </div>
                                                <div class="ms-auto">
                                                    <button class="btn btn-primary btn-icon">
                                                        <i class="icon-base ti tabler-user-x icon-22px"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="mb-4">
                                            <div class="d-flex align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar me-2">
                                                        <img src="../../assets/img/avatars/10.png" alt="Avatar"
                                                            class="rounded-circle" />
                                                    </div>
                                                    <div class="me-2">
                                                        <h6 class="mb-0">Alice Stone</h6>
                                                        <small>125 Connections</small>
                                                    </div>
                                                </div>
                                                <div class="ms-auto">
                                                    <button class="btn btn-primary btn-icon">
                                                        <i class="icon-base ti tabler-user-x icon-22px"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="mb-4">
                                            <div class="d-flex align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar me-2">
                                                        <img src="../../assets/img/avatars/7.png" alt="Avatar"
                                                            class="rounded-circle" />
                                                    </div>
                                                    <div class="me-2">
                                                        <h6 class="mb-0">Darrell Barnes</h6>
                                                        <small>456 Connections</small>
                                                    </div>
                                                </div>
                                                <div class="ms-auto">
                                                    <button class="btn btn-label-primary btn-icon">
                                                        <i class="icon-base ti tabler-user-check icon-22px"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </li>

                                        <li class="mb-6">
                                            <div class="d-flex align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar me-2">
                                                        <img src="../../assets/img/avatars/12.png" alt="Avatar"
                                                            class="rounded-circle" />
                                                    </div>
                                                    <div class="me-2">
                                                        <h6 class="mb-0">Eugenia Moore</h6>
                                                        <small>1.2k Connections</small>
                                                    </div>
                                                </div>
                                                <div class="ms-auto">
                                                    <button class="btn btn-label-primary btn-icon">
                                                        <i class="icon-base ti tabler-user-check icon-22px"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="text-center">
                                            <a href="javascript:;">View all connections</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!--/ Connections -->
                        <!-- Teams -->
                        <div class="col-lg-12 col-xl-6">
                            <div class="card card-action mb-6">
                                <div class="card-header align-items-center">
                                    <h5 class="card-action-title mb-0">Teams</h5>
                                    <div class="card-action-element">
                                        <div class="dropdown">
                                            <button type="button"
                                                class="btn btn-icon btn-text-secondary dropdown-toggle hide-arrow p-0"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i
                                                    class="icon-base ti tabler-dots-vertical  icon-md text-body-secondary"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="javascript:void(0);">Share
                                                        teams</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0);">Suggest
                                                        edits</a></li>
                                                <li>
                                                    <hr class="dropdown-divider" />
                                                </li>
                                                <li><a class="dropdown-item" href="javascript:void(0);">Report
                                                        bug</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-4">
                                            <div class="d-flex align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar me-2">
                                                        <img src="../../assets/img/icons/brands/react-label.png"
                                                            alt="Avatar" class="rounded-circle" />
                                                    </div>
                                                    <div class="me-2">
                                                        <h6 class="mb-0">React Developers</h6>
                                                        <small>72 Members</small>
                                                    </div>
                                                </div>
                                                <div class="ms-auto">
                                                    <a href="javascript:;"><span
                                                            class="badge bg-label-danger">Developer</span></a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="mb-4">
                                            <div class="d-flex align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar me-2">
                                                        <img src="../../assets/img/icons/brands/support-label.png"
                                                            alt="Avatar" class="rounded-circle" />
                                                    </div>
                                                    <div class="me-2">
                                                        <h6 class="mb-0">Support Team</h6>
                                                        <small>122 Members</small>
                                                    </div>
                                                </div>
                                                <div class="ms-auto">
                                                    <a href="javascript:;"><span
                                                            class="badge bg-label-primary">Support</span></a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="mb-4">
                                            <div class="d-flex align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar me-2">
                                                        <img src="../../assets/img/icons/brands/figma-label.png"
                                                            alt="Avatar" class="rounded-circle" />
                                                    </div>
                                                    <div class="me-2">
                                                        <h6 class="mb-0">UI Designers</h6>
                                                        <small>7 Members</small>
                                                    </div>
                                                </div>
                                                <div class="ms-auto">
                                                    <a href="javascript:;"><span
                                                            class="badge bg-label-info">Designer</span></a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="mb-4">
                                            <div class="d-flex align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar me-2">
                                                        <img src="../../assets/img/icons/brands/vue-label.png"
                                                            alt="Avatar" class="rounded-circle" />
                                                    </div>
                                                    <div class="me-2">
                                                        <h6 class="mb-0">Vue.js Developers</h6>
                                                        <small>289 Members</small>
                                                    </div>
                                                </div>
                                                <div class="ms-auto">
                                                    <a href="javascript:;"><span
                                                            class="badge bg-label-danger">Developer</span></a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="mb-6">
                                            <div class="d-flex align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar me-2">
                                                        <img src="../../assets/img/icons/brands/twitter-label.png"
                                                            alt="Avatar" class="rounded-circle" />
                                                    </div>
                                                    <div class="me-w">
                                                        <h6 class="mb-0">Digital Marketing</h6>
                                                        <small>24 Members</small>
                                                    </div>
                                                </div>
                                                <div class="ms-auto">
                                                    <a href="javascript:;"><span
                                                            class="badge bg-label-secondary">Marketing</span></a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="text-center">
                                            <a href="javascript:;">View all teams</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!--/ Teams -->
                    </div>
                    <!-- Projects table -->
                    <div class="card mb-6">
                        <div class="mb-4">
                            <table class="table datatable-project">
                                <thead class="border-top">
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th>Project</th>
                                        <th>Leader</th>
                                        <th>Team</th>
                                        <th class="w-px-200">Progress</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <!--/ Projects table -->
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

                        <a href="https://demos.pixinvent.com/vuexy-html-admin-template/documentation/" target="_blank"
                            class="footer-link me-4">Documentation</a>

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
