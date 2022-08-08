<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
    private $user;
    public function __construct()
    {
        $this->user = new User();
    }
    public function index()
    {
        $data = $this->user->getDataAll();
        return response()->json(['status'=>'success','data'=>$data]);
    }
}
