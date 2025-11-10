<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\CustomerOrder;
use App\Models\Customer;
use App\Models\User;
use App\Models\PaymentMethod;
use App\Models\Exchange;
use App\Models\Category;
use App\Models\Brand;
use Spatie\Permission\Models\Role;
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
use App\Mail\NotificationEmail;
use Illuminate\Support\Facades\Mail;

class PurchaseOrderController extends Controller

{

    public function __construct(PurchaseOrder $purchaseOrder, Role $role, CustomerOrder $customerOrder, Customer $customer, PaymentMethod $paymentMethod, User $user, PurchaseOrderDetail $purchaseOrderDetail, Exchange $exchange, Category $category, Brand $brand)
    {
        $this->purchase = $purchaseOrder;
        $this->customerOrder = $customerOrder;
        $this->customer = $customer;
        $this->user = $user;
        $this->purchaseOrderDetail = $purchaseOrderDetail;
        $this->paymentMethod = $paymentMethod;
        $this->exchange = $exchange;
        $this->category = $category;
        $this->brand = $brand;
        $this->role = $role;

    }

    public function index()
    {
        return view('purchase.index');
    }

    public function create()
{
    $customer = $this->customer->get();
    $category = $this->category->get()->map(function ($itm) {
            return [
                'value' => $itm->id,
                'label' => $itm->name,
            ];
        });
    $brand = $this->brand->get()->map(function ($itm) {
        return [
            'value' => $itm->id,
            'label' => $itm->name,
        ];
    });

    $customerOrders = $this->customerOrder->whereNotIn('po_number', function($query) {
        $query->select('no_po_jasmin')->whereNotNull('no_po_jasmin')
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
        'category' => $category,
        'brand' => $brand,
        'customer' => $customer,
        'customerOrdersJson' => $customerOrders->toJson()
    ]);
}

    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'nama' => 'required|string',
        'phone' => 'required|string',
        'alamat' => 'required|string',
        'email' => 'required|email',
        'tipe_order' => 'required|string',
        'items' => 'required|array|min:1',
        'items.*.no_po_customer' => 'required|string',
        'items.*.nama_barang' => 'required|string',
        'items.*.quantity' => 'required|numeric',
        'items.*.estimasi_kg' => 'required|numeric',
        'items.*.estimasi_harga' => 'required|numeric',
        'items.*.total_estimasi' => 'required|numeric',
        'items.*.category_id' => 'required|exists:category,id',
        'items.*.brand_id' => 'required|exists:brand,id',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Validasi gagal',
            'errors' => $validator->errors()
        ], 422);
    }

    // Mulai transaction database
    DB::beginTransaction();

    try {
        // Simpan data purchase order utama
        $data = [
            'nama' => $request->nama,
            'no_telp' => $request->phone,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'tipe_order' => $request->tipe_order,
        ];

        $purchase = $this->purchase->create($data);

        // Simpan item-item purchase order
        foreach ($request->items as $item) {
            $this->purchaseOrderDetail->create([
                'purchase_order_id' => $purchase->id,
                'no_po' => $item['no_po_customer'],
                'tipe_order' => $request->tipe_order,
                'nama_barang' => $item['nama_barang'],
                'link_barang' => $item['link_barang'],
                'estimasi_kg' => $item['estimasi_kg'],
                'estimasi_harga' => $item['estimasi_harga'],
                'qty' => $item['quantity'],
                'estimasi_diskon' => $item['diskon'],
                'total_estimasi' => $item['total_estimasi'],
                'asuransi' => $item['asuransi'],
                'jasa' => $item['jasakg'],
                'estimasi_notes' => $item['estimasi_notes'],
                'brand_id' => $item['brand_id'],
                'category_id' => $item['category_id'],

            ]);
        }



        DB::commit();

        // Send email notification
        try {
            $emails = $this->user->pluck('email')->toArray();
            $user = $this->user->where('id', Auth::id())->first();
            $role = $this->role->where('id', $user->role_id)->first();
            $purchase["role"] = $role->name;
            $purchase["user"] = $user->name;
            Mail::to('no-reply@mail.com')
                ->bcc($emails)
                ->send(new NotificationEmail($purchase));
        } catch (\Exception $mailError) {
            // Continue even if email fails
        }
        return response()->json([
            'success' => true,
            'message' => 'Purchase Order berhasil dibuat',
            'redirect' => route('purchase.index')
        ]);

    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'success' => false,
            'message' => 'Gagal membuat Purchase Order: ' . $e->getMessage()
        ], 500);
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
                'label' => $order->po_number,
                'customProperties' => [
                    'po_number' => $order->po_number,
                    'nama_barang' => $order->nama_barang,
                    'link_product' => $order->link_product,
                    'jumlah_berat' => $order->jumlah_berat,
                    'total_harga' => $order->total_harga
                ]
            ];
        });
    $category = $this->category->get()->map(function ($itm) {
        return [
            'value' => $itm->id,
            'label' => $itm->name,
            'name' => $itm->name,
            'id' => $itm->id
        ];
    });
    $brand = $this->brand->get()->map(function ($itm) {
        return [
            'value' => $itm->id,
            'label' => $itm->name,
            'name' => $itm->name,
            'id' => $itm->id
        ];
    });
    return view('purchase.edit', [
        'purchase' => $purchase,
        'purchaseOrderDetail' => $purchaseOrderDetail,
        'customers' => $customers,
        'customerOrders' => $customerOrders,
        'customerOrdersJson' => $customerOrders->toJson(),
        'category' => $category,
        'brand' => $brand,
    ]);
}

    public function update(Request $request, $id)
{
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

        $existingItemIds = $this->purchaseOrderDetail
        ->where('purchase_order_id', $id)
        ->pluck('id')
        ->toArray();

        $sentItemIds = []; // untuk menampung ID yang ada di request
        foreach ($request->items as $item) {

            // Jika item punya ID → berarti update
            if (!empty($item['purchase_order_detail_id'])) {

                $sentItemIds[] = $item['purchase_order_detail_id']; // tandai bahwa item ini masih ada
                
                $this->purchaseOrderDetail
                    ->where('id', $item['purchase_order_detail_id'])
                    ->update([
                        'no_po' => $item['no_po_customer'],
                        'tipe_order' => $request->tipe_order,
                        'nama_barang' => $item['nama_barang'],
                        'link_barang' => $item['link_barang'],
                        'estimasi_kg' => $item['estimasi_kg'],
                        'estimasi_harga' => $item['estimasi_harga'],
                        'qty' => $item['quantity'],
                        'estimasi_diskon' => $item['diskon'],
                        'total_estimasi' => $item['total_estimasi'],
                        'asuransi' => $item['asuransi'],
                        'jasa' => $item['jasakg'],
                        'estimasi_notes' => $item['estimasi_notes'],
                        'category_id' => $item['category_id'],
                        'brand_id' => $item['brand_id']
                    ]);

            } else {

                // Jika tidak ada ID → item baru → create
                $new = $this->purchaseOrderDetail->create([
                    'purchase_order_id' => $id,
                    'no_po' => $item['no_po_customer'],
                    'tipe_order' => $request->tipe_order,
                    'nama_barang' => $item['nama_barang'],
                    'link_barang' => $item['link_barang'],
                    'estimasi_kg' => $item['estimasi_kg'],
                    'estimasi_harga' => $item['estimasi_harga'],
                    'qty' => $item['quantity'],
                    'estimasi_diskon' => $item['diskon'],
                    'total_estimasi' => $item['total_estimasi'],
                    'asuransi' => $item['asuransi'],
                    'jasa' => $item['jasakg'],
                    'estimasi_notes' => $item['estimasi_notes'],
                    'category_id' => $item['category_id'],
                    'brand_id' => $item['brand_id']
                ]);

                $sentItemIds[] = $new->id; // tambahkan ke list item yang harus dipertahankan
            }
        }

    // HAPUS item lama yang tidak ada di request
        $this->purchaseOrderDetail
            ->where('purchase_order_id', $id)
            ->whereNotIn('id', $sentItemIds)
            ->delete();
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
    $data = [
        'nama_rek_transfer' => $request->nama_rek,
        'jumlah_transfer' => $request->jumlah_transfer,
        'dp' => $request->dp,
        'fullpayment' => $request->full_payment,
        'kurang_bayar' => $request->kurang_bayar,
        'status_follow_up' => $request->status_follow_up,
        'mutasi_check' => $request->mutasi_check
    ];
    if ($request->hasFile('bukti_transfer')) {
        $path = $request->file('bukti_transfer')->store('bukti_transfer', 'public');
        $data['foto_bukti_tf'] = $path;
    }

        $purchaseOrderDetail = $this->purchaseOrderDetail->where('id', $id)->first();
        $purchaseOrderDetail->update($data);

    return response()->json([
        'success' => true,
        'message' => 'Estimasi berhasil diperbarui'
    ]);
}

