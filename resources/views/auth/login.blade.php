
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
        <div id="auth-right" style="position: relative; overflow: hidden;">
            <div class="auth-image" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
                <img src="assets/images/loginImage.jpeg" alt="Welcome" style="width: 100%; height: 100%; object-fit: cover;">
                <h1 class="auth-title" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; text-shadow: 2px 2px 4px rgba(0,0,0,0.5); margin: 0; z-index: 10;">Hello Team, Have a nice day!</h1>
            </div>
        </div>
    </div>
    <div class="col-lg-7 col-12 ">
        <div id="auth-left" style="display: flex; flex-direction: column; justify-content: center; align-items: center; min-height: 100vh; padding: 20px;">
            <div class="auth-logo" style="text-align: center; margin-bottom: 30px;">
                <a href="#"><img src="assets/images/logo/logo.jpeg" alt="Logo" style="max-width: 60%; height: auto;"></a>
            </div>
            <form method="POST" action="{{ route('login') }}" style="width: 80%; ">
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
