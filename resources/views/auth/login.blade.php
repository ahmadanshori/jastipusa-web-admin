
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
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        .auth-logo {
            animation: fadeInUp 0.8s ease-out;
        }

        .auth-title {
            animation: fadeInUp 0.8s ease-out 0.2s both;
        }

        .login-form {
            animation: fadeInUp 0.8s ease-out 0.4s both;
        }

        .auth-image img {
            transition: transform 0.3s ease;
        }

        .auth-image:hover img {
            transform: scale(1.05);
        }

        .form-control:focus {
            border-color: #435ebe;
            box-shadow: 0 0 0 0.2rem rgba(67, 94, 190, 0.25);
            transform: translateY(-2px);
            transition: all 0.3s ease;
        }

        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .btn-login:active {
            transform: translateY(-1px);
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            transition: left 0.5s ease;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .form-control-icon {
            transition: color 0.3s ease;
        }

        .form-group:focus-within .form-control-icon {
            color: #667eea;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .welcome-text {
            font-size: 1.1rem;
            color: #6c757d;
            font-weight: 400;
            margin-bottom: 40px;
            animation: fadeInUp 0.8s ease-out 0.3s both;
        }

        .auth-image::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.3) 0%, rgba(118, 75, 162, 0.3) 100%);
            z-index: 1;
        }
    </style>
</head>

<body>
    <div id="auth">

<div class="row h-100 g-0 m-0">
    <div class="col-lg-6 to-top-bar p-0">
        <div id="auth-right" style="position: relative; overflow: hidden; height: 100vh;">
            <div class="auth-image" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
                <img src="assets/images/loginImage.jpeg" alt="Welcome" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-12 p-0">
        <div id="auth-left" style="display: flex; flex-direction: column; justify-content: center; align-items: center; min-height: 100vh; padding: 40px; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
            <div class="auth-card" style="width: 100%; max-width: 480px;">
                <div class="auth-logo" style="text-align: center; margin-bottom: 25px;">
                    <a href="#"><img src="assets/images/logo/logo.jpeg" alt="Logo" style="max-width: 80%; height: auto;"></a>
                </div>
                <h1 class="auth-title" style="text-align: center; margin-bottom: 10px; color: #2d3748; font-size: 1.8rem; font-weight: 700;">
                    Welcome Back! 👋
                </h1>
                <p class="welcome-text" style="text-align: center;">
                    Hello Team, Have a nice day!
                </p>
                <form method="POST" action="{{ route('login') }}" class="login-form">
                    @csrf
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus class="form-control form-control-xl @error('email') is-invalid @enderror" placeholder="Enter your email" style="border-radius: 10px; padding: 15px 15px 15px 55px; border: 2px solid #e2e8f0; transition: all 0.3s ease;">
                        <div class="form-control-icon" style="left: 12px; top: 50%; transform: translateY(-50%); position: absolute; font-size: 1.3rem; color: #a0aec0;">
                            <i class="bi bi-envelope"></i>
                        </div>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input id="password" type="password" name="password" required class="form-control form-control-xl @error('password') is-invalid @enderror" placeholder="Enter your password" style="border-radius: 10px; padding: 15px 15px 15px 55px; border: 2px solid #e2e8f0; transition: all 0.3s ease;">
                        <div class="form-control-icon" style="left: 12px; top: 50%; transform: translateY(-50%); position: absolute; font-size: 1.3rem; color: #a0aec0;">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-block btn-lg shadow-lg mt-4 btn-login" style="border-radius: 10px; padding: 15px; font-size: 1.1rem;">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Log in
                    </button>
                </form>

                <div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e2e8f0;">
                    <p style="color: #718096; font-size: 0.9rem; margin: 0;">
                        <i class="bi bi-shield-check me-1"></i> Secure Login
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

    </div>
</body>

</html>
