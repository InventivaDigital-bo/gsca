var CARSELECT = "";

var CITYSELECT = "";

var SUCRUSALSELECT = "";

var database = {

	"ARRIZO3": {

		nombre: "ARRIZO 3",

		precio: "12.500",

		ciudad: {

			"SANTACRUZ": [

					{nombre: "Sucrusal Norte Av. Cristo Redentor <br> Entre 4to y 5to anillo", telefono:'71354018'},

					{nombre: "Sucursal Grigotá Nro 420<br>Entre  3er y 4to anillo", telefono:'72104316'},
					
					{nombre: "Sucursal 4to anillo y Av. Centenario <br>(al lado de Multicenter) <br>(Autoplaza)", telefono:'78509255'},
				
					{nombre: "Sucursal Av. 4to anillo, casi esquina Virgen de Cotoca #3275 <br> (JC Cars)", telefono:'77673012'},

					{nombre: "Sucursal 3er Anillo Interno, calle Froilán Roca casi Av. Piraí <br> (Ciudad Indana)", telefono:'70854192'},

					{nombre: "Sucursal Av. Velarde N° 49 <br> (Union Motor)", telefono:'78530808'},


			],

			"COCHABAMBA": [

					{nombre: "Sucursal Av. Beijing esq. Batallón Colorados <br> (Automundo)", telefono:'79789587'},
				
					{nombre: "Sucursal Av. Libertador Bolívar N°1418 <br> (Automundo)", telefono:'79789587'}

			],

			"LAPAZ": [

					{nombre: "Av. Juan Pablo II, entre Cruz Papal y Fuerza Aérea, lado Prosalud. <br> EL ALTO <br> (Punto Motriz)", telefono:'77522022'},

					{nombre: "C/Pasoskanki y Av. Brasil, zona Miraflores <br> LA PAZ <br> (Punto Motriz)", telefono:'76772731'}

			],

			"TARIJA": [

					{nombre: "Jaime Paz Zamora s/n entre C/ Aulegio Ruiz y Federico Ávila <br> Telf. 46637202 <br> (Punto Motriz)", telefono:'69790019'}

			],

			"ORURO": [

					{nombre: "Av. Circunvalación No.6 y C/Manuel Molina, zona este, dos cuadras hacia el norte del Mercado Tagarete. <br> (Punto Motriz)", telefono:'70415175'}

			]

		}

	},

	"NEWQQ": {

		nombre: "NEWQQ",

		precio: "10.000",

		ciudad: {

			"SANTACRUZ": [

					{nombre: "Sucrusal Norte Av. Cristo Redentor <br> Entre 4to y 5to anillo", telefono:'71354018'},

					{nombre: "Sucursal Grigotá Nro 420<br>Entre  3er y 4to anillo", telefono:'72104316'},
					
					{nombre: "Sucursal 4to anillo y Av. Centenario <br>(al lado de Multicenter) <br>(Autoplaza)", telefono:'78509255'},
				
					{nombre: "Sucursal Av. 4to anillo, casi esquina Virgen de Cotoca #3275 <br> (JC Cars)", telefono:'77673012'},

					{nombre: "Sucursal 3er Anillo Interno, calle Froilán Roca casi Av. Piraí <br> (Ciudad Indana)", telefono:'70854192'},

					{nombre: "Sucursal Av. Velarde N° 49 <br> (Union Motor)", telefono:'78530808'},

			],

			"COCHABAMBA": [

					{nombre: "Sucursal Av. Beijing esq. Batallón Colorados <br> (Automundo)", telefono:'79789587'},
				
					{nombre: "Sucursal Av. Libertador Bolívar N°1418 <br> (Automundo)", telefono:'79789587'}

			],

			"LAPAZ": [

					{nombre: "Av. Juan Pablo II, entre Cruz Papal y Fuerza Aérea, lado Prosalud. <br> EL ALTO <br> (Punto Motriz)", telefono:'77522022'},

					{nombre: "C/Pasoskanki y Av. Brasil, zona Miraflores <br> LA PAZ <br> (Punto Motriz)", telefono:'76772731'}

			],

			"TARIJA": [

					{nombre: "Jaime Paz Zamora s/n entre C/ Aulegio Ruiz y Federico Ávila <br> Telf. 46637202 <br> (Punto Motriz)", telefono:'69790019'}

			],

			"ORURO": [

					{nombre: "Av. Circunvalación No.6 y C/Manuel Molina, zona este, dos cuadras hacia el norte del Mercado Tagarete. <br> (Punto Motriz)", telefono:'70415175'}

			]

		}

	},

	"TIGGO2": {

		nombre: "TIGGO 2",

		precio: "14.490",

		ciudad: {

			"SANTACRUZ": [

					{nombre: "Sucrusal Norte Av. Cristo Redentor <br> Entre 4to y 5to anillo", telefono:'71354018'},

					{nombre: "Sucursal Grigotá Nro 420<br>Entre  3er y 4to anillo", telefono:'72104316'},
					
					{nombre: "Sucursal 4to anillo y Av. Centenario <br>(al lado de Multicenter) <br>(Autoplaza)", telefono:'78509255'},
				
					{nombre: "Sucursal Av. 4to anillo, casi esquina Virgen de Cotoca #3275 <br> (JC Cars)", telefono:'77673012'},

					{nombre: "Sucursal 3er Anillo Interno, calle Froilán Roca casi Av. Piraí <br> (Ciudad Indana)", telefono:'70854192'},

					{nombre: "Sucursal Av. Velarde N° 49 <br> (Union Motor)", telefono:'78530808'},


			],

			"COCHABAMBA": [

					{nombre: "Sucursal Av. Beijing esq. Batallón Colorados <br> (Automundo)", telefono:'79789587'},
				
					{nombre: "Sucursal Av. Libertador Bolívar N°1418 <br> (Automundo)", telefono:'79789587'}

			],

			"LAPAZ": [

					{nombre: "Av. Juan Pablo II, entre Cruz Papal y Fuerza Aérea, lado Prosalud. <br> EL ALTO <br> (Punto Motriz)", telefono:'77522022'},

					{nombre: "C/Pasoskanki y Av. Brasil, zona Miraflores <br> LA PAZ <br> (Punto Motriz)", telefono:'76772731'}

			],

			"TARIJA": [

					{nombre: "Jaime Paz Zamora s/n entre C/ Aulegio Ruiz y Federico Ávila <br> Telf. 46637202 <br> (Punto Motriz)", telefono:'69790019'}

			],

			"ORURO": [

					{nombre: "Av. Circunvalación No.6 y C/Manuel Molina, zona este, dos cuadras hacia el norte del Mercado Tagarete. <br> (Punto Motriz)", telefono:'70415175'}

			]

		}

	},


	"TIGGO4": {

		nombre: "TIGGO 4",

		precio: "17.500",

		ciudad: {

			"SANTACRUZ": [

					{nombre: "Sucrusal Norte Av. Cristo Redentor <br> Entre 4to y 5to anillo", telefono:'71354018'},

					{nombre: "Sucursal Grigotá Nro 420<br>Entre  3er y 4to anillo", telefono:'72104316'},
					
					{nombre: "Sucursal 4to anillo y Av. Centenario <br>(al lado de Multicenter) <br>(Autoplaza)", telefono:'78509255'},
				
					{nombre: "Sucursal Av. 4to anillo, casi esquina Virgen de Cotoca #3275 <br> (JC Cars)", telefono:'77673012'},

					{nombre: "Sucursal 3er Anillo Interno, calle Froilán Roca casi Av. Piraí <br> (Ciudad Indana)", telefono:'70854192'},

					{nombre: "Sucursal Av. Velarde N° 49 <br> (Union Motor)", telefono:'78530808'},

			],

			"COCHABAMBA": [

					{nombre: "Sucursal Av. Beijing esq. Batallón Colorados <br> (Automundo)", telefono:'79789587'},
				
					{nombre: "Sucursal Av. Libertador Bolívar N°1418 <br> (Automundo)", telefono:'79789587'}

			],

			"LAPAZ": [

					{nombre: "Av. Juan Pablo II, entre Cruz Papal y Fuerza Aérea, lado Prosalud. <br> EL ALTO <br> (Punto Motriz)", telefono:'77522022'},

					{nombre: "C/Pasoskanki y Av. Brasil, zona Miraflores <br> LA PAZ <br> (Punto Motriz)", telefono:'76772731'}

			],

			"TARIJA": [

					{nombre: "Jaime Paz Zamora s/n entre C/ Aulegio Ruiz y Federico Ávila <br> Telf. 46637202 <br> (Punto Motriz)", telefono:'69790019'}

			],

			"ORURO": [

					{nombre: "Av. Circunvalación No.6 y C/Manuel Molina, zona este, dos cuadras hacia el norte del Mercado Tagarete. <br> (Punto Motriz)", telefono:'70415175'}

			]

		}

	},

	"YOYO11": {

		nombre: "YOYO VAN 11 PASAJEROS",

		precio: "12.990",

		ciudad: {

			"SANTACRUZ": [

					{nombre: "Sucrusal Norte Av. Cristo Redentor <br> Entre 4to y 5to anillo", telefono:'71354018'},

					{nombre: "Sucursal Grigotá Nro 420<br>Entre  3er y 4to anillo", telefono:'72104316'},
					
					{nombre: "Sucursal 4to anillo y Av. Centenario <br>(al lado de Multicenter) <br>(Autoplaza)", telefono:'78509255'},
				
					{nombre: "Sucursal Av. 4to anillo, casi esquina Virgen de Cotoca #3275 <br> (JC Cars)", telefono:'77673012'},

					{nombre: "Sucursal 3er Anillo Interno, calle Froilán Roca casi Av. Piraí <br> (Ciudad Indana)", telefono:'70854192'},

					{nombre: "Sucursal Av. Velarde N° 49 <br> (Union Motor)", telefono:'78530808'},

			],

			"COCHABAMBA": [

					{nombre: "Sucursal Av. Beijing esq. Batallón Colorados <br> (Automundo)", telefono:'79789587'},
				
					{nombre: "Sucursal Av. Libertador Bolívar N°1418 <br> (Automundo)", telefono:'79789587'}

			],

			"LAPAZ": [

					{nombre: "Av. Juan Pablo II, entre Cruz Papal y Fuerza Aérea, lado Prosalud. <br> EL ALTO <br> (Punto Motriz)", telefono:'77522022'},

					{nombre: "C/Pasoskanki y Av. Brasil, zona Miraflores <br> LA PAZ <br> (Punto Motriz)", telefono:'76772731'}

			],

			"TARIJA": [

					{nombre: "Jaime Paz Zamora s/n entre C/ Aulegio Ruiz y Federico Ávila <br> Telf. 46637202 <br> (Punto Motriz)", telefono:'69790019'}

			],

			"ORURO": [

					{nombre: "Av. Circunvalación No.6 y C/Manuel Molina, zona este, dos cuadras hacia el norte del Mercado Tagarete. <br> (Punto Motriz)", telefono:'70415175'}

			]

		}

	},

	"YOKI": {

		nombre: "YOKI XL",

		precio: "11.500",

		ciudad: {

			"SANTACRUZ": [

					{nombre: "Sucrusal Norte Av. Cristo Redentor <br> Entre 4to y 5to anillo", telefono:'71354018'},

					{nombre: "Sucursal Grigotá Nro 420<br>Entre  3er y 4to anillo", telefono:'72104316'},
					
					{nombre: "Sucursal 4to anillo y Av. Centenario <br>(al lado de Multicenter) <br>(Autoplaza)", telefono:'78509255'},
				
					{nombre: "Sucursal Av. 4to anillo, casi esquina Virgen de Cotoca #3275 <br> (JC Cars)", telefono:'77673012'},

					{nombre: "Sucursal 3er Anillo Interno, calle Froilán Roca casi Av. Piraí <br> (Ciudad Indana)", telefono:'70854192'},

					{nombre: "Sucursal Av. Velarde N° 49 <br> (Union Motor)", telefono:'78530808'},

			],

			"COCHABAMBA": [

					{nombre: "Sucursal Av. Beijing esq. Batallón Colorados <br> (Automundo)", telefono:'79789587'},
				
					{nombre: "Sucursal Av. Libertador Bolívar N°1418 <br> (Automundo)", telefono:'79789587'}

			],

			"LAPAZ": [

					{nombre: "Av. Juan Pablo II, entre Cruz Papal y Fuerza Aérea, lado Prosalud. <br> EL ALTO <br> (Punto Motriz)", telefono:'77522022'},

					{nombre: "C/Pasoskanki y Av. Brasil, zona Miraflores <br> LA PAZ <br> (Punto Motriz)", telefono:'76772731'}

			],

			"TARIJA": [

					{nombre: "Jaime Paz Zamora s/n entre C/ Aulegio Ruiz y Federico Ávila <br> Telf. 46637202 <br> (Punto Motriz)", telefono:'69790019'}

			],

			"ORURO": [

					{nombre: "Av. Circunvalación No.6 y C/Manuel Molina, zona este, dos cuadras hacia el norte del Mercado Tagarete. <br> (Punto Motriz)", telefono:'70415175'}

			]

		}

	},

	"K50": {

		nombre: "K50",

		precio: "13.500",

		ciudad: {

			"SANTACRUZ": [

					{nombre: "Sucrusal Norte Av. Cristo Redentor <br> Entre 4to y 5to anillo", telefono:'71354018'},

					{nombre: "Sucursal Grigotá Nro 420<br>Entre  3er y 4to anillo", telefono:'72104316'},
					
					{nombre: "Sucursal 4to anillo y Av. Centenario <br>(al lado de Multicenter) <br>(Autoplaza)", telefono:'78509255'},
				
					{nombre: "Sucursal Av. 4to anillo, casi esquina Virgen de Cotoca #3275 <br> (JC Cars)", telefono:'77673012'},

					{nombre: "Sucursal 3er Anillo Interno, calle Froilán Roca casi Av. Piraí <br> (Ciudad Indana)", telefono:'70854192'},

					{nombre: "Sucursal Av. Velarde N° 49 <br> (Union Motor)", telefono:'78530808'},

			],

			"COCHABAMBA": [

					{nombre: "Sucursal Av. Beijing esq. Batallón Colorados <br> (Automundo)", telefono:'79789587'},
				
					{nombre: "Sucursal Av. Libertador Bolívar N°1418 <br> (Automundo)", telefono:'79789587'}

			],

			"LAPAZ": [

					{nombre: "Av. Juan Pablo II, entre Cruz Papal y Fuerza Aérea, lado Prosalud. <br> EL ALTO <br> (Punto Motriz)", telefono:'77522022'},

					{nombre: "C/Pasoskanki y Av. Brasil, zona Miraflores <br> LA PAZ <br> (Punto Motriz)", telefono:'76772731'}

			],

			"TARIJA": [

					{nombre: "Jaime Paz Zamora s/n entre C/ Aulegio Ruiz y Federico Ávila <br> Telf. 46637202 <br> (Punto Motriz)", telefono:'69790019'}

			],

			"ORURO": [

					{nombre: "Av. Circunvalación No.6 y C/Manuel Molina, zona este, dos cuadras hacia el norte del Mercado Tagarete. <br> (Punto Motriz)", telefono:'70415175'}

			]

		}

	}

}