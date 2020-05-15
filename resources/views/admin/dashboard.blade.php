@extends('layouts.wide')

@section('body')
    <div class="card">
        <div class="card-header">Dashboard</div>

        <div class="card-body">
            <h1>Welcome, {{ Auth::user()->username }}</h1>
            <p>
                You're logged in as
                {{ Auth::user()->isAdmin() ? 'Admin' : (Auth::user()->isStaff() ? 'Staff' : 'Doctor') }}
            </p>

            <section class="table-responsive">
                <h2>Manage Staffs</h2>

                @include('admin.tables.staff')
            </section>

            <section>
                <h2>Manage Doctors</h2>

                @include('admin.tables.doctor')
            </section>

            <div class="row justify-content-center">
                <div class="col">
                    <a href="{{ route('staffs.create') }}" class="btn btn-block btn-outline-dark">Add new Staff</a>
                </div>
                <div class="col">
                    <a href="{{ route('doctors.create') }}" class="btn btn-block btn-outline-dark">Add new Doctor</a>
                </div>
            </div>
        </div>
    </div>
@endsection
