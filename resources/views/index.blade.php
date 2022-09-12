<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/index.css">
    <link rel="stylesheet" href="./assets/css/header.css">
    <title>Chery Bolivia</title>
    <style>

    </style>
</head>
<body>
@include('layouts.components.header')
<!-- slider -->
<main>
    <section class="has-dflex-center">
        <div class="lx-container-80">
            <div class="lx-row">
                <div class="lx-card carousel-container">

                    <a href="{{route('modelo', 'tiggo-2-pro')}}" class="item fade">
                        <div class="image"><img src="{{asset('/assets/img/banner/1.png')}}" /></div>
                    </a>

                    <a href="{{route('modelo', 'tiggo-2-premium')}}" class="item fade">
                        <div class="image"><img src="{{asset('/assets/img/banner/2.png')}}" /></div>
                    </a>

                    <a href="{{route('modelo', 'new-tiggo-4-15')}}" class="item fade">
                        <div class="image"><img src="{{asset('/assets/img/banner/3.png')}}" /></div>
                    </a>

                    <a href="{{route('modelo', 'new-tiggo-4-20')}}" class="item fade">
                        <div class="image"><img src="{{asset('assets/img/banner/4.png')}}" /></div>
                    </a>

                    <a href="{{route('modelo', 'tiggo-7-pro')}}" class="item fade">
                        <div class="image"><img src="{{asset('/assets/img/banner/5.png')}}" /></div>
                    </a>

                    <a class="prev has-dflex-center"><i class="fas fa-angle-left"></i></a><a class="next has-dflex-center"><i class="fas fa-angle-right"></i></a>
                </div>
            </div>
        </div>
    </section>
</main>
<!-- <section class="slider">
    <img src="assets/img/banner/baner_1.jpg" alt="">
</section> -->
<section class="video">
    <div class="image"><img src="{{asset('assets/img/auto.jpg')}}" alt=""></div>
    <div class="content">
        <h2>Quiénes somos</h2>
        <p style="line-height : 25px;">GS Consorcio Automotriz SR, la cual ha logrado en poco tiempo expandir
            la marca a varios departamentos del país por nuestros
            diseños, el mejor precio del mercado, la excelente atención
            al cliente y servicios de taller especializado con stock amplio
            de repuestos originales, continuaremos expandiéndonos
            para llegar a cada rincón de Bolivia.</p>
    </div>
</section>
@include('layouts.components.footer')

<div class="float-button"><a href="https://wa.link/xh0uqv"><img src="/assets/img/float-wpp.png" alt=""></a></div>
<script src="https://kit.fontawesome.com/230beef275.js" crossorigin="anonymous"></script>
<script>
    "use strict";

    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll(".carousel-container").forEach(carousel => {
            insertNumbers(carousel);
            carousel.querySelector(".prev").addEventListener("click", e => {
                minusItem(carousel);
            });
            carousel.querySelector(".next").addEventListener("click", () => {
                plusItem(carousel);
            });
            insertDots(carousel);
            carousel.querySelectorAll(".dot").forEach(dot => {
                dot.addEventListener("click", e => {
                    let item = Array.prototype.indexOf.call(e.target.parentNode.children, e.target);
                    showItems(carousel, item);
                });
            });
            showItems(carousel, 0);
        });
    });

    function insertNumbers(carousel) {
        const length = carousel.querySelectorAll(".item").length;

        for (let i = 0; i < length; i++) {
            const nmbr = document.createElement("div");
            nmbr.classList.add("numbertext");
            nmbr.innerText = i + 1 + " / " + length;
            carousel.querySelectorAll(".item")[i].append(nmbr);
        }
    }

    function insertDots(carousel) {
        const dots = document.createElement("div");
        dots.classList.add("dots");
        carousel.append(dots);
        carousel.querySelectorAll(".item").forEach(elem => {
            const dot = document.createElement("div");
            dot.classList.add("dot");
            carousel.querySelector(".dots").append(dot);
        });
    }

    function plusItem(carousel) {
        let item = currentItem(carousel);
        carousel.querySelectorAll(".item")[item].nextElementSibling.classList.contains("item") ? showItems(carousel, item + 1) : showItems(carousel, 0);
    }

    function minusItem(carousel) {
        let item = currentItem(carousel);
        carousel.querySelectorAll(".item")[item].previousElementSibling != null ? showItems(carousel, item - 1) : showItems(carousel, carousel.querySelectorAll(".item").length - 1);
    }

    function currentItem(carousel) {
        return [...carousel.querySelectorAll(".item")].findIndex(item => item.style.display == "block");
    }

    function showItems(carousel, item) {
        if (carousel.querySelectorAll(".item")[currentItem(carousel)] != undefined) carousel.querySelectorAll(".item")[currentItem(carousel)].style.display = "none";
        carousel.querySelectorAll(".item")[item].style.display = "block";
        if (carousel.querySelector(".dot.active") != null) carousel.querySelector(".dot.active").classList.remove("active");
        carousel.querySelectorAll(".dot")[item].classList.add("active");
    }

    function menuToggle(){
        let menu = document.getElementById('menu');
        menu.classList.toggle('active');
    }
    nextSlide()
    function nextSlide(){
        setTimeout(() => {
            document.getElementsByClassName("next")[0].click()
            nextSlide()
        }, 3000);
    }
</script>
</body>
</html>
