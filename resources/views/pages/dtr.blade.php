@extends('layouts.app')

@section('content')

<div class="jumbotron text-center">
    <h1>
        <i class="fas fa-calendar-week"></i>
        Daily Time Record
    </h1>
    <h4>[{{ $agency->agency_name }}]</h4>

    <div class="mt-3">
        <div class="btn-group m-1 dropright">
            <button id="btn-office" class="btn btn-danger dropdown-toggle"
                    data-toggle="dropdown" type="button">
                Select Office
            </button>
            <div class="dropdown-menu" aria-labelledby="btn-office">
                <h6 class="dropdown-header">Offices</h6>

                @foreach ($offices as $office)
                <a class="dropdown-item"
                   onclick="$(this).setOffice('{{ $office->id }}',
                                              '{{ $office->office_name }}');">
                    {{ $office->office_name }}
                </a>
                @endforeach
            </div>
        </div>
        <div id="btn-grp-division" class="btn-group m-1 dropright" style="display: none;">
            <button id="btn-division" class="btn btn-danger dropdown-toggle"
                    data-toggle="dropdown" type="button">
                Select Division
            </button>
            <div id="dropdown-division" class="dropdown-menu" aria-labelledby="btn-division">
                <h6 class="dropdown-header">Divisions</h6>

                @foreach ($divisions as $division)
                <a class="dropdown-item"
                   onclick="$(this).setDivision('{{ $division->id }}',
                                                '{{ $division->division_name }}');">
                    {{ $division->division_name }}
                </a>
                @endforeach
            </div>
        </div>
        <button onclick="$(this).resetSeleted();" id="btn-reset" class="btn btn-link"
                style="display: none;">
            <i class="fas fa-undo"></i> Reset
        </button>
    </div>
    <hr>
    <div class="container mt-3">
        <div class="row">
            <div class="col p-0">
                <div id="data-body" class="card" style="display: none;">
                </div>
            </div>
        </div>
    </div>
</div>

<form id="frm-dtr-print" action="{{ url('print/dtr') }}" method="POST" target="_blank">
    @csrf
    <input type="hidden" name="key" id="inp-key">
    <input type="hidden" name="datefrom" id="inp-datefrom">
    <input type="hidden" name="dateto" id="inp-dateto">
    <input type="hidden" name="papertype" id="inp-papertype">
    <input type="hidden" name="toggle" id="inp-toggle">
</form>

@include('modals.dtr-print')

@endsection

@section('custom-js')

<script src="{{ asset('assets/js/dtr.js') }}"></script>

@endsection
