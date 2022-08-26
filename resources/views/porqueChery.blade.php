<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/header.css">
    <link rel="stylesheet" href="./assets/css/porque.css">
    <title>Chery Bolivia</title>
</head>
<body>
    @include('layouts.components.header')
    <main>
        <section class="title">
            <div class="card">
                <div class="img"><img src="assets/img/porqueChery/autos.jpg" alt=""></div>
                <div class="content">
                    <h4>Chery Automobile Corporation Ltd., fue creada en
                        1997 en la ciudad de Wuhu, perteneciente a la provincia de
                        Anhui, de la República Popular de China. Dos años después
                        el primer vehículo salió de la línea de producción.
                    </h4>
                    <p>En 2006 las ventas incrementaron en un 62%, con al menos 305.200 unidades, aumentando la participación en un
                        7% y se posiciona en el cuarto lugar en el mercado Chino de vehículos de pasajeros.
                    </p>
                </div>
            </div>
            <div class="text">
                <h1>POR QUÉ <br><span>CHERY</span></h1>
            </div>
        </section>
        <section class="quienes">
            <div class="title-primary">
                <h2>QUIÉNES <span>SOMOS</span></h2>
                <h6>(NUESTRA HISTORIA)</h6>
            </div>
            <div class="timeline">
                <div class="date">
                    <div class="year"><p>1997</p></div>
                    <div class="pointer">
                        <div class="point"></div><div class="line"></div></div>
                    <div class="description">
                        <p>Chery Automobile Corporation Ltd., fue creada en 1997 en la ciudad de Wuhu, de la República Popular de China.  </p>
                    </div>
                </div>
                <div class="date">
                    <div class="year"><p>2002</p></div>
                    <div class="pointer"><div class="point"></div><div class="line"></div></div>
                    <div class="description">
                        <p>Chery Automobile Corporation Ltd., se consolida dentro de las diez mejores marcas del mercado Chino, superando las 50.000 unidades. </p>
                    </div>
                </div>
                <div class="date">
                    <div class="year"><p>2006</p></div>
                    <div class="pointer"><div class="point"></div><div class="line"></div></div>
                    <div class="description">
                        <p>CHERY presente en 90 países a nivel mundial. </p>
                    </div>
                </div>
                {{-- <div class="date">
                    <div class="year"><p>2007</p></div>
                    <div class="pointer"><div class="point"></div><div class="line"></div></div>
                    <div class="description">
                        <p>En julio de 2007 se firmó una alianza estratégica con el grupo Chyster, también para provisión de motores ACTECO, permitiéndole ingresar a los mercados en donde participa este reconocido grupo estadounidense. </p>
                    </div>
                </div> --}}
                <div class="date">
                    <div class="year"><p>2011</p></div>
                    <div class="pointer"><div class="point"></div><div class="line"></div></div>
                    <div class="description">
                        <p>La marca CHERY llega a Bolivia con una excelente aceptación del mercado. </p>
                    </div>
                </div>
                <div class="date">
                    <div class="year"><p>2013</p></div>
                    <div class="pointer"><div class="point"></div><div class="line"></div></div>
                    <div class="description">
                        <p>CHERY Perú ganó el premio de “Estándar de excelencia automotriz”.</p>
                    </div>
                </div>
                <div class="date">
                    <div class="year"><p>2015</p></div>
                    <div class="pointer"><div class="point"></div><div class="line"></div></div>
                    <div class="description">
                        <p>El modelo Arrizo 7 fue nominado en Chile como “Mejor auto del año”</p>
                    </div>
                </div>
                <div class="date">
                    <div class="year"><p>2016</p></div>
                    <div class="pointer"><div class="point"></div><div class="line"></div></div>
                    <div class="description">
                        <p>CHERY ganó en “BEST OVERSEAS IMAGE” en la República Popular de China.</p>
                    </div>
                </div>
                <div class="date">
                    <div class="year"><p>2017</p></div>
                    <div class="pointer"><div class="point"></div><div class="line"></div></div>
                    <div class="description">
                        <p>CHERY ganó la medalla de oro en el “International Quality Olympiad” en la categoría de vehículos chinos.</p>
                    </div>
                </div>
                <div class="date">
                    <div class="year"><p>2018</p></div>
                    <div class="pointer"><div class="point"></div><div class="line"></div></div>
                    <div class="description">
                        <p>CHERY gana en Rusia por 3ra vez consecutiva como “La marca de vehículo chino más popular”</p>
                    </div>
                </div>
                <div class="date">
                    <div class="year"><p>Actualidad</p></div>
                    <div class="pointer large"><div class="point"></div><div class="line"></div></div>
                    <div class="description">
                        <p>CHERY AUTOMOBILE CORPORATION LTD., considerada la mayor exportadora de vehículos chinos a nivel mundial. </p>
                    </div>
                </div>
            </div>

        </section>
    </main>
    @include('layouts.components.footer')
    <script src="https://kit.fontawesome.com/230beef275.js" crossorigin="anonymous"></script>

    <div class="float-button"><a href="https://wa.link/xh0uqv"><img src="/assets/img/float-wpp.png" alt=""></a></div>
</body>
</html>
