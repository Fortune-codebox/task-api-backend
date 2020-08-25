<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use App\Helper\Functions\TaskTrait;
use App\Requests\TaskRequest;
use App\Http\Resources\TaskResource;

class TaskController extends Controller
{

    use TaskTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::latest()->get();
        if($tasks) {
         $resourced = TaskResource::collection($tasks);
         return $this->apiResponse(200, 'success', $resourced);
        }
 
        return $this->apiResponse(200, 'success', []);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        
        $validatedRequest = $request->validated();

        $task = Task::createIfNotExist($validatedRequest);

        return $this->apiResponse(201, 'success', $task);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\task  $task
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::findOrFail($id);

        return $this->apiResponse(200, 'success', $task);    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, $id)
    {
        $task = Task::find($id);
        $validatedRequest = $request->all();
        if($task) {
            if($task->update($validatedRequest)) {
                return $this->apiResponse(200, 'success', []);
            }
        }

        return $this->apiResponse(404, 'fail', []);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\task  $task
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return $this->apiResponse(204, 'success', []);
    }
}
