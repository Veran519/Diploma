<template>
    <section class="d-flex mb-5 justify-content-between">
        <div class="col-lg-8 col-md-6 col-sm-4 mb-5">
            <h1>Цветочный бутик “Элен”</h1>
            <p class="text-p">Создадим авторский букет с особым смыслом, чтобы вы поразили своих близких.</p>
            <form action="" class="catBtn">
                <div class="btCat" @click="this.$router.push('/Products')">Перейти в каталог</div>
            </form>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-2 mb-5">
            <img class="f-site" src="../../assets/images/siteFace.webp" alt="Лицо сайта">
        </div>
    </section>
</template>

<style>
    main h1 {
        font-family: 'Pacifico';
        font-size: 72px;
        line-height: 145%;
        letter-spacing: 2px;
        color: #502D5C;
    }
    .text-p {
        font-family: 'Noto Serif';
        font-size: 20px;
        line-height: 140%;
        color: #502D5C;
        width: 70%;
    }
    .catBtn {
        border-radius: 5px;
        cursor: pointer;
        width: 240px;
        height: 48px;
        background-color: #502D5C;
    }
    .btCat {
        color: #BBBABC !important;
        text-align: center;
        font-family: 'Noto Serif';
        font-size: 20px;
        padding: 8px 0;
        width: 100%;
    }
</style>