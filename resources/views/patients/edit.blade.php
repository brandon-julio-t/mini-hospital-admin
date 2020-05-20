@extends('layouts.slim')

@section('body')
    <div class="card">
        <div class="card-header">Edit Staff</div>

        <div class="card-body">
            @include('staffs.form', ['route' => route('staffs.update', $staff->id), 'method' => 'PUT','staff' => $staff])
        </div>
    </div>
@endsection
