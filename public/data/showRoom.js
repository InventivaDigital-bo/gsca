var APP_DATA = {
    "scenes": [
    
    {
        "id": "4-lb2",
        "name": "lb2",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": 1.8938764435904272,
          "pitch": 0.08372223144716706,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": -0.6240360258159399,
            "pitch": 0.019484559394323142,
            "rotation": 0,
            "type": "next",
            "label": "Regresar al lobby",
            "target": "3-lbc-2"
          },
          {
            "yaw": 1.6868863292411769,
            "pitch": 0.263044476457452,
            "rotation": 0,
            "type": "next",
            "label": "Avanzar a New Tiggo 4 1.5 y Tiggo 2 Pro",
            "target": "5-lb3"
          },
          {
            "yaw": 2.688868057784341,
            "pitch": 0.08526666705217067,
            "rotation": 0,
            "type": "show",
            "label": "Ver Tiggo 7 Pro",
            "target": "0-7pfc"
          }
        ],
        "infoHotspots": []
      },    
      {
        "id": "3-lbc-2",
        "name": "lbc (2)",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": -1.5326421410926212,
          "pitch": 0.0760818708995501,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": 0.4493759281681236,
            "pitch": 0.1403076007859788,
            "rotation": 0,
            "type": "next",
            "label": "Regresar a exteriores",
            "target": "1-ext2"
          },
          {
            "yaw": -1.4493759281681236,
            "pitch": 0.2403076007859788,
            "rotation": 0,
            "type": "next",
            "label": "Avanzar Tiggo 7 Pro",
            "target": "4-lb2"
          }
        ],
        "infoHotspots": []
      },
  
    //   Lobby
  

      {
        "id": "0-ext",
        "name": "ext",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": 0.7008168227238922,
          "pitch": -0.05769197613758692,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": 0.13456269520001563,
            "pitch": 0.17310250102344327,
            "rotation": 0,
            "type": "next",
            "label": "Avanzar al lobby",
            "target": "1-ext2"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "1-ext2",
        "name": "ext2",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": 0.0026851219261452286,
          "pitch": -0.057691976137594025,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": 0.04689222351865041,
            "pitch": 0.03966558185778801,
            "rotation": 0,
            "type": "next",
            "label": "Avanzar al lobby",
            "target": "3-lbc-2"
          },
          {
            "yaw": 3.1241866994997807,
            "pitch": 0.1902383734412254,
            "rotation": 0,
            "type": "next",
            "label": "Regresar a exteriores",
            "target": "0-ext"
          }
        ],
        "infoHotspots": []
      },

      {
        "id": "5-lb3",
        "name": "lb3",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "pitch": 0,
          "yaw": 0,
          "fov": 1.5707963267948966
        },
        "linkHotspots": [
          {
            "yaw": 0.33347335296504177,
            "pitch": 0.17852825410270867,
            "rotation": 0,
            "type": "next",
            "label": "Avanzar a Tiggo 2 pro",
            "target": "6-lb4"
          },
          {
            "yaw": 2.728686158676238,
            "pitch": 0.1884740623752137,
            "rotation": 0,
            "type": "next",
            "label": "Regresar al lobby",
            "target": "4-lb2"
          },
          {
            "yaw": -2.0939649701739906,
            "pitch": 0.2784733580896308,
            "rotation": 0,
            "type": "next",
            "label": "Avanzar a New Tiggo 4 1.5",
            "target": "7-lb5"
          },
          {
            "yaw": 2.03510566529042,
            "pitch": 0.09138062518133694,
            "rotation": 0,
            "type": "show",
            "label": "Ver Tiggo 7 Pro",
            "target": "0-7pfc"
          },
          {
            "yaw": 0.9207224403864984,
            "pitch": 0.0650429431701447,
            "rotation": 0,
            "type": "show",
            "label": "Ver Tiggo 2 Pro",
            "target": "0-2cfc"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "6-lb4",
        "name": "lb4",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": 3.0968688168635286,
          "pitch": 0.10951014665936043,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": -2.5415551827632807,
            "pitch": 0.15155416594690152,
            "rotation": 0,
            "type": "next",
            "label": "Regresar al lobby",
            "target": "5-lb3"
          },
          {
            "yaw": 2.86543233979335,
            "pitch": 0.14769149685800897,
            "rotation": 0,
            "type": "show",
            "label": "Ver Tiggo 2 Pro",
            "target": "0-2cfc"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "7-lb5",
        "name": "lb5",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": -1.6748750798796603,
          "pitch": 0.15484781211696053,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": -1.3463381636061325,
            "pitch": 0.11920672272201926,
            "rotation": 0,
            "type": "next",
            "label": "Avanzar a Tiggo 2 Pro",
            "target": "8-lb6"
          },
          {
            "yaw": 0.8853411357128937,
            "pitch": 0.3415499764724643,
            "rotation": 0,
            "type": "next",
            "label": "Regresar al lobby",
            "target": "5-lb3"
          },
          {
            "yaw": -1.8024180552030646,
            "pitch": 0.16022011064323038,
            "rotation": 0,
            "type": "show",
            "label": "Ver New Tiggo 4 Pro 1.5",
            "target": "0-4pfc"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "8-lb6",
        "name": "lb6",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": -2.489581870582315,
          "pitch": 0.33684669938407197,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": 1.0670805919599324,
            "pitch": 0.18036310832683355,
            "rotation": 0,
            "type": "next",
            "label": "Regresar al lobby",
            "target": "7-lb5"
          },
          {
            "yaw": -2.716314462455461,
            "pitch": 0.16118549849575814,
            "rotation": 0,
            "type": "show",
            "label": "Ver Tiggo 2 Pro",
            "target": "0-2pfc"
          },
          {
            "yaw": 1.7580246365292878,
            "pitch": 0.18010300371695465,
            "rotation": 0,
            "type": "show",
            "label": "Ver New Tiggo 4 Pro 1.5",
            "target": "0-4pfc"
          }
        ],
        "infoHotspots": []
      },

      
  //
  //     Tiggo 2 pro
  //

      {
        "id": "0-2cfc",
        "name": "2cfc",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": -1.9824590820970158,
          "pitch": 0.4950364633473612,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": -1.5344912856543544,
            "pitch": 0.33447164484879366,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral izquierda ",
            "target": "9-2cic"
          },
          {
            "yaw": -2.4404540927282667,
            "pitch": 0.17803248098478974,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral derecha",
            "target": "6-2cdc"
          },
          {
            "yaw": -2.2411395370336997,
            "pitch": 0.42668866539292516,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista motor",
            "target": "1-2cfa"
          },
          {
            "yaw": -2.6404540927282667,
            "pitch": 0.17803248098478974,
            "rotation": 0,
            "type": "next",
            "label": "Regresar al tour",
            "target": "6-lb4"
          },
          {
            "yaw": -4.0404540927282667,
            "pitch": 0.57803248098478974,
            "rotation": 0,
            "type": "next",
            "label": "Regresar al tour",
            "target": "5-lb3"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "1-2cfa",
        "name": "2cfa",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": 0.04161938985525104,
          "pitch": 0.3349804071780831,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": 0.713414352569357,
            "pitch": 0.17853727664704877,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral izquierda",
            "target": "9-2cic"
          },
          {
            "yaw": -0.5644143746079067,
            "pitch": 0.1946248190277764,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral derecha",
            "target": "6-2cdc"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "2-2ctc",
        "name": "2ctc",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": 0.6148929210872307,
          "pitch": 0.5657562185493337,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": 1.3414162915239807,
            "pitch": 0.3015015093738249,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral derecha",
            "target": "6-2cdc"
          },
          {
            "yaw": 0.7415856792667490,
            "pitch": 0.3015015093738249,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista del maletero",
            "target": "3-2cta"
          },
          {
            "yaw": 0.07417550670095174,
            "pitch": 0.3387749838573555,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral izquierda",
            "target": "9-2cic"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "3-2cta",
        "name": "2cta",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": 0.656506490148713,
          "pitch": 0.3963997070100085,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": 1.3414162915239807,
            "pitch": 0.3015015093738249,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral derecha",
            "target": "6-2cdc"
          },
          {
            "yaw": 0.07417550670095174,
            "pitch": 0.3387749838573555,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral izquierda",
            "target": "9-2cic"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "4-2cit",
        "name": "2cit",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": 0.04430451178139627,
          "pitch": 0.0018610314883105161,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": 0.05545754204379527,
            "pitch": -0.11697329111670385,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista interior delatera",
            "target": "5-2cid"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "5-2cid",
        "name": "2cid",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": 0.1678201203840768,
          "pitch": 0.19726933776085076,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": 1.1167981714503803,
            "pitch": 0.18744581929841075,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral derecha",
            "target": "7-2cda"
          },
          {
            "yaw": -0.7535677717901397,
            "pitch": 0.1634913641436242,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral izquierda",
            "target": "8-2cia"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "6-2cdc",
        "name": "2cdc",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": 0.1707331203292739,
          "pitch": 0.408795167410382,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": 1.1423984646101975,
            "pitch": 0.3125914690160556,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista frontal",
            "target": "0-2cfc"
          },
          {
            "yaw": 0.2411455552296502,
            "pitch": 0.517147372647381,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral derecha",
            "target": "7-2cda"
          },
          {
            "yaw": -0.6315727340176984,
            "pitch": 0.21048389452214167,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral tracera",
            "target": "2-2ctc"
          },
          {
            "yaw": 2.7423984646101975,
            "pitch": 0.3125914690160556,
            "rotation": 0,
            "type": "next",
            "label": "Regresar al tour",
            "target": "6-lb4"
          },
        ],
        "infoHotspots": []
      },
      {
        "id": "7-2cda",
        "name": "2cda",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": -0.1584221936425685,
          "pitch": 0.4392034312411326,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": 0.27281684696535535,
            "pitch": 0.40595355768507346,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista interior delantera",
            "target": "5-2cid"
          },
          {
            "yaw": -0.32552138443249135,
            "pitch": 0.3748393858801169,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista interior trasera",
            "target": "4-2cit"
          },
          {
            "yaw": 0.7960169734948437,
            "pitch": 0.2855724640540025,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista frontal",
            "target": "0-2cfc"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "8-2cia",
        "name": "2cia",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": 0.034225556217290176,
          "pitch": 0.5176340341840895,
          "fov": 1.3045156974440075
        },
        "linkHotspots": [
          {
            "yaw": -0.2374599984397392,
            "pitch": 0.40500471771154345,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista interior delatera",
            "target": "5-2cid"
          },
          {
            "yaw": 0.35594716433329765,
            "pitch": 0.4166042437814923,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista interior trasera",
            "target": "4-2cit"
          },
          {
            "yaw": 1.0238926214970263,
            "pitch": 0.29861233390975883,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista trasera",
            "target": "2-2ctc"
          },
          {
            "yaw": -0.6769788079825929,
            "pitch": 0.2918382308185201,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista frontal",
            "target": "0-2cfc"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "9-2cic",
        "name": "2cic",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": -0.21227966124958364,
          "pitch": 0.08526996268395415,
          "fov": 1.12233526732503
        },
        "linkHotspots": [
          {
            "yaw": -0.3821644988593782,
            "pitch": 0.06378527785069998,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral izquierda",
            "target": "8-2cia"
          },
          {
            "yaw": 0.43085800477542513,
            "pitch": -0.07451424327694589,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista tracera",
            "target": "2-2ctc"
          },
          {
            "yaw": -0.9762398929263671,
            "pitch": 0.04598958338115722,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista frontal",
            "target": "0-2cfc"
          }
        ],
        "infoHotspots": []
      },

  //
  //     Tiggo 2 pro
  //

      {
        "id": "0-2pfc",
        "name": "2pfc",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": 0.2068735385666436,
          "pitch": 0.5412375647097001,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": 0.08158111353357,
            "pitch": 0.6093317730525101,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista del motor",
            "target": "1-2pfa"
          },
          {
            "yaw": 0.6625923934941955,
            "pitch": 0.23466329567058608,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral derecha",
            "target": "6-2pdc"
          },
          {
            "yaw": -0.37334482133532276,
            "pitch": 0.17787785519260169,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral izquierda",
            "target": "9-2pic"
          },
          {
            "yaw": 1.6625923934941955,
            "pitch": 0.53466329567058608,
            "rotation": 0,
            "type": "next",
            "label": "Regresar al tour",
            "target": "8-lb6"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "1-2pfa",
        "name": "2pfa",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": 0.1839310822758602,
          "pitch": 0.4429254942177323,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": 0.6670088402297303,
            "pitch": 0.20704512771104788,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral derecha",
            "target": "6-2pdc"
          },
          {
            "yaw": -0.4214239973750562,
            "pitch": 0.22314984728000198,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral izquierda",
            "target": "9-2pic"
          },
          {
            "yaw": 0.008695721508674481,
            "pitch": 0.8250253363382107,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista frontal",
            "target": "0-2pfc"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "2-2ptc",
        "name": "2ptc",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": -0.187958534830166,
          "pitch": 0.2698495658049218,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": -0.12136409282761562,
            "pitch": 0.19148389162609547,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista del maletero",
            "target": "3-2pta"
          },
          {
            "yaw": 0.22567269698307157,
            "pitch": 0.1284801960004014,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral izquierda",
            "target": "9-2pic"
          },
          {
            "yaw": -0.6526882755029995,
            "pitch": 0.14407384665127232,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral derecha",
            "target": "6-2pdc"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "3-2pta",
        "name": "2pta",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": 0.37994519413837224,
          "pitch": 0.4633968405891373,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": 0.32136409282761562,
            "pitch": 0.19148389162609547,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista trasera",
            "target": "2-2ptc"
          },
          {
            "yaw": 0.96567269698307157,
            "pitch": 0.1284801960004014,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral izquierda",
            "target": "9-2pic"
          },
          {
            "yaw": -0.3526882755029995,
            "pitch": 0.14407384665127232,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral derecha",
            "target": "6-2pdc"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "4-2pit",
        "name": "2pit",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": 0.2188374369808308,
          "pitch": 0.1674928339478825,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": 0.2188374369808308,
            "pitch": 0.1674928339478825,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista interior delantera",
            "target": "5-2pid"
          },
          {
            "yaw": 1.1554108490895505,
            "pitch": 0.02206191497375265,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral izquierda",
            "target": "9-2pic"
          },
          {
            "yaw": -0.6435013229473032,
            "pitch": 0.00019799641223272602,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral derecha",
            "target": "6-2pdc"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "5-2pid",
        "name": "2pid",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": 0.2980485338021168,
          "pitch": 0.3715914584876465,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": 1.1950329726025792,
            "pitch": 0.11366757001515637,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral izquierda",
            "target": "9-2pic"
          },
          {
            "yaw": -0.5785016998208192,
            "pitch": 0.2274899039524847,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral derecha",
            "target": "6-2pdc"
          },
          {
            "yaw": 2.9627713506917956,
            "pitch": -0.0981580566219371,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista interior trasera",
            "target": "4-2pit"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "6-2pdc",
        "name": "2pdc",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": -0.005370243852290457,
          "pitch": 0.3889555810567451,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": -0.1301942369273359,
            "pitch": 0.39947167776468717,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral",
            "target": "7-2pda"
          },
          {
            "yaw": 0.9984477665304716,
            "pitch": 0.2021460971986393,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista trasera",
            "target": "2-2ptc"
          },
          {
            "yaw": -0.9466180669491884,
            "pitch": 0.17215979662216796,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista frontal",
            "target": "0-2pfc"
          },
          {
            "yaw": -1.4466180669491884,
            "pitch": 0.27215979662216796,
            "rotation": 0,
            "type": "next",
            "label": "Regresar al tour",
            "target": "8-lb6"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "7-2pda",
        "name": "2pda",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": 0.5423946290813202,
          "pitch": 0.6122786380191236,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": 0.0301942369273359,
            "pitch": 0.39947167776468717,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista interior delantera",
            "target": "5-2pid"
          },
          {
            "yaw": 0.9984477665304716,
            "pitch": 0.2021460971986393,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista trasera",
            "target": "2-2ptc"
          },
          {
            "yaw": -0.4466180669491884,
            "pitch": 0.40215979662216796,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista frontal",
            "target": "0-2pfc"
          },
          {
            "yaw": -1.0466180669491884,
            "pitch": 0.27215979662216796,
            "rotation": 0,
            "type": "next",
            "label": "Regresar al tour",
            "target": "8-lb6"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "8-2pia",
        "name": "2pia",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": 2.8537733724127854,
          "pitch": 0.30894401242918335,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": -3.0345281480135355,
            "pitch": 0.3489397929274176,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista interior delantera",
            "target": "5-2pid"
          },
          {
            "yaw": -2.4519274965820266,
            "pitch": 0.21283179765093152,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista frontal",
            "target": "0-2pfc"
          },
          {
            "yaw": 1.8726610854125525,
            "pitch": 0.19960090173815992,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista trasera",
            "target": "2-2ptc"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "9-2pic",
        "name": "2pic",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "pitch": 0,
          "yaw": 0,
          "fov": 1.5707963267948966
        },
        "linkHotspots": [
          {
            "yaw": -0.028859386529390463,
            "pitch": 0.3412508337309976,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral izquierda",
            "target": "8-2pia"
          },
          {
            "yaw": 0.9858547897649927,
            "pitch": 0.20666855938395656,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista frontal",
            "target": "0-2pfc"
          },
          {
            "yaw": -0.9105901552236535,
            "pitch": 0.1633145415084627,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista trasera",
            "target": "2-2ptc"
          }
        ],
        "infoHotspots": []
      },

  //
  //     Tiggo 7 pro
  //

      {
        "id": "0-7pfc",
        "name": "7pfc",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": 0.10740487704579493,
          "pitch": 0.26612750282830433,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": -0.40134840836437213,
            "pitch": 0.10545233365371232,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral derecha",
            "target": "7-7pdc"
          },
          {
            "yaw": 0.3950751870707805,
            "pitch": 0.10735842846467847,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral izquierda",
            "target": "9-7pic"
          },
          {
            "yaw": -0.04961864871282984,
            "pitch": 0.4092843841332563,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista del motor",
            "target": "1-7pfa"
          },
          {
            "yaw": 1.9,
            "pitch": 0.0092843841332563,
            "rotation": 0,
            "type": "next",
            "label": "Regresar al tour",
            "target": "4-lb2"
          },
          {
            "yaw": -2.54961864871282984,
            "pitch": 0.4092843841332563,
            "rotation": 0,
            "type": "next",
            "label": "Regresar al tour",
            "target": "7-lb5"
          },
          {
            "yaw": -1.04961864871282984,
            "pitch": 0.1092843841332563,
            "rotation": 0,
            "type": "next",
            "label": "Regresar al tour",
            "target": "5-lb3"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "1-7pfa",
        "name": "7pfa",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": 0.11546024282424305,
          "pitch": 0.36680171751192603,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": 0.5922504323490507,
            "pitch": 0.09829122234723542,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral izquierda",
            "target": "9-7pic"
          },
          {
            "yaw": -0.5301378753822021,
            "pitch": 0.09175694918728894,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral derecha",
            "target": "7-7pdc"
          },
          {
            "yaw": 0.08309364595857005,
            "pitch": 0.9034352659475751,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista frontal",
            "target": "0-7pfc"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "2-7ptc",
        "name": "7ptc",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": 0.40708415655196184,
          "pitch": 0.27921764372047875,
          "fov": 1.0047835318292417
        },
        "linkHotspots": [
          {
            "yaw": 0.8172284424981466,
            "pitch": 0.135232908650611,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral derecha",
            "target": "7-7pdc"
          },
          {
            "yaw": -0.0268425413692146,
            "pitch": 0.13514824850794405,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral izquierda",
            "target": "9-7pic"
          },
          {
            "yaw": 0.39924890113400835,
            "pitch": 0.31497581583789724,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista del maletero",
            "target": "3-7pta"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "3-7pta",
        "name": "7pta",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": 0.46617933129515166,
          "pitch": 0.014633956797375447,
          "fov": 1.3045054558447242
        },
        "linkHotspots": [
          {
            "yaw": 0.3994560096480946,
            "pitch": 0.478630787351495,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista trasera",
            "target": "2-7ptc"
          },
          {
            "yaw": 0.856951313564938,
            "pitch": 0.14803411704585123,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral derecha",
            "target": "7-7pdc"
          },
          {
            "yaw": -0.05542002477484509,
            "pitch": 0.1735489079868877,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral izquierda",
            "target": "9-7pic"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "4-7pid",
        "name": "7pid",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": 0.04896662413343833,
          "pitch": 0.029970821133307624,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": 2.775959005664504,
            "pitch": -0.12894592266971472,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista interior trasera",
            "target": "5-7pit"
          },
          {
            "yaw": 1.0100690239124965,
            "pitch": 0.060462484179335974,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral derecha",
            "target": "7-7pdc"
          },
          {
            "yaw": -0.8394091653619711,
            "pitch": 0.01470209483731999,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral izquierda",
            "target": "9-7pic"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "5-7pit",
        "name": "7pit",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": 3.0507779344497035,
          "pitch": 0.04126218020222083,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": 3.1148421642384037,
            "pitch": -0.07136052740666976,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista interior delantero",
            "target": "4-7pid"
          },
          {
            "yaw": -2.3304111933260714,
            "pitch": -0.04438400350704086,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral derecha",
            "target": "7-7pdc"
          },
          {
            "yaw": 2.3323500868921245,
            "pitch": 0.0026577509497300866,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral izquierda",
            "target": "9-7pic"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "6-7pda",
        "name": "7pda",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": -1.4067591550038347,
          "pitch": 0.4318751093581703,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": -0.8303421589428766,
            "pitch": 0.2271546284964181,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista interior delantero",
            "target": "4-7pid"
          },
          {
            "yaw": -1.4809228491592599,
            "pitch": 0.2468128066834705,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista interior trasera",
            "target": "5-7pit"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "7-7pdc",
        "name": "7pdc",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": 0.06477218951421371,
          "pitch": 0.35482488429411063,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": 1.0827050733645862,
            "pitch": 0.13980637570307763,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista frontal",
            "target": "0-7pfc"
          },
          {
            "yaw": 0.07430817381265697,
            "pitch": 0.3725745237792992,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral derecha",
            "target": "6-7pda"
          },
          {
            "yaw": -0.973974511419236,
            "pitch": 0.09476018554475374,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista trasera",
            "target": "2-7ptc"
          },
          {
            "yaw": 1.5827050733645862,
            "pitch": 0.53980637570307763,
            "rotation": 0,
            "type": "next",
            "label": "Regresar al tour",
            "target": "5-lb3"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "8-7pia",
        "name": "7pia",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": 0.38531499640182076,
          "pitch": 0.2140186211556312,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": -0.41780365722551593,
            "pitch": 0.11371121060340172,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista frontal",
            "target": "0-7pfc"
          },
          {
            "yaw": 1.0134629971097588,
            "pitch": 0.13409000316649333,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista trasera",
            "target": "2-7ptc"
          },
          {
            "yaw": -0.08190825751377417,
            "pitch": 0.19167033470195172,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista interior delantero",
            "target": "4-7pid"
          },
          {
            "yaw": 0.38758746479008543,
            "pitch": 0.21401809662719984,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista interior trasera",
            "target": "5-7pit"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "9-7pic",
        "name": "7pic",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": -0.27114233187324643,
          "pitch": 0.25814091801040107,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": -0.20538647827292777,
            "pitch": 0.34604031705466554,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral izquierda",
            "target": "8-7pia"
          },
          {
            "yaw": 0.7153652268325619,
            "pitch": 0.16268619726509748,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista trasera",
            "target": "2-7ptc"
          },
          {
            "yaw": -1.2194264802819,
            "pitch": 0.19378297469756767,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista frontal",
            "target": "0-7pfc"
          }
        ],
        "infoHotspots": []
      },


  //
  //     Tiggo 4 Pro 1.5
  //

      {
        "id": "0-4pfc",
        "name": "4pfc",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": 0.2054118273501082,
          "pitch": 0.37406732915027163,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": 0.09414146916575739,
            "pitch": 0.47114990326257455,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista del motor",
            "target": "1-4pfa"
          },
          {
            "yaw": 0.5872049557448786,
            "pitch": 0.1307737698560345,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral izquierda",
            "target": "6-4pic"
          },
          {
            "yaw": -0.18637299985814337,
            "pitch": 0.1089479349215825,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral derecha",
            "target": "5-4pdc"
          },
          {
            "yaw": -3.18637299985814337,
            "pitch": 0.5089479349215825,
            "rotation": 0,
            "type": "next",
            "label": "Regresar al lobby",
            "target": "5-lb3"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "1-4pfa",
        "name": "4pfa",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": 0.46585267779942185,
          "pitch": 0.39453867552167665,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": 0.9977623004885192,
            "pitch": 0.2291146275077427,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral izquierda",
            "target": "6-4pic"
          },
          {
            "yaw": -0.273139599055245,
            "pitch": 0.21414600798488337,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral derecha",
            "target": "5-4pdc"
          },
          {
            "yaw": 0.6067298007355788,
            "pitch": 0.9380829954492285,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista frontal",
            "target": "0-4pfc"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "2-4ptc",
        "name": "4ptc",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": 0.2577746144803168,
          "pitch": 0.14702148757647748,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": 0.3014473402411504,
            "pitch": 0.3074507855554742,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral",
            "target": "3-4pta"
          },
          {
            "yaw": 0.7533692454528556,
            "pitch": 0.17473646651765762,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral derecha",
            "target": "5-4pdc"
          },
          {
            "yaw": -0.27836105138506895,
            "pitch": 0.14199775448988206,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral izquierda",
            "target": "6-4pic"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "3-4pta",
        "name": "4pta",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": 0.10606231608273653,
          "pitch": 0.36848423468534364,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": 0.77991884818376,
            "pitch": 0.26573132046889825,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral derecha",
            "target": "5-4pdc"
          },
          {
            "yaw": -0.6416488601915304,
            "pitch": 0.21857113153282448,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral izquierda",
            "target": "6-4pic"
          },
          {
            "yaw": -0.0070612696541818565,
            "pitch": 0.8190901255557286,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista trasera",
            "target": "2-4ptc"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "4-4pit",
        "name": "4pit",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": 0.2376332904638474,
          "pitch": 0.07258022804408881,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": 0.9898098430584561,
            "pitch": 0.035178610367919916,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral derecha",
            "target": "5-4pdc"
          },
          {
            "yaw": -0.5871318860211439,
            "pitch": 0.029684727814045075,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral izquierda",
            "target": "6-4pic"
          },
          {
            "yaw": 0.21085321782639,
            "pitch": 0.10805612475927795,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista interior derecha",
            "target": "7-4pid"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "5-4pdc",
        "name": "4pdc",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "pitch": 0,
          "yaw": 0,
          "fov": 1.5707963267948966
        },
        "linkHotspots": [
          {
            "yaw": 1.4019456998638972,
            "pitch": 0.1648766426034456,
            "rotation": 0,
            "type": "next",
            "label": "Regresar el tour",
            "target": "5-lb3"
          },
          {
            "yaw": 1.1019456998638972,
            "pitch": 0.1648766426034456,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista frontal",
            "target": "0-4pfc"
          },
          {
            "yaw": -0.9726458342797777,
            "pitch": 0.13087598268533895,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista trasera",
            "target": "2-4ptc"
          },
          {
            "yaw": 0.21561598856226638,
            "pitch": 0.3988248508242229,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista interior derecha",
            "target": "7-4pid"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "6-4pic",
        "name": "4pic",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "pitch": 0,
          "yaw": 0,
          "fov": 1.5707963267948966
        },
        "linkHotspots": [
          {
            "yaw": -1.4068291669082967,
            "pitch": 0.30139539475558088,
            "rotation": 0,
            "type": "next",
            "label": "Regresar el tour",
            "target": "5-lb3"
          },
          {
            "yaw": -1.0068291669082967,
            "pitch": 0.20139539475558088,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista frontal",
            "target": "0-4pfc"
          },
          {
            "yaw": 1.2499746508617786,
            "pitch": 0.16340482535778733,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista trasera",
            "target": "2-4ptc"
          },
          {
            "yaw": 0.05732375225146846,
            "pitch": 0.4054004742520423,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista interior derecha",
            "target": "7-4pid"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "7-4pid",
        "name": "4pid",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": 0.17050524231022202,
          "pitch": 0.08002435399732022,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": -0.7284838772918398,
            "pitch": 0.056813680990554616,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral izquierda",
            "target": "6-4pic"
          },
          {
            "yaw": 1.1510428574678606,
            "pitch": 0.02142823718303788,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral derecha",
            "target": "5-4pdc"
          },
          {
            "yaw": 2.8035695302969375,
            "pitch": -0.1074591130362812,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral",
            "target": "4-4pit"
          }
        ],
        "infoHotspots": []
      },

  //
  //     Tiggo 4 Pro 2.0
  //

      {
        "id": "0-42pfc",
        "name": "42pfc",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": -0.08726646259971993,
          "pitch": 0.36290114022041564,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": 0.34435575457131407,
            "pitch": 0.07625224973534728,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral derecha",
            "target": "5-42pdc"
          },
          {
            "yaw": -0.45420192855715946,
            "pitch": 0.08411686187336542,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral izquierda",
            "target": "7-42pic"
          },
          {
            "yaw": -0.0628174933649035,
            "pitch": 0.43814304662716985,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista del motor",
            "target": "1-42pfa"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "1-42pfa",
        "name": "42pfa",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": 0.24703121720535925,
          "pitch": 0.4931733444020985,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": 0.9399942768704008,
            "pitch": 0.19516766588900403,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral derecha",
            "target": "5-42pdc"
          },
          {
            "yaw": -0.3956714972909232,
            "pitch": 0.20456687892276904,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral izquierda",
            "target": "7-42pic"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "2-42ptc",
        "name": "42ptc",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": 0.17050524231022202,
          "pitch": 0.4336203367761833,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": -0.11691079609206412,
            "pitch": 0.6215687511496242,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista del maletero",
            "target": "3-42pta"
          },
          {
            "yaw": 0.5634924244355695,
            "pitch": 0.19718999765529688,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral izquierda",
            "target": "7-42pic"
          },
          {
            "yaw": -0.5315725495092245,
            "pitch": 0.18020455745412,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral derecha",
            "target": "5-42pdc"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "3-42pta",
        "name": "42pta",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": 0.1409689011226245,
          "pitch": 0.2679885343166113,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": 0.7193286174573608,
            "pitch": 0.2920803328101833,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral izquierda",
            "target": "7-42pic"
          },
          {
            "yaw": -0.5637985832220576,
            "pitch": 0.2009774147885608,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral derecha",
            "target": "5-42pdc"
          },
          {
            "yaw": -0.11081546646842888,
            "pitch": 0.7755689306330105,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista trasera",
            "target": "2-42ptc"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "4-42pda",
        "name": "42pda",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": -0.022823536372234443,
          "pitch": 0.2698495658049218,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": 0.9036379468917595,
            "pitch": 0.1674357434023186,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista trasera",
            "target": "2-42ptc"
          },
          {
            "yaw": -0.8615653099781824,
            "pitch": 0.18281301399720817,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista frontal",
            "target": "0-42pfc"
          },
          {
            "yaw": -0.27339530719746286,
            "pitch": 0.29638542078047614,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista interior delantera",
            "target": "8-42pid"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "5-42pdc",
        "name": "42pdc",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": -0.06712804815363071,
          "pitch": 0.23448996752703266,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": 0.8621514888121222,
            "pitch": 0.1439581869128972,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista trasera",
            "target": "2-42ptc"
          },
          {
            "yaw": -0.8035880629537555,
            "pitch": 0.12694026120773572,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista frontal",
            "target": "0-42pfc"
          },
          {
            "yaw": -0.1734653947218181,
            "pitch": 0.3219028302158371,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral derecha",
            "target": "4-42pda"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "6-42pia",
        "name": "42pia",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": -0.037631705152413986,
          "pitch": 0.46531129960600737,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": -0.05240745316848816,
            "pitch": 0.44750456215552603,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista interior delantera",
            "target": "8-42pid"
          },
          {
            "yaw": 1.0034377632855023,
            "pitch": 0.21356885542832416,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista frontal",
            "target": "0-42pfc"
          },
          {
            "yaw": -1.0851309330210697,
            "pitch": 0.191519449069526,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista trasera",
            "target": "2-42ptc"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "7-42pic",
        "name": "42pic",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": 0.18527341290402077,
          "pitch": 0.3963997070099943,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": 1.1962909027852309,
            "pitch": 0.2121166112421662,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista frontal",
            "target": "0-42pfc"
          },
          {
            "yaw": -0.8563303720472675,
            "pitch": 0.14963952084581678,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista trasera",
            "target": "2-42ptc"
          },
          {
            "yaw": 0.11747000067735947,
            "pitch": 0.41331554209878973,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral",
            "target": "6-42pia"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "8-42pid",
        "name": "42pid",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": 0.1047197324842628,
          "pitch": 0.16377077097126502,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": 0.947842857550226,
            "pitch": -0.04863512822695881,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral izquierda",
            "target": "7-42pic"
          },
          {
            "yaw": -0.6694450040777937,
            "pitch": 0.05109441386990454,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral derecha",
            "target": "5-42pdc"
          },
          {
            "yaw": 2.7037606119359143,
            "pitch": 0.12341810088210181,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista interior trasera",
            "target": "9-42pit"
          }
        ],
        "infoHotspots": []
      },
      {
        "id": "9-42pit",
        "name": "42pit",
        "levels": [
          {
            "tileSize": 256,
            "size": 256,
            "fallbackOnly": true
          },
          {
            "tileSize": 512,
            "size": 512
          },
          {
            "tileSize": 512,
            "size": 1024
          },
          {
            "tileSize": 512,
            "size": 2048
          }
        ],
        "faceSize": 1440,
        "initialViewParameters": {
          "yaw": 0.0469896337075415,
          "pitch": 0.43920343124112193,
          "fov": 1.3715802068843215
        },
        "linkHotspots": [
          {
            "yaw": 0.8060322367401298,
            "pitch": 0.2542840312242518,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral izquierda",
            "target": "7-42pic"
          },
          {
            "yaw": -0.7355090045651984,
            "pitch": 0.29412828585235395,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista lateral derecha",
            "target": "5-42pdc"
          },
          {
            "yaw": 0.061248005929432026,
            "pitch": 0.37043991126481046,
            "rotation": 0,
            "type": "into",
            "label": "Ir a vista interior delantera",
            "target": "8-42pid"
          }
        ],
        "infoHotspots": []
      }
    ],
    "name": "Project Title",
    "settings": {
      "mouseViewMode": "drag",
      "autorotateEnabled": false,
      "fullscreenButton": false,
      "viewControlButtons": false
    }
  };
