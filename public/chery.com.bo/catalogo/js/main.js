function paintWhatsappContact(){
	cleanContentWhatsappContact();
	var car = database[CARSELECT];
	var ciudad = car.ciudad[CITYSELECT];
	var result = [];
	for (var i = 0; i < ciudad.length; i++) {
		var item = ciudad[i];
		var html = '<a href="https://wa.me/591' + 
						item.telefono + '?text=Hola!%20Me%20interesa%20el%20' + 
						car.nombre + '," class="whatsapp-item" target="_blank" data-telf="' + 
						item.telefono + '" data-car="' + 
						car.nombre + '" onclick="whatsappClick(this);">' +
						'<div class="header">' +
							'<h3>' + item.nombre + '</h3>' +
						'</div>' +
						'<div class="main">' +
							'<img src="./img/whatsapp-icon.png" alt="70987548"> <br>' +
							'<h5>' + item.telefono + '</h5>' +
						'</div>' +
					'</a>';
		result.push(html);
	}
	$("#call-by-whatsapp").html(result);
}

function cleanContentWhatsappContact(){
	$("#call-by-whatsapp").html("");
}

function getCarSelect(){
	var car = database[CARSELECT];
	$('.car-select').text(car.nombre);
	$('.car-price').text(car.precio);
	if( document.getElementById('inputAuto') ){
		$('#inputAuto').val(car.nombre);
	}
	if( document.getElementById('inputPrecio') ){
		$('#inputPrecio').val(car.precio);
	}
}

function openMenuSandwich(){
	$(".menu").addClass("active");
}

function closeMenuSandwich(){
	$(".menu").removeClass("active");
}

function verifyHash(hash){
	if(hash == '#FULWINHB'){
		goto(1);
	}
	if(hash == '#FULWINSD'){
		goto(2);
	}
	if(hash == '#NEWQQ'){
		goto(3);
	}
	if(hash == '#TIGGO2'){
		goto(4);
	}
	if(hash == '#TIGGO3'){
		goto(5);
	}
	if(hash == '#TIGGO4'){
		goto(6);
	}
	if(hash == '#TIGGO5'){
		goto(7);
	}
	
	closeMenuSandwich();
}

function goto(position){
	$('.slick').slick('slickGoTo', position - 1);
}

function openPopUp(){
	$('#popupWhatsapp').addClass('active');
}

function closePopUp(){
	cleanContentWhatsappContact();
	$('#popupWhatsapp').removeClass('active');
	$(".sucursal-title").addClass('hide');
	cleanInputsFormEmail()
	CARSELECT = "";
	CITYSELECT = "";
	SUCRUSALSELECT = "";
}

function closePopUpForm(){
	cleanContentWhatsappContact();
	$('#popupForm').removeClass('active');
	cleanInputsFormEmail();
	console.log("CERRANDO POPUP");
	$('.formContent').css('display','block');
	$('.formThanyou').css('display','none');
	CARSELECT = "";
	CITYSELECT = "";
	SUCRUSALSELECT = "";
}

function cleanInputsFormEmail(){
	$('#inputCiudad').val('');
	$('#inputAuto').val('');
	$('#inputPrecio').val('');
	$('#inputCiudad').val('');
	$('#inputNombre').val('');
	$('#inputCorreo').val('');
	$('#inputTelefono').val('');
	$('#inputMensaje').val('');
}

function openPopUpForm(){
	$('#popupForm').addClass('active');
}

function selectCiudad(){
	if( $(".ciudades ul").hasClass('active') ){
		$(".ciudades p").removeClass('active');
		$(".ciudades ul").removeClass('active');
	}else{
		$(".ciudades p").addClass('active');
		$(".ciudades ul").addClass('active');
	}
}

function closeSelectCiudad(event){
	// if( $(event).find("#ciudad") ){
	// 	if( $(".ciudades ul").hasClass('active') ){
	// 		console.log("AQUII");
	// 		$(".ciudades p").removeClass('active');
	// 		$(".ciudades ul").removeClass('active');
	// 	}
	// }
}

function submitFormEmail(){
	var ciudad = $('#inputCiudad').val();
	var nombre = $('#inputNombre').val();
	var correo = $('#inputCorreo').val();
	var telefono = $('#inputTelefono').val();
	var auto = $('#inputAuto').val();
	var precio = $('#inputPrecio').val();
	var mensaje = $('#inputMensaje').val();
	$('#btnSendFormEmail').prop("disabled",true);
	if( validarFormEmail() ){
		$.ajax({
			url:'/catalogo/contacto/',
			method:'post',
			data: {
				'ciudad': ciudad,
				'nombre': nombre,
				'correo': correo,
				'telefono': telefono,
				'auto': auto,
				'precio': precio,
				'mensaje': mensaje,
				'submit': true
			},
			success: successFormEmail,
			error: errorFormEmail
		});
		var value = "Vehiculo:" + auto + ", phone:" + telefono;
		analitycsEventCall('Email send', value);
	}else{
		habilitarBotonEnviarForm();
	}
	return false;
}

function validarFormEmail(){
	var ERRORCIUDAD = 'Selecciona una ciudad';
	var CAMPOREQUERIDO = 'Este campo es requerido';
	var ciudad = $('#inputCiudad').val();
	var nombre = $('#inputNombre').val();
	var correo = $('#inputCorreo').val();
	var telefono = $('#inputTelefono').val();
	var isValid = true;
	$('.error').text('');
	if( ciudad == undefined || ciudad.trim() == '' ){
		$('#ciudadError').text(ERRORCIUDAD);
		isValid = false;
	}
	if( nombre == undefined || nombre.trim() == '' ){
		$('#nombreError').text(CAMPOREQUERIDO);
		isValid = false;
	}
	if( correo == undefined || correo.trim() == '' ){
		$('#correoError').text(CAMPOREQUERIDO);
		isValid = false;
	}
	if( telefono == undefined || telefono.trim() == '' ){
		$('#telefonoError').text(CAMPOREQUERIDO);
		isValid = false;
	}
	return isValid;
}

function habilitarBotonEnviarForm(){
	$('#btnSendFormEmail').prop("disabled",false);
}

function successFormEmail(data){
	$('.formContent').css('display','none');
	$('.formThanyou').css('display','block');
	habilitarBotonEnviarForm();
}

function errorFormEmail(err){
	habilitarBotonEnviarForm();
}