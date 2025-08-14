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

class TrackingController extends Controller

{

    public function __construct(Customer $customer, PurchaseOrderDetail $purchaseOrderDetail)
    {
        // dd(class_exists(\App\Http\Middleware\CheckRole::class));
        $this->customer = $customer;
        $this->purchaseOrderDetail = $purchaseOrderDetail;
    }

    public function index()
    {
        return view('tracking.index');
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
       
        $details = $this->purchaseOrderDetail->with('purchaseOrder')->select('purchase_order_detail.*');

        return DataTables::of($details)
            ->addColumn('nama', function($detail) {
                return $detail->purchaseOrder->nama;
            })
            ->addColumn('no_telp', function($detail) {
                return $detail->purchaseOrder->no_telp;
            })
            ->addColumn('alamat', function($detail) {
                return $detail->purchaseOrder->alamat;
            })
            ->addColumn('email', function($detail) {
                return $detail->purchaseOrder->email;
            })
            ->addColumn('link_barang', function($detail) {
                return $detail->link_barang ? '<a href="'.$detail->link_barang.'" target="_blank">View</a>' : '-';
            })
            ->addColumn('estimasi_harga', function($detail) {
                return $detail->estimasi_harga ? 'Rp '.number_format($detail->estimasi_harga) : '-';
            })
            ->addColumn('total_harga', function($detail) {
                return $detail->total_harga ? 'Rp '.number_format($detail->total_harga) : '-';
            })
            ->addColumn('jumlah_transfer', function($detail) {
                return $detail->jumlah_transfer ? 'Rp '.number_format($detail->jumlah_transfer) : '-';
            })
            ->addColumn('dp', function($detail) {
                return $detail->dp ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-danger">No</span>';
            })
            ->addColumn('fullpayment', function($detail) {
                return $detail->fullpayment ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-danger">No</span>';
            })
            ->addColumn('foto_bukti_tf', function($detail) {
                if($detail->foto_bukti_tf) {
                    return '<a href="'.asset('storage/'.$detail->foto_bukti_tf).'" target="_blank" class="btn btn-sm btn-info">View</a>';
                }
                return '-';
            })
            ->addColumn('mutasi_check', function($detail) {
                return $detail->mutasi_check ? '<span class="badge bg-success">Checked</span>' : '<span class="badge bg-danger">Unchecked</span>';
            })
            ->addColumn('total_purchase', function($detail) {
                return $detail->total_purchase ? 'Rp '.number_format($detail->total_purchase) : '-';
            })
            ->addColumn('total_fix_diskon', function($detail) {
                return $detail->total_fix_diskon ? 'Rp '.number_format($detail->total_fix_diskon) : '-';
            })
            ->addColumn('foto_bukti_pembelian', function($detail) {
                if($detail->foto_bukti_pembelian) {
                    return '<a href="'.asset('storage/'.$detail->foto_bukti_pembelian).'" target="_blank" class="btn btn-sm btn-info">View</a>';
                }
                return '-';
            })
            ->addColumn('fix_price', function($detail) {
                return $detail->fix_price ? 'Rp '.number_format($detail->fix_price) : '-';
            })
            ->addColumn('status_barang_sampai', function($detail) {
                switch($detail->status_barang_sampai) {
                    case 'received':
                        return '<span class="badge bg-success">Received</span>';
                    case 'on_delivery':
                        return '<span class="badge bg-warning">On Delivery</span>';
                    case 'not_sent':
                        return '<span class="badge bg-danger">Not Sent</span>';
                    default:
                        return '-';
                }
            })
            ->rawColumns([
                'link_barang', 'dp', 'fullpayment', 'foto_bukti_tf', 
                'mutasi_check', 'foto_bukti_pembelian', 'status_barang_sampai'
            ])
            ->make(true);
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
