<?php

namespace App\Http\Controllers;

use View;
use Auth;
use Response;
use Redirect;
use Request;
use Validator;
use Crypt;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

    /**
     * Check that slug is unique
     * @param  string  $slug      
     * @param  boolean $userScope  (Whether to limit uniqueness to username)
     * @return boolean/string
     */
    private function checkSlug( $slug, $userScope = true ){
        if( $userScope ){
            $lists = List::where('slug', $value)->where('user_id', Auth::user()->id)->get();
        } else {
            $lists =List::where('slug', $value)->get();
        }

        if( empty( $lists ) ){
            return true;
        } else {
            return $this->errorMessages['slug_not_unique'];
        }
    }
}
