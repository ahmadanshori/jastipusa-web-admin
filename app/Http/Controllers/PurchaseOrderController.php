<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\CustomerOrder;
use App\Models\Customer;
use App\Models\User;
use App\Models\PaymentMethod;
use Auth;
use Illuminate\Http\Request;
use DataTables;
use Storage;
use Validator;
use App\Helpers\Bahasa;
use Carbon\Carbon;
use DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\PurchaseOrderExport;
use Maatwebsite\Excel\Facades\Excel;

class PurchaseOrderController extends Controller

{

    public function __construct(PurchaseOrder $purchaseOrder, CustomerOrder $customerOrder, Customer $customer, PaymentMethod $paymentMethod, User $user, PurchaseOrderDetail $purchaseOrderDetail)
    {
        $this->purchase = $purchaseOrder;
        $this->customerOrder = $customerOrder;
        $this->customer = $customer;
        $this->user = $user;
        $this->purchaseOrderDetail = $purchaseOrderDetail;
        $this->paymentMethod = $paymentMethod;

    }

    public function index()
    {
        return view('purchase.index');
    }

    public function create()
{
    $customer = $this->customer->get();

    $customerOrders = $this->customerOrder->whereNotIn('po_number', function($query) {
        $query->select('no_po')
              ->from('purchase_order_detail');
    })->whereNotNull('po_number')->get()
        ->map(function ($order) {
            return [
                'value' => $order->po_number,
                'label' => $order->po_number,
                'customProperties' => [
                    'po_number' => $order->po_number,
                    'nama_barang' => $order->nama_barang,
                    'link_product' => $order->link_product,
                    'jumlah_berat' => $order->jumlah_berat,
                    'total_harga' => $order->estimasi_harga,
                    'customer_id' => $order->id_whatsapp_number,
                ]
            ];
        });

    return view('purchase.form', [
        'customerOrders' => $customerOrders,
        'customer' => $customer,
        'customerOrdersJson' => $customerOrders->toJson() // Untuk inisialisasi Choices
    ]);
}

    // public function store(Request $request)
    // {
    //     $validation = Validator::make($request->all(), [
    //         'no_po' => 'required',
    //         'nama' => 'required',
    //         'no_telp' => 'required',
    //         'alamat' => 'required',
    //         'email' => 'required',
    //         'nama_barang' => 'required',
    //         'link_barang' => 'required',
    //         'estimasi_kg' => 'required',
    //         'estimasi_harga' => 'required',
    //     ]);


    //     if ($validation->passes()) {
    //         $data = [
    //             'no_po' => $request->no_po,
    //             'nama' => $request->nama,
    //             'no_telp' => $request->no_telp,
    //             'alamat' => $request->alamat,
    //             'email' => $request->email,
    //             'nama_barang' => $request->nama_barang,
    //             'link_barang' => $request->link_barang,
    //             'estimasi_kg' => $request->estimasi_kg,
    //             'estimasi_harga' => $request->estimasi_harga,
    //         ];
    //         $this->purchase->create($data);

    //         \Session::flash('success', 'purchase has been created');
    //         return redirect()->route('purchase.index');
    //     } else {
    //         return redirect()->back()
    //             ->withErrors($validation)->withInput();
    //     }
    // }

