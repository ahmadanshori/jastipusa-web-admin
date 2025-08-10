@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-first">
                <h3>Payment Method</h3>
                <p class="text-subtitle text-muted">{{ (isset($paymentMethod)? 'Edit Payment Method':'Add Payment Method') }}</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('payment-method.index') }}">Payment Method</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ (isset($paymentMethod)? 'Edit Payment Method':'Add Payment Method') }}</li>
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
                        @if(isset($paymentMethod))

                        <form class="form" method="POST" action="{{route('payment-method.update', $paymentMethod->id)}}" enctype="multipart/form-data">
                            {{ method_field('PUT') }}
                        @else
                        <form class="form" method="POST" action="{{route('payment-method.store')}}" enctype="multipart/form-data">
                        @endif
                        
                        @csrf
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" id="name" class="form-control form-control-lg"  value="{{ (isset($paymentMethod->name)? $paymentMethod->name:old('name')) }}"  name="name">
                                    </div>
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory">
                                        <label for="number" class="form-label">Number</label>
                                        <input type="number" id="number" class="form-control form-control-lg"  value="{{ (isset($paymentMethod->number)? $paymentMethod->number:old('number')) }}"  name="number">
                                    </div>
                                    @error('number')
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
