<!-- Блок каталога товаров магазина по категориям -->
<template>
    <section class="mt-5 mb-5">
              <h2 class="h-text mb-5">Каталог</h2>
              <div class="d-flex item_container">
                  <div class="item_bouqet justify-content-between mb-5" v-for="(category, index) in this.category" :key="index">
                      <h3 class="cat-h">{{category.name}}</h3>
                      <div class="img_container">
                        <a :href="category.image_preview" data-lightbox="image.preview" data-title="My caption"><img :src="category.image_preview" class="img_size mb-3" alt=""></a>
                      </div>
                      <form action="" class="calltoaction">
                          <div class="bt" @click="this.$router.push('/Products')">Купить</div>
                      </form>
                  </div>
              </div>
        </section>    
</template>
  
<script>
    import { getCategories } from "../../services/ApiMethods";  // Импортируем функцию, которая получает катеогории с сервера
    import { baseUrlStorage } from "../../services/config.js";  // Импортируем префикс для изображений, чтоб корректно отобразить путь к ним
    import { toast } from 'vue3-toastify';

    export default {
      name: 'Catalog',
      components: {
        
      },
      data(){
        return {
            category: [], // Возвращаем пустой массив с категориями
        }
      },
      async created(){
        this.category = await this.getCategories(); // приравниваем пустой массви к методу, в котором производим отбор данных с бэка и выводим
      },
      methods:{
        async getCategories() { // Метод получения категорий с бэка
          try {
          let category = await getCategories(); // Задаем переменную категорий, приравниваем ее к функции получения категорий с бэка
            category = category.data.categories.map((item, index) => {  // перебираем массив данных с бэка и выводим нужные нам данные
                return {
                    name: item.name,
                    id: item.id,
                    image_preview: baseUrlStorage + item.prevImage
                };
            });
            
            return category;  // Возвращаем категории после перебора
          } catch (error) {
              toast.error('Ни одной категории обнаружить не удалось! Ошибка!'); //Выводим тост об ошибке, если она есть
            }   
        },
      }
    }
</script>

<style>
  .calltoaction {
    font-family: 'Noto Serif';
    font-size: 20px;
    background-color: #502D5C;
    width: fit-content; 
    border-radius: 5px;
    width: 30%;
    height: 40px;
    margin: 0 auto;
    cursor: pointer;
  }

  .bt {
    color: #BBBABC !important;
    padding: 5px 16px;
  }
  .img_size {
    width: 340px;
    height: 500px;
    border-radius: 5px;
  }
  .img_container {
    padding: 3px;
  }
  .item_bouqet {
    margin: 0 auto;
  }
  .item_bouqet:nth-child(2) {
    margin-left: 30px;
    margin-right: 30px;
  }
  .h-text {
    text-align: center;
    margin: 0 auto;
    font-family: 'Pacifico';
    font-size: 32px;
    line-height: 140%;
    color: #502D5C;
    width: 100%;
  }
  .cat-h {
    font-family: 'Pacifico';
    font-size: 24px;
    line-height: 140%;
    color: #502D5C;
    text-align: center;
    margin: 0 auto;
    margin-bottom: 20px;
  }
    @media screen and (max-width: 1227.98px) 
    {
      .img_size {
        width: 300px;
        height: 400px;
      }
      .bt {
        padding: 5px 10px;
      }
    }
    @media screen and (max-width: 1050.98px) 
    {
      .item_container {
        flex-wrap: wrap;
      }
      .item_bouqet:nth-child(2) {
        margin: 0 auto;
      }
    }
    @media screen and (max-width: 767.98px) 
    {
      .item_bouqet:nth-child(2) {
        margin: 0 auto;
      }
    }
    @media screen and (max-width: 529.98px) 
    {
      .item_container {
        flex-direction: column;
      }
    }
</style>