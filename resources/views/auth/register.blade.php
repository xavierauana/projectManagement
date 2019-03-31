@component('components.plain')
	<div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
          <div class="col-lg-7">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
              </div>
              <form class="user" action="/register" method="POST">
                @csrf
	              <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user"
                           name="first_name" required value="{{ old('first_name') }}"
                           id="first_name" placeholder="First Name">
	                  @if ($errors->has('first_name'))
		                  <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('first_name') }}</strong>
                            </span>
	                  @endif
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user"
                           name='last_name' id="last_name" value="{{ old('last_name') }}" required
                           placeholder="Last Name">
	                  @if ($errors->has('last_name'))
		                  <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('last_name') }}</strong>
                            </span>
	                  @endif
                  </div>
                </div>
                <div class="form-group">
                  <input type="email" class="form-control form-control-user"
                         name="email" id="email" value="{{ old('email') }}" placeholder="Email Address"
                         required>
	                @if ($errors->has('email'))
		                <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
	                @endif
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="password" name="password"
                           class="form-control form-control-user"
                           required id="password" placeholder="Password">
	                  @if ($errors->has('password'))
		                  <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
	                  @endif
                  </div>
                  <div class="col-sm-6">
                    <input type="password"
                           class="form-control form-control-user"
                           name="password_confirmation"
                           id="password_confirmation" required
                           placeholder="Repeat Password">
	                  @if ($errors->has('password_confirmation'))
		                  <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
	                  @endif
                  </div>
                </div>
                <button type="submit"
                        class="btn btn-primary btn-user btn-block">
                  Register Account
                </button>
                <hr>
                <a href="index.html" class="btn btn-google btn-user btn-block">
                  <i class="fab fa-google fa-fw"></i> Register with Google
                </a>
                <a href="index.html"
                   class="btn btn-facebook btn-user btn-block">
                  <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                </a>
              </form>
              <hr>
              <div class="text-center">
                <a class="small"
                   href="forgot-password.html">Forgot Password?</a>
              </div>
              <div class="text-center">
                <a class="small" href="/login">Already have an account? Login!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endcomponent
