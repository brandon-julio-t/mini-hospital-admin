<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'char(5)';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    public function isAdmin()
    {
        return DB::selectOne('select * from admins where user_id = ?', [Auth::id()]) !== null;
    }

    public function isStaff()
    {
        return DB::selectOne('select * from staffs where user_id = ?', [Auth::id()]) !== null;
    }

    public function isDoctor()
    {
        return DB::selectOne('select * from doctors where user_id = ?', [Auth::id()]) !== null;
    }
}
