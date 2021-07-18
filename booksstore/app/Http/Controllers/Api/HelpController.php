<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HelpResource;
use App\Http\Resources\HelpResource3;
use Illuminate\Http\Request;
use App\Models\categories;
use App\Models\books;


class HelpController extends Controller
{
    /** Этот контроллер содержит GETы для каталога товаров */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        /** Выводим все книжки, которые у нас есть (? каталог)*/
        if ($request->category != null) {
            $data = array();
            $i = 0;
            $category_books = categories::where('id', $request->category)->first()->category_name;
            $all_books = books::all();
            foreach ($all_books as & $wow1) {
                //$help=categories::manbooks($)
                if ($wow1->category == $category_books) {
                    $data[$i] = [$wow1];
                }
                $i++;
            }
            return $data;

        } else {
            return HelpResource::collection(books::all());
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        /** Выводим товар-книжку по айдишнику (? карточка товара)*/
        return new HelpResource(books::findorFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


}
