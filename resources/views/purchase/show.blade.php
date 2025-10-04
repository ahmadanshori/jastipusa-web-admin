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
                                @if ($purchaseOrderDetail->every->mutasi_check && (
                                App\Models\User::checkRole('master_admin') ||
                                App\Models\User::checkRole('admin_chat_input')))
                                <a href="{{ route('purchase-estimasi.pdf', [$purchase->id]) }}" target="_blank"
                                    class="btn icon btn-info"> <i class="fas fa-file-pdf me-2"></i>
                                    Invoice Estimasi
                                </a>
                                @endif
                                @if ($purchaseOrderDetail->every->hpp_mutasi_check && (App\Models\User::checkRole('master_admin') || App\Models\User::checkRole('admin_purchase')))

                                    <a href="{{ route('purchase-hpp.pdf', [$purchase->id]) }}" target="_blank"
                                        class="btn icon btn-warning"> <i class="fas fa-file-pdf me-2"></i>
                                        Invoice HPP
                                    </a>
                                @endif

                                @if ($purchaseOrderDetail->every->status_on_check && (App\Models\User::checkRole('master_admin') || App\Models\User::checkRole('operasional')))

                                    <a href="{{ route('purchase-operasional.pdf', [$purchase->id]) }}" target="_blank"
                                        class="btn icon btn-danger"> <i class="fas fa-file-pdf me-2"></i>
                                        Invoice Oprasional
                                    </a>
                                @endif

                               @if ($purchaseOrderDetail->every->wh_indo && (App\Models\User::checkRole('master_admin') || App\Models\User::checkRole('operasional')))

                                    <a href="{{ route('purchase-received.pdf', [$purchase->id]) }}" target="_blank"
                                        class="btn icon btn-primary"> <i class="fas fa-file-pdf me-2"></i>
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
                                                <label for="tipe_order" class="form-label">Tipe Order</label>
                                                <select class="required choices form-select" disabled id="tipe_order" name="tipe_order">

                                                    <option value="">Press to select</option>
                                                        <option value="01" {{ $purchase->tipe_order == '01' ? 'selected' : '' }}>Jasmin</option>
                                                        <option value="02" {{ $purchase->tipe_order == '02' ? 'selected' : '' }}>Jastip Order</option>
                                                        <option value="03" {{ $purchase->tipe_order == '03' ? 'selected' : '' }}>Jastip Only</option>
                                                        <option value="04" {{ $purchase->tipe_order == '04' ? 'selected' : '' }}>Jastip B2B</option>


                                                </select>
                                            </div>
                                            @error('publish_at')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="customer" class="form-label">Customer</label>
                                                <select class="choices form-select" disabled id="customer" name="no_telp">
                                                    <option value="">{{$purchase->no_telp}} - {{$purchase->nama}}</option>

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

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="phone" class="form-label">Phone</label>
                                                <input type="text" id="phone" class="form-control form-control-lg"
                                                    value="{{ old('phone', $purchase->no_telp) }}" readonly name="phone">

                                                <input type="hidden" id="exchange" value="{{ $exchange }}" readonly
                                                    name="exchange">
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="address" class="form-label">Address</label>
                                                <input type="text" id="address" class="form-control form-control-lg"
                                                    value="{{ old('alamat', $purchase->alamat) }}" readonly name="alamat">
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
                                {{-- <h4 class="card-title">Customer PO</h4> --}}
                                <div class="row">
                                    <div class="col-12 col-md-6 order-md-1 order-first">
                                        <h3>Purchase Order #{{ $purchase->no_invoice }}</h3>
                                        {{-- <div class="summary-badges mt-2">
                                            <span class="badge bg-light-primary">
                                                <i class="bi bi-box-seam"></i> {{ $total_items }} Items
                                            </span>
                                            <span class="badge bg-light-success">
                                                <i class="bi bi-cash-stack"></i>
                                                <span data-currency="{{ $total_estimasi_harga }}"></span>
                                            </span>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div id="items-container">
                                        @foreach ($purchaseOrderDetail as $index => $item)
                                            <div class="item-row row mb-3 border p-3 rounded">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Customer Order</label>
                                                        <select class="choices form-select customer-order-select" disabled
                                                            name="items[{{ $index }}][customer_order_id]"
                                                            data-index="{{ $index }}" data-selected="{{ $item->no_po }}">
                                                            <option value="">Select Customer Order</option>
                                                            <option value="{{ $item->no_po }}" selected>
                                                                {{ $item->no_po }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Quantity</label>
                                                        <input type="text" class="form-control form-control-lg" readonly
                                                            name="items[{{ $index }}][qty]"
                                                            value="{{ old("items.$index.qty", $item->qty) }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Notes</label>
                                                        <input type="text" class="form-control form-control-lg"
                                                            name="items[{{ $index }}][estimasi_notes]" readonly
                                                            value="{{ old("items.$index.estimasi_notes", $item->estimasi_notes) }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label class="form-label">No. PO Customer</label>
                                                        <input type="text" class="form-control form-control-lg"
                                                            name="items[{{ $index }}][no_po_customer]"
                                                            value="{{ old("items.$index.no_po_customer", $item->no_po) }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Harga Barang</label>
                                                        <input type="text" class="form-control form-control-lg"
                                                            name="items[{{ $index }}][estimasi_harga]" readonly
                                                            value="{{ old("items.$index.estimasi_harga", number_format($item->estimasi_harga,0,',','.')) }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Estimasi Kg</label>
                                                        <input type="text" class="form-control form-control-lg" readonly
                                                            name="items[{{ $index }}][estimasi_kg]"
                                                            value="{{ old("items.$index.estimasi_kg", $item->estimasi_kg) }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Nama Barang</label>
                                                        <input type="text" class="form-control form-control-lg" readonly
                                                            name="items[{{ $index }}][nama_barang]"
                                                            value="{{ old("items.$index.nama_barang", $item->nama_barang) }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Asuransi 2%</label>
                                                        <input type="text" class="form-control form-control-lg"
                                                            name="items[{{ $index }}][asuransi]" readonly
                                                            value="{{ old("items.$index.asuransi", number_format($item->asuransi,0,',','.')) }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Jasa Kg</label>
                                                        <input type="text" class="form-control form-control-lg" readonly
                                                            name="items[{{ $index }}][jasa]"
                                                            value="{{ old("items.$index.jasa", number_format($item->jasa,0,',','.')) }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">

                                                    <div class="form-group">
                                                        <label class="form-label">Link Barang</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control form-control-lg link-input"
                                                                readonly
                                                                value="{{ old("items.$index.link_barang", $item->link_barang) }}"
                                                                name="items[{{ $index }}][link_barang]">
                                                            <button class="btn btn-outline-primary btn-open-link" type="button"
                                                                disabled>
                                                                <i class="bi bi-box-arrow-up-right"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Diskon</label>
                                                        <input type="text" class="form-control form-control-lg"
                                                            name="items[{{ $index }}][estimasi_diskon]" readonly
                                                            value="{{ old("items.$index.estimasi_diskon", number_format($item->estimasi_diskon,0,',','.')) }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Total Harga Estimasi</label>
                                                        <input type="text" class="form-control form-control-lg" readonly
                                                            name="items[{{ $index }}][total_estimasi]"
                                                            value="{{ old("items.$index.total_estimasi", number_format($item->total_estimasi,0,',','.')) }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Category</label>
                                                        <select class="choices form-select category-select" disabled
                                                            name="items[{{ $index }}][category_id]"
                                                            data-index="{{ $index }}" data-selected="{{ $item->category_id }}">
                                                             @if(isset($item))
                                                                @foreach($category as $categories)
                                                                <option value="{{ $categories->id }}" {{ ($categories->id == $item->category_id)? 'selected' : '' }}>{{$categories->name}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>

                                                 <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Brand</label>
                                                        <select class="choices form-select brand-select" disabled
                                                            name="items[{{ $index }}][brand_id]"
                                                            data-index="{{ $index }}" data-selected="{{ $item->brand_id }}">
                                                            @if(isset($item))
                                                                @foreach($brand as $brands)
                                                                <option value="{{ $brands->id }}" {{ ($brands->id == $item->brand_id)? 'selected' : '' }}>{{$brands->name}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="col-md-12">
                                                    <div class="accordion mb-3" id="accordionExample{{ $index }}">
                                                        <!-- Estimasi -->
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="headingEstimasi{{ $index }}">
                                                                <div
                                                                    class="d-flex justify-content-between align-items-center w-100 pe-2">
                                                                    <button class="accordion-button flex-grow-1 text-start"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#collapseEstimasi{{ $index }}"
                                                                        aria-expanded="false"
                                                                        aria-controls="collapseEstimasi{{ $index }}">
                                                                        Estimasi
                                                                    </button>
                                                                    @if (App\Models\User::checkRole('master_admin') || App\Models\User::checkRole('admin_chat_input') || App\Models\User::checkRole('accounting'))
                                                                        <button type="button"
                                                                            class="btn btn-outline-primary btn-sm edit-estimasi-btn ms-2"
                                                                            data-item-id="{{ $item->id }}"
                                                                            data-nama-rek="{{ $item->nama_rek_transfer }}"
                                                                            data-jumlah-transfer="{{ $item->jumlah_transfer }}"
                                                                            data-total-estimasi="{{ $item->total_estimasi }}"
                                                                            data-dp="{{ $item->dp }}"
                                                                            data-full-payment="{{ $item->fullpayment }}"
                                                                            data-foto-bukti="{{ $item->foto_bukti_tf }}"
                                                                            data-status-follow-up="{{ $item->status_follow_up }}"
                                                                            data-mutasi-check="{{ $item->mutasi_check }}">
                                                                            <i class="bi bi-pencil"></i> Edit
                                                                        </button>

                                                                    @else
                                                                        <button type="button"
                                                                            class="btn btn-outline-primary btn-sm edit-estimasi-btn ms-2"
                                                                            disabled style="background: #ccc">
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
                                                                                    <small class="text-muted d-block">Jumlah
                                                                                        Transfer</small>
                                                                                    <div class="fw-semibold">
                                                                                        <span
                                                                                            data-currency="{{ $item->jumlah_transfer ?? 0 }}"></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Baris Kedua -->
                                                                        <div class="row mb-3 border-bottom pb-2">
                                                                            <div class="col-md-6">
                                                                                <div class="mb-2">
                                                                                    <small class="text-muted d-block">DP</small>
                                                                                    <div class="fw-semibold">
                                                                                        <span
                                                                                            data-currency="{{ $item->dp ?? 0 }}"></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="mb-2">
                                                                                    <small class="text-muted d-block">Full
                                                                                        Payment</small>
                                                                                    <div class="fw-semibold">
                                                                                        <span
                                                                                            data-currency="{{ $item->fullpayment ?? 0 }}"></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Baris Ketiga -->
                                                                        <div class="row mb-3 border-bottom pb-2">
                                                                            <div class="col-md-6">
                                                                                <div class="mb-2">
                                                                                    <small class="text-muted d-block">Status
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
                                                                                    <small class="text-muted d-block">Mutasi
                                                                                        Check</small>
                                                                                    <span
                                                                                        class="badge {{ $item->mutasi_check ? 'bg-success' : 'bg-secondary' }}">
                                                                                        {{ $item->mutasi_check ? 'Checked' : 'Unchecked' }}
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Foto Bukti Transfer -->
                                                                        <div class="row mb-3 border-bottom pb-2">
                                                                            <div class="col-md-6">
                                                                                <div class="mb-2">
                                                                                    <small class="text-muted d-block">Kurang
                                                                                        Bayar</small>
                                                                                    <div class="fw-semibold">
                                                                                        <span
                                                                                            data-currency="{{ $item->kurang_bayar ?? 0 }}"></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
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
                                                        </div>

                                                        <!-- HPP -->
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="headingHpp{{ $index }}">
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
                                                                    @if (App\Models\User::checkRole('master_admin') || App\Models\User::checkRole('admin_purchase') || App\Models\User::checkRole('accounting'))
                                                                        <button type="button"
                                                                            class="btn btn-outline-primary btn-sm edit-hpp-btn ms-2"
                                                                            data-item-id="{{ $item->id }}"
                                                                            data-payment-method="{{ $item->payment_method }}"
                                                                            data-total-purchase="{{ $item->total_purchase }}"
                                                                            data-status-purchase="{{ $item->status_purchase }}"
                                                                            data-notes="{{ $item->notes }}"
                                                                            data-bukti-pembelian="{{ $item->foto_bukti_pembelian }}"
                                                                            data-harga-hpp="{{ $item->harga_hpp }}"
                                                                            data-diskon="{{ $item->diskon }}"
                                                                            data-pajak="{{ $item->pajak }}"
                                                                            data-pengiriman="{{ $item->pengiriman }}"
                                                                            data-hpp-mutasi-check="{{ $item->hpp_mutasi_check  }}">
                                                                            <i class="bi bi-pencil"></i> Edit
                                                                        </button>
                                                                    @else
                                                                        <button type="button"
                                                                            class="btn btn-outline-primary btn-sm edit-hpp-btn ms-2"
                                                                            disabled style="background: #ccc">
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
                                                                                    <small class="text-muted d-block">Payment
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
                                                                                    <div class="fw-semibold currency-format"
                                                                                        data-amount="{{ $item->total_purchase ?? 0 }}">
                                                                                        {{ $item->total_purchase ?? 0 }}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row mb-3 border-bottom pb-2">
                                                                            <div class="col-md-6">
                                                                                <div class="mb-2">
                                                                                    <small class="text-muted d-block">Pajak
                                                                                    </small>
                                                                                    <div class="fw-semibold currency-format"
                                                                                        data-amount="{{ $item->pajak ?? 0 }}">
                                                                                        {{ $item->pajak ?? 0 }}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="mb-2">
                                                                                    <small class="text-muted d-block">Pengiriman
                                                                                    </small>
                                                                                    <div class="fw-semibold currency-format"
                                                                                        data-amount="{{ $item->pengiriman ?? 0 }}">
                                                                                        {{ $item->pengiriman ?? 0 }}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row mb-3 border-bottom pb-2">
                                                                            <div class="col-md-6">
                                                                                <div class="mb-2">
                                                                                    <small class="text-muted d-block">Harga
                                                                                        barang
                                                                                    </small>
                                                                                    <div class="fw-semibold currency-format"
                                                                                        data-amount="{{ $item->harga_hpp ?? 0 }}">
                                                                                        {{ $item->harga_hpp ?? 0 }}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="mb-2">
                                                                                    <small class="text-muted d-block">Diskon
                                                                                    </small>
                                                                                    <div class="fw-semibold currency-format"
                                                                                        data-amount="{{ $item->diskon ?? 0 }}">
                                                                                        {{ $item->diskon ?? 0 }}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Baris Kedua -->
                                                                        <div class="row mb-3 border-bottom pb-2">
                                                                            <div class="col-md-6">
                                                                                <div class="mb-2">
                                                                                    <small class="text-muted d-block">Status
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
                                                                                    <small class="text-muted d-block">Mutasi
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
                                                                            <div class="col-md-6">
                                                                                <!-- Foto Bukti Pembelian -->
                                                                                <div class="mb-3">
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
                                                                            <div class="col-md-6">
                                                                                <div class="mb-2">
                                                                                    <small
                                                                                        class="text-muted d-block">Notes</small>
                                                                                    <div class="fw-semibold">
                                                                                        {{ $item->notes ?? '-' }}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>


                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Operasional -->
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="headingOperasional{{ $index }}">
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
                                                                    @if (App\Models\User::checkRole('master_admin') || App\Models\User::checkRole('operasional') || App\Models\User::checkRole('accounting'))
                                                                        <button type="button"
                                                                            class="btn btn-outline-primary btn-sm edit-operasional-btn ms-2"
                                                                            data-item-id="{{ $item->id }}"
                                                                            data-wh-usa-path="{{ $item->wh_usa }}"
                                                                            data-wh-usa-mutasi-check="{{ $item->status_on_check }}"
                                                                            data-wh-indonesia-path="{{ $item->wh_indo }}"
                                                                            data-fix-weight="{{ $item->fix_weight }}"
                                                                            data-fix-price="{{ $item->fix_price }}"
                                                                            data-sku="{{ $item->sku }}"
                                                                            data-no-box="{{ $item->no_box }}"
                                                                            data-kurir-lokal="{{ $item->kurir_lokal }}"
                                                                            data-pelunasan="{{ $item->pelunasan }}"
                                                                            data-status-barang-sampai="{{ $item->status_barang_sampai }}">
                                                                            <i class="bi bi-pencil"></i> Edit
                                                                        </button>
                                                                    @else
                                                                        <button type="button"
                                                                            class="btn btn-outline-primary btn-sm edit-operasional-btn ms-2"
                                                                            disabled style="background: #ccc">
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
                                                                                        @if($item->fix_price)
                                                                                            <span
                                                                                                data-currency="{{ $item->fix_price }}"></span>
                                                                                        @else
                                                                                            -
                                                                                        @endif
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

                                                                        <div class="row mb-3 border-bottom pb-2">
                                                                            <div class="col-md-6">
                                                                                <div class="mb-2">
                                                                                    <small class="text-muted d-block">Kurir
                                                                                        Lokal
                                                                                    </small>
                                                                                    <div class="fw-semibold">
                                                                                        @if($item->kurir_lokal)
                                                                                            <span
                                                                                                data-currency="{{ $item->kurir_lokal }}"></span>
                                                                                        @else
                                                                                            -
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-6">
                                                                                <div class="mb-2">
                                                                                    <small
                                                                                        class="text-muted d-block">Pelunasan</small>
                                                                                    <div class="fw-semibold">
                                                                                        @if($item->pelunasan)
                                                                                            <span
                                                                                                data-currency="{{ $item->pelunasan }}"></span>
                                                                                        @else
                                                                                            -
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>

                                                                        <div class="row mb-3 border-bottom pb-2">
                                                                            <div class="col-md-6">
                                                                                <div class="mb-2">
                                                                                    <small class="text-muted d-block">SKU
                                                                                    </small>
                                                                                    <div class="fw-semibold">
                                                                                        {{ $item->sku ? $item->sku : '-' }}
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-6">
                                                                                <div class="mb-2">
                                                                                    <small class="text-muted d-block">Nomor
                                                                                        Box</small>
                                                                                    <div class="fw-semibold">
                                                                                        {{ $item->no_box ? $item->no_box : '-' }}
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                        <!-- Baris Ketiga -->
                                                                        <div class="row mb-3 border-bottom pb-2">

                                                                            <div class="col-md-6">
                                                                                <div class="mb-2">
                                                                                    <small class="text-muted d-block">Status
                                                                                        WH USA</small>
                                                                                    <span
                                                                                        class="badge {{ $item->status_on_check ? 'bg-success' : 'bg-secondary' }}">
                                                                                        {{ $item->status_on_check ? 'Done' : 'Failed' }}
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="mb-2">
                                                                                    <small class="text-muted d-block">Status
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
                                                                                        <small class="text-muted d-block mt-1">
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
                                                                                        <small class="text-muted d-block mt-1">
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
                                <div class="form-group">
                                    <label class="form-label">Nama Rek Transfer</label>
                                    <input type="text" id="nama_rek" {{ App\Models\User::checkRole('accounting') ? 'readonly':''  }} class="form-control form-control-lg" name="nama_rek"
                                        placeholder="jasmin">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="form-label">Jumlah Transfer</label>
                                    <input type="text" id="jumlah_transfer" readonly class="form-control form-control-lg"
                                        name="jumlah_transfer" placeholder="1.000.000">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="form-label">DP</label>
                                    <input type="text" id="dp" {{ App\Models\User::checkRole('accounting') ? 'readonly':''  }} class="form-control form-control-lg" name="dp"
                                        placeholder="500.000">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="form-label">Full Payment</label>
                                    <input type="text" id="full_payment" {{ App\Models\User::checkRole('accounting') ? 'readonly':''  }} class="form-control form-control-lg"
                                        name="full_payment" placeholder="1.000.000">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="form-label">Kurang Bayar</label>
                                    <input type="text" id="kurang_bayar" readonly class="form-control form-control-lg"
                                        name="kurang_bayar" placeholder="Auto Count">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="form-label">Status Follow Up</label>
                                    <select class="form-select" id="status_follow_up" {{ App\Models\User::checkRole('accounting') ? 'disabled':''  }} name="status_follow_up">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="form-label">Foto Bukti Transfer</label>
                                    <input type="file" id="bukti_transfer" {{ App\Models\User::checkRole('accounting') ? 'disabled':''  }} class="form-control form-control-lg"
                                        name="bukti_transfer">
                                        <input type="hidden" id="txt_foto_bukti">

                                    <div id="foto-preview" class="mt-3"></div>


                                </div>
                            </div>
                            @if (App\Models\User::checkRole('master_admin') || App\Models\User::checkRole('accounting'))
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="form-label">Mutasi Check</label>
                                    <br>
                                    <input id="modal_btn_status" type="checkbox" data-onstyle="success" data-toggle="toggle"
                                        data-on="Checked" data-off="Unchecked" data-offstyle="secondary" data-width="200"
                                        data-height="45">
                                    <input type="true" id="modal_status" name="mutasi_check" hidden>
                                </div>
                            </div>
                            @endif
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
                                <div class="form-group">
                                    <label class="form-label">Payment Method</label>

                                    <select class="form-select" id="payment_method" {{ App\Models\User::checkRole('accounting') ? 'disabled':''  }} name="payment_method">
                                        <option value="">Press to select</option>

                                        {{-- @foreach($paymentMethod as $paymentMethods)
                                            <option value="{{ $paymentMethods->name . '-' . $paymentMethods->number }}">
                                                {{$paymentMethods->name . '-' . $paymentMethods->number}}
                                            </option>
                                        @endforeach --}}
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="form-label">Status Purchase</label>
                                    <select class="form-select" id="status_purchase" {{ App\Models\User::checkRole('accounting') ? 'disabled':''  }} name="status_purchase">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="form-label">Harga Barang</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="text" id="harga_barang" {{ App\Models\User::checkRole('accounting') ? 'readonly':''  }} class="form-control form-control-lg"
                                            name="harga_barang" placeholder="100">
                                    </div>
                                    <span id="show_harga_barang" class="invalid-feedback" style="display: block">
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="form-label">Pajak</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="text" id="pajak" {{ App\Models\User::checkRole('accounting') ? 'readonly':''  }} class="form-control form-control-lg" name="pajak"
                                            placeholder="10">
                                    </div>
                                    <span id="show_pajak" class="invalid-feedback" style="display: block">
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="form-label">Diskon</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="text" id="diskon" {{ App\Models\User::checkRole('accounting') ? 'readonly':''  }} class="form-control form-control-lg" name="diskon"
                                            placeholder="5">
                                    </div>
                                    <span id="show_diskon" class="invalid-feedback" style="display: block">
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="form-label">Pengiriman</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="text" id="pengiriman" {{ App\Models\User::checkRole('accounting') ? 'readonly':''  }} class="form-control form-control-lg"
                                            name="pengiriman" placeholder="15">
                                    </div>
                                    <span id="show_pengiriman" class="invalid-feedback" style="display: block">
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="form-label">Notes</label>
                                    <input type="text" id="notes" class="form-control form-control-lg" {{ App\Models\User::checkRole('accounting') ? 'readonly':''  }} name="notes"
                                        placeholder="Color, Size, Etc">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="form-label">Total Purchase</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" id="total_purchase" readonly
                                            class="form-control form-control-lg" name="total_purchase" {{ App\Models\User::checkRole('accounting') ? 'readonly':''  }} placeholder="$">
                                    </div>
                                    <span id="show_total_purchase" class="invalid-feedback" style="display: block">
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="form-label">Foto Bukti Pembelian</label>
                                    <input type="file" id="bukti_pembelian" {{ App\Models\User::checkRole('accounting') ? 'disabled':''  }} class="form-control form-control-lg"
                                        name="bukti_pembelian">
                                    {{-- <div id="bukti_pembelian_preview" class="mt-2"></div> --}}

                                        <input type="hidden" id="txt_foto_bukti_pembelian">

                                        <div id="foto-preview-bukti-pembelian" class="mt-3"></div>

                                </div>
                            </div>
                            @if (App\Models\User::checkRole('master_admin') || App\Models\User::checkRole('accounting'))
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="form-label">Mutasi Check</label>
                                    <br>
                                    <input id="hpp_btn_status" type="checkbox" data-onstyle="info" data-toggle="toggle"
                                        data-on="Checked" data-off="Unchecked" data-offstyle="secondary"
                                        data-width="200" data-height="45">
                                    <input type="hidden" id="hpp_status" name="hpp_mutasi_check" value="false">
                                </div>
                            </div>
                            @endif

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
    <div class="modal fade" id="operasionalModal" tabindex="-1" aria-labelledby="operasionalModalLabel" aria-hidden="true">
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
                                <div class="form-group">
                                    <label class="form-label">Fix Weight (kg)</label>
                                    <input type="number" step="0.01" id="fix_weight" {{ App\Models\User::checkRole('accounting') ? 'readonly':''  }} class="form-control form-control-lg"
                                        name="fix_weight" placeholder="Kg">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="form-label">Fix Price</label>
                                    <input type="text" id="fix_price" {{ App\Models\User::checkRole('accounting') ? 'readonly':''  }} class="form-control form-control-lg"
                                        name="fix_price" placeholder="1.000.000">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="form-label">Nomor Box</label>
                                    <input type="text" id="nomor_box" {{ App\Models\User::checkRole('accounting') ? 'readonly':''  }} class="form-control form-control-lg" name="nomor_box"
                                        placeholder="T2110">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="form-label">SKU</label>
                                    <input type="text" id="sku" readonly class="form-control form-control-lg" name="sku"
                                        placeholder="Nomor SKU">
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="form-label">Kurir Lokal</label>
                                    <input type="text" id="kurir_lokal" {{ App\Models\User::checkRole('accounting') ? 'readonly':''  }} class="form-control form-control-lg"
                                        name="kurir_lokal" placeholder="50.000">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="form-label">Pelunasan</label>
                                    <input type="text" id="pelunasan" {{ App\Models\User::checkRole('accounting') ? 'readonly':''  }} class="form-control form-control-lg"
                                        name="pelunasan" placeholder="500.000">
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="form-label">Status Barang Sampai</label>
                                    <select class="form-select" {{ App\Models\User::checkRole('accounting') ? 'disabled':''  }} id="status_barang_sampai" name="status_barang_sampai">

                                    </select>
                                </div>
                            </div>
                            @if (App\Models\User::checkRole('master_admin') || App\Models\User::checkRole('accounting'))
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="form-label">Status On Check</label>
                                    <br>
                                    <input id="wh_usa_btn_status" type="checkbox" data-onstyle="info" data-toggle="toggle"
                                        data-on="Done" data-off="Failed" data-offstyle="secondary" data-width="200"
                                        data-height="45">
                                    <input type="hidden" id="wh_usa_status" name="wh_usa_mutasi_check" value="false">
                                </div>
                            </div>
                            @endif
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="form-label">WH USA</label>
                                    <input type="file" id="wh_usa" {{ App\Models\User::checkRole('accounting') ? 'disabled':''  }} class="form-control form-control-lg" name="wh_usa">
                                    {{-- <div id="wh_usa_preview" class="mt-2"></div> --}}

                                     <input type="hidden" id="txt_foto_wh_usa">

                                    <div id="foto-preview-wh-usa" class="mt-3"></div>

                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="form-label">WH Indo</label>
                                    <input type="file" id="wh_indonesia" {{ App\Models\User::checkRole('accounting') ? 'disabled':''  }} class="form-control form-control-lg"
                                        name="wh_indonesia">
                                    {{-- <div id="wh_indonesia_preview" class="mt-2"></div> --}}
                                     <input type="hidden" id="txt_foto_wh_indonesia">

                                    <div id="foto-preview-wh-indonesia" class="mt-3"></div>
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
    <script src="{{ asset('js/utils/currency.js') }}"></script>
    <script>
        $(document).ready(function () {
            // Format all currency elements using formatDollar
            $('.currency-format').each(function () {
                const amount = $(this).data('amount');
                const formatted = formatDollar(amount, { showDecimals: false });
                $(this).text(formatted);
            });

            // Inisialisasi data customer order dari controller
            const estimasiModal = new bootstrap.Modal(document.getElementById('estimasiModal'));
            initLinkButtons();

            // Juga panggil saat menambah item baru

            // Toggle untuk mutasi check
            $('#modal_btn_status').change(function () {
                $('#modal_status').val($(this).prop('checked'));
            });

            $(document).on('click', '.edit-estimasi-btn', function () {
                const itemId = $(this).data('item-id');
                $('#item_id').val(itemId);
                $('#nama_rek').val($(this).data('nama-rek'));

                // Format values dengan Rupiah
                const totalEstimasi = $(this).data('total-estimasi');
                $('#jumlah_transfer').val(totalEstimasi ? formatRupiah(totalEstimasi.toString()) : '');

                const dp = $(this).data('dp');
                $('#dp').val(dp ? formatRupiah(dp.toString()) : '');

                const fullPayment = $(this).data('full-payment');
                $('#full_payment').val(fullPayment ? formatRupiah(fullPayment.toString()) : '');

                $('#status_follow_up').val($(this).data('status-follow-up'));
                $('#foto-bukti').val($(this).data('foto-bukti'));
                $('#txt_foto_bukti').val($(this).data('foto-bukti'));
                const fotoBukti = $(this).data('foto-bukti');
                const fotoBuktiField = $('#bukti_transfer');
                const fotoPreview = $('#foto-preview');

                // Reset file input
                fotoBuktiField.val('');

                if (fotoBukti) {
                    // Jika sudah ada foto bukti, tampilkan preview image yang bisa diklik
                    fotoPreview.html(`
                                                        <a href="/storage/${fotoBukti}"
                                                            target="_blank"
                                                            class="btn btn-sm btn-outline-primary mt-1">
                                                            <i class="bi bi-eye"></i> Lihat Dokumen
                                                        </a>
                                                        `);

                    // Buat field tidak required karena sudah ada foto
                    fotoBuktiField.removeAttr('required');
                } else {
                    // Jika belum ada foto
                    fotoPreview.html('');
                    fotoBuktiField.attr('required', 'required');
                }

                var statusFollowUp = $(this).data('status-follow-up');
                console.log('Nilai status follow up:', statusFollowUp);

                // Dapatkan instance Choices
                var selectElement = document.getElementById('status_follow_up');

                // Jika Choices.js terdeteksi
                if (typeof Choices !== 'undefined') {
                    // Destroy existing instance jika ada
                    if (selectElement.choices) {
                        selectElement.choices.destroy();
                    }

                    // Buat instance Choices baru dengan opsi yang benar
                    var choicesInstance = new Choices(selectElement, {
                        choices: [
                            { value: '', label: 'Press to select', selected: true, disabled: true },
                            { value: 'Scheduled', label: 'Scheduled' },
                            { value: 'Followed', label: 'Followed' },
                            { value: 'Unfollowed', label: 'Unfollowed' }
                        ],
                        searchEnabled: false,
                        shouldSort: false,
                        itemSelectText: ''
                    });

                    // Set nilai yang dipilih
                    choicesInstance.setChoiceByValue(statusFollowUp);
                } else {
                    // Fallback traditional method
                    $('#status_follow_up').html('\
                                                            <option value="">Press to select</option>\
                                                            <option value="Scheduled"' + (statusFollowUp === 'Scheduled' ? ' selected' : '') + '>Scheduled</option>\
                                                            <option value="Followed"' + (statusFollowUp === 'Followed' ? ' selected' : '') + '>Followed</option>\
                                                            <option value="Unfollowed"' + (statusFollowUp === 'Unfollowed' ? ' selected' : '') + '>Unfollowed</option>\
                                                        ');
                    $('#status_follow_up').trigger('change');
                }

                // Set toggle dengan cara yang benar
                const isChecked = $(this).data('mutasi-check');

                // Atur nilai checkbox berdasarkan isChecked
                // $('#modal_btn_status').prop('checked', true);
                if (isChecked) {
                    $('#modal_btn_status').bootstrapToggle('on');
                } else {
                    $('#modal_btn_status').bootstrapToggle('off');
                }
                $('#modal_status').val(isChecked);

                // Pastikan event handler untuk toggle berfungsi
                $('#modal_btn_status').off('change').on('change', function () {
                    const isChecked = $(this).is(':checked');
                    $('#modal_status').val(isChecked ? 1 : 0);
                    console.log('Toggle status:', isChecked ? 'Checked' : 'Unchecked');
                });


                // Add event listeners
                $('#jumlah_transfer, #dp, #full_payment').on('input', calculateKurangBayar);

                // Calculate initial value
                calculateKurangBayar();
                // Tampilkan modal
                estimasiModal.show();
            });

            $('#saveEstimasi').click(function () {
                // Validasi form
                const fotoBukti = $('#txt_foto_bukti').val();
                let requiredFields = [{
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
                    id: '#kurang_bayar',
                    name: 'Kurang Bayar'
                },
                ];

                if (!fotoBukti) {
                    requiredFields.push({ id: '#bukti_transfer', name: 'Bukti Transfer' });
                }
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
                            success: function (response) {
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
                            error: function (xhr) {
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
            $('#estimasiModal').on('hidden.bs.modal', function () {
                $('#estimasiForm')[0].reset();
                $('.is-invalid').removeClass('is-invalid');
                $('#modal_btn_status').bootstrapToggle('off');
                $('#modal_status').val('false');
            });

            // Handler untuk input file (preview)
            $('#bukti_transfer').change(function () {
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
            $('#hpp_btn_status').change(function () {
                $('#hpp_status').val($(this).prop('checked'));
            });

            $('#harga_barang, #pajak, #diskon, #pengiriman').on('input', hitungTotalPurchase);

            // Fungsi untuk mereset form
            $('#resetBtn').click(function () {
                $('#harga_barang, #pajak, #diskon, #pengiriman').val(0);
                hitungTotalPurchase();
            });

            // Auto-calculate saat input HPP berubah
            $('#harga_barang, #pajak, #diskon, #pengiriman').on('input', hitungTotalPurchase);
            $(document).on('click', '.edit-hpp-btn', function () {
                const itemId = $(this).data('item-id');


                // Isi form modal dengan data dari tombol
                $('#hpp_item_id').val(itemId);
                $('#payment_method').val($(this).data('payment-method'));

                // Format values dengan Rupiah
                const totalPurchase = $(this).data('total-purchase');
                $('#total_purchase').val(totalPurchase ? formatRupiah(totalPurchase.toString()) : '');

                $('#status_purchase').val($(this).data('status-purchase'));
                $('#notes').val($(this).data('notes'));

                const pajak = $(this).data('pajak');
                $('#pajak').val(pajak ? formatRupiah(pajak.toString()) : '');

                const diskon = $(this).data('diskon');
                $('#diskon').val(diskon ? formatRupiah(diskon.toString()) : '');

                const pengiriman = $(this).data('pengiriman');
                $('#pengiriman').val(pengiriman ? formatRupiah(pengiriman.toString()) : '');

                const hargaHpp = $(this).data('harga-hpp');
                $('#harga_barang').val(hargaHpp ? formatRupiah(hargaHpp.toString()) : '');

                $("#txt_foto_bukti_pembelian").val($(this).data('bukti-pembelian'));
                hitungTotalPurchase();
                // Tampilkan preview bukti pembelian jika ada
                const buktiPembelianPath = $(this).data('bukti-pembelian');
                const previewDiv = $('#foto-preview-bukti-pembelian');
                const fotoBuktiField = $('#bukti_pembelian');

               console.log("AAA",buktiPembelianPath);

                // Reset file input
                fotoBuktiField.val('');

                if (buktiPembelianPath) {
                    // Jika sudah ada foto bukti, tampilkan preview image yang bisa diklik
                    previewDiv.html(`
                                                        <a href="/storage/${buktiPembelianPath}"
                                                            target="_blank"
                                                            class="btn btn-sm btn-outline-primary mt-1">
                                                            <i class="bi bi-eye"></i> Lihat Dokumen
                                                        </a>
                                                        `);

                    // Buat field tidak required karena sudah ada foto
                    fotoBuktiField.removeAttr('required');
                } else {
                    // Jika belum ada foto
                    previewDiv.html('');
                    fotoBuktiField.attr('required', 'required');
                }

                // Set toggle



                const isChecked = $(this).data('hpp-mutasi-check');

                // Atur nilai checkbox berdasarkan isChecked
                // $('#modal_btn_status').prop('checked', true);
                if (isChecked) {
                    $('#hpp_btn_status').bootstrapToggle('on');
                } else {
                    $('#hpp_btn_status').bootstrapToggle('off');
                }
                $('#hpp_status').val(isChecked);

                // Pastikan event handler untuk toggle berfungsi
                $('#hpp_btn_status').off('change').on('change', function () {
                    const isChecked = $(this).is(':checked');
                    $('#hpp_status').val(isChecked ? 1 : 0);
                    console.log('Toggle status:', isChecked ? 'Checked' : 'Unchecked');
                });
                // Inisialisasi Choices untuk select

                var statusFollowUp = $(this).data('status-purchase');
                console.log('Nilai status follow up:', statusFollowUp);

                // Dapatkan instance Choices
                var selectElement = document.getElementById('status_purchase');

                // Jika Choices.js terdeteksi
                if (typeof Choices !== 'undefined') {
                    // Destroy existing instance jika ada
                    if (selectElement.choices) {
                        selectElement.choices.destroy();
                    }


                    // Buat instance Choices baru dengan opsi yang benar
                    var choicesInstance = new Choices(selectElement, {
                        choices: [
                            { value: '', label: 'Press to select', selected: true, disabled: true },
                            { value: 'Wait For Order', label: 'Wait For Order' },
                            { value: 'Ordered', label: 'Ordered' },
                            { value: 'Failed Order', label: 'Failed Order' }
                        ],
                        searchEnabled: false,
                        shouldSort: false,
                        itemSelectText: ''
                    });

                    // Set nilai yang dipilih
                    choicesInstance.setChoiceByValue(statusFollowUp);
                } else {
                    // Fallback traditional method
                    $('#status_purchase').html('\
                                                            <option value="">Press to select</option>\
                                                            <option value="Wait For Order"' + (statusFollowUp === 'Wait For Order' ? ' selected' : '') + '>Wait For Order</option>\
                                                            <option value="Ordered"' + (statusFollowUp === 'Ordered' ? ' selected' : '') + '>Ordered</option>\
                                                            <option value="Failed Order"' + (statusFollowUp === 'Failed Order' ? ' selected' : '') + '>Failed Order</option>\
                                                        ');
                    $('#status_purchase').trigger('change');
                }

                 var paymentMethodValue = $(this).data('payment-method');
    console.log('Nilai payment method:', paymentMethodValue);

    // Dapatkan instance Choices untuk payment method
    var paymentMethodElement = document.getElementById('payment_method');

     if (typeof Choices !== 'undefined') {
        // Destroy existing instance jika ada
        if (paymentMethodElement.choices) {
            paymentMethodElement.choices.destroy();
        }

        // Pastikan opsi payment method sudah ada
        if ($('#payment_method option').length <= 1) {
            // Isi opsi payment method dari data PHP
            @foreach($paymentMethod as $paymentMethods)
                $('#payment_method').append('<option value="{{ $paymentMethods->name . '-' . $paymentMethods->number }}">{{ $paymentMethods->name . '-' . $paymentMethods->number }}</option>');
            @endforeach
        }

        // Buat instance Choices baru
        var paymentMethodChoices = new Choices(paymentMethodElement, {
            searchEnabled: true,
            shouldSort: false,
            itemSelectText: ''
        });

        // Set nilai yang dipilih setelah timeout kecil
        setTimeout(function() {
            if (paymentMethodValue) {
                paymentMethodChoices.setChoiceByValue(paymentMethodValue);
            } else {
                // Auto select index 0 jika belum ada data payment method
                // Pilih opsi pertama setelah opsi default
                if ($('#payment_method option').length > 1) {
                    paymentMethodChoices.setChoiceByValue($('#payment_method option:eq(1)').val());
                }
            }
        }, 100);
    } else {
        // Fallback traditional method
        // Pastikan opsi payment method sudah ada
        if ($('#payment_method option').length <= 1) {
            // Isi opsi payment method dari data PHP
            @foreach($paymentMethod as $paymentMethods)
                $('#payment_method').append('<option value="{{ $paymentMethods->name . '-' . $paymentMethods->number }}">{{ $paymentMethods->name . '-' . $paymentMethods->number }}</option>');
            @endforeach
        }

        // Set nilai yang dipilih atau auto select index 0
        if (paymentMethodValue) {
            $('#payment_method').val(paymentMethodValue);
        } else {
            // Auto select index 0 jika belum ada data payment method
            // Pilih opsi pertama setelah opsi default
            if ($('#payment_method option').length > 1) {
                $('#payment_method').val($('#payment_method option:eq(1)').val());
            }
        }
        $('#payment_method').trigger('change');
    }
                // Tampilkan modal
                hppModal.show();
            });

            $('#bukti_pembelian').change(function () {
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
                    reader.onload = function (e) {
                        preview.html(
                            `<img src="${e.target.result}" class="img-thumbnail" style="max-height: 150px;">`
                        );
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Handler untuk tombol save
            $('#saveHpp').click(function () {
                // Validasi form
                const fotoBukti = $("#txt_foto_bukti_pembelian").val();
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
                    id: '#pajak',
                    name: 'Pajak'
                },
                {
                    id: '#harga_barang',
                    name: 'Harga Barang'
                },
                {
                    id: '#diskon',
                    name: 'Diskon'
                },
                {
                    id: '#pengiriman',
                    name: 'Pengiriman'
                }
                ];

                 if (!fotoBukti) {
                    requiredFields.push({ id: '#bukti_pembelian', name: 'Foto Bukti Pembelian' });
                }
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
                            success: function (response) {
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
                            error: function (xhr) {
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
            $('#wh_usa_btn_status').change(function () {
                $('#wh_usa_status').val($(this).prop('checked'));
            });

            $('#wh_usa').change(function () {
                previewImage(this, '#wh_usa_preview');
            });

            // Preview gambar WH Indonesia
            $('#wh_indonesia').change(function () {
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
                    reader.onload = function (e) {
                        preview.html(
                            `<img src="${e.target.result}" class="img-thumbnail" style="max-height: 150px;">`
                        );
                    }
                    reader.readAsDataURL(file);
                }
            }
            // Handle klik tombol edit operasional
            $(document).on('click', '.edit-operasional-btn', function () {
                // Ambil data dari tombol
                const itemId = $(this).data('item-id');
                const statusBarang = $(this).data('status-barang-sampai');

                // Isi form modal
                $('#operasional_item_id').val(itemId);

                // Fix Weight tidak perlu format Rupiah (dalam kg)
                const fixWeight = $(this).data('fix-weight');
                $('#fix_weight').val(fixWeight || 0);

                // Format values dengan Rupiah
                const fixPrice = $(this).data('fix-price');
                $('#fix_price').val(fixPrice ? formatRupiah(fixPrice.toString()) : '');

                $('#status_barang_sampai').val(statusBarang);

                $('#nomor_box').val($(this).data('no-box'));
                $('#sku').val($(this).data('sku'));

                const kurirLokal = $(this).data('kurir-lokal');
                $('#kurir_lokal').val(kurirLokal ? formatRupiah(kurirLokal.toString()) : '');

                const pelunasan = $(this).data('pelunasan');
                $('#pelunasan').val(pelunasan ? formatRupiah(pelunasan.toString()) : '');


                var statusFollowUp = $(this).data('status-barang-sampai');
                console.log('Nilai status follow up:', statusFollowUp);

                // Dapatkan instance Choices
                var selectElement = document.getElementById('status_barang_sampai');

                // Jika Choices.js terdeteksi
                if (typeof Choices !== 'undefined') {
                    // Destroy existing instance jika ada
                    if (selectElement.choices) {
                        selectElement.choices.destroy();
                    }

                    // Buat instance Choices baru dengan opsi yang benar
                    var choicesInstance = new Choices(selectElement, {
                        choices: [
                            { value: '', label: 'Press to select', selected: true, disabled: true },
                            { value: 'Waiting Courier', label: 'Waiting Courier' },
                            { value: 'Received', label: 'Received' },
                            { value: 'Cancel', label: 'Cancel' }
                        ],
                        searchEnabled: false,
                        shouldSort: false,
                        itemSelectText: ''
                    });

                    // Set nilai yang dipilih
                    choicesInstance.setChoiceByValue(statusFollowUp);
                } else {
                    // Fallback traditional method
                    $('#status_barang_sampai').html('\
                                                            <option value="">Press to select</option>\
                                                            <option value="Waiting Courier"' + (statusFollowUp === 'Waiting Courier' ? ' selected' : '') + '>Waiting Courier</option>\
                                                            <option value="Received"' + (statusFollowUp === 'Received' ? ' selected' : '') + '>Received</option>\
                                                            <option value="Cancel"' + (statusFollowUp === 'Cancel' ? ' selected' : '') + '>Cancel</option>\
                                                        ');
                    $('#status_barang_sampai').trigger('change');
                }

                const isChecked = $(this).data('wh-usa-mutasi-check');

                // Atur nilai checkbox berdasarkan isChecked
                // $('#modal_btn_status').prop('checked', true);
                if (isChecked) {
                    $('#wh_usa_btn_status').bootstrapToggle('on');
                } else {
                    $('#wh_usa_btn_status').bootstrapToggle('off');
                }
                $('#wh_usa_status').val(isChecked);

                // Pastikan event handler untuk toggle berfungsi
                $('#wh_usa_btn_status').off('change').on('change', function () {
                    const isChecked = $(this).is(':checked');
                    $('#wh_usa_status').val(isChecked ? 1 : 0);
                    console.log('Toggle status:', isChecked ? 'Checked' : 'Unchecked');
                });


                // Preview gambar jika ada
                const whUsaImg = $(this).data('wh-usa-path');
                const whIndoImg = $(this).data('wh-indonesia-path');
                $("#txt_foto_wh_usa").val(whUsaImg);
                $("#txt_foto_wh_indonesia").val(whIndoImg);
                const fotoBuktiFieldUsa = $('#wh_usa');
                const fotoPreviewUsa = $('#foto-preview-wh-usa');

                const fotoBuktiFieldIndo = $('#wh_indonesia');
                const fotoPreviewIndo = $('#foto-preview-wh-indonesia');

                // Reset file input
                fotoBuktiFieldUsa.val('');
                fotoBuktiFieldIndo.val('');

                if (whUsaImg) {
                    // Jika sudah ada foto bukti, tampilkan preview image yang bisa diklik
                    fotoPreviewUsa.html(`
                                                        <a href="/storage/${whUsaImg}"
                                                            target="_blank"
                                                            class="btn btn-sm btn-outline-primary mt-1">
                                                            <i class="bi bi-eye"></i> Lihat Dokumen
                                                        </a>
                                                        `);

                    // Buat field tidak required karena sudah ada foto
                    fotoBuktiFieldUsa.removeAttr('required');
                } else {
                    // Jika belum ada foto
                    fotoPreviewUsa.html('');
                    fotoBuktiFieldUsa.attr('required', 'required');
                }

                if (whIndoImg) {
                    // Jika sudah ada foto bukti, tampilkan preview image yang bisa diklik
                    fotoPreviewIndo.html(`
                                                        <a href="/storage/${whIndoImg}"
                                                            target="_blank"
                                                            class="btn btn-sm btn-outline-primary mt-1">
                                                            <i class="bi bi-eye"></i> Lihat Dokumen
                                                        </a>
                                                        `);

                    // Buat field tidak required karena sudah ada foto
                    fotoBuktiFieldIndo.removeAttr('required');
                } else {
                    // Jika belum ada foto
                    fotoPreviewIndo.html('');
                    fotoBuktiFieldIndo.attr('required', 'required');
                }

                // Tampilkan modal
                $('#operasionalModal').modal('show');
            });

            // Handle simpan operasional
            $('#saveOperasional').click(function () {
                // Validasi form
                const ftoUsa = $("#txt_foto_wh_usa").val();
                const ftoIndo = $("#txt_foto_wh_indonesia").val();
                const requiredFields = [
                {
                    id: '#fix_weight',
                    name: 'Fix Weight'
                },
                {
                    id: '#kurir_lokal',
                    name: 'Kurir Lokal'
                },
                {
                    id: '#pelunasan',
                    name: 'Pelunasan'
                },
                {
                    id: '#sku',
                    name: 'SKU'
                },
                {
                    id: '#nomor_box',
                    name: 'Nomor Box'
                },
                {
                    id: '#fix_price',
                    name: 'Fix Price'
                }
                ];

                if (!ftoUsa) {
                    requiredFields.push({ id: '#wh_usa', name: 'WH USA' });
                }

                if (!wh_indonesia) {
                    requiredFields.push({ id: '#wh_indonesia', name: 'WH Indonesia' });
                }

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
                            success: function (response) {
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
                            error: function (xhr) {
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

            $('#operasionalModal').on('hidden.bs.modal', function () {
                $('#operasionalForm')[0].reset();
                $('#wh_usa_preview, #wh_indonesia_preview').empty();
                $('.is-invalid').removeClass('is-invalid');
                $('#wh_usa_btn_status').bootstrapToggle('off');
                $('#wh_usa_status').val('false');
            });

            $('#hppModal').on('hidden.bs.modal', function () {
                $('#hppForm')[0].reset();
                $('#bukti_pembelian_preview').empty();
                $('.is-invalid').removeClass('is-invalid');
                $('#hpp_btn_status').bootstrapToggle('off');
                $('#hpp_status').val('false');
            });

            $('#estimasiModal').on('hidden.bs.modal', function () {
                $('#estimasiForm')[0].reset();
                $('.is-invalid').removeClass('is-invalid');
                $('#modal_btn_status').bootstrapToggle('off');
                $('#modal_status').val('false');
            });

        });

        function initLinkButtons() {
            // Handler untuk input link
            $(document).on('input', '.link-input', function () {
                const btn = $(this).next('.btn-open-link');
                btn.prop('disabled', !$(this).val().trim());
            });

            // Handler untuk klik tombol buka link
            $(document).on('click', '.btn-open-link', function () {
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
            $('.link-input').each(function () {
                $(this).next('.btn-open-link').prop('disabled', !$(this).val().trim());
            });
        }

        // Format number to Rupiah format (1000000 -> "1.000.000")
        function formatRupiah(angka) {
            if (!angka) return '';

            // Hapus semua karakter non-digit
            const numberString = angka.toString().replace(/[^,\d]/g, '');
            const split = numberString.split(',');
            const sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            const ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                const separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            return split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
        }

        // Parse Rupiah format back to number ("1.000.000" -> 1000000)
        function parseRupiah(rupiah) {
            if (!rupiah) return 0;
            return parseInt(rupiah.toString().replace(/\./g, '')) || 0;
        }

        // Apply Rupiah formatting to input element
        function applyRupiahFormat(element) {
            const value = $(element).val();
            if (value) {
                const formatted = formatRupiah(value);
                $(element).val(formatted);
            }
        }

        // Initialize Rupiah formatting for all currency fields
        function initRupiahFormatting() {
            // Daftar semua field yang perlu formatting
            const currencyFields = [
                'input[name="estimasi_harga"]',
                'input[name="jasa"]',
                'input[name="kurir_lokal"]',
                'input[name="pajak"]',
                'input[name="diskon"]',
                'input[name="pengiriman"]',
                'input[name="fix_price"]',
                'input[name="total_purchase"]',
                'input[name="harga_hpp"]',
                'input#jumlah_transfer',
                'input#dp',
                'input#full_payment',
                'input#pelunasan',
                'input#kurang_bayar'
            ].join(', ');

            // Auto-format saat mengetik
            $(document).on('keyup', currencyFields, function(e) {
                // Save cursor position
                const element = this;
                const cursorPosition = element.selectionStart;
                const oldLength = element.value.length;

                // Format value
                const value = $(element).val();
                const formatted = formatRupiah(value);
                $(element).val(formatted);

                // Restore cursor position (adjust for new length)
                const newLength = formatted.length;
                const lengthDiff = newLength - oldLength;
                const newPosition = cursorPosition + lengthDiff;

                // Set cursor position
                if (element.setSelectionRange) {
                    element.setSelectionRange(newPosition, newPosition);
                }
            });

            // Format existing values on page load
            $(currencyFields).each(function() {
                if ($(this).val() && !$(this).prop('readonly') && !$(this).prop('disabled')) {
                    applyRupiahFormat(this);
                }
            });
        }

        function calculateKurangBayar() {
            const jumlahTransfer = parseRupiah($('#jumlah_transfer').val());
            const dp = parseRupiah($('#dp').val());
            const fullPayment = parseRupiah($('#full_payment').val());

            let kurangBayar = 0;
            let fullPay = 0;
            let dpPay = 0;

            // Kondisi 1: Jika ada DP dan full payment masih 0/kosong
            if (dp > 0 && fullPayment === 0) {
                kurangBayar = jumlahTransfer - dp;
                fullPay = 0;
                $('#full_payment').val(fullPay);
            }
            // Kondisi 2: Jika full payment terisi
            else if (fullPayment > 0) {
                kurangBayar = fullPayment - jumlahTransfer;
                dpPay = 0;
                $('#dp').val(dpPay);
            }

            // Format kurang bayar dengan Rupiah
            $('#kurang_bayar').val(formatRupiah(Math.round(kurangBayar).toString()));


            // Update styling
            $('#kurang_bayar').removeClass('is-valid is-invalid is-warning');

            if (kurangBayar > 0) {
                $('#kurang_bayar').addClass('is-invalid');
            } else if (kurangBayar < 0) {
                $('#kurang_bayar').addClass('is-warning');
            } else {
                if ($('#dp').val() || $('#full_payment').val()) {
                    $('#kurang_bayar').addClass('is-valid');
                } else {
                    $('#kurang_bayar').addClass('is-invalid');
                }
            }
        }

        function hitungTotalPurchase() {
            // Ambil nilai dari input dengan parseRupiah
            const hargaBarang = parseRupiah($('#harga_barang').val());
            const pajak = parseRupiah($('#pajak').val());
            const diskon = parseRupiah($('#diskon').val());
            const pengiriman = parseRupiah($('#pengiriman').val());
            const exchange = parseFloat($('#exchange').val()) || 0;

            // Format individual currency fields in IDR
            const formatCurrency = (amount) => {
                const idrAmount = amount * exchange;
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(idrAmount);
            };

            // Update individual currency displays
            $('#show_harga_barang').html(formatCurrency(hargaBarang));
            $('#show_pajak').html(formatCurrency(pajak));
            $('#show_diskon').html(formatCurrency(diskon));
            $('#show_pengiriman').html(formatCurrency(pengiriman));

            // Hitung total
            const total = hargaBarang + pajak + pengiriman - diskon;

            // Tampilkan hasil dengan format Rupiah (pastikan tidak negatif)
            const totalValue = total >= 0 ? total : 0;
            $('#total_purchase').val(formatRupiah(Math.round(totalValue).toString()));
            const showTotal = parseFloat(total * exchange);
            const formattedTotal = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(showTotal);
            $('#show_total_purchase').html(formattedTotal)
        }

        // Function to format all currency elements on page load
        function formatAllCurrencyElements() {
            // Format elements with data-currency attribute
            $('[data-currency]').each(function () {
                const $element = $(this);
                const value = $element.data('currency');
                const formatted = CurrencyUtils.formatRupiah(value);
                $element.text(formatted);
            });
        }

        // Format currency elements when page loads
        formatAllCurrencyElements();

        // Initialize Rupiah formatting
        initRupiahFormatting();

    </script>
@endsection
