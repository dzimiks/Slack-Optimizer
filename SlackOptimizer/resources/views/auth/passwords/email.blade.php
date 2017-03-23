@extends('layouts.app')

<!-- Main Content -->
@section('content')
<div class="container">
    <div class="wrapper">


                <h1>Reset Password</h1>

                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                        {{ csrf_field() }}


                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">
                                <br/>
                                @if ($errors->has('email'))
                                    <span class="error">
                                        {{ $errors->first('email') }}
                                    </span>

                                @endif
                                <br/>
                            </div>



                                <button type="submit" class="btn btn-primary">
                                    Send Password Reset Link
                                </button>

                    </form>


    </div>
</div>

@endsection
