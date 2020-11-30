<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Problem;
use App\Models\User;

class JobController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $userId = $this->getUser()->id;

        $problems = Problem::where('employee_id', $userId)
            ->where('deleted', false)
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        return view('job.index', [
            'problems' => $problems,
        ]);
    }


    public function update($problemId)
    {
        $data = request()->validate([
            'status' => 'required|in:registered,in_progress,finished',
        ]);

        $problem = $this->getProblem($problemId);
        $problem->status = $data['status'];

        switch ($data['status']) {
        case "registered":
            $problem->started_at = null;
            $problem->finished_at = null;
            break;

        case "in_progress":
            if (is_null($problem->started_at))
                $problem->started_at = now();

            $problem->finished_at = null;
            break;

        case "finished":
            if (is_null($problem->started_at))
                $problem->started_at = now();

            if (is_null($problem->finished_at))
                $problem->finished_at = now();

            break;
        }

        $problem->save();

        return redirect(route('jobs.show', ['problemId' => $problem->id]));
    }


    protected function getUser()
    {
        $user = auth()->user();

        if ($user->type != 'employee')
        {
            return abort(404);
        }

        return $user;
    }


    protected function getProblem($problemId)
    {
        $userId = $this->getUser()->id;
        $problem = Problem::where('employee_id', $userId)->findOrFail($problemId);
        return $problem;
    }


    public function show($problemId)
    {
        $problem = $this->getProblem($problemId);
        $user = User::findOrFail($problem->user_id);

        return view('job.show', [
            'problem' => $problem,
            'user' => $user,
        ]);
    }
}
