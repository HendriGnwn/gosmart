<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\PrivateModel;
use DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Session;

class PrivateController extends Controller
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
        return view('admin.private.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('admin.private.create');
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
        
        PrivateModel::create($requestData);

        Session::flash('flash_message', 'Private added!');
        
        return redirect('admin/private');
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
        $model = PrivateModel::findOrFail($id);

        return view('admin.private.show', compact('model'));
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
        $model = PrivateModel::findOrFail($id);

        return view('admin.private.edit', compact('model'));
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
		
		$model = PrivateModel::findOrFail($id);
		
        $requestData = $request->all();
		
        $model->update($requestData);

        Session::flash('flash_message', 'Private updated!');

        return redirect('admin/private/' . $id);
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

        return redirect('admin/private');
    }
	
	/**
	 * any data
	 */
	public function anyData(Request $request)
    {
        DB::statement(DB::raw('set @rownum=0'));
        $model = PrivateModel::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'), 'private.*']);

         $datatables = app('datatables')->of($model)
			->editColumn('user_id', function ($model) {
				return isset($model->student) ? $model->student->getFullName() : $model->user_id;
			})
			->editColumn('teacher_id', function ($model) {
				return isset($model->teacher) ? $model->teacher->getFullName() : $model->teacher_id;
			})
			->editColumn('status', function ($model) {
				return $model->getStatusLabel();
			})
            ->addColumn('action', function ($model) {
                return '<a href="private/'.$model->id.'" class="btn btn-xs btn-success rounded" data-toggle="tooltip" title="" data-original-title="'. trans('systems.edit') .'"><i class="fa fa-eye"></i></a> '
						. '<a href="private/'.$model->id.'/edit" class="btn btn-xs btn-primary rounded" data-toggle="tooltip" title="" data-original-title="'. trans('systems.edit') .'"><i class="fa fa-pencil"></i></a> '
						. '<a onclick="deleteData('.$model->id.')" class="btn btn-xs btn-danger rounded" data-toggle="tooltip" title="" data-original-title="'. trans('systems.delete') .'"><i class="fa fa-trash"></i></a>';
            });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        if ($range = $datatables->request->get('range')) {
            $rang = explode(":", $range);
            if($rang[0] != "Invalid date" && $rang[1] != "Invalid date" && $rang[0] != $rang[1]){
                $datatables->whereBetween('private.created_at', ["$rang[0] 00:00:00", "$rang[1] 23:59:59"]);
            }else if($rang[0] != "Invalid date" && $rang[1] != "Invalid date" && $rang[0] == $rang[1]) {
                $datatables->whereBetween('private.created_at', ["$rang[0] 00:00:00", "$rang[1] 23:59:59"]);
            }
        }
		
        return $datatables->make(true);
    }
}
