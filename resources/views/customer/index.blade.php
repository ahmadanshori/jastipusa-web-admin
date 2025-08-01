@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-first">
                <h3>Customer</h3>
                <p class="text-subtitle text-muted">List Data</p>
            </div>
              <div class="col-12 col-md-6 order-md-2 order-last">
                      <a href="{{ route('customer.export') }}" target="_blank" class="btn btn-success">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </a>
                </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            
            <div class="card-body">
                <div class="table-responsive">
                <table class="table" id="show-table">
                    <thead class="thead-light">
                        <tr>
                            <th>Nama</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Email</th>
                            <th>Action</th>
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
<script src="{{ asset('js/index/customer.js') }}"></script>
@endsection