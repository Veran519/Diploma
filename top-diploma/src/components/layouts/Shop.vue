<!-- Блок информации с инофрмацией о магазине, название, "слоган" КУПИТЬ :) -->
<template>
    <section class="d-flex mb-5 justify-content-between shop_info">
        <div class="col-lg-8 col-md-6 col-sm-12 mb-5">
            <h1 class="main_heading">Цветочный бутик “Элен”</h1>
            <p class="text-p">Создадим авторский букет с особым смыслом, чтобы вы поразили своих близких.</p>
            <form action="" class="catBtn">
                <div class="btCat" @click="this.$router.push('/Products')">Перейти в каталог</div>
            </form>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-8 mb-5 imgFace">
            <img class="f-site" src="../../assets/images/siteFace.webp" alt="Лицо сайта">
        </div>
        <form action="" class="catBtnHidden">
                <div class="btCatHidden" @click="this.$router.push('/Products')">Перейти в каталог</div>
        </form>
    </section>
</template>

<style>
    .main_heading {
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
    .catBtnHidden {
        display: hidden;
    }
    .btCatHidden {
        display: none;
    }
    @media screen and (max-width: 991.98px) 
    {
        .main_heading {
            font-size: 64px;
        }
        .text-p {
            font-size: 16px;
        }
    }
    @media screen and (max-width: 835px) 
    {
        .main_heading {
            font-size: 62px;
        }
        .text-p {
            font-size: 14px;
        }
        .catBtn {
            width: 220px;
        }
        .btCat {
            font-size: 18px;
            margin: 0 auto;
            padding: 10px 0 10px 0;
        }
    }
    @media screen and (max-width: 812px) 
    {
        .main_heading {
            font-size: 52px;
        }
        .catBtn {
            width: 185px;
        }
        .btCat {
            font-size: 16px;
            margin: 0 auto;
            padding: 12px 0 12px 0;
        }
    }
    @media screen and (max-width: 767.98px) 
    {
        .main_heading {
            font-size: 58px;
            text-align: center;
            margin-bottom: 30px;
        }
        .text-p {
            font-size: 16px;
            text-align: center;
            margin: 0 auto;
        }
        .catBtn {
            display: none;
        }
        .btCat {
            font-size: 16px;
            margin: 0 auto;
            padding: 12px 0 12px 0;
        }
        .imgFace {
            margin: 0 auto;
        }
        .catBtnHidden {
            display: block;
            border-radius: 5px;
            cursor: pointer;
            width: 240px;
            height: 48px;
            background-color: #502D5C;
            margin: 0 auto;
        }
        .btCatHidden {
            display: block;
            color: #BBBABC !important;
            text-align: center;
            font-family: 'Noto Serif';
            font-size: 20px;
            padding: 8px 0;
            width: 100%;
        }
    }
    @media screen and (max-width: 529.98px) 
    {
        .shop_info {
            display: block !important;
        }
    }
    @media screen and (max-width: 444.98px) 
    {
        .text-p {
            font-size: 14px;
        }
    }
    @media screen and (max-width: 392.98px) 
    {
        .text-p {
            font-size: 12px;
        }
        .main_heading {
            font-size: 48px;
        }
        .catBtnHidden {
            width: 180px;
            
        }
        .btCatHidden {
            font-size: 16px;
            padding: 12px 0 12px 0;
        }
    }
</style>