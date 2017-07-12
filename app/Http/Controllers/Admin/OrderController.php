<?php

namespace App\Http\Controllers\Admin;

use App\Course;
use App\Http\Controllers\Controller;
use App\Order;
use DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Session;

class OrderController extends Controller
{
	protected $rules = [
		'status' => 'required'
	];


	/**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        return view('admin.order.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('admin.order.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse|Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);
		
		$requestData = $request->all();
        
        Order::create($requestData);

        Session::flash('flash_message', 'Order added!');
        
        return redirect('admin/order');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *Bank
     * @return View
     */
    public function show($id)
    {
        $model = Order::findOrFail($id);

        return view('admin.order.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return View
     */
    public function edit($id)
    {
        $model = Order::findOrFail($id);

        return view('admin.order.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     *
     * @return RedirectResponse|Redirector
     */
    public function update($id, Request $request)
    {
        $this->validate($request, $this->rules);
		
		$model = Order::findOrFail($id);
		
        $requestData = $request->all();
		if ($requestData['status'] == Order::STATUS_PAID) {
			$requestData['paid_by'] = \Auth::user()->id;
			$requestData['paid_at'] = \Carbon\Carbon::now();
		}
		
        $model->update($requestData);
		$model->insertToPrivateModel();

        Session::flash('flash_message', 'Order updated!');

        return redirect('admin/order/' . $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return RedirectResponse|Redirector
     */
    public function destroy($id)
    {
		//Order::destroy($id);

        //Session::flash('flash_message', 'Order deleted!');

        return redirect('admin/order');
    }
	
	/**
	 * any data
	 */
	public function anyData(Request $request)
    {
        DB::statement(DB::raw('set @rownum=0'));
        $model = Order::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'), 'order.*']);

         $datatables = app('datatables')->of($model)
			->editColumn('user_id', function ($model) {
				return isset($model->student) ? $model->student->getFullName() : $model->user_id;
			})
			->editColumn('teacher_id', function ($model) {
				return isset($model->teacher) ? $model->teacher->getFullName() : $model->teacher_id;
			})
			->editColumn('admin_fee', function ($model) {
				return $model->getFormattedAdminFee();
			})
			->editColumn('final_amount', function ($model) {
				return $model->getFormattedFinalAmount();
			})
			->editColumn('payment_id', function ($model) {
				return isset($model->payment) ? $model->payment->name : $model->payment_id;
			})
			->editColumn('paid_by', function ($model) {
				return isset($model->paidBy) ? $model->paidBy->getFullName() : $model->paid_by;
			})
			->editColumn('status', function ($model) {
				return $model->getStatusLabel();
			})
            ->addColumn('action', function ($model) {
                return '<a href="order/'.$model->id.'" class="btn btn-xs btn-success rounded" data-toggle="tooltip" title="" data-original-title="'. trans('systems.edit') .'"><i class="fa fa-eye"></i></a> '
						. '<a href="order/'.$model->id.'/edit" class="btn btn-xs btn-primary rounded" data-toggle="tooltip" title="" data-original-title="'. trans('systems.edit') .'"><i class="fa fa-pencil"></i></a> '
						. '<a onclick="deleteData('.$model->id.')" class="btn btn-xs btn-danger rounded" data-toggle="tooltip" title="" data-original-title="'. trans('systems.delete') .'"><i class="fa fa-trash"></i></a>';
            });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        if ($range = $datatables->request->get('range')) {
            $rang = explode(":", $range);
            if($rang[0] != "Invalid date" && $rang[1] != "Invalid date" && $rang[0] != $rang[1]){
                $datatables->whereBetween('order.created_at', ["$rang[0] 00:00:00", "$rang[1] 23:59:59"]);
            }else if($rang[0] != "Invalid date" && $rang[1] != "Invalid date" && $rang[0] == $rang[1]) {
                $datatables->whereBetween('order.created_at', ["$rang[0] 00:00:00", "$rang[1] 23:59:59"]);
            }
        }
		
        return $datatables->make(true);
    }
}
