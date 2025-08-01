@extends('layouts.app')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-first">
                    <h3>Edit Purchase Order</h3>
                    <p class="text-subtitle text-muted">Edit purchase order details</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('purchase.index') }}">Purchase Order</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Purchase Order</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <form class="form" method="POST" action="{{ route('purchase.update', $purchase->id) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Customer Information Section -->
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="card">
                            <div class="card-header bg-light">
                                @if (App\Models\User::checkRole('master_admin') || App\Models\User::checkRole('admin_chat_input'))

                                <a href="{{ route('purchase-estimasi.pdf', [$purchase->id]) }}" target="_blank" class="btn icon btn-info"> <i class="fas fa-file-pdf me-2"></i>
                                Invoice Estimasi
                                </a>
                                @endif
                                @if (App\Models\User::checkRole('master_admin') || App\Models\User::checkRole('admin_purchase'))

                                 <a href="{{ route('purchase-hpp.pdf', [$purchase->id]) }}" target="_blank" class="btn icon btn-warning"> <i class="fas fa-file-pdf me-2"></i>
                                Invoice HPP
                                </a>
                                @endif

                                @if (App\Models\User::checkRole('master_admin') || App\Models\User::checkRole('operasional'))

                                <a href="{{ route('purchase-operasional.pdf', [$purchase->id]) }}" target="_blank" class="btn icon btn-danger"> <i class="fas fa-file-pdf me-2"></i>
                                Invoice Oprasional
                                </a>
                                @endif

                                @if (App\Models\User::checkRole('master_admin'))

                                 <a href="{{ route('purchase-received.pdf', [$purchase->id]) }}" target="_blank" class="btn icon btn-primary"> <i class="fas fa-file-pdf me-2"></i>
                                Invoice Received
                                </a>
                                @endif

                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <h5 class="card-title">Customer Information</h5>


                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="customer" class="form-label">Customer</label>
                                                <select class="choices form-select" disabled id="customer"
                                                    name="no_telp">
                                                    <option value="">Select customer</option>
                                                    @foreach ($customers as $customer)
                                                        <option value="{{ $customer->whatsapp_number }}"
                                                            {{ $purchase->no_telp === $customer->whatsapp_number ? 'selected' : '' }}>
                                                            {{ $customer->whatsapp_number }} - {{ $customer->display_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" id="name" class="form-control form-control-lg"
                                                    value="{{ old('nama', $purchase->nama) }}" readonly name="nama">
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="text" id="email" class="form-control form-control-lg"
                                                    value="{{ old('email', $purchase->email) }}" readonly name="email">
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="address" class="form-label">Address</label>
                                                <input type="text" id="address" class="form-control form-control-lg"
                                                    value="{{ old('alamat', $purchase->alamat) }}" readonly
                                                    name="alamat">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Items Section -->
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Customer PO</h4>
                                <div class="row">
                                    <div class="col-12 col-md-6 order-md-1 order-first">
                                        <h3>Purchase Order #{{ $purchase->purchase_number }}</h3>
                                        <div class="summary-badges mt-2">
                                            <span class="badge bg-light-primary">
                                                <i class="bi bi-box-seam"></i> {{ $total_items }} Items
                                            </span>
                                            <span class="badge bg-light-success">
                                                <i class="bi bi-cash-stack"></i>
                                                {{ number_format($total_estimasi_harga, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div id="items-container">
                                        @foreach ($purchaseOrderDetail as $index => $item)
                                            <div class="item-row row mb-3 border p-3 rounded">
                                                <div class="col-md-12 col-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Customer Order</label>
                                                        <select class="choices form-select customer-order-select" disabled
                                                            name="items[{{ $index }}][customer_order_id]"
                                                            data-index="{{ $index }}"
                                                            data-selected="{{ $item->no_po }}">
                                                            <option value="">Select Customer Order</option>
                                                            <option value="{{ $item->no_po }}" selected>
                                                                {{ $item->no_po }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label class="form-label">No. PO Customer</label>
                                                        <input type="text" class="form-control"
                                                            name="items[{{ $index }}][no_po_customer]"
                                                            value="{{ old("items.$index.no_po_customer", $item->no_po) }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Nama Barang</label>
                                                        <input type="text" class="form-control" readonly
                                                            name="items[{{ $index }}][nama_barang]"
                                                            value="{{ old("items.$index.nama_barang", $item->nama_barang) }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">

                                                    <div class="form-group">
                                                        <label class="form-label">Link Barang</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control link-input" readonly
                                                                value="{{ old("items.$index.link_barang", $item->link_barang) }}"
                                                                name="items[{{ $index }}][link_barang]">
                                                            <button class="btn btn-outline-primary btn-open-link"
                                                                type="button" disabled>
                                                                <i class="bi bi-box-arrow-up-right"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Estimasi Kg</label>
                                                        <input type="text" class="form-control" readonly
                                                            name="items[{{ $index }}][estimasi_kg]"
                                                            value="{{ old("items.$index.estimasi_kg", $item->estimasi_kg) }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Estimasi Harga</label>
                                                        <input type="text" class="form-control"
                                                            name="items[{{ $index }}][estimasi_harga]" readonly
                                                            value="{{ old("items.$index.estimasi_harga", $item->estimasi_harga) }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="accordion mb-3" id="accordionExample{{ $index }}">
                                                        <!-- Estimasi -->
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header"
                                                                id="headingEstimasi{{ $index }}">
                                                                <div
                                                                    class="d-flex justify-content-between align-items-center w-100 pe-2">
                                                                    <button class="accordion-button flex-grow-1 text-start"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#collapseEstimasi{{ $index }}"
                                                                        aria-expanded="false"
                                                                        aria-controls="collapseEstimasi{{ $index }}">
                                                                        Estimasi
                                                                    </button>
                                                                       @if (App\Models\User::checkRole('master_admin') || App\Models\User::checkRole('admin_chat_input'))
                                                                        <button type="button"
                                                                            class="btn btn-outline-primary btn-sm edit-estimasi-btn ms-2"
                                                                            data-item-id="{{ $item->id }}"
                                                                            data-nama-rek="{{ $item->nama_rek_transfer }}"
                                                                            data-jumlah-transfer="{{ $item->jumlah_transfer }}"
                                                                            data-dp="{{ $item->dp }}"
                                                                            data-full-payment="{{ $item->fullpayment }}"
                                                                            data-foto-bukti="{{ $item->foto_bukti_tf }}"
                                                                            data-status-follow-up="{{ $item->status_follow_up }}"
                                                                            data-mutasi-check="{{ $item->mutasi_check ? 'true' : 'false' }}">
                                                                            <i class="bi bi-pencil"></i> Edit
                                                                        </button>

                                                                        @else
                                                                            <button type="button" 
                                                                                class="btn btn-outline-primary btn-sm edit-estimasi-btn ms-2" disabled style="background: #ccc">
                                                                                <i class="bi bi-pencil"></i> Edit
                                                                            </button>
                                                                        @endif
                                                                </div>
                                                            </h2>
                                                            <div id="collapseEstimasi{{ $index }}"
                                                                class="accordion-collapse collapse"
                                                                aria-labelledby="headingEstimasi{{ $index }}"
                                                                data-bs-parent="#accordionExample{{ $index }}">
                                                                <div class="accordion-body">
                                                                    <!-- Konten Estimasi -->
                                                                        <div class="estimasi-simple">
                                                                        <!-- Baris Pertama -->
                                                                        <div class="row mb-3 border-bottom pb-2">
                                                                            <div class="col-md-6">
                                                                                <div class="mb-2">
                                                                                    <small class="text-muted d-block">Name
                                                                                        Rek Transfer</small>
                                                                                    <div class="fw-semibold">
                                                                                        {{ $item->nama_rek_transfer ?? '-' }}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="mb-2">
                                                                                    <small
                                                                                        class="text-muted d-block">Jumlah
                                                                                        Transfer</small>
                                                                                    <div class="fw-semibold">
                                                                                        {{ number_format($item->jumlah_transfer ?? 0, 0, ',', '.') }}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Baris Kedua -->
                                                                        <div class="row mb-3 border-bottom pb-2">
                                                                            <div class="col-md-6">
                                                                                <div class="mb-2">
                                                                                    <small
                                                                                        class="text-muted d-block">DP</small>
                                                                                    <div class="fw-semibold">
                                                                                        {{ number_format($item->dp ?? 0, 0, ',', '.') }}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="mb-2">
                                                                                    <small class="text-muted d-block">Full
                                                                                        Payment</small>
                                                                                    <div class="fw-semibold">
                                                                                        {{ number_format($item->fullpayment ?? 0, 0, ',', '.') }}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Baris Ketiga -->
                                                                        <div class="row mb-3 border-bottom pb-2">
                                                                            <div class="col-md-6">
                                                                                <div class="mb-2">
                                                                                    <small
                                                                                        class="text-muted d-block">Status
                                                                                        Follow Up</small>
                                                                                    <span
                                                                                        class="badge 
                                                                                            @if ($item->status_follow_up == 'Scheduled') bg-warning text-dark
                                                                                            @elseif($item->status_follow_up == 'Followed') bg-success
                                                                                            @elseif($item->status_follow_up == 'Unfollowed') bg-danger
                                                                                            @else bg-secondary @endif">
                                                                                        {{ $item->status_follow_up ?? 'Belum diisi' }}
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="mb-2">
                                                                                    <small
                                                                                        class="text-muted d-block">Mutasi
                                                                                        Check</small>
                                                                                    <span
                                                                                        class="badge {{ $item->mutasi_check ? 'bg-success' : 'bg-secondary' }}">
                                                                                        {{ $item->mutasi_check ? 'Checked' : 'Unchecked' }}
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Foto Bukti Transfer -->
                                                                        <div class="mb-3">
                                                                            <small class="text-muted d-block">Foto Bukti
                                                                                Transfer</small>
                                                                            @if ($item->foto_bukti_tf ?? false)
                                                                                <a href="{{ asset('storage/' . $item->foto_bukti_tf) }}"
                                                                                    target="_blank"
                                                                                    class="btn btn-sm btn-outline-primary mt-1">
                                                                                    <i class="bi bi-eye"></i> Lihat Dokumen
                                                                                </a>
                                                                                <small class="text-muted d-block mt-1">
                                                                                    {{ strtoupper(pathinfo($item->foto_bukti_tf, PATHINFO_EXTENSION)) }}
                                                                                    •
                                                                                    {{ round(filesize(public_path('storage/' . $item->foto_bukti_tf)) / 1024) }}
                                                                                    KB
                                                                                </small>
                                                                            @else
                                                                                <span class="text-muted">-</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- HPP -->
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header"
                                                                id="headingHpp{{ $index }}">
                                                                <div
                                                                    class="d-flex justify-content-between align-items-center w-100 pe-2">
                                                                    <button
                                                                        class="accordion-button collapsed flex-grow-1 text-start"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#collapseHpp{{ $index }}"
                                                                        aria-expanded="false"
                                                                        aria-controls="collapseHpp{{ $index }}">
                                                                        HPP
                                                                    </button>
                                                                     @if (App\Models\User::checkRole('master_admin') || App\Models\User::checkRole('admin_purchase'))
                                                                    <button type="button"
                                                                        class="btn btn-outline-primary btn-sm edit-hpp-btn ms-2"
                                                                        data-item-id="{{ $item->id }}"
                                                                        data-payment-method="{{ $item->payment_method }}"
                                                                        data-total-purchase="{{ $item->total_purchase }}"
                                                                        data-status-purchase="{{ $item->status_purchase }}"
                                                                        data-notes="{{ $item->notes }}"
                                                                        data-bukti-pembelian="{{ $item->bukti_pembelian_path }}"
                                                                        data-hpp-mutasi-check="{{ $item->hpp_mutasi_check ? 'true' : 'false' }}">
                                                                        <i class="bi bi-pencil"></i> Edit
                                                                    </button>
                                                                    @else
                                                                    <button type="button"
                                                                        class="btn btn-outline-primary btn-sm edit-hpp-btn ms-2" disabled style="background: #ccc">
                                                                        <i class="bi bi-pencil"></i> Edit
                                                                    </button>
                                                                    @endif
                                                                </div>
                                                            </h2>
                                                            <div id="collapseHpp{{ $index }}"
                                                                class="accordion-collapse collapse"
                                                                aria-labelledby="headingHpp{{ $index }}"
                                                                data-bs-parent="#accordionExample{{ $index }}">
                                                                <div class="accordion-body">
                                                                    <!-- Konten HPP -->
                                                                         <div class="hpp-simple">
                                                                        <!-- Baris Pertama -->
                                                                        <div class="row mb-3 border-bottom pb-2">
                                                                            <div class="col-md-6">
                                                                                <div class="mb-2">
                                                                                    <small
                                                                                        class="text-muted d-block">Payment
                                                                                        Method</small>
                                                                                    <div class="fw-semibold">
                                                                                        {{ $item->payment_method ?? '-' }}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="mb-2">
                                                                                    <small class="text-muted d-block">Total
                                                                                        Purchase</small>
                                                                                    <div class="fw-semibold">
                                                                                        {{ number_format($item->total_purchase ?? 0, 0, ',', '.') }}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Baris Kedua -->
                                                                        <div class="row mb-3 border-bottom pb-2">
                                                                            <div class="col-md-6">
                                                                                <div class="mb-2">
                                                                                    <small
                                                                                        class="text-muted d-block">Status
                                                                                        Purchase</small>
                                                                                    <span
                                                                                        class="badge 
                                                                                        @if ($item->status_purchase == 'Wait For Order') bg-warning text-dark
                                                                                        @elseif($item->status_purchase == 'Ordered') bg-success
                                                                                        @elseif($item->status_purchase == 'Failed Order') bg-danger
                                                                                        @else bg-secondary @endif">
                                                                                        {{ $item->status_purchase ?? 'Belum diisi' }}
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="mb-2">
                                                                                    <small
                                                                                        class="text-muted d-block">Mutasi
                                                                                        Check</small>
                                                                                    <span
                                                                                        class="badge {{ $item->hpp_mutasi_check ? 'bg-success' : 'bg-secondary' }}">
                                                                                        {{ $item->hpp_mutasi_check ? 'Available' : 'Not Available' }}
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Baris Ketiga -->
                                                                        <div class="row mb-3">
                                                                            <div class="col-12">
                                                                                <div class="mb-2">
                                                                                    <small
                                                                                        class="text-muted d-block">Notes</small>
                                                                                    <div class="fw-semibold">
                                                                                        {{ $item->notes ?? '-' }}</div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Foto Bukti Pembelian -->
                                                                        <div class="mb-3 border-top pt-2">
                                                                            <small class="text-muted d-block">Foto Bukti
                                                                                Pembelian</small>
                                                                            @if ($item->foto_bukti_pembelian ?? false)
                                                                                <a href="{{ asset('storage/' . $item->foto_bukti_pembelian) }}"
                                                                                    target="_blank"
                                                                                    class="btn btn-sm btn-outline-primary mt-1">
                                                                                    <i class="bi bi-eye"></i> Lihat Dokumen
                                                                                </a>
                                                                                <small class="text-muted d-block mt-1">
                                                                                    {{ strtoupper(pathinfo($item->foto_bukti_pembelian, PATHINFO_EXTENSION)) }}
                                                                                    •
                                                                                    {{ round(filesize(public_path('storage/' . $item->foto_bukti_pembelian)) / 1024) }}
                                                                                    KB
                                                                                </small>
                                                                            @else
                                                                                <span class="text-muted">-</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Operasional -->
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header"
                                                                id="headingOperasional{{ $index }}">
                                                                <div
                                                                    class="d-flex justify-content-between align-items-center w-100 pe-2">
                                                                    <button
                                                                        class="accordion-button collapsed flex-grow-1 text-start"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#collapseOperasional{{ $index }}"
                                                                        aria-expanded="false"
                                                                        aria-controls="collapseOperasional{{ $index }}">
                                                                        Operasional
                                                                    </button>
                                                                     @if (App\Models\User::checkRole('master_admin') || App\Models\User::checkRole('operasional'))
                                                                        <button type="button"
                                                                            class="btn btn-outline-primary btn-sm edit-operasional-btn ms-2"
                                                                            data-item-id="{{ $item->id }}"
                                                                            data-wh-usa-path="{{ $item->wh_usa_path }}"
                                                                            data-wh-usa-mutasi-check="{{ $item->wh_usa_mutasi_check ? 'true' : 'false' }}"
                                                                            data-wh-indonesia-path="{{ $item->wh_indonesia_path }}"
                                                                            data-fix-weight="{{ $item->fix_weight }}"
                                                                            data-fix-price="{{ $item->fix_price }}"
                                                                            data-status-barang-sampai="{{ $item->status_barang_sampai }}">
                                                                            <i class="bi bi-pencil"></i> Edit
                                                                        </button>
                                                                    @else
                                                                        <button type="button"
                                                                            class="btn btn-outline-primary btn-sm edit-operasional-btn ms-2" disabled style="background: #ccc">
                                                                            <i class="bi bi-pencil"></i> Edit
                                                                        </button>
                                                                    @endif
                                                                </div>
                                                            </h2>
                                                            <div id="collapseOperasional{{ $index }}"
                                                                class="accordion-collapse collapse"
                                                                aria-labelledby="headingOperasional{{ $index }}"
                                                                data-bs-parent="#accordionExample{{ $index }}">
                                                                <div class="accordion-body">
                                                                    <!-- Konten Operasional -->
                                                                       <div class="operasional-simple">
                                                                        <!-- Baris Pertama -->
                                                                        <div class="row mb-3 border-bottom pb-2">
                                                                            <div class="col-md-6">
                                                                                <div class="mb-2">
                                                                                    <small class="text-muted d-block">Fix
                                                                                        Price</small>
                                                                                    <div class="fw-semibold">
                                                                                        {{ $item->fix_price ? number_format($item->fix_price, 0, ',', '.') : '-' }}
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-6">
                                                                                <div class="mb-2">
                                                                                    <small class="text-muted d-block">Fix
                                                                                        Weight</small>
                                                                                    <div class="fw-semibold">
                                                                                        {{ $item->fix_weight ? $item->fix_weight . ' kg' : '-' }}
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                        <!-- Baris Ketiga -->
                                                                        <div class="row mb-3 border-bottom pb-2">

                                                                            <div class="col-md-6">
                                                                                <div class="mb-2">
                                                                                    <small
                                                                                        class="text-muted d-block">Status
                                                                                        WH USA</small>
                                                                                    <span
                                                                                        class="badge {{ $item->wh_usa_mutasi_check ? 'bg-success' : 'bg-secondary' }}">
                                                                                        {{ $item->wh_usa_mutasi_check ? 'Done' : 'Failed' }}
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="mb-2">
                                                                                    <small
                                                                                        class="text-muted d-block">Status
                                                                                        Barang</small>
                                                                                    <span
                                                                                        class="badge 
                                                                                            @if ($item->status_barang_sampai == 'Waiting Courier') bg-warning text-dark
                                                                                            @elseif($item->status_barang_sampai == 'Received') bg-success
                                                                                            @elseif($item->status_barang_sampai == 'Cancel') bg-danger
                                                                                            @else bg-secondary @endif">
                                                                                        {{ $item->status_barang_sampai ?? 'Belum diisi' }}
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- Baris Kedua -->
                                                                        <div class="row mb-3 border-bottom pb-2">
                                                                            <div class="col-md-6">
                                                                                <div class="mb-2">
                                                                                    <small class="text-muted d-block">WH
                                                                                        Indonesia</small>
                                                                                    @if ($item->wh_indo ?? false)
                                                                                        <a href="{{ asset('storage/' . $item->wh_indo) }}"
                                                                                            target="_blank"
                                                                                            class="btn btn-sm btn-outline-primary mt-1">
                                                                                            <i class="bi bi-eye"></i> Lihat
                                                                                            Dokumen
                                                                                        </a>
                                                                                        <small
                                                                                            class="text-muted d-block mt-1">
                                                                                            {{ strtoupper(pathinfo($item->wh_indo, PATHINFO_EXTENSION)) }}
                                                                                            •
                                                                                            {{ round(filesize(public_path('storage/' . $item->wh_indo)) / 1024) }}
                                                                                            KB
                                                                                        </small>
                                                                                    @else
                                                                                        <span class="text-muted">-</span>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="mb-2">
                                                                                    <small class="text-muted d-block">WH
                                                                                        USA</small>
                                                                                    @if ($item->wh_usa ?? false)
                                                                                        <a href="{{ asset('storage/' . $item->wh_usa) }}"
                                                                                            target="_blank"
                                                                                            class="btn btn-sm btn-outline-primary mt-1">
                                                                                            <i class="bi bi-eye"></i> Lihat
                                                                                            Dokumen
                                                                                        </a>
                                                                                        <small
                                                                                            class="text-muted d-block mt-1">
                                                                                            {{ strtoupper(pathinfo($item->wh_usa, PATHINFO_EXTENSION)) }}
                                                                                            •
                                                                                            {{ round(filesize(public_path('storage/' . $item->wh_usa)) / 1024) }}
                                                                                            KB
                                                                                        </small>
                                                                                    @else
                                                                                        <span class="text-muted">-</span>
                                                                                    @endif
                                                                                </div>
                                                                            </div>

                                                                        </div>


                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                               

                                                </div>
                                                <div class="col-md-12 col-12 text-end">





                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </form>
        </section>
    </div>

    <div class="modal fade" id="estimasiModal" tabindex="-1" aria-labelledby="estimasiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="estimasiModalLabel">Edit Estimasi Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="estimasiForm">
                    @csrf
                    <input type="hidden" id="item_id" name="item_id">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label class="form-label">Nama Rek Transfer</label>
                                <input type="text" id="nama_rek" class="form-control form-control-lg"
                                    name="nama_rek">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label class="form-label">Jumlah Transfer</label>
                                <input type="number" id="jumlah_transfer" class="form-control form-control-lg"
                                    name="jumlah_transfer">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label class="form-label">DP</label>
                                <input type="number" id="dp" class="form-control form-control-lg"
                                    name="dp">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label class="form-label">Full Payment</label>
                                <input type="number" id="full_payment" class="form-control form-control-lg"
                                    name="full_payment">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="form-label">Status Follow Up</label>
                                <select class="choices form-select" id="status_follow_up" name="status_follow_up">
                                    <option value="">Press to select</option>
                                    <option value="Scheduled">Scheduled</option>
                                    <option value="Followed">Followed</option>
                                    <option value="Unfollowed">Unfollowed</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label class="form-label">Foto Bukti Transfer</label>
                                <input type="file" id="bukti_transfer" class="form-control form-control-lg"
                                    name="bukti_transfer">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label class="form-label">Mutasi Check</label>
                                <br>
                                <input id="modal_btn_status" type="checkbox" data-onstyle="info" data-toggle="toggle"
                                    data-on="Available" data-off="Not Available" data-offstyle="secondary"
                                    data-width="200" data-height="45">
                                <input type="hidden" id="modal_status" name="mutasi_check" value="false">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveEstimasi">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal HPP -->
<div class="modal fade" id="hppModal" tabindex="-1" aria-labelledby="hppModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hppModalLabel">Edit HPP</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="hppForm">
                    @csrf
                    <input type="hidden" id="hpp_item_id" name="item_id">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label class="form-label">Payment Method</label>
                                <input type="text" id="payment_method" class="form-control form-control-lg"
                                    name="payment_method">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label class="form-label">Total Purchase</label>
                                <input type="number" id="total_purchase" class="form-control form-control-lg"
                                    name="total_purchase">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="form-label">Status Purchase</label>
                                <select class="choices form-select" id="status_purchase" name="status_purchase">
                                    <option value="">Press to select</option>
                                    <option value="Wait For Order">Wait For Order</option>
                                    <option value="Ordered">Ordered</option>
                                    <option value="Failed Order">Failed Order</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label class="form-label">Notes</label>
                                <input type="text" id="notes" class="form-control form-control-lg"
                                    name="notes">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label class="form-label">Foto Bukti Pembelian</label>
                                <input type="file" id="bukti_pembelian" class="form-control form-control-lg"
                                    name="bukti_pembelian">
                                <div id="bukti_pembelian_preview" class="mt-2"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label class="form-label">Mutasi Check</label>
                                <br>
                                <input id="hpp_btn_status" type="checkbox" data-onstyle="info" data-toggle="toggle"
                                    data-on="Available" data-off="Not Available" data-offstyle="secondary"
                                    data-width="200" data-height="45">
                                <input type="hidden" id="hpp_status" name="hpp_mutasi_check" value="false">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveHpp">Save changes</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal Operasional -->
<div class="modal fade" id="operasionalModal" tabindex="-1" aria-labelledby="operasionalModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="operasionalModalLabel">Edit Operasional</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="operasionalForm">
                    @csrf
                    <input type="hidden" id="operasional_item_id" name="item_id">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label class="form-label">Fix Weight (kg)</label>
                                <input type="number" step="0.01" id="fix_weight"
                                    class="form-control form-control-lg" name="fix_weight">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label class="form-label">Fix Price</label>
                                <input type="number" id="fix_price" class="form-control form-control-lg"
                                    name="fix_price">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="form-label">Status Barang Sampai</label>
                                <select class="choices form-select" id="status_barang_sampai"
                                    name="status_barang_sampai">
                                    <option value="">Press to select</option>
                                    <option value="Waiting Courier">Waiting Courier</option>
                                    <option value="Received">Received</option>
                                    <option value="Cancel">Cancel</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label class="form-label">Status On Check</label>
                                <br>
                                <input id="wh_usa_btn_status" type="checkbox" data-onstyle="info"
                                    data-toggle="toggle" data-on="Done" data-off="Failed" data-offstyle="secondary"
                                    data-width="200" data-height="45">
                                <input type="hidden" id="wh_usa_status" name="wh_usa_mutasi_check" value="false">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label class="form-label">WH USA</label>
                                <input type="file" id="wh_usa" class="form-control form-control-lg"
                                    name="wh_usa">
                                <div id="wh_usa_preview" class="mt-2"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label class="form-label">WH Indo</label>
                                <input type="file" id="wh_indonesia" class="form-control form-control-lg"
                                    name="wh_indonesia">
                                <div id="wh_indonesia_preview" class="mt-2"></div>
                            </div>
                        </div>


                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveOperasional">Save changes</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Inisialisasi data customer order dari controller
            const estimasiModal = new bootstrap.Modal(document.getElementById('estimasiModal'));
            initLinkButtons();

            // Juga panggil saat menambah item baru

            // Toggle untuk mutasi check
            $('#modal_btn_status').change(function() {
                $('#modal_status').val($(this).prop('checked'));
            });

            $(document).on('click', '.edit-estimasi-btn', function() {
                const itemId = $(this).data('item-id');
                $('#item_id').val(itemId);
                $('#nama_rek').val($(this).data('nama-rek'));
                $('#jumlah_transfer').val($(this).data('jumlah-transfer'));
                $('#dp').val($(this).data('dp'));
                $('#full_payment').val($(this).data('full-payment'));
                $('#status_follow_up').val($(this).data('status-follow-up'));

                // Set toggle
                const isChecked = $(this).data('mutasi-check') === 'true';
                $('#modal_btn_status').prop('checked', isChecked).change();
                $('#modal_status').val(isChecked);

                // Inisialisasi Choices untuk select
                new Choices('#status_follow_up', {
                    searchEnabled: false,
                    shouldSort: false,
                    itemSelectText: ''
                });
                // Tampilkan modal
                estimasiModal.show();
            });

            $('#saveEstimasi').click(function() {
                // Validasi form
                const requiredFields = [{
                        id: '#nama_rek',
                        name: 'Nama Rekening'
                    },
                    {
                        id: '#jumlah_transfer',
                        name: 'Jumlah Transfer'
                    },
                    {
                        id: '#dp',
                        name: 'DP'
                    },
                    {
                        id: '#status_follow_up',
                        name: 'Status Follow Up'
                    },
                    {
                        id: '#full_payment',
                        name: 'Full Payment'
                    },
                    {
                        id: '#bukti_transfer',
                        name: 'Bukti Transfer'
                    }
                ];

                let isValid = true;
                const emptyFields = [];

                // Cek field wajib diisi
                requiredFields.forEach(field => {
                    const $field = $(field.id);
                    if (!$field.val() || $field.val().trim() === '') {
                        isValid = false;
                        $field.addClass('is-invalid');
                        emptyFields.push(field.name);
                    } else {
                        $field.removeClass('is-invalid');
                    }
                });

                // Validasi file upload
                const fileInput = $('#bukti_transfer')[0];
                if (fileInput.files.length > 0) {
                    const file = fileInput.files[0];
                    const validTypes = ['image/jpeg', 'image/png', 'application/pdf'];
                    const maxSize = 2 * 1024 * 1024; // 2MB

                    if (!validTypes.includes(file.type)) {
                        isValid = false;
                        $('#bukti_transfer').addClass('is-invalid');
                        emptyFields.push('Format file bukti transfer tidak valid (hanya JPEG, PNG, PDF)');
                    }

                    if (file.size > maxSize) {
                        isValid = false;
                        $('#bukti_transfer').addClass('is-invalid');
                        emptyFields.push('Ukuran file bukti transfer terlalu besar (maks 2MB)');
                    }
                }

                if (!isValid) {
                    // Tampilkan error dengan format lebih baik
                    let errorMessage;
                    if (emptyFields.length > 3) {
                        errorMessage =
                            `<b>${emptyFields.length} field wajib</b> belum diisi atau tidak valid`;
                    } else {
                        errorMessage =
                            `<b>Masalah berikut perlu diperbaiki:</b><br>• ${emptyFields.join('<br>• ')}`;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Form Tidak Lengkap',
                        html: errorMessage,
                        footer: 'Harap periksa kembali form Anda'
                    });
                    return;
                }

                // Jika valid, tampilkan konfirmasi
                Swal.fire({
                    title: 'Simpan Perubahan?',
                    text: "Anda yakin ingin menyimpan data estimasi pembayaran ini?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Simpan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit form via AJAX
                        const formData = new FormData($('#estimasiForm')[0]);

                        // Tampilkan loading
                        Swal.fire({
                            title: 'Menyimpan...',
                            html: 'Sedang memproses data',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        const itemId = $('#item_id').val();
                        // Ganti URL dengan endpoint Anda
                        $.ajax({
                            url: `/purchase-order-detail/${itemId}/update-estimasi`,
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Data estimasi berhasil disimpan',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    // Tutup modal dan refresh data
                                    $('#estimasiModal').modal('hide');
                                    location
                                        .reload(); // atau update tabel secara dinamis
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: xhr.responseJSON?.message ||
                                        'Terjadi kesalahan saat menyimpan data'
                                });
                            }
                        });
                    }
                });
            });

            // Reset form saat modal ditutup
            $('#estimasiModal').on('hidden.bs.modal', function() {
                $('#estimasiForm')[0].reset();
                $('.is-invalid').removeClass('is-invalid');
                $('#modal_btn_status').bootstrapToggle('off');
                $('#modal_status').val('false');
            });

            // Handler untuk input file (preview)
            $('#bukti_transfer').change(function() {
                const file = this.files[0];
                if (file) {
                    // Validasi ukuran file
                    if (file.size > 2 * 1024 * 1024) {
                        $(this).addClass('is-invalid');
                        Swal.fire({
                            icon: 'warning',
                            title: 'File terlalu besar',
                            text: 'Ukuran file maksimal 2MB'
                        });
                        $(this).val('');
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                }
            });




            const hppModal = new bootstrap.Modal(document.getElementById('hppModal'));

            // Toggle untuk mutasi check HPP
            $('#hpp_btn_status').change(function() {
                $('#hpp_status').val($(this).prop('checked'));
            });

            $(document).on('click', '.edit-hpp-btn', function() {
                const itemId = $(this).data('item-id');

                // Isi form modal dengan data dari tombol
                $('#hpp_item_id').val(itemId);
                $('#payment_method').val($(this).data('payment-method'));
                $('#total_purchase').val($(this).data('total-purchase'));
                $('#status_purchase').val($(this).data('status-purchase'));
                $('#notes').val($(this).data('notes'));

                // Tampilkan preview bukti pembelian jika ada
                const buktiPembelianPath = $(this).data('bukti-pembelian');
                const previewDiv = $('#bukti_pembelian_preview');
                previewDiv.empty();

                if (buktiPembelianPath) {
                    previewDiv.append(`
                <img src="/storage/${buktiPembelianPath}" class="img-thumbnail" style="max-height: 100px;">
                <p class="small text-muted mt-1">Current file</p>
            `);
                }

                // Set toggle
                const isChecked = $(this).data('hpp-mutasi-check') === 'true';
                $('#hpp_btn_status').prop('checked', isChecked).change();
                $('#hpp_status').val(isChecked);

                // Inisialisasi Choices untuk select
                new Choices('#status_purchase', {
                    searchEnabled: false,
                    shouldSort: false,
                    itemSelectText: ''
                });

                // Tampilkan modal
                hppModal.show();
            });

            $('#bukti_pembelian').change(function() {
                const file = this.files[0];
                const preview = $('#bukti_pembelian_preview');
                preview.empty();

                if (file) {
                    if (!file.type.match('image.*')) {
                        preview.html('<div class="text-danger">File harus berupa gambar</div>');
                        $(this).val('');
                        return;
                    }

                    if (file.size > 2 * 1024 * 1024) {
                        preview.html('<div class="text-danger">Ukuran file maksimal 2MB</div>');
                        $(this).val('');
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.html(
                            `<img src="${e.target.result}" class="img-thumbnail" style="max-height: 150px;">`
                        );
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Handler untuk tombol save
            $('#saveHpp').click(function() {
                // Validasi form
                const requiredFields = [{
                        id: '#payment_method',
                        name: 'Payment Method'
                    },
                    {
                        id: '#total_purchase',
                        name: 'Total Purchase'
                    },
                    {
                        id: '#notes',
                        name: 'Notes'
                    },
                    {
                        id: '#bukti_pembelian',
                        name: 'Foto Bukti Pembelian'
                    }
                ];

                let isValid = true;
                const emptyFields = [];

                requiredFields.forEach(field => {
                    const $field = $(field.id);
                    const value = $field.is('input[type="file"]') ? $field[0].files[0] : $field
                        .val();

                    if (!value) {
                        isValid = false;
                        $field.addClass('is-invalid');
                        emptyFields.push(field.name);
                    } else {
                        $field.removeClass('is-invalid');
                    }
                });

                if (!isValid) {
                    const errorMessage = emptyFields.length > 3 ?
                        `<b>${emptyFields.length} field wajib</b> belum diisi` :
                        `<b>Field wajib berikut belum diisi:</b><br>• ${emptyFields.join('<br>• ')}`;

                    Swal.fire({
                        icon: 'error',
                        title: 'Form Tidak Lengkap',
                        html: errorMessage,
                        footer: 'Harap periksa kembali form Anda'
                    });
                    return;
                }

                // Jika valid, tampilkan konfirmasi
                Swal.fire({
                    title: 'Simpan Perubahan HPP?',
                    text: "Anda yakin ingin menyimpan data HPP ini?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Simpan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const formData = new FormData($('#hppForm')[0]);
                        const itemId = $('#hpp_item_id').val();

                        // Tampilkan loading
                        Swal.fire({
                            title: 'Menyimpan...',
                            html: 'Sedang memproses data HPP',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Kirim data via AJAX
                        $.ajax({
                            url: `/purchase-order-detail/${itemId}/update-hpp`,
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Data HPP berhasil disimpan',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    $('#hppModal').modal('hide');
                                    location
                                        .reload(); // atau update tabel secara dinamis
                                });
                            },
                            error: function(xhr) {
                                let errorMessage =
                                    'Terjadi kesalahan saat menyimpan data';
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                }

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: errorMessage
                                });
                            }
                        });
                    }
                });
            });

            const operasionalModal = new bootstrap.Modal(document.getElementById('operasionalModal'));

            // Toggle untuk mutasi check WH USA
            $('#wh_usa_btn_status').change(function() {
                $('#wh_usa_status').val($(this).prop('checked'));
            });

            $('#wh_usa').change(function() {
                previewImage(this, '#wh_usa_preview');
            });

            // Preview gambar WH Indonesia
            $('#wh_indonesia').change(function() {
                previewImage(this, '#wh_indonesia_preview');
            });

            // Fungsi untuk preview gambar
            function previewImage(input, previewId) {
                const file = input.files[0];
                const preview = $(previewId);
                preview.empty();

                if (file) {
                    // Validasi tipe file
                    if (!file.type.match('image.*')) {
                        preview.html('<div class="text-danger">File harus berupa gambar (JPEG, PNG)</div>');
                        $(input).val('');
                        return;
                    }

                    // Validasi ukuran file (maks 2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        preview.html('<div class="text-danger">Ukuran file maksimal 2MB</div>');
                        $(input).val('');
                        return;
                    }

                    // Tampilkan preview
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.html(
                            `<img src="${e.target.result}" class="img-thumbnail" style="max-height: 150px;">`
                        );
                    }
                    reader.readAsDataURL(file);
                }
            }
            // Handle klik tombol edit operasional
            $(document).on('click', '.edit-operasional-btn', function() {
                // Ambil data dari tombol
                const itemId = $(this).data('item-id');
                const whUsaStatus = $(this).data('wh-usa-status') === 'true';
                const statusBarang = $(this).data('status-barang');

                // Isi form modal
                $('#operasional_item_id').val(itemId);
                $('#fix_weight').val($(this).data('fix-weight'));
                $('#fix_price').val($(this).data('fix-price'));
                $('#status_barang_sampai').val(statusBarang);

                // Set toggle switch
                if (whUsaStatus) {
                    $('#wh_usa_btn_status').bootstrapToggle('on');
                    $('#wh_usa_status').val('true');
                } else {
                    $('#wh_usa_btn_status').bootstrapToggle('off');
                    $('#wh_usa_status').val('false');
                }

                // Preview gambar jika ada
                const whUsaImg = $(this).data('wh-usa-img');
                const whIndoImg = $(this).data('wh-indo-img');

                if (whUsaImg) {
                    $('#wh_usa_preview').html(
                        `<img src="/storage/${whUsaImg}" class="img-thumbnail" style="max-height: 150px;">`
                    );
                }

                if (whIndoImg) {
                    $('#wh_indonesia_preview').html(
                        `<img src="/storage/${whIndoImg}" class="img-thumbnail" style="max-height: 150px;">`
                    );
                }

                // Tampilkan modal
                $('#operasionalModal').modal('show');
            });

            // Handle simpan operasional
            $('#saveOperasional').click(function() {
                // Validasi form
                const requiredFields = [{
                        id: '#wh_usa',
                        name: 'WH USA',
                        isFile: true
                    },
                    {
                        id: '#wh_indonesia',
                        name: 'WH Indo',
                        isFile: true
                    },
                    {
                        id: '#fix_weight',
                        name: 'Fix Weight'
                    },
                    {
                        id: '#fix_price',
                        name: 'Fix Price'
                    }
                ];

                let isValid = true;
                const emptyFields = [];

                // Cek field wajib
                requiredFields.forEach(field => {
                    const $field = $(field.id);
                    let value = field.isFile ? $field[0].files[0] : $field.val();

                    // Validasi khusus untuk number
                    if (!field.isFile && $field.attr('type') === 'number') {
                        value = parseFloat(value);
                        if (isNaN(value)) value = null;
                    }

                    if (!value) {
                        isValid = false;
                        $field.addClass('is-invalid');
                        emptyFields.push(field.name);
                    } else {
                        $field.removeClass('is-invalid');
                    }
                });

                if (!isValid) {
                    // Format pesan error
                    let errorMessage;
                    if (emptyFields.length > 3) {
                        errorMessage = `<b>${emptyFields.length} field wajib</b> belum diisi`;
                    } else {
                        errorMessage =
                            `<b>Field wajib berikut belum diisi:</b><br>• ${emptyFields.join('<br>• ')}`;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Form Tidak Lengkap',
                        html: errorMessage,
                        footer: 'Harap periksa kembali form Anda'
                    });
                    return;
                }

                // Jika valid, tampilkan konfirmasi
                Swal.fire({
                    title: 'Simpan Data Operasional?',
                    text: "Anda yakin ingin menyimpan perubahan data operasional ini?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Simpan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const formData = new FormData($('#operasionalForm')[0]);
                        const itemId = $('#operasional_item_id').val();

                        // Tampilkan loading
                        const swalLoading = Swal.fire({
                            title: 'Menyimpan...',
                            html: 'Sedang memproses data operasional',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Kirim data via AJAX
                        $.ajax({
                            url: `/purchase-order-detail/${itemId}/update-operasional`,
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                swalLoading.close();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Data operasional berhasil disimpan',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    $('#operasionalModal').modal('hide');
                                    location
                                        .reload(); // atau update tabel secara dinamis
                                });
                            },
                            error: function(xhr) {
                                swalLoading.close();
                                let errorMessage =
                                    'Terjadi kesalahan saat menyimpan data';
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                }

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: errorMessage
                                });
                            }
                        });
                    }
                });
            });

            $('#operasionalModal').on('hidden.bs.modal', function() {
                $('#operasionalForm')[0].reset();
                $('#wh_usa_preview, #wh_indonesia_preview').empty();
                $('.is-invalid').removeClass('is-invalid');
                $('#wh_usa_btn_status').bootstrapToggle('off');
                $('#wh_usa_status').val('false');
            });

            $('#hppModal').on('hidden.bs.modal', function() {
                $('#hppForm')[0].reset();
                $('#bukti_pembelian_preview').empty();
                $('.is-invalid').removeClass('is-invalid');
                $('#hpp_btn_status').bootstrapToggle('off');
                $('#hpp_status').val('false');
            });

            $('#estimasiModal').on('hidden.bs.modal', function() {
                $('#estimasiForm')[0].reset();
                $('.is-invalid').removeClass('is-invalid');
                $('#modal_btn_status').bootstrapToggle('off');
                $('#modal_status').val('false');
            });

        });

        function initLinkButtons() {
            // Handler untuk input link
            $(document).on('input', '.link-input', function() {
                const btn = $(this).next('.btn-open-link');
                btn.prop('disabled', !$(this).val().trim());
            });

            // Handler untuk klik tombol buka link
            $(document).on('click', '.btn-open-link', function() {
                const url = $(this).prev('.link-input').val().trim();
                if (url) {
                    // Validasi URL
                    let finalUrl = url;
                    if (!url.startsWith('http://') && !url.startsWith('https://')) {
                        finalUrl = 'https://' + url;
                    }
                    window.open(finalUrl, '_blank');
                }
            });

            // Auto-disable button jika link kosong saat load
            $('.link-input').each(function() {
                $(this).next('.btn-open-link').prop('disabled', !$(this).val().trim());
            });
        }
    </script>
@endsection
