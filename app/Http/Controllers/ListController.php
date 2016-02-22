<?php

namespace App\Http\Controllers;

// Base includes
use View;
use Auth;
use Response;
use Redirect;
use Illuminate\Http\Request;
use Validator;
use Crypt;
use Session;

// Our Models
use App\TaskList;
use App\Task;
use App\User;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ListController extends Controller
{

    private $errorMessages = [
        'incorrect_permissions' => 'You do not have permission to do this.',
        'list_not_created'      => 'Something went wrong, list creation failed',
        'invalid_list_id'       => 'That list ID is invalid',
        'invalid_task_id'       => 'That task ID is invalid',
        'list_not_found'        => 'We couldn\'t find that list, sorry',
        'slug_not_unique'       => 'Your slug isn\'t unique!'
    ];

    private $successMessages =[
        'list_created' => 'Your list was created successfully! Happy to-doing!',
        'list_updated' => 'Task updated successfully!',
        'list_deleted' => 'Task deleted successfully!'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lists = Auth::user()->lists;
        return view('lists.index')->with('lists', $lists);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('lists.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Only allow following fields to be submitted
        $data = $request->only([ 'title', 'slug', 'global' ]);

        // Checkbox transmits "on" if checked
        $data['global'] = ($data['global'] == 'on' ? true : false );

        // Validate all input
        $validator = Validator::make( $data, [
                    'title'  => 'required',
                    'slug'   => 'alpha_dash|required'
                ]);

        $slugError = $this->checkSlug( $data['slug'], $data['global'] );

        if( $validator->fails( ) || $slugError ){
            if( $slugError ){
                // If our slug error exists, add it to the validator errors
                $validator->errors()->add('slug', $this->errorMessages['slug_not_unique']);
            }
            // If validation fails, redirect back with errors
            return Redirect::back( )
                    ->withErrors( $validator )
                    ->withInput( );
        }

        // Get user's ID and create the list
        $data['user_id'] = Auth::user()->id;
        $list = TaskList::create( $data );

        if( $list ){
            return redirect()->route('list.show', $list->id )->with( 'success', $this->successMessages['list_created'] );
        } else {
            return Redirect::back()->withErrors( [$this->errorMessages['list_not_created']] );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $list = TaskList::find( $id );

        if( $list->global ){
            return redirect()->route('showBySlug', [$list->slug]);
        } else{
            return redirect()->route('showByUserSlug', [ 'slug' => $list->slug, 'username' => $list->user->name]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showBySlug($slug)
    {
        $list = TaskList::where('slug', $slug)->where('global', true)->first();
        return view('lists.show')->with('list', $list);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showByUserSlug($username, $slug)
    {
        if( $username == "images" ){
            return redirect('/');
        }
        $user = User::where('name', $username)->first();
        $list = TaskList::where('slug', $slug)->where('user_id', $user->id)->first();

        return view('lists.show')->with('list', $list);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {

            $id = Crypt::decrypt( $id );
            $list = TaskList::find( $id );
            return view('lists.show')->with('list', $list);

        } catch (DecryptException $e) {
            return back()->with( 'error', $this->errorMessages['invalid_list_id'] );
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

        try {
            $id = Crypt::decrypt( $id );
            // Only allow following fields to be submitted
            $data = $request->only([ 'title', 'slug', 'global' ]);

            // Validate all input
            $validator = Validator::make( $data, [
                        'title'  => 'required',
                        'slug'   => 'alpha_dash|required'
                    ]);

            $slugError = $this->checkSlug( $data['slug'], $data['global'] );

            if( $validator->fails( ) || $slugError ){
                if( $slugError ){
                    // If our slug error exists, add it to the validator errors
                    $validator->errors()->add('slug', $this->errorMessages['slug_not_unique']);
                }
                // If validation fails, redirect back with errors
                return Response::json( $validator->errors() );
            }

            // Get user's ID and create the list
            $data['user_id'] = Auth::user()->id;
            $list = TaskList::find( $id );
            $list->update( $data );

            return Response::json([ 'success' => $this->successMessages['list_updated'] ]);
        } catch (DecryptException $e) {
            return Response::json([ 'error' => $this->errorMessages['invalid_list_id'] ]);
        } catch (ModelNotFoundException $e){
            return Response::json([ 'error' => $this->errorMessages['list_not_found']]);
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
            $list = TaskList::find( $id );
            $list->delete();
        } catch (DecryptException $e) {
            return Response::json([ 'error' => $this->errorMessages['invalid_list_id'] ]);
        } catch (ModelNotFoundException $e){
            return Response::json([ 'error' => $this->errorMessages['list_not_found']]);
        }
    }

    /**
     * Check that slug is unique
     * @param  string  $slug      
     * @param  boolean $global  (Whether to limit uniqueness to username)
     * @return boolean
     */
    private function checkSlug( $slug, $global = true ){
        if( !$global ){
            $lists = TaskList::where('slug', $slug)->where('user_id', Auth::user()->id)->where('global', false)->get();
        } else {
            $lists = TaskList::where('slug', $slug)->where('global', true)->get();
        }

        if( $lists->isEmpty() ){
            return false;
        } else {
            return true;
        }
    }
}
