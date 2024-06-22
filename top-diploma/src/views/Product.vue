<!-- Блок каталога с товарами по категориям -->
<template>
    <section class="container">
        <h2 class="p-heading mb-5">Каталог</h2>
            <section v-for="(product, index) in this.productsById" :key="index">
                <div>
                    <h3 class="cat_heading mb-5">{{product.name}}</h3>
                </div>
                <div class="d-flex justify-content-center cat_info">
                    <section class="d-flex" v-for="(item, index) in product.items" :key="index">
                        <div class="card_item me-4 mb-5">
                            <a :href="item.picture" data-lightbox="item.picture" data-title="My caption"><img class="pic_prop mb-4" :src="item.picture" alt="фото букета"></a>
                            <div class="mb-4 price_container">
                                <span class="p_text">Цена: {{item.price}}</span>
                            </div>
                            <div class="d-flex but_container mb-2">
                                <div class="buy_C" @click="AddToBasket(item.id)">Купить</div>
                                <div class="buy_C"  v-if="item.in_basket" @click="DeleteFromBasket(item.id)">Удалить</div>
                                <div class="about_C" @click="this.$router.push(item.link)">Подробнее</div>
                            </div>
                        </div>
                    </section>
                </div>
            </section>
    </section>
</template>

<script>
    import { baseUrlStorage } from "../services/config.js";     // Импорт префикса для хранилища изображений
    import { getProducts } from "../services/ApiMethods";       // Импорт функции получения товаров
    import { getProductsByCategory } from "../services/ApiMethods"; // Импорт функциип получения товаров по категории
    import { toast } from 'vue3-toastify';

    export default {
      name: 'Product',
      components: {
        
      },
      data(){
        return {
            products: [],
            productsById: [],           // Возвращаем товары и товары по категории + состоянии корзины
            productInBasket: false,
        }
      },
      async created(){
        this.products = await this.getProducts();       // Получаем все товары
        this.productsById = await this.getProductsByCategory();     // Получаем товары по ид
        this.productInBasket = this.checkProductInBasket();     // Получаем информацию о товарах, добавленных в корзину
      },
      methods:{
        async getProducts() {       // Метод получения всех товаров
          try {
          let products = await getProducts();   // Присваиваем переменной функцию получения товаров с api
            products = products.data.products.map((item, index) => {    // Перебираем полученные данные и заполняем новый массив
                return {
                    name: item.name,
                    id: item.id,
                    price: item.price,
                    category_id: item.category_id,
                    picture: baseUrlStorage + item.picture,
                    isActual:item.isActual,
                    isAvailable: item.isAvailable,
                    link: '/Products/ProductInfo/' + item.id
                };
            });
                  
            return products;    // Возвращаем заполненный массив
          } catch (error) {     // Выводим ошибку, если товаров нет
              toast.error('Товары не были получены!Ошибка сервера!');
            }   
        },

        async getProductsByCategory() {     // Метод получения товаров по категориям
          try {
          let productsById = await getProductsByCategory(); // Получаем товары по категориям с api
            productsById = productsById.data.categories.map((item, index) => {  // производим перебор полученных данных и формируем новый массив
                return {
                    id: item.id,
                    name: item.name,
                    items: item.items.map((data, index) => {
                            return {
                            id: data.id,
                            picture: baseUrlStorage + data.picture,
                            price: data.price,
                            link: '/Products/ProductInfo/' + data.id,
                            in_basket: this.checkProductInBasket(data.id)
                        }                            
                    }),
                }
            });
            
            return productsById;    // Возвращаем заполненный массив
          } catch (error) {     // Выводим ошибки, если что-то пошло не так
            toast.error('Товары не были получены!Ошибка сервера!');
            }   
        },
        AddToBasket(id) {       // Метод добавления товара в корзину
            if(localStorage.basket == null) {   // Если хранилище пустое, то выполняем код ниже
                let basket = [];    // Объявляем пустой массив
                basket.push(id);    // Забиваем туда ид товара
                localStorage.setItem('basket', JSON.stringify(basket)); // Меняем состояние хранилища, добавляя туда товар
            } else {
                const basket = JSON.parse(localStorage.basket);         // Иначе в корзине уже добавлен товар и просто показываем статус, что один из товаров уже находится в корзине
                basket.push(id);
                localStorage.setItem('basket', JSON.stringify(basket));
            }
            toast.success('Товар был успешно добавлен в корзину!');
            this.checkProductInBasket(id);      // запускаем метод проверки товаров в корзине
            this.productsById.forEach(category=>{   // Перебираем массив каждой категории
                category.items.forEach(items=>{ // В категориях перебираем товары
                    if(items.id === id) {       // Если найден ид товара, который удовлетворяет условию, то отмечаем его состояние как добавлен
                        items.in_basket = this.checkProductInBasket(id);
                    }
                })
            })   
        },
        checkProductInBasket (id) {     // Метод проверки наличия товара в корзине
            if (localStorage.basket == null) {
                return false;               // если товаров нет, то возвращаем false
            }

            const basket = JSON.parse(localStorage.basket);     // Конвертируем товары, которые находятся в хранилище, если есть
            const product = basket.find(element => element === id);     // ищем нужный нам элемент хранилища, он должен равняться ид товара

            if (product == null) {
                return false;           // если ничего не обнаружили, то корзина пуста
            }
            return true;
        },
        DeleteFromBasket(id) {      // Метод удаления товара из корзины
            const basket = JSON.parse(localStorage.basket); // Получаем данные о том, что находится в корзине
            const index = basket.indexOf(id);   // Затем удаляем выбранный товар по ид
            if(index > -1) {
                basket.splice(index, 1);
            }
            toast.info('Добавление товара отменено!');
            localStorage.setItem('basket', JSON.stringify(basket)); // Задаем новое состояние хранилища
            this.productsById.forEach(category=>{   // Перебираем категории и товары внутри них, возвращая измененные данные
                category.items.forEach(items=>{
                    if(items.id === id) {
                        items.in_basket = this.checkProductInBasket(id);
                    }
                })
            })
        }
      }
    }
