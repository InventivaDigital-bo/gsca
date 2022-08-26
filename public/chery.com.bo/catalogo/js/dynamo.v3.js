var CARSELECT = "";
var CITYSELECT = "";
var SUCRUSALSELECT = "";
var database = {
	"ARRIZO3": {
		nombre: "ARRIZO 3",
		precio: "13.900",
		ciudad: {
			"SANTACRUZ": [
					{nombre: "Sucrusal Norte Av. Cristo Redentor <br> Entre 4to y 5to anillo", telefono:'72104316'},
					{nombre: "Sucursal Grigotá Nro 420<br>Entre  3er y 4to anillo", telefono:'72148818'},
					{nombre: "Sucursal Av. 3 pasos al frente <br> (JC-Cars)", telefono:'77673012'},
					{nombre: "Sucursal Doble Vía la Guardia <br> (Global Motor)", telefono:'72641090'},
					{nombre: "Sucursal Av. Cañada Pailita <br> (Union Motor)", telefono:'77037520'},
					{nombre: "Sucursal Av. Roca y Coronado <br> (Eco Car)", telefono:'69044727'},
					{nombre: "Sucursal Av. Cuarto anillo y<br> Centenario (Autoplaza)", telefono:'76578256'},
					{nombre: "Sucursal Cristobal de mendoza <br>esq. Beni (Autoworld)", telefono:'77196600'},
			],
			"COCHABAMBA": [
					{nombre: "Sucursal Av. Beijing Esq. Batallón Colorado (Automundo)", telefono:'79789587'}
			],
			"LAPAZ": [
					{nombre: "Sucursal Av. Satélite Nro 760 <br> entre Civica y Arica - El Alto <br> (Punto Motriz)", telefono:'78982940'},
					{nombre: "Sucursal Av. Satélite Nro 760 <br> entre Civica y Arica - El Alto <br> (Punto Motriz)", telefono:'69791135'}
			],
			// "SUCRE": [
					// {nombre: "Global Motor", telefono:'72875007'}
			// ],
			"TARIJA": [
					{nombre: "Chery Tarija C/Los Heroes del chaco zona aeropuerto", telefono:'76189870'}
			]
		}
	},
	"NEWQQ": {
		nombre: "NEWQQ",
		precio: "10.400",
		ciudad: {
			"SANTACRUZ": [
					{nombre: "Sucrusal Norte Av. Cristo Redentor <br> Entre 4to y 5to anillo", telefono:'72104316'},
					{nombre: "Sucursal Grigotá Nro 420<br>Entre  3er y 4to anillo", telefono:'72148818'},
					{nombre: "Sucursal Av. 3 pasos al frente <br> (JC-Cars)", telefono:'77673012'},
					{nombre: "Sucursal Doble Vía la Guardia <br> (Global Motor)", telefono:'72641090'},
					{nombre: "Sucursal Av. Cañada Pailita <br> (Union Motor)", telefono:'77037520'},
					{nombre: "Sucursal Av. Roca y Coronado <br> (Eco Car)", telefono:'69044727'},
					{nombre: "Sucursal Av. Cuarto anillo y<br> Centenario (Autoplaza)", telefono:'76578256'},
					{nombre: "Sucursal Cristobal de mendoza <br>esq. Beni (Autoworld)", telefono:'77196600'},
			],
			"COCHABAMBA": [
					{nombre: "Sucursal Av. Beijing Esq. Batallón Colorado (Automundo)", telefono:'79789587'}
			],
			"LAPAZ": [
					{nombre: "Sucursal Av. Satélite Nro 760 <br> entre Civica y Arica - El Alto <br> (Punto Motriz)", telefono:'78982940'},
					{nombre: "Sucursal Av. Satélite Nro 760 <br> entre Civica y Arica - El Alto <br> (Punto Motriz)", telefono:'69791135'}
			],
			//"SUCRE": [
					//{nombre: "Global Motor", telefono:'72875007'}
			//],
			"TARIJA": [
					{nombre: "Chery Tarija C/Los Heroes del chaco zona aeropuerto", telefono:'76189870'}
			]
		}
	},
	"FULWINHB": {
		nombre: "FULWIN HATCHBACK",
		precio: "13.500",
		ciudad: {
			"SANTACRUZ": [
					{nombre: "Sucrusal Norte Av. Cristo Redentor <br> Entre 4to y 5to anillo", telefono:'72104316'},
					{nombre: "Sucursal Grigotá Nro 420<br>Entre  3er y 4to anillo", telefono:'72148818'},
					{nombre: "Sucursal Av. 3 pasos al frente <br> (JC-Cars)", telefono:'77673012'},
					{nombre: "Sucursal Doble Vía la Guardia <br> (Global Motor)", telefono:'72641090'},
					{nombre: "Sucursal Av. Cañada Pailita <br> (Union Motor)", telefono:'77037520'},
					{nombre: "Sucursal Av. Roca y Coronado <br> (Eco Car)", telefono:'69044727'},
					{nombre: "Sucursal Av. Cuarto anillo y<br> Centenario (Autoplaza)", telefono:'76578256'},
					{nombre: "Sucursal Cristobal de mendoza <br>esq. Beni (Autoworld)", telefono:'77196600'},
			],
			"COCHABAMBA": [
					{nombre: "Sucursal Av. Beijing Esq. Batallón Colorado (Automundo)", telefono:'79789587'}
			],
			"LAPAZ": [
					{nombre: "Sucursal Av. Satélite Nro 760 <br> entre Civica y Arica - El Alto <br> (Punto Motriz)", telefono:'78982940'},
					{nombre: "Sucursal Av. Satélite Nro 760 <br> entre Civica y Arica - El Alto <br> (Punto Motriz)", telefono:'69791135'}
			],
			//"SUCRE": [
					//{nombre: "Global Motor", telefono:'72875007'}
			//],
			"TARIJA": [
					{nombre: "Chery Tarija C/Los Heroes del chaco zona aeropuerto", telefono:'76189870'}
			]
		}
	},
	"FULWINSD": {
		nombre: "FULWIN SEDÁN",
		precio: "13.500",
		ciudad: {
			"SANTACRUZ": [
					{nombre: "Sucrusal Norte Av. Cristo Redentor <br> Entre 4to y 5to anillo", telefono:'72104316'},
					{nombre: "Sucursal Grigotá Nro 420<br>Entre  3er y 4to anillo", telefono:'72148818'},
					{nombre: "Sucursal Av. 3 pasos al frente <br> (JC-Cars)", telefono:'77673012'},
					{nombre: "Sucursal Doble Vía la Guardia <br> (Global Motor)", telefono:'72641090'},
					{nombre: "Sucursal Av. Cañada Pailita <br> (Union Motor)", telefono:'77037520'},
					{nombre: "Sucursal Av. Roca y Coronado <br> (Eco Car)", telefono:'69044727'},
					{nombre: "Sucursal Av. Cuarto anillo y<br> Centenario (Autoplaza)", telefono:'76578256'},
					{nombre: "Sucursal Cristobal de mendoza <br>esq. Beni (Autoworld)", telefono:'77196600'},
			],
			"COCHABAMBA": [
					{nombre: "Sucursal Av. Beijing Esq. Batallón Colorado (Automundo)", telefono:'79789587'}
			],
			"LAPAZ": [
					{nombre: "Sucursal Av. Satélite Nro 760 <br> entre Civica y Arica - El Alto <br> (Punto Motriz)", telefono:'78982940'},
					{nombre: "Sucursal Av. Satélite Nro 760 <br> entre Civica y Arica - El Alto <br> (Punto Motriz)", telefono:'69791135'}
			],
			//"SUCRE": [
					//{nombre: "Global Motor", telefono:'72875007'}
			//],
			"TARIJA": [
					{nombre: "Chery Tarija C/Los Heroes del chaco zona aeropuerto", telefono:'76189870'}
			]
		}
	},
	"TIGGO2": {
		nombre: "TIGGO 2",
		precio: "16.900",
		ciudad: {
			"SANTACRUZ": [
					{nombre: "Sucrusal Norte Av. Cristo Redentor <br> Entre 4to y 5to anillo", telefono:'72104316'},
					{nombre: "Sucursal Grigotá Nro 420<br>Entre  3er y 4to anillo", telefono:'72148818'},
					{nombre: "Sucursal Av. 3 pasos al frente <br> (JC-Cars)", telefono:'77673012'},
					{nombre: "Sucursal Doble Vía la Guardia <br> (Global Motor)", telefono:'72641090'},
					{nombre: "Sucursal Av. Cañada Pailita <br> (Union Motor)", telefono:'77037520'},
					{nombre: "Sucursal Av. Roca y Coronado <br> (Eco Car)", telefono:'69044727'},
					{nombre: "Sucursal Av. Cuarto anillo y<br> Centenario (Autoplaza)", telefono:'76578256'},
					{nombre: "Sucursal Cristobal de mendoza <br>esq. Beni (Autoworld)", telefono:'77196600'},
			],
			"COCHABAMBA": [
					{nombre: "Sucursal Av. Beijing Esq. Batallón Colorado (Automundo)", telefono:'79789587'}
			],
			"LAPAZ": [
					{nombre: "Sucursal Av. Satélite Nro 760 <br> entre Civica y Arica - El Alto <br> (Punto Motriz)", telefono:'78982940'},
					{nombre: "Sucursal Av. Satélite Nro 760 <br> entre Civica y Arica - El Alto <br> (Punto Motriz)", telefono:'69791135'}
			],
			//"SUCRE": [
					//{nombre: "Global Motor", telefono:'72875007'}
			//],
			"TARIJA": [
					{nombre: "Chery Tarija C/Los Heroes del chaco zona aeropuerto", telefono:'76189870'}
			]
		}
	},
	"TIGGO3": {
		nombre: "TIGGO 3",
		precio: "18.500",
		ciudad: {
			"SANTACRUZ": [
					{nombre: "Sucrusal Norte Av. Cristo Redentor <br> Entre 4to y 5to anillo", telefono:'72104316'},
					{nombre: "Sucursal Grigotá Nro 420<br>Entre  3er y 4to anillo", telefono:'72148818'},
					{nombre: "Sucursal Av. 3 pasos al frente <br> (JC-Cars)", telefono:'77673012'},
					{nombre: "Sucursal Doble Vía la Guardia <br> (Global Motor)", telefono:'72641090'},
					{nombre: "Sucursal Av. Cañada Pailita <br> (Union Motor)", telefono:'77037520'},
					{nombre: "Sucursal Av. Roca y Coronado <br> (Eco Car)", telefono:'69044727'},
					{nombre: "Sucursal Av. Cuarto anillo y<br> Centenario (Autoplaza)", telefono:'76578256'},
					{nombre: "Sucursal Cristobal de mendoza <br>esq. Beni (Autoworld)", telefono:'77196600'},
			],
			"COCHABAMBA": [
					{nombre: "Sucursal Av. Beijing Esq. Batallón Colorado (Automundo)", telefono:'79789587'}
			],
			"LAPAZ": [
					{nombre: "Sucursal Av. Satélite Nro 760 <br> entre Civica y Arica - El Alto <br> (Punto Motriz)", telefono:'78982940'},
					{nombre: "Sucursal Av. Satélite Nro 760 <br> entre Civica y Arica - El Alto <br> (Punto Motriz)", telefono:'69791135'}
			],
			//"SUCRE": [
					//{nombre: "Global Motor", telefono:'72875007'}
			//],
			"TARIJA": [
					{nombre: "Chery Tarija C/Los Heroes del chaco zona aeropuerto", telefono:'76189870'}
			]
		}
	},
	"TIGGO4": {
		nombre: "TIGGO 4",
		precio: "20.500",
		ciudad: {
			"SANTACRUZ": [
					{nombre: "Sucrusal Norte Av. Cristo Redentor <br> Entre 4to y 5to anillo", telefono:'72104316'},
					{nombre: "Sucursal Grigotá Nro 420<br>Entre  3er y 4to anillo", telefono:'72148818'},
					{nombre: "Sucursal Av. 3 pasos al frente <br> (JC-Cars)", telefono:'77673012'},
					{nombre: "Sucursal Doble Vía la Guardia <br> (Global Motor)", telefono:'72641090'},
					{nombre: "Sucursal Av. Cañada Pailita <br> (Union Motor)", telefono:'77037520'},
					{nombre: "Sucursal Av. Roca y Coronado <br> (Eco Car)", telefono:'69044727'},
					{nombre: "Sucursal Av. Cuarto anillo y<br> Centenario (Autoplaza)", telefono:'76578256'},
					{nombre: "Sucursal Cristobal de mendoza <br>esq. Beni (Autoworld)", telefono:'77196600'},
			],
			"COCHABAMBA": [
					{nombre: "Sucursal Av. Beijing Esq. Batallón Colorado (Automundo)", telefono:'79789587'}
			],
			"LAPAZ": [
					{nombre: "Sucursal Av. Satélite Nro 760 <br> entre Civica y Arica - El Alto <br> (Punto Motriz)", telefono:'78982940'},
					{nombre: "Sucursal Av. Satélite Nro 760 <br> entre Civica y Arica - El Alto <br> (Punto Motriz)", telefono:'69791135'}
			],
			//"SUCRE": [
					//{nombre: "Global Motor", telefono:'72875007'}
			//],
			"TARIJA": [
					{nombre: "Chery Tarija C/Los Heroes del chaco zona aeropuerto", telefono:'76189870'}
			]
		}
	},
	"TIGGO5": {
		nombre: "TIGGO 5",
		precio: "22.000",
		ciudad: {
			"SANTACRUZ": [
					{nombre: "Sucrusal Norte Av. Cristo Redentor <br> Entre 4to y 5to anillo", telefono:'72104316'},
					{nombre: "Sucursal Grigotá Nro 420<br>Entre  3er y 4to anillo", telefono:'72148818'},
					{nombre: "Sucursal Av. 3 pasos al frente <br> (JC-Cars)", telefono:'77673012'},
					{nombre: "Sucursal Doble Vía la Guardia <br> (Global Motor)", telefono:'72641090'},
					{nombre: "Sucursal Av. Cañada Pailita <br> (Union Motor)", telefono:'77037520'},
					{nombre: "Sucursal Av. Roca y Coronado <br> (Eco Car)", telefono:'69044727'},
					{nombre: "Sucursal Av. Cuarto anillo y<br> Centenario (Autoplaza)", telefono:'76578256'},
					{nombre: "Sucursal Cristobal de mendoza <br>esq. Beni (Autoworld)", telefono:'77196600'},
			],
			"COCHABAMBA": [
					{nombre: "Sucursal Av. Beijing Esq. Batallón Colorado (Automundo)", telefono:'79789587'}
			],
			"LAPAZ": [
					{nombre: "Sucursal Av. Satélite Nro 760 <br> entre Civica y Arica - El Alto <br> (Punto Motriz)", telefono:'78982940'},
					{nombre: "Sucursal Av. Satélite Nro 760 <br> entre Civica y Arica - El Alto <br> (Punto Motriz)", telefono:'69791135'}
			],
			//"SUCRE": [
					//{nombre: "Global Motor", telefono:'72875007'}
			//],
			"TARIJA": [
					{nombre: "Chery Tarija C/Los Heroes del chaco zona aeropuerto", telefono:'76189870'}
			]
		}
	}
}