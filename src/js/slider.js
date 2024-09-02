import Swiper from 'swiper'
import { Navigation } from 'swiper/modules'
import 'swiper/css';
import 'swiper/css/navigation';

document.addEventListener('DOMContentLoaded', function(){
    if(document.querySelector('.slider')){
        const opciones = {
            slidesPerView: 1, //Slides Por Vista
            spaceBetween: 15,  //Espaciado Entre Cada Slide PX
            freeMode: true, //Soluciona Errores En Los Slides
            navigation: {
                nextEl: '.swiper-button-next', //Elemento Que Tendrá El Botón De Siguiente, Definido En El HTML
                prevEl: '.swiper-button-prev' //Elemento Que Tendrá El Botón De Anterior, Definido En El HTML
            },
            breakpoints: { //Es Una Especie De Media Querys
                760:{
                    slidesPerView: 2
                },
                1024:{
                    slidesPerView: 3
                },
                1200:{
                    slidesPerView: 4
                }
            }
        }
        Swiper.use([Navigation])
        new Swiper('.slider', opciones)
    }
});