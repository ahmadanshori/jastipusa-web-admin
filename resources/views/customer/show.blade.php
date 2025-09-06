@extends('layouts.app')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-first">
                    <h3>Customer</h3>
                    <p class="text-subtitle text-muted">{{ isset($customer) ? 'Detail Customer' : 'Add Customer' }}</p>
                </div>



            </div>
        </div>
        <section class="section">
            <div class="col-md-12 col-12">

                <div class="container py-4">
                    <!-- Customer Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="h3">{{$customer->display_name}}</h1>
                        <p>{{$customer->address}}</p>
                    </div>

                    <!-- Stats Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3 col-6 mb-3">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <h6 class="card-subtitle mb-2 text-muted">Total Belanja</h6>
                                    <p class="card-text h5">{{ number_format($total_order, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <h6 class="card-subtitle mb-2 text-muted">Total Order</h6>
                                    <p class="card-text h5">{{ $jumlah_order }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <h6 class="card-subtitle mb-2 text-muted">Customer sejak</h6>
                                    <p class="card-text h5">{{$membership_duration}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="card h-100 border-success">
                                <div class="card-body text-center">
                                    <h6 class="card-subtitle mb-2 text-muted">Whatsapp Number</h6>
                                    <p class="card-text h5 text-success">{{$customer->whatsapp_number}}</p>
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- Timeline Section -->
                    <div class="card">
                        <div class="card-header bg-light">
                            <h3 class="h6 mb-0">Semua Purchase Order</h3>
                        </div>
                        <div class="card-body">
                               <div class="table-responsive mt-2">
                              <table class="table" id="show-table">
                                  <thead>
                                      <tr>
                                          <th>No PO</th>
                                          <th>Name</th>
                                          <th>Estimasi KG</th>
                                          <th>Estimasi Harga</th>
                                          <th>Jumlah Transfer</th>
                                          <th>DP</th>
                                      </tr>
                                  </thead>

                              </table>
                              </div>
                        </div>
                    </div>
                </div>

                <!-- Optional CSS for timeline (Bootstrap doesn't include timeline by default) -->
                <style>
                    .timeline {
                        position: relative;
                    }

                    .timeline-item {
                        margin-left: 6px;
                    }

                    .timeline-item:last-child {
                        padding-bottom: 0;
                        border-left: 0 !important;
                    }

                    .timeline-item:last-child::before {
                        display: none;
                    }
                </style>
            </div>
        </section>
    </div>
@endsection
@section('scripts')
<script src="{{ asset('js/utils/currency.js') }}"></script>
<script src="{{ asset('js/index/order-detail.js') }}"></script>
@endsection
