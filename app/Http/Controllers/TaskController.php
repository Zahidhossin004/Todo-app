<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Repository\TaskRepository;
class TaskController extends Controller
{
    private  $taskRepository;
    public  function  __construct(TaskRepository $taskRepository)
    {
        $this->middleware('auth');
        $this->taskRepository=$taskRepository;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Exception
     */
    public  function list()
    {
        $tasks=$this->taskRepository->getTaskOfCurrentUser();
        return view('tasks.list',compact('tasks'));
    }
    public function  create()
    {
      return view('tasks.create');
    }

    /**
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public  function  store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|min:8|max:120',
            'description' => 'required|string',
            'end_time'=>'required|date|after:today',
        ]);
        $taskSave=$this->taskRepository->createTask($request->except('_token'));
        if($taskSave)
        {
            return redirect()->route('task_list');
        }
        else{
            return view('4o4');
        }

    }


    public function  edit($id)
    {
        return view('tasks.edit',['task'=>$this->taskRepository->getTaskById($id)]);
    }

    /**
     * @param $id
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public  function update($id,Request $request)
    {
        $this->validate($request,[
            'name' => 'required|min:8|max:120',
            'description' => 'required|string',
            'end_time'=>'required|date|after:today',
        ]);
       $task=$this->taskRepository->saveTask($id,$request->except('_token'));
        if($task)
        {
            return redirect()->route('task_list');
        }
        else{
            return view('4o4');
        }
    }
    public function  delete($id)
    {
        $this->taskRepository->deleteTaskById($id);
        return redirect()->route('task_list');
    }
    public function complete($taskId)
    {
        //$this->taskRepository->checkIfAuthorized($taskId);
        $task = $this->taskRepository->saveTask($taskId, [
            'status' => config('status.Completed')
        ]);
        if ($task) {
            return redirect(route('task_list'));
        } else {
            return view('404');
        }
    }
}
