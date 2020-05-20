<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDoctor;
use App\Http\Requests\StoreTreatment;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class DoctorController extends Controller
{
    public function treat($patient_id)
    {
        return view('doctors.treat')
            ->with('patient', DB::selectOne('select * from patients where id = ?', [$patient_id]));
    }

    public function finishTreatment(StoreTreatment $request, $patient_id)
    {
        $data = $request->validated();

        DB::transaction(function () use ($data, $patient_id) {
            $receiptHeaderId = DB::selectOne("
                select rh.id
                from receipt_headers rh
                     join registration_forms rf on rh.registration_form_id = rf.id
                where patient_id = 'PT001'
            ")->id;

            $medicines = collect($data['medicines'])->reject(function ($value, $key) {
                return $value <= 0;
            });
            $medicineIds = $medicines->keys();

            foreach ($medicineIds as $medicineId) {
                DB::insert("
                    insert into receipt_medicine_details
                    values (:receipt_header_id, :medicine_id, :quantity)
                ", [
                    'receipt_header_id' => $receiptHeaderId,
                    'medicine_id' => $medicineId,
                    'quantity' => $medicines->get($medicineId),
                ]);
            }

            $doctorCharges = collect($data['charges']);
            $doctorChargeIds = $doctorCharges->keys();

            foreach ($doctorChargeIds as $doctorChargeId) {
                DB::insert("
                    insert into receipt_doctor_details
                    values (:receipt_header_id, :doctor_charge_id)
                ", [
                    'receipt_header_id' => $receiptHeaderId,
                    'doctor_charge_id' => $doctorChargeId,
                ]);
            }
        });

        return redirect()->route('home')->with('status', 'Patient treated');
    }

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
        return view('doctors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDoctor $request
     * @return RedirectResponse
     */
    public function store(StoreDoctor $request)
    {
        $data = $request->validated();

        $latestUserId = DB::selectOne('select id from users order by id desc')->id ?? 0;
        $latestDoctorId = DB::selectOne('select id from doctors order by id desc')->id ?? 0;

        $nextUserId = intval(substr($latestUserId, 1)) + 1;
        $nextDoctorId = intval(substr($latestDoctorId, 2)) + 1;

        $user_id = sprintf('U%04d', $nextUserId);
        $doctor_id = sprintf('DR%03d', $nextDoctorId);

        DB::beginTransaction();

        DB::insert("
            insert into users (id, username, password)
            values (:user_id, :doctor_id, :dob)
        ", [
            'user_id' => $user_id,
            'doctor_id' => $doctor_id,
            'dob' => Hash::make(str_replace('-', '', $data['date_of_birth']))
        ]);

        DB::insert("
            insert into doctors (id, user_id, address, date_of_birth, email, name, phone_number, specialist, salary)
            values (:doctor_id, :user_id, :address, :date_of_birth, :email, :name, :phone_number, :specialist, :salary)
        ", [
            'doctor_id' => $doctor_id,
            'user_id' => $user_id,
            'address' => $data['address'],
            'date_of_birth' => $data['date_of_birth'],
            'name' => $data['name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'specialist' => $data['specialist'],
            'salary' => $data['salary'],
        ]);

        DB::commit();

        return redirect()->route('home')->with('status', 'Doctor added');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
        return view('doctors.show')
            ->with('doctor', DB::selectOne("select * from doctors where id = ?", [$id]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        return view('doctors.edit')
            ->with('doctor', DB::selectOne("select * from doctors where id = ?", [$id]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreDoctor $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(StoreDoctor $request, $id)
    {
        $data = $request->validated();

        DB::update("
            update doctors
            set address = :address,
                date_of_birth = :date_of_birth,
                email = :email,
                name = :name,
                phone_number = :phone_number,
                salary = :salary,
                specialist = :specialist
            where id = :id
        ", [
            'id' => $id,
            'address' => $data['address'],
            'date_of_birth' => $data['date_of_birth'],
            'name' => $data['name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'salary' => $data['salary'],
            'specialist' => $data['specialist'],
        ]);

        return redirect()->route('home')->with('status', 'Doctor updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $user_id = DB::selectOne('select user_id from doctors where id = ?', [$id])->user_id;

        DB::beginTransaction();

        DB::delete("delete from doctors where id = ?", [$id]);
        DB::delete('delete from users where id = ?', [$user_id]);

        DB::commit();

        return redirect()->route('home')->with('status', 'Doctor fired');
    }
}
