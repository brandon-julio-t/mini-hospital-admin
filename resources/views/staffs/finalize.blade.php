@extends('layouts.slim')

@section('body')

    <div class="card">
        <div class="card-header">Finalize Receipt</div>

        <div class="card-body">
            <section>
                <h2>Patient Information</h2>
                <div class="table-responsive">
                    <table class="table table-borderless table-hover">
                        <tr>
                            <th scope="row">Name</th>
                            <td>{{ $patient->name }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Date of Birth</th>
                            <td>{{ $patient->date_of_birth }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Doctor Name</th>
                            <td>{{ $doctor->name }}</td>
                        </tr>
                    </table>
                </div>
            </section>

            <section>
                <h2>Hospital Charges</h2>

                @if ($errors->any())
                    <h3 class="text-danger">Errors</h3>
                    <ul>
                        @foreach($errors->all() as $message)
                            <li class="text-danger">{{ $message }}</li>
                        @endforeach
                    </ul>
                @endif

                <form action="{{ route('patient.finalize', $patient->id) }}" method="POST">
                    @csrf

                    @forelse($hospitalCharges as $hospitalCharge)
                        <div class="form-check">
                            <input type="checkbox"
                                   class="form-check-input @if($errors->any()) is-invalid @enderror"
                                   name="hospitalCharges[{{ $hospitalCharge->id }}]"
                                   id="{{ $hospitalCharge->id }}"
                                   @if ($hospitalCharge->id == 'HC001') checked @endif>
                            <label class="form-check-label" for="{{ $hospitalCharge->id }}">
                                {{ $hospitalCharge->name }}
                            </label>
                        </div>
                    @empty
                        <p class="text-center">No data</p>
                    @endforelse


                    <button type="submit" class="btn btn-block btn-outline-dark mt-3">
                        Submit
                    </button>
                </form>
            </section>
        </div>
    </div>

@endsection
