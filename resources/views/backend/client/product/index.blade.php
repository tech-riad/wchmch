@extends('backend.layouts.app')
@push('styles')

@endpush

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        {{-- Header Section --}}
        <div class="d-flex justify-content-between align-items-center py-3 mb-4">
            <div>
                <h4 class="fw-bold mb-0">
                    <span class="text-muted fw-light">Clients /</span> Add New Client
                </h4>
                <p class="mb-0 text-muted">Create a new client account in the system</p>
            </div>
            <div>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary me-2">
                    <i class="ti ti-arrow-left me-1"></i> Back to List
                </a>

            </div>
        </div>
        <div class="contentarea" id="contentarea">
            <div style="float:left;width:100%;">
                <h1>Add New Order</h1>

                <form method="post" action="{{ route('admin.orders.store') }}" id="orderfrm">
                    @csrf
                    <input type="hidden" name="submitorder" value="true">

                    <div class="row">
                        <div class="col-md-8">

                            {{-- HEADER FORM (WHMCS table style but Bootstrap 5) --}}
                            <div class="card mb-3">
                                <div class="card-body">

                                    {{-- Client --}}
                                    <div class="row mb-3">
                                        <div class="col-md-3 fw-semibold">Client</div>
                                        <div class="col-md-9">
                                            <div style="max-width:400px">
                                                <select id="selectUserid" name="userid" class="form-select">
                                                    <option value="">Start Typing to Search Clients</option>

                                                    <optgroup label="Active">
                                                        @foreach($clients as $c)
                                                        @if(($c['status'] ?? '') === 'Active')
                                                        <option value="{{ $c['id'] }}"
                                                            data-email="{{ $c['email'] ?? '' }}">
                                                            {{ $c['firstname'] }} {{ $c['lastname'] }}
                                                            @if(!empty($c['companyname'])) ({{ $c['companyname'] }})
                                                            @endif
                                                            - #{{ $c['id'] }}
                                                        </option>
                                                        @endif
                                                        @endforeach
                                                    </optgroup>

                                                    <optgroup label="Inactive">
                                                        @foreach($clients as $c)
                                                        @if(($c['status'] ?? '') !== 'Active')
                                                        <option value="{{ $c['id'] }}"
                                                            data-email="{{ $c['email'] ?? '' }}">
                                                            {{ $c['firstname'] }} {{ $c['lastname'] }}
                                                            @if(!empty($c['companyname'])) ({{ $c['companyname'] }})
                                                            @endif
                                                            - #{{ $c['id'] }}
                                                        </option>
                                                        @endif
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Payment --}}
                                    <div class="row mb-3">
                                        <div class="col-md-3 fw-semibold">Payment Method</div>
                                        <div class="col-md-9">
                                            <select name="paymentmethod" class="form-select" style="max-width:260px">
                                                @foreach($paymethodMethods as $pm)
                                                <option value="{{ $pm['module'] ?? $pm['displayname'] }}">
                                                    {{ $pm['displayname'] }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Promo --}}
                                    <div class="row mb-3">
                                        <div class="col-md-3 fw-semibold">Promotion Code</div>
                                        <div class="col-md-9 d-flex gap-2 flex-wrap">
                                            <div style="max-width:340px;width:100%;">
                                                <select name="promocode" id="promodd" class="form-select">
                                                    <option value="0">None</option>
                                                    @foreach(($promos ?? []) as $p)
                                                    <option value="{{ $p['code'] ?? '' }}">{{ $p['code'] ?? '' }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button type="button" class="btn btn-outline-secondary btn-sm"
                                                id="createPromoCode">
                                                <i class="bi bi-plus"></i> Create Custom Promo
                                            </button>
                                        </div>
                                    </div>

                                    {{-- Status --}}
                                    <div class="row mb-3">
                                        <div class="col-md-3 fw-semibold">Order Status</div>
                                        <div class="col-md-9">
                                            <select name="orderstatus" class="form-select" style="max-width:180px">
                                                <option value="Pending">Pending</option>
                                                <option value="Active">Active</option>
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Checkbox --}}
                                    <div class="row">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-9">
                                            <label class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="adminorderconf"
                                                    checked>
                                                <span class="form-check-label">Order Confirmation</span>
                                            </label>
                                            <label class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox"
                                                    name="admingenerateinvoice" checked>
                                                <span class="form-check-label">Generate Invoice</span>
                                            </label>
                                            <label class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="adminsendinvoice"
                                                    checked>
                                                <span class="form-check-label">Send Email</span>
                                            </label>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{-- PRODUCTS --}}
                            <div id="products">
                                <div id="ord0" class="product border rounded p-3 mb-3">

                                    <p class="fw-bold mb-2">Product/Service</p>

                                    <div class="row mb-3">
                                        <div class="col-md-3 fw-semibold">Product/Service</div>
                                        <div class="col-md-9">
                                            <select name="pid[]" id="pid0" class="form-select" style="max-width:320px"
                                                onchange="loadproductoptions(this)">
                                                <option value="">None</option>
                                                @foreach(($products ?? []) as $gname => $group)
                                                <optgroup label="{{ $gname }}">
                                                    @foreach($group as $p)
                                                    <option value="{{ $p['id'] }}">{{ $p['name'] }}</option>
                                                    @endforeach
                                                </optgroup>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-3 fw-semibold">Domain</div>
                                        <div class="col-md-9">
                                            <div class="text-danger small domain-feedback d-none">
                                                <i class="bi bi-exclamation-triangle"></i> Not a domain
                                            </div>
                                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                                <input type="text" name="domain[]" class="form-control"
                                                    style="max-width:300px" onkeyup="handleProductDomainInput(this)">
                                                <span id="whoisresult0" class="small text-muted"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-3 fw-semibold">Billing Cycle</div>
                                        <div class="col-md-9">
                                            <select name="billingcycle[]" class="form-select" style="max-width:220px"
                                                onchange="updatesummary();loadproductoptions(document.getElementById('pid' + this.id.substring(12)));return false;"
                                                id="billingcycle0">
                                                <option value="Free Account">Free</option>
                                                <option value="One Time">One Time</option>
                                                <option value="Monthly" selected>Monthly</option>
                                                <option value="Quarterly">Quarterly</option>
                                                <option value="Semi-Annually">Semi-Annually</option>
                                                <option value="Annually">Annually</option>
                                                <option value="Biennially">Biennially</option>
                                                <option value="Triennially">Triennially</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div id="addonsrow0" class="row mb-3 d-none">
                                        <div class="col-md-3 fw-semibold">Addons</div>
                                        <div class="col-md-9" id="addonscont0"></div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-3 fw-semibold">Quantity</div>
                                        <div class="col-md-9">
                                            <input type="text" name="qty[]" value="1" class="form-control"
                                                style="max-width:80px" onkeyup="updatesummary()">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3 fw-semibold">Price Override</div>
                                        <div class="col-md-9 d-flex align-items-center gap-2 flex-wrap">
                                            <input type="text" name="priceoverride[]" class="form-control"
                                                style="max-width:140px" onkeyup="updatesummary()">
                                            <span class="text-muted small">(Only enter to manually override default
                                                product pricing)</span>
                                        </div>
                                    </div>

                                    <div id="productconfigoptions0" class="mt-3"></div>

                                    <div class="text-end mt-3">
                                        <button type="button"
                                            class="btn btn-outline-danger btn-sm removeProduct d-none">Remove</button>
                                    </div>

                                </div>
                            </div>

                            <p class="ps-3">
                                <a href="#" class="btn btn-outline-secondary btn-sm addproduct">
                                    <i class="bi bi-plus"></i> Add Another Product
                                </a>
                            </p>

                            {{-- DOMAINS --}}
                            <p class="fw-bold mb-2">Domain Registration</p>

                            <div id="domains">
                                <div class="domain-block border rounded p-3 mb-3" data-index="0">
                                    <div class="row mb-3">
                                        <div class="col-md-3 fw-semibold">Registration Type</div>
                                        <div class="col-md-9">
                                            <label class="form-check form-check-inline">
                                                <input class="form-check-input domain-reg-action" type="radio"
                                                    name="regaction[0]" value="" checked>
                                                <span class="form-check-label">None</span>
                                            </label>
                                            <label class="form-check form-check-inline">
                                                <input class="form-check-input domain-reg-action" type="radio"
                                                    name="regaction[0]" value="register">
                                                <span class="form-check-label">Registration</span>
                                            </label>
                                            <label class="form-check form-check-inline">
                                                <input class="form-check-input domain-reg-action" type="radio"
                                                    name="regaction[0]" value="transfer">
                                                <span class="form-check-label">Transfer</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="domain-fields d-none">
                                        <div class="row mb-3">
                                            <div class="col-md-3 fw-semibold">Domain</div>
                                            <div class="col-md-9">
                                                <input type="text" name="regdomain[]" class="form-control"
                                                    style="max-width:300px">
                                                <div class="text-warning small d-none required-field-indication">
                                                    * Indicates a required field
                                                </div>
                                                <div class="text-danger small d-none invalid-tld">
                                                    TLD/Extension not configured for sale.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-3 fw-semibold">Registration Period</div>
                                            <div class="col-md-9">
                                                <select name="regperiod[]" class="form-select" style="max-width:160px"
                                                    onchange="updatesummary()">
                                                    @for($y=1;$y<=10;$y++) <option value="{{ $y }}">{{ $y }} Year
                                                        </option>
                                                        @endfor
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-3 domain-eppcode d-none">
                                            <div class="col-md-3 fw-semibold">EPP Code</div>
                                            <div class="col-md-9">
                                                <input type="text" name="eppcode[]" class="form-control"
                                                    style="max-width:200px">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-3 fw-semibold">Domain Addons</div>
                                            <div class="col-md-9">
                                                <label class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="dnsmanagement[0]" onclick="updatesummary()">
                                                    <span class="form-check-label">DNS Management</span>
                                                </label>
                                                <label class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="emailforwarding[0]" onclick="updatesummary()">
                                                    <span class="form-check-label">Email Forwarding</span>
                                                </label>
                                                <label class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="idprotection[0]" onclick="updatesummary()">
                                                    <span class="form-check-label">ID Protection</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-3 fw-semibold">Registration Price Override</div>
                                            <div class="col-md-9 d-flex align-items-center gap-2 flex-wrap">
                                                <input type="text" name="domainpriceoverride[0]" class="form-control"
                                                    style="max-width:140px" oninput="updatesummary()">
                                                <span class="text-muted small">(Only enter to manually override default
                                                    pricing)</span>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3 fw-semibold">Renewal Price Override</div>
                                            <div class="col-md-9 d-flex align-items-center gap-2 flex-wrap">
                                                <input type="text" name="domainrenewoverride[0]" class="form-control"
                                                    style="max-width:140px" oninput="updatesummary()">
                                                <span class="text-muted small">(Only enter to manually override default
                                                    pricing)</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-end mt-3">
                                        <button type="button"
                                            class="btn btn-outline-danger btn-sm removeDomain d-none">Remove</button>
                                    </div>
                                </div>
                            </div>

                            <p class="ps-3">
                                <a href="#" class="btn btn-outline-secondary btn-sm adddomain">
                                    <i class="bi bi-plus"></i> Add Another Domain
                                </a>
                            </p>

                        </div>

                        {{-- RIGHT SUMMARY --}}
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header fw-bold">Order Summary</div>
                                <div class="card-body" id="ordersummary">
                                    <div class="text-center text-muted py-3" id="noItemsText">No Items Selected</div>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <span>Sub Total</span>
                                        <span class="fw-bold" id="subTotalText">$0.00</span>
                                    </div>
                                    <div class="d-flex justify-content-between mt-2">
                                        <span class="fw-bold">Total</span>
                                        <span class="fw-bold text-primary" id="totalText">$0.00</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary w-100 py-3 fw-bold"
                                    style="font-size:20px;">
                                    Submit Order »
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Required Domain Fields Missing Modal --}}
        <div class="modal fade" id="modalvalidationResults" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Required Domain Fields Missing</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>One or more required domain fields have been left empty. This missing information may cause
                            domain registration to fail.</p>
                        <p>Click on the 'Submit Order' button if you would like to proceed with the order regardless of
                            this warning.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="forceSubmitBtn">Submit Order</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Create Promo Modal --}}
        <div class="modal fade" id="modalCreatePromo" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Create Custom Promo</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Promotion Code</label>
                                <input type="text" id="newPromoCode" class="form-control" placeholder="e.g. SAVE10">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Type</label>
                                <select id="newPromoType" class="form-select">
                                    <option value="Percentage">Percentage</option>
                                    <option value="Fixed Amount">Fixed Amount</option>
                                    <option value="Price Override">Price Override</option>
                                    <option value="Free Setup">Free Setup</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Value</label>
                                <input type="text" id="newPromoValue" class="form-control" placeholder="10">
                            </div>
                            <div class="col-12">
                                <label class="form-check">
                                    <input type="checkbox" id="newPromoRecurring" class="form-check-input">
                                    <span class="form-check-label">Enable - Recur For</span>
                                </label>
                                <input type="text" id="newPromoRecurFor" value="0" class="form-control mt-2"
                                    style="max-width:120px">
                                <div class="text-muted small mt-1">Times (0 = Unlimited)</div>
                            </div>
                        </div>
                        <div class="text-muted small mt-3">
                            * Promotional Discounts created "on the fly" here apply to all items in an order
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="savePromoBtn">OK</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    // ----- Select2 client search -----
    function escapeHtml(str) {
        return String(str).replace(/[&<>"']/g, m => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        } [m]));
    }

    function formatClient(opt) {
        if (!opt.id) return opt.text;
        const email = $(opt.element).data('email') || '';
        const text = opt.text || '';
        return $(`<div style="line-height:1.2">
      <div>${escapeHtml(text)}</div>
      ${email ? `<div style="font-size:12px;opacity:.7">${escapeHtml(email)}</div>` : ``}
    </div>`);
    }

    $(function () {
        $('#selectUserid').select2({
            placeholder: 'Start Typing to Search Clients',
            width: '400px',
            templateResult: formatClient,
            templateSelection: function (opt) {
                return opt.text || '';
            }
        });

        $('#promodd').select2({
            width: '340px'
        });
    });

    // ----- Domain validation UI -----
    window.handleProductDomainInput = function (input) {
        const val = (input.value || '').trim();
        const feedback = input.closest('.col-md-9').querySelector('.domain-feedback');
        const isDomain = /^[a-z0-9.-]+\.[a-z]{2,}$/i.test(val);
        if (!val) {
            feedback.classList.add('d-none');
            return;
        }
        feedback.classList.toggle('d-none', isDomain);
    }

    // placeholders (your ajax later)
    window.loadproductoptions = window.loadproductoptions || function () {};
    window.updatesummary = window.updatesummary || function () {
        // basic summary: if any pid selected show items count
        const pids = Array.from(document.querySelectorAll('select[name="pid[]"]')).filter(s => s.value);
        document.getElementById('noItemsText').style.display = pids.length ? 'none' : 'block';
    };

    // ----- Add Product clone like WHMCS -----
    function renumberProducts() {
        const items = document.querySelectorAll('#products .product');
        items.forEach((el, i) => {
            el.id = 'ord' + i;
            el.querySelectorAll('[id]').forEach(node => {
                node.id = node.id.replace(/\d+$/, i);
            });
            // keep names pid[], domain[] etc unchanged (array)
            const whois = el.querySelector('[id^="whoisresult"]');
            if (whois) whois.id = 'whoisresult' + i;

            const removeBtn = el.querySelector('.removeProduct');
            if (removeBtn) removeBtn.classList.toggle('d-none', i === 0);
        });
    }

    document.querySelector('.addproduct').addEventListener('click', function (e) {
        e.preventDefault();
        const products = document.getElementById('products');
        const first = document.getElementById('ord0');
        const clone = first.cloneNode(true);

        // clear fields
        clone.querySelectorAll('select, input').forEach(el => {
            if (el.tagName === 'SELECT') el.value = '';
            if (el.tagName === 'INPUT') {
                if (el.name === 'qty[]') el.value = '1';
                else el.value = '';
            }
        });
        clone.querySelectorAll('.domain-feedback').forEach(x => x.classList.add('d-none'));
        clone.querySelectorAll('#productconfigoptions0').forEach(x => x.innerHTML = '');

        // add remove btn visible
        const rm = clone.querySelector('.removeProduct');
        if (rm) rm.classList.remove('d-none');

        products.appendChild(clone);
        renumberProducts();
        updatesummary();
    });

    document.getElementById('products').addEventListener('click', function (e) {
        const btn = e.target.closest('.removeProduct');
        if (!btn) return;
        e.preventDefault();
        btn.closest('.product').remove();
        renumberProducts();
        updatesummary();
    });

    // ----- Domains add/remove + toggle fields -----
    function renumberDomains() {
        const blocks = document.querySelectorAll('#domains .domain-block');
        blocks.forEach((b, i) => {
            b.dataset.index = i;
            // fix name indexes like regaction[0], dnsmanagement[0] etc
            b.querySelectorAll('[name]').forEach(el => {
                el.name = el.name.replace(/\[\d+\]/, `[${i}]`);
            });

            const rm = b.querySelector('.removeDomain');
            if (rm) rm.classList.toggle('d-none', i === 0);
        });
    }

    function applyDomainAction(block) {
        const action = block.querySelector('.domain-reg-action:checked') ? .value || '';
        const fields = block.querySelector('.domain-fields');
        const epp = block.querySelector('.domain-eppcode');

        if (!action) {
            fields.classList.add('d-none');
            epp.classList.add('d-none');
            return;
        }

        fields.classList.remove('d-none');
        if (action === 'transfer') epp.classList.remove('d-none');
        else epp.classList.add('d-none');
    }

    document.getElementById('domains').addEventListener('change', function (e) {
        if (!e.target.classList.contains('domain-reg-action')) return;
        const block = e.target.closest('.domain-block');
        applyDomainAction(block);
        updatesummary();
    });

    document.querySelector('.adddomain').addEventListener('click', function (e) {
        e.preventDefault();
        const domains = document.getElementById('domains');
        const first = domains.querySelector('.domain-block[data-index="0"]');
        const clone = first.cloneNode(true);

        // reset
        clone.querySelectorAll('input').forEach(i => i.value = '');
        clone.querySelectorAll('select').forEach(s => s.selectedIndex = 0);
        clone.querySelectorAll('.domain-fields').forEach(f => f.classList.add('d-none'));
        clone.querySelectorAll('.domain-eppcode').forEach(f => f.classList.add('d-none'));
        clone.querySelectorAll('.domain-reg-action').forEach(r => r.checked = (r.value === ''));

        // show remove
        const rm = clone.querySelector('.removeDomain');
        if (rm) rm.classList.remove('d-none');

        domains.appendChild(clone);
        renumberDomains();
        updatesummary();
    });

    document.getElementById('domains').addEventListener('click', function (e) {
        const btn = e.target.closest('.removeDomain');
        if (!btn) return;
        e.preventDefault();
        btn.closest('.domain-block').remove();
        renumberDomains();
        updatesummary();
    });

    // init domain block 0
    applyDomainAction(document.querySelector('#domains .domain-block'));

    // ----- Promo modal (UI only hook) -----
    const promoModal = new bootstrap.Modal(document.getElementById('modalCreatePromo'));
    document.getElementById('createPromoCode').addEventListener('click', () => promoModal.show());

    document.getElementById('savePromoBtn').addEventListener('click', function () {
        const code = (document.getElementById('newPromoCode').value || '').trim();
        if (!code) return;

        // add to promo dropdown and select it
        const promodd = document.getElementById('promodd');
        const opt = new Option(code, code, true, true);
        promodd.add(opt);
        $('#promodd').trigger('change');

        promoModal.hide();
        updatesummary();
    });

    // ----- Submit validation modal like WHMCS -----
    const warnModal = new bootstrap.Modal(document.getElementById('modalvalidationResults'));
    let bypassOnce = false;

    document.getElementById('orderfrm').addEventListener('submit', function (e) {
        if (bypassOnce) return;

        // if any domain action register/transfer chosen but regdomain empty -> warn
        const domainBlocks = document.querySelectorAll('#domains .domain-block');
        let missing = false;
        domainBlocks.forEach(b => {
            const action = b.querySelector('.domain-reg-action:checked') ? .value || '';
            if (action) {
                const regdomain = b.querySelector('input[name="regdomain[]"]') ? .value ? .trim();
                if (!regdomain) missing = true;
            }
        });

        if (missing) {
            e.preventDefault();
            warnModal.show();
        }
    });

    document.getElementById('forceSubmitBtn').addEventListener('click', function () {
        bypassOnce = true;
        warnModal.hide();
        document.getElementById('orderfrm').submit();
    });

    // first run
    updatesummary();

</script>
@endpush
