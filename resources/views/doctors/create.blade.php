@extends('layouts.slim')

@section('body')
    <div class="card">
        <div class="card-header">Add Doctor</div>

        <div class="card-body">
            @include('doctors.form', ['route' => route('doctors.store'), 'method' => 'POST'])
        </div>
    </div>
@endsection
