<template>
    <section class="d-flex mb-5 justify-content-between mt-5">
        <form class="d-flex flex-column formSub" action="post">
            <input class="order_form mb-3" type="text" v-model="this.myForm.name" placeholder="Имя">
            <input class="order_form mb-3" type="phone" v-model="this.myForm.phone" placeholder="Номер телефона">   
            <textarea class="order_form mb-3" name="" id="" v-model="this.myForm.adress" cols="30" rows="10"  placeholder="Адрес доставки"></textarea>
            <div type="submit" @click="updateData" class="btn btn_save">Сохранить</div>
        </form>
    </section>
</template>

<script>
    import axios from 'axios';
    import { baseUrl } from '../../services/config';

    export default {
      name: 'ProfileInfo',
      components: {
        
      },
      initForm: {
        name: '',
        phone: null,
        adress: '',
      },
      data(){
        return {
            name: '',
            phone: null,
            adress: '',
            form: {},
            myForm:[],
        }
      },
      watch: {
        form: {
            handler() {
                this.updateStorage();
            },
            deep: true
        }
      },
      created() {
        let storedForm = this.getStorage();
        this.form = { ...this.$options.initForm, ...storedForm };
        if(localStorage.getItem('token')) {
            axios.defaults.headers.common['Authorization'] = 'Bearer '+ localStorage.getItem('token');
            axios.get(baseUrl + 'api/user').then(response => {
                    console.log(response)
                    /*this.name = response.data.name;
                    this.phone = response.data.phone;
                    this.adress = response.data.adress;*/
                    let formData = response.data;
                    this.myForm = formData;
                    console.log(formData);
                    return formData;
                }) 
          }
      },
      methods: {
            updateData() {
                axios.post(baseUrl + 'api/updateUsersData', {
                    name: this.name,
                    phone: this.phone,
                    adress: this.adress,
                }).then(response => {
                    this.form = { ...this.$options.initForm }
                })
            },
            getStorage() {
                return JSON.parse(localStorage.getItem('Myform'))
            },
            setStorage(val) {
                localStorage.setItem('Myform', JSON.stringify(val))
            },
            updateStorage() {
                let storedForm = this.getStorage();
                if (!storedForm) storedForm = {}

                storedForm = JSON.parse(JSON.stringify(this.form));
                this.setStorage(storedForm);
            }
      }
    }
</script>

<style>
    .btn_save {
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
        width: 25vh;
    }
    .formSub {
        margin: 0 auto;
    }
</style>