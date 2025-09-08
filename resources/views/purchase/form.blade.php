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
                            <h5 class="card-title">Jasmin</h5>
                            <div class="row">
                                 <div class="col-md-6 col-12">
                                    <div class="form-group">
                                         <label for="tipe_order" class="form-label">Tipe Order</label>
                                        <select class="required choices form-select" id="tipe_order" name="tipe_order">

                                            <option value="">Press to select</option>
                                            <option value="01">Jasmin</option>
                                            <option value="02">Jastip Order</option>
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
                                        <select class="required choices form-select" id="customer" name="no_telp">
                                             <option value="custom">-- Custom / Buat Baru --</option>

                                            <option value="">Press to select</option>
                                            @if(isset($purchase))
                                                @foreach($customer as $customers)
                                                <option value="{{ $customers->id }}" {{ ($customers->whatsapp_number == $purchase->no_telp)? 'selected' : '' }}>{{$customers->whatsapp_number}} - {{$customers->display_name}}</option>
                                                @endforeach
                                            @else
                                                @foreach($customer as $customers)
                                                <option value="{{ $customers->whatsapp_number }}" >{{$customers->whatsapp_number}}  - {{$customers->display_name}}</option>
                                                @endforeach
                                            @endif
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
                                            <input type="text" class="form-control form-control-lg required" name="items[0][estimasi_harga]" placeholder="Rp">
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
                                            <input type="text" class="form-control form-control-lg required" name="items[0][jasakg]" placeholder="Rp. 325.000">
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
                                            <input type="text" class="form-control form-control-lg required" name="items[0][diskon]" placeholder="Rp">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label class="form-label">Total Estimasi</label>
                                            <input type="text" class="form-control form-control-lg required" name="items[0][total_estimasi]" placeholder="Rp">
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
@endsection

@section('scripts')

<script>
$(document).ready(function() {
    let itemCounter = $('#items-container .item-row').length;
    const customerOrders = @json($customerOrders);
    let selectedCustomerOrders = [];
    let choicesInstances = [];
    let currentCustomerId = null;

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
            // Submit form jika konfirmasi OK
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: $(this).serialize(),
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data berhasil disimpan',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = "{{ route('purchase.index') }}";
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat menyimpan data'
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
        initItemEvents(index);
        initializeChoices($(this).find('.customer-order-select')[0], index);
    });
       $('#customer').change(function() {
            const customerId = $(this).val();
            if(customerId) {
                $.get('/customers/' + customerId, function(data) {
                    $('#name').val(data.display_name ? data.display_name : "");
                    $('#email').val(data.email_address ? data.email_address  : "");
                    $('#address').val(data.address ? data.address  : "");
                    $('#no_telp').val(data.whatsapp_number ? data.whatsapp_number  : "");
                    // Fill other fields as needed
                });
            }
        });
    // Event change untuk customer select
    $('#customer').change(function() {
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
    function resetCustomerOrderSelects() {
        $('.customer-order-select').each(function() {
            const select = $(this)[0];
            const choicesInstance = choicesInstances.find(i => i.element === select)?.instance;

            if (choicesInstance) {
                choicesInstance.clearChoices();
                choicesInstance.setChoices(
                    customerOrders.map(order => ({
                        value: order.value,
                        label: order.label,
                        customProperties: order.customProperties
                    })),
                    'value',
                    'label',
                    false
                );
                choicesInstance.setValue(['']);
            }
        });
    }

    // Fungsi untuk inisialisasi Choices.js pada select element
    function initializeChoices(selectElement, index) {
        const existingInstance = choicesInstances.find(i => i.element === selectElement);
        if (existingInstance) {
            existingInstance.instance.destroy();
            choicesInstances = choicesInstances.filter(i => i.element !== selectElement);
        }

        // Get available orders (not selected or for current customer)
        const availableOrders = currentCustomerId
            ? customerOrders.filter(order =>
                order.customProperties.customer_id == currentCustomerId &&
                (!selectedCustomerOrders.includes(order.value) ||
                 order.value === $(selectElement).val()))
            : [];

        const customOption = {
            value: "custom",
            label: "-- Custom / Buat Baru --",
            customProperties: {}
        };

        const choices = new Choices(selectElement, {
            choices: [customOption, ...availableOrders],
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
        itemRow.find(`input[name="items[${index}][estimasi_harga]"]`).val(order.customProperties.total_harga || '');
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
        $('.customer-order-select').each(function() {
            const index = $(this).data('index');
            const currentValue = $(this).val();
            const choicesInstance = choicesInstances.find(i => i.element === this)?.instance;

            if (choicesInstance) {
                // Dapatkan order yang tersedia untuk customer saat ini
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

                // Simpan nilai yang sedang dipilih
                const currentSelection = choicesInstance.getValue(true);

                // Perbarui pilihan
                choicesInstance.clearChoices();
                choicesInstance.setChoices(
                    [customOption, ...availableOrders],
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
                        <input type="text" class="form-control form-control-lg required" name="items[${itemCounter}][estimasi_harga]" placeholder="Rp">
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
                        <input type="text" class="form-control form-control-lg required" name="items[${itemCounter}][jasakg]" placeholder="Rp. 325.000">
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
                        <input type="text" class="form-control form-control-lg required" name="items[${itemCounter}][diskon]" placeholder="Rp">
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label class="form-label">Total Estimasi</label>
                        <input type="text" class="form-control form-control-lg required" name="items[${itemCounter}][total_estimasi]" placeholder="Rp">
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
        initializeChoices(newSelect, itemCounter);
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
        const harga = parseFloat(itemRow.find('input[name="items[' + index + '][estimasi_harga]"]').val().replace(/[^\d.]/g, '')) || 0;
        const jasa = parseFloat(itemRow.find('input[name="items[' + index + '][jasakg]"]').val().replace(/[^\d.]/g, '')) || 0;
        const diskon = parseFloat(itemRow.find('input[name="items[' + index + '][diskon]"]').val().replace(/[^\d.]/g, '')) || 0;
        const qty = parseFloat(itemRow.find('input[name="items[' + index + '][quantity]"]').val().replace(/[^\d.]/g, '')) || 0;

        // Hitung asuransi (2% dari harga)
        const asuransi = harga * 0.02;
        itemRow.find('input[name="items[' + index + '][asuransi]"]').val(asuransi);

        // Hitung total
        const total = (harga * qty) + jasa + asuransi - diskon;
        itemRow.find('input[name="items[' + index + '][total_estimasi]"]').val(total);
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

    // Inisialisasi awal
    initLinkButtons();


});
</script>

@endsection
