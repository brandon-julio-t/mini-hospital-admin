<h1>Welcome, {{ $staff->name }}</h1>

<section class="my-5">
    <h2>Patients Queue</h2>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">Patient ID</th>
                <th scope="col">Patient Name</th>
                <th scope="col">Doctor ID</th>
                <th scope="col">Doctor Name</th>
                <th scope="col">Doctor Specialist</th>
            </tr>
            </thead>
            <tbody>
            @forelse(DB::select('
                select p.id         as patient_id,
                       p.name       as patient_name,
                       d.id         as doctor_id,
                       d.name       as doctor_name,
                       d.specialist as doctor_specialist
                from patients p
                         join registration_forms rf on p.id = rf.patient_id
                         join doctors d on rf.doctor_id = d.id
                where p.id in (select patient_id
                               from registration_forms rf
                                        join receipt_headers rh on rf.id = rh.registration_form_id
                                        join receipt_medicine_details rmd on rh.id = rmd.receipt_id
                                        join receipt_doctor_details rdd on rh.id = rdd.receipt_id
                               where rh.finalized_at is null
                               group by patient_id
                               having count(rdd.doctor_charge_id) = 0)
            ') as $patient)
                <tr>
                    <th scope="row">{{ $patient->patient_id }}</th>
                    <td>{{ $patient->patient_name }}</td>
                    <th scope="row">{{ $patient->doctor_id }}</th>
                    <td>{{ $patient->doctor_name }}</td>
                    <td>{{ $patient->doctor_specialist }}</td>
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

<section class="my-5">
    <h2>Treated Patient</h2>
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
                select p.id         as patient_id,
                       p.name       as patient_name
                from patients p
                         join registration_forms rf on p.id = rf.patient_id
                where p.id in (select patient_id
                               from registration_forms rf
                                        join receipt_headers rh on rf.id = rh.registration_form_id
                                        join receipt_doctor_details rdd on rh.id = rdd.receipt_id
                               where rh.finalized_at is null
                               group by patient_id
                               having count(rdd.doctor_charge_id) > 0)
            ') as $patient)
                <tr>
                    <th scope="row" class="align-middle">{{ $patient->patient_id }}</th>
                    <td class="align-middle">{{ $patient->patient_name }}</td>
                    <td class="align-middle">
                        <a href="{{ route('patient.finalize.preparation', $patient->patient_id) }}"
                           class="btn btn-outline-dark">
                            Finalize Receipt
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

<section class="my-5">
    <h2>Treated Patient</h2>
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

<div class="row justify-content-center">
    <div class="col">
        <a href="{{ route('staffs.show', $staff->id) }}" class="btn btn-block btn-outline-dark">
            View Profile
        </a>
    </div>
    <div class="col">
        <a href="{{ route('patients.create') }}" class="btn btn-block btn-outline-primary">
            Register New Patient
        </a>
    </div>
</div>
