<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\PurchaseOrderDetail;
use Auth;
use Illuminate\Http\Request;
use DataTables;
use Storage;
use Validator;
use App\Helpers\Bahasa;
use Carbon\Carbon;
use App\Exports\CustomerPurchaseExport;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller

{

    public function __construct(Customer $customer, PurchaseOrderDetail $purchaseOrderDetail)
    {
        // dd(class_exists(\App\Http\Middleware\CheckRole::class));
        $this->customer = $customer;
        $this->purchaseOrderDetail = $purchaseOrderDetail;
    }

    public function index()
    {
        return view('customer.index');
    }

    public function create()
    {
        return view('customer.form');
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'id_title' => 'required',
            'image' => 'required',
        ]);

        $title = [
            'id' => $request->id_title,
            'en' => $request->en_title
        ];


        if ($validation->passes()) {
            $data = [
                'title' => json_encode($title),
                'publish_at' => $request->publish_at,
                'cover_image' => $request->image,
                'status_publish' => $request->status_publish == "true" ? "1" : "0",
            ];
            $this->customer->create($data);

            \Session::flash('success', 'customer has been created');
            return redirect()->route('customer.index');
        } else {
            return redirect()->back()
                ->withErrors($validation)->withInput();
        }
    }

    public function show($id)
    {
        $customer = $this->customer->where('id', $id)->first();
        $purchaseOrderDetail = $this->purchaseOrderDetail->whereIn('purchase_order_id', function($query) use ($customer) {
            $query->select('id')
                ->from('purchase_order')->where('no_telp', $customer->whatsapp_number);
        })->get();
        return view('customer.show', [
            'customer' => $customer,
            'membership_duration' => $customer->getMembershipDuration(),
            'jumlah_order' => $purchaseOrderDetail->count(),
            'total_order' => $purchaseOrderDetail->sum('fix_price'),
        ]);
    }


    public function edit($id)
    {
        $customer = $this->customer->where('id', $id)->first();
        $customer_title =  json_decode($customer->title);
        $customer['id_title'] = $customer_title->id;
        $customer['en_title'] = $customer_title->en;
        return view('customer.form', compact('customer'));
    }


    public function update(Request $request, $id)
    {
        $customer = $this->customer->where('id', $id)->first();

        $validation = Validator::make($request->all(), [
            'id_title' => 'required',
            'image' => 'required',
        ]);

        $title = [
            'id' => $request->id_title,
            'en' => $request->en_title
        ];


        if ($validation->passes()) {
            $data = [
                'title' => json_encode($title),
                'publish_at' => $request->publish_at,
                'cover_image' => $request->image,
                'status_publish' => $request->status_publish == "true" ? "1" : "0",
            ];

            $customer->update($data);

            \Session::flash('success', 'customer has been updated');
            return redirect()->route('customer.index');
        } else {
            return redirect()->back()
                ->withErrors($validation)->withInput();
        }
    }

    public function destroy($id)
    {
        $customer = $this->customer->where('id', $id)->first();

        $customer->delete();

        \Session::flash('success', 'customer has been deleted');
        return redirect()->route('customer.index');
    }

    public function ajax(Request $request)
    {
       
        $customers = $this->customer->latest()->get();

        return Datatables::of($customers)
           
            ->addColumn('actions', function ($customers) {
                $customer = $customers;
                return view('customer.action', compact('customer'))->render();
            })->rawColumns(['actions'])->make(true);
    }

      public function ajaxOrderDetail(Request $request, $id)
    {
       
        $customer = $this->customer->where('id', $id)->first();
        $purchaseOrderDetail = $this->purchaseOrderDetail->whereIn('purchase_order_id', function($query) use ($customer) {
            $query->select('id')
                ->from('purchase_order')->where('no_telp', $customer->whatsapp_number);
        })->get();

        return Datatables::of($purchaseOrderDetail)->make(true);
            // ->addColumn('actions', function ($purchaseOrders) {
            //     $purchase = $purchaseOrders;
            //     return view('purchase.action', compact('purchase'))->render();
            // })->rawColumns(['actions'])->make(true);
    }

    public function exportExcel()
    {
        return Excel::download(new CustomerPurchaseExport(), 'customer_report.xlsx');
    }
    

}
