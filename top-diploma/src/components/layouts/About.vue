<!-- Блок информации О нас, в котором содержится краткая информация о магазине и его фишках -->
<template>  
    <section class="d-flex mb-5 justify-content-between about_us">
        <div class="col-lg-8 col-md-10 col-sm-12 me-3 img_about">
            <img class="about" src="../../assets/images/siteFace2.webp" alt="Лицо сайта">
        </div>
        <div class="col-lg-3 col-md-10 col-sm-12 mb-5 me-5">
            <h2 class="about_heading">О нас</h2>
            <p class="text-about">
                Наша история началась в 2019 году. Мы хотели построить свое дело на том чтобы дать людям возможность получать цветы исключительного качества, достойный сервис, качественную флористику за разумные деньги.
                <br>
                <br>
                Мы закупаем качественные сорта цветов напрямую с сертефицированных плантаций Голандии Эквадора и России. Это позволяет гаррантировать нам свежесть каждого букета.
                <br>
                <br>
                Для наших флористов создание бкетов это искусство, и как любой творц, мы вкладываем в наше дело душу.
                <br>
                <br>
                Обращаясь к нам вы можете быть уверены в том, что сможете порадовать своих блиских чедесным настроением и теплом.
            </p>
        </div>
     </section>
</template>

<style>
    .about {
        width: 100%;
        transform: scale(-1, 1);
        margin-top: 10px;
        height: 100%;
    }
    .text-about {
        font-family: 'Noto Serif';
        font-size: 18px;
        line-height: 140%;
        color: #502D5C;
    }
    @media screen and (max-width: 991.98px) 
    {
        .about_us {
            flex-direction: column;
            align-items: center;
        }
        .about_heading {
            text-align: center;
        }
        .img_about {
            margin-bottom: 50px;
        }
    }
    @media screen and (max-width: 527.98px) 
    {
      .text-about {
        font-size: 14px;
      }
    }
</style>