@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-first">
                <h3>Purchase Order</h3>
                <p class="text-subtitle text-muted">{{ (isset($purchase)? 'Edit purchase':'Add purchase') }}</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('purchase.index') }}">Purchase Order</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ (isset($purchase)? 'Edit Purchase Order':'Add Purchase Order') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">

        <form class="form" method="POST" action="{{route('purchase.store')}}" enctype="multipart/form-data">
@csrf
         <!-- Items Section -->
         <div class="row">
                   <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                 <div class="col-md-6 col-12">
                                    <div class="form-group">
                                         <label for="tipe_order" class="form-label">Tipe Order</label>
                                        <select class="required choices form-select" id="tipe_order" name="tipe_order">

                                            <option value="">Press to select</option>
                                            <option value="01">Jasmin</option>
                                            <option value="02" selected>Jastip Order</option>
                                            <option value="03">Jastip Only</option>
                                            <option value="04">Jastip B2B</option>


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
                                        <select class="required form-select" id="customer" name="no_telp">
                                             {{-- <option value="custom">-- Custom / Buat Baru --</option>

                                            <option value="">Press to select</option> --}}
                                            {{-- @if(isset($purchase))
                                                @foreach($customer as $customers)
                                                <option value="{{ $customers->id }}" {{ ($customers->whatsapp_number == $purchase->no_telp)? 'selected' : '' }}>{{$customers->whatsapp_number}} - {{$customers->display_name}}</option>
                                                @endforeach
                                            @else
                                                @foreach($customer as $customers)
                                                <option value="{{ $customers->whatsapp_number }}" >{{$customers->whatsapp_number}}  - {{$customers->display_name}}</option>
                                                @endforeach
                                            @endif --}}
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
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" id="name" class="form-control form-control-lg required"  value="{{ (isset($purchase->nama)? $purchase->nama:old('nama')) }}"  name="nama" placeholder="Jasmin">
                                    </div>
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="text" id="email" class="form-control form-control-lg required"  value="{{ (isset($purchase->email)? $purchase->email:old('email')) }}"  name="email" placeholder="mail@gmail.com">
                                    </div>
                                    @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                 <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="no_telp" class="form-label">Phone</label>
                                        <input type="text" id="no_telp" class="form-control form-control-lg required"  value="{{ (isset($purchase->no_telp)? $purchase->no_telp:old('no_telp')) }}"  name="phone" placeholder="Enter Phone Number">
                                    </div>
                                    @error('no_telp')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                  <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="name" class="form-label">Alamat</label>
                                        <input type="text" id="address" class="form-control form-control-lg required"  value="{{ (isset($purchase->alamat)? $purchase->alamat:old('alamat')) }}"  name="alamat" placeholder="Enter Address">
                                    </div>
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Customer PO</h4>
                        <button type="button" class="btn btn-primary btn-sm float-end" id="add-item-btn">
                            <i class="bi bi-plus"></i> Add Item
                        </button>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div id="items-container">


                                <!-- Default empty item -->
                                <div class="item-row row mb-3 border p-3 rounded">
                                  <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label class="form-label">Customer Order</label>
                                            <select class="required form-select customer-order-select" name="items[0][customer_order_id]" data-index="0">


                                                <option value="">Select Customer Order</option>
                                                <!-- Options akan diisi oleh Choices.js -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label class="form-label">Quantity</label>
                                            <input type="text" class="form-control form-control-lg required" name="items[0][quantity]" placeholder="1">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label class="form-label">Notes</label>
                                            <input type="text" class="form-control form-control-lg required" name="items[0][estimasi_notes]" placeholder="color, size, etc">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label class="form-label">No. PO Customer</label>
                                            <input type="text" readonly class="form-control form-control-lg required" name="items[0][no_po_customer]" placeholder="Auto Generate By System">
                                        </div>
                                    </div>
                                      <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label class="form-label">Harga Barang</label>
                                            <input type="text" class="form-control form-control-lg required" name="items[0][estimasi_harga]" placeholder="1.000.000">
                                        </div>
                                    </div>
                                     <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label class="form-label">Estimasi Kg</label>
                                            <input type="text" class="form-control form-control-lg required" name="items[0][estimasi_kg]" placeholder="Kg">
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label class="form-label">Nama Barang</label>
                                            <input type="text" class="form-control form-control-lg required" name="items[0][nama_barang]" placeholder="Enter Item Name">
                                        </div>
                                    </div>
                                     <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label class="form-label">Asuransi 2%</label>
                                            <input type="text" readonly class="form-control form-control-lg required" name="items[0][asuransi]" placeholder="Auto Count">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label class="form-label">Jasa Kg</label>
                                            <input type="text" class="form-control form-control-lg required" name="items[0][jasakg]" placeholder="325.000">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">

                                         <div class="form-group">
                                            <label class="form-label">Link Barang</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-lg required link-input"
                                                    name="items[0][link_barang]" placeholder="https://example.com">
                                                <button class="btn btn-outline-primary btn-open-link"
                                                    type="button">
                                                    <i class="bi bi-box-arrow-up-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label class="form-label">Diskon</label>
                                            <input type="text" class="form-control form-control-lg required" name="items[0][diskon]" placeholder="50.000">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label class="form-label">Total Estimasi</label>
                                            <input type="text" class="form-control form-control-lg required" name="items[0][total_estimasi]" placeholder="Auto Count" readonly>
                                        </div>
                                    </div>
                                     <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label class="form-label">Category</label>
                                            <div class="input-group">
                                                <select class="required form-select category-select" name="items[0][category_id]" data-index="0">
                                                    <option value="">Select Category</option>
                                                </select>
                                                <button type="button" class="btn btn-primary btn-add-category" title="Add New Category" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                                                    <i class="bi bi-plus-lg"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label class="form-label">Brand</label>
                                            <div class="input-group">
                                                <select class="required form-select brand-select" name="items[0][brand_id]" data-index="0">
                                                    <option value="">Select Brand</option>
                                                </select>
                                                <button type="button" class="btn btn-success btn-add-brand" title="Add New Brand" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                                                    <i class="bi bi-plus-lg"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12 text-end">
                                        <button type="button" class="btn btn-danger btn-sm remove-item-btn">
                                            <i class="bi bi-trash"></i> Remove Item
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


         </div>


            <div class="row">
                <div class="col-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                </div>
            </div>
        </form>
    </section>
</div>

