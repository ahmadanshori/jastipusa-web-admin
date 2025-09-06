@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-first">
                <h3>Exchange</h3>
                <p class="text-subtitle text-muted">{{ (isset($exchange)? 'Edit Exchange':'Add Exchange') }}</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('exchange.index') }}">Exchange</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ (isset($exchange)? 'Edit Exchange':'Add Exchange') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="col-md-12 col-12">
            <div class="card">

                <div class="card-content">
                    <div class="card-body">
                        @if(isset($exchange))

                        <form class="form" method="POST" action="{{route('exchange.update', $exchange->id)}}" enctype="multipart/form-data">
                            {{ method_field('PUT') }}
                        @else
                        <form class="form" method="POST" action="{{route('exchange.store')}}" enctype="multipart/form-data">
                        @endif

                        @csrf
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" id="name" class="form-control form-control-lg"  value="{{ (isset($exchange->name)? $exchange->name:old('name')) }}"  name="name">
                                    </div>
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory">
                                        <label for="value" class="form-label">Value</label>
                                        <input type="number" id="value" class="form-control form-control-lg"  value="{{ (isset($exchange->value)? $exchange->value:old('value')) }}"  name="value">
                                    </div>
                                    @error('value')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>


                            <div class="row">
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                    <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
@section('scripts')
@endsection
