<body>
    <div class="cont-100 bg-black h-100">
        <br><br><br>
        <h1 class=" ts-1 c-white text-center">PHISTON</h1><br>
        <p class="ts-5 c-white text-center">Mini framework creado para php 8.0</p>
        <br><br><br>
        <!-- Instancia de Vue -->
        <div id="app" v-cloak>
            <p class="text-12 text-center c-white">Contador en vue</p>
            <br>
            <h2 class="text-center px16 c-primary">{{contador}}</h2><br>
            <button class="button bg-success c-white  d-block mr-auto pad-4 border-rad-1"
                @click="Count">Click para contar</button>
        </div>
    </div>
</body>