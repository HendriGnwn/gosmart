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
                return '<a href="admin/teacher/'.$model->id.'" class="btn btn-xs btn-success rounded" data-toggle="tooltip" title="" data-original-title="'. trans('systems.edit') .'"><i class="fa fa-eye"></i></a> '
						. '<a href="admin/user/'.$model->id.'/edit" class="btn btn-xs btn-primary rounded" data-toggle="tooltip" title="Update To Active" data-original-title="'. trans('systems.edit') .'"><i class="fa fa-check"></i></a> ';
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
	
	public function listTotalHistories(Request $request)
    {
        DB::statement(DB::raw('set @rownum=0'));
        $model = \App\TeacherTotalHistory::join('user', 'teacher_total_history.user_id', '=', 'user.id')
			->select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'), 'teacher_total_history.*', 'user.first_name AS first_name', 'user.unique_number AS unique_number'])
				->whereIn('teacher_total_history.status', [\App\TeacherTotalHistory::STATUS_WAITING_FOR_APPROVE, \App\TeacherTotalHistory::STATUS_APPROVED])
				->orderBy('teacher_total_history.created_at', 'desc');

         $datatables = app('datatables')->of($model)
			->editColumn('private_id', function ($model) {
				return isset($model->privateModel) ? $model->privateModel->getDetailHtml($model->privateModel->code) : $model->private_id;
			})
			->editColumn('unique_number', function ($model) {
				return isset($model->user) ? $model->user->unique_number : null;
			})
			->editColumn('first_name', function ($model) {
				return isset($model->user) ? $model->user->getUserDetailHtml() : null;
			})
			->editColumn('total', function ($model) {
				return $model->getFormattedTotal();
			})
			->editColumn('status', function ($model) {
				return $model->getStatusLabel();
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
                $datatables->whereBetween('user.created_at', ["$rang[0] 00:00:00", "$rang[1] 23:59:59"]);
            }else if($rang[0] != "Invalid date" && $rang[1] != "Invalid date" && $rang[0] == $rang[1]) {
                $datatables->whereBetween('user.created_at', ["$rang[0] 00:00:00", "$rang[1] 23:59:59"]);
            }
        }
		
        return $datatables->make(true);
    }
}
