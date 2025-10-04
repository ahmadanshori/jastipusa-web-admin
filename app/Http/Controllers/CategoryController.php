<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Auth;
use Illuminate\Http\Request;
use DataTables;
use Storage;
use Validator;

class CategoryController extends Controller

{

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    protected $rulesValidation = [
        'name' => 'required',
        'code' => 'required'
    ];

    public function index()
    {
        return view('category.index');
    }

    public function create()
    {
        return view('category.form');
    }

    public function store(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'code' => 'required|string|max:50|unique:category,code',
        ]);


        if ($validation->passes()) {
            $data = [
                'name' => $request->name,
                'code' => $request->code,
            ];
            $this->category->create($data);

            \Session::flash('success', 'Category has been created');
            return redirect()->route('category.index');
        } else {
            return redirect()->back()
                ->withErrors($validation)->withInput();
        }
    }

    public function edit($id)
    {
        $category = $this->category->where('id', $id)->first();
        return view('category.form', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = $this->category->where('id', $id)->first();

        $validation = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'code' => 'required|string|max:50|unique:category,code,' . $id,
        ]);

        if ($validation->passes()) {
            $data = [
                'name' => $request->name,
                'code' => $request->code,
            ];

            $category->update($data);

            \Session::flash('success', 'Category has been updated');
            return redirect()->route('category.index');
        } else {
            return redirect()->back()
                ->withErrors($validation)->withInput();
        }
    }

    public function destroy($id)
    {
        $category = $this->category->where('id', $id)->first();

        $category->delete();

        \Session::flash('success', 'Category has been Deleted');
        return redirect()->route('category.index');
    }

    public function ajax()
    {
        $categorys = $this->category->latest()->get();

        return Datatables::of($categorys)


            ->addColumn('actions', function ($categorys) {
                $category = $categorys;
                return view('category.action', compact('category'))->render();
            })->rawColumns(['actions'])->make(true);
    }

    /**
     * Store category via AJAX (for purchase form)
     */
    public function storeAjax(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'code' => 'required|string|max:50|unique:category,code',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validation->errors()
            ], 422);
        }

        try {
            $category = $this->category->create([
                'name' => $request->name,
                'code' => strtoupper($request->code),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Category berhasil ditambahkan!',
                'data' => [
                    'value' => $category->id,
                    'label' => $category->name . ' (' . $category->code . ')'
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check if category code already exists (for real-time validation)
     */
    public function checkCode(Request $request)
    {
        $code = strtoupper($request->code);
        $exists = $this->category->where('code', $code)->exists();

        return response()->json([
            'exists' => $exists,
            'message' => $exists ? 'Category code sudah digunakan' : 'Category code tersedia'
        ]);
    }

}
