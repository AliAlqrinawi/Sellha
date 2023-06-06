<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStore;
use App\Models\Category;
use App\Models\File;
use App\Models\Product;
use App\Models\Scopes\ActiveScope;
use App\Models\User;
use App\Services\ProductStoreService;
use App\Services\ProductUpdateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Throwable;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

use function PHPUnit\Framework\isEmpty;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Gate::allows('product-view')) {
            abort(500);
        }
        if ($request->ajax()) {
            $data = Product::with('category' , 'user')->withoutGlobalScope(ActiveScope::class)->orderBy('id', 'desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('file', function ($row) {
                    $image = '<img src="' .  $row->file . '" alt="file" width="50" height="50">';
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
                    $btn = '<button class="modal-effect btn btn-sm btn-secondary" style="margin: 5px" id="showModalProduct" data-id="' . $row->id . '" ><i class="fab fa-viadeo"></i></button>';
                    $btn = $btn . '<a href="'.route('product.edit' , $row->id).'" class="modal-effect btn btn-sm btn-info"  style="margin: 5px"><i class="las la-pen"></i></a>';
                    $btn = $btn . '<button class="modal-effect btn btn-sm btn-danger" style="margin: 5px" id="showModalDeleteProduct" data-name="' . $row->title_en . '" data-id="' . $row->id . '"><i class="las la-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns(['file' => 'file', 'status' => 'status', 'action' => 'action'])->make(true);
        }
        return view('dashboard.views-dash.product.index');
    }


    public function create()
    {
        $categories = Category::where('parent_id', NULL)->withoutGlobalScope(ActiveScope::class)->get();
        $subCategories = Category::where('parent_id', '!=', NULL)->withoutGlobalScope(ActiveScope::class)->get();
        $users = User::where('type', 'USER')->get();
        return view('dashboard.views-dash.product.create', compact('categories', 'subCategories', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ProductStoreService $productStoreService)
    {
        $request->validate([
            'title_en' => 'required|max:255',
            'title_ar' => 'required|max:255',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric',
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:ACTIVE,INACTIVE',
            'description_ar' => 'required|max:255',
            'description_en' => 'required|max:255',
            'lat' => 'required',
            'lng' => 'required',
            'file' => 'required|image',
            'files' => 'nullable',
            'type' => 'required|in:NEW,LIKENEW,GOOD,NOTSODUSTY,OLD',
            'show' => 'nullable|in:BEST-DEALS,NEW-ARRIVALS,MOST-WANTED,DEALS-OF-THE-WEEK',
            'category_id' => 'required|integer|exists:categories,id',
            'sub_category_id' => 'required|integer|exists:categories,id',
        ]);
        $data = $request->all();
        if ($request->file('file')) {
            $name = Str::random(12);
            $path = $request->file('file');
            $name = $name . time() . '.' . $request->file('file')->getClientOriginalExtension();
            $path->move('uploads/products/', $name);
            $data['file'] = 'uploads/products/' . $name;
        }
        $product = Product::create($data);
        $files = $request->file('files');
        if(isset($files)){
        foreach ($files as $file) {
                $name = Str::random(12);
                $path = $file;
                $name = $name . time() . '.' . $file->getClientOriginalExtension();
                $file->move('uploads/products/', $name);
                $filePath = 'uploads/products/' . $name;
                File::create([
                    'file' => $filePath,
                    'product_id' => $product->id,
                ]);
        };
    }
        return redirect()->route('product.index')->with('success', __('Added successfully'));
    }

        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::with('user' , 'category' , 'sub_category')->withoutGlobalScope(ActiveScope::class)->find($id);
        if ($product) {
            return ControllersService::responseSuccess([
                'message' => __('Found Data'),
                'status' => 200,
                'data' => $product
            ]);
        }
        return ControllersService::responseErorr([
            'message' => __('Not Found Data'),
            'status' => 400,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::withoutGlobalScope(ActiveScope::class)->find($id);
        $categories = Category::where('parent_id', NULL)->withoutGlobalScope(ActiveScope::class)->get();
        $subCategories = Category::where('parent_id', '!=', NULL)->withoutGlobalScope(ActiveScope::class)->get();
        $users = User::where('type', 'USER')->get();
        return view('dashboard.views-dash.product.update', compact('product' , 'categories', 'subCategories', 'users'));
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
        $request->validate([
            'title_en' => 'required|max:255',
            'title_ar' => 'required|max:255',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric',
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:ACTIVE,INACTIVE',
            'description_ar' => 'required|max:255',
            'description_en' => 'required|max:255',
            'lat' => 'required',
            'lng' => 'required',
            'file' => 'nullable|image',
            'files' => 'nullable',
            'type' => 'required|in:NEW,LIKENEW,GOOD,NOTSODUSTY,OLD',
            'show' => 'required|in:BEST-DEALS,NEW-ARRIVALS,MOST-WANTED,DEALS-OF-THE-WEEK',
            'category_id' => 'required|integer|exists:categories,id',
            'sub_category_id' => 'required|integer|exists:categories,id',
        ]);
        $data = $request->all();
        if ($request->file('file')) {
            $name = Str::random(12);
            $path = $request->file('file');
            $name = $name . time() . '.' . $request->file('file')->getClientOriginalExtension();
            $path->move('uploads/products/', $name);
            $data['file'] = 'uploads/products/' . $name;
        }
        $product = Product::withoutGlobalScope(ActiveScope::class)->find($id)->update($data);
        $files = $request->file('files');
        if(isset($files)){
        foreach ($files as $file) {
                $name = Str::random(12);
                $path = $file;
                $name = $name . time() . '.' . $file->getClientOriginalExtension();
                $file->move('uploads/products/', $name);
                $filePath = 'uploads/products/' . $name;
                File::create([
                    'file' => $filePath,
                    'product_id' => $id,
                ]);
        };
    }
        return redirect()->route('product.index')->with('success', __('Updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::withoutGlobalScope(ActiveScope::class)->find($id);
        if ($product) {
            $product->delete();
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
        $product = Product::withoutGlobalScope(ActiveScope::class)->find($id);
        if ($product) {
            $product->changeStatus();
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
