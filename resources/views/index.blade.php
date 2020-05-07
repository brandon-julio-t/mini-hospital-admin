@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <h1>Welcome, {{ Auth::user()->username }}</h1>
                        <h2>You're logged in as Admin / Staff / Doctor</h2>

                        <div class="row justify-content-center my-5">
                            <div class="col-md-3">
                                <button class="btn btn-outline-dark">Add new Staff</button>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-outline-dark">Add new Doctor</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
