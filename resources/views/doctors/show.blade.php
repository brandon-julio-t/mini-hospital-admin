@extends('layouts.slim')

@section('body')
    <div class="card">
        <div class="card-header">{{ $doctor->id }}</div>

        <div class="card-body table-responsive">
            <table class="table table-hover">
                <tr>
                    <td>Name</td>
                    <td>{{ $doctor->name }}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>{{ $doctor->email }}</td>
                </tr>
                <tr>
                    <td>Phone Number</td>
                    <td>{{ $doctor->phone_number }}</td>
                </tr>
                <tr>
                    <td>Date of Birth</td>
                    <td>{{ $doctor->date_of_birth }}</td>
                </tr>
                <tr>
                    <td>Specialist</td>
                    <td>{{ $doctor->specialist }}</td>
                </tr>
                <tr>
                    <td>Salary</td>
                    <td>{{ $doctor->salary }}</td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td>{{ $doctor->address }}</td>
                </tr>
            </table>

            @if(Auth::user()->isAdmin())
                <form action="{{ route('doctors.destroy', $doctor->id) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <a href="{{ route('doctors.edit', $doctor->id) }}" class="btn btn-block btn-outline-dark">
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

                    <button class="btn btn-block btn-outline-danger">
                        <svg class="bi bi-trash-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M2.5 1a1 1 0 00-1 1v1a1 1 0 001 1H3v9a2 2 0 002 2h6a2 2 0 002-2V4h.5a1 1 0 001-1V2a1 1 0 00-1-1H10a1 1 0 00-1-1H7a1 1 0 00-1 1H2.5zm3 4a.5.5 0 01.5.5v7a.5.5 0 01-1 0v-7a.5.5 0 01.5-.5zM8 5a.5.5 0 01.5.5v7a.5.5 0 01-1 0v-7A.5.5 0 018 5zm3 .5a.5.5 0 00-1 0v7a.5.5 0 001 0v-7z"
                                  clip-rule="evenodd"/>
                        </svg>
                        Delete
                    </button>
                </form>
            @endif
        </div>
    </div>
@endsection
