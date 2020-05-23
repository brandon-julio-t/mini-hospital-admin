@extends('layouts.slim')

@section('body')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('staffs.index') }}" class="btn d-flex align-items-center">
                <svg class="bi bi-chevron-left" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                </svg>
                Back
            </a>
        </div>

        <section class="card-body">
            <div class="table-responsive">
                <table class="table table-borderless table-hover">
                    <tr>
                        <td>ID</td>
                        <td>{{ $staff->id }}</td>
                    </tr>
                    <tr>
                        <td>Name</td>
                        <td>{{ $staff->name }}</td>
                    </tr>
                    <tr>
                        <td>Phone Number</td>
                        <td>{{ $staff->phone_number }}</td>
                    </tr>
                    <tr>
                        <td>Date of Birth</td>
                        <td>{{ $staff->date_of_birth }}</td>
                    </tr>
                    <tr>
                        <td>Role</td>
                        <td>{{ $staff->role }}</td>
                    </tr>
                    <tr>
                        <td>Salary</td>
                        <td>{{ 'Rp' . number_format($staff->salary, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td>{{ $staff->address }}</td>
                    </tr>
                </table>
            </div>

            @if(Auth::user()->isAdmin())
                <form action="{{ route('staffs.destroy', $staff->id) }}" method="POST" class="row">
                    @csrf
                    @method('DELETE')

                    <div class="col">
                        <a href="{{ route('staffs.edit', $staff->id) }}" class="btn btn-block btn-outline-dark">
                            <svg class="bi bi-pencil" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M11.293 1.293a1 1 0 011.414 0l2 2a1 1 0 010 1.414l-9 9a1 1 0 01-.39.242l-3 1a1 1 0 01-1.266-1.265l1-3a1 1 0 01.242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z"
                                      clip-rule="evenodd"/>
                                <path fill-rule="evenodd"
                                      d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 00.5.5H4v.5a.5.5 0 00.5.5H5v.5a.5.5 0 00.5.5H6v-1.5a.5.5 0 00-.5-.5H5v-.5a.5.5 0 00-.5-.5H3z"
                                      clip-rule="evenodd"/>
                            </svg>
                            Edit
                        </a>
                    </div>

                    <div class="col">
                        <button class="btn btn-block btn-outline-danger">
                            <svg class="bi bi-trash-fill" width="1em" height="1em" viewBox="0 0 16 16"
                                 fill="currentColor"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M2.5 1a1 1 0 00-1 1v1a1 1 0 001 1H3v9a2 2 0 002 2h6a2 2 0 002-2V4h.5a1 1 0 001-1V2a1 1 0 00-1-1H10a1 1 0 00-1-1H7a1 1 0 00-1 1H2.5zm3 4a.5.5 0 01.5.5v7a.5.5 0 01-1 0v-7a.5.5 0 01.5-.5zM8 5a.5.5 0 01.5.5v7a.5.5 0 01-1 0v-7A.5.5 0 018 5zm3 .5a.5.5 0 00-1 0v7a.5.5 0 001 0v-7z"
                                      clip-rule="evenodd"/>
                            </svg>
                            Delete
                        </button>
                    </div>
                </form>
            @else
                <div class="row mt-5">
                    <div class="col">
                        <a href="{{ route('password.reset.form') }}" class="btn btn-block btn-outline-dark">Reset
                            Password</a>
                    </div>
                    <div class="col">
                        <a href="{{ route('home') }}" class="btn btn-block btn-outline-secondary">Return</a>
                    </div>
                </div>
            @endif
        </section>
    </div>
@endsection
