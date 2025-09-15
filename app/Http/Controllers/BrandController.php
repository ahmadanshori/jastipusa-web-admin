<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Auth;
use Illuminate\Http\Request;
use DataTables;
use Storage;
use Validator;

class BrandController extends Controller

{

    public function __construct(Brand $brand)
    {
        $this->brand = $brand;
    }

    protected $rulesValidation = [
        'name' => 'required',
        'code' => 'required'
    ];

    public function index()
    {
        return view('brand.index');
    }

    public function create()
    {
        return view('brand.form');
    }

    public function store(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'code' => 'required|string|max:50|unique:brand,code',
        ]);


        if ($validation->passes()) {
            $data = [
                'name' => $request->name,
                'code' => $request->code,
            ];
            $this->brand->create($data);

            \Session::flash('success', 'brand has been created');
            return redirect()->route('brand.index');
        } else {
            return redirect()->back()
                ->withErrors($validation)->withInput();
        }
    }

    public function edit($id)
    {
        $brand = $this->brand->where('id', $id)->first();
        return view('brand.form', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        $brand = $this->brand->where('id', $id)->first();

        $validation = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'code' => 'required|string|max:50|unique:brand,code,' . $id,
        ]);

        if ($validation->passes()) {
            $data = [
                'name' => $request->name,
                'code' => $request->code,
            ];

            $brand->update($data);

            \Session::flash('success', 'brand has been updated');
            return redirect()->route('brand.index');
        } else {
            return redirect()->back()
                ->withErrors($validation)->withInput();
        }
    }

    public function destroy($id)
    {
        $brand = $this->brand->where('id', $id)->first();

        $brand->delete();

        \Session::flash('success', 'brand has been Deleted');
        return redirect()->route('brand.index');
    }

    public function ajax()
    {
        $brands = $this->brand->latest()->get();

        return Datatables::of($brands)

          
            ->addColumn('actions', function ($brands) {
                $brand = $brands;
                return view('brand.action', compact('brand'))->render();
            })->rawColumns(['actions'])->make(true);
    }

}
