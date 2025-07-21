<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\CustomerOrder;
use App\Models\Customer;
use Auth;
use Illuminate\Http\Request;
use DataTables;
use Storage;
use Validator;
use App\Helpers\Bahasa;
use Carbon\Carbon;

class PurchaseOrderController extends Controller

{

    public function __construct(PurchaseOrder $purchaseOrder, CustomerOrder $customerOrder, Customer $customer)
    {
        $this->purchase = $purchaseOrder;
        $this->customerOrder = $customerOrder;
        $this->customer = $customer;
    }

    public function index()
    {
        return view('purchase.index');
    }

    public function create()
    {
        $customer = $this->customer->get();
        $customerOrder = $this->customerOrder->whereNotNull('po_number')->get();
        return view('purchase.form',compact('customer','customerOrder'));
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'no_po' => 'required',
            'nama' => 'required',
            'no_telp' => 'required',
            'alamat' => 'required',
            'email' => 'required',
            'nama_barang' => 'required',
            'link_barang' => 'required',
            'estimasi_kg' => 'required',
            'estimasi_harga' => 'required',
        ]);

      
        if ($validation->passes()) {
            $data = [
                'no_po' => $request->no_po,
                'nama' => $request->nama,
                'no_telp' => $request->no_telp,
                'alamat' => $request->alamat,
                'email' => $request->email,
                'nama_barang' => $request->nama_barang,
                'link_barang' => $request->link_barang,
                'estimasi_kg' => $request->estimasi_kg,
                'estimasi_harga' => $request->estimasi_harga,
            ];
            $this->purchase->create($data);

            \Session::flash('success', 'purchase has been created');
            return redirect()->route('purchase.index');
        } else {
            return redirect()->back()
                ->withErrors($validation)->withInput();
        }
    }

    public function show($id)
    {
       
    }


    public function edit($id)
    {
        $purchase = $this->purchase->where('id', $id)->first();
           $customer = $this->customer->get();
        $customerOrder = $this->customerOrder->whereNotNull('po_number')->get();
        return view('purchase.form', compact('purchase','customer','customerOrder'));
    }


    public function update(Request $request, $id)
    {
        $purchaseOrder = $this->purchase->where('id', $id)->first();

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

            $purchaseOrder->update($data);

            \Session::flash('success', 'purchase has been updated');
            return redirect()->route('purchase.index');
        } else {
            return redirect()->back()
                ->withErrors($validation)->withInput();
        }
    }

    public function destroy($id)
    {
        $purchaseOrder = $this->purchase->where('id', $id)->first();

        $purchaseOrder->delete();

        \Session::flash('success', 'purchase has been deleted');
        return redirect()->route('purchase.index');
    }

    public function ajax(Request $request)
    {
       
        $purchaseOrders = $this->purchase->latest()->get();

        return Datatables::of($purchaseOrders)
            ->addColumn('actions', function ($purchaseOrders) {
                $purchase = $purchaseOrders;
                return view('purchase.action', compact('purchase'))->render();
            })->rawColumns(['actions'])->make(true);
    }

    public function list_detail_customer($id){
        $customer = $this->customer->where('whatsapp_number', $id)->orderby('whatsapp_number','asc')->first();    
        return response()->json($customer);
    }

     public function list_detail_customer_order($id){
        $customer = $this->customerOrder->where('po_number', $id)->whereNotNull('po_number')->orderby('po_number','asc')->first();    
        return response()->json($customer);
    }

}
