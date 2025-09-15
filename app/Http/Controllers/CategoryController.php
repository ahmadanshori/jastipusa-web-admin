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

}
