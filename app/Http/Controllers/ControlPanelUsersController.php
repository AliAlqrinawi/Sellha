<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use App\Models\Profile;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class ControlPanelUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Gate::allows('admin-view')) {
            abort(500);
        }
        $roles = Role::get();
        if ($request->ajax()) {
            $data = User::where('type', 'ADMIN')->with('roles')->orderBy('id', 'desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    if ($row->id != 1) {
                        if ($row->status == 'ACTIVE') {
                            $status = '<button class="modal-effect btn btn-sm btn-success" style="margin: 5px" id="status" data-id="' . $row->id . '" ><i class=" icon-check"></i></button>';
                        } else {
                            $status = '<button class="modal-effect btn btn-sm btn-danger" style="margin: 5px" id="status" data-id="' . $row->id . '" ><i class=" icon-check"></i></button>';
                        }
                        return $status;
                    }
                })
                ->addColumn('action', function ($row) {
                    if ($row->id != 1) {
                        $btn = '<button class="modal-effect btn btn-sm btn-info"  style="margin: 5px" id="showModalEditAdmin" data-id="' . $row->id . '"><i class="las la-pen"></i></button>';
                        $btn = $btn . '<button class="modal-effect btn btn-sm btn-danger" style="margin: 5px" id="showModalDeleteAdmin" data-name="' . $row->name . '" data-id="' . $row->id . '"><i class="las la-trash"></i></button>';
                        return $btn;
                    }
                })
                ->rawColumns(['status' => 'status', 'action' => 'action'])->make(true);
        }
        return view('dashboard.views-dash.panelUsers.index' , compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminRequest $adminRequest)
    {
        $data = $adminRequest->all();
        $data['phone'] = $data['email'];
        $data['otp'] = 852300;
        $data['type'] = 'ADMIN';
        $data['password'] = Hash::make($data['password']);
        $admin = User::create($data);
        Profile::create(['user_id' => $admin->id]);
        RoleUser::create([
            'role_id' => $data['role_id'],
            'user_id' => $admin->id,
        ]);
        return ControllersService::responseSuccess(['message' => __('Added successfully'), 'status' => 200]);
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
        $admin = User::with('roles')->find($id);
        if ($admin) {
            return ControllersService::responseSuccess([
                'message' => __('Found Data'),
                'status' => 200,
                'data' => $admin
            ]);
        }
        return ControllersService::responseErorr([
            'message' => __('Not Found Data'),
            'status' => 400,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminRequest $adminRequest, $id)
    {
        $data = $adminRequest->all();
        if(isset($data['password'])){
            $data['password'] = Hash::make($data['password']);
        }else{
            $data['password'] = User::find($id)->password;
        }
        User::find($id)->update($data);
        RoleUser::where('user_id' , $id)->update([
            'role_id' => $data['role_id'],
        ]);
        return ControllersService::responseSuccess(['message' => __('Updated successfully'), 'status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admin = User::find($id);
        if ($admin) {
            $admin->delete();
            return ControllersService::responseSuccess([
                'message' => __('Deleted successfully'),
                'status' => 200,
            ]);
        }
        return ControllersService::responseErorr([
            'message' => __('Not Found Data'),
            'status' => false,
        ]);
    }

    public function status($id)
    {
        $admin = User::find($id);
        if ($admin) {
            $admin->changeStatus();
            return ControllersService::responseSuccess([
                'message' => __('Updated successfully'),
                'status' => 200,
            ]);
        } else {
            return ControllersService::responseErorr([
                'message' =>  __('Not Found Data'),
                'status' => false,
            ]);
        }
    }
}
