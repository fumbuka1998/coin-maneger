@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header alert alert-primary">
                    {{-- {{ __('Dashboard') }} --}}
                
                    <div class="row1">
                        <ul>
                            <li><h1><i>HELLO</i></h1>
                                {{ Auth::user()->name }}
                            </li>
                            <li><img src="../../image/user1.png"  style="width:4.25rem"></li>
                        </ul>
                    </div>
                    <div class="row2 ">
                        <ul>
                            <li><h1>{{ Auth::user()->amount }}</h1>{{ __('Available Balance') }}</li>
                            
                        </ul>
                    </div>
                    <div class="row3">
                        <ul>
                            <li><h3>{{ __('Wallet ID') }}</h3></li>
                            <li>{{ Auth::user()->account_no }}</li>
                        </ul>

                    </div>
                
                
                
                
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('card scan history for me!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
