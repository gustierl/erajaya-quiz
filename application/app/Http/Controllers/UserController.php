<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    private $user;
    public function __construct()
    {
        $this->user         = new User();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $this->user->getDataAll();
        if($request->ajax())
            {
                return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<button class="btn btn-sm btn-icon btn-outline-dark mr-1 edit-data" data-toggle="tooltip" title="Edit"  data-id="'.$row->id.'" data-original-title="Edit"><i class="ri-edit-2-line"></i></button> ';
                    $btn = $btn.'<button class="btn btn-sm btn-icon btn-outline-danger mr-1 delete-data" data-toggle="tooltip" title="Edit"  data-id="'.$row->id.'" data-name="'.$row->name.'" data-original-title="delete"><i class="mdi mdi-delete"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
            }
        return view('users')->with(['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->code == null) {
            $rules  = [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'confirmed'],
                'role'=>['required']

            ];
            $message = [
                'name.required'=>'Nama harus diisi',
                'name.string'=>'Nama harus berupa karakter',
                'name.max'=>'Nama maks.  255 karakter',
                'email.required'=>'Email harus diisi',
                'email.email'=>'Email tidak valid',
                'email.max'=>'Email maks. 255 karakter',
                'email.unique'=>'Email sudah terdaftar',
                'password.required'=>'Password harus diisi',
                'password.confirmed'=>'Pasword tidak cocok',
                'role.required'=>'Role harus diisi',
            ];
         } else {
            $rules  = [
                'name' => ['required', 'string', 'max:255'],
                'role'=>['required']

            ];
            $message = [
                'name.required'=>'Nama harus diisi',
                'name.string'=>'Nama harus berupa karakter',
                'name.max'=>'Nama maks.  255 karakter',
                'role.required'=>'Role harus diisi',
            ];
        }

        $validator = Validator::make($request->all(), $rules,$message);
        if($validator->passes()){
            if ($request->code == null) {
                $data = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ];
                $this->user->saveData($data,$request->role);
            } else {
                $user = User::updateOrCreate(
                    ['id' => $request->code],
                    [
                    'name' => $request->name,
                    ]);
                    $user->syncRoles(explode(',',$request->role));
            }
            return response()->json(['status'=>'success','message'=>' Data Berhasil Disimpan.']);
        }else{
            return response()->json(['status'=>'failed','message'=>$validator->errors()]);
        }
    }

    public function changePassword(Request $request)
    {

        $rules  = [
            'new_password'        => 'required|confirmed|min:8|string',
            'new_password_confirmation' => 'required',

        ];
        $message = [
            'new_password.required'                 => 'Password harus diisi',
            'new_password_confirmation.required'    => 'Konfirmasi Password harus diisi',
            'new_password.confirmed'   => 'Password tidak cocok',

        ];

        $validator = Validator::make($request->all(), $rules,$message);
        if($validator->passes()){
            $data = [
                'password' => Hash::make($request->new_password),
            ];
            $this->user->updatePassword($request->code,$data);
            return response()->json(['status'=>'success','message'=>' Data Berhasil Disimpan.']);
        }else{
            return response()->json(['status'=>'failed','message'=>$validator->errors()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->user->getDataSingle($id);
        return response()->json($data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->user->deleteData($id);
        return response()->json(['success'=>'Data berhasil dihapus']);
    }

}
