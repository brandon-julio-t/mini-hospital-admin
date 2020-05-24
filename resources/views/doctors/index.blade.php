@extends('layouts.dashboard')

@section('dashboard')
    <section class="table-responsive">
        <h2>Manage Doctors</h2>

        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone Number</th>
                <th scope="col" colspan="2">Specialist</th>
            </tr>
            </thead>
            <tbody>
            @forelse (DB::select('select * from doctors') as $doctor)
                <tr>
                    <th scope="row" class="align-middle">{{ $doctor->id }}</th>
                    <td class="align-middle">{{ $doctor->name }}</td>
                    <td class="align-middle">{{ $doctor->email }}</td>
                    <td class="align-middle">{{ $doctor->phone_number }}</td>
                    <td class="align-middle">{{ $doctor->specialist }}</td>
                    <td class="align-middle">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        </button>
                        <form action="{{ route('doctors.destroy', $doctor->id) }}" method="POST" class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            @csrf
                            @method('DELETE')

                            <a href="{{ route('doctors.show', $doctor->id) }}"
                                class="dropdown-item" title="View">
                                <svg class="bi bi-eye-fill" width="1em" height="1em" viewBox="0 0 16 16"
                                        fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.5 8a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                                    <path fill-rule="evenodd"
                                            d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 100-7 3.5 3.5 0 000 7z"
                                            clip-rule="evenodd"/>
                                </svg>
                                View
                            </a>

                            <a href="{{ route('doctors.edit', $doctor->id) }}"
                                class="dropdown-item" title="Edit">
                                <svg class="bi bi-pencil" width="1em" height="1em" viewBox="0 0 16 16"
                                        fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                            d="M11.293 1.293a1 1 0 011.414 0l2 2a1 1 0 010 1.414l-9 9a1 1 0 01-.39.242l-3 1a1 1 0 01-1.266-1.265l1-3a1 1 0 01.242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z"
                                            clip-rule="evenodd"/>
                                    <path fill-rule="evenodd"
                                            d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 00.5.5H4v.5a.5.5 0 00.5.5H5v.5a.5.5 0 00.5.5H6v-1.5a.5.5 0 00-.5-.5H5v-.5a.5.5 0 00-.5-.5H3z"
                                            clip-rule="evenodd"/>
                                </svg>
                                Edit
                            </a>

                            <button type="submit" class="dropdown-item" title="Delete">
                                <svg class="bi bi-trash-fill" width="1em" height="1em"
                                        viewBox="0 0 16 16"
                                        fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                            d="M2.5 1a1 1 0 00-1 1v1a1 1 0 001 1H3v9a2 2 0 002 2h6a2 2 0 002-2V4h.5a1 1 0 001-1V2a1 1 0 00-1-1H10a1 1 0 00-1-1H7a1 1 0 00-1 1H2.5zm3 4a.5.5 0 01.5.5v7a.5.5 0 01-1 0v-7a.5.5 0 01.5-.5zM8 5a.5.5 0 01.5.5v7a.5.5 0 01-1 0v-7A.5.5 0 018 5zm3 .5a.5.5 0 00-1 0v7a.5.5 0 001 0v-7z"
                                            clip-rule="evenodd"
                                    />
                                </svg>
                                Fire
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No Doctor</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </section>

    <div class="row">
        <div class="col">
            <a href="{{ route('doctors.create') }}" class="btn btn-block btn-outline-dark">Add new Doctor</a>
        </div>
        <div class="col">
            <a href="{{ route('home') }}" class="btn btn-block btn-outline-danger">Return</a>
        </div>
    </div>
@endsection
