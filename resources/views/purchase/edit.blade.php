@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-first">
                <h3>Edit Purchase Order</h3>
                <p class="text-subtitle text-muted">Edit Purchase Order Detail</p>
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
                                     <div class="row">
                                 <div class="col-md-6 col-12">
                                    <div class="form-group">
                                         <label for="tipe_order" class="form-label">Tipe Order</label>
                                        <select class="required choices form-select" id="tipe_order" name="tipe_order" readonly>
                                            
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
                                        <select class="required choices form-select" id="customer" name="no_telp">
                                             <option value="custom">-- Custom / Buat Baru --</option>
                                            
                                            <option value="">Press to select</option>
                                            @foreach($customers as $customer)
                                                <option value="{{ $customer->whatsapp_number }}" 
                                                    {{ $purchase->no_telp === $customer->whatsapp_number ? 'selected' : '' }}>
                                                    {{ $customer->whatsapp_number }} - {{ $customer->display_name }}
                                                </option>
                                                @endforeach
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
                                        <input type="text" id="name" class="form-control form-control-lg required" readonly value="{{ (isset($purchase->nama)? $purchase->nama:old('nama')) }}"  name="nama">
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
                                        <input type="text" id="email" class="form-control form-control-lg required" readonly value="{{ (isset($purchase->email)? $purchase->email:old('email')) }}"  name="email">
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
                                        <input type="text" id="no_telp" class="form-control form-control-lg required" readonly value="{{ (isset($purchase->no_telp)? $purchase->no_telp:old('no_telp')) }}"  name="phone">
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
                                        <input type="text" id="address" class="form-control form-control-lg required" readonly value="{{ (isset($purchase->alamat)? $purchase->alamat:old('alamat')) }}"  name="alamat">
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
                                  <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label class="form-label">Customer Order</label>
                                          
                                            <select class="choices form-select customer-order-select" 
                                                    name="items[{{ $index }}][customer_order_id]" 
                                                    data-index="{{ $index }}"
                                                    data-selected="{{ $item->no_po }}">
                                                    <option value="">Select Customer Order</option>
                                                    <option value="{{ $item->no_po }}" selected>{{ $item->no_po }}</option>
                                                </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label class="form-label">Quantity</label>
                                            <input type="text" value="{{ old("items.$index.quantity", $item->qty) }}" class="form-control form-control-lg required" name="items[{{$index}}][quantity]">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label class="form-label">Notes</label>
                                            <input type="text" value="{{ old("items.$index.estimasi_notes", $item->estimasi_notes) }}" class="form-control form-control-lg required" name="items[{{$index}}][estimasi_notes]">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label class="form-label">No. PO Customer</label>
                                            <input type="text" value="{{ old("items.$index.no_po_customer", $item->no_po) }}" class="form-control form-control-lg required" name="items[{{$index}}][no_po_customer]">
                                        </div>
                                    </div>
                                      <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label class="form-label">Harga Barang</label>
                                            <input type="text" class="form-control form-control-lg required" value="{{ old("items.$index.estimasi_harga", number_format($item->estimasi_harga,0,'','')) }}" name="items[{{$index}}][estimasi_harga]">
                                        </div>
                                    </div>
                                     <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label class="form-label">Estimasi Kg</label>
                                            <input type="text" class="form-control form-control-lg required" value="{{ old("items.$index.estimasi_kg", $item->estimasi_kg) }}" name="items[{{$index}}][estimasi_kg]">
                                        </div>
                                    </div>
                                  
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label class="form-label">Nama Barang</label>
                                            <input type="text" class="form-control form-control-lg required" name="items[{{$index}}][nama_barang]" value="{{ old("items.$index.nama_barang", $item->nama_barang) }}">
                                        </div>
                                    </div>
                                     <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label class="form-label">Asuransi 2%</label>
                                            <input type="text" class="form-control form-control-lg required" name="items[{{$index}}][asuransi]" value="{{ old("items.$index.asuransi", number_format($item->asuransi,0,'','')) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label class="form-label">Jasa Kg</label>
                                            <input type="text" class="form-control form-control-lg required" name="items[{{$index}}][jasakg]" value="{{ old("items.$index.jasakg", number_format($item->jasakg,0,'','')) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        
                                         <div class="form-group">
                                            <label class="form-label">Link Barang</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-lg required link-input"
                                                    name="items[{{$index}}][link_barang]" value="{{ old("items.$index.link_barang", $item->link_barang) }}">
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
                                            <input type="text" class="form-control form-control-lg required" value="{{ old("items.$index.diskon", number_format($item->diskon,0,'','')) }}" name="items[{{$index}}][diskon]">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label class="form-label">Total Estimasi</label>
                                            <input type="text" class="form-control form-control-lg required" name="items[{{$index}}][total_estimasi]" value="{{ old("items.$index.total_estimasi", number_format($item->total_estimasi,0,'','')) }}">
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
     let currentCustomerId = null;
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

     $('.item-row').each(function() {
        const index = $(this).find('.customer-order-select').data('index');
        initItemEvents(index);
        initializeChoices($(this).find('.customer-order-select')[0], index);
    });
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
        const tipeOrder = $('#tipe_order').val();
        
        const customOption = {
            value: "custom",
            label: "-- Custom / Buat Baru --",
            selected: true,
            customProperties: {}
        };
        let choicesData = [];
        if (tipeOrder === "01") { 
            choicesData = customerOrdersJson
        }else{
            choicesData = [customOption]
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

    // function initializeChoices(selectElement, index) {
    //     const tipeOrder = $('#tipe_order').val();

    //     const existingInstance = choicesInstances.find(i => i.element === selectElement);
    //     if (existingInstance) {
    //         existingInstance.instance.destroy();
    //         choicesInstances = choicesInstances.filter(i => i.element !== selectElement);
    //     }

    //     // Get available orders (not selected or for current customer)
    //      let choicesData = [];
    //             // Dapatkan order yang tersedia untuk customer saat ini
    //          const customOption = {
    //             value: "custom",
    //             label: "-- Custom / Buat Baru --",
    //             selected: true,
    //             customProperties: {}
    //         };
    //     if (tipeOrder === "01") { 
    //         const availableOrders = currentCustomerId
    //             ? customerOrders.filter(order =>
    //                 order.customProperties.customer_id == currentCustomerId &&
    //                 (!selectedCustomerOrders.includes(order.value) ||
    //                 order.value === $(selectElement).val()))
    //             : [];

          
    //         choicesData = [customerOrdersJson];
    //     }else{
    //         choicesData = [customOption];
    //     }

    //     const choices = new Choices(selectElement, {
    //         choices: choicesData,
    //         searchEnabled: true,
    //         shouldSort: false,
    //         itemSelectText: '',
    //         classNames: {
    //             containerInner: 'choices__inner form-select'
    //         },
    //         callbackOnInit: function() {
    //             const selectedValue = $(selectElement).val();
    //             if (selectedValue && !selectedCustomerOrders.includes(selectedValue) && selectedValue !== "custom") {
    //                 selectedCustomerOrders.push(selectedValue);
    //              this.setChoiceByValue(selectedValue);
    //                 autoFillItem(index, selectedValue);
    //             }
               
    //         },
    //         shouldSortItems: function() {
    //             return false;
    //         }
    //     });

    //     choicesInstances.push({
    //         element: selectElement,
    //         instance: choices
    //     });

    //     return choices;
    // }

    // Fungsi untuk auto-fill data
    function autoFillItem(index, customerOrderId) {
        const order = customerOrders.find(o => o.value == customerOrderId);
        if (!order) return;

        const itemRow = $(`.item-row [data-index="${index}"]`).closest('.item-row');
        itemRow.find(`input[name="items[${index}][no_po_customer]"]`).val(order.customProperties.po_number || '');
        itemRow.find(`input[name="items[${index}][nama_barang]"]`).val(order.customProperties.nama_barang || '');
        itemRow.find(`input[name="items[${index}][link_barang]"]`).val(order.customProperties.link_product || '');
        itemRow.find(`input[name="items[${index}][estimasi_notes]"]`).val(order.customProperties.jumlah_berat || '');
        itemRow.find(`input[name="items[${index}][estimasi_harga]"]`).val(order.customProperties.total_harga || '');
        itemRow.find(`input[name="items[${index}][quantity]"]`).val('1');

        calculateTotals(index);
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
                        <input type="text" class="form-control form-control-lg required" name="items[${itemCounter}][quantity]">
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label class="form-label">Notes</label>
                        <input type="text" class="form-control form-control-lg required" name="items[${itemCounter}][estimasi_notes]">
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="form-group">
                        <label class="form-label">No. PO Customer</label>
                        <input type="text" readonly class="form-control form-control-lg required" name="items[${itemCounter}][no_po_customer]">
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label class="form-label">Harga Barang</label>
                        <input type="text" class="form-control form-control-lg required" name="items[${itemCounter}][estimasi_harga]">
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label class="form-label">Estimasi Kg</label>
                        <input type="text" class="form-control form-control-lg required" name="items[${itemCounter}][estimasi_kg]">
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="form-group">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" class="form-control form-control-lg required" name="items[${itemCounter}][nama_barang]">
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label class="form-label">Asuransi 2%</label>
                        <input type="text" readonly class="form-control form-control-lg required" name="items[${itemCounter}][asuransi]">
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label class="form-label">Jasa Kg</label>
                        <input type="text" class="form-control form-control-lg required" name="items[${itemCounter}][jasakg]">
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="form-group">
                        <label class="form-label">Link Barang</label>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-lg required link-input" name="items[${itemCounter}][link_barang]">
                            <button class="btn btn-outline-primary btn-open-link" type="button">
                                <i class="bi bi-box-arrow-up-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label class="form-label">Diskon</label>
                        <input type="text" class="form-control form-control-lg required" name="items[${itemCounter}][diskon]">
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label class="form-label">Total Estimasi</label>
                        <input type="text" class="form-control form-control-lg required" name="items[${itemCounter}][total_estimasi]">
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

     function calculateTotals(index) {
        const itemRow = $(`[data-index="${index}"]`).closest('.item-row');
        const harga = parseFloat(itemRow.find('input[name="items[' + index + '][estimasi_harga]"]').val().replace(/[^\d.]/g, '')) || 0;
        const jasa = parseFloat(itemRow.find('input[name="items[' + index + '][jasakg]"]').val().replace(/[^\d.]/g, '')) || 0;
        const diskon = parseFloat(itemRow.find('input[name="items[' + index + '][diskon]"]').val().replace(/[^\d.]/g, '')) || 0;
        const qty = parseFloat(itemRow.find('input[name="items[' + index + '][quantity]"]').val().replace(/[^\d.]/g, '')) || 0;
        
        // Hitung asuransi (2% dari harga)
        const asuransi = harga * qty * 0.02;
        itemRow.find('input[name="items[' + index + '][asuransi]"]').val(asuransi);
        
        // Hitung total
        const total = (harga * qty) + jasa + asuransi - diskon;
        itemRow.find('input[name="items[' + index + '][total_estimasi]"]').val(total);
    }

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
});
</script>
@endsection