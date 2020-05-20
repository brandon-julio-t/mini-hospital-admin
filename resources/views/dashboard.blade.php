@extends('layouts.wide')

@section('body')
    <div class="card">
        <div class="card-header">Dashboard</div>

        <div class="card-body">
            @includeWhen(Auth::user()->isAdmin(), 'admin.dashboard')
            @includeWhen(Auth::user()->isStaff(), 'staffs.dashboard', ['staff' => DB::selectOne('select * from staffs where user_id = ?', [Auth::id()])])
            @includeWhen(Auth::user()->isDoctor(),'doctors.dashboard',  ['doctor' => DB::selectOne('select * from doctors where user_id = ?', [Auth::id()])])
        </div>
    </div>
@endsection
