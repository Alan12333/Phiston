<?php
//Para incluir una dependencia local ubicada en App/public/dep/ se usa la libreria include_dep('ruta');
include_dep("vue3.js");
include_dep("axios.js");


//Si quieres dependencias externas que vengan de un CDN y sean de Javascript se usan con esta funcion ext_js('url');
// ext_js('<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>');

//Si quieres dependencias que vengan de un CDN y sean de CSS se usa la funcion ext_css('url);
// ext_css('<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">');
?>
