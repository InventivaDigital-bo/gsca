jQuery(document).ready(function(){jQuery('.owl-carousel').owlCarousel({center:false,margin:10,loop:false,autoplay:false,nav:true,autoplayHoverPause:false,responsive:{0:{items:1,autoplay:false},600:{items:2,autoplay:false},1000:{items:3}}});});jQuery(document).ready(function(){jQuery("#automoviles-button").on("click",function(){jQuery('#automoviles').css('display','block');jQuery('#vagonetas').css('display','none');jQuery('#utilitarios').css('display','none');jQuery("#automoviles-button").addClass("marcado");jQuery("#vagonetas-button").removeClass("marcado");jQuery("#utilitarios-button").removeClass("marcado");});jQuery("#vagonetas-button").on("click",function(){jQuery('#vagonetas').css('display','block');jQuery('#automoviles').css('display','none');jQuery('#utilitarios').css('display','none')
jQuery("#automoviles-button").removeClass("marcado");jQuery("#vagonetas-button").addClass("marcado");jQuery("#utilitarios-button").removeClass("marcado");});jQuery("#utilitarios-button").on("click",function(){jQuery('#utilitarios').css('display','block');jQuery('#automoviles').css('display','none');jQuery('#vagonetas').css('display','none');jQuery("#automoviles-button").removeClass("marcado");jQuery("#vagonetas-button").removeClass("marcado");jQuery("#utilitarios-button").addClass("marcado");});jQuery(".boton-general").on("click",function(){jQuery('#date').show();jQuery('#date-brands').hide();jQuery('.button-date').show();jQuery('.button-date-brands').hide();});var maxWidth=0;jQuery('.wBut').each(function(){if(jQuery(this).width()>maxWidth){maxWidth=jQuery(this).width();}})
jQuery('.wBut').width(maxWidth);});