@extends('auth.templates.main')

@section('main')
<h3>Login to <strong>rocketcontent.io</strong></h3>
                    <!-- <p class="mb-4">Lorem ipsum dolor sit amet elit. Sapiente sit aut eos consectetur adipisicing.</p> -->
                    <form action="{{ route('auth.login.request') }}" method="post" class="mt-5">
                        @csrf

                        <div class="form-group first">
                            <label for="username">Username</label>
                            @error('email')
                                <div>{{ $message }}</div>
                            @enderror
                            <input type="text" class="form-control border" placeholder="your-email@gmail.com" id="username" name="email">
                        </div>

                        <div class="form-group last mb-3 mt-3">
                            <label for="password">Password</label>
                            @error('password')
                                <div>{{ $message }}</div>
                            @enderror
                            <input type="password" class="form-control border" placeholder="Your Password" id="password" name="password">
                        </div>
                        
                        <div class="d-flex mb-5 align-items-center">
                            <label class="control control--checkbox mb-0"><span class="caption">Remember me</span>
                            <input type="checkbox" checked="checked"/>
                            <div class="control__indicator"></div>
                            </label>
                            <span class="ms-auto"><a href="#" class="forgot-pass">Forgot Password</a></span> 
                        </div>

                        <div class="d-grid">
                            <input type="submit" id="loginButton" value="Log In" class="btn btn-block btn-primary">
                        </div>
                    </form>
@endsection