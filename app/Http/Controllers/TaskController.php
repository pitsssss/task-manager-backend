<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeTaskRequest;
use App\Http\Requests\updateTaskRequest;
use App\Models\Category;
use App\Models\Task;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller {
    // HTTP status codes:
    // 200 = ok, done
    // 201 = created succefuly & dba_open
    // 204 = done, no content
    // 404 = not found
    // 403 = forbidden, limit access
    // 500 = internal server error

    public function index() {
        $tasks = Auth::user()->Tasks;
        return response()->json( $tasks, 200 );
    }

    public function getTasksByPriority() {
        $tasks = Auth::user()->Tasks()->orderByRaw( "FIELD(priority,'high','medium','low')" )->get();
        return response()->json( $tasks, 200 );
    }

    public function store( StoreTaskRequest $request ) {
        $user_id = Auth::user()->id;
        $validatedData = $request->validated();
        $validatedData[ 'user_id' ] = $user_id;
        $task = Task::create( $validatedData );
        return response()->json( $task, 201 );
    }

    public function update( Request $request, $id ) {
        try {
        $user_id = Auth::user()->id;
        $task = Task::findorfail( $id );
        if ( $task->user_id !== $user_id )
        return response()->json( [ 'message'=>'Unauthurized' ], 403 );

        //$task->update( $request->all() );
        $ValidatedData = $request->validate( [
            'Title' => 'sometimes|string|max:30',
            'Description' => 'sometimes|string',
            'Priority' => 'sometimes|integer|min:1|max:5',
            //'user_id' => 'required|exists:users,id'
        ] );
        $task->update( $ValidatedData );
        return response()->json( $task, 200 );
        } catch ( ModelNotFoundException $e ) {
            return response()->json( [
                'Error'=> 'Task Not Found',
                ,'Details'=>$e->getMessage() ], 404);
        }
    }

    public function show( $id ) {
        $user_id = Auth::user()->id;
        $task = Task::findorfail( $id );
        if ( $task->user_id !== $user_id )
        return response()->json( [ 'message'=>'Unauthurized' ], 403 );

        $task = Task::findorfail( $id );
        return response()->json( $task, 200 );
    }

    public function destroy( $id ) {

        try {
            $task = Task::findorfail( $id );
            $task->delete();
            return response()->json( [
                'message'=>' Task deleted successfully' ]
                , 200 );
            } catch( ModelNotFoundException $e ) {
                return response()->json( [
                    'error'=>'Task not found',
                    'Details'=> $e->getMessage()
                ], 404 );

            } catch( Exception $e ) {
                return response()->json( [
                    'error'=>'Something went wrong while deleting...' ,
                    'Details'=> $e->getMessage()
                ], 404 );
            }
        }

        public function getTaskUser( $id ) {
            $user = Task::findOrFail( $id )->user;
            return response()->json( $user, 200 );
        }

        public function addCategoriesToTask( Request $request, $TaskID ) {
            $task = Task::findOrFail( $TaskID );
            $task->categories()->attach( $request->category_id );
            return response()->json( 'Category attached successfully', 200 );

        }

        public function getTasksCategories( $TaskID ) {
            $categories = Task::findOrFail( $TaskID )->categories;
            return response()->json( $categories, 200 );
        }

        public function getCategoriesTasks( $Category_ID ) {
            $tasks = Category::findOrFail( $Category_ID )->tasks;
            return response()->json( $tasks, 200 );
        }

        public function GetAllTasks() {
            $tasks = Task::all();
            return response()->json( $tasks, 200 );
        }

        public function addToFavorites( $taskID ) {
            Task::findOrFail( $taskID );
            Auth::user()->favoriteTasks()->syncWithoutDetaching( $taskID );
            return response()->json( [ 'message'=>'Task added to favorites successfully' ], 200 );

        }

        public function removeFromFavorites( $taskID ) {
            Task::findOrFail( $taskID );
            Auth::user()->favoriteTasks()->detach( $taskID );
            return response()->json( [ 'message'=>'Task removed from favorites successfully' ], 200 );

        }

        public function getFavoritesTasks() {
            $favorites = Auth::user()->favoriteTasks()->get();
            return response()->json( $favorites, 200 );

        }

    }
