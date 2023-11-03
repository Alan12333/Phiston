<?php
/**
 * 
 * ******************************************************************
 * Title: Files Upload 2023
 * 
 * Description: Clase para la manipulacion de archivos en php, subir, limitar, descargar y eliminar.
 * 
 * Version: 1.0.1
 * autor: Alan Guzmán
 * mail: alan.guzman12333@gmail.com
 * 
 * *******************************************************************
 */

class FilesUpload
{
    /**
     * 
     * opciones principales para las rutas
     * 
     * @var string[]
     */
    protected $defaultoptions = [
        "min_size"=>0.001,
        "max_size"=>50,
        "replace" => true,
        "restricttype" => [
            "doc_type"=>"all",
            "doc_extension" => "all"
            ]
        ];

    /**
     * 
     * Ruta por defecto en phiston
     * 
     * 
     * @var string 
     */
    protected $rute="App/Resources/";
    
    /**
     * 
     * Ttipos de documentos aceptados
     * 
     * @var string[]
     */
    protected $docs=["document","text","video","image","sound", "compress","all"];

    /**
     * Tipos de extensiones permitidas
     * 
     * @var string[]
     */
    protected $extensions = [
        "document"=>[
            "xlsx",
            "xlsm",
            "xlsb",
            "xltx",
            "xltm",
            "xls",
            "xlt",
            "xml",
            "xlam",
            "xla",
            "xlw",
            "xlr",
            "doc",
            "pdf",
            "ptt"
        ],
        "text"=>[
            "txt",
            "bat",
        ],
        "image"=>[
            "iso",
            "dmg",
            "webp",
            "png",
            "jpeg",
            "jpg",
            "bpm"
        ],
        "compress"=>[
            "rar",
            "zip"
        ],
        "sound"=>[
            "mp3",
        ],
        "Video"=>[
            "mp4",
            "mpeg",
            "avi"
        ], 
    ];

    /**
     * 
     * Variable para guardar el documento
     * 
     * @var string[]
     * 
     */
    protected $file = [];

    /**
     * 
     * Variable para los tipo de errores
     */
    protected $Error_Type;

    /**
     * Variable para identificar si el se reemplazara el archivo
     */
    protected $replace = true;

    /**
     * 
     * Toma un arreglo de archivos, la ruta o da la que es por defecto y las opciones la scuales son:
     * 
     * 
     * "min_size" => 5, el tamaño minimo MB
     * 
     * "max_size" => 10, el tamaño maximo MB
     * 
     * "restrictype" => [
     * 
     *      "doc_type" => "doc" // Tipo de documento, si es txt, doc, img
     * 
     *      "doc_extension" => "pdf" //Extension del archivo, pdf, xlsx, xlm, doc, ptt, png, webp....
     * 
     *  ]
     * 
     * 
     * 
     */
    public function UploadFile($files=[], $rute="",$options=[],$randname=false)
    {
        if(is_array($rute))
        {
            $this->DefineRoute("");
            $this->file = $files;
            return $this->UploadFiles($rute, $randname);
        }
        else
        {
            $this->DefineRoute($rute);
            if($this->ValidateRoute())
            {
                $this->file = $files;
                return $this->UploadFiles($options, $randname);
            }
            else
            {
                return $this->Error_Type;
            }
        }
    }

    private function UploadFiles($options, $rand)
    {
        if($this->CheckOptions($options) == true)
        {
            return $this->ConstructRute($rand);
        }
        else
        {
            return $this->Error_Type;
        }
    }

    public function DeleteFile($file)
    {
        if(is_string($file))
        {
            return $this->BrockenRute($file);
        }
        else
        {
            return $this->Error_Type = ["status"=>"Ruta del archivo vacia"];
        }
    }

    
    private function BrockenRute($rute)
    {
        $array = explode("/",$rute);
        $name="";
        if(count($array) > 1)
        {
            $name = $array[count($array)-1];
        }
        else
        {
            return $this->Error_Type = ["status"=>"tipo de entrada no valida, intenta con '/' "];
        }
        if(file_exists($rute))
        {
            $propiedades = stat($rute);
            if(unlink($rute))
            {
                $newobject = [
                    "name"=>$name,
                    "size"=>$propiedades["size"],
                    "route"=>$rute,
                    "status"=>"complete",
                ];
                return $newobject;
            }
            else
            {
                $error = error_get_last();
                return $this->Error_Type=["status"=>"No se puede eliminar el archivo. ".$error];
            }
        }
        else
        {
            return $this->Error_Type=["status"=>"No se encuentra el archivo"];
        }
    }

