@extends('layouts.dashboard')

@section('dashboard')
    <h1>Welcome, {{ Auth::user()->username }}</h1>

    <section class="row my-5">
        <div class="col">
            <a href="{{ route('staffs.index') }}" class="btn btn-block btn-outline-dark">Manage Staffs</a>
        </div>
        <div class="col">
            <a href="{{ route('doctors.index') }}" class="btn btn-block btn-outline-dark">Manage Doctors</a>
        </div>
    </section>
@endsection
