<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Payment;
use Illuminate\Http\Request;
use Session;
use DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.payment.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.payment.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
			'name' => 'required'
		]);
        $requestData = $request->all();
        
        Payment::create($requestData);

        Session::flash('flash_message', 'Payment added!');

        return redirect('admin/payment');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $payment = Payment::findOrFail($id);

        return view('admin.payment.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $payment = Payment::findOrFail($id);

        return view('admin.payment.edit', compact('payment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
			'name' => 'required'
		]);
        $requestData = $request->all();
        
        $payment = Payment::findOrFail($id);
        $payment->update($requestData);

        Session::flash('flash_message', 'Payment updated!');

        return redirect('admin/payment');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Payment::destroy($id);

        Session::flash('flash_message', 'Payment deleted!');

        return redirect('admin/payment');
    }
	
	/**
	 * any data
	 */
	public function anyData(Request $request)
    {
        DB::statement(DB::raw('set @rownum=0'));
        $payment = Payment::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'), 'payment.*']);

         $datatables = app('datatables')->of($payment)
			->editColumn('status', function ($payment) {
				return $payment->getStatusLabel();
			})
            ->addColumn('action', function ($payment) {
                return '<a href="payment/'.$payment->id.'" class="btn btn-xs btn-success rounded" data-toggle="tooltip" title="" data-original-title="'. trans('systems.edit') .'"><i class="fa fa-eye"></i></a> '
						. '<a href="payment/'.$payment->id.'/edit" class="btn btn-xs btn-primary rounded" data-toggle="tooltip" title="" data-original-title="'. trans('systems.edit') .'"><i class="fa fa-pencil"></i></a> '
						. '<a onclick="deleteData('.$payment->id.')" class="btn btn-xs btn-danger rounded" data-toggle="tooltip" title="" data-original-title="'. trans('systems.delete') .'"><i class="fa fa-trash"></i></a>';
            });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        if ($range = $datatables->request->get('range')) {
            $rang = explode(":", $range);
            if($rang[0] != "Invalid date" && $rang[1] != "Invalid date" && $rang[0] != $rang[1]){
                $datatables->whereBetween('payment.created_at', ["$rang[0] 00:00:00", "$rang[1] 23:59:59"]);
            }else if($rang[0] != "Invalid date" && $rang[1] != "Invalid date" && $rang[0] == $rang[1]) {
                $datatables->whereBetween('payment.created_at', ["$rang[0] 00:00:00", "$rang[1] 23:59:59"]);
            }
        }
		
        return $datatables->make(true);
    }
}
