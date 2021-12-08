<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\Candidate;
use App\Models\Student;
use App\Models\Election;
use Auth;

class TaskController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('permission:tasks.index', ['only' => ['index']]);
		$this->middleware('permission:tasks.create', ['only' => ['create','store']]);
		$this->middleware('permission:tasks.show', ['only' => ['show']]);
		$this->middleware('permission:tasks.edit', ['only' => ['edit','update']]);
		$this->middleware('permission:tasks.destroy', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::select('*');
        if(Auth::user()->hasrole('System Administrator')){
            $tasks = $tasks->withTrashed();
        }

        if(Auth::user()->hasrole('Student')){
            $tasks = $tasks->where('student_id', Auth::user()->student->student_id);
        }

        $data = [
            'tasks' => $tasks->get()
        ];

        return view('tasks.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $officers = Student::officers();
        if(request()->ajax())
        {
            $data = [
                'officers' => $officers
            ];
            return response()->json([
                'modal_content' => view('tasks.create', $data)->render()
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'officer' => ['required'],
            'task' => ['required'],
        ]);

        Task::create([
            'student_id' => $request->get('officer'),
            'task' => $request->get('task'),
            'description' => $request->get('description'),
        ]);

        return redirect()->route('tasks.index')->with('alert-success', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        if(request()->ajax())
        {
            $data = [
                'task' => $task
            ];
            return response()->json([
                'modal_content' => view('tasks.show', $data)->render()
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        if(request()->ajax())
        {
            $officers = Student::officers();
            $data = [
                'task' => $task,
                'officers' => $officers,
            ];
            return response()->json([
                'modal_content' => view('tasks.edit', $data)->render()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'officer' => ['required'],
            'task' => ['required'],
        ]);

        $task->update([
            'student_id' => $request->get('officer'),
            'task' => $request->get('task'),
            'description' => $request->get('description'),
        ]);

        return redirect()->route('tasks.index')->with('alert-success', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
	{
		if (request()->get('permanent')) {
			$task->forceDelete();
		}else{
			$task->delete();
		}
		return redirect()->route('tasks.index')->with('alert-danger','Deleted');
	}

	public function restore($task)
	{
		$task = Task::withTrashed()->find($task);
		$task->restore();
		return redirect()->route('tasks.index')->with('alert-success','Restored');
    }

    public function markAsDone(Task $task)
    {
        $task->update([
            'is_done' => True
        ]);
        return redirect()->route('tasks.index')->with('alert-success', 'success');
    }
}
