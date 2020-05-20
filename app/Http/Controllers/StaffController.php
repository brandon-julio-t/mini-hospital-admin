<?php

namespace App\Http\Controllers;

use App\Http\Requests\FinalizeReceipt;
use App\Http\Requests\StoreStaff;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class StaffController extends Controller
{
    public function finalizePreparation($patient_id)
    {
        if (!auth()->user()->isStaff()) {
            return response(null, 403);
        }

        return view('staffs.finalize')
            ->with('patient', DB::selectOne('select * from patients where id = ?', [$patient_id]))
            ->with('doctor', DB::selectOne('
                select d.name as name
                from doctors d
                         join registration_forms rf on d.id = rf.doctor_id
                where rf.patient_id = ?
            ', [$patient_id]))
            ->with('hospitalCharges', DB::select('select * from hospital_charges'));
    }

    public function finalizeReceipt(FinalizeReceipt $request, $patient_id)
    {
        $data = $request->validated();

        DB::transaction(function () use ($data, $patient_id) {
            DB::update("
                update receipt_headers
                set finalized_at = :timestamp
                where registration_form_id = (select rf.id
                                              from receipt_headers rh
                                                       join registration_forms rf on rh.registration_form_id = rf.id
                                              where rf.patient_id = :patient_id)
            ", [
                'timestamp' => now(),
                'patient_id' => $patient_id,
            ]);

            $receipt_id = DB::selectOne('
                select rh.id
                from receipt_headers rh
                         join registration_forms rf on rh.registration_form_id = rf.id
                where patient_id = ?
            ', [$patient_id])->id;

            foreach (collect($data['hospitalCharges'])->keys() as $hospitalChargeId) {
                DB::insert("
                    insert into receipt_hospital_details
                    values (:receipt_id, :hospital_charge_id)
                ", [
                    'receipt_id' => $receipt_id,
                    'hospital_charge_id' => $hospitalChargeId,
                ]);
            }
        });

        return redirect()->route('home')->with('status', 'Patient receipt finalized');
    }

    public function viewReceipt($patient_id)
    {
        return view('staffs.receipt')
            ->with('patient', DB::selectOne('select * from patients where id = ?', [$patient_id]))
            ->with('medicines', DB::select('
                select m.name, m.disease, m.type, rmd.quantity
                from medicines m
                         join receipt_medicine_details rmd on m.id = rmd.medicine_id
                         join receipt_headers rh on rmd.receipt_id = rh.id
                         join registration_forms rf on rh.registration_form_id = rf.id
                where patient_id = ?
            ', [$patient_id]))
            ->with('doctor', DB::selectOne('
                select d.name
                from doctors d
                         join registration_forms rf on d.id = rf.doctor_id
                where patient_id = ?
            ', [$patient_id]))
            ->with('hospitalCharges', DB::select('
                select hc.name, hc.amount
                from hospital_charges hc
                         join receipt_hospital_details rhd on hc.id = rhd.hospital_charge_id
                         join receipt_headers rh on rhd.receipt_id = rh.id
                         join registration_forms rf on rh.registration_form_id = rf.id
                where patient_id = ?
            ', [$patient_id]))
            ->with('doctorCharges', DB::select('
                select dc.name, dc.amount
                from doctor_charges dc
                         join receipt_doctor_details rdd on dc.id = rdd.doctor_charge_id
                         join receipt_headers rh on rdd.receipt_id = rh.id
                         join registration_forms rf on rh.registration_form_id = rf.id
                where patient_id = ?
            ', [$patient_id]))
            ->with('staff', DB::selectOne('
                select s.name
                from staffs s
                         join registration_forms rf on s.id = rf.staff_id
                where patient_id = ?
            ', [$patient_id]))
            ->with('receipt', DB::selectOne('
                select rf.created_at, rh.finalized_at
                from receipt_headers rh
                         join registration_forms rf on rh.registration_form_id = rf.id
                where patient_id = ?
            ', [$patient_id]))
            ->with('hospitalChargeSubtotal', DB::selectOne('
                select sum(hc.amount) as subtotal
                from hospital_charges hc
                         join receipt_hospital_details rhd on hc.id = rhd.hospital_charge_id
                         join receipt_headers rh on rhd.receipt_id = rh.id
                         join registration_forms rf on rh.registration_form_id = rf.id
                where patient_id = ?
            ', [$patient_id]))
            ->with('doctorChargeSubtotal', DB::selectOne('
                select sum(dc.amount) as subtotal
                from doctor_charges dc
                         join receipt_doctor_details rhd on dc.id = rhd.doctor_charge_id
                         join receipt_headers rh on rhd.receipt_id = rh.id
                         join registration_forms rf on rh.registration_form_id = rf.id
                where patient_id = ?
            ', [$patient_id]))
            ;
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
        return view('staffs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreStaff $request
     * @return RedirectResponse
     */
    public function store(StoreStaff $request)
    {
        $data = $request->validated();

        $latestUserId = DB::selectOne('select id from users order by id desc')->id ?? 0;
        $latestStaffId = DB::selectOne('select id from staffs order by id desc')->id ?? 0;

        $nextUserId = intval(substr($latestUserId, 1)) + 1;
        $nextStaffId = intval(substr($latestStaffId, 2)) + 1;

        $user_id = sprintf('U%04d', $nextUserId);
        $staff_id = sprintf('ST%03d', $nextStaffId);

        DB::beginTransaction();

        DB::insert("
            insert into users (id, username, password)
            values (:user_id, :staff_id, :dob)
        ", [
            'user_id' => $user_id,
            'staff_id' => $staff_id,
            'dob' => Hash::make(str_replace('-', '', $data['date_of_birth']))
        ]);

        DB::insert("
            insert into staffs (id, user_id, address, date_of_birth, name, phone_number, role, salary)
            values (:staff_id, :user_id, :address, :date_of_birth, :name, :phone_number, :role, :salary)
        ", [
            'staff_id' => $staff_id,
            'user_id' => $user_id,
            'address' => $data['address'],
            'date_of_birth' => $data['date_of_birth'],
            'name' => $data['name'],
            'phone_number' => $data['phone_number'],
            'role' => $data['role'],
            'salary' => $data['salary'],
        ]);

        DB::commit();

        return redirect()->route('home')->with('status', 'Staff added');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
        return view('staffs.show', ['staff' => DB::selectOne('select * from staffs where id = ?', [$id])]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        return view('staffs.edit', [
            'staff' => DB::selectOne('select * from staffs where id = ?', [$id])
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreStaff $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(StoreStaff $request, $id)
    {
        $data = $request->validated();

        DB::update("
            update staffs
            set address = :address,
                date_of_birth = :date_of_birth,
                name = :name,
                phone_number = :phone_number,
                role = :role,
                salary = :salary
            where id = :id
        ", [
            'id' => $id,
            'address' => $data['address'],
            'date_of_birth' => $data['date_of_birth'],
            'name' => $data['name'],
            'phone_number' => $data['phone_number'],
            'role' => $data['role'],
            'salary' => $data['salary'],
        ]);

        return redirect()->route('home')->with('status', 'Staff updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param String $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $user_id = DB::selectOne('select user_id from staffs where id = ?', [$id])->user_id;

        DB::beginTransaction();

        DB::delete('delete from staffs where id = ?', [$id]);
        DB::delete('delete from users where id = ?', [$user_id]);

        DB::commit();

        return redirect()->route('home')->with('status', 'Staff fired');
    }
}
