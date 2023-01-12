<template>
    <section class="callme">
            <h2 class="h-text mb-5">Нужна консультация по подбору букета или индивидуальная подборка?
                  Оформим букет специально для вас!</h2>
                  <div class="row p-5">
                    <div class="d-flex justify-content-between">
                        <div class="mb-5 d-flex flex-column s-form">
                            <p class="callback_text">Оставьте заявку и получите консультацию нашего специалиста в течение 10 минут</p>
                            <form type="submit" method="post" class="d-flex flex-column c-form">
                                <input type="text" v-model="name" class="mb-3 i-form" placeholder="Имя">
                                <input type="phone" v-model="phone" class="mb-3 i-form" placeholder="Телефон">
                                <div @click="sendForm" class="b-call pt-1">Оставить заявку</div>
                            </form>
                        </div>
                        <div class="img-f mb-5">
                            <img  class="callback_form" src="../../assets/images/siteFace3.webp" alt="Лицо сайта">
                        </div>
                    </div>
                </div>                                          
        </section>
</template>

<script>
    import { askCallBack } from '../../services/ApiMethods';

    export default {
    name: 'CallBack',
    components: {
        
    },
    data(){
        return {
            name: '',
            phone: '',
        }
      },
      methods:{
        async sendForm() {   
        try { 
          const callBackreq = await askCallBack({
            name:this.name,
            phone:this.phone
          });
          alert('Ваша заявка отправлена!');
        } catch (error) {
              alert("Ошибка отправки данных для обратного звонка!", "error");
            }  
        },
      },
      
  }
</script>

<style>
    .h-text {
        text-align: center;
        font-family: 'Pacifico';
        font-size: 32px;
        line-height: 140%;
        color: #502D5C;
    }
    .callback_text {
        font-family: 'Noto Serif';
        font-size: 20px;
        line-height: 140%;
        color: #502D5C;
        width: 50%;
    }
    .c-form {
        width: 40%;
    }
    .i-form {
        background-color: #9D6796;
        border-radius: 5px;
        border: 2px solid black;
    }
    input::placeholder {
        font-family: 'Noto Serif';
        font-size: 16px;
        line-height: 140%;
        color: #502D5C;
        width: 50%;
    }
    .img-f {
        width: 50vh;
    }
    .b-call {
        text-align: center;
        color: #BBBABC;
        font-family: 'Noto Serif';
        font-size: 16px;
        line-height: 140%;
    }
    form div {
        background-color:#502D5C;
        border-radius: 5px;
        width: 40%;
        height: 30px;
        margin: 0 auto;
    }
    
    .callme {
        width: 100%;
    }
    @media screen and (min-width: 1200px) and (max-width: 1920px) {
        .h-text {
        margin: 0 auto;
    }
        .s-form {
            margin: 0 auto;
        }
        .callback_form {
        margin: 0 auto;
        width: 100%;
    }
    form div {
        width: 50%;
    }
    }
    @media screen and (min-width: 992px) and (max-width: 1199.98px) {
        .h-text {
        margin: 0 auto;
        font-size: 28px !important;
    }
        .s-form {
            margin: 0 auto;
        }
        .callback_form {
        margin: 0 auto;
        width: 100%;
    }
    form div {
        width: 60%;
    }
    }
    @media screen and (min-width: 768px) and (max-width: 991.98px) {
        .h-text {
        margin: 0 auto;
        font-size: 24px !important;
    }
        .s-form {
            margin: 0 auto;
        }
        .callback_form {
        margin: 0 auto;
        width: 100%;
    }
    form div {
        width: 60%;
    }
    .callback_text {
        font-size: 16px;
        width: 90%;
    }
    .c-form {
        width: 90%;
    }
    }

    @media screen and (min-width: 598px) and (max-width: 767.98px) {
        .h-text {
        margin: 0 auto;
        font-size: 22px !important;
    }
        .s-form {
            margin: 0 auto;
        }
        .callback_form {
        margin: 0 auto;
        width: 100%;
    }
    form div {
        width: 80%;
    }
    .callback_text {
        font-size: 16px;
        width: 100%;
        text-align: center;
    }
    .c-form {
        width: 100%;
        font-size: 14px;
    }
    .d-flex {
        flex-direction: column;
        width: 80%;
        margin: 0 auto;
    }
    }

    @media screen and (min-width: 530px) and (max-width: 597.98px) {
        .h-text {
        margin: 0 auto;
        font-size: 18px !important;
        padding: 5px;
    }
        .s-form {
            margin: 0 auto;
        }
        .callback_form {
        margin: 0 auto;
        width: 90%;
    }
    form div {
        width: 80%;
    }
    .callback_text {
        font-size: 16px;
        width: 100%;
        text-align: center;
    }
    .c-form {
        width: 100%;
        font-size: 14px;
    }
    .d-flex {
        flex-direction: column;
        width: 80%;
        margin: 0 auto;
    }
    }
</style>