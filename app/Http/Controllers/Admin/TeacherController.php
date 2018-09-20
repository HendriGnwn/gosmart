<?php

namespace App\Http\Controllers\Admin;

use App\Config;
use App\Http\Controllers\Controller;
use App\TeacherCourse;
use App\TeacherTotalHistory;
use Illuminate\Routing\UrlGenerator;
use App\User;
use Carbon\Carbon;
use DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Session;

class TeacherController extends Controller
{
	protected $rules = [
		'title' => 'required',
		'first_name' => 'required',
		'phone_number' => 'required|numeric',
		'address' => 'required',
		'email' => 'required|email|max:100|unique:user,email',
		'password' => 'required|min:6|max:255',
		'role' => 'required',
		'status' => 'required',
	];
	
	protected $rulesCourse = [
		'course_id' => 'required|exists:course,id',
		'description' => 'required',
		'expected_cost' => 'required|numeric',
		'additional_cost' => 'required|numeric',
		'admin_fee' => 'required|numeric',
		'final_cost' => 'required|numeric',
		'status' => 'required',
	];

	/**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        return view('admin.teacher.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('admin.teacher.create');
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
		
		$request['unique_number'] = User::generateUniqueNumber($request->role);
		$requestData = $request->all();
		$user = new User();
		$user->fill($requestData);
		$user->title = $request['title'];
		$user->password = bcrypt($user->password);
		
		switch ($request->role) {
			case User::ROLE_SUPERADMIN :
				$user->save();
				break;
			case User::ROLE_TEACHER :
				$user->insertTeacher();
				break;
			case User::ROLE_STUDENT :
				$user->insertStudent();
				break;
		}
		
        Session::flash('flash_message', 'User added!');
        
        return redirect('admin/teacher');
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
        $model = User::findOrFail($id);

        return view('admin.teacher.show', compact('model'));
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
        $model = User::findOrFail($id);

        return view('admin.teacher.edit', compact('model'));
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
		$rules = $this->rules;
		unset($rules['email']);
		unset($rules['password']);
		$rules['email'] = 'required|email|max:100|unique:user,email,'.$id;
		$rules['password'] = 'max:255';
        $this->validate($request, $rules);
		
		$model = User::findOrFail($id);
		
		if (!empty($request->password)) {
			$request['password'] = bcrypt($request->password);
		} else {
			$request['password'] = $model->password;
		}
        $requestData = $request->all();
        $model->update($requestData);

        Session::flash('flash_message', 'User updated!');

        return redirect('admin/teacher');
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
		User::destroy($id);

        Session::flash('flash_message', 'User deleted!');

        return redirect('admin/teacher');
    }
	
	/**
	 * any data
	 */
	public function anyData(Request $request)
    {
        DB::statement(DB::raw('set @rownum=0'));
        $model = User::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'), 'user.*'])->roleTeacher()->orderBy('user.first_name');

         $datatables = app('datatables')->of($model)
			->editColumn('first_name', function ($model) {
				return $model->getFullName();
			})
			->editColumn('status', function ($model) {
				return $model->getStatusLabel();
			})
			->addColumn('action', function ($model) {
                return '<a href="teacher/'.$model->id.'" class="btn btn-xs btn-success rounded" data-toggle="tooltip" title="" data-original-title="'. trans('systems.edit') .'"><i class="fa fa-eye"></i></a> '
						. '<a href="teacher/'.$model->id.'/edit" class="btn btn-xs btn-primary rounded" data-toggle="tooltip" title="" data-original-title="'. trans('systems.edit') .'"><i class="fa fa-pencil"></i></a> '
						. '<a onclick="deleteData('.$model->id.')" class="btn btn-xs btn-danger rounded" data-toggle="tooltip" title="" data-original-title="'. trans('systems.delete') .'"><i class="fa fa-trash"></i></a>';
            });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        if ($range = $datatables->request->get('range')) {
            $rang = explode(":", $range);
            if($rang[0] != "Invalid date" && $rang[1] != "Invalid date" && $rang[0] != $rang[1]){
                $datatables->whereBetween('user.created_at', ["$rang[0] 00:00:00", "$rang[1] 23:59:59"]);
            }else if($rang[0] != "Invalid date" && $rang[1] != "Invalid date" && $rang[0] == $rang[1]) {
                $datatables->whereBetween('user.created_at', ["$rang[0] 00:00:00", "$rang[1] 23:59:59"]);
            }
        }
		
        return $datatables->make(true);
    }
	
