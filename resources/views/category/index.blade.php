@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-first">
                <h3>Category</h3>
                <p class="text-subtitle text-muted">List Data</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-last">
                    <a href="{{ route('category.create') }}" class="btn icon icon-left btn-info btn-add"><span class="fa-fw select-all fas"></span> Create new entry</a>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            
            <div class="card-body">
                <div class="table-responsive">
                <table class="table table-responsive" id="show-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th style="width:10%">Action</th>
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
<script src="{{ asset('js/index/category.js') }}"></script>


@endsection