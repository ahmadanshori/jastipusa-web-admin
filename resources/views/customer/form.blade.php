@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-first">
                <h3>Account</h3>
                <p class="text-subtitle text-muted">{{ (isset($user)? 'Edit Account':'Add Account') }}</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Account</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ (isset($user)? 'Edit Account':'Add Account') }}</li>
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
                        @if(isset($user))
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link @if($errors->has('password') OR $errors->has('password_confirmation')) ac  @else active @endif" id="home-tab" data-bs-toggle="tab" href="#home" role="tab"
                                    aria-controls="home" aria-selected="true"><i class="bi bi-person"></i> Profile</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link @if($errors->has('password') OR $errors->has('password_confirmation')) active  @else ac @endif" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab"
                                    aria-controls="profile" aria-selected="false"><i class="bi bi-lock"></i>  Change Password</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade @if($errors->has('password') OR $errors->has('password_confirmation')) ac  @else show active @endif" id="home" role="tabpanel" aria-labelledby="home-tab">
                               <div class="mt-3">
                                <form class="form" method="POST" action="{{route('user.update', $user->id)}}" enctype="multipart/form-data">
                                    {{ method_field('PUT') }}
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <div class="form-group mandatory">
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" id="name" class="form-control form-control-lg"  value="{{ (isset($user->name)? $user->name:old('name')) }}"  name="name">
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
                                                <input type="email" id="email" class="form-control form-control-lg" value="{{ (isset($user->email)? $user->email:old('email')) }}"  name="email">
                                            </div>
                                            @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
        
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mandatory">
                                                <label for="role" class="form-label">Role</label>
                                                <select class="choices form-select" id="role" name="role">
                                                    <option value="">Press to select</option>
                                                    @if(isset($user))
                                                        @foreach($role as $roles)
                                                        <option value="{{ $roles->id }}" {{ ($roles->id == $user->role_id)? 'selected' : '' }}>{{$roles->name}}</option>
                                                        @endforeach
                                                    @else
                                                        @foreach($role as $roles)
                                                        <option value="{{ $roles->id }}">{{$roles->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
        
                                    </div>
                                  
                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                        </div>
                                    </div>
                                </form>
                               </div>
                            </div>
                            <div class="tab-pane fade @if($errors->has('password') OR $errors->has('password_confirmation')) show active  @else ac @endif" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="mt-3">
                                    <form class="form" method="POST" action="{{route('user.change-password', $user->id)}}" enctype="multipart/form-data">
                                        {{ method_field('PUT') }}
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group mandatory">
                                                    <label for="password" class="form-label">New Password</label>
                                                    <input type="password" id="password" class="form-control form-control-lg" name="password">
                                                </div>
                                                @error('password')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
            
                                            <div class="col-md-6 col-12">
                                                <div class="form-group mandatory">
                                                    <label for="password_confirmation" class="form-label">Password Confirmation</label>
                                                    <input type="password" id="password_confirmation" class="form-control form-control-lg" name="password_confirmation">
                                                </div>
                                                @error('password_confirmation')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
            
                                        </div>
                                      
                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                   </div>
                            </div>
                        </div>
                        @else
                        <form class="form" method="POST" action="{{route('user.store')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="form-group mandatory">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" id="name" class="form-control form-control-lg"  value="{{ (isset($user->name)? $user->name:old('name')) }}"  name="name">
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
                                        <input type="email" id="email" class="form-control form-control-lg" value="{{ (isset($user->email)? $user->email:old('email')) }}"  name="email">
                                    </div>
                                    @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory">
                                        <label for="role" class="form-label">Role</label>
                                        <select class="choices form-select" id="role" name="role">
                                            <option value="">Press to select</option>
                                            @if(isset($user))
                                                @foreach($role as $roles)
                                                <option value="{{ $roles->id }}" {{ ($roles->id == $user->role_id)? 'selected' : '' }}>{{$roles->name}}</option>
                                                @endforeach
                                            @else
                                                @foreach($role as $roles)
                                                <option value="{{ $roles->id }}">{{$roles->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" id="password" class="form-control form-control-lg" name="password">
                                    </div>
                                    @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory">
                                        <label for="password_confirmation" class="form-label">Password Confirmation</label>
                                        <input type="password" id="password_confirmation" class="form-control form-control-lg" name="password_confirmation">
                                    </div>
                                    @error('password_confirmation')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                          
                            <div class="row">
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                </div>
                            </div>
                        </form>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


@endsection
@section('scripts')
@endsection
