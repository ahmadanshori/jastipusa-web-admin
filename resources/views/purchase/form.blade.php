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

</script>
@endsection