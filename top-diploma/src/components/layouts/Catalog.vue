<template>
    <section>
            <div class="mb-5">
              <h2 class="h-text mb-5">Каталог</h2>
              <div class="d-flex justify-content-between">
                  <div class="item_bouqet me-5">
                      <h3>Моно букеты</h3>
                      <img src="" alt="Моно букеты">
                      <form action="" class="calltoact buyC">
                          <button class="btn">Купить</button>
                      </form>
                  </div>
                  <div class="item_bouqet me-5">
                      <h3>Букеты ассорти</h3>
                      <img src="" alt="Букеты ассорти">
                      <form action="" class="calltoact buyC">
                          <button class="btn">Купить</button>
                      </form>
                  </div>
                  <div class="item_bouqet">
                      <h3>Композиции</h3>
                      <img src="" alt="Композиции">
                      <form action="" class="calltoact buyC">
                          <button class="btn">Купить</button>
                      </form>
                  </div>
              </div>
          </div>
        </section>    
</template>
  
<script>
  import { getCategories } from "../../services/ApiMethods";

    export default {
      name: 'Catalog',
      components: {
        
      },
      data(){
        return {
            work: {},
            posts: [],
        }
      },
      async created(){
        await this.initWork();
        await this.initPosts();
      },
      methods:{
        async initWork() {
            try {
              const res = await getWorks();
                const work = res.data.works.map((work) => {
                    return {
                        title: work.title,
                        description: work.description,
                        image_preview: "https://techcrunch.com/wp-content/uploads/2017/09/pinterest-app-icon-ios.jpg"
                    }
                })
                
                this.work = work;
            } catch (error) {
              this.showToast("Работы не были получены!","error");
            }   
        },
      }
    }
</script>

<style>

</style>