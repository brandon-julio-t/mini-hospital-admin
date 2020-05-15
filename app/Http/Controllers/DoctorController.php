<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDoctor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
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
        return view('doctors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        return view('doctors.edit')
            ->with('doctor', DB::selectOne("select * from doctors where id = ?", [$id]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
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
     * @return \Illuminate\Http\RedirectResponse
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
