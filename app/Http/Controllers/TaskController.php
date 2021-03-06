<?php

namespace App\Http\Controllers;

// Base functions
use Auth;
use Response;
use Illuminate\Http\Request;
use Validator;
use Crypt;
use DB;

// Our Models
use App\TaskList;
use App\Task;
use App\User;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaskController extends Controller
{

	private $errorMessages = [
		'incorrect_permissions' => 'You do not have permission to do this.',
		'task_not_created'      => 'Something went wrong, task creation failed',
		'invalid_list_id'       => 'That list ID is invalid',
		'invalid_task_id'       => 'That task ID is invalid'
	];

	private $successMessages =[
		'task_created' => 'Your task was added successfully',
		'task_updated' => 'Task updated successfully!',
		'task_deleted' => 'Task deleted successfully!'
	];

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$data = $request->only(['description', 'list_id']);

		try {

			// Decrypt List ID
			$data['task_list_id'] = Crypt::decrypt($data['list_id']);

			$list = TaskList::find( $data['task_list_id'] );
			if( $list->user->id == Auth::user()->id ){
				// If the user who sent the message owns the list
				
				$data['done'] = false;
				$task = Task::create($data);
				if( $task ){
					// If task creation succeeded
					return Response::json( [ 'success' => $this->successMessages['task_created'], 'task' => $task ] );
				} else {
					// If task creation failed
					return Response::json([ 'error' => $this->errorMessages['task_not_created'] ]);
				}
			} else {
				// If user doesn't own the current list
				return Response::json([ 'error' => $this->errorMessages['incorrect_permissions'] ]);
			}

		} catch (DecryptException $e) {
			// If decryption fails, it's an invalid ID
			return Response::json([ 'error' => $this->errorMessages['invalid_list_id'] ]);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$data = $request->only(['description', 'done']);
		try {
			$task = Task::find( $id );
			// DB::enableQueryLog();
			// $task->tasklist;
			// dd( DB::getQueryLog() );

			if( $task->tasklist->user->id == Auth::user()->id ){
				// Update the task based on the supplied data
				$data['done'] = ($data['done'] == "true" ? 1 : 0);
				$task->update( $data );

				return Response::json([ 'success' => $this->successMessages['task_updated'] ]);
			} else{
				return Response::json([ 'error' => $this->errorMessages['incorrect_permissions']]);
			}
		} catch (ModelNotFoundException $e) {
			// If no task can be found, the task doesn't exist
			return Response::json([ 'error' => $this->errorMessages['invalid_task_id'] ]);
		}

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		try {
			$id = Crypt::decrypt( $id );

			try {
				$task = Task::find( $id );
				// Delete the task
				$task->delete();

				return Response::json([ 'success' => $this->successMessages['task_deleted'] ]);
			} catch (ModelNotFoundException $e) {
				// If no task can be found, the task doesn't exist
				return Response::json([ 'error' => $this->errorMessages['invalid_task_id'] ]);
			}

		} catch (DecryptException $e) {
			// If decryption fails, it's an invalid ID
			return Response::json([ 'error' => $this->errorMessages['invalid_task_id'] ]);
		}
	}

	/**
	 * Retrieve all the tasks for a list
	 * @param  string $encryptedListID 
	 * @return JSON
	 */
	public function getTasks( $encryptedListID ){
		try {
			$id = Crypt::decrypt( $encryptedListID );

			$list = TaskList::find( $id );
			$tasks = $list->tasks;
			$counter = 0;
			foreach ($tasks as $task) {
				$tasks[ $counter ]->token = Crypt::encrypt( $task->id );
				$counter++;
			}
			
			return Response::json($tasks);

		} catch (DecryptException $e) {
			// If decryption fails, it's an invalid ID
			return Response::json([ 'error' => $this->errorMessages['invalid_list_id'] ]);
		}  catch (ModelNotFoundException $e) {
			// If no task can be found, the task doesn't exist
			return Response::json([ 'error' => $this->errorMessages['invalid_list_id'] ]);
		}
	}
}