<!-- Modal Add Category -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border: none; border-radius: 15px; box-shadow: 0 10px 40px rgba(0,0,0,0.15);">
            <div class="modal-header" style="border-bottom: 2px solid rgba(255,255,255,0.2); border-radius: 15px 15px 0 0;">
                <h5 class="modal-title" id="addCategoryModalLabel" style="font-weight: 600;">
                    <i class="bi bi-folder-plus me-2"></i> Add New Category
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 2rem;">
                <form id="addCategoryForm">
                    <div class="mb-4">
                        <label for="category_name" class="form-label">
                            <i class="bi bi-folder me-1"></i> Category Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control form-control-lg" id="category_name" name="name"
                               placeholder="e.g., Shoes, Apparel" required
                               style="border-radius: 10px; border: 2px solid #e2e8f0;">
                        <div class="invalid-feedback" id="category_name_error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="category_code" class="form-label">
                            <i class="bi bi-upc-scan me-1"></i> Category Code <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control form-control-lg text-uppercase" id="category_code" name="code"
                               placeholder="e.g., SHO, APP" required maxlength="50"
                               style="border-radius: 10px; border: 2px solid #e2e8f0; font-weight: 600; letter-spacing: 1px;">
                        <small class="text-muted d-block mt-2">
                            <i class="bi bi-info-circle me-1"></i> Kode unik untuk category (otomatis uppercase)
                        </small>
                        <div class="invalid-feedback" id="category_code_error"></div>
                        <div class="valid-feedback" id="category_code_success">
                            <i class="bi bi-check-circle me-1"></i> Category code tersedia!
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="border-top: 1px solid #e2e8f0; padding: 1.5rem 2rem; border-radius: 0 0 15px 15px;">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 8px; padding: 0.5rem 1.5rem;">
                    <i class="bi bi-x-circle me-1"></i> Cancel
                </button>
                <button type="button" class="btn btn-primary" id="saveCategoryBtn" style="border-radius: 8px; padding: 0.5rem 1.5rem; font-weight: 600;">
                    <i class="bi bi-save me-1"></i> Save Category
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Brand -->
<div class="modal fade" id="addBrandModal" tabindex="-1" aria-labelledby="addBrandModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border: none; border-radius: 15px; box-shadow: 0 10px 40px rgba(0,0,0,0.15);">
            <div class="modal-header" style="border-bottom: 2px solid rgba(255,255,255,0.2); border-radius: 15px 15px 0 0;">
                <h5 class="modal-title" id="addBrandModalLabel" style="font-weight: 600;">
                    <i class="bi bi-tags-fill me-2"></i> Add New Brand
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 2rem;">
                <form id="addBrandForm">
                    <div class="mb-4">
                        <label for="brand_name" class="form-label">
                            <i class="bi bi-tag me-1"></i> Brand Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control form-control-lg" id="brand_name" name="name"
                               placeholder="e.g., Nike, Adidas" required
                               style="border-radius: 10px; border: 2px solid #e2e8f0;">
                        <div class="invalid-feedback" id="name_error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="brand_code" class="form-label">
                            <i class="bi bi-upc-scan me-1"></i> Brand Code <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control form-control-lg text-uppercase" id="brand_code" name="code"
                               placeholder="e.g., NKE, ADS" required maxlength="50"
                               style="border-radius: 10px; border: 2px solid #e2e8f0; font-weight: 600; letter-spacing: 1px;">
                        <small class="text-muted d-block mt-2">
                            <i class="bi bi-info-circle me-1"></i> Kode unik untuk brand (otomatis uppercase)
                        </small>
                        <div class="invalid-feedback" id="code_error"></div>
                        <div class="valid-feedback" id="code_success">
                            <i class="bi bi-check-circle me-1"></i> Brand code tersedia!
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="border-top: 1px solid #e2e8f0; padding: 1.5rem 2rem; border-radius: 0 0 15px 15px;">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 8px; padding: 0.5rem 1.5rem;">
                    <i class="bi bi-x-circle me-1"></i> Cancel
                </button>
                <button type="button" class="btn btn-success" id="saveBrandBtn" style="border-radius: 8px; padding: 0.5rem 1.5rem; font-weight: 600;">
                    <i class="bi bi-save me-1"></i> Save Brand
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
    /* Styling untuk Category & Brand Input Group dengan Choices.js */
    .input-group .choices {
        flex: 1 1 auto;
        width: 1%;
    }

    .input-group .choices .choices__inner {
        border-top-right-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
        border-right: 0;
        min-height: 48px !important;
        height: 48px !important;
        padding: 0.625rem 1rem;
        display: flex;
        align-items: center;
    }

    /* Category Button Styling */
    .input-group .btn-add-category {
        border-left: 1px solid #dfe3e7;
        padding: 0;
        min-width: 48px;
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .input-group .btn-add-category i {
        font-size: 1.1rem;
        line-height: 1;
    }

    .input-group .btn-add-category:hover {
        background-color: #0d6efd;
        border-color: #0d6efd;
        transform: none;
    }

    /* Brand Button Styling */
    .input-group .btn-add-brand {
        border-left: 1px solid #dfe3e7;
        padding: 0;
        min-width: 48px;
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .input-group .btn-add-brand i {
        font-size: 1.1rem;
        line-height: 1;
    }

    .input-group .btn-add-brand:hover {
        background-color: #28a745;
        border-color: #28a745;
        transform: none;
    }

    .input-group:focus-within .choices .choices__inner {
        border-color: #5a8dee;
        box-shadow: 0 0 0 0.2rem rgba(90, 141, 238, 0.25);
    }

    /* Pastikan single value text vertical center */
    .input-group .choices__inner .choices__list--single {
        padding: 0;
    }

    .input-group .choices__inner .choices__list--single .choices__item {
        padding: 0;
    }    /* Fix untuk Choices dropdown yang terpotong */
    .choices[data-type*="select-one"] .choices__inner {
        padding-bottom: 0.625rem;
    }

    .choices__list--dropdown {
        z-index: 100;
    }

    /* Styling untuk modal category */
    #addCategoryModal .modal-header {
        background: linear-gradient(135deg, #4285f4 0%, #0d47a1 100%);
        color: white;
    }

    #addCategoryModal .modal-header .btn-close {
        filter: brightness(0) invert(1);
        opacity: 1;
    }

    #addCategoryModal .modal-header .btn-close:hover {
        opacity: 0.8;
    }

    #addCategoryModal .form-label {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0.5rem;
    }

    #addCategoryModal .form-control:focus {
        border-color: #4285f4;
        box-shadow: 0 0 0 0.2rem rgba(66, 133, 244, 0.25);
    }

    #addCategoryModal .text-danger {
        color: #dc3545;
    }

    #addCategoryModal .invalid-feedback,
    #addCategoryModal .valid-feedback {
        display: block;
        margin-top: 0.5rem;
        font-size: 0.875rem;
    }

    /* Styling untuk modal brand */
    #addBrandModal .modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    #addBrandModal .modal-header .btn-close {
        filter: brightness(0) invert(1);
        opacity: 1;
    }

    #addBrandModal .modal-header .btn-close:hover {
        opacity: 0.8;
    }

    #addBrandModal .form-label {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0.5rem;
    }

    #addBrandModal .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    #addBrandModal .text-danger {
        color: #dc3545;
    }

    #addBrandModal .invalid-feedback,
    #addBrandModal .valid-feedback {
        display: block;
        margin-top: 0.5rem;
        font-size: 0.875rem;
    }

    /* Animasi untuk button add category & brand */
    .btn-add-category,
    .btn-add-brand {
        transition: all 0.2s ease;
    }

    .btn-add-category:active,
    .btn-add-brand:active {
        transform: scale(0.95);
    }

    /* Animasi modal */
    .modal.fade .modal-dialog {
        transition: transform 0.3s ease-out;
    }

    .modal.show .modal-dialog {
        transform: none;
    }

    /* Styling untuk button save */
    #saveCategoryBtn,
    #saveBrandBtn {
        transition: all 0.3s ease;
    }

    #saveCategoryBtn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
    }

    #saveBrandBtn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
    }

    #saveCategoryBtn:active,
    #saveBrandBtn:active {
        transform: translateY(0);
    }
