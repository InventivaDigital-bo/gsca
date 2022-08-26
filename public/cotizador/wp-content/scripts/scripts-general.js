  jQuery(document).ready(function() {
      jQuery('.owl-carousel').owlCarousel({
          center: false,
          margin: 10,
          loop: false,
          autoplay: false,
          nav: true,
          autoplayHoverPause: false,

          responsive: {
              0: {
                  items: 1,
                  autoplay: false
              },
              600: {
                  items: 2,
                  autoplay: false
              },
              1000: {
                  items: 3
              }
          }
      });
  });


  //mostrar - ocultar contenido

  jQuery(document).ready(function() {

      jQuery("#automoviles-button").on("click", function() {
          //mostrar/ocultar div
          jQuery('#automoviles').css('display', 'block');
          jQuery('#vagonetas').css('display', 'none');
          jQuery('#utilitarios').css('display', 'none');

          //dar estilo al botton de selección
          jQuery("#automoviles-button").addClass("marcado");
          jQuery("#vagonetas-button").removeClass("marcado");
          jQuery("#utilitarios-button").removeClass("marcado");
      });

      jQuery("#vagonetas-button").on("click", function() {
          //mostrar/ocultar div
          jQuery('#vagonetas').css('display', 'block');
          jQuery('#automoviles').css('display', 'none');
          jQuery('#utilitarios').css('display', 'none')

          //dar estilo al botton de selección
          jQuery("#automoviles-button").removeClass("marcado");
          jQuery("#vagonetas-button").addClass("marcado");
          jQuery("#utilitarios-button").removeClass("marcado");
      });

      jQuery("#utilitarios-button").on("click", function() {
          //mostrar/ocultar div
          jQuery('#utilitarios').css('display', 'block');
          jQuery('#automoviles').css('display', 'none');
          jQuery('#vagonetas').css('display', 'none');

          //dar estilo al botton de selección
          jQuery("#automoviles-button").removeClass("marcado");
          jQuery("#vagonetas-button").removeClass("marcado");
          jQuery("#utilitarios-button").addClass("marcado");
      });

      jQuery(".boton-general").on("click", function() {
          jQuery('#date').show();
          jQuery('#date-brands').hide();
          jQuery('.button-date').show();
          jQuery('.button-date-brands').hide();
      });

      //Div con misma altura
      //var maxHeight = 0;
      //jQuery('.card-content').each(function() {
          //if (jQuery(this).height() > maxHeight) {
             // maxHeight = jQuery(this).height();
          //}
      //});
      //jQuery('.card-content').height(maxHeight);

      //Div con mismo ancho
      var maxWidth = 0;
      jQuery('.wBut').each(function() {
          if (jQuery(this).width() > maxWidth) {
              maxWidth = jQuery(this).width();
          }
      })
      jQuery('.wBut').width(maxWidth);
  });


  //div misma altura