@extends('layouts.dashboard')

@section('dashboard')
    <h1>Welcome, {{ $doctor->name }}</h1>

    <section class="my-5">
        <h2>Patients Queue</h2>
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
                    select p.id   as patient_id,
                           p.name as patient_name
                    from patients p
                             join registration_forms rf on p.id = rf.patient_id
                             join doctors d on rf.doctor_id = d.id
                    where d.id = ?
                      and p.id in (select patient_id
                                   from registration_forms rf
                                            join receipt_headers rh on rf.id = rh.registration_form_id
                                   where rh.finalized_at is null
                                   group by patient_id)
                      and (select count(*)
                           from receipt_doctor_details rdd
                                    join receipt_headers r on rdd.receipt_id = r.id
                                    join registration_forms f on r.registration_form_id = f.id
                           where f.patient_id = p.id) = 0
                ', [$doctor->id]) as $patient)
                    <tr>
                        <th scope="row" class="align-middle">{{ $patient->patient_id }}</th>
                        <td class="align-middle">{{ $patient->patient_name }}</td>
                        <td class="align-middle">
                            <a href="{{ route('treat.patient', $patient->patient_id) }}"
                               class="btn btn-block btn-outline-dark">
                                Treat Patient
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No patients in queue.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <a href="{{ route('password.reset.form') }}" class="btn btn-block btn-outline-dark">Edit Password</a>
@endsection
