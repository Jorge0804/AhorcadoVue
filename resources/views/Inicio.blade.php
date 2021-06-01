<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Ahorcado</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>

    <!-- Styles -->
    <style>
        body{
            background-color: #282525;
        }
        #app{
            display: inline-block;
        }
        #d1{
            float: left;
            width: 450px;
            text-align: center;
            height: 600px;
            margin: 20px;
        }
        #d2{
            text-align: center;
            float: right;
            width: 750px;
            height: 600px;
            margin: 10px;
        }
        #cont_corazon{
            position: relative;
            display: inline-block;
            text-align: center;
            vertical-align: center;
            height: 100%;
        }
        img{
            width: 300px;
            display: block;
            margin-top: 180px;
        }
        #num_vidas{
            position: absolute;
            top: 52%;
            color: white;
            font-size: 150px;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        input{
            width: 140px;
            height: 150px;
            margin-top: 80px;
            color: white;
            background-color: rgba(55, 139, 9, 0.07);
            text-align: center;
            border-style: solid;
            border-color: #247208;
            border-radius: 20px;
            font-size: 150px;
        }
        #palabra{
            margin-top: 80px;
        }
        #letra{
            border-style: solid;
            border-color: blue;
            margin-right: 10px;
            background-color: rgba(0, 0, 255, 0.13);
            border-radius: 20px;
            font-size: 40px;
            width: 90px;
            color: #8d8c8c;
            padding: 10px;
            height: 90px;
        }
        #cont_intentos{
            margin-top: 60px;
        }
        #intento{
            color: white;
        }
        #l_intento{
            margin: 5px;
            border-style: solid;
            background-color: rgba(139, 0, 0, 0.14);
            border-color: #db0707;
            border-radius: 10px;
            border-width: 2px;
            font-size: 30px;
            color: white;
            padding: 6px;
        }
    </style>
</head>
<body>
    <div id="app">
        <div id="d1">
            <div id="cont_corazon">
                <img src="corazon.png" alt="">
                <label id="num_vidas" v-text="vidas"></label>
            </div>
        </div>
        <div id="d2">
            <input type="text" v-model="entrada" maxlength="1">
            <div id="palabra">
                <label id="letra" v-text="Validar(letra)" v-for="(letra, indice) of letras" ref="indice">@{{letra.letra}}</label>
                <div id="cont_intentos">
                    <h1 id="intento">Intentos:</h1>
                    <div>
                        <label id="l_intento" v-for="(intento, indice) of intentos">@{{ intento }}</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        new Vue({
            el: '#app',
            data: {
                palabras:[
                    'VACA',
                    'ELEFANTE',
                    'CARTA',
                    'LAPIZ',
                    'NARANJA',
                    'MANZANA',
                    'JORGE',
                    'AGUA',
                    'LORATADINA',
                    'CHICHARRON',
                    'AMARILLO',
                    'SANDWICH',
                    'DESODORANTE',
                    'CELULAR',
                    'MESA',
                    'SILLA',
                    'ARBOL',
                    'PUERTA',
                    'SERVILLETA',
                    'TIERRA'
                ],
                letras: [],
                entrada: '',
                vidas: 6,
                palabra: '',
                intentos: []
            },
            created: function (){
                this.SeleccionarPalbra();
                this.DarPista();
            },
            watch:{
              entrada: function(){
                  if (this.entrada){
                      var n_letra = this.entrada.toUpperCase();
                      if(!this.letras.find(el => el.letra == n_letra)){
                          this.ValidarIntento(n_letra);
                      }
                  }
              }
            },
            methods: {
                SeleccionarPalbra: function(){
                    var rand = Math.floor(Math.random() * (this.palabras.length - 0)) + 0;
                    var arr = [];
                    this.palabra = this.palabras[rand];
                    this.palabra.split('').forEach(function(value, index){
                        arr.push({letra: value, enc: false});
                    });
                    this.letras = arr;
                },
                RestarVida: function(){
                    this.vidas = this.vidas -1;
                    if (this.vidas == 0){
                        alert('Lo siento, perdiste el juego :c ' +
                            '(La palabra correcta era: '+this.palabra+')');
                        location.reload();
                    }
                },
                ValidarIntento: function(n_letra){
                    if (!this.intentos.includes(n_letra)){
                        this.intentos.push(n_letra);
                        this.RestarVida();
                    }
                },
                DarPista: function () {
                    var pos = Math.floor(Math.random() * (this.letras.length - 0)) + 0;
                    this.letras[pos].enc = true;
                },
                ValidarVictoria: function(){
                    console.log(!this.letras.find(el => el.enc == false));
                    if(!this.letras.find(el => el.enc == false)){
                        alert('Felicidades! Ya ganaste :D');
                        location.reload();
                    }
                },
                Validar: function (l){
                    if (l.enc){
                        return l.letra;
                    } else if (this.entrada){
                        var n_letra = this.entrada.toUpperCase();
                        if(this.letras.find(el => el.letra == n_letra)){
                            if (n_letra == l.letra || l.enc){
                                l.enc = true;
                                this.ValidarVictoria();
                                return l.letra;
                            } else{
                                return '__';
                            }
                        } else {
                            return '__';
                        }
                    } else{
                        return '__';
                    }
                }
            }
        })
    </script>
</body>
</html>
