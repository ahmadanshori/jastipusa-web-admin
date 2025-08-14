@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-first">
                <h3>Tracking</h3>
                <p class="text-subtitle text-muted">List Data</p>
            </div>
              {{-- <div class="col-12 col-md-6 order-md-2 order-last">
                      <a href="{{ route('customer.export') }}" target="_blank" class="btn btn-success">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </a>
                </div> --}}
        </div>
    </div>
    <section class="section">
        <div class="card">
            
            <div class="card-body">
                <div class="table-responsive" style="overflow-x: auto">
                <table class="table" id="show-table" style="width: 100%; white-space: nowrap">
                    <thead class="thead-light">
                        <tr>
                           <th>No PO</th>
                            <th>Nama</th>
                            <th>No Telp</th>
                            <th>Alamat</th>
                            <th>Email</th>
                            <th>Nama Barang</th>
                            <th>Link Barang</th>
                            <th>Estimasi Kg</th>
                            <th>Estimasi Harga</th>
                            <th>Status Follow Up</th>
                            <th>Estimasi Diskon</th>
                            <th>Total Harga</th>
                            <th>Nama Rek Transfer</th>
                            <th>Jumlah Transfer</th>
                            <th>DP</th>
                            <th>Fullpayment</th>
                            <th>Foto Bukti TF</th>
                            <th>Mutasi Check</th>
                            <th>Payment Method</th>
                            <th>Total Purchase</th>
                            <th>Total Fix Diskon</th>
                            <th>Foto Bukti Pembelian</th>
                            <th>Status Purchase</th>
                            <th>Notes</th>
                            <th>WH USA</th>
                            <th>Status On Check</th>
                            <th>WH INDO</th>
                            <th>Fix Weight</th>
                            <th>Fix Price</th>
                            <th>Status Barang Sampai</th>
                        </tr>
                    </thead>
                  
                </table>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
@section('scripts')
<script src="{{ asset('js/index/tracking.js') }}"></script>
@endsection