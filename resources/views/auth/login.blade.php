@component('components.plain')
	<!-- Outer Row -->
	<div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                  </div>
                  <form class="user" method="POST" action="{{url('login')}}">
                    @csrf
	                  <div class="form-group">
                      <input type="email" class="form-control form-control-user"
                             required value="{{old('email')}}" id="email"
                             name="email" aria-describedby="emailHelp"
                             placeholder="Enter Email Address...">
		                  @if ($errors->has('email'))
			                  <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
		                  @endif
                    </div>
                    <div class="form-group">
                      <input type="password"
                             class="form-control form-control-user"
                             name="password" id="password"
                             placeholder="Password">
	                    @if ($errors->has('password'))
		                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
	                    @endif
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input"
                               name="remember" id="remember"
                               value="{{old('remember')}}">
	                      @if ($errors->has('remember'))
		                      <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('remember') }}</strong>
                            </span>
	                      @endif
	                      <label class="custom-control-label" for="customCheck">Remember Me</label>
                      </div>
                    </div>
                    <button type="submit"
                            class="btn btn-primary btn-user btn-block">Login
                    </button>
                    <hr>
                    <a href="index.html"
                       class="btn btn-google btn-user btn-block">
                      <i class="fab fa-google fa-fw"></i> Login with Google
                    </a>
                    <a href="index.html"
                       class="btn btn-facebook btn-user btn-block">
                      <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                    </a>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="forgot-password.html">Forgot Password?</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="register.html">Create an Account!</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>
@endcomponent
