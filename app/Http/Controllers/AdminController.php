<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Problem;
use App\Models\User;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $this->getAuthUser();

        $problems = Problem::select('problems.*', 'users.name', 'users.email', 'users.type')
            ->where('deleted', false)
            ->leftJoin('users', 'problems.employee_id', '=', 'users.id')
            ->orderBy('problems.created_at', 'DESC')
            ->paginate(10);

        return view('admin.index', [
            'problems' => $problems,
        ]);
    }


    protected function getAuthUser()
    {
        $user = auth()->user();

        if ($user->type != 'admin')
        {
            return abort(404);
        }

        return $user;
    }


    public function show($problemId)
    {
        $this->getAuthUser();

        $problem = Problem::findOrFail($problemId);
        $employee = User::findOrFail($problem->employee_id);
        $user = User::findOrFail($problem->user_id);

        return view('admin.show', [
            'problem' => $problem,
            'employee' => $employee,
            'user' => $user,
        ]);
    }


    public function stats()
    {
        $this->getAuthUser();

        $stats = User::select(
                'users.*',
                \DB::raw('IFNULL(SUM(IFNULL(`problems`.`finished_at`,CURRENT_TIMESTAMP)-`problems`.`started_at`),0) AS `total_work_time`'),
                \DB::raw('IFNULL(AVG(IFNULL(`problems`.`finished_at`,CURRENT_TIMESTAMP)-`problems`.`started_at`),0) AS `avg_work_time`'),
                \DB::raw('IFNULL(AVG(IFNULL(`problems`.`started_at`, CURRENT_TIMESTAMP)-`problems`.`created_at`),0) AS `avg_reaction_time`'),
            )->leftJoin('problems', 'problems.employee_id', '=', 'users.id')
            ->where('problems.deleted', '=', false)
            ->where('users.type', '=', 'employee')
            ->groupBy('users.id')
            ->paginate(10);

        return view('admin.stats', [
            'stats' => $stats,
        ]);
    }
}