</style>
@endsection

@section('scripts')

<script>
$(document).ready(function() {
    let itemCounter = $('#items-container .item-row').length;
    const customerOrders = @json($customerOrders);
    let dataBrand = @json($brand); // Ubah ke let agar bisa diupdate saat add brand baru
    const dataCategory = @json($category);
    let selectedCustomerOrders = [];
    let choicesInstances = [];
    let currentCustomerId = null;

    // ============================================
    // RUPIAH FORMATTING FUNCTIONS
    // ============================================

    /**
     * Format angka menjadi format Rupiah (dengan separator titik)
     * Contoh: 1000000 -> 1.000.000
     */
    function formatRupiah(angka) {
        if (!angka) return '';

        // Hapus semua karakter non-digit
        let number_string = angka.toString().replace(/[^,\d]/g, '');
        let split = number_string.split(',');
        let sisa = split[0].length % 3;
        let rupiah = split[0].substr(0, sisa);
        let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // Tambahkan titik jika sudah menjadi ribuan
        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return rupiah;
    }

    /**
     * Parse format Rupiah kembali ke angka untuk kalkulasi
     * Contoh: "1.000.000" -> 1000000
     */
    function parseRupiah(rupiah) {
        if (!rupiah) return 0;
        return parseFloat(rupiah.toString().replace(/\./g, '').replace(/,/g, '.')) || 0;
    }

    /**
     * Apply format Rupiah ke input field saat user mengetik
     */
    function applyRupiahFormat(element) {
        let value = $(element).val();
        let formatted = formatRupiah(value);
        $(element).val(formatted);
    }

    /**
     * Initialize Rupiah format untuk semua field currency yang ada
     */
    function initRupiahFormatting() {
        // Selector untuk semua field yang perlu format Rupiah
        const currencyFields = [
            'input[name*="[estimasi_harga]"]',
            'input[name*="[jasakg]"]',
            'input[name*="[diskon]"]',
            'input[name*="[total_estimasi]"]',
            'input[name*="[asuransi]"]',
            'input[name*="[dp]"]',
            'input[name*="[fullpayment]"]',
            'input[name*="[pelunasan]"]',
            'input[name*="[kurang_bayar]"]',
            'input[name*="[jumlah_transfer]"]',
            'input[name*="[total_purchase]"]',
            'input[name*="[harga_hpp]"]',
            'input[name*="[fix_price]"]'
        ].join(', ');

        // Apply format saat user mengetik
        $(document).on('keyup', currencyFields, function(e) {
            // Simpan posisi cursor
            let cursorPosition = this.selectionStart;
            let oldLength = this.value.length;

            // Format value
            applyRupiahFormat(this);

            // Restore posisi cursor (adjust untuk separator yang ditambahkan)
            let newLength = this.value.length;
            let newPosition = cursorPosition + (newLength - oldLength);
            this.setSelectionRange(newPosition, newPosition);
        });

        // Format existing values on page load
        $(currencyFields).each(function() {
            if ($(this).val() && !$(this).prop('readonly')) {
                applyRupiahFormat(this);
            }
        });
    }

    // Initialize Rupiah formatting
    initRupiahFormatting();

    $('form').submit(function(e) {
    e.preventDefault();

    // Validasi semua field wajib
    let isValid = true;

    const emptyFields = new Set(); // Gunakan Set untuk menghindari duplikasi

    // Validasi field utama
    $('.required').each(function() {
        const label = $(this).prev('label').text().trim();
        if ($(this).is('select') ? !$(this).val() : !$(this).val() || $(this).val().trim() === '') {
            isValid = false;
            $(this).addClass('is-invalid');
            if (label) emptyFields.add(label);
        } else {
            $(this).removeClass('is-invalid');
        }
    });

    // Validasi item
    $('.item-row').each(function(index) {
        const itemSelect = $(this).find('.customer-order-select');
        if (!itemSelect.val()) {
            isValid = false;
            itemSelect.addClass('is-invalid');
            emptyFields.add(`Customer Order Item ${index + 1}`);
        } else {
            itemSelect.removeClass('is-invalid');
        }
    });

    if (!isValid) {
        // Format pesan error lebih rapi
        let errorMessage;
        if (emptyFields.size > 0) {
            const fieldsArray = Array.from(emptyFields).filter(field => field);
            if (fieldsArray.length > 3) {
                errorMessage = `<b>${fieldsArray.length} field wajib</b> belum diisi`;
            } else {
                errorMessage = `<b>Field wajib berikut belum diisi:</b><br>• ${fieldsArray.join('<br>• ')}`;
            }
        } else {
            errorMessage = 'Terdapat field yang belum diisi';
        }

        Swal.fire({
            icon: 'error',
            title: 'Form Tidak Lengkap',
            html: errorMessage,
            footer: 'Harap periksa kembali form Anda'
        });
        return;
    }

    // Validasi minimal 1 item
    const itemCount = $('.item-row').length;
    if (itemCount === 0) {
        isValid = false;
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Anda harus menambahkan minimal 1 item'
        });
        return;
    }

    // Jika validasi sukses, tampilkan konfirmasi
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data akan disimpan ke database",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Simpan!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Convert format Rupiah ke angka sebelum submit
            const $form = $(this);
            const formData = new FormData($form[0]);

            // List semua field currency yang perlu di-convert
            const currencyFields = [
                'estimasi_harga',
                'jasakg',
                'diskon',
                'total_estimasi',
                'asuransi'
            ];

            // Convert semua item currency fields
            $('.item-row').each(function(index) {
                currencyFields.forEach(field => {
                    const $input = $(this).find(`input[name="items[${index}][${field}]"]`);
                    if ($input.length && $input.val()) {
                        const rawValue = parseRupiah($input.val());
                        formData.set(`items[${index}][${field}]`, rawValue);
                    }
                });
            });

            // Submit form dengan FormData yang sudah di-convert
            $.ajax({
                url: $form.attr('action'),
                method: $form.attr('method'),
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message || 'Data berhasil disimpan',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = response.redirect || "{{ route('purchase.index') }}";
                    });
                },
                error: function(xhr) {
                    let errorMessage = 'Terjadi kesalahan saat menyimpan data';
                    let errorDetails = '';

                    if (xhr.responseJSON) {
                        if (xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        if (xhr.responseJSON.errors) {
                            // Format validation errors
                            const errors = xhr.responseJSON.errors;
                            errorDetails = '<ul class="text-start">';
                            Object.keys(errors).forEach(key => {
                                errors[key].forEach(error => {
                                    errorDetails += `<li>${error}</li>`;
                                });
                            });
                            errorDetails += '</ul>';
                        }
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        html: errorMessage + errorDetails,
                        width: '600px'
                    });
                }
            });
        }
    });
});

