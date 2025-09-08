@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-first">
                <h3>Purchase Order</h3>
                <p class="text-subtitle text-muted">List Data</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-last">
                 @if (App\Models\User::checkRole('master_admin') || App\Models\User::checkRole('admin_chat_input'))
                    <a href="{{ route('purchase.create') }}" class="btn icon icon-left btn-info btn-add"><span class="fa-fw select-all fas"></span> Create new entry</a>
                @endif
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header bg-light">
                @if (App\Models\User::checkRole('master_admin') || App\Models\User::checkRole('admin_chat_input'))
                <a href="{{ route('purchase.export') }}" class="btn btn-success">
                    <i class="fas fa-file-excel"></i> Export to Excel
                </a>
                @endif
            </div>
            <div class="card-body" style="margin-top: 24px;">

                <div class="table-responsive">
                <table class="table" id="show-table">
                    <thead>
                        <tr>
                            <th>No PO</th>
                            <th>Date</th>
                            <th>Name</th>
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
<script src="{{ asset('js/index/purchase.js') }}"></script>

@endsection
