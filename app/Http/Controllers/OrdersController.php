<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        if (!Gate::allows('order-view')) {
            abort(500);
        }
        if ($request->ajax()) {
            $data = Order::with('buyer', 'seller', 'product')->orderBy('id', 'desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    if ($row->status == 'PENDING') {
                        $status = '<button class="modal-effect btn btn-light  " id="status" data-id="' . $row->id . '">' . __('PENDING') . '</button>';
                    } elseif ($row->status == 'PROCESSING') {
                        $status = '<button class="modal-effect btn btn-secondary " id="status" data-id="' . $row->id . '">' . __('PROCESSING') . '</button>';
                    } elseif ($row->status == 'DELIVERING') {
                        $status = '<button class="modal-effect btn btn-info " id="status" data-id="' . $row->id . '">' . __('DELIVERING') . '</button>';
                    } elseif ($row->status == 'COMPLETED') {
                        $status = '<button class="modal-effect btn btn-success " id="status" data-id="' . $row->id . '">' . __('COMPLETED') . '</button>';
                    } elseif ($row->status == 'CANCELLED') {
                        $status = '<button class="modal-effect btn btn-danger " id="status" data-id="' . $row->id . '">' . __('CANCELLED') . '</button>';
                    } elseif ($row->status == 'REFUNDED') {
                        $status = '<button class="modal-effect btn btn-warning " id="status" data-id="' . $row->id . '">' . __('REFUNDED') . '</button>';
                    } else {
                        $status = '<button class="modal-effect btn btn-info " id="status" data-id="' . $row->id . '">' . __('Erorr') . '</button>';
                    }
                    return $status;
                })
                ->addColumn('payment_status', function ($row) {
                    if ($row->payment_status == 'PENDING') {
                        $status = '<button class="btn btn-light">' . __('PENDING') . '</button>';
                    } elseif ($row->payment_status == 'PAID') {
                        $status = '<button class="btn btn-success">' . __('PAID') . '</button>';
                    } else {
                        $status = '<button class="btn btn-danger">' . __('FAILED') . '</button>';
                    }
                    return $status;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<button class="modal-effect btn btn-sm btn-secondary" style="margin: 5px" id="showModalOrder" data-id="' . $row->id . '" ><i class="fab fa-viadeo"></i></button>';
                    $btn = $btn . '<button class="modal-effect btn btn-sm btn-danger" style="margin: 5px" id="showModalDeleteOrder" data-name="' . $row->id . '" data-id="' . $row->id . '"><i class="las la-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns(['status' => 'status', 'payment_status' => 'payment_status', 'action' => 'action'])->make(true);
        }
        return view('dashboard.views-dash.order.index');
    }

    public function show(Request $request , $id)
    {
        $order = Order::with('buyer', 'seller', 'product.category' , 'product.sub_category')->find($id);
        if ($order) {
            return ControllersService::responseSuccess([
                'message' => __('Found Data'),
                'status' => 200,
                'data' => $order
            ]);
        }
        return ControllersService::responseErorr([
            'message' => __('Not Found Data'),
            'status' => 400,
        ]);
    }

    public function destroy($id)
    {
        $order = Order::find($id);
        if ($order) {
            $order->delete();
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
        $order = Order::find($id);
        if ($order) {
            $order->changeStatus();
            return ControllersService::responseSuccess([
                'message' => __('Updated successfully'),
                'status' => 200,
            ]);
        } else {
            return ControllersService::responseErorr([
                'message' => __('Not Found Data'),
                'status' => 400,
            ]);
        }
    }
}