// Untuk menghilangkan error saat mulai mengisi
$('.required').on('input change', function() {
    if ($(this).val()) {
        $(this).removeClass('is-invalid');
    }
});

    // Inisialisasi fungsi untuk item yang sudah ada
    $('.item-row').each(function() {
        const index = $(this).find('.customer-order-select').data('index');
        const indexCt = $(this).find('.category-select').data('index');
        const indexBrd = $(this).find('.brand-select').data('index');
        initItemEvents(index);
        initializeChoices($(this).find('.customer-order-select')[0], index);
        initializeChoicesCategory($(this).find('.category-select')[0], indexCt)
        initializeChoicesBrand($(this).find('.brand-select')[0], indexBrd)
    });

    $('#customer').on('change', function () {
        const customerId = $(this).val();

        if (customerId) {

            $.get('/customers/' + customerId, function(data) {

                $('#name').val(data.display_name ?? "");
                $('#email').val(data.email_address ?? "");
                $('#address').val(data.address ?? "");
                $('#no_telp').val(data.whatsapp_number ?? "");

            });
        }
    });
    // Event change untuk customer select
    $('#customer').on('change', function () {
        currentCustomerId = $(this).val();
        selectedCustomerOrders = [];

        if (currentCustomerId && currentCustomerId !== 'custom') {
            filterCustomerOrders(currentCustomerId);

            // Reset semua form item
            $('.item-row').each(function() {
                const index = $(this).find('.customer-order-select').data('index');
                resetItemForm(index);
            });
        } else {
            resetCustomerOrderSelects();
        }
    });

    // Fungsi untuk filter customer orders berdasarkan customer yang dipilih
    function filterCustomerOrders(customerId) {
        resetAllItems();
        const filteredOrders = customerOrders.filter(order =>
            order.customProperties.customer_id == customerId
        );

        // Update semua select yang ada
        $('.customer-order-select').each(function() {
            const select = $(this)[0];
            const currentValue = $(this).val();
            const choicesInstance = choicesInstances.find(i => i.element === select)?.instance;

            if (choicesInstance) {
                // Clear current choices
                choicesInstance.clearChoices();

                // Add filtered options
                choicesInstance.setChoices(
                    filteredOrders.map(order => ({
                        value: order.value,
                        label: order.label,
                        customProperties: order.customProperties
                    })),
                    'value',
                    'label',
                    false
                );

                // Restore selection jika masih valid
                if (currentValue && filteredOrders.some(o => o.value == currentValue)) {
                    choicesInstance.setValue([currentValue]);
                    selectedCustomerOrders.push(currentValue);
                } else {
                    $(this).val('').trigger('change');
                }
            }
        });
    }

    // Fungsi untuk reset semua items
    function resetAllItems() {
        $('.item-row').each(function() {
            const index = $(this).find('.customer-order-select').data('index');
            resetItemForm(index);

            // Reset select value
            const selectElement = $(this).find('.customer-order-select')[0];
            const choicesInstance = choicesInstances.find(i => i.element === selectElement)?.instance;
            if (choicesInstance) {
                choicesInstance.setValue(['']);
            }
        });
    }

    // Fungsi untuk reset customer order selects
    // function resetCustomerOrderSelects() {
    //     $('.customer-order-select').each(function() {
    //         const select = $(this)[0];
    //         const choicesInstance = choicesInstances.find(i => i.element === select)?.instance;

    //         if (choicesInstance) {
    //             choicesInstance.clearChoices();
    //             choicesInstance.setChoices(
    //                 customerOrders.map(order => ({
    //                     value: order.value,
    //                     label: order.label,
    //                     customProperties: order.customProperties
    //                 })),
    //                 'value',
    //                 'label',
    //                 false
    //             );
    //             choicesInstance.setValue(['']);
    //         }
    //     });
    // }

    function resetCustomerOrderSelects() {
    const tipeOrder = $('#tipe_order').val();

    $('.customer-order-select').each(function() {
        const select = $(this)[0];
        const choicesInstance = choicesInstances.find(i => i.element === select)?.instance;

        if (choicesInstance) {
            choicesInstance.clearChoices();

            if (tipeOrder === "01") {
                // Kalau Jasmin, isi dari customerOrders
                const customOption = {
                    value: "custom",
                    label: "-- Custom / Buat Baru --",
                    customProperties: {}
                };

                choicesInstance.setChoices(
                    [customOption, ...customerOrders.map(order => ({
                        value: order.value,
                        label: order.label,
                        customProperties: order.customProperties
                    }))],
                    'value',
                    'label',
                    false
                );
            } else {
                // Kalau bukan Jasmin, reset ke custom aja
                choicesInstance.setChoices(
                    [{
                        value: "custom",
                        label: "-- Custom / Buat Baru --",
                        selected: true,
                        customProperties: {}
                    }],
                    'value',
                    'label',
                    false
                );
            }

            // Reset value ke kosong
            choicesInstance.setValue(['']);
        }
    });
}

    // Fungsi untuk inisialisasi Choices.js pada select element
    function initializeChoices(selectElement, index) {
        const tipeOrder = $('#tipe_order').val();

        const existingInstance = choicesInstances.find(i => i.element === selectElement);
        if (existingInstance) {
            existingInstance.instance.destroy();
            choicesInstances = choicesInstances.filter(i => i.element !== selectElement);
        }

        // Get available orders (not selected or for current customer)
         let choicesData = [];
                // Dapatkan order yang tersedia untuk customer saat ini
             const customOption = {
                value: "custom",
                label: "-- Custom / Buat Baru --",
                selected: true,
                customProperties: {}
            };
        if (tipeOrder === "01") {
            const availableOrders = currentCustomerId
                ? customerOrders.filter(order =>
                    order.customProperties.customer_id == currentCustomerId &&
                    (!selectedCustomerOrders.includes(order.value) ||
                    order.value === $(selectElement).val()))
                : [];


            choicesData = [...availableOrders];
        }else{
            choicesData = [customOption];
        }

        const choices = new Choices(selectElement, {
            choices: choicesData,
            searchEnabled: true,
            shouldSort: false,
            itemSelectText: '',
            classNames: {
                containerInner: 'choices__inner form-select'
            },
            callbackOnInit: function() {
                const selectedValue = $(selectElement).val();
                if (selectedValue && !selectedCustomerOrders.includes(selectedValue) && selectedValue !== "custom") {
                    selectedCustomerOrders.push(selectedValue);
                    autoFillItem(index, selectedValue);
                }
            },
            shouldSortItems: function() {
                return false;
            }
        });

        choicesInstances.push({
            element: selectElement,
            instance: choices
        });

        return choices;
    }


     function initializeChoicesCategory(selectElement, index) {

        const choices = new Choices(selectElement, {
            choices: dataCategory,
            searchEnabled: true,
            shouldSort: false,
            itemSelectText: '',
            classNames: {
                containerInner: 'choices__inner form-select category-select'
            },
            shouldSortItems: function() {
                return false;
            }
        });

        choicesInstances.push({
            element: selectElement,
            instance: choices
        });

        return choices;
    }

     function initializeChoicesBrand(selectElement, index) {

        const choices = new Choices(selectElement, {
            choices: dataBrand,
            searchEnabled: true,
            shouldSort: false,
            itemSelectText: '',
            classNames: {
                containerInner: 'choices__inner form-select brand-select'
            },
            shouldSortItems: function() {
                return false;
            }
        });

        choicesInstances.push({
            element: selectElement,
            instance: choices
        });

        return choices;
    }

    // Fungsi untuk auto-fill data item berdasarkan customer order
    function autoFillItem(index, customerOrderId) {
        resetItemForm(index);

        const order = customerOrders.find(o => o.value == customerOrderId);
        if (!order) return;

        const itemRow = $(`.item-row [data-index="${index}"]`).closest('.item-row');
        itemRow.find(`input[name="items[${index}][no_po_customer]"]`).val(order.customProperties.po_number || '');
        itemRow.find(`input[name="items[${index}][nama_barang]"]`).val(order.customProperties.nama_barang || '');
        itemRow.find(`input[name="items[${index}][link_barang]"]`).val(order.customProperties.link_product || '');
        itemRow.find(`input[name="items[${index}][estimasi_notes]"]`).val(order.customProperties.jumlah_berat || '');

        // Format harga ke Rupiah jika ada
        const totalHarga = order.customProperties.total_harga || '';
        if (totalHarga) {
            itemRow.find(`input[name="items[${index}][estimasi_harga]"]`).val(formatRupiah(totalHarga.toString()));
        }

        itemRow.find(`input[name="items[${index}][quantity]"]`).val('1');

        // Hitung asuransi dan total
        calculateTotals(index);
        initLinkButtons();
    }

    // Fungsi untuk reset form item
    function resetItemForm(index) {
        const itemRow = $(`select[data-index="${index}"]`).closest('.item-row');
        itemRow.find(`input[name="items[${index}][no_po_customer]"]`).val('').prop('readonly', true);
        itemRow.find(`input[name="items[${index}][nama_barang]"]`).val('');
        itemRow.find(`input[name="items[${index}][link_barang]"]`).val('');
        itemRow.find(`input[name="items[${index}][estimasi_kg]"]`).val('');
        itemRow.find(`input[name="items[${index}][estimasi_harga]"]`).val('');
        itemRow.find(`input[name="items[${index}][estimasi_notes]"]`).val('');
        itemRow.find(`input[name="items[${index}][asuransi]"]`).val('');
        itemRow.find(`input[name="items[${index}][jasakg]"]`).val('');
        itemRow.find(`input[name="items[${index}][diskon]"]`).val('0');
        itemRow.find(`input[name="items[${index}][total_estimasi]"]`).val('');
    }

    // Fungsi untuk refresh semua select elements
    function refreshAllSelects() {
        const tipeOrder = $('#tipe_order').val();
        $('.customer-order-select').each(function() {
            const index = $(this).data('index');
            const currentValue = $(this).val();
            const choicesInstance = choicesInstances.find(i => i.element === this)?.instance;

            if (choicesInstance) {
                    let choicesData = [];
                // Dapatkan order yang tersedia untuk customer saat ini
                 if (tipeOrder === "01") {
                    const availableOrders = currentCustomerId
                        ? customerOrders.filter(order =>
                            order.customProperties.customer_id == currentCustomerId &&
                            (!selectedCustomerOrders.includes(order.value) || order.value === currentValue)
                        )
                        : [];

                    const customOption = {
                        value: "custom",
                        label: "-- Custom / Buat Baru --",
                        customProperties: {}
                    };

                    choicesData = [...availableOrders];
                    // Simpan nilai yang sedang dipilih

                }else{
                     choicesData = [{
                        value: "custom",
                        label: "-- Custom / Buat Baru --",
                        selected: true,
                        customProperties: {}
                    }];
                }

                 const currentSelection = choicesInstance.getValue(true);

                // Perbarui pilihan
                choicesInstance.clearChoices();
                choicesInstance.setChoices(
                    choicesData,
                    'value',
                    'label',
                    false
                );
                // Kembalikan seleksi jika masih tersedia
                if (currentValue && (currentValue === "custom" || availableOrders.some(o => o.value == currentValue))) {
                    choicesInstance.setValue([currentValue]);
                }
            }
        });
    }

    // Event listener untuk perubahan select customer order
    $('#items-container').on('change', '.customer-order-select', function() {
        const index = $(this).data('index');
        const selectedValue = $(this).val();
        const previousValue = $(this).data('prev-value') || '';
        const choicesInstance = choicesInstances.find(i => i.element === this)?.instance;

        // Hapus nilai sebelumnya dari tracking
        if (previousValue && previousValue !== "custom" && selectedCustomerOrders.includes(previousValue)) {
            selectedCustomerOrders = selectedCustomerOrders.filter(v => v !== previousValue);
        }

        if (selectedValue === "custom") {
            // Reset form untuk custom input
            resetItemForm(index);
            $(`input[name="items[${index}][no_po_customer]"]`).prop('readonly', true);
            $(`input[name="items[${index}][no_po_customer]"]`).val('Generated By System');
            $(`input[name="items[${index}][nama_barang]"]`).prop('readonly', false);
            return;
        }

        // Cek untuk duplikasi seleksi
        if (selectedValue && selectedValue !== "custom") {
            if (selectedCustomerOrders.includes(selectedValue)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Customer Order ini sudah dipilih di item lain!',
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'Mengerti'
                });

                if (choicesInstance) {
                    choicesInstance.setValue([previousValue]);
                    if (previousValue) {
                        selectedCustomerOrders.push(previousValue);
                    }
                }
                return;
            }

            // Tambahkan ke selected orders dan auto-fill
            selectedCustomerOrders.push(selectedValue);
            $(this).data('prev-value', selectedValue);
            autoFillItem(index, selectedValue);
        } else {
            resetItemForm(index);
        }

        // Refresh semua selects untuk update opsi yang tersedia
        refreshAllSelects();
    });

    // Tambah item baru
    $('#add-item-btn').click(function() {
        const newItemHtml = `
            <div class="item-row row mb-3 border p-3 rounded">
                <div class="col-md-6 col-12">
                    <div class="form-group">
                        <label class="form-label">Customer Order</label>
                        <select class="form-select customer-order-select required" name="items[${itemCounter}][customer_order_id]" data-index="${itemCounter}">
                            <option value="">Select Customer Order</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label class="form-label">Quantity</label>
                        <input type="text" class="form-control form-control-lg required" name="items[${itemCounter}][quantity]" placeholder="1">
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label class="form-label">Notes</label>
                        <input type="text" class="form-control form-control-lg required" name="items[${itemCounter}][estimasi_notes]" placeholder="color, size, etc">
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="form-group">
                        <label class="form-label">No. PO Customer</label>
                        <input type="text" readonly class="form-control form-control-lg required" name="items[${itemCounter}][no_po_customer]" placeholder="Auto Generate By System">
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label class="form-label">Harga Barang</label>
                        <input type="text" class="form-control form-control-lg required" name="items[${itemCounter}][estimasi_harga]" placeholder="1.000.000">
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label class="form-label">Estimasi Kg</label>
                        <input type="text" class="form-control form-control-lg required" name="items[${itemCounter}][estimasi_kg]" placeholder="Kg">
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="form-group">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" class="form-control form-control-lg required" name="items[${itemCounter}][nama_barang]" placeholder="Enter Item Name">
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label class="form-label">Asuransi 2%</label>
                        <input type="text" readonly class="form-control form-control-lg required" name="items[${itemCounter}][asuransi]" placeholder="Auto Count">
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label class="form-label">Jasa Kg</label>
                        <input type="text" class="form-control form-control-lg required" name="items[${itemCounter}][jasakg]" placeholder="325.000">
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="form-group">
                        <label class="form-label">Link Barang</label>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-lg required link-input" name="items[${itemCounter}][link_barang]" placeholder="https://example.com">
                            <button class="btn btn-outline-primary btn-open-link" type="button">
                                <i class="bi bi-box-arrow-up-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label class="form-label">Diskon</label>
                        <input type="text" class="form-control form-control-lg required" name="items[${itemCounter}][diskon]" placeholder="50.000">
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label class="form-label">Total Estimasi</label>
                        <input type="text" class="form-control form-control-lg required" name="items[${itemCounter}][total_estimasi]" placeholder="Auto Count" readonly>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="form-group">
                        <label class="form-label">Category</label>
                        <div class="input-group">
                            <select class="form-select category-select required" name="items[${itemCounter}][category_id]" data-category="${itemCounter}">
                                <option value="">Select Category</option>
                            </select>
                            <button type="button" class="btn btn-primary btn-add-category" title="Add New Category" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                                <i class="bi bi-plus-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="form-group">
                        <label class="form-label">Brand</label>
                        <div class="input-group">
                            <select class="form-select brand-select required" name="items[${itemCounter}][brand_id]" data-brand="${itemCounter}">
                                <option value="">Select Brand</option>
                            </select>
                            <button type="button" class="btn btn-success btn-add-brand" title="Add New Brand" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                                <i class="bi bi-plus-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-12 text-end">
                    <button type="button" class="btn btn-danger btn-sm remove-item-btn">
                        <i class="bi bi-trash"></i> Remove Item
                    </button>
                </div>
            </div>
        `;

        $('#items-container').append(newItemHtml);
        const newSelect = $(`[data-index="${itemCounter}"]`)[0];
        const newSelectCat = $(`[data-category="${itemCounter}"]`)[0];
        const newSelectBrand = $(`[data-brand="${itemCounter}"]`)[0];
        initializeChoices(newSelect, itemCounter);
        initializeChoicesCategory(newSelectCat, itemCounter);
        initializeChoicesBrand(newSelectBrand, itemCounter);
        initItemEvents(itemCounter);
        resetItemForm(itemCounter);
        itemCounter++;
    });

    // Hapus item
    $('#items-container').on('click', '.remove-item-btn', function() {
        if ($('#items-container .item-row').length > 1) {
            const itemRow = $(this).closest('.item-row');
            const selectElement = itemRow.find('.customer-order-select')[0];
            const selectedValue = $(selectElement).val();

            // Hapus dari daftar yang dipilih jika ada nilai
            if (selectedValue && selectedCustomerOrders.includes(selectedValue)) {
                selectedCustomerOrders = selectedCustomerOrders.filter(v => v !== selectedValue);
            }

            // Hancurkan instance Choices sebelum menghapus
            const instanceIndex = choicesInstances.findIndex(i => i.element === selectElement);
            if (instanceIndex !== -1) {
                choicesInstances[instanceIndex].instance.destroy();
                choicesInstances.splice(instanceIndex, 1);
            }

            // Hapus baris item
            itemRow.remove();

            // Re-index item yang tersisa
            reindexItems();

            // Refresh semua select untuk mengembalikan opsi yang dihapus
            refreshAllSelects();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Anda harus memiliki setidaknya satu item',
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Mengerti'
            });
        }
    });

    // Fungsi untuk re-index items
    function reindexItems() {
        let newIndex = 0;
        $('#items-container .item-row').each(function() {
            $(this).find('input, select').each(function() {
                const name = $(this).attr('name').replace(/items\[\d+\]/, `items[${newIndex}]`);
                $(this).attr('name', name);
            });

            const selectElement = $(this).find('.customer-order-select')[0];
            $(selectElement).attr('data-index', newIndex);

            const instance = choicesInstances.find(i => i.element === selectElement);
            if (instance) {
                instance.instance.setValue([$(selectElement).val()]);
            }

            newIndex++;
        });
        itemCounter = newIndex;
    }

    // Inisialisasi events untuk item
    function initItemEvents(index) {
        const itemRow = $(`[data-index="${index}"]`).closest('.item-row');

        // Hitung total ketika harga, jasa, atau diskon berubah
        itemRow.find('input[name="items[' + index + '][estimasi_harga]"], input[name="items[' + index + '][jasakg]"], input[name="items[' + index + '][diskon]"],  input[name="items[' + index + '][quantity]"]').on('input', function() {
            calculateTotals(index);
        });

        // Link button enable/disable
        itemRow.find('.link-input').on('input', function() {
            const btn = $(this).closest('.input-group').find('.btn-open-link');
            btn.prop('disabled', !$(this).val().trim());
        });

        // Open link button
        itemRow.find('.btn-open-link').click(function() {
            const url = $(this).closest('.input-group').find('.link-input').val().trim();
            if (url) {
                let finalUrl = url;
                if (!url.startsWith('http://') && !url.startsWith('https://')) {
                    finalUrl = 'https://' + url;
                }
                window.open(finalUrl, '_blank');
            }
        });
    }

    // Fungsi untuk menghitung total
    function calculateTotals(index) {
        const itemRow = $(`[data-index="${index}"]`).closest('.item-row');

        // Parse nilai dari format Rupiah ke angka
        const harga = parseRupiah(itemRow.find('input[name="items[' + index + '][estimasi_harga]"]').val());
        const jasa = parseRupiah(itemRow.find('input[name="items[' + index + '][jasakg]"]').val());
        const diskon = parseRupiah(itemRow.find('input[name="items[' + index + '][diskon]"]').val());
        const qty = parseFloat(itemRow.find('input[name="items[' + index + '][quantity]"]').val().replace(/[^\d.]/g, '')) || 0;

        // Hitung asuransi (2% dari harga)
        const asuransi = harga * qty * 0.02;
        const asuransiFormatted = formatRupiah(Math.round(asuransi).toString());
        itemRow.find('input[name="items[' + index + '][asuransi]"]').val(asuransiFormatted);

        // Hitung total
        const total = (harga * qty) + jasa + asuransi - diskon;
        const totalFormatted = formatRupiah(Math.round(total).toString());
        itemRow.find('input[name="items[' + index + '][total_estimasi]"]').val(totalFormatted);
    }

    // Inisialisasi link buttons
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


        const tipeOrder = document.getElementById("tipe_order");
        const customerSelect = document.getElementById("customer");

        let customerChoices = customerSelect.choicesInstance
        || new Choices(customerSelect, { removeItemButton: true, shouldSort: false });

    // simpan instance di element biar ga double
    customerSelect.choicesInstance = customerChoices;

        const customers = @json($customer);
    function loadCustomersIfJasmin() {
         customerChoices.clearStore();

        // isi default
        customerChoices.setChoices([
            { value: "", label: "Press to select", disabled: true },
        ], 'value', 'label', false);

        // kalau tipe Jasmin → load customers
        if (tipeOrder.value === "01") {
            const data = customers.map(c => ({
                value: c.whatsapp_number,
                label: `${c.whatsapp_number} - ${c.display_name}`
            }));
            customerChoices.setChoices(data, 'value', 'label', false);
        }else{
             customerChoices.setChoices([
                { value: "custom", label: "-- Custom / Buat Baru --" , selected: true}
            ], 'value', 'label', false);
            $('#name').val("");
            $('#email').val("");
            $('#address').val("");
            $('#no_telp').val("");

            $('.item-row').each(function() {
                const index = $(this).find('.customer-order-select').data('index');
                resetItemForm(index);
                $(`input[name="items[${index}][no_po_customer]"]`).prop('readonly', true);
                $(`input[name="items[${index}][no_po_customer]"]`).val('Generated By System');
                $(`input[name="items[${index}][nama_barang]"]`).prop('readonly', false);
            });
             resetCustomerOrderSelects();
             refreshAllSelects();
        }
    }

    loadCustomersIfJasmin();

    // jalankan saat select berubah
    tipeOrder.addEventListener("change", loadCustomersIfJasmin);
    // Inisialisasi awal
    initLinkButtons();

    // ============================================
    // CATEGORY MODAL FUNCTIONALITY
    // ============================================
    let currentCategoryItemIndex = null;
    const addCategoryModal = new bootstrap.Modal(document.getElementById('addCategoryModal'));
    let categoryCodeCheckTimeout;

    // Event handler untuk tombol add category
    $(document).on('click', '.btn-add-category', function() {
        // Simpan index item yang sedang aktif
        currentCategoryItemIndex = $(this).closest('.item-row').find('.category-select').data('category');

        // Reset form
        $('#addCategoryForm')[0].reset();
        $('#category_name').removeClass('is-invalid is-valid');
        $('#category_code').removeClass('is-invalid is-valid');
        $('#category_name_error').text('');
        $('#category_code_error').text('');
        $('#category_code_success').text('Category code tersedia!');

        // Tampilkan modal
        addCategoryModal.show();
    });

    // Auto-uppercase untuk category code
    $('#category_code').on('input', function() {
        this.value = this.value.toUpperCase();
    });

    // Real-time check category code saat user mengetik
    $('#category_code').on('input', function() {
        const code = $(this).val().trim();
        const codeInput = $(this);

        // Clear timeout sebelumnya
        clearTimeout(categoryCodeCheckTimeout);

        if (code.length < 2) {
            codeInput.removeClass('is-invalid is-valid');
            $('#category_code_error').text('');
            return;
        }

        // Set timeout untuk menghindari terlalu banyak request
        categoryCodeCheckTimeout = setTimeout(function() {
            $.ajax({
                url: '{{ route("category.check.code") }}',
                method: 'POST',
                data: {
                    code: code,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.exists) {
                        codeInput.removeClass('is-valid').addClass('is-invalid');
                        $('#category_code_error').text(response.message);
                    } else {
                        codeInput.removeClass('is-invalid').addClass('is-valid');
                        $('#category_code_error').text('');
                    }
                }
            });
        }, 500); // Delay 500ms
    });

    // Handle save category
    $('#saveCategoryBtn').click(function() {
        const name = $('#category_name').val().trim();
        const code = $('#category_code').val().trim();
        const saveBtn = $(this);

        // Reset validasi
        $('#category_name').removeClass('is-invalid');
        $('#category_code').removeClass('is-invalid');
        $('#category_name_error').text('');
        $('#category_code_error').text('');

        // Validasi client-side
        let hasError = false;

        if (!name) {
            $('#category_name').addClass('is-invalid');
            $('#category_name_error').text('Category name wajib diisi');
            hasError = true;
        }

        if (!code) {
            $('#category_code').addClass('is-invalid');
            $('#category_code_error').text('Category code wajib diisi');
            hasError = true;
        } else if (code.length < 2) {
            $('#category_code').addClass('is-invalid');
            $('#category_code_error').text('Category code minimal 2 karakter');
            hasError = true;
        }

        if (hasError) return;

        // Disable button dan tampilkan loading
        saveBtn.prop('disabled', true).html('<i class="bi bi-hourglass-split"></i> Saving...');

        // Kirim AJAX request
        $.ajax({
            url: '{{ route("category.store.ajax") }}',
            method: 'POST',
            data: {
                name: name,
                code: code,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    // Tutup modal
                    addCategoryModal.hide();

                    // Tampilkan success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });

                    // Tambahkan category baru ke semua select category
                    $('.category-select').each(function() {
                        const selectElement = this;
                        const choicesInstance = choicesInstances.find(i => i.element === selectElement)?.instance;

                        if (choicesInstance) {
                            choicesInstance.setChoices([{
                                value: response.data.value,
                                label: response.data.label,
                                selected: false
                            }], 'value', 'label', false);
                        }
                    });

                    // Set category yang baru ditambahkan ke item yang aktif
                    if (currentCategoryItemIndex !== null) {
                        const targetSelect = $(`.category-select[data-category="${currentCategoryItemIndex}"]`)[0];
                        const targetInstance = choicesInstances.find(i => i.element === targetSelect)?.instance;

                        if (targetInstance) {
                            targetInstance.setChoiceByValue(response.data.value.toString());
                        }
                    }

                    // Update global category data
                    dataCategory.push({
                        value: response.data.value,
                        label: response.data.label
                    });
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;

                if (xhr.status === 422 && response.errors) {
                    // Validasi error dari server
                    if (response.errors.name) {
                        $('#category_name').addClass('is-invalid');
                        $('#category_name_error').text(response.errors.name[0]);
                    }
                    if (response.errors.code) {
                        $('#category_code').addClass('is-invalid');
                        $('#category_code_error').text(response.errors.code[0]);
                    }
                } else {
                    // Error lainnya
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: response?.message || 'Terjadi kesalahan saat menyimpan category',
                    });
                }
            },
            complete: function() {
                // Re-enable button
                saveBtn.prop('disabled', false).html('<i class="bi bi-save me-1"></i> Save Category');
            }
        });
    });

    // Reset form saat modal ditutup
    $('#addCategoryModal').on('hidden.bs.modal', function() {
        $('#addCategoryForm')[0].reset();
        $('#category_name').removeClass('is-invalid is-valid');
        $('#category_code').removeClass('is-invalid is-valid');
        $('#category_name_error').text('');
        $('#category_code_error').text('');
        currentCategoryItemIndex = null;
    });

    // Handle Enter key di form modal
    $('#addCategoryForm').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            $('#saveCategoryBtn').click();
        }
    });

    // ============================================
    // BRAND MODAL FUNCTIONALITY
    // ============================================
    let currentBrandItemIndex = null;
    const addBrandModal = new bootstrap.Modal(document.getElementById('addBrandModal'));
    let codeCheckTimeout;

    // Event handler untuk tombol add brand
    $(document).on('click', '.btn-add-brand', function() {
        // Simpan index item yang sedang aktif
        currentBrandItemIndex = $(this).closest('.item-row').find('.brand-select').data('brand');

        // Reset form
        $('#addBrandForm')[0].reset();
        $('#brand_name').removeClass('is-invalid is-valid');
        $('#brand_code').removeClass('is-invalid is-valid');
        $('#name_error').text('');
        $('#code_error').text('');
        $('#code_success').text('Brand code tersedia!');

        // Tampilkan modal
        addBrandModal.show();
    });

    // Auto-uppercase untuk brand code
    $('#brand_code').on('input', function() {
        this.value = this.value.toUpperCase();
    });

    // Real-time check brand code saat user mengetik
    $('#brand_code').on('input', function() {
        const code = $(this).val().trim();
        const codeInput = $(this);

        // Clear timeout sebelumnya
        clearTimeout(codeCheckTimeout);

        if (code.length < 2) {
            codeInput.removeClass('is-invalid is-valid');
            $('#code_error').text('');
            return;
        }

        // Set timeout untuk menghindari terlalu banyak request
        codeCheckTimeout = setTimeout(function() {
            $.ajax({
                url: '{{ route("brand.check.code") }}',
                method: 'POST',
                data: {
                    code: code,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.exists) {
                        codeInput.removeClass('is-valid').addClass('is-invalid');
                        $('#code_error').text(response.message);
                    } else {
                        codeInput.removeClass('is-invalid').addClass('is-valid');
                        $('#code_error').text('');
                    }
                }
            });
        }, 500); // Delay 500ms
    });

    // Handle save brand
    $('#saveBrandBtn').click(function() {
        const name = $('#brand_name').val().trim();
        const code = $('#brand_code').val().trim();
        const saveBtn = $(this);

        // Reset validasi
        $('#brand_name').removeClass('is-invalid');
        $('#brand_code').removeClass('is-invalid');
        $('#name_error').text('');
        $('#code_error').text('');

        // Validasi client-side
        let hasError = false;

        if (!name) {
            $('#brand_name').addClass('is-invalid');
            $('#name_error').text('Brand name wajib diisi');
            hasError = true;
        }

        if (!code) {
            $('#brand_code').addClass('is-invalid');
            $('#code_error').text('Brand code wajib diisi');
            hasError = true;
        } else if (code.length < 2) {
            $('#brand_code').addClass('is-invalid');
            $('#code_error').text('Brand code minimal 2 karakter');
            hasError = true;
        }

        if (hasError) return;

        // Disable button dan tampilkan loading
        saveBtn.prop('disabled', true).html('<i class="bi bi-hourglass-split"></i> Saving...');

        // Kirim AJAX request
        $.ajax({
            url: '{{ route("brand.store.ajax") }}',
            method: 'POST',
            data: {
                name: name,
                code: code,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    // Tutup modal
                    addBrandModal.hide();

                    // Tampilkan success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });

                    // Tambahkan brand baru ke semua select brand
                    $('.brand-select').each(function() {
                        const selectElement = this;
                        const choicesInstance = choicesInstances.find(i => i.element === selectElement)?.instance;

                        if (choicesInstance) {
                            choicesInstance.setChoices([{
                                value: response.data.value,
                                label: response.data.label,
                                selected: false
                            }], 'value', 'label', false);
                        }
                    });

                    // Set brand yang baru ditambahkan ke item yang aktif
                    if (currentBrandItemIndex !== null) {
                        const targetSelect = $(`.brand-select[data-brand="${currentBrandItemIndex}"]`)[0];
                        const targetInstance = choicesInstances.find(i => i.element === targetSelect)?.instance;

                        if (targetInstance) {
                            targetInstance.setChoiceByValue(response.data.value.toString());
                        }
                    }

                    // Update global brand data
                    dataBrand.push({
                        value: response.data.value,
                        label: response.data.label
                    });
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;

                if (xhr.status === 422 && response.errors) {
                    // Validasi error dari server
                    if (response.errors.name) {
                        $('#brand_name').addClass('is-invalid');
                        $('#name_error').text(response.errors.name[0]);
                    }
                    if (response.errors.code) {
                        $('#brand_code').addClass('is-invalid');
                        $('#code_error').text(response.errors.code[0]);
                    }
                } else {
                    // Error lainnya
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: response?.message || 'Terjadi kesalahan saat menyimpan brand',
                    });
                }
            },
            complete: function() {
                // Re-enable button
                saveBtn.prop('disabled', false).html('<i class="bi bi-save"></i> Save Brand');
            }
        });
    });

    // Reset form saat modal ditutup
    $('#addBrandModal').on('hidden.bs.modal', function() {
        $('#addBrandForm')[0].reset();
        $('#brand_name').removeClass('is-invalid is-valid');
        $('#brand_code').removeClass('is-invalid is-valid');
        $('#name_error').text('');
        $('#code_error').text('');
        currentBrandItemIndex = null;
    });

    // Handle Enter key di form modal
    $('#addBrandForm').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            $('#saveBrandBtn').click();
        }
    });

});
</script>

@endsection
