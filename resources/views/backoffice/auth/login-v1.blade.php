<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
        <title>{{ $APP_NAME }} | {{ __('Login') }}</title>
        <link rel="shortcut icon" href="favicon.ico">
        <link href="{{ asset('backoffice/assets/css/auth/login-v1.css') }}" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <main id="content" class="main" style="height: 100vh; width: 100vw; background: #387dff;">
            <div class="container py-5 py-sm-7">
                <div class="row justify-content-center">
                    <div class="col-md-7 col-lg-5">
                        <div class="card card-lg mb-5 mt-5">
                            <div class="card-body">
                                <form method="POST" action="{{ route('login') }}" autocomplete="off">
                                    @csrf
                                    <div class="js-form-message form-group">
                                        <label class="input-label" for="signinSrEmail">{{ __('Your Email') }}</label>
                                        <input type="email" class="form-control form-control-lg" name="email" autocomplete="off" id="signinSrEmail" tabindex="1" placeholder="{{ __('email@address.com') }}" required>
                                    </div>
                                    <div class="js-form-message form-group">
                                        <label class="input-label" for="signupSrPassword">{{ __('Password') }}</label>
                                        <input type="password" class="js-toggle-password form-control form-control-lg" name="password" id="signupSrPassword" placeholder="{{ __('8+ characters required') }}" required>
                                    </div>
                                    <button type="submit" class="btn btn-lg btn-block btn-primary">{{ __('Sign in') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>
