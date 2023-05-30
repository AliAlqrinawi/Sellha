<?php

namespace App\Http\Controllers;

use App\Models\Denouncement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class DenouncementsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Gate::allows('denouncement-view')) {
            abort(500);
        }
        if ($request->ajax()) {
            $data = Denouncement::with('product' , 'user')->orderBy('id' , 'desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<button class="modal-effect btn btn-sm btn-danger" style="margin: 5px" id="showModalDeleteDenouncement" data-name="' . $row->reason . '" data-id="' . $row->id . '"><i class="las la-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action' => 'action'])->make(true);
        }
        return view('dashboard.views-dash.denouncement.index');
    }

    public function destroy($id)
    {
        $denouncement = Denouncement::find($id);
        if ($denouncement) {
            $denouncement->delete();
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

}