</script>

<style>
    .p-heading {
        font-family: 'Pacifico';
        font-size: 32px;
        font-weight: 400;
        line-height: 140%;
        color: #502D5C;
        text-align: center;
        margin: 0 auto;
        text-shadow: 4px 4px 3px rgba(0, 0, 0, 0.25);
    }
    .cat_heading {
        font-family: 'Pacifico';
        font-size: 24px;
        line-height: 140%;
        color: #502D5C;
        text-align: center;
        margin: 0 auto;
        margin-bottom: 20px;
        cursor: pointer;
    }
    .pic_prop {
        width: 400px;
        height: 500px;
        border-radius: 12px;
        padding-left: 6px;
        padding-right: 6px;
        padding-top: 6px;
    }
    .p-item {
        margin: 0 auto;
    }
    .price_container {
        text-align: center;
        margin: 0 auto;
    }
    .but_container {
        margin: 0 auto;
        justify-content: space-around;
        width: 100%;
    }
    .cat_heading {
        font-family: 'Pacifico';
        font-size: 24px;
        line-height: 140%;
        color: #502D5C;
        margin: 0 auto; 
    }
    .p_text {
        font-family: 'Noto Serif';
        font-size: 20px;
        line-height: 140%;
        color: #502D5C;
        text-align: center;
        margin: 0 auto;
    }
    .buy_C {
        font-family: 'Noto Serif';
        font-size: 20px;
        line-height: 140%;
        color: #BBBABC;
        text-align: center;
        background-color: #502D5C;
        width: 120px;
        height: 40px;
        padding-top: 5px;
        border-radius: 5px;
        cursor: pointer;
    }
    .about_C {
        font-family: 'Noto Serif';
        font-size: 20px;
        line-height: 140%;
        color: #BBBABC;
        text-align: center;
        background-color: #502D5C;
        width: 150px;
        height: 40px;
        padding-top: 5px;
        border-radius: 5px;
        cursor: pointer;
    }
    .card_item {
        border: 2px solid #502D5C;
        background-color: #EFDAE8;
        margin: 0 auto;
        border-radius: 5px;
    }
    @media screen and (max-width: 1399.98px) 
    {
        .cat_info {
            flex-wrap: wrap;
        }
    }
    @media screen and (max-width: 1399.98px) 
    {
        .buy_C {
            font-size: 18px;
            width: 100px;
        }
        .about_C {
            font-size: 18px;
            width: 130px;
        }
        .but_container {
            flex-direction: row;
        }
    }
    @media screen and (max-width: 431.98px) 
    {
        .pic_prop {
            width: 300px;
            height: 400px;
        }
        .card_item {
            margin: 0 0 10px 0 !important;
        }
        .buy_C {
            font-size: 16px;
            width: 80px;
            height: 35px;
        }
        .about_C {
            font-size: 16px;
            width: 110px;
            height: 35px;
        }
    }
</style>