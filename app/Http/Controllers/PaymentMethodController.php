<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Auth;
use Illuminate\Http\Request;
use DataTables;
use Storage;
use Validator;
use App\Helpers\Summernote;

class PaymentMethodController extends Controller

{

    public function __construct(PaymentMethod $paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    }

    protected $rulesValidation = [
        'name' => 'required',
        'number' => 'required'
    ];

    public function index()
    {
        return view('payment-method.index');
    }

    public function create()
    {
        return view('payment-method.form');
    }

    public function store(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'number' => 'required',
        ]);


        if ($validation->passes()) {
            $data = [
                'name' => $request->name,
                'number' => $request->number,
            ];
            $this->paymentMethod->create($data);

            \Session::flash('success', 'Payment method has been created');
            return redirect()->route('payment-method.index');
        } else {
            return redirect()->back()
                ->withErrors($validation)->withInput();
        }
    }

    public function edit($id)
    {
        $paymentMethod = $this->paymentMethod->where('id', $id)->first();
        return view('payment-method.form', compact('paymentMethod'));
    }

    public function update(Request $request, $id)
    {
        $paymentMethod = $this->paymentMethod->where('id', $id)->first();

        $validation = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'number' => 'required',
        ]);

        if ($validation->passes()) {
            $data = [
                'name' => $request->name,
                'number' => $request->number,
            ];

            $paymentMethod->update($data);

            \Session::flash('success', 'Payment method has been updated');
            return redirect()->route('payment-method.index');
        } else {
            return redirect()->back()
                ->withErrors($validation)->withInput();
        }
    }

    public function destroy($id)
    {
        $paymentMethod = $this->paymentMethod->where('id', $id)->first();

        $paymentMethod->delete();

        \Session::flash('success', 'Payment method has been Deleted');
        return redirect()->route('payment-method.index');
    }

    public function ajax()
    {
        $paymentMethods = $this->paymentMethod->latest()->get();

        return Datatables::of($paymentMethods)

          
            ->addColumn('actions', function ($paymentMethods) {
                $paymentMethod = $paymentMethods;
                return view('payment-method.action', compact('paymentMethod'))->render();
            })->rawColumns(['actions'])->make(true);
    }

}