    private function CheckOptions($options = [])
    {
        if($this->file["name"] != "")
        {
            $min=false;$max=false;$type=false;
            //Verifica si el arreglo pasado por parámetros tiene alguna opción
            if(count($options) >=1 )
            {
                if(isset($options['replace']))
                {
                    $this->replace = $options['replace'];
                }
                //Valida las 3 opciones minsize, maxsize y el tipo de dato
                if(isset($options["min_size"])  && isset($options["max_size"])  && isset($options["restricttype"]))
                {
                    
                    //Valida primero el tipo de dato, si es de todo tipo de dato se envia como all ambos parametros en el arreglo
                    if($this->ValidateDataType($options["restricttype"]["doc_type"], $options["restricttype"]["doc_extension"]) === true)
                    {
                        //Valida que se cumpla con el requisito de no exceder el tamaño máximo definido
                        if($this->CheckMaxSize($options["max_size"]) == true)
                        {
                            //Valida que se cumpla con el requisito de no estar por debajo del tamaño minio definido
                            if($this->CheckMinSize($options["min_size"]) == true)
                            {
                                return true;
                            }
                            else
                            {
                                $this->Error_Type = "las variables existen pero el tamaño del valor mínimo no cumple";
                                return false;
                            }
                        }
                        else
                        {
                            $this->Error_Type = "las variables existen pero el tamaño del valor mínimo no cumple";
                            return false;
                        }
                    }
                    else
                    {
                        $this->Error_Type = "las variables existen pero las restricciones de archivo no cumplen";
                        return false;
                    }
                }

                /**
                 * Si solo entra uno o algunos de los elementos en el arreglo se analiza cual fue
                 */

                //Se pregunta si el elemento es min_size si es asi se guarda el valor en la variable $min
                if(isset($options["min_size"]))
                {
                    if($this->CheckMinSize($options["min_size"]) == true)
                    {
                        $min =  true;
                    }
                    else
                    {
                        $this->Error_Type = "No se cumple con el valor mínimo";
                        $min = false;
                    }
                }

                //Se pregunta si el elemento es max_size si es asi se guarda el valor en la variable $max
                if(isset($options["max_size"]))
                {
                    if($this->CheckMaxSize($options["max_size"]) == true)
                    {
                        $max =  true;
                    }
                    else
                    {
                        $this->Error_Type = ["status"=>"No se Cumple con el Valor Máximo"];
                        $max = false;
                    }
                }

                //Se pregunta si el elemento es restricttype si es asi se guarda el valor en la variable $type
                if(isset($options["restricttype"]))
                {
                    if($this->ValidateDataType($options["restricttype"]["doc_type"], $options["restricttype"]["doc_extension"]) === true)
                    {
                        $type =  true;
                    }
                    else
                    {
                        $this->Error_Type = ["status"=>"No se cumple con las restricciones de archivo"];
                        $type = false;
                    }
                }

                //Se hace un escaneo y comprobacion de las variables $min, $max y $type, si se cumplen algunas o una de estas retorna true
                return $this->Combinations($min,  $max,  $type, $options);
            }
            else //Si el arreglo viene vació entonces toma las opciones por defecto
            {
                if($this->ValidateDataType($this->defaultoptions["restricttype"]["doc_type"], $this->defaultoptions["restricttype"]["doc_extension"]) === true)
                {
                    if($this->CheckMaxSize($this->defaultoptions["max_size"]) == true)
                    {
                        if($this->CheckMinSize($this->defaultoptions["min_size"]) == true)
                        {
                            return true;
                        }
                        else
                        {
                            $this->Error_Type = ["status"=>"las variables existen pero el tamaño del valor mínimo no cumple"];
                            return false;
                        }
                    }
                    else
                    {
                        $this->Error_Type = ["status"=>"las variables existen pero el tamaño del valor máximo no cumple"];
                        return false;
                    }
                }
                else
                {
                    $this->Error_Type = ["status"=>"las variables existen pero las restricciones de archivo no cumplen"];
                    return false;
                }         
            }
        }
        else
        {
            $this->Error_Type=["status"=>"No hay archivos que subir"];
            return false;
        }
    }


