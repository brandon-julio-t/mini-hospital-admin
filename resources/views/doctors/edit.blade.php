@extends('layouts.slim')

@section('body')
    <div class="card">
        <div class="card-header">Edit Doctor</div>

        <div class="card-body">
            @include('doctors.form', ['route' => route('doctors.update', $doctor->id), 'method' => 'PUT','doctor' => $doctor])
        </div>
    </div>
@endsection
