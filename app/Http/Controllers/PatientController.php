<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePatient;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return response(null, 501);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('patients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePatient $request
     * @return RedirectResponse
     */
    public function store(StorePatient $request)
    {
        $patientData = $request->validated();

        $latestPatientId = DB::selectOne('select id from patients order by id desc')->id ?? 0;
        $latestRegistrationFormId = DB::selectOne('select id from registration_forms order by id desc')->id ?? 0;

        $nextPatientId = sprintf('PT%03d', $latestPatientId + 1);
        $nextRegistrationFormId = sprintf('F%04d', $latestRegistrationFormId + 1);

        $currentStaffId = DB::selectOne('select id from staffs where user_id = ?', [Auth::id()])->id;

        DB::beginTransaction();

        DB::insert('
            insert into patients (id, address, date_of_birth, name, phone_number, sex)
            values (:id, :address, :date_of_birth, :name, :phone_number, :sex)
        ', [
            'id' => $nextPatientId,
            'address' => $patientData['address'],
            'date_of_birth' => $patientData['date_of_birth'],
            'name' => $patientData['name'],
            'phone_number' => $patientData['phone_number'],
            'sex' => $patientData['sex'],
        ]);

        DB::insert('
            insert into registration_forms (id, doctor_id, patient_id, staff_id, created_at)
            values (:id, :doctor_id, :patient_id, :staff_id, :created_at)
        ', [
            'id' => $nextRegistrationFormId,
            'doctor_id' => $patientData['doctor_id'],
            'patient_id' => $nextPatientId,
            'staff_id' => $currentStaffId,
            'created_at' => Carbon::now()
        ]);

        DB::commit();

        return redirect()->route('home')->with('status', 'Patient added');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return response(null, 501);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        return response(null, 501);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        return response(null, 501);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        return response(null, 501);
    }
}
