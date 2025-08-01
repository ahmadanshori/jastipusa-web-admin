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
                                            <select class="choices form-select" disabled id="customer" name="no_telp">
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
                            <button type="button" class="btn btn-primary btn-sm float-end" id="add-item-btn">
                                <i class="bi bi-plus"></i> Add Item
                            </button>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div id="items-container">
                                    @foreach($purchaseOrderDetail as $index => $item)
                                    <div class="item-row row mb-3 border p-3 rounded">
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label class="form-label">Customer Order</label>
                                                <select class="choices form-select customer-order-select" disabled
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
                                            <button type="button" class="btn btn-danger btn-sm remove-item-btn">
                                                <i class="bi bi-trash"></i> Remove Item
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

            <div class="row">
                <div class="col-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary me-1 mb-1">Update</button>
                    <a href="{{ route('purchase.index') }}" class="btn btn-light-secondary me-1 mb-1">Cancel</a>
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
    $('#customer').change(function() {
        const customerId = $(this).val();
        if(customerId) {
            $.get('/customers/' + customerId, function(data) {
                $('#name').val(data.display_name ? data.display_name : "-");
                $('#email').val(data.email_address ? data.email_address  : "-");
                $('#address').val(data.address ? data.address  : "-");
                // Fill other fields as needed
            });
        }
    });

    const customerOrders = @json($customerOrders);
    const customerOrdersJson = JSON.parse('{!! addslashes($customerOrdersJson) !!}');
    
    let choicesInstances = [];
    let itemCounter = $('#items-container .item-row').length;

    // Fungsi untuk mengisi data customer
    $('#customer').change(function() {
        const customerId = $(this).val();
        if (customerId) {
            const selectedCustomer = customerOrders.find(c => c.value == customerId);
            if (selectedCustomer) {
                $('#name').val(selectedCustomer.customProperties.display_name || '-');
                $('#email').val(selectedCustomer.customProperties.email || '-');
                $('#address').val(selectedCustomer.customProperties.address || '-');
            }
        }
    });

    // Fungsi untuk menginisialisasi Choices
    function initializeChoices(selectElement, index) {
        const selectedValue = $(selectElement).data('selected');
        
        const choices = new Choices(selectElement, {
            choices: customerOrdersJson,
            searchEnabled: true,
            shouldSort: false,
            itemSelectText: '',
            classNames: {
                containerInner: 'choices__inner form-select'
            },
            callbackOnInit: function() {
                if (selectedValue) {
                    this.setChoiceByValue(selectedValue);
                    autoFillItem(index, selectedValue);
                }
            }
        });

        choicesInstances.push({
            element: selectElement,
            instance: choices
        });

        return choices;
    }

    // Fungsi untuk auto-fill data
    function autoFillItem(index, customerOrderId) {
        const order = customerOrders.find(o => o.value == customerOrderId);
        if (!order) return;

        const itemRow = $(`.item-row [data-index="${index}"]`).closest('.item-row');
        itemRow.find(`input[name="items[${index}][no_po_customer]"]`).val(order.customProperties.po_number);
        itemRow.find(`input[name="items[${index}][nama_barang]"]`).val(order.customProperties.nama_barang);
        itemRow.find(`input[name="items[${index}][link_barang]"]`).val(order.customProperties.link_product);
        itemRow.find(`input[name="items[${index}][estimasi_kg]"]`).val(order.customProperties.jumlah_berat);
        itemRow.find(`input[name="items[${index}][estimasi_harga]"]`).val(order.customProperties.total_harga);
    }

    // Inisialisasi Choices untuk select yang sudah ada
    $('.customer-order-select').each(function() {
        // initializeChoices(this, $(this).data('index'));
    });

    // Event listener untuk perubahan select
    $('#items-container').on('change', '.customer-order-select', function() {
        const index = $(this).data('index');
        const selectedValue = $(this).val();
        autoFillItem(index, selectedValue);
    });

    // Tambah item baru
    $('#add-item-btn').click(function() {
        const newItemHtml = `
            <div class="item-row row mb-3 border p-3 rounded">
                <div class="col-md-12 col-12">
                    <div class="form-group">
                        <label class="form-label">Customer Order</label>
                        <select class="form-select customer-order-select" name="items[${itemCounter}][customer_order_id]" data-index="${itemCounter}">
                            <option value="">Select Customer Order</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="form-group">
                        <label class="form-label">No. PO Customer</label>
                        <input type="text" class="form-control" name="items[${itemCounter}][no_po_customer]" readonly>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="form-group">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" name="items[${itemCounter}][nama_barang]">
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="form-group">
                        <label class="form-label">Link Barang</label>
                        <input type="text" class="form-control" name="items[${itemCounter}][link_barang]">
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label class="form-label">Estimasi Kg</label>
                        <input type="text" class="form-control" name="items[${itemCounter}][estimasi_kg]">
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label class="form-label">Estimasi Harga</label>
                        <input type="text" class="form-control" name="items[${itemCounter}][estimasi_harga]">
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
        itemCounter++;
    });

    // Hapus item
    $('#items-container').on('click', '.remove-item-btn', function() {
        if ($('#items-container .item-row').length > 1) {
            const itemRow = $(this).closest('.item-row');
            const selectElement = itemRow.find('.customer-order-select')[0];
            
            // Hancurkan instance Choices sebelum menghapus
            const instanceIndex = choicesInstances.findIndex(i => i.element === selectElement);
            if (instanceIndex !== -1) {
                choicesInstances[instanceIndex].instance.destroy();
                choicesInstances.splice(instanceIndex, 1);
            }
            
            itemRow.remove();
            reindexItems();
        } else {
            alert('You must have at least one item.');
        }
    });

    // Fungsi untuk re-index
    function reindexItems() {
        let newIndex = 0;
        $('#items-container .item-row').each(function() {
            $(this).find('input, select').each(function() {
                const name = $(this).attr('name').replace(/items\[\d+\]/, `items[${newIndex}]`);
                $(this).attr('name', name);
            });
            
            const selectElement = $(this).find('.customer-order-select')[0];
            $(selectElement).attr('data-index', newIndex);
            
            // Update instance Choices jika ada
            const instance = choicesInstances.find(i => i.element === selectElement);
            if (instance) {
                instance.instance.setValue([$(selectElement).val()]);
            }
            
            newIndex++;
        });
        
        itemCounter = newIndex;
    }
});
</script>
@endsection