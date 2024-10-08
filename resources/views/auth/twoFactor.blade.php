

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="for-header">
                            @if (env('APP_ENV') != 'Production')
                                <img src="{{url('images/bostik_test.png')}}">
                            @else
                                <img src="{{url('images/Bostik_Logo.png')}}">
                            @endif
                        </div>
                        @if(session()->has('message'))
                            <p class="alert alert-info">
                                {{ session()->get('message') }}
                            </p>
                        @endif
                        <form method="POST" action="{{ route('verify.store') }}" class="login verify">
                            {{ csrf_field() }}
                            <h4 class="verify">{{ __('2 Factor Authentication') }}</h4>
                            <p>
                                {{ __('Please check your email inbox for a 2 factor authentication code in order to continue.') }}
                            </p>

                            <div class="form-group row">

                                <label for="code"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Authentication Code') }}</label>

                                <div class="col-md-6">
                                    <input name="two_factor_code" type="text"
                                           class="form-control{{ $errors->has('two_factor_code') ? ' is-invalid' : '' }}"
                                           required autofocus>
                                    @if($errors->has('two_factor_code'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('two_factor_code') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            var locale = "{{ session('locale') }}";
            $('#dropdownMenu').html($('#' + locale).val());
        });


        $('.dropdown-item').on('click', function () {
            $('#dropdownMenu').html($(this).val());
            $.ajax({
                url: '/changeLocale',
                method: 'POST',
                data: {
                    'loc': $(this).attr('id')
                },
                success: function () {
                    window.location.href = "{{URL::to('/verify')}}"
                }
            });
        });
    </script>
@endsection
