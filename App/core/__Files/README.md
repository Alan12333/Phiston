# Files

Files es una librería básica para PHP que facilita la manipulación de archivos, permitiendo la subida y eliminación de los mismos de manera sencilla.

## Características

- Fácil de implementar y utilizar.
- Permite subir archivos a través de formularios web.
- Proporciona opciones para configurar restricciones de tamaño y tipo de archivo.
- Soporta la generación de nombres aleatorios para los archivos subidos.
- Permite eliminar archivos de forma sencilla.

## Instalación
1. Descarga el archivo Files.php.
2. Incluye el archivo en tu proyecto:

```
<?php
  require_once("File/File.php");
?>
```

## Uso

La función principal UploadFile se utiliza para subir archivos, y requiere como parámetros el archivo a subir, la ruta de destino, opciones adicionales y una bandera para indicar si se desea generar un nombre aleatorio para el archivo.

Ejemplo básico:

```
<?php
 
  $filename = Files::setFile("archivo"); //Nombre del archivo

  Files::UploadFile($filename, "source/files/"); //Se ejecuta la subida del archivo
?>
```


Para eliminar un archivo, utiliza la función DeleteFile() pasando la ruta del archivo:


```
<?php
  $url = "source/files/archivo1.jpg;
  Files::DeleteFile($url); //Se elimina el archivo
?>
```

## Ejemplo completo

```
<?php
$archivo = Files::SetFile("archivo");

$options = [
    "min_size"=>0.010,
    "max_size"=>20,
    "restricttype"=>[
        "doc_type"=>"all",
        "doc_extension"=>"all"
    ]
]

$ruta = "Files/Save/";

$resultadoSubida = Files::UploadFile($archivo,$ruta,$options, true);

if($resultadoSubida['status']==="success")
{
    echo $resultadoSubida['status']; //pintara success
    echo $resultadoSubida['name']; // regresa el nombre aleatorio  generado y la extension del archivo subido 
}
else
{
    echo "Error ". $resultadoSubida["status"]; // si no cumple con las opciones pasadas mostrara el mensaje de error
}

?>
```

## Contribuciones

Se agradecen las contribuciones para mejorar la biblioteca Files. Si deseas contribuir, envía tus mejoras por correo electrónico junto con tu nombre para recibir el reconocimiento correspondiente.

## Licencia

Esta biblioteca se distribuye bajo la licencia GNU.

## Contacto
Autor: Alan Guzmán.
correo: alan.guzman@baniradigital.com
