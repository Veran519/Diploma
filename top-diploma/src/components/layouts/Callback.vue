<!-- Блок обратной связи, где клиент может запросить обратный звонок, используя форму обратной связи -->
<template>
    <section class="callme">
            <h2 class="h-text mb-4">Нужна консультация по подбору букета или индивидуальная подборка?
                  Оформим букет специально для вас!</h2>
                  <div class="row p-3">
                    <div class="d-flex justify-content-between callback_f">
                        <div class="mb-5 d-flex flex-column s-form">
                            <p class="callback_text">Оставьте заявку и получите консультацию нашего специалиста в течение 10 минут</p>
                            <form type="submit" method="post" class="d-flex flex-column c-form">
                                <input type="text" v-model="name" class="i-form i-form_name" placeholder="Имя">
                                <span class="error mb-1" v-for="items in errors.name" v-if="errors.name">{{ items }}</span>
                                <input type="tel" v-model="telphone" class="i-form i-form_phone hidden" placeholder="+7 (___) ___-____">
                                <MaskInput v-model="phone" mask="+ 7 (###) ###-##-##" class="i-form i-form_phone" placeholder="+7 (___) ___-____"/>
                                <span class="error mb-1" v-for="items in errors.phone" v-if="errors.phone">{{ items }}</span>
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
    import { askCallBack } from '../../services/ApiMethods';    // Импортируем функцию, которая отправляет данные на сервер и в чат бот телеграм
    import { toast } from 'vue3-toastify';
    import { MaskInput } from 'vue-3-mask';


    export default {
    name: 'CallBack',
    components: {
        MaskInput,
    },
    data(){
        return {
            name: '',
            phone: '',    // Возвращаем пустые поля формы и ошибок
            telphone: '',
            errors: {
                name:'',
                phone:''
            }
        }
      },
      methods:{
        async sendForm() {   // Объявляем метод отправки данных на сервер и в чатбот
        try { 
          const callBackreq = await askCallBack({   // Объявляем переменную, в которую записываем заполненные данные с формы на сайте
            name:this.name,
            phone:this.telphone = this.phone.replace(/[^0-9]/g, '')
          })
         toast.success('Ваше сообщение отправлено!');
        } catch (error) {  // Если есть ошибки при заполнении, то ловим их и выводим для пользователя сообщения об ошибках
            if(error.response.status === 422) {
                this.errors.name =  error.response.data.errors.name;
                this.errors.phone = error.response.data.errors.phone;
            }
            toast.error('Одно или несколько полей были заполнены неверно!');
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
    .i-form {
        background-color: #9D6796;
        border-radius: 5px;
        border: 2px solid black;
    }
    .i-form_name {
        margin-bottom: 7px;
    }
    .i-form_phone {
        margin-bottom: 7px;
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
        background-color:#502D5C;
        border-radius: 5px;
        width: 50%;
        height: 30px;
        margin: 0 auto;
    }
    /*form div {
        background-color:#502D5C;
        border-radius: 5px;
        width: 40%;
        height: 30px;
        margin: 0 auto;
    }*/
    .error {
        margin: 0;
        padding: 0;
        font-family: 'Noto Serif';
        font-size: 16px;
        line-height: 140%;
        color: #c70c25;
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
    .c-form {
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
    .c-form {
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
        width: 80%;
    }
    .c-form {
        width: 65%;
    }
    }

    @media screen and (min-width: 597.98px) and (max-width: 767.98px) {
        .h-text {
        margin: 0 auto;
        font-size: 22px !important;
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
    }
    .b-call {
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
        width: 80%;
    }
    form div {
        width: 70%;
    }
    .callback_text {
        font-size: 14px;
        width: 100%;
        text-align: center;
    }
    .c-form {
        width: 100%;
        height: 105px;
    }
    .d-flex {
        flex-direction: column;
        width: 80%;
        margin: 0 auto;
    }
    .b-call {
        font-size: 12px;
        height: 25%;
        padding-bottom: 10px;
    }
    .error {
        font-size: 12px;
        margin-top: 0 !important;
    }
    input::placeholder {
        font-size: 14px;
    }
    }
    @media screen and (max-width: 529.98px) 
    {
      .callback_f {
        flex-direction: column;
      }
      .callback_form {
        width: 100%;
      }
      .c-form {
        width: 70%;
        margin: 0 auto;
    }
    .callback_text {
        font-size: 14px;
        width: 100%;
        text-align: center;
    }
    .h-text {
        margin: 0 auto;
        font-size: 18px !important; 
    }
    .img-f {
        margin: 0 auto;
    }
    .error {
        font-size: 14px;
    }
    input::placeholder {
        font-size: 14px;
    }
    .b-call {
        font-size: 14px;
    }
    }
    @media screen and (max-width: 455.98px) 
    {
      .c-form {
        width: 90%;
        margin: 0 auto;
    }
    }
    @media screen and (max-width: 423.98px) 
    {
      .callback_form {
        width: 100%;
      }
      .c-form {
        width: 100%;
    }
    }
    @media screen and (max-width: 388.98px) 
    {
      .c-form {
        width: 100%;
    }
    .h-text {
        font-size: 16px !important; 
    }
    .callback_text {
        font-size: 14px;
    }
    .b-call {
        font-size: 14px;
    }
    }
</style>