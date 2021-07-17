<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HelpResource2;
use Illuminate\Http\Request;
use App\Models\sessions;
use App\Models\help2;


class HelpController2 extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return HelpResource2::collection(sessions::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $created_desk=sessions::create($request->all());
        //$created_desk2=help2::create($request->all());
        /**$$created_desk2 = help2::create([
            'bookss_id' => $request['bookss_id'],   // $request->title also works?
            'bookss_count' => $request['bookss_count'], // $request->body also works?
            'sessions_id' =>  sessions::where('session_id')->find('session_id'), // there might be a better solution, but this works 100%

        ]);*/
        return new HelpResource2($created_desk);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new HelpResource2(sessions::with('products')->findorFail($id));
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
    }
}
