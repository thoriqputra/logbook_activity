@section('title')
Register
@endsection

@extends('layouts.template_login')

@section('content')
<main class="main-content mt-0">
    <section class="min-vh-100 mb-8">
        <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg" style="background-image: url('../assets/img/curved-images/curved14.jpg');">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 text-center mx-auto">
                        <h1 class="text-white mb-2 mt-5">Sign Up!</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-lg-n10 mt-md-n11 mt-n10">
                <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
                    <div class="card z-index-0">
                        <div class="card-header text-center pt-4">
                            <h5>Register</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" id="form" role="form text-left" action="javascript:void(0);">
                            {{ csrf_field() }}
                                <div class="mb-3">
                                    <input type="text" name="name" class="form-control" placeholder="Name" aria-label="Name" aria-describedby="name-addon">
                                </div>
                                <div class="mb-3">
                                    <input type="text" name="username" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="username-addon">
                                </div>
                                <div class="mb-3">
                                    <input type="email" name="email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="email-addon">
                                </div>
                                <div class="mb-3">
                                    <input type="password" name="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="password-addon">
                                </div>
                                <div class="text-center">
                                    <button type="submit" id="register" onclick="doRegister();" class="btn bg-gradient-dark w-100 my-4 mb-2">{{ __('Sign up') }}</button>
                                </div>
                            </form>
                            
                            @if (Route::has('register'))
                                <p class="text-sm mt-3 mb-0">Already have an account?
                                    <a href="{{ route('login') }}" class="text-dark font-weight-bolder">Sign in</a>
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer py-5">
        <div class="container">
            <div class="row">
                <div class="col-8 mx-auto text-center mt-1">
                    <p class="mb-0 text-secondary">
                        Copyright © 
                        <script>
                            document.write(new Date().getFullYear())
                        </script> 
                        Developer Team.
                    </p>
                </div>
            </div>
        </div>
    </footer>
</main>
@endsection