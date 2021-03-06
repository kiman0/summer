<?php

namespace App\Http\Controllers;

include 'Controller.php';

use App\Models\categories;
use App\Models\books;
use App\Models\interm_table;
use App\Models\interm_tables2;
use App\Models\orders;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function home()
    {
        return view('parse');
    }

    public function parse()
    {
        /**Подключаемся к сайту для парсинга*/
        $url = 'https://book24.ru/knigi-bestsellery/';

        /**и добавляем содержание каждой страницы в строку*/
        $out = file_get_contents($url);

        /**Регулярка для поиска ссылок на книжки с полученной страницы*/
        preg_match_all('#<a\s+?title="[A-Za-zА-Яа-я0-9,.!+-? ]*?"\s+?href="(.+?)"#su', $out, $res);
       // var_dump($res);

        /**Увеличиваем время обработки, чтобы ничего не упало*/
        ini_set('max_execution_time', 300);

        for ($row = 1; $row < 2; $row++) {
            for ($col = 0; $col < 20; $col++) {
                $url1 = "https://book24.ru" . ($res[$row][$col]);
                $out1 = file_get_contents($url1);    //добавляем содержание каждой страницы в строку
                //echo $url1;

                /** Название книжки */
                preg_match_all('#<h1\s*?itemprop="name"\s*?class="product-detail-page__title">\s*?(.+?)\s*?</h1>#su', $out1, $res2);
                //echo $res2[1][0];

                /** Цена книжки */
                preg_match_all('#<b\s*?itemprop="price">\s*?(.+?)\s*?</b>#su', $out1, $res3);
                $comma_separated = implode(",", $res3[1]);
                //echo $comma_separated;

                /** Автор
                 * ( В книжном book24 сейчас занимаются
                 * переделкой сайта и некоторые книги стали парсится по другому,
                 * а некоторые также, как месяц назад, поэтому есть ниже в коде цикл проверки для книжек,
                 * которые подверглись изменению) ! аналогично с ценой
                 */
                preg_match_all('#<a[^>]+?itemprop\s*?=\s*?(["\'])author\1[^>]*?>\s*?(.+?)\s*?</a>#su', $out1, $res4);
                /** Объединяем всех авторов одной книги в строку, если их несколько */
                //$comma_separated = implode(",", $res4[2]);
                // echo $comma_separated;

                /** Жанр книжки/каталог */
                /**preg_match_all('#<a\s*?class="item-tab__chars-link"[^>]+?href\s*?=\s*?["\']/catalog[^>]+?>(.+?)</a>#su', $out1, $res5);*/
                preg_match_all('#<meta\s*?itemprop="genre"\s*?content="\s*?(.+?)\s*?">#su', $out1, $res5);

                /** Картинка */
                /**preg_match_all('#<img\s*?[^>]+?class="item-cover__image _loaded"[^>]+?src="(.+?)"[^>]+?>#su', $out1, $res6);*/
                preg_match_all('#<img src="\s*?(.+?)\s*?"[^>]+?>#su', $out1, $res6);

                // echo "<img src='" .$res6[1][0]. "'></img>";

                /** Проверка Автора, если рез4 не работает, то ищем по тегу meta и берем res4[1] */
                if (count($res4[1]) == 0):
                    {
                        //echo "Автор зашел в цикл: ".$res2[1][0];
                        //preg_match_all('#<meta[^>]+?itemprop="author"\s*?content="\s*?(.+?)\s*?">#su', $out1, $res4);
                        preg_match_all(' #<a\s*?title="\s*?(.+?)\s*?"\s*?href="/author/[^>]+?">#su', $out1, $res4);
                        /** Объединяем всех авторов одной книги в строку, если их несколько */
                        $comma_separated2 = implode(",", $res4[1]);
                        //echo $comma_separated2;

                    };
                endif;


                /** Проверка цены  */
                if (count($res3[1]) == 0):
                    {
                        //echo "Название книги: ".$res2[1][0];
                        /**preg_match_all('#<b\s*?>\s*?(.+?)\s*?</b>#su', $out1, $res3);*/
                        preg_match_all('#<meta\s*?itemprop="price"\s*?content="\s*?(.+?)\s*?">#su', $out1, $res3);
                        // echo 'Ну вот цены:';   //var_dump($res4[1]);  //echo $comma_separated3;
                    };
                endif;

                /** Заполняем нашу БД с книжками и со связями*/
                $counter = $col + 1;
                //echo $counter;
                if ($counter == $col + 1):
                    {
                        $helpers = $res5[1][0];

                        if ($u = DB::table('categories')->where('category_name', '=', $helpers)->first()) {

                        } else {
                            $t2 = new categories();
                            $t2->id = $counter;
                            $t2->category_name = $res5[1][0];
                            $t2->save();
                        }

                        $post = DB::table('categories')->where('category_name', $helpers)->first();

                        if ($u = DB::table('books')->where('book_name', '=', $res2[1][0])->first()) {

                        } else {
                            $t1 = new books();
                            $t1->id = $counter;
                            $t1->book_name = $res2[1][0];
                            $t1->book_author = $comma_separated2;
                            $t1->book_price = (int)($res3[1][0]);
                            $t1->category = $post->category_name;
                            $t1->data_img = $res6[1][0];
                            $t1->save();
                        }
                        echo "book_saved";
                    };
                endif;

            }

        }


    }
}
