<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStaff;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(null, 501);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        return view('staffs.show', ['staff' => DB::selectOne('select * from staffs where id = ?', [$id])]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
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
