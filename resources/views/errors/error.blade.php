@extends('test-theme::master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="error-template">
                    <h1>
                        Oops!</h1>
                    <h2>
                        Something Went Wrong</h2>
                    <div class="error-details">
                        @if($message)
                            {{ $message }}
                        @else
                            Sorry, the page you are looking for is not found!
                        @endif
                    </div>
                    <div class="error-actions">
                        <a href="{{ url('test-theme') }}" class="btn btn-primary btn-lg">
                            <span class="glyphicon glyphicon-home"></span>
                            Take Me Home 
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection