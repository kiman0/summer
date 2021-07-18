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
    /** Этот контроллер содержит POSTы и GETы для корзины */
    public function index(Request $request)
    {
        /** чекаем по номеру сессии книжки в корзине - таблица help2 */
        $titles = help2::where('sessions_id', $request->id)->pluck('bookss_id');
        //  return (sessions::where('id',$request->id)->first());
        $price_full = 0;
        $count_full = 0;
        foreach ($titles as & $wow1) {
            $int = (int)$wow1;
            $price = books::where('id', $wow1)->first()->book_price;
            /** На всякий случай переводим в число*/
            $int = (int)$price;

            $count = help2::where('sessions_id', $request->id)->where('bookss_id', $wow1)->first()->bookss_count;
            /** На всякий случай переводим в число*/
            $int = (int)$count;

            /** Считаем итоговую стоимость, итоговое количество-на всякий случай*/
            $price_full = $price_full + $price * $count;
            $count_full = $count_full + $count;
        }

        $data = array();
        $i = 0;

        $get_books_name = help2::where('sessions_id', $request->id)->pluck('bookss_id');
        foreach ($get_books_name as & $wow2) {
            $cheks1 = books::where('id', $wow2)->first()->book_name;
            $cheks2 = books::where('id', $wow2)->first()->book_price;
            $cheks3 = books::where('id', $wow2)->first()->data_img;
            $data[$i] = [
                'name' => $cheks1,
                'prices' => $cheks2,
                'image' => $cheks3,
            ];
            $i++;

        }

        return [new HelpResource2(sessions::with('products')->findorFail($request->id)), $price_full, $count_full, $data];


    }

    public function store(Request $request)
    {
        $create_session = sessions::create(
            ['id' => $request->id,
                'user_id' => $request->id,
                /** Какие-то вспомогательные поля, можно поменять их заполнение */
                'payload' => 1,
                'last_activity' => 1,]
        );

        //$books = books::where('id', $request->bookss_id)->first();
        $user_id = sessions::where('id', $request->id)->first()->user_id;

        $possible_order = help2::create([
            'sessions_id' => $user_id,
            'bookss_id' => $request->bookss_id,
            'bookss_count' => $request->bookss_count,
        ]);

        $titles = help2::where('sessions_id', $request->id)->pluck('bookss_id');
        $price_full = 0;
        $count_full = 0;
        foreach ($titles as & $wow1) {
            $int = (int)$wow1;
            $price = books::where('id', $wow1)->first()->book_price;
            $int = (int)$price;

            $count = help2::where('sessions_id', $request->id)->where('bookss_id', $wow1)->first()->bookss_count;
            $int = (int)$count;

            $price_full = $price_full + $price * $count;
            $count_full = $count_full + $count;
        }
        $data = array();
        $i = 0;

        $get_books_name = help2::where('sessions_id', $request->id)->pluck('bookss_id');
        foreach ($get_books_name as & $wow2) {
            $cheks1 = books::where('id', $wow2)->first()->book_name;
            $cheks2 = books::where('id', $wow2)->first()->book_price;
            $cheks3 = books::where('id', $wow2)->first()->data_img;
            $data[$i] = [
                'name' => $cheks1,
                'prices' => $cheks2,
                'image' => $cheks3,
            ];
            $i++;

        }
        return [new HelpResource2(sessions::with('products')->findorFail($request->id)), $price_full, $count_full, $data];
    }


    public function show(Request $request)
    {
        /** чекаем по номеру сессии книжки в корзине - таблица help2 */
        $titles = help2::where('sessions_id', $request->id)->pluck('bookss_id');
        //  return (sessions::where('id',$request->id)->first());
        $price_full = 0;
        $count_full = 0;
        foreach ($titles as & $wow1) {
            $int = (int)$wow1;
            $price = books::where('id', $wow1)->first()->book_price;
            /** На всякий случай переводим в число*/
            $int = (int)$price;

            $count = help2::where('sessions_id', $request->id)->where('bookss_id', $wow1)->first()->bookss_count;
            /** На всякий случай переводим в число*/
            $int = (int)$count;

            /** Считаем итоговую стоимость, итоговое количество-на всякий случай*/
            $price_full = $price_full + $price * $count;
            $count_full = $count_full + $count;
        }

        $data = array();
        $i = 0;

        $get_books_name = help2::where('sessions_id', $request->id)->pluck('bookss_id');
        foreach ($get_books_name as & $wow2) {
            $cheks1 = books::where('id', $wow2)->first()->book_name;
            $cheks2 = books::where('id', $wow2)->first()->book_price;
            $cheks3 = books::where('id', $wow2)->first()->data_img;
            $data[$i] = [
                'name' => $cheks1,
                'prices' => $cheks2,
                'image' => $cheks3,
            ];
            $i++;

        }

        return [new HelpResource2(sessions::with('products')->findorFail($request->id)), $price_full, $count_full, $data];
    }

    public function update(Request $request)
    {
        /** Два пути, если уже есть книжка с ID в корзине, то +ее количество,
         * А если нет, то кладем ее в корзину (создаем новую запись в help2 )*/
        if ((help2::where('sessions_id', $request->id)->where('bookss_id', $request->bookss_id)->first()) != null) {
            $user_id = help2::where('sessions_id', $request->id)->where('bookss_id', $request->bookss_id)->first();

            if (($user_id->bookss_id) == ($request->bookss_id)) {
                help2::where('sessions_id', $request->id)->where('bookss_id', $request->bookss_id)->increment('bookss_count', $request->bookss_count);
            } else {
                $possible_order = help2::create([
                    'sessions_id' => $request->id,
                    'bookss_id' => $request->bookss_id,
                    'bookss_count' => $request->bookss_count,
                ]);
            }
        } else {
            $possible_order = help2::create([
                'sessions_id' => $request->id,
                'bookss_id' => $request->bookss_id,
                'bookss_count' => $request->bookss_count,
            ]);
        };

        $titles = help2::where('sessions_id', $request->id)->pluck('bookss_id');
        $price_full = 0;
        $count_full = 0;

        foreach ($titles as & $wow1) {
            $int = (int)$wow1;
            $price = books::where('id', $wow1)->first()->book_price;
            $int = (int)$price;

            $count = help2::where('sessions_id', $request->id)->where('bookss_id', $wow1)->first()->bookss_count;
            $int = (int)$count;

            $price_full = $price_full + $price * $count;
            $count_full = $count_full + $count;
        }

        $data = array();
        $i = 0;

        $get_books_name = help2::where('sessions_id', $request->id)->pluck('bookss_id');
        foreach ($get_books_name as & $wow2) {
            $cheks1 = books::where('id', $wow2)->first()->book_name;
            $cheks2 = books::where('id', $wow2)->first()->book_price;
            $cheks3 = books::where('id', $wow2)->first()->data_img;
            $data[$i] = [
                'name' => $cheks1,
                'prices' => $cheks2,
                'image' => $cheks3,
            ];
            $i++;

        }
        return [new HelpResource2(sessions::with('products')->findorFail($request->id)), $price_full, $count_full, $data];

    }

    public function destroy(Request $request)
    {
        /** Удаляем товар из корзины
         * Проверка существования товара в корзине происходит на стороне фронта,
         * (если товара нет в корзине, то и отображаться он не будет, как и кнопка удаления заданного товара)
         */
        help2::where('sessions_id', $request->id)->where('bookss_id', $request->bookss_id)->delete();

        $titles = help2::where('sessions_id', $request->id)->pluck('bookss_id');
        $price_full = 0;
        $count_full = 0;
        foreach ($titles as & $wow1) {
            $int = (int)$wow1;
            $price = books::where('id', $wow1)->first()->book_price;
            $int = (int)$price;

            $count = help2::where('sessions_id', $request->id)->where('bookss_id', $wow1)->first()->bookss_count;
            $int = (int)$count;
            $price_full = $price_full + $price * $count;
            $count_full = $count_full + $count;
        };

        return [new HelpResource2(sessions::with('products')->findorFail($request->id)), $price_full, $count_full];
    }

    public function submit(Request $request)
    {
        /** help2 - это корзина, при оформлении заказа, происходит запись корзины в таблицу заказов - orders
         * И во вспомогательную таблицу interm1
         */
        //количество товаров + суммарная стоимость
        $titles = help2::where('sessions_id', $request->id)->pluck('bookss_id');
        $price_full = 0;
        $count_full = 0;
        foreach ($titles as & $wow1) {
            $int = (int)$wow1;
            $price = books::where('id', $wow1)->first()->book_price;
            $int = (int)$price;

            $count = help2::where('sessions_id', $request->id)->where('bookss_id', $wow1)->first()->bookss_count;
            $int = (int)$count;
            $price_full = $price_full + $price * $count;
            $count_full = $count_full + $count;
        };

        $id_books = help2::where('sessions_id', $request->id)->pluck('bookss_id');
        $user = help2::where('sessions_id', $request->id)->pluck('bookss_count');

        $created_desk1 = orders::create([
            'order_id' => $request->order_id,
            'name' => $request->name,
            'surname' => $request->surname,
            'patronymic' => $request->patronymic,
            'telephone' => $request->telephone,
            'total_price' => $price_full,
            'email' => $request->email,
            'address' => $request->address,
        ]);

        $titlessss = help2::where('sessions_id', $request->id)->pluck('bookss_id');
        //$user = help2::where('sessions_id', $request->user_id)->pluck('bookss_count');

        foreach ($titlessss as & $wow11) {
            $usersss = help2::where('sessions_id', $request->id)->where('bookss_id', $wow11)->first()->bookss_count;
            $created_desk2 = interm1::create
            ([
                'ord_id' => $request->order_id,
                'boo_id' => $wow11,
                'quantity' => $usersss,
            ]);
        }

        /** На фронте это не используется (пока что?)*/
        return [orders::all()];
    }
}
