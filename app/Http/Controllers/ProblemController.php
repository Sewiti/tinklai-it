<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Problem;
use App\Models\User;

class ProblemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $userId = auth()->user()->id;
        // $problems = Problem::where('user_id', $userId)->where('deleted', false)->get();
        $problems = $this->getProblem(null);

        return view('problem.index', [
            'problems' => $problems,
        ]);
    }


    public function store()
    {
        $data = $this->validatedData();

        $userId = auth()->user()->id;

        $problem = new Problem();
        $problem->title = $data['title'];
        $problem->desc = $data['desc'];
        $problem->user_id = $userId;

        $employee = User::select('users.*', \DB::raw('IFNULL(aj.active_jobs, 0) AS active_jobs'))
            ->leftJoin(\DB::raw("(
                SELECT `employee_id`, COUNT(`employee_id`) AS `active_jobs` FROM `problems`
                WHERE `status`!='finished' AND `deleted`=FALSE
                GROUP BY `employee_id`
            ) AS `aj`"), 'aj.employee_id', 'users.id')
            ->where('users.type', 'employee')
            ->orderBy('active_jobs', 'ASC')
            ->orderBy('users.created_at', 'ASC')
            ->first();

        $problem->employee_id = $employee->id;
        $problem->save();

        return redirect(route('problems.show', ['problemId' => $problem->id]));
    }


    public function update($problemId)
    {
        $data = $this->validatedData();

        $problem = $this->getProblem($problemId);
        $problem->title = $data['title'];
        $problem->desc = $data['desc'];
        $problem->save();

        return redirect(route('problems.show', ['problemId' => $problem->id]));
    }


    protected function validatedData()
    {
        return request()->validate([
            'title' => 'required|min:3|max:50',
            'desc' => 'required|min:5|max:1000',
        ]);
    }


    protected function getProblem($problemId)
    {
        $userId = auth()->user()->id;
        $problems = Problem::where('user_id', $userId)->where('deleted', false);

        if (is_null($problemId)) {
            return $problems->paginate(10);
        }

        return $problems->findOrFail($problemId);
    }


    public function destroy($problemId)
    {
        $problem = $this->getProblem($problemId);
        $problem->deleted = true;
        $problem->save();

        return redirect(route('problems.index'));
    }


    public function create()
    {
        return view('problem.create');
    }


    public function show($problemId)
    {
        $problem = $this->getProblem($problemId);
        return view('problem.show', [
            'problem' => $problem,
        ]);
    }


    public function edit($problemId)
    {
        $problem = $this->getProblem($problemId);
        return view('problem.edit', [
            'problem' => $problem,
        ]);
    }
}
