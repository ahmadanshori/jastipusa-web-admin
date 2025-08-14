@extends('layouts.app')

@section('content')
{{-- <div class="page-heading">
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
                        <li class="breadcrumb-item active" aria-current="page">{{ (isset($purchase)? 'Edit
                            Purchase Order':'Add Purchase Order') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
         @if(isset($purchase))

        <form class="form" method="POST" action="{{route('purchase.update', $purchase->id)}}"
            enctype="multipart/form-data">
            {{ method_field('PUT') }}
            @else
        <form class="form" method="POST" action="{{route('purchase.store')}}"
                enctype="multipart/form-data">
                @endif
                @csrf

            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <h5 class="card-title">Jasmin</h5>
                            <div class="row">

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                         <label for="customer" class="form-label">Customer</label>
                                        <select class="choices form-select" id="customer" name="no_telp">
                                            <option value="">Press to select</option>
                                            @if(isset($purchase))
                                                @foreach($customer as $customers)
                                                <option value="{{ $customers->id }}" {{ ($customers->whatsapp_number == $purchase->no_telp)? 'selected' : '' }}>{{$customers->whatsapp_number}}</option>
                                                @endforeach
                                            @else
                                                @foreach($customer as $customers)
                                                <option value="{{ $customers->whatsapp_number }}" >{{$customers->whatsapp_number}}</option>
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
                                    <div class="form-group mandatory">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" id="name" class="form-control form-control-lg"  value="{{ (isset($purchase->nama)? $purchase->nama:old('nama')) }}"  name="nama">
                                    </div>
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="text" id="email" class="form-control form-control-lg"  value="{{ (isset($purchase->email)? $purchase->email:old('email')) }}"  name="email">
                                    </div>
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                  <div class="col-md-12 col-12">
                                    <div class="form-group mandatory">
                                        <label for="name" class="form-label">Alamat</label>
                                        <input type="text" id="address" class="form-control form-control-lg"  value="{{ (isset($purchase->alamat)? $purchase->alamat:old('alamat')) }}"  name="alamat">
                                    </div>
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                 <div class="col-md-6 col-12">
                                    <div class="form-group">
                                         <label for="no_po" class="form-label">Customer Order</label>
                                        <select class="choices form-select" id="customer-order" name="no_po">
                                            <option value="">Press to select</option>
                                            @if(isset($purchase))
                                                @foreach($customerOrder as $customers)
                                                <option value="{{ $customers->po_number }}" {{ ($customers->po_number == $purchase->no_po)? 'selected' : '' }}>{{$customers->po_number}}</option>
                                                @endforeach
                                            @else
                                                @foreach($customerOrder as $customers)
                                                <option value="{{ $customers->po_number }}">{{$customers->po_number}}</option>
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
                                    <div class="form-group mandatory">
                                        <label for="name" class="form-label">Nama Barang</label>
                                        <input type="text" id="nama_barang" class="form-control form-control-lg"  value="{{ (isset($purchase->nama_barang)? $purchase->nama_barang:old('nama_barang')) }}"  name="nama_barang">
                                    </div>
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-md-12 col-12">
                                    <div class="form-group mandatory">
                                        <label for="name" class="form-label">Link barang</label>
                                        <input type="text" id="link_barang" class="form-control form-control-lg"  value="{{ (isset($purchase->link_barang)? $purchase->link_barang:old('link_barang')) }}"  name="link_barang">
                                    </div>
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                  <div class="col-md-6 col-12">
                                    <div class="form-group mandatory">
                                        <label for="name" class="form-label">Estimasi Kg</label>
                                        <input type="text" id="estimasi_kg" class="form-control form-control-lg"  value="{{ (isset($purchase->estimasi_kg)? $purchase->estimasi_kg:old('estimasi_kg')) }}"  name="estimasi_kg">
                                    </div>
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory">
                                        <label for="name" class="form-label">Estimasi Harga</label>
                                        <input type="text" id="estimasi_harga" class="form-control form-control-lg"  value="{{ (isset($purchase->estimasi_harga)? $purchase->estimasi_harga:old('estimasi_harga')) }}"  name="estimasi_harga">
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
   @if(isset($purchase))
             <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <h5 class="card-title">Perkiraan/Estimasi</h5>
                            <div class="row">

                                

                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory">
                                        <label for="name" class="form-label">Name Rek Transfer</label>
                                        <input type="text" id="name" class="form-control form-control-lg"   name="nama">
                                    </div>
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory">
                                        <label for="email" class="form-label">Jumlah Transfer</label>
                                        <input type="text" id="email" class="form-control form-control-lg"    name="email">
                                    </div>
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                  <div class="col-md-12 col-12">
                                    <div class="form-group mandatory">
                                        <label for="name" class="form-label">DP</label>
                                        <input type="text" id="address" class="form-control form-control-lg"    name="alamat">
                                    </div>
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                  <div class="col-md-12 col-12">
                                    <div class="form-group mandatory">
                                        <label for="name" class="form-label">Full Payment</label>
                                        <input type="text" id="address" class="form-control form-control-lg"    name="alamat">
                                    </div>
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                 <div class="col-md-6 col-12">
                                    <div class="form-group">
                                         <label for="no_po" class="form-label">Status Follow Up</label>
                                        <select class="choices form-select" id="customer-order" name="no_po">
                                            <option value="">Press to select</option>
                                                <option value="Schedulled">Schedulled</option>
                                                <option value="Followed">Followed</option>
                                                <option value="Unfollowed">Unfollowed</option>
                                              
                                        </select>
                                    </div>
                                    @error('publish_at')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                   <div class="col-md-6 col-12">
                                    <div class="form-group mandatory">
                                        <label for="name" class="form-label">Foto Bukti Transfer</label>
                                        <input type="file" id="nama_barang" class="form-control form-control-lg" name="nama_barang">
                                    </div>
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                  <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="btn_status" class="form-label">Mutasi Check</label>
                                            <br>
                                            <input id="btn_status" type="checkbox" data-onstyle="info"
                                                data-toggle="toggle" data-on="Active" data-off="Not Active"
                                                data-offstyle="secondary" data-width="200" data-height="45">
                                            <input type="hidden" id="status" name="status_publish" value="false">

                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


             <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <h5 class="card-title">HPP</h5>
                            <div class="row">

                                

                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory">
                                        <label for="name" class="form-label">Payment Method</label>
                                        <input type="text" id="name" class="form-control form-control-lg" name="nama">
                                    </div>
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory">
                                        <label for="email" class="form-label">Total Purchase</label>
                                        <input type="text" id="email" class="form-control form-control-lg" name="email">
                                    </div>
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>


                                 <div class="col-md-6 col-12">
                                    <div class="form-group">
                                         <label for="no_po" class="form-label">Status Purchase</label>
                                        <select class="choices form-select" id="customer-order" name="no_po">
                                            <option value="">Press to select</option>
                                                <option value="Schedulled">Wait For Order</option>
                                                <option value="Followed">Ordered</option>
                                                <option value="Unfollowed">Failed Order</option>
                                              
                                        </select>
                                    </div>
                                    @error('publish_at')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                 <div class="col-md-6 col-12">
                                    <div class="form-group mandatory">
                                        <label for="email" class="form-label">Notes</label>
                                        <input type="text" id="email" class="form-control form-control-lg" name="email">
                                    </div>
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                   <div class="col-md-6 col-12">
                                    <div class="form-group mandatory">
                                        <label for="name" class="form-label">Foto Bukti Pembelian</label>
                                        <input type="file" id="nama_barang" class="form-control form-control-lg" name="nama_barang">
                                    </div>
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                  <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="btn_status" class="form-label">Mutasi Check</label>
                                            <br>
                                            <input id="btn_status" type="checkbox" data-onstyle="info"
                                                data-toggle="toggle" data-on="Active" data-off="Not Active"
                                                data-offstyle="secondary" data-width="200" data-height="45">
                                            <input type="hidden" id="status" name="status_publish" value="false">

                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <h5 class="card-title">Oprasional</h5>
                            <div class="row">

                                
                                   <div class="col-md-6 col-12">
                                    <div class="form-group mandatory">
                                        <label for="name" class="form-label">WH USA</label>
                                        <input type="file" id="nama_barang" class="form-control form-control-lg" name="nama_barang">
                                    </div>
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                  <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="btn_status" class="form-label">Mutasi Check</label>
                                            <br>
                                            <input id="btn_status" type="checkbox" data-onstyle="info"
                                                data-toggle="toggle" data-on="Active" data-off="Not Active"
                                                data-offstyle="secondary" data-width="200" data-height="45">
                                            <input type="hidden" id="status" name="status_publish" value="false">

                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                    <div class="form-group mandatory">
                                        <label for="name" class="form-label">WH Indo</label>
                                        <input type="file" id="nama_barang" class="form-control form-control-lg" name="nama_barang">
                                    </div>
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory">
                                        <label for="name" class="form-label">Fix Weight</label>
                                        <input type="text" id="name" class="form-control form-control-lg" name="nama">
                                    </div>
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory">
                                        <label for="email" class="form-label">Fix Price</label>
                                        <input type="text" id="email" class="form-control form-control-lg" name="email">
                                    </div>
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>


                                 <div class="col-md-6 col-12">
                                    <div class="form-group">
                                         <label for="no_po" class="form-label">Status Barang Sampai</label>
                                        <select class="choices form-select" id="customer-order" name="no_po">
                                            <option value="">Press to select</option>
                                                <option value="Schedulled">Waiting Courier</option>
                                                <option value="Followed">Received</option>
                                                <option value="Unfollowed">Cancel</option>
                                              
                                        </select>
                                    </div>
                                    @error('publish_at')
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
@endif
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
    $('#btn_status').change(function() {
        $('#status').val($(this).prop('checked'))
    });

   $('#customer').change(function() {
        const customerId = $(this).val();
        if(customerId) {
            $.get('/customers/' + customerId, function(data) {
                $('#name').val(data.display_name ? data.display_name : "-");
                $('#email').val(data.email ? data.email  : "-");
                $('#address').val(data.address ? data.address  : "-");
                // Fill other fields as needed
            });
        }
    });

     $('#customer-order').change(function() {
        const customerId = $(this).val();
        if(customerId) {
            $.get('/customer-orders/' + customerId, function(data) {
                $('#nama_barang').val(data.link_product ? data.link_product : "-");
                $('#link_barang').val(data.link_product ? data.link_product  : "-");
                $('#estimasi_kg').val(data.jumlah_berat ? data.jumlah_berat  : "-");
                $('#estimasi_harga').val(data.jumlah_berat ? data.jumlah_berat  : "-");
                // Fill other fields as needed
            });
        }
    });

    $('#datetimepicker1').datetimepicker({
    format: 'YYYY-MM-DD HH:mm:ss',
    icons: {
      time: "fa fa-clock",
      date: "fa fa-calendar-day",
      up: "fa fa-chevron-up",
      down: "fa fa-chevron-down",
      previous: 'fa fa-chevron-left',
      next: 'fa fa-chevron-right',
      today: 'fa fa-screenshot',
      clear: 'fa fa-trash',
      close: 'fa fa-remove'
    }
  });

</script> --}}


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
                                    <div class="form-group mandatory">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" id="name" class="form-control form-control-lg required"  value="{{ (isset($purchase->nama)? $purchase->nama:old('nama')) }}"  name="nama">
                                    </div>
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="text" id="email" class="form-control form-control-lg required"  value="{{ (isset($purchase->email)? $purchase->email:old('email')) }}"  name="email">
                                    </div>
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                  <div class="col-md-12 col-12">
                                    <div class="form-group mandatory">
                                        <label for="name" class="form-label">Alamat</label>
                                        <input type="text" id="address" class="form-control form-control-lg required"  value="{{ (isset($purchase->alamat)? $purchase->alamat:old('alamat')) }}"  name="alamat">
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
                                  <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label class="form-label">Customer Order</label>
                                            <select class="required form-select customer-order-select" name="items[0][customer_order_id]" data-index="0">
                                          
                                               
                                                <option value="">Select Customer Order</option>
                                                <!-- Options akan diisi oleh Choices.js -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label class="form-label">No. PO Customer</label>
                                            <input type="text" class="form-control required" name="items[0][no_po_customer]">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label class="form-label">Nama Barang</label>
                                            <input type="text" class="form-control required" name="items[0][nama_barang]">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        
                                         <div class="form-group">
                                            <label class="form-label">Link Barang</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control required link-input"
                                                    name="items[0][link_barang]">
                                                <button class="btn btn-outline-primary btn-open-link"
                                                    type="button">
                                                    <i class="bi bi-box-arrow-up-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label class="form-label">Estimasi Kg</label>
                                            <input type="text" class="form-control required" name="items[0][estimasi_kg]">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label class="form-label">Estimasi Harga</label>
                                            <input type="text" class="form-control required" name="items[0][estimasi_harga]">
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
    // Inisialisasi data customer order dari controller
initLinkButtons();

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

       $('#customer').change(function() {
            const customerId = $(this).val();
            if(customerId) {
                $.get('/customers/' + customerId, function(data) {
                    $('#name').val(data.display_name ? data.display_name : "");
                    $('#email').val(data.email_address ? data.email_address  : "");
                    $('#address').val(data.address ? data.address  : "");
                    // Fill other fields as needed
                });
            }
        });

       
    let currentCustomerId = null;
let selectedCustomerOrders = [];
   const customerOrders = [...new Map(@json($customerOrders).map(item => [item.value, item])).values()];
    const customerOrdersJson = JSON.parse('{!! addslashes($customerOrdersJson) !!}');
    let choicesInstances = [];
    let itemCounter = $('#items-container .item-row').length;

      const customerSelect = document.getElementById('customer');
    const customerChoicesInstance = new Choices(customerSelect, {
        searchEnabled: true,
        shouldSort: false,
        itemSelectText: '',
        classNames: {
            containerInner: 'choices__inner form-select'
        }
    });
       $('#customer').change(function() {
        currentCustomerId = $(this).val();
        selectedCustomerOrders = []; // Reset selected orders
        
        if (currentCustomerId) {
            // Filter and update all customer order selects
            filterCustomerOrders(currentCustomerId);
            
            // Clear all item forms
            $('.item-row').each(function() {
                const index = $(this).find('.customer-order-select').data('index');
                resetItemForm(index);
            });
        } else {
            // Reset all selects if no customer selected
            resetCustomerOrderSelects();
        }
    });

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

 function filterCustomerOrders(customerId) {
        resetAllItems();
        const filteredOrders = customerOrders.filter(order => 
            order.customProperties.customer_id == customerId
        );

        // Update all existing selects
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

                // Restore selection if still valid
                if (currentValue && filteredOrders.some(o => o.value == currentValue)) {
                    choicesInstance.setValue([currentValue]);
                    selectedCustomerOrders.push(currentValue);
                } else {
                    $(this).val('').trigger('change');
                }
            }
        });
    }
    
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
    // Fungsi untuk menginisialisasi Choices
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
    // Fungsi untuk auto-fill data
   function autoFillItem(index, customerOrderId) {
    // Reset form terlebih dahulu
    resetItemForm(index);
    
    const customerOrders = @json($customerOrders);
    const order = customerOrders.find(o => o.value == customerOrderId);
    if (!order) return;
    const itemRow = $(`.item-row [data-index="${index}"]`).closest('.item-row');
    itemRow.find(`input[name="items[${index}][no_po_customer]"]`).val(order.customProperties.po_number || '');
    itemRow.find(`input[name="items[${index}][nama_barang]"]`).val(order.customProperties.nama_barang || '');
    itemRow.find(`input[name="items[${index}][link_barang]"]`).val(order.customProperties.link_product || '');
    itemRow.find(`input[name="items[${index}][estimasi_kg]"]`).val(order.customProperties.jumlah_berat || '');
    itemRow.find(`input[name="items[${index}][estimasi_harga]"]`).val(order.customProperties.total_harga || '');
initLinkButtons();

}

    // Inisialisasi Choices untuk elemen yang sudah ada
    $('.customer-order-select').each(function() {
        initializeChoices(this, $(this).data('index'));
    });
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
    // Event listener untuk perubahan select
 $('#items-container').on('change', '.customer-order-select', function() {
        const index = $(this).data('index');
        const selectedValue = $(this).val();
        const previousValue = $(this).data('prev-value') || '';
        const choicesInstance = choicesInstances.find(i => i.element === this)?.instance;

        // Remove previous value from tracking
        if (previousValue && previousValue !== "custom" && selectedCustomerOrders.includes(previousValue)) {
            selectedCustomerOrders = selectedCustomerOrders.filter(v => v !== previousValue);
        }
        
         if (selectedValue === "custom") {
            // Reset form untuk custom input
            resetItemForm(index);
            $(`input[name="items[${index}][no_po_customer]"]`).prop('readonly', false);
            $(`input[name="items[${index}][nama_barang]"]`).prop('readonly', false);
            return;
        }
        // Check for duplicate selection
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
            
            // Add to selected orders and auto-fill
            selectedCustomerOrders.push(selectedValue);
            $(this).data('prev-value', selectedValue);
            autoFillItem(index, selectedValue);
        } else {
            resetItemForm(index);
        }
        
        // Refresh all selects to update available options
        refreshAllSelects();
    });

    // Tambah item baru
    $('#add-item-btn').click(function() {
    const newItemHtml = `
        <div class="item-row row mb-3 border p-3 rounded">
            <div class="col-md-12 col-12">
                <div class="form-group">
                    <label class="form-label">Customer Order</label>
                    <select class="form-select customer-order-select required" name="items[${itemCounter}][customer_order_id]" data-index="${itemCounter}">
                        <option value="">Select Customer Order</option>
                    </select>
                </div>
            </div>
             <div class="col-md-6 col-12">
                    <div class="form-group">
                        <label class="form-label">No. PO Customer</label>
                        <input type="text" class="form-control required" name="items[${itemCounter}][no_po_customer]" readonly>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="form-group">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" class="form-control required" name="items[${itemCounter}][nama_barang]">
                    </div>
                </div>
                <div class="col-md-6 col-12">
                   
                    <div class="form-group">
                        <label class="form-label">Link Barang</label>
                        <div class="input-group">
                            <input type="text" class="form-control required link-input"
                                name="items[${itemCounter}][link_barang]">
                            <button class="btn btn-outline-primary btn-open-link"
                                type="button">
                                <i class="bi bi-box-arrow-up-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label class="form-label">Estimasi Kg</label>
                        <input type="text" class="form-control required" name="items[${itemCounter}][estimasi_kg]">
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label class="form-label">Estimasi Harga</label>
                        <input type="text" class="form-control required" name="items[${itemCounter}][estimasi_harga]">
                    </div>
                </div>
                <div class="col-md-12 col-12 text-end">
                    <button type="button" class="btn btn-danger btn-sm remove-item-btn">
                        <i class="bi bi-trash"></i> Remove Item
                    </button>
                </div>
            </div>
        </div>
    `;

    $('#items-container').append(newItemHtml);
    const newSelect = $(`[data-index="${itemCounter}"]`)[0];
    initializeChoices(newSelect, itemCounter);
    
    // Reset form untuk item yang baru ditambahkan
    resetItemForm(itemCounter);
    
    itemCounter++;
});

    // Hapus item
  $('#items-container').on('click', '.remove-item-btn', function() {
    if ($('#items-container .item-row').length > 1) {
        const itemRow = $(this).closest('.item-row');
        const selectElement = itemRow.find('.customer-order-select')[0];
        const selectedValue = $(selectElement).val();
        
        // 1. Hapus dari daftar yang dipilih jika ada nilai
        if (selectedValue && selectedCustomerOrders.includes(selectedValue)) {
            selectedCustomerOrders = selectedCustomerOrders.filter(v => v !== selectedValue);
        }
        
        // 2. Hancurkan instance Choices sebelum menghapus
        const instanceIndex = choicesInstances.findIndex(i => i.element === selectElement);
        if (instanceIndex !== -1) {
            choicesInstances[instanceIndex].instance.destroy();
            choicesInstances.splice(instanceIndex, 1);
        }
        
        // 3. Hapus baris item
        itemRow.remove();
        
        // 4. Re-index item yang tersisa
        reindexItems();
        
        // 5. Refresh semua select untuk mengembalikan opsi yang dihapus
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

    // Fungsi untuk re-index
    function fillCustomerFromOrder(customerOrderId) {
        const order = customerOrders.find(o => o.value == customerOrderId);
        if (order && order.customProperties.customer_id) {
            $('#customer').val(order.customProperties.customer_id).trigger('change');
        }
    }
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

   function resetItemForm(index) {
    const itemRow = $(`select[data-index="${index}"]`).closest('.item-row');
        itemRow.find(`input[name="items[${index}][no_po_customer]"]`).val('').prop('readonly', true);
    itemRow.find(`input[name="items[${index}][nama_barang]"]`).val('');
    itemRow.find(`input[name="items[${index}][link_barang]"]`).val('');
    itemRow.find(`input[name="items[${index}][estimasi_kg]"]`).val('');
    itemRow.find(`input[name="items[${index}][estimasi_harga]"]`).val('');
}
});
</script>
@endsection

@endsection