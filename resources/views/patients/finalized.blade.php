@extends('layouts.dashboard')

@section('dashboard')
    <section>
        <h2>Finalized Patient</h2>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">Patient ID</th>
                    <th scope="col">Patient Name</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse(DB::select('
                    select p.id            as patient_id,
                           p.name          as patient_name,
                           rh.finalized_at as finalized_at
                    from patients p
                             join registration_forms rf on p.id = rf.patient_id
                             join receipt_headers rh on rf.id = rh.registration_form_id
                    where p.id in (select patient_id
                                   from registration_forms rf
                                            join receipt_headers rh on rf.id = rh.registration_form_id
                                   where rh.finalized_at is not null)
                ') as $patient)
                    <tr>
                        <th scope="row" class="align-middle">{{ $patient->patient_id }}</th>
                        <td class="align-middle">{{ $patient->patient_name }}</td>
                        <td class="align-middle">
                            <a href="{{ route('receipt', $patient->patient_id) }}" class="btn btn-outline-dark">
                                View Receipt
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No patients in queue.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <a href="{{ route('home') }}" class="btn btn-block btn-outline-dark">Return</a>
@endsection
