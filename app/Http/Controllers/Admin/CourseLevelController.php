<?php

namespace App\Http\Controllers\Admin;

use App\Bank;
use App\CourseLevel;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Session;

class CourseLevelController extends Controller
{
	protected $rules = [
		'name' => 'required',
		'order' => 'required|numeric'
	];


	/**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        return view('admin.course-level.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('admin.course-level.create');
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
        
        CourseLevel::create($requestData);

        Session::flash('flash_message', 'Course Level added!');
        
        return redirect('admin/course-level');
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
        $courseLevel = CourseLevel::findOrFail($id);

        return view('admin.course-level.show', compact('courseLevel'));
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
        $courseLevel = CourseLevel::findOrFail($id);

        return view('admin.course-level.edit', compact('courseLevel'));
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
		
		$courseLevel = CourseLevel::findOrFail($id);
		
        $requestData = $request->all();
        $courseLevel->update($requestData);

        Session::flash('flash_message', 'Course Level updated!');

        return redirect('admin/course-level');
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
		CourseLevel::destroy($id);

        Session::flash('flash_message', 'Course Level deleted!');

        return redirect('admin/course-level');
    }
	
	/**
	 * any data
	 */
	public function anyData(Request $request)
    {
        DB::statement(DB::raw('set @rownum=0'));
        $courseLevel = CourseLevel::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'), 'course_level.*'])->ordered();

         $datatables = app('datatables')->of($courseLevel)
			->editColumn('status', function ($courseLevel) {
				return $courseLevel->getStatusLabel();
			})
			->editColumn('order', function ($courseLevel) {
				return $courseLevel->order;
			})
            ->addColumn('action', function ($courseLevel) {
                return '<a href="course-level/'.$courseLevel->id.'" class="btn btn-xs btn-success rounded" data-toggle="tooltip" title="" data-original-title="'. trans('systems.edit') .'"><i class="fa fa-eye"></i></a> '
						. '<a href="course-level/'.$courseLevel->id.'/edit" class="btn btn-xs btn-primary rounded" data-toggle="tooltip" title="" data-original-title="'. trans('systems.edit') .'"><i class="fa fa-pencil"></i></a> '
						. '<a onclick="deleteData('.$courseLevel->id.')" class="btn btn-xs btn-danger rounded" data-toggle="tooltip" title="" data-original-title="'. trans('systems.delete') .'"><i class="fa fa-trash"></i></a>';
            });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        if ($range = $datatables->request->get('range')) {
            $rang = explode(":", $range);
            if($rang[0] != "Invalid date" && $rang[1] != "Invalid date" && $rang[0] != $rang[1]){
                $datatables->whereBetween('course_level.created_at', ["$rang[0] 00:00:00", "$rang[1] 23:59:59"]);
            }else if($rang[0] != "Invalid date" && $rang[1] != "Invalid date" && $rang[0] == $rang[1]) {
                $datatables->whereBetween('course_level.created_at', ["$rang[0] 00:00:00", "$rang[1] 23:59:59"]);
            }
        }
		
        return $datatables->make(true);
    }
}