    public function store(Request $request)
{
    // Validasi data utama
    // $validatedData = $request->validate([
    //     'items' => 'required|array|min:1',
    //     'items.*.customer_order_id' => 'required',
    //     'items.*.no_po_customer' => 'required|string',
    //     'items.*.nama_barang' => 'required|string',
    //     'items.*.link_barang' => 'nullable|url',
    //     'items.*.estimasi_kg' => 'required',
    //     'items.*.estimasi_harga' => 'required',
    // ]);

    // Mulai transaction database
    DB::beginTransaction();

    try {
        // Simpan data purchase order utama

        $data = [
            // 'no_po' => $request->no_po,
            'nama' => $request->nama,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'email' => $request->email,
        ];
        $purchase = $this->purchase->create($data);
        // dd($purchase);
        // Simpan item-item purchase order
        foreach ($request->items as $item) {
            $this->purchaseOrderDetail->create([
                'purchase_order_id' => $purchase->id,
                'no_po' => $item['no_po_customer'],
                'nama_barang' => $item['nama_barang'],
                'link_barang' => $item['link_barang'],
                'estimasi_kg' => $item['estimasi_kg'],
                'estimasi_harga' => $item['estimasi_harga']
            ]);
        }

        // Commit transaction jika semua berhasil
        DB::commit();

        return redirect()->route('purchase.index')
            ->with('success', 'Purchase Order berhasil dibuat');

    } catch (\Exception $e) {
        // Rollback transaction jika terjadi error
        // dd($e);
        DB::rollBack();

             return back()
            ->withInput()
            ->with('error', 'Failed to create Purchase Order: '.$e->getMessage())
            ->with('old_items', $request->items); // Tambahkan items ke session
    }
}



    public function edit($id)
{
    // Load relasi items dan customer
    $purchase = $this->purchase->where('id', $id)->first();
    $purchaseOrderDetail = $this->purchaseOrderDetail->where('purchase_order_id', $id)->get();
    // Ambil data customer untuk dropdown
     $customers = $this->customer->get();
    // Ambil data customer order untuk dropdown items
    $customerOrders = $this->customerOrder->whereNotNull('po_number')
        ->get()
        ->map(function ($order) {
            return [
                'value' => $order->po_number,
                'label' => $order->po_number . ' - ' . $order->nama_barang,
                'customProperties' => [
                    'po_number' => $order->po_number,
                    'nama_barang' => $order->nama_barang,
                    'link_product' => $order->link_product,
                    'jumlah_berat' => $order->jumlah_berat,
                    'total_harga' => $order->total_harga
                ]
            ];
        });

    return view('purchase.edit', [
        'purchase' => $purchase,
        'purchaseOrderDetail' => $purchaseOrderDetail,
        'customers' => $customers,
        'customerOrders' => $customerOrders,
        'customerOrdersJson' => $customerOrders->toJson()
    ]);
}
    // public function edit($id)
    // {
    //     $purchase = $this->purchase->where('id', $id)->first();
    //        $customer = $this->customer->get();
    //     $customerOrder = $this->customerOrder->whereNotNull('po_number')->get();
    //     return view('purchase.form', compact('purchase','customer','customerOrder'));
    // }

