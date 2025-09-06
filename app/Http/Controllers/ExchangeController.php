<?php

namespace App\Http\Controllers;

use App\Models\Exchange;
use Auth;
use Illuminate\Http\Request;
use DataTables;
use Storage;
use Validator;
use App\Helpers\Summernote;

class ExchangeController extends Controller

{

    public function __construct(Exchange $exchange)
    {
        $this->exchange = $exchange;
    }

    protected $rulesValidation = [
        'name' => 'required',
        'value' => 'required'
    ];

    public function index()
    {
        return view('exchange.index');
    }

    public function create()
    {
        return view('exchange.form');
    }

    public function store(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'value' => 'required',
        ]);


        if ($validation->passes()) {
            $data = [
                'name' => $request->name,
                'value' => $request->value,
            ];
            $this->exchange->create($data);

            \Session::flash('success', 'Payment method has been created');
            return redirect()->route('exchange.index');
        } else {
            return redirect()->back()
                ->withErrors($validation)->withInput();
        }
    }

    public function edit($id)
    {
        $exchange = $this->exchange->where('id', $id)->first();
        return view('exchange.form', compact('exchange'));
    }

    public function update(Request $request, $id)
    {
        $exchange = $this->exchange->where('id', $id)->first();

        $validation = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'value' => 'required',
        ]);

        if ($validation->passes()) {
            $data = [
                'name' => $request->name,
                'value' => $request->value,
            ];

            $exchange->update($data);

            \Session::flash('success', 'Exchange has been updated');
            return redirect()->route('exchange.index');
        } else {
            return redirect()->back()
                ->withErrors($validation)->withInput();
        }
    }

    public function destroy($id)
    {
        $exchange = $this->exchange->where('id', $id)->first();

        $exchange->delete();

        \Session::flash('success', 'Payment method has been Deleted');
        return redirect()->route('exchange.index');
    }

    public function ajax()
    {
        $exchanges = $this->exchange->get();

        return Datatables::of($exchanges)

            ->editColumn('value', function($exchanges) {
                $exchange = $exchanges;
                return $exchange->value ? 'Rp '.number_format($exchange->value) : '-';
            })
            ->addColumn('actions', function ($exchanges) {
                $exchange = $exchanges;
                return view('exchange.action', compact('exchange'))->render();
            })->rawColumns(['value','actions'])->make(true);
    }

}
