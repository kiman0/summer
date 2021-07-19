# summer
Ким Су Ен (Анастасия), back-end
Front-end: https://github.com/veronicazzzz/summer-practice

Реализовано:
1. Проектирование базы данных
P.S. В booksstore/database/migrations присутсвуют дефолтные таблицы типа Users, passwords, failedjobs, которые не ипользуются в проекте.

2. Заполнение базы данных
  2.2. Парсинг данных с существующего сайта
  В качестве источника был выбран сайт интернет-магазина book24 ( https://book24.ru/knigi-bestsellery/ )
  Чтобы запустить парсер: http://127.0.0.1:8000/parse . после каждой удачно добавленной записи в бд, будет выведено сообщение.
  Лежит в App\Http\Controllers\MainController.php

3. Разработка API 
  1) GET /products - Метод для получения списка товаров. Поддерживает фильтрацию по категории. .../api/products?category={id}.
  2) GET /products/{id} - Метод для получения товара по ID.  .../api/products/{id}.
  3) GET /cart Метод для получения списка товаров из корзины. Возвращает количество и итоговую стоимость товаров в корзине.
  .../api/cart?id={id}. (id-идентификатор пользователя)
  4) POST /cart/add Метод для добавления товара в корзину. ID добавленных товаров и их количество хранить в сессии пользователя. 
  .../api/cart/add?id={id}?bookss_id={bookss_id}?bookss_count={bookss_count}.
  5) POST /cart/update Метод для изменения количества товара в корзине. 
  .../api/cart/update?id={id}?bookss_id={bookss_id}?bookss_count={bookss_count}.
  6) POST /cart/delete Метод для удаления товара из корзины. 
  .../api/cart/delete?id={id}?bookss_id={bookss_id}?bookss_count={bookss_count}.
  7) POST /cart/submit Метод для оформления заказа. Принимает контактные данные пользователя и сохраняет их вместе с товарами из корзины в бд. 
  .../api/cart/add/?id={id}?name={bookss_id}?surname={bookss_count}?patronymic={patronymic}?telephone={telephone}?email={email}?=address={address}.


  
