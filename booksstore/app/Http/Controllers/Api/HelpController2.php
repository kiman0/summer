<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HelpResource2;
use App\Http\Resources\HelpResource;
use Illuminate\Http\Request;
use App\Models\sessions;
use App\Models\help2;
use App\Models\books;
use App\Models\orders;
use App\Models\interm1;


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

      $created_desk2= help2::create([
                    'sessions_id' => $user_id,
                    'bookss_id' => $request->bookss_id,
                    'bookss_count' => $request->bookss_count,
                ]);

        $titles = help2::where('sessions_id', $request->sessions_id)->pluck('bookss_id');
        $price_full=0;
        $count_full=0;
        foreach ($titles as & $wow1) {
            $int = (int)$wow1;
            $price = books::where('id', $wow1)->first()->book_price;
            $int = (int)$price;
            //$count = books::where('id', $wow1)->first()->book_price;
            $count = help2::where('sessions_id', $request->sessions_id)->where('bookss_id',$wow1)->first()->bookss_count;
            $int = (int)$count;
            $price_full=$price_full+$price*$count;
            $count_full=$count_full+$count;
        }
      return [new HelpResource2(sessions::with('products')->findorFail($request->id)),$price_full ,$count_full, books::find($request->bookss_id)];
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
    {/**
        $titles = help2::where('sessions_id', $request->sessions_id)->pluck('bookss_id');
        $price_full=0;
        $count_full=0;
        foreach ($titles as & $wow1) {
            $int = (int)$wow1;
            $price = books::where('id', $wow1)->first()->book_price;
            $int = (int)$price;
            //$count = books::where('id', $wow1)->first()->book_price;
            $count = help2::where('sessions_id', $request->sessions_id)->where('bookss_id',$wow1)->first()->bookss_count;
            $int = (int)$count;
            $price_full=$price_full+$price*$count;
            $count_full=$count_full+$count;
        }*/
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user_id = help2::where('sessions_id', $request->user_id)->where('bookss_id',$request->bookss_id)->first();

       // $helppppp =books::with('help_rel')->findorFail($request);

        if ( ($user_id->bookss_id) == ($request->bookss_id))
        {
          help2::where('sessions_id', $request->user_id)->where('bookss_id',$request->bookss_id)->increment('bookss_count',$request->bookss_count);
        }
        else {
            $created_desk=help2::create([
                'sessions_id' => $request->user_id,
                'bookss_id' => $request->bookss_id,
                'bookss_count' => $request->bookss_count,
            ]);
        }

        $titles = help2::where('sessions_id', $request->sessions_id)->pluck('bookss_id');
        $price_full=0;
        $count_full=0;
        foreach ($titles as & $wow1) {
            $int = (int)$wow1;
            $price = books::where('id', $wow1)->first()->book_price;
            $int = (int)$price;
            //$count = books::where('id', $wow1)->first()->book_price;
            $count = help2::where('sessions_id', $request->sessions_id)->where('bookss_id',$wow1)->first()->bookss_count;
            $int = (int)$count;
            $price_full=$price_full+$price*$count;
            $count_full=$count_full+$count;
        }

        //$posts = help2::with('help_rel')->get();
        //$userssss = help2::where('sessions_id',$request->sessions_id)->pluck('bookss_id');
        //return help2::with('man_books')->get();
        //foreach ($userssss as & $wow2) {
         ////   $hell=new HelpResource(books::where('id', $wow2));


        //$count_full= help2::where('sessions_id', $request->sessions_id)->where(bookss::where())

      return [new HelpResource2(sessions::with('products')->findorFail($request->user_id)),$price_full,$count_full];}
   //  new HelpResource(books::where()->findorFail($request->bookss_id))];
      //  books::find($request->bookss_id)




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //$product = help2::where('sessions_id', $request->user_id)->where('bookss_id',$request->bookss_id)->first();
        //help2::where('sessions_id', $request->user_id)->where('bookss_id',$request->bookss_id)->first()->delete();
        //$product->delete();
        help2::where('sessions_id', $request->id)->where('bookss_id',$request->bookss_id)->delete();
        $titles = help2::where('sessions_id', $request->user_id)->pluck('bookss_id');
        $price_full=0;
        $count_full=0;
        foreach ($titles as & $wow1) {
            $int = (int)$wow1;
            $price = books::where('id', $wow1)->first()->book_price;
            $int = (int)$price;
            //$count = books::where('id', $wow1)->first()->book_price;
            $count = help2::where('sessions_id', $request->sessions_id)->where('bookss_id',$wow1)->first()->bookss_count;
            $int = (int)$count;
            $price_full=$price_full+$price*$count;
            $count_full=$count_full+$count;
        };

        return [new HelpResource2(sessions::with('products')->findorFail($request->user_id)),$price_full,$count_full];
    }
    public function submit(Request $request)
    {
//количество товаров + суммарная стоимость
        $titles = help2::where('sessions_id', $request->user_id)->pluck('bookss_id');
        $price_full=0;
        $count_full=0;
        foreach ($titles as & $wow1) {
            $int = (int)$wow1;
            $price = books::where('id', $wow1)->first()->book_price;
            $int = (int)$price;
            //$count = books::where('id', $wow1)->first()->book_price;
            $count = help2::where('sessions_id', $request->sessions_id)->where('bookss_id',$wow1)->first()->bookss_count;
            $int = (int)$count;
            $price_full=$price_full+$price*$count;
            $count_full=$count_full+$count;
        };

        $id_books= help2::where('sessions_id', $request->user_id)->pluck('bookss_id');
        $user = help2::where('sessions_id', $request->user_id)->pluck('bookss_count');


        $created_desk1=orders::create([
            'order_id' => $request->order_id,
            'name' => $request->name,
            'surname' => $request->surname,
            'patronymic' => $request->patronymic,
            'telephone' => $request->telephone,
            'total_price' => $price_full,
            'email' => $request->email,
            'address' => $request->address,
                ]);

        $titlessss= help2::where('sessions_id', $request->user_id)->pluck('bookss_id');
        //$user = help2::where('sessions_id', $request->user_id)->pluck('bookss_count');

        foreach ($titlessss as & $wow11) {
            $usersss = help2::where('sessions_id', $request->user_id)->where('bookss_id',$wow11)->first()->bookss_count;
            $created_desk2 = interm1::create
            ([
                'ord_id' => $request->order_id,
                'boo_id' => $wow11,
                'quantity' => $usersss,
            ]);
        }

        return [orders::all()];
    }
}