	/**
	 * any data
	 */
	public function listTeacherCourses($id, Request $request)
    {
        DB::statement(DB::raw('set @rownum=0'));
        $model = TeacherCourse::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'), 'teacher_course.*'])->whereUserId($id)->orderBy('teacher_course.created_at');

         $datatables = app('datatables')->of($model)
			->editColumn('course_id', function ($model) {
				return isset($model->course) ? $model->course->name : $model->course_id;
			})
			->editColumn('expected_cost', function ($model) {
				return $model->getFormattedExpectedCost();
			})
			->editColumn('additional_cost', function ($model) {
				return $model->getFormattedAdditionalCost();
			})
			->editColumn('admin_fee', function ($model) {
				return $model->getFormattedAdminFee();
			})
			->editColumn('final_cost', function ($model) {
				return $model->getFormattedFinalCost();
			})
			->editColumn('approved_by', function ($model) {
				return isset($model->approvedBy) ? $model->approvedBy->getFullName() : $model->approved_by;
			})
			->editColumn('module', function ($model) {
				return $model->getModuleHtml();
			})
			->editColumn('status', function ($model) {
				return $model->getStatusLabel();
			})
			->addColumn('action', function ($model) {
                return //'<a href="teacher/'.$model->id.'" class="btn btn-xs btn-success rounded" data-toggle="tooltip" title="" data-original-title="'. trans('systems.edit') .'"><i class="fa fa-eye"></i></a> '
						 '<a href="'.$model->id.'/edit-course" class="btn btn-xs btn-primary rounded" data-toggle="tooltip" title="" data-original-title="'. trans('systems.edit') .'"><i class="fa fa-pencil"></i></a> '
						. '<a onclick="deleteData('.$model->id.')" class="btn btn-xs btn-danger rounded" data-toggle="tooltip" title="" data-original-title="'. trans('systems.delete') .'"><i class="fa fa-trash"></i></a>';
            });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        if ($range = $datatables->request->get('range')) {
            $rang = explode(":", $range);
            if($rang[0] != "Invalid date" && $rang[1] != "Invalid date" && $rang[0] != $rang[1]){
                $datatables->whereBetween('teacher_course.created_at', ["$rang[0] 00:00:00", "$rang[1] 23:59:59"]);
            }else if($rang[0] != "Invalid date" && $rang[1] != "Invalid date" && $rang[0] == $rang[1]) {
                $datatables->whereBetween('teacher_course.created_at', ["$rang[0] 00:00:00", "$rang[1] 23:59:59"]);
            }
        }
		
        return $datatables->make(true);
    }
	
		/**
	 * any data
	 */
	public function listTotalHistories($id, Request $request)
    {
        DB::statement(DB::raw('set @rownum=0'));
        $model = TeacherTotalHistory::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'), 'teacher_total_history.*'])->whereUserId($id)->orderBy('teacher_total_history.created_at');

         $datatables = app('datatables')->of($model)
			->editColumn('private_id', function ($model) {
				return isset($model->privateModel) ? $model->privateModel->getDetailHtml($model->privateModel->code) : $model->private_id;
			})
			->editColumn('operation', function ($model) {
				return $model->getOperationLabel();
			})
			->editColumn('status', function ($model) {
				return $model->getStatusLabel();
			})
			->editColumn('evidence', function ($model) {
				return $model->getEvidenceHtml();
			})
			->editColumn('total', function ($model) {
				return $model->getFormattedTotal();
			})
			->addColumn('action', function ($model) {
				return $model->getActionListHistories();
            });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        if ($range = $datatables->request->get('range')) {
            $rang = explode(":", $range);
            if($rang[0] != "Invalid date" && $rang[1] != "Invalid date" && $rang[0] != $rang[1]){
                $datatables->whereBetween('teacher_total_history.created_at', ["$rang[0] 00:00:00", "$rang[1] 23:59:59"]);
            }else if($rang[0] != "Invalid date" && $rang[1] != "Invalid date" && $rang[0] == $rang[1]) {
                $datatables->whereBetween('teacher_total_history.created_at', ["$rang[0] 00:00:00", "$rang[1] 23:59:59"]);
            }
        }
		
        return $datatables->make(true);
    }
	
	/**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function createCourse($id)
    {
        return view('admin.teacher.create-course', [
			'userId' => $id,
		]);
    }
	
	public function storeCourse($id, Request $request)
	{
		$this->validate($request, $this->rulesCourse);
		
		// unique course id and user id
		
		if ($request->status == TeacherCourse::STATUS_ACTIVE) {
			$request['approved_by'] = \Auth::user()->id;
			$request['approved_at'] = Carbon::now();
		} else {
			$request['approved_by'] = null;
			$request['approved_at'] = null;
		}
		
		if (isset($request->file)) {
			$files = $request->file('file');
			$path = TeacherCourse::DESTINATION_PATH;
			$name = rand(10000,99999).'.'.$files->getClientOriginalExtension();
			$request['module'] = $name;
			$files->move($path,$name);
		} else {
			Session::flash('message', 'Module wajib diisi!'); 
			return redirect('admin/teacher/course/create/' . $id);
		}
		
		$request['user_id'] = $id;
		$request['expected_cost_updated_at'] = Carbon::now();
		$request['additional_cost'] = Config::getAdditionalCost();
		$request['admin_fee'] = Config::getTeacherCourseAdminFee();
		$request['final_cost'] = $request->expected_cost + (Config::getAdditionalCost() + Config::getTeacherCourseAdminFee());
		
		$requestData = $request->all();
		$model = new TeacherCourse();
		$model->fill($requestData);
		$model->save();
		
        Session::flash('flash_message', 'Teacher Course added!');
        
        return redirect('admin/teacher/' . $model->user_id);
	}
	
	/**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return View
     */
    public function editCourse($id)
    {
        $model = TeacherCourse::findOrFail($id);

        return view('admin.teacher.edit-course', compact('model'));
    }
	
	public function updateCourse($id, Request $request)
	{
		$this->validate($request, $this->rulesCourse);
		
		$model = TeacherCourse::findOrFail($id);
		
		if ($request->status == TeacherCourse::STATUS_ACTIVE) {
			$request['approved_by'] = \Auth::user()->id;
			$request['approved_at'] = Carbon::now();
		} else {
			$request['approved_by'] = null;
			$request['approved_at'] = null;
		}
		
		if (isset($request->file)) {
			$model->deleteFile();
			$files = $request->file('file');
			$path = TeacherCourse::DESTINATION_PATH;
			$name = rand(10000,99999).'.'.$files->getClientOriginalExtension();
			$request['module'] = $name;
			$files->move($path,$name);
		}
		
		if ($model->expected_cost != $request->expected_cost) {
			$request['expected_cost_updated_at'] = Carbon::now();
		}
		$request['final_cost'] = $request->expected_cost + ($request->additional_cost + $request->admin_fee);
		
        $requestData = $request->all();
		$model->fill($requestData);
		
        $model->save();
		$model->sendNotificationCourse();

        Session::flash('flash_message', 'Teacher Course updated!');

        return redirect('admin/teacher/' . $model->user_id);
	}
	
	/**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return View
     */
    public function updateTeacherCourse($id)
    {
        $model = TeacherCourse::findOrFail($id);
		
		$model->status = TeacherCourse::STATUS_ACTIVE;
		$model->approved_by = \Auth::user()->id;
		$model->approved_at = Carbon::now();
		$model->save();
		$model->sendNotificationCourse();
		
		Session::flash('flash_message', 'Teacher Course '. $model->user->unique_number .', '. $model->course->name .' updated!');

        return redirect('admin');
    }
	
	/**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return RedirectResponse|Redirector
     */
    public function destroyCourse($id)
    {
		$course = TeacherCourse::findOrFail($id);
		if (isset($course->module)) {
			$course->deleteFile();
		}
		TeacherCourse::destroy($id);

        Session::flash('flash_message', 'User deleted!');

        return redirect('admin/teacher/' . $course->user_id);
    }
	
	public function totalHistoryReject($id)
	{
		$model = TeacherTotalHistory::findOrFail($id);
		$model->status = TeacherTotalHistory::STATUS_REJECTED;
		$model->save();
		
		$model->sendNotificationTotalHistoryReject();
		
		$model->sendEmailReject();
		
		Session::flash('flash_message', 'Total History successfully saved to reject!');
		
		return redirect(app(UrlGenerator::class)->previous());
	}
	
	public function totalHistoryApprove($id)
	{
		$model = TeacherTotalHistory::findOrFail($id);
		$model->approved_by = \Auth::user()->id;
		$model->approved_at = Carbon::now();
		$model->status = TeacherTotalHistory::STATUS_APPROVED;
		$model->save();
		
		$model->sendNotificationTotalHistoryApproved();
		
		Session::flash('flash_message', 'Total History successfully saved to approve!');
		
		return redirect(app(UrlGenerator::class)->previous());
	}
	
	public function totalHistoryDone($id)
	{
		$model = TeacherTotalHistory::findOrFail($id);
		
		return view('admin.teacher.edit-history', compact('model'));
	}
	
	public function storeTotalHistoryDone($id, Request $request)
	{
		$model = TeacherTotalHistory::findOrFail($id);
		
		if (isset($request->file)) {
			$file = $request->file('file');
			$path = TeacherTotalHistory::DESTINATION_PATH;
		    if (isset($model->evidence)) {
				$model->deleteFile();
			}
			$name = rand(10000,99999).'.'.$file->getClientOriginalExtension();
            $file->move($path,$name);
			$model->evidence = $name;
        }
		
		$model->done_by = \Auth::user()->id;
		$model->done_at = Carbon::now();
		$model->status = TeacherTotalHistory::STATUS_DONE;
		$model->save();
		
		$model->sendNotificationTotalHistoryDone();
		
		$model->sendEmailDone();
		
		Session::flash('flash_message', 'Total History successfully saved to done!');
		
		return redirect('admin/teacher/' . $model->user_id);
	}
}