    private function Combinations($min,  $max,  $restrict, $options)
    {
        if($min === true && $max === true)
        {
            return true;
        }
        else if($min===true && $restrict === true)
        {
            return true;
        }
        else if($max===true && $restrict === true)
        {
            return true;
        }
        else if($max === true)
        {
            if(!isset($options['min_size']))
            {
                $minsize = 0.001;
            }
            $filezise = number_format($this->file["size"] / (1024 * 1024),3);
            if($filezise >= $minsize)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else if($min === true)
        {
            $filezise = number_format($this->file["size"] / (1024 * 1024),3);
            if(!isset($options['max_size']))
            {
                $maxsize = 50;
            }
            if($filezise <= $maxsize)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else if($restrict === true)
        {
            return true;
        }
        else if(isset($options['replace']))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    private function ValidateDataType($file_type, $extension)
    {
        if($file_type === "all" && $extension === "all")
        {
            return true;
        }
        else
        {
            foreach($this->extensions as $type => $key)
            {
                if($type === $file_type)
                {
                    foreach($key as $exten)
                    {
                        if($extension === $exten)
                        {
                            $array = explode(".",$this->file['name']);
                            if($array[1] === $exten)
                            {
                                return true;
                            }
                        }
                    }
                }
            }
        }
        return false;
    }

    private function CheckMaxSize($max)
    {
        $filezise = number_format($this->file["size"] / (1024 * 1024),3);
        if($max >= $filezise)
        {
            
            return true;
        }
        else
        {
            return false;
        }
    }
    private function CheckMinSize($min)
    {
        $filezise = number_format($this->file["size"] / (1024 * 1024),3);
        if($min <= $filezise)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    private function DefineRoute($rute)
    {
        if($rute != "")
        {
            $this->rute = $rute;
        }
    }

    private function ConstructRute($randname)
    {
        $nuevaruta = "";
        $name = "";
        if($randname == true)
        {
            $newname = $this->DefineNameRandom();
            $nametype = explode(".",$this->file['name']);
            $name = $newname.".".$nametype[1];
            $nuevaruta = $this->rute.$name;
        }
        else
        {
            $name = $this->file['name'];
            $nuevaruta = $this->rute.$this->file['name'];
            if($this->replace === false)
            {
                if(file_exists($nuevaruta))
                {
                    $newname = $this->DefineNameRandom();
                    $nametype = explode(".",$this->file['name']);
                    $name = $this->file['name']."_".$newname.".".$nametype[1];
                    $nuevaruta = $this->rute.$name;
                }
            }
        }
        if(move_uploaded_file($this->file["tmp_name"], $nuevaruta))
        {
            $newobject = [
                "name"=>$name,
                "size"=>$this->file["size"],
                "route"=>$nuevaruta,
                "status"=>"success",
                "Error"=>$this->file["error"],
            ];
            return $newobject;
        }
        else
        {
            $this->Error_Type = ["status"=>"La ruta especificada no esta correcta"];
            return false;
        }
    }

    private function DefineNameRandom()
    {
        $letras = ["a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z",
            "A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","1","2",
            "3","4","5","6","7","8","9","0"
        ];
        $finalletter = "";
        for($i=0; $i<15; $i++)
        {
            $random = rand(0,60);
            $finalletter.=$letras[$random];
        }
        return $finalletter;
    }

    private function ValidateRoute()
    {
        if(file_exists($this->rute))
        {
            return true;
        }
        else
        {
            $this->Error_Type = ["status"=>"La ruta es incorrecta o no existe"];
            return false;
        }
    }
}