    public function update(Request $request, $id)
{
    // $validatedData = $request->validate([
    //     'no_telp' => 'required',
    //     'nama' => 'required',
    //     'email' => 'required|email',
    //     'alamat' => 'required',
    //     'items' => 'required|array|min:1',
    //     'items.*.customer_order_id' => 'required|exists:customer_orders,id',
    //     'items.*.no_po_customer' => 'required',
    //     'items.*.nama_barang' => 'required',
    //     'items.*.estimasi_kg' => 'required|numeric',
    //     'items.*.estimasi_harga' => 'required|numeric'
    // ]);

    DB::beginTransaction();

    try {
        // Update data purchase utama
        $purchase = $this->purchase->where('id', $id)->first();
        $purchase->update([
                 'nama' => $request->nama,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'email' => $request->email,
        ]);

    $this->purchaseOrderDetail->where('purchase_order_id', $id)->delete();



        // Buat items baru
        foreach ($request->items as $item) {
             $this->purchaseOrderDetail->create([
                'purchase_order_id' => $purchase->id,
                'no_po' => $item['no_po_customer'],
                'nama_barang' => $item['nama_barang'],
                'link_barang' => $item['link_barang'],
                'estimasi_kg' => $item['estimasi_kg'],
                'estimasi_harga' => $item['estimasi_harga']
            ]);
        }

        DB::commit();

        return redirect()->route('purchase.index')
            ->with('success', 'Purchase order updated successfully');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withInput()
            ->with('error', 'Failed to update purchase order: ' . $e->getMessage());
    }
}


public function updateEstimasi(Request $request, $id)
{
    // $validatedData = $request->validate([
    //     'nama_rek' => 'sometimes|string|max:255',
    //     'jumlah_transfer' => 'sometimes|numeric',
    //     'dp' => 'sometimes|numeric',
    //     'full_payment' => 'sometimes|numeric',
    //     'status_follow_up' => 'sometimes|in:Scheduled,Followed,Unfollowed',
    //     'mutasi_check' => 'sometimes|boolean',
    //     'bukti_transfer' => 'sometimes|image|max:2048'
    // ]);

    // Handle file upload
    $data = [
        'nama_rek_transfer' => $request->nama_rek,
        'jumlah_transfer' => $request->jumlah_transfer,
        'dp' => $request->dp,
        'fullpayment' => $request->full_payment,
        'status_follow_up' => $request->status_follow_up,
        'mutasi_check' => $request->mutasi_check == "true" ? "1" : "0"
    ];
    if ($request->hasFile('bukti_transfer')) {
        $path = $request->file('bukti_transfer')->store('bukti_transfer', 'public');
        $data['foto_bukti_tf'] = $path;
    }

        $purchaseOrderDetail = $this->purchaseOrderDetail->where('id', $id)->first();
        $purchaseOrderDetail->update($data);

    return response()->json([
        'success' => true,
        'message' => 'Estimasi berhasil diperbarui',
        // 'nama_rek' => $item->nama_rek,
        // 'jumlah_transfer' => $item->jumlah_transfer,
        // 'dp' => $item->dp,
        // 'full_payment' => $item->full_payment,
        // 'status_follow_up' => $item->status_follow_up,
        // 'mutasi_check' => $item->mutasi_check
    ]);
}

public function updateHpp(Request $request, $id)
{
    // $validatedData = $request->validate([
    //     'nama_rek' => 'sometimes|string|max:255',
    //     'jumlah_transfer' => 'sometimes|numeric',
    //     'dp' => 'sometimes|numeric',
    //     'full_payment' => 'sometimes|numeric',
    //     'status_follow_up' => 'sometimes|in:Scheduled,Followed,Unfollowed',
    //     'mutasi_check' => 'sometimes|boolean',
    //     'bukti_transfer' => 'sometimes|image|max:2048'
    // ]);

    // Handle file upload
    $data = [
        'payment_method' => $request->payment_method,
        'total_purchase' => $request->total_purchase,
        'status_purchase' => $request->status_purchase,
        'notes' => $request->notes,
        'hpp_mutasi_check' => $request->hpp_mutasi_check == "true" ? "1" : "0"
    ];

   if ($request->hasFile('bukti_pembelian')) {
        // Hapus file lama jika ada
        $path = $request->file('bukti_pembelian')->store('bukti_pembelian', 'public');
        $data['foto_bukti_pembelian'] = $path;
    }

        $purchaseOrderDetail = $this->purchaseOrderDetail->where('id', $id)->first();
        $purchaseOrderDetail->update($data);

    return response()->json([
        'success' => true,
        'message' => 'Estimasi berhasil diperbarui',
        // 'nama_rek' => $item->nama_rek,
        // 'jumlah_transfer' => $item->jumlah_transfer,
        // 'dp' => $item->dp,
        // 'full_payment' => $item->full_payment,
        // 'status_follow_up' => $item->status_follow_up,
        // 'mutasi_check' => $item->mutasi_check
    ]);
}

public function updateOprasional(Request $request, $id)
{
    // $validatedData = $request->validate([
    //     'nama_rek' => 'sometimes|string|max:255',
    //     'jumlah_transfer' => 'sometimes|numeric',
    //     'dp' => 'sometimes|numeric',
    //     'full_payment' => 'sometimes|numeric',
    //     'status_follow_up' => 'sometimes|in:Scheduled,Followed,Unfollowed',
    //     'mutasi_check' => 'sometimes|boolean',
    //     'bukti_transfer' => 'sometimes|image|max:2048'
    // ]);

    // Handle file upload

    $data = [
        'fix_weight' => $request->fix_weight,
        'fix_price' => $request->fix_price,
        'status_barang_sampai' => $request->status_barang_sampai,
        'status_on_check' => $request->wh_usa_mutasi_check == "true" ? "1" : "0"
    ];

    if ($request->hasFile('wh_usa')) {
        // Hapus file lama jika ada
        $path = $request->file('wh_usa')->store('wh_usa', 'public');
        $data['wh_usa'] = $path;
    }

    // Handle file upload WH Indonesia
    if ($request->hasFile('wh_indonesia')) {
        $path = $request->file('wh_indonesia')->store('wh_indonesia', 'public');
        $data['wh_indo'] = $path;
    }

        $purchaseOrderDetail = $this->purchaseOrderDetail->where('id', $id)->first();
        $purchaseOrderDetail->update($data);

    return response()->json([
        'success' => true,
        'message' => 'Estimasi berhasil diperbarui',
        // 'nama_rek' => $item->nama_rek,
        // 'jumlah_transfer' => $item->jumlah_transfer,
        // 'dp' => $item->dp,
        // 'full_payment' => $item->full_payment,
        // 'status_follow_up' => $item->status_follow_up,
        // 'mutasi_check' => $item->mutasi_check
    ]);
}

