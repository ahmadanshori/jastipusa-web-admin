<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use Auth;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Helpers\Bahasa;
use Validator;
use Illuminate\Support\Facades\Hash;
use DB;


class UserController extends Controller

{

    public function __construct(Role $role, User $user)
    {
        $this->role = $role;
        $this->user = $user;
    }
    
    public function index()
    {
        $user = $this->user->latest()->get();
        return view('user.index', compact('user'));
    }

    public function create()
    {
        $role =  $this->role->latest()->get();
        return view('user.form', compact('role'));
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:6', 'confirmed'],
            'password_confirmation' => ['required', 'min:6',]
        ]);

        if ($validation->passes()) {
            $data = [
                'name'  => $request->name,
                'role_id' => $request->role,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'created_by' =>  Auth::id(),
                'updated_by' =>  Auth::id(),
            ];
            $user = $this->user->create($data);
            $role = $this->role->find($request->input('role'));

            if ($role) {
                $user->assignRole($role->name);
            }

            \Session::flash('success', 'Account has been created');
            return redirect()->route('user.index');
        } else {
            return redirect()->back()
                ->withErrors($validation)->withInput();
        }
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $user = $this->user->where('id', $id)->first();
        $role =  $this->role->latest()->get();
        return view('user.form', compact('role', 'user'));
    }


    public function update(Request $request, $id)
    {
        $user = $this->user->where('id', $id)->first();

        $validation = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'role' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id],
        ]);


        if ($validation->passes()) {
            $data = [
                'name'  => $request->name,
                'role_id' => $request->role,
                'email' => $request->email,
                'updated_by' =>  Auth::id(),
            ];

            $user->update($data);
            DB::table('model_has_roles')->where('model_id', $id)->delete();
            $role = $this->role->find($request->input('role'));

            if ($role) {
                $user->assignRole($role->name);
            }

            \Session::flash('success', 'Account has been updated');
            return redirect()->route('user.index');
        } else {
            return redirect()->back()
                ->withErrors($validation)->withInput();
        }
    }

    public function changePassword(Request $request, $id)
    {
        $user = $this->user->where('id', $id)->first();

        $validation = Validator::make($request->all(), [
            'password' => ['required', 'min:6', 'confirmed'],
            'password_confirmation' => ['required', 'min:6',]
        ]);


        if ($validation->passes()) {
            $data = [
                'password' => Hash::make($request->password),
                'updated_by' =>  Auth::id(),
            ];
            $user->update($data);

            \Session::flash('success', 'Account has been updated');
            return redirect()->route('user.index');
        } else {
            return redirect()->back()
                ->withErrors($validation)->withInput();
        }
    }

    public function destroy($id)
    {
        $user = $this->user->where('id', $id)->first();

        $user->delete();

        \Session::flash('success', 'account has been Deleted');
        return redirect()->route('user.index');
    }

    public function ajax()
    {
        $users = $this->user->latest()->get();

        return Datatables::of($users)
            ->addColumn('role', function ($users) {
                $user = $users;
                $role = $this->role->where('id',$user->role_id)->first();
                return isset($role) ?  $role->name : '';
            })
            ->addColumn('actions', function ($users) {
                $user = $users;
                return view('user.action', compact('user'))->render();
            })->rawColumns(['actions','role'])->make(true);
    }

}
