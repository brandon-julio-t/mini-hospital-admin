@extends('layouts.slim')

@section('body')
    <div class="card">
        <div class="card-header">Add Patient</div>

        <div class="card-body">
            @include('patients.form', ['route' => route('patients.store'), 'method' => 'POST'])
        </div>
    </div>
@endsection