 public function show($id)
{
    // Load relasi items dan customer
    $purchase = $this->purchase->where('id', $id)->first();
    $purchaseOrderDetail = $this->purchaseOrderDetail->where('purchase_order_id', $id)->get();
    // Ambil data customer untuk dropdown
     $customers = $this->customer->get();
     $paymentMethod = $this->paymentMethod->get();

    // Ambil data customer order untuk dropdown items
    $customerOrders = $this->customerOrder->whereNotNull('po_number')
        ->get()
        ->map(function ($order) {
            return [
                'value' => $order->po_number,
                'label' => $order->po_number . ' - ' . $order->nama_barang,
                'customProperties' => [
                    'po_number' => $order->po_number,
                    'nama_barang' => $order->nama_barang,
                    'link_product' => $order->link_product,
                    'jumlah_berat' => $order->jumlah_berat,
                    'total_harga' => $order->total_harga
                ]
            ];
        });
    if($this->user->checkRole('accounting')){
        return view('purchase.show_accounting', [
                'purchase' => $purchase,
                'paymentMethod' => $paymentMethod,
                'purchaseOrderDetail' => $purchaseOrderDetail,
                'customers' => $customers,
                'customerOrders' => $customerOrders,
                'customerOrdersJson' => $customerOrders->toJson(),
                'total_items' => $purchaseOrderDetail->count(),
                'total_estimasi_harga' => $purchaseOrderDetail->sum('estimasi_harga'),
            ]);
    }else{
         return view('purchase.show', [
        'purchase' => $purchase,
        'paymentMethod' => $paymentMethod,
        'purchaseOrderDetail' => $purchaseOrderDetail,
        'customers' => $customers,
        'customerOrders' => $customerOrders,
        'customerOrdersJson' => $customerOrders->toJson(),
         'total_items' => $purchaseOrderDetail->count(),
        'total_estimasi_harga' => $purchaseOrderDetail->sum('estimasi_harga'),
    ]);
    }
   
}

//     public function update(Request $request, $id)
//     {
//         $purchaseOrder = $this->purchase->where('id', $id)->first();

//         $validation = Validator::make($request->all(), [
//             'id_title' => 'required',
//             'image' => 'required',
//         ]);

//         $title = [
//             'id' => $request->id_title,
//             'en' => $request->en_title
//         ];


//         if ($validation->passes()) {
//             $data = [
//                 'title' => json_encode($title),
//                 'publish_at' => $request->publish_at,
//                 'cover_image' => $request->image,
//                 'status_publish' => $request->status_publish == "true" ? "1" : "0",
//             ];
//             $purchaseOrder->update($data);

//             \Session::flash('success', 'purchase has been updated');
//             return redirect()->route('purchase.index');
//         } else {
//             return redirect()->back()
//                 ->withErrors($validation)->withInput();
//         }
//     }

