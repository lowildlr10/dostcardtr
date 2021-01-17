@extends('layouts.app')

@section('content')
    <div class="jumbotron text-center">
        <h1>
            <i class="fas fa-calendar-week"></i>
            Daily Time Record
        </h1>
        <h4>[{{ $agency->agency_name }}]</h4>

        <div class="mt-3">
            <a class="btn btn-link btn-lg" href="{{ url('dtr') }}" role="button">
                Proceed >>
            </a>
        </div>
        <hr>
    </div>
@endsection
