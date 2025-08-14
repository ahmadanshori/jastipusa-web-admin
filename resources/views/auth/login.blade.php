
 <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JASTIPUSA - Login</title>
    <link rel="stylesheet" href="assets/css/main/app.css">
    <link rel="stylesheet" href="assets/css/pages/auth.css">
    <link rel="shortcut icon" href="assets/images/logo/favicon.jpg" type="image/x-icon">
    <link rel="shortcut icon" href="assets/images/logo/favicon.jpg" type="image/png">
</head>

<body>
    <div id="auth">
        
<div class="row h-100">
   
    <div class="col-lg-5 to-top-bar">
        <div id="auth-right">
            <h1 class="auth-title">Hello Team, Have a nice day!</h1>
          
        </div>
    </div>
    <div class="col-lg-7 col-12">
        <div id="auth-left">
            <div class="auth-logo">
                <a href="#"><img src="assets/images/logo/login-logo.jpg" alt="Logo"></a>
            </div>
           

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group position-relative has-icon-left mb-4">
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus class="form-control form-control-xl @error('email') is-invalid @enderror" placeholder="Username">
                    <div class="form-control-icon">
                        <i class="bi bi-person"></i>
                    </div>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>
                <div class="form-group position-relative has-icon-left mb-4">
                    <input id="password" type="password" name="password" required class="form-control form-control-xl @error('password') is-invalid @enderror" placeholder="Password">
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
               
                <button type="submit" class="btn btn-block btn-lg shadow-lg mt-5 btn-login">Log in</button>
            </form>
           
        </div>
    </div>
</div>

    </div>
</body>

</html>
