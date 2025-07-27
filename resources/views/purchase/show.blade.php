@extends('layouts.app')
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
                                <label class="form-label">Name Rek Transfer</label>
                                <input type="text" id="nama_rek" class="form-control form-control-lg" name="nama_rek">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label class="form-label">Jumlah Transfer</label>
                                <input type="text" id="jumlah_transfer" class="form-control form-control-lg" name="jumlah_transfer">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label class="form-label">DP</label>
                                <input type="text" id="dp" class="form-control form-control-lg" name="dp">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label class="form-label">Full Payment</label>
                                <input type="text" id="full_payment" class="form-control form-control-lg" name="full_payment">
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
                                <input type="file" id="bukti_transfer" class="form-control form-control-lg" name="bukti_transfer">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label class="form-label">Mutasi Check</label>
                                <br>
                                <input id="modal_btn_status" type="checkbox" data-onstyle="info"
                                    data-toggle="toggle" data-on="Available" data-off="Not Available"
                                    data-offstyle="secondary" data-width="200" data-height="45">
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
                                <input type="text" id="payment_method" class="form-control form-control-lg" name="payment_method">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label class="form-label">Total Purchase</label>
                                <input type="number" id="total_purchase" class="form-control form-control-lg" name="total_purchase">
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
                                <input type="text" id="notes" class="form-control form-control-lg" name="notes">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label class="form-label">Foto Bukti Pembelian</label>
                                <input type="file" id="bukti_pembelian" class="form-control form-control-lg" name="bukti_pembelian">
                                <div id="bukti_pembelian_preview" class="mt-2"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label class="form-label">Mutasi Check</label>
                                <br>
                                <input id="hpp_btn_status" type="checkbox" data-onstyle="info"
                                    data-toggle="toggle" data-on="Available" data-off="Not Available"
                                    data-offstyle="secondary" data-width="200" data-height="45">
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
                            <div class="form-group mandatory">
                                <label class="form-label">WH USA</label>
                                <input type="file" id="wh_usa" class="form-control form-control-lg" name="wh_usa">
                                <div id="wh_usa_preview" class="mt-2"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label class="form-label">Status On Check</label>
                                <br>
                                <input id="wh_usa_btn_status" type="checkbox" data-onstyle="info"
                                    data-toggle="toggle" data-on="Done" data-off="Failed"
                                    data-offstyle="secondary" data-width="200" data-height="45">
                                <input type="hidden" id="wh_usa_status" name="wh_usa_mutasi_check" value="false">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label class="form-label">WH Indo</label>
                                <input type="file" id="wh_indonesia" class="form-control form-control-lg" name="wh_indonesia">
                                <div id="wh_indonesia_preview" class="mt-2"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label class="form-label">Fix Weight (kg)</label>
                                <input type="number" step="0.01" id="fix_weight" class="form-control form-control-lg" name="fix_weight">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label class="form-label">Fix Price</label>
                                <input type="number" id="fix_price" class="form-control form-control-lg" name="fix_price">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="form-label">Status Barang Sampai</label>
                                <select class="choices form-select" id="status_barang_sampai" name="status_barang_sampai">
                                    <option value="">Press to select</option>
                                    <option value="Waiting Courier">Waiting Courier</option>
                                    <option value="Received">Received</option>
                                    <option value="Cancel">Cancel</option>
                                </select>
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
        <form class="form" method="POST" action="{{ route('purchase.update', $purchase->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Customer Information Section -->
            <div class="row">
                <div class="col-md-12 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <h5 class="card-title">Customer Information</h5>

        
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="customer" class="form-label">Customer</label>
                                            <select class="choices form-select" id="customer" name="no_telp">
                                                <option value="">Select customer</option>
                                                @foreach($customers as $customer)
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
                                                value="{{ old('nama', $purchase->nama) }}" name="nama">
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="text" id="email" class="form-control form-control-lg" 
                                                value="{{ old('email', $purchase->email) }}" name="email">
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="address" class="form-label">Address</label>
                                            <input type="text" id="address" class="form-control form-control-lg" 
                                                value="{{ old('alamat', $purchase->alamat) }}" name="alamat">
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
                        <i class="bi bi-cash-stack"></i> {{ number_format($total_estimasi_harga, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div id="items-container">
                                    @foreach($purchaseOrderDetail as $index => $item)
                                    <div class="item-row row mb-3 border p-3 rounded">
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label class="form-label">Customer Order</label>
                                                <select class="form-select customer-order-select" 
                                                    name="items[{{ $index }}][customer_order_id]" 
                                                    data-index="{{ $index }}"
                                                    data-selected="{{ $item->no_po }}">
                                                    <option value="">Select Customer Order</option>
                                                    <option value="{{ $item->no_po }}" selected>{{ $item->no_po }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="form-label">No. PO Customer</label>
                                                <input type="text" class="form-control" 
                                                    name="items[{{ $index }}][no_po_customer]" 
                                                    value="{{ old("items.$index.no_po_customer", $item->no_po) }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="form-label">Nama Barang</label>
                                                <input type="text" class="form-control" 
                                                    name="items[{{ $index }}][nama_barang]" 
                                                    value="{{ old("items.$index.nama_barang", $item->nama_barang) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="form-label">Link Barang</label>
                                                <input type="text" class="form-control" 
                                                    name="items[{{ $index }}][link_barang]" 
                                                    value="{{ old("items.$index.link_barang", $item->link_barang) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label class="form-label">Estimasi Kg</label>
                                                <input type="text" class="form-control" 
                                                    name="items[{{ $index }}][estimasi_kg]" 
                                                    value="{{ old("items.$index.estimasi_kg", $item->estimasi_kg) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label class="form-label">Estimasi Harga</label>
                                                <input type="text" class="form-control" 
                                                    name="items[{{ $index }}][estimasi_harga]" 
                                                    value="{{ old("items.$index.estimasi_harga", $item->estimasi_harga) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12 text-end">
                                            <button type="button" class="btn btn-info btn-sm edit-estimasi-btn me-2" 
                                                data-item-id="{{ $item->id }}"
                                                data-nama-rek="{{ $item->nama_rek_transfer }}"
                                                data-jumlah-transfer="{{ $item->jumlah_transfer }}"
                                                data-dp="{{ $item->dp }}"
                                                data-full-payment="{{ $item->fullpayment }}"
                                                data-foto-bukti="{{ $item->foto_bukti_tf }}"
                                                data-status-follow-up="{{ $item->status_follow_up }}"
                                                data-mutasi-check="{{ $item->mutasi_check ? 'true' : 'false' }}">
                                                <i class="bi bi-pencil"></i> Edit Estimasi
                                            </button>

                                            <button type="button" class="btn btn-warning btn-sm edit-hpp-btn me-2" 
                                            data-item-id="{{ $item->id }}"
                                            data-payment-method="{{ $item->payment_method }}"
                                            data-total-purchase="{{ $item->total_purchase }}"
                                            data-status-purchase="{{ $item->status_purchase }}"
                                            data-notes="{{ $item->notes }}"
                                            data-bukti-pembelian="{{ $item->bukti_pembelian_path }}"
                                            data-hpp-mutasi-check="{{ $item->hpp_mutasi_check ? 'true' : 'false' }}">
                                            <i class="bi bi-calculator"></i> Edit HPP
                                            </button>

                                               <button type="button" class="btn btn-success btn-sm edit-operasional-btn me-2" 
                                                    data-item-id="{{ $item->id }}"
                                                    data-wh-usa-path="{{ $item->wh_usa_path }}"
                                                    data-wh-usa-mutasi-check="{{ $item->wh_usa_mutasi_check ? 'true' : 'false' }}"
                                                    data-wh-indonesia-path="{{ $item->wh_indonesia_path }}"
                                                    data-fix-weight="{{ $item->fix_weight }}"
                                                    data-fix-price="{{ $item->fix_price }}"
                                                    data-status-barang-sampai="{{ $item->status_barang_sampai }}">
                                                <i class="bi bi-truck"></i> Edit Operasional
                                            </button>
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
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Inisialisasi data customer order dari controller
       const estimasiModal = new bootstrap.Modal(document.getElementById('estimasiModal'));
    
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
        const formData = new FormData($('#estimasiForm')[0]);
        const itemId = $('#item_id').val();
        
        $.ajax({
            url: `/purchase-order-detail/${itemId}/update-estimasi`,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                alert('Estimasi berhasil diperbarui');
                estimasiModal.hide();
                
                // Update tombol dengan data terbaru
                $(`.edit-estimasi-btn[data-item-id="${itemId}"]`)
                    .data('nama-rek', response.nama_rek)
                    .data('jumlah-transfer', response.jumlah_transfer)
                    .data('dp', response.dp)
                    .data('full-payment', response.full_payment)
                    .data('status-follow-up', response.status_follow_up)
                    .data('mutasi-check', response.mutasi_check);
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
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

    $('#saveHpp').click(function() {
    const formData = new FormData($('#hppForm')[0]);
    const itemId = $('#hpp_item_id').val();
    
    $.ajax({
        url: `/purchase-order-detail/${itemId}/update-hpp`,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            alert('HPP berhasil diperbarui');
            hppModal.hide();
            
            // Update tombol dengan data terbaru
            $(`.edit-hpp-btn[data-item-id="${itemId}"]`)
                .data('payment-method', response.payment_method)
                .data('total-purchase', response.total_purchase)
                .data('status-purchase', response.status_purchase)
                .data('notes', response.notes)
                .data('bukti-pembelian', response.bukti_pembelian_path)
                .data('hpp-mutasi-check', response.hpp_mutasi_check);
        },
        error: function(xhr) {
            toastr.error('Gagal memperbarui HPP');
            console.error(xhr.responseText);
        }
    });
});

const operasionalModal = new bootstrap.Modal(document.getElementById('operasionalModal'));

// Toggle untuk mutasi check WH USA
$('#wh_usa_btn_status').change(function() {
    $('#wh_usa_status').val($(this).prop('checked'));
});

// Handle klik tombol edit operasional
$(document).on('click', '.edit-operasional-btn', function() {
    const itemId = $(this).data('item-id');
    
    // Isi form modal dengan data dari tombol
    $('#operasional_item_id').val(itemId);
    $('#fix_weight').val($(this).data('fix-weight'));
    $('#fix_price').val($(this).data('fix-price'));
    $('#status_barang_sampai').val($(this).data('status-barang-sampai'));
    
    // Tampilkan preview WH USA jika ada
    const whUsaPath = $(this).data('wh-usa-path');
    const whUsaPreview = $('#wh_usa_preview');
    whUsaPreview.empty();
    
    if (whUsaPath) {
        whUsaPreview.append(`
            <img src="/storage/${whUsaPath}" class="img-thumbnail" style="max-height: 100px;">
            <p class="small text-muted mt-1">Current file</p>
        `);
    }
    
    // Tampilkan preview WH Indo jika ada
    const whIndonesiaPath = $(this).data('wh-indonesia-path');
    const whIndonesiaPreview = $('#wh_indonesia_preview');
    whIndonesiaPreview.empty();
    
    if (whIndonesiaPath) {
        whIndonesiaPreview.append(`
            <img src="/storage/${whIndonesiaPath}" class="img-thumbnail" style="max-height: 100px;">
            <p class="small text-muted mt-1">Current file</p>
        `);
    }
    
    // Set toggle WH USA
    const isChecked = $(this).data('wh-usa-mutasi-check') === 'true';
    $('#wh_usa_btn_status').prop('checked', isChecked).change();
    $('#wh_usa_status').val(isChecked);
    
    // Inisialisasi Choices untuk select
    new Choices('#status_barang_sampai', {
        searchEnabled: false,
        shouldSort: false,
        itemSelectText: ''
    });
    
    // Tampilkan modal
    operasionalModal.show();
});

// Handle simpan operasional
$('#saveOperasional').click(function() {
    const formData = new FormData($('#operasionalForm')[0]);
    const itemId = $('#operasional_item_id').val();
    
    $.ajax({
        url: `/purchase-order-detail/${itemId}/update-operasional`,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            alert('Data operasional berhasil diperbarui');
            operasionalModal.hide();
            
            // Update tombol dengan data terbaru
            $(`.edit-operasional-btn[data-item-id="${itemId}"]`)
                .data('wh-usa-path', response.wh_usa_path)
                .data('wh-usa-mutasi-check', response.wh_usa_mutasi_check)
                .data('wh-indonesia-path', response.wh_indonesia_path)
                .data('fix-weight', response.fix_weight)
                .data('fix-price', response.fix_price)
                .data('status-barang-sampai', response.status_barang_sampai);
        },
        error: function(xhr) {
            toastr.error('Gagal memperbarui data operasional');
            console.error(xhr.responseText);
        }
    });
});

});
</script>
@endsection