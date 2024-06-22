<!-- Блок регистрации новых пользователей -->
<template>
    <section class="container col-lg-12 col-md-8 col-sm-4">
        <form class="registr" action="post">
            <div class="mb-1 reg_item">
                <label for="name" class="form-label">Укажите Ваше имя</label>
                <input type="text" v-model="name" class="form-control reg_form" id="name">
                <span class="error" v-for="items in errors.name" v-if="errors.name">{{ items }}</span>
            </div>
            <div class="mb-1 reg_item">
                <label for="exampleInputEmail1" class="form-label">Укажите Ваш адрес электронной почты</label>
                <input type="email" v-model="email" class="form-control reg_form" id="exampleInputEmail1" aria-describedby="emailHelp">
                <span class="error" v-for="items in errors.email" v-if="errors.email">{{ items }}</span>
            </div>
            <div class="mb-1 reg_item">
                <label for="exampleInputPassword1" class="form-label">Придумайте пароль</label>
                <input type="password" v-model="password" class="form-control reg_form" id="exampleInputPassword1">
                <span class="error" v-for="items in errors.password" v-if="errors.password">{{ items }}</span>
            </div>
            <div class="mb-1 reg_item">
                <label for="exampleInputPassword2" class="form-label">Подвердите пароль</label>
                <input type="password" v-model="password_confirm" class="form-control reg_form" id="exampleInputPassword2">
                <span class="error" v-for="items in errors.password_confirm" v-if="errors.password_confirm">{{ items }}</span>
            </div>
            <div type="submit" @click="registr" class="btn_col mb-5">Зарегистрироваться</div>
            <div class="or mb-5">
                <span>ИЛИ</span>
            </div>       
            <div class="btn_auth mb-5" @click="this.$router.push('/login')">Войти</div>
        </form>
    </section>
</template>

<script>
    import axios from 'axios';  // импорт аксиос
    import { baseUrl } from '../services/config';   // Импорт api
    import { toast } from 'vue3-toastify';

    export default {
      name: 'Registration',
      components: {
        
      },
      data(){
        return {
           name: null,
           email: null,
           password: null,              // Возвращаем данные с формы регистрации, а также ошибки при ее заполненнии
           password_confirm: null,
           errors: {
                name:'',
                email:'',
                password:'',
                password_confirm:''
           } 
        }
      },
      async created() {
        
      },
      methods: {
            registr() {     // Метод регистрации новых пользователей
                axios.get(baseUrl + 'sanctum/csrf-cookie').then(response => {   // Делаем запрос  на csrf куки, затем заполняем форму и полученные данные отправляем на сервер
                    axios.post(baseUrl + 'api/registration', {
                        name: this.name,
                        email: this.email,
                        password: this.password,
                        password_confirmation: this.password_confirm
                    }).then(response => {
                        toast.success('Пользователь был успешно зарегистрирован!');
                    }).catch(error => {     // Выводим ошибки, при их наличии в результате заполнения формы
                    if(error.response.status === 422) {
                        console.log(error.response.data.errors);
                        this.errors.name =  error.response.data.errors.name;
                        this.errors.email = error.response.data.errors.email;
                        this.errors.password = error.response.data.errors.password;
                        this.errors.password_confirm = error.response.data.errors.password_confirmation;
            }
            toast.error('Одно или несколько полей были заполнены неверно!');
                }) 
            })
        }
      }
    }
</script>

<style>
    .reg_item {
        margin: 0 auto;
    }
    .btn_col {
        margin: 0 auto;
        text-align: center;
        font-family: 'Noto Serif';
        font-size: 20px;
        line-height: 140%;
        color: #BBBABC;
        text-align: center;
        background-color: #502D5C;
        height: 40px;
        padding-top: 5px;
        border-radius: 5px;
        cursor: pointer;
        width: 35%;
    }
    .reg_form {
        background-color: #9D6796;
        border-radius: 5px;
        border: 2px solid black;
        width: 100%;
        margin: 0 auto;
    }
    .form-label {
        font-family: 'Noto Serif';
        font-size: 16px;
        line-height: 140%;
        color: #502D5C;
        word-wrap: break-word;
    }
    .btn_auth {
        margin: 0 auto;
        text-align: center;
        font-family: 'Noto Serif';
        font-size: 20px;
        line-height: 140%;
        color: #BBBABC;
        text-align: center;
        background-color: #502D5C;
        height: 40px;
        padding-top: 5px;
        border-radius: 5px;
        cursor: pointer;
        width: 15%;
    }
    .or {
        margin: 0 auto;
        text-align: center;
        font-family: 'Noto Serif';
        font-size: 20px;
        line-height: 140%;
        color: #502D5C;
        word-wrap: break-word;
    }
    .registr {
        width: 60%;
        margin: 0 auto;
    }
    @media screen and (max-width: 1624.98px) 
    {
        .registr {
            width: 80%;
        }
    }
    @media screen and (max-width: 1199.98px) 
    {
        .registr {
            width: 65%;
        }
    }
    @media screen and (max-width: 1050.98px) 
    {
        .registr {
            width: 75%;
        }
    }
    @media screen and (max-width: 992.98px) 
    {
        .registr {
            width: 80%;
        }
    }
    @media screen and (max-width: 810.98px) 
    {
        .registr {
            width: 90%;
        }
    }
    @media screen and (max-width: 767.98px) 
    {
        .reg_item {
            width: 50%;
        }
        .registr {
            width: 100%;
        }
    }
    @media screen and (max-width: 675.98px) 
    {
        .reg_item {
            width: 60%;
        }
        .btn_col {
            width: 40%;
        }
    }
    @media screen and (max-width: 579.98px) 
    {
        .reg_item {
            width: 80%;
        }
        .btn_col {
            width: 45%;
        }
        .btn_auth {
            width: 20%;
        }
    }
    @media screen and (max-width: 519.98px) 
    {
        .reg_item {
            width: 80%;
        }
        .btn_col {
            width: 50%;
        }
    }
    @media screen and (max-width: 460.98px) 
    {
        .reg_item {
            width: 90%;
        }
        .btn_col {
            width: 60%;
        }
    }
    @media screen and (max-width: 390.98px) 
    {
        .reg_item {
            width: 100%;
        }
        .btn_col {
            width: 70%;
        }
        .btn_auth {
            width: 30%;
        }
    }
</style>