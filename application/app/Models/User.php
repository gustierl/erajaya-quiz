<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'code_pengguna',
        'code_cabang',
        'code_department'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getDataAll()
    {
        $data = User::select(
            'users.name','users.email',
            'roles.id as role_id',
            'users.id',
            'roles.name as role',
            'users.created_at')
        ->leftjoin('role_user','users.id','=','role_user.user_id')
        ->leftjoin('roles','role_user.role_id','=','roles.id')
        ->orderBy('users.created_at','desc')
        ->get();

        return $data;
    }
    public function totalUser()
    {
        $data = User::select(
            'users.name','users.email',
            'roles.id as role_id',
            'users.id',
            'roles.name as role_name',
            'users.created_at')
        ->leftjoin('role_user','users.id','=','role_user.user_id')
        ->leftjoin('roles','role_user.role_id','=','roles.id')
        ->orderBy('users.created_at','desc')
        ->where('roles.name','User')
        ->count();

        return $data;
    }
    public function getDataSingle($user_id)
    {
        $data = User::select(
            'users.name','users.email',
            'roles.id',
            'roles.name as role',
            'users.created_at')
        ->leftjoin('role_user','users.id','=','role_user.user_id')
        ->leftjoin('roles','role_user.role_id','=','roles.id')
        ->orderBy('users.created_at','desc')
        ->where('users.id',$user_id)
        ->first();

        return $data;
    }
    public function saveData($data,$role)
    {
        $user = User::create($data);
        $user->attachRole($role);
        return true;
    }
    public function editData($user_id,$data,$role)
    { 
        $user = User::where('id',$user_id)->update($data);
        $user->syncRoles(explode(',',$role));
        return true;
    }
    public function updatePassword($user_id,$data)
    { 
        $user = User::where('id',$user_id)->update($data);
        return true;
    }
    public function deleteData($id)
    {
        User::where('id', '=', $id)->delete();;
        return true;
    }
}
