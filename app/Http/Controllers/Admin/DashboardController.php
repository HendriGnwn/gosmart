<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        return view('admin.dashboard');
    }
	
	public function listTeachers(Request $request)
    {
        DB::statement(DB::raw('set @rownum=0'));
        $model = User::join('teacher_profile', 'teacher_profile.user_id', '=', 'user.id')
			->select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'), 'user.*', 
				'teacher_profile.graduated AS graduated', 'teacher_profile.title AS title'])
				->roleTeacher()
				->statusInactive()
				->orderBy('user.created_at', 'desc');

         $datatables = app('datatables')->of($model)
			->editColumn('title', function ($model) {
				return isset($model->teacherProfile) ? $model->teacherProfile->getTitleLabel() : null;
			})
			->editColumn('first_name', function ($model) {
				return $model->getFullName();
			})
            ->addColumn('action', function ($model) {
                return '<a href="user/'.$model->id.'" class="btn btn-xs btn-success rounded" data-toggle="tooltip" title="" data-original-title="'. trans('systems.edit') .'"><i class="fa fa-eye"></i></a> '
						. '<a href="user/'.$model->id.'/update-status" class="btn btn-xs btn-primary rounded" data-toggle="tooltip" title="Update To Active" data-original-title="'. trans('systems.edit') .'"><i class="fa fa-check"></i></a> ';
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
}