public function updateHpp(Request $request, $id)
{
    $data = [
        'payment_method' => $request->payment_method,
        'total_purchase' => $request->total_purchase,
        'status_purchase' => $request->status_purchase,
        'notes' => $request->notes,
        'hpp_mutasi_check' => $request->hpp_mutasi_check,
        'pajak' => $request->pajak,
        'diskon' => $request->diskon,
        'pengiriman' => $request->pengiriman,
        'harga_hpp' => $request->harga_barang
    ];

   if ($request->hasFile('bukti_pembelian')) {
        $path = $request->file('bukti_pembelian')->store('bukti_pembelian', 'public');
        $data['foto_bukti_pembelian'] = $path;
    }

    $purchaseOrderDetail = $this->purchaseOrderDetail->where('id', $id)->first();
    $purchaseOrderDetail->update($data);

    return response()->json([
        'success' => true,
        'message' => 'HPP berhasil diperbarui'
    ]);
}

public function updateOprasional(Request $request, $id)
{
    $data = [
        'fix_weight' => $request->fix_weight,
        'fix_price' => $request->fix_price,
        'status_barang_sampai' => $request->status_barang_sampai,
        'status_on_check' => $request->wh_usa_mutasi_check,
        'no_box' => $request->nomor_box,
        'kurir_lokal' => $request->kurir_lokal,
        'pelunasan' => $request->pelunasan,
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
    $purchaseOrderDetail = $this->purchaseOrderDetail->where('purchase_order_id', $id)->orderBy('id','asc')->get();
    // Ambil data customer untuk dropdown
     $customers = $this->customer->get();
     $paymentMethod = $this->paymentMethod->get();

    $exchange = $this->exchange->first()->value;

     $category = $this->category->get();
    $brand = $this->brand->get();

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
    // if($this->user->checkRole('accounting')){
    //     return view('purchase.show_accounting', [
    //             'purchase' => $purchase,
    //             'paymentMethod' => $paymentMethod,
    //             'purchaseOrderDetail' => $purchaseOrderDetail,
    //             'customers' => $customers,
    //             'customerOrders' => $customerOrders,
    //             'customerOrdersJson' => $customerOrders->toJson(),
    //             'total_items' => $purchaseOrderDetail->count(),
    //             'total_estimasi_harga' => $purchaseOrderDetail->sum('estimasi_harga'),
    //             'exchange' => $exchange
    //         ]);
    // }else{
         return view('purchase.show', [
        'purchase' => $purchase,
        'paymentMethod' => $paymentMethod,
        'purchaseOrderDetail' => $purchaseOrderDetail,
        'customers' => $customers,
        'customerOrders' => $customerOrders,
        'customerOrdersJson' => $customerOrders->toJson(),
         'total_items' => $purchaseOrderDetail->count(),
        'total_estimasi_harga' => $purchaseOrderDetail->sum('estimasi_harga'),
        'exchange' => $exchange,
        'category' => $category,
        'brand' => $brand,
    ]);
}

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
        // Use query builder instead of get() to enable server-side processing
        $purchaseOrders = $this->purchase->latest('updated_at');

        return Datatables::of($purchaseOrders)
            ->editColumn('created_at', function ($purchaseOrders) {
                 $months = [
                    "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                    "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                ];

                $date = Carbon::parse($purchaseOrders->created_at);
                $day   = $date->day;
                $month = $months[$date->month - 1]; // index mulai dari 0
                $year  = $date->year;

                return "$day $month $year";
            })
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
        $user = $this->user->where('id', Auth::id())->first();
        $role = $this->role->where('id', $user->role_id)->first();

        $data = [
            'purchase' => $purchase,
            'purchaseOrderDetail' => $purchaseOrderDetail,
            'customer' => $customers,
            'title' => 'Purchase Order #' . $purchase->id,
            'date' => now()->format('d F Y'),
            'user' => $user,
            'role' => $role,
            'isPdf' => true
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
        $user = $this->user->where('id', Auth::id())->first();
        $role = $this->role->where('id', $user->role_id)->first();
        $data = [
            'purchase' => $purchase,
            'purchaseOrderDetail' => $purchaseOrderDetail,
            'customer' => $customers,
            'title' => 'Purchase Order #' . $purchase->id,
            'date' => now()->format('d F Y'),
            'user' => $user,
            'role' => $role,
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
         $user = $this->user->where('id', Auth::id())->first();
        $role = $this->role->where('id', $user->role_id)->first();
        $data = [
            'purchase' => $purchase,
            'purchaseOrderDetail' => $purchaseOrderDetail,
            'customer' => $customers,
            'title' => 'Purchase Order #' . $purchase->id,
            'date' => now()->format('d F Y'),
            'user' => $user,
            'role' => $role,
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
        $user = $this->user->where('id', Auth::id())->first();
        $role = $this->role->where('id', $user->role_id)->first();
        $data = [
            'purchase' => $purchase,
            'purchaseOrderDetail' => $purchaseOrderDetail,
            'customer' => $customers,
            'title' => 'Purchase Order #' . $purchase->id,
            'date' => now()->format('d F Y'),
            'user' => $user,
            'role' => $role,
        ];
        $pdf = PDF::loadView('purchase.pdf_received', $data);
        return $pdf->download('purchase-received-'.$purchase->purchase_number.'.pdf');
    }

}
