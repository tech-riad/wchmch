@extends('backend.layouts.app')

@section('content')

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">


        <div class="menu-mobile-toggler d-xl-none rounded-1">
            <a href="javascript:void(0);"
                class="layout-menu-toggle menu-link text-large text-bg-secondary p-2 rounded-1">
                <i class="ti tabler-menu icon-base"></i><i class="ti tabler-chevron-right icon-base"></i>
            </a>
        </div>

        <!-- Layout container -->
        <div class="layout-page">

            <!-- Navbar (Vuexy style, reduced) -->
            <nav class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme"
                id="layout-navbar">
                <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                    <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)"><i
                            class="icon-base ti tabler-menu-2 icon-md"></i></a>
                </div>
                <div class="navbar-nav-right d-flex align-items-center justify-content-end">
                    <div class="navbar-nav align-items-center">
                        <div class="nav-item navbar-search-wrapper px-md-0 px-2 mb-0">
                            <a class="nav-item nav-link search-toggler d-flex align-items-center px-0"
                                href="javascript:void(0);">
                                <span class="d-inline-block text-body-secondary fw-normal">Search (Invoice #5)</span>
                            </a>
                        </div>
                    </div>
                    <ul class="navbar-nav flex-row align-items-center ms-md-auto">
                        <li class="nav-item dropdown-user dropdown">
                            <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);"
                                data-bs-toggle="dropdown">
                                <div class="avatar avatar-online"><img src="../../assets/img/avatars/1.png" alt
                                        class="rounded-circle" /></div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#"><i
                                            class="icon-base ti tabler-user me-3"></i>Profile</a></li>
                                <li><a class="dropdown-item" href="#"><i
                                            class="icon-base ti tabler-logout me-3"></i>Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- / Navbar -->

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">

                    <!-- INVOICE HEADER with Vuexy style elements -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-bold">Invoice #{{$invoice['invoiceid']}}</h4>
                        <div class="btn-group">
                            <button class="btn btn-outline-primary btn-sm"><i
                                    class="icon-base ti tabler-edit me-1"></i>Manage</button>
                            <button class="btn btn-outline-secondary btn-sm"><i
                                    class="icon-base ti tabler-printer me-1"></i>Print</button>
                            <button class="btn btn-outline-secondary btn-sm"><i
                                    class="icon-base ti tabler-download me-1"></i>PDF</button>
                        </div>
                    </div>

                    <!-- Two column layout: left = invoice summary card, right = tabs -->
                    <div class="row g-6">


                        <!-- Right column: tabs (Summary, Add Payment, Credit, Refund, Notes) -->
                        <div class="col-xl-12 col-lg-12">
                            <div class="card">
                                <div class="card-header p-0 pt-2 px-3">
                                    <!-- Tabs navigation (Vuexy style) -->
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item"><a class="nav-link active" id="summary-tab"
                                                data-bs-toggle="tab" href="#summary" role="tab"><i
                                                    class="icon-base ti tabler-file-text me-1"></i>Summary</a></li>
                                        <li class="nav-item"><a class="nav-link" id="payment-tab" data-bs-toggle="tab"
                                                href="#addpayment" role="tab"><i
                                                    class="icon-base ti tabler-plus-circle me-1"></i>Add Payment</a>
                                        </li>
                                        <li class="nav-item"><a class="nav-link" id="credit-tab" data-bs-toggle="tab"
                                                href="#credit" role="tab"><i
                                                    class="icon-base ti tabler-coin me-1"></i>Credit</a></li>
                                        <li class="nav-item"><a class="nav-link" id="refund-tab" data-bs-toggle="tab"
                                                href="#refund" role="tab"><i
                                                    class="icon-base ti tabler-receipt-refund me-1"></i>Refund</a></li>
                                        <li class="nav-item"><a class="nav-link" id="notes-tab" data-bs-toggle="tab"
                                                href="#notes" role="tab"><i
                                                    class="icon-base ti tabler-notes me-1"></i>Notes</a></li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content p-0">
                                        <!-- Tab 1: Summary (original WHMCS fields) -->
                                        <div class="tab-pane fade show active" id="summary" role="tabpanel">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <table class="table table-sm">
                                                        <tr>
                                                            <th>Client Name</th>
                                                            <td><a
                                                                    href="{{route('admin.users.details', ['client_id' => $client['id']])}}">{{$client['firstname']}}
                                                                    {{$client['lastname']}}</a> (ID:{{$client['id']}})
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Invoice Date</th>
                                                            <td>{{$invoice['date']}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Due Date</th>
                                                            <td>{{$invoice['duedate']}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Amount</th>
                                                            <td>{{$invoice['total']}} USD</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Balance</th>
                                                            <td class="text-danger">{{$invoice['balance']}} USD</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col-md-6 text-center">
                                                    <span
                                                        class="invoice-status unpaid mb-3">{{$invoice['status']}}</span>
                                                    <div class="mt-3">
                                                        <select name="paymentmethod"
                                                            class="form-select form-select-sm w-auto d-inline-block me-2">
                                                            @foreach($paymethodMethods as $m)
                                                            <option value="{{ $m['module'] ?? $m['displayname'] }}">
                                                                {{ $m['displayname'] ?? $m['module'] }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        <button class="btn btn-sm btn-success">Capture</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Tab 2: Add Payment -->
                                        <div class="tab-pane fade" id="addpayment" role="tabpanel">
                                            <form
                                                action="{{route('admin.users.invoice.paymentadd',$invoice['invoiceid'])}}"
                                                method="POST">
                                                @csrf
                                                @if ($invoice['status'] != 'Paid')


                                                <div class="row g-3">
                                                    <div class="alert alert-info d-flex align-items-start" role="alert">
                                                    <div class="me-2">
                                                        <i class="ti ti-info-circle fs-4"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="alert-heading mb-1">This is a {{$invoice['status']}} Invoice.</h6>
                                                        <p class="mb-0">
                                                        The system can only apply payments to an invoice in
                                                        <strong>Unpaid</strong> status.
                                                        </p>
                                                    </div>
                                                    </div>
                                                </div>
                                                @else
                                                <div class="row g-3">
                                                    <div class="col-md-6"><label class="form-label">Date</label>
                                                        <input type="date" class="form-control" name="date"
                                                            value="{{ date('Y-m-d') }}">
                                                    </div>
                                                    <div class="col-md-6"><label class="form-label">Amount</label><input
                                                            type="text" class="form-control" name="amount"
                                                            value="{{ $invoice['subtotal'] ?? '—' }}"></div>
                                                    <div class="col-md-6"><label class="form-label">Payment
                                                            method</label>
                                                        <select name="paymentmethod" class="form-control select-inline">
                                                            @foreach($paymethodMethods as $m)
                                                            <option value="{{ $m['module'] ?? $m['displayname'] }}">
                                                                {{ $m['displayname'] ?? $m['module'] }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6"><label class="form-label">Transaction
                                                            ID</label><input type="text" name="transid"
                                                            class="form-control"></div>
                                                    <div class="col-md-6"><label class="form-label">Transaction
                                                            Fees</label><input type="text" name="fees"
                                                            class="form-control"></div>
                                                    <div class="col-md-12">
                                                        <div class="form-check">
                                                            <label class="checkbox-inline">
                                                                <input type="hidden" name="sendconfirmation" value="0">
                                                                <input type="checkbox" name="sendconfirmation"
                                                                    value="1">
                                                                Check to Send Confirmation Email
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12"><button type="submit"
                                                            class="btn btn-primary">Add
                                                            Payment</button></div>
                                                </div>
                                                @endif
                                            </form>
                                        </div>
                                        <!-- Tab 3: Credit -->
                                        <div class="tab-pane fade" id="credit" role="tabpanel">
                                            <div class="row text-center">
                                                <div class="col-sm-6 mb-3">
                                                    <label class="fw-bold">Add Credit</label>
                                                    <input class="form-control form-control-sm d-inline w-auto mx-2"
                                                        value="0.00" disabled>
                                                    <button class="btn btn-sm btn-secondary" disabled>Go</button>
                                                    <div class="mt-2 text-success">$0.00 Available</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="fw-bold">Remove Credit</label>
                                                    <input class="form-control form-control-sm d-inline w-auto mx-2"
                                                        value="0.00" disabled>
                                                    <button class="btn btn-sm btn-secondary" disabled>Go</button>
                                                    <div class="mt-2 text-danger">$0.00 Available</div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Tab 4: Refund -->
                                        <div class="tab-pane fade" id="refund" role="tabpanel">
                                            <div class="alert alert-info mb-0">There are no transactions that are
                                                eligible for a refund.</div>
                                        </div>
                                        <!-- Tab 5: Notes -->
                                        <div class="tab-pane fade" id="notes" role="tabpanel">
                                            <div class="alert alert-info mb-0">
                                                @if ($invoice['notes'] != '')
                                                {{$invoice['notes']}}
                                                @else
                                                There are no notes on this invoice.

                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional card for Invoice Items (like original but in Vuexy style) -->
                            <div class="card mt-6">
                                <div class="card-header">
                                    <h5 class="mb-0">Invoice Items</h5>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Description</th>
                                                <th>Taxed</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $items = $invoice['items']['item'] ?? $invoice['item'] ?? [];
                                            @endphp

                                            @foreach ($items as $item)

                                            <tr>
                                                <td>{{ $item['description'] ?? '-' }}</td>
                                                <td>{{ $item['tax'] ?? '-' }}</td>
                                                <td>${{ number_format($item['amount']) }} USD</td>
                                            </tr>
                                            @endforeach
                                            <tr class="table-active">
                                                <th colspan="2" class="text-end">Sub Total:</th>
                                                <td>{{ $invoice['subtotal'] ?? '—' }} USD</td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Ledger & Transaction History placed in one row (responsive) -->
                            <div class="row mt-6">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="mb-0">Ledger</h6>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-sm small">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Type</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td colspan="3" class="text-center">No Records Found</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="mb-0">Transaction History</h6>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-sm small">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Method</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($invoice['transactions'] != '')
                                                    <tr>
                                                        <td colspan="3" class="text-center"> Records Found</td>
                                                    </tr>
                                                    @else
                                                    <tr>
                                                        <td colspan="3" class="text-center">No Records Found</td>
                                                    </tr>

                                                    @endif

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer (Vuexy style) -->
                <footer class="content-footer footer bg-footer-theme">
                    <div class="container-xxl">
                        <div
                            class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                            <div class="text-body">© 2026, WHMCS style · Vuexy inspired</div>
                            <div><a href="#" class="footer-link me-4">Docs</a><a href="#"
                                    class="footer-link">Support</a></div>
                        </div>
                    </div>
                </footer>
                <div class="content-backdrop fade"></div>
            </div>
            <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>
    <div class="layout-overlay layout-menu-toggle"></div>
    <div class="drag-target"></div>
</div>
@endsection
