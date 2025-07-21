<?php

namespace App\Http\Controllers;

use App\Models\CustomerOrder;
use Auth;
use Illuminate\Http\Request;
use DataTables;
use Storage;
use Validator;
use App\Helpers\Bahasa;
use Carbon\Carbon;

class CustomerOrderController extends Controller

{

    public function __construct(CustomerOrder $customerOrder)
    {
        $this->jasmin = $customerOrder;
    }

    public function index()
    {
        return view('jasmin.index');
    }

    public function create()
    {
        return view('jasmin.form');
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
            $this->jasmin->create($data);

            \Session::flash('success', 'jasmin has been created');
            return redirect()->route('jasmin.index');
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
        $customerOrder = $this->jasmin->where('id', $id)->first();
        $customerOrder_title =  json_decode($customerOrder->title);
        $customerOrder['id_title'] = $customerOrder_title->id;
        $customerOrder['en_title'] = $customerOrder_title->en;
        return view('jasmin.form', compact('jasmin'));
    }


    public function update(Request $request, $id)
    {
        $customerOrder = $this->jasmin->where('id', $id)->first();

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

            $customerOrder->update($data);

            \Session::flash('success', 'jasmin has been updated');
            return redirect()->route('jasmin.index');
        } else {
            return redirect()->back()
                ->withErrors($validation)->withInput();
        }
    }

    public function destroy($id)
    {
        $customerOrder = $this->jasmin->where('id', $id)->first();

        $customerOrder->delete();

        \Session::flash('success', 'jasmin has been deleted');
        return redirect()->route('jasmin.index');
    }

    public function ajax(Request $request)
    {
       
        $customerOrders = $this->jasmin->latest()->get();

        return Datatables::of($customerOrders)
            ->addColumn('title', function ($customerOrders) {
                $customerOrder = $customerOrders;
                return Bahasa::translate($customerOrder['title']);
            })
            ->addColumn('status', function ($customerOrders) {
                $customerOrder = $customerOrders;
                if ($customerOrder->status_publish == "1") {
                    return '<span class="badge bg-info">Active</span>';
                } else {
                    return '<span class="badge bg-secondary">Non Active</span>';
                }
            })
            ->addColumn('publish_date', function ($customerOrders) {
                $customerOrder = $customerOrders;
                $date = Carbon::createFromFormat('Y-m-d H:i:s', $customerOrder->publish_at)
                ->format('d M Y - H:i');
                return $date;
            })
            ->addColumn('actions', function ($customerOrders) {
                $customerOrder = $customerOrders;
                return view('jasmin.action', compact('jasmin'))->render();
            })->rawColumns(['image', 'status', 'actions'])->make(true);
    }

}
