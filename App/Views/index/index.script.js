// Estructura base de Vue

const app = Vue.createApp({
    data() {
        return {
            //Declaracion de variables por ejemplo 
            contador:0
        }
    },
    methods: {
        //declaracion de metodos
        Count(){
            this.contador ++;
        },
        Alerta()
        {
            alert("cargo antes de ejecución");
        }
    },
    mounted() {
        //Se cargan las funciones previas al contenido de la pagina
        // this.Alerta();
        document.getElementById('app').setAttribute('v-cloak', '');
    },
}).mount("#app");
