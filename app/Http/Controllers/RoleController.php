<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function index (Request $request){
        if (!Gate::allows('role-view')) {
            abort(500);
        }
        if ($request->ajax()) {
            $data = Role::withCount('users')->select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('count', function ($row) {
                    return $row->users_count;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<button class="modal-effect btn btn-sm btn-info"  style="margin: 5px" id="showModalEditRole" data-id="' . $row->id . '"><i class="las la-pen"></i></button>';
                    $btn = $btn . '<button class="modal-effect btn btn-sm btn-danger" style="margin: 5px" id="showModalDeleteRole" data-name="' . $row->name . '" data-id="' . $row->id . '"><i class="las la-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns([
                    // 'count' => 'count',
                    'action' => 'action',
                ])
                ->make(true);
        }
        return view('dashboard.views-dash.role.index');
    }

    public function store (Request $request){
        $role = new Role();
        $role->name = $request->name;
        $role->permissions = $request->permissions;
        $role->save();
    }

    public function edit($id)
    {
        $roleTable = Role::find($id);
        if ($roleTable) {
            $response = [
                'message' => __('success'),
                'status' => 200,
                'data' => $roleTable
            ];
            return ControllersService::responseSuccess($response);
        } else {
            $response = [
                'message' => __('Not Found Data'),
                'status' => 400,
            ];
            return ControllersService::responseErorr($response);
        }
    }

    public function update(Request $request, $id)
    {

        $role = Role::find($id);
        $role->name = $request->name;
        $role->permissions = $request->permissions;
        $role->update();
        $response = [
            'message' => __('Updated successfully'),
            'status' => 200,
        ];
        return ControllersService::responseSuccess($response);
    }

    public function destroy($id)
    {
        $roleTable = Role::find($id);
        if ($roleTable) {
            $roleTable->delete();
            $response = [
                'message' => __('Deleted successfully'),
                'status' => 200,
            ];
            return ControllersService::responseSuccess($response);
        } else {
            $response = [
                'message' => __('Not Found Data'),
                'status' => 400,
            ];
            return ControllersService::responseErorr($response);
        }
    }
}
