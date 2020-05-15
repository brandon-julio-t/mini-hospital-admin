@extends('layouts.slim')

@section('body')
    <div class="card">
        <div class="card-header">Add Staff</div>

        <div class="card-body">
            @include('staffs.form', ['route' => route('staffs.store'), 'method' => 'POST'])
        </div>
    </div>
@endsection
