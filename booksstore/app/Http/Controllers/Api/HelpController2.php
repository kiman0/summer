<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HelpResource2;
use App\Http\Resources\HelpResource;
use Illuminate\Http\Request;
use App\Models\sessions;
use App\Models\help2;
use App\Models\books;


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
        $created_desk=sessions::create(
            ['id' =>  $request->id,
               'user_id' =>  $request->user_id,
                'payload' => 10,
                'last_activity' => 10,]
        );

        $books = books::where('id', $request->bookss_id)->first();
        $user_id = sessions::where('id', $request->id)->first()->user_id;
        $price = books::where('id', $request->bookss_id)->first()->book_price;
        $price_full=$price*($request->bookss_count);
        $counter=0;
       // $objectData=books::where('id', $request->bookss_id);
       // $objectData = (array)$objectData;
        $counter=count([help2::where('sessions_id', $request->id)]);
        //for ($i = 1; $i <= count(help2::where('sessions_id', $request->user_id)); $i++)
       // {

        //}
       // $price = books::where('id', $request->bookss_id)->first()->book_price;



       //if (sessions::where('user_id', $request->user_id)->first() != null)
       // {
          //  $omg = help2::where('product_id', $request->id)->where('cart_id', $user_id)->first();
         //  {

      $created_desk2= help2::create([
                    'sessions_id' => $user_id,
                    'bookss_id' => $books->id,
                    'bookss_count' => $request->bookss_count,
                ]);
      return [new HelpResource2(sessions::with('products')->findorFail($request->id)),$price_full ,$counter,new HelpResource(books::find($request->bookss_id))];
    //return new HelpResource2($created_desk2);

      //  return response()->json(['error' => 'no such product'], 404);
        //$created_desk2=help2::create($request->all());
        /**$$created_desk2 = help2::create([
            'bookss_id' => $request['bookss_id'],   // $request->title also works?
            'bookss_count' => $request['bookss_count'], // $request->body also works?
            'sessions_id' =>  sessions::where('session_id')->find('session_id'), // there might be a better solution, but this works 100%

        ]);*/

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
    public function update(Request $request)
    {   $products_to_update = help2::where('sessions_id', $request->sessions_id)->first();
        $products_to_update->update([
            'count' => $request->bookss_count,
        ]);
        $wow=help2::where('sessions_id', $request->sessions_id)->bookss_id;
        $price = books::where('id', $wow)->first()->book_price;
        $price_full=$price*$wow;
        return [new HelpResource2(sessions::with('products')->findorFail($request->id)),$price_full ,new HelpResource(books::find($request->bookss_id))];
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