    public function destroy($id)
    {
        $this->purchaseOrderDetail->where('purchase_order_id', $id)->delete();
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

     public function list_customer_order(){
        $customer = $this->customerOrder->whereNotNull('po_number')->orderby('po_number','asc')->get();
        return response()->json($customer);
    }

    public function generatePDF($id)
    {
        $purchase = $this->purchase->where('id', $id)->first();
        $purchaseOrderDetail = $this->purchaseOrderDetail->where('purchase_order_id', $id)->get();

        // Ambil data customer untuk dropdown
        $customers = $this->customer->where('whatsapp_number',$purchase->no_telp)->first();
        $data = [
            'purchase' => $purchase,
            'purchaseOrderDetail' => $purchaseOrderDetail,
            'customer' => $customers,
            'title' => 'Purchase Order #' . $purchase->id,
            'date' => now()->format('d F Y')
        ];

        $pdf = PDF::loadView('purchase.pdf_purchase_order', $data);

        return $pdf->download('purchase-order-'.$purchase->purchase_number.'.pdf');
    }

    public function export()
    {
        $date = now()->format('Y-m-d');
        return Excel::download(new PurchaseOrderExport(), "purchase_orders_{$date}.xlsx");
    }

     public function generatePDFEstimasi($id)
    {
        $purchase = $this->purchase->where('id', $id)->first();
        $purchaseOrderDetail = $this->purchaseOrderDetail->where('purchase_order_id', $id)->get();
        // Ambil data customer untuk dropdown
        $customers = $this->customer->where('whatsapp_number',$purchase->no_telp)->first();
        $data = [
            'purchase' => $purchase,
            'purchaseOrderDetail' => $purchaseOrderDetail,
            'customer' => $customers,
            'title' => 'Purchase Order #' . $purchase->id,
            'date' => now()->format('d F Y')
        ];
        $pdf = PDF::loadView('purchase.pdf_estimasi', $data);
        return $pdf->download('purchase-estimasi-'.$purchase->purchase_number.'.pdf');
    }

    public function generatePDFHpp($id)
    {
        $purchase = $this->purchase->where('id', $id)->first();
        $purchaseOrderDetail = $this->purchaseOrderDetail->where('purchase_order_id', $id)->get();
        // Ambil data customer untuk dropdown
        $customers = $this->customer->where('whatsapp_number',$purchase->no_telp)->first();
        $data = [
            'purchase' => $purchase,
            'purchaseOrderDetail' => $purchaseOrderDetail,
            'customer' => $customers,
            'title' => 'Purchase Order #' . $purchase->id,
            'date' => now()->format('d F Y')
        ];

        $pdf = PDF::loadView('purchase.pdf_hpp', $data);

        return $pdf->download('purchase-hpp-'.$purchase->purchase_number.'.pdf');
    }

    public function generatePDFOperasional($id)
    {
        $purchase = $this->purchase->where('id', $id)->first();
        $purchaseOrderDetail = $this->purchaseOrderDetail->where('purchase_order_id', $id)->get();
        // Ambil data customer untuk dropdown
        $customers = $this->customer->where('whatsapp_number',$purchase->no_telp)->first();
        $data = [
            'purchase' => $purchase,
            'purchaseOrderDetail' => $purchaseOrderDetail,
            'customer' => $customers,
            'title' => 'Purchase Order #' . $purchase->id,
            'date' => now()->format('d F Y')
        ];
        $pdf = PDF::loadView('purchase.pdf_operasional', $data);
        return $pdf->download('purchase-operasional-'.$purchase->purchase_number.'.pdf');
    }

    public function generatePDFReceived($id)
    {
        $purchase = $this->purchase->where('id', $id)->first();
        $purchaseOrderDetail = $this->purchaseOrderDetail->where('purchase_order_id', $id)->get();
        // Ambil data customer untuk dropdown
        $customers = $this->customer->where('whatsapp_number',$purchase->no_telp)->first();
        $data = [
            'purchase' => $purchase,
            'purchaseOrderDetail' => $purchaseOrderDetail,
            'customer' => $customers,
            'title' => 'Purchase Order #' . $purchase->id,
            'date' => now()->format('d F Y')
        ];
        $pdf = PDF::loadView('purchase.pdf_received', $data);
        return $pdf->download('purchase-received-'.$purchase->purchase_number.'.pdf');
    }

}
