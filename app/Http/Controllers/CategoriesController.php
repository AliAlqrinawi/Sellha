<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Scopes\ActiveScope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Gate::allows('category-view')) {
            abort(500);
        }
        if ($request->ajax()) {
            $data = Category::where('parent_id' , NULL)->withoutGlobalScope(ActiveScope::class)->orderBy('id' , 'desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    $image = '<img src="' . asset('/') . $row->image . '" alt="image" width="50" height="50">';
                    return $image;
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == 'ACTIVE') {
                        $status = '<button class="modal-effect btn btn-sm btn-success" style="margin: 5px" id="status" data-id="' . $row->id . '" ><i class=" icon-check"></i></button>';
                    } else {
                        $status = '<button class="modal-effect btn btn-sm btn-danger" style="margin: 5px" id="status" data-id="' . $row->id . '" ><i class=" icon-check"></i></button>';
                    }
                    return $status;
                })
                ->addColumn('action', function ($row) {
                    // $btn = '<a class="modal-effect btn btn-sm btn-secondary" style="margin: 5px" href="'. route('business.index'). '?category='. $row->id .'"><i class="las la-clipboard"></i></a>';
                    $btn = '<button class="modal-effect btn btn-sm btn-info"  style="margin: 5px" id="showModalEditCategory" data-id="' . $row->id . '"><i class="las la-pen"></i></button>';
                    $btn = $btn . '<button class="modal-effect btn btn-sm btn-danger" style="margin: 5px" id="showModalDeleteCategory" data-name="' . $row->title_en . '" data-id="' . $row->id . '"><i class="las la-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns(['image' => 'image', 'status' => 'status', 'action' => 'action'])->make(true);
        }
        return view('dashboard.views-dash.category.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $categoryRequest)
    {
        Category::create($categoryRequest->categoryData());
        return ControllersService::responseSuccess(['message' => __('Added successfully') , 'status' => 200]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::withoutGlobalScope(ActiveScope::class)->find($id);
        if ($category) {
            return ControllersService::responseSuccess([
                'message' => __('Found Data'),
                'status' => 200,
                'data' => $category
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
    public function update(CategoryRequest $categoryRequest, $id)
    {
        Category::withoutGlobalScope(ActiveScope::class)->find($id)->update($categoryRequest->categoryData());
        return ControllersService::responseSuccess(['message' => __('updated successfully'),'status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::withoutGlobalScope(ActiveScope::class)->find($id);
        if ($category) {
            $category->delete();
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
        $category = Category::withoutGlobalScope(ActiveScope::class)->find($id);
        if ($category) {
            $category->changeStatus();
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
