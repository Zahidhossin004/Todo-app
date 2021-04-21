<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Repository\TaskRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    private  $taskRepository;
    public  function  __construct(TaskRepository $taskRepository)
    {
        $this->middleware('auth');
       $t= $this->taskRepository=$taskRepository;

    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     * @throws \Exception
     */
    public function index()
    {
       $tasks= $this->taskRepository->getRecentTaskOfCurrentUser(3);
      // dd($tasks);

        return view('home',compact('tasks'));
    }
}
