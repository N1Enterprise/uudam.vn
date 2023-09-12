<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>{{ $APP_NAME }} | {{ __('Login') }}</title>

        <link rel="shortcut icon" href="favicon.ico">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
        <link href="{{ asset('assets/css/auth/login-v1.css') }}" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <main id="content" role="main" class="main">
            <div class="position-fixed top-0 right-0 left-0 bg-img-hero" style="height: 32rem; background-image: url({{ asset('assets/svg/abstract-bg-4.svg') }});">
                <figure class="position-absolute right-0 bottom-0 left-0">
                    <svg preserveaspectratio="none" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewbox="0 0 1921 273">
                        <polygon fill="#fff" points="0,273 1921,273 1921,0 "></polygon>
                    </svg>
                </figure>
            </div>

            <div class="container py-5 py-sm-7">
                <a class="d-flex justify-content-center mb-5" href="javascript:void(0)">
                    <img class="z-index-2" src="{{ asset('assets\svg\main-logo.svg') }}" alt="{{ __('Image Description') }}" style="width: 8rem;">
                </a>

                <div class="row justify-content-center">
                    <div class="col-md-7 col-lg-5">
                        <div class="card card-lg mb-5">
                            <div class="card-body">
                                <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}" autocomplete="off">
                                    @csrf
                                    <div class="js-form-message form-group">
                                        <label class="input-label" for="signinSrEmail">{{ __('Your Email') }}</label>
                                        <input type="email" class="form-control form-control-lg" name="email" autocomplete="off" id="signinSrEmail" tabindex="1" placeholder="{{ __('email@address.com') }}" aria-label="{{ __('email@address.com') }}" required>
                                    </div>

                                    <div class="js-form-message form-group">
                                        <label class="input-label" for="signupSrPassword">{{ __('Password') }}</label>
                                        <input type="password" class="js-toggle-password form-control form-control-lg" name="password" id="signupSrPassword" placeholder="{{ __('8+ characters required') }}" aria-label="{{ __('8+ characters required') }}" required>
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
