<?php
namespace App\Repository;
use Illuminate\Support\Facades\Auth;
use App\Traits\AuthTait;
use App\Models\Task;

class TaskRepository
{
    use AuthTait;

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getTaskOfCurrentUser()
    {
        $this->userAuthCheck();
        $user_id=Auth::id();
        return Task::where('user_id',$user_id)
            ->select('id','user_id','name','description','end_time')
            ->orderBy('end_time','asc')
            ->get();

    }

    /**
     * @return int
     * @throws \Exception
     */
    public function  getTaskCountOfUser():int
    {
        return count($this->getRecentTaskOfCurrentUser());

    }

    /**
     * @param int $numberOf
     * @return mixed
     * @throws \Exception
     */
    public function getRecentTaskOfCurrentUser($numberOf=3)
    {
        $this->userAuthCheck();
        $user_id=Auth::id();
        $ta= Task::where('user_id',$user_id)
            ->orderBy('end_time','asc')
            ->whereDate('end_time','>=',new \DateTime())
            ->take($numberOf)
            ->get();
       return $ta;

    }

    /**
     * @param $task
     * @throws \Exception
     */
    public  function  createTask($task)
    {
        $endTime=(new \DateTime($task['end_time']))->format('y-m-d h:i:s');
        Task::create([
            'name'=>$task['name'],
            'description'=>$task['description'],
            'end_time'=>$endTime,
            'user_id'=>Auth::id(),
        ]);
        if(!$task)
        {
            throw new \Exception('failure save task');
        }
        return $task;
    }
    public function checkIfAuthorized($id)
    {
        $task = Task::where("id", $id)->first();
        if ($task->user_id !== Auth::id()) {
            throw new \Exception("You do not have access to modify this task");
        }
    }
    /**
     * @param $id
     * @return Task
     */
    public function getTaskById($id)
    {
       return Task::findorfail($id);
    }

    /**
     * @param $id
     * @return bool|null
     * @throws \Exception
     */
    public function deleteTaskById($id)
    {
        $this->checkIfAuthorized($id);
       return $this->getTaskById($id)->delete();
    }

    /**
     * @param $id
     * @param $task
     * @return mixed
     * @throws \Exception
     */
    public function  saveTask($id,$task)
    {
        $this->checkIfAuthorized($id);
        if($id==null||!isset($id))
        {
          throw  new \Exception('Task is id required');
        }
        return Task::where('id',$id)->update($task);
    }
}
