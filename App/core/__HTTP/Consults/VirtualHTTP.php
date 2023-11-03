<?php

class VIRTUALHTTP
{
    public function GET($model, DB $con, $special="")
    {
        $cmd = "SELECT * FROM $model[model_name]";
        $res = [];
        $res_consulta = mysqli_query($con->Con(),$cmd);
		if($special=="")
        {
            while($row=mysqli_fetch_assoc($res_consulta))
            {
                array_push($res,$row);
            }
            return $res;
        }
        else if($special=="DESC")
        {

            return  mysqli_query($con->Con(),"SELECT * FROM $model[model_name]  ORDER BY id DESC");
        }
        else if($special == "ASC")
        {
            return  mysqli_query($con->Con(),"SELECT * FROM $model[model_name]  ORDER BY id ASC");
        }
        else if($special=="MAX")
        {
            $res_consulta = mysqli_query($con->Con(),"SELECT * FROM $model[model_name] ORDER BY id DESC LIMIT 1")->fetch_assoc();
            return $res_consulta['id'];
        }
        else if($special=="COUNT")
        {
            return $res_consulta->num_rows;
        }
    }

    public function GETBYARG($model,$id, $arg, DB $con, $special="")
    {
        $res=array();
        $cmd1 = "SELECT * FROM $model[model_name] WHERE $arg = '$id'";
        if($special=="")
        {
            $res_consulta = mysqli_query($con->Con(),$cmd1);
            while($row=mysqli_fetch_assoc($res_consulta))
            {
                array_push($res,$row);
                foreach($model as $clave => $valor)
                {
                    if($clave=="model_name" || $clave=="model")
                    {

                    }
                    else
                    {
                        $model[$clave] = $row[$clave];
                    }
                }
            }
            return $res;
        }
        else if($special=="COUNT")
        {
            $res_consulta = mysqli_query($con->Con(),$cmd1);
            return $res_consulta->num_rows;
        }
        else if($special=="%")
        {
            $cmd = "SELECT * FROM $model[model_name] WHERE $arg LIKE '%$id%'";
            $res_consulta = mysqli_query($con->Con(),$cmd);
            while($row=mysqli_fetch_assoc($res_consulta))
            {
                
                array_push($res,$row);
                foreach($model as $clave => $valor)
                {
                    if($clave=="model_name" || $clave=="model")
                    {

                    }
                    else
                    {
                        $model->$clave = $row[$clave];
                    }
                }
            }
            return $res;
        }
        else if($special=="MAX")
        {
            return  mysqli_query($con->Con(),"SELECT * FROM $model[model_name] WHERE $arg = '$id' ORDER BY $arg DESC LIMIT 1");
        }
        else if($special=="DESC")
        {
            return  mysqli_query($con->Con(),"SELECT * FROM $model[model_name] WHERE $arg = '$id' ORDER BY $arg DESC");
        }
        else if($special == "ASC")
        {
            return  mysqli_query($con->Con(),"SELECT * FROM $model[model_name] WHERE $arg = '$id' ORDER BY $arg ASC");
        }
        else if($special=="JOIN")
        {
            $cmd = "SELECT * FROM $model[model_name] $arg";
            if($id==="")
            {
                return "Debes ingresar un ID";
            }
            else
            {
                
                $res_consulta = mysqli_query($con->Con(),$cmd);
                while ($row = mysqli_fetch_assoc($res_consulta)) {
                    array_push($res,$row);
                }
                return json_encode($res);
            }
        }

    }
    public function VirtualPost($model, DB $con, $arg)
    {
        $res = array();
        $variables="";
        $valores="";
        $cont =0;
        $newcont =0;
        foreach($model as $clave => $valor)
        {
            if ($clave != "model_name" && $clave != "id" && $clave != "model") {
                $cont += 1;
            }
        }
        foreach($model as $clave => $valor) {
            if($clave!="model_name" && $clave!="id" && $clave != "model")
            {
                $newcont +=1;
                if($cont==$newcont)
                {
                    $variables .= $clave;
                    $valores .= "'$valor'";
                }
                else
                {
                    $variables .= $clave.",";
                    $valores .= "'$valor',";
                }
            }
        }
        $cmd = "INSERT INTO $model[model_name] ($variables) VALUES ($valores)";
        mysqli_query($con->Con(),$cmd);
        $res_consulta = mysqli_query($con->Con(),"SELECT * FROM $model[model_name] ORDER BY id DESC LIMIT 1");
        if($arg!="")
        {
            $row = $res_consulta->fetch_assoc();
            array_push($res, [$arg => $row[$arg]]);
            return $res;
        }
        else
        {
            while($row=mysqli_fetch_assoc($res_consulta))
            {
                array_push($res,$row);
            }
            return $res;
        }
    }


    public function UpdateRecords($model, DB $con,$arg = "",$value="")
    {
        $id = "";
        $variables="";
        $cont =0;
        $newcont =0;
        $consulta = "";
        foreach($model as $clave => $valor)
        {
            if ($clave != "model_name" && $clave != "id" && $clave!="model") {
                $cont += 1;
            }
        }
        foreach($model as $clave => $valor) {

            if($clave=="id")
            {
                $id = $valor;
            }
            
            if($clave!="model_name" && $clave!="id" && $clave!="model")
            {
                $newcont +=1;
                if($cont==$newcont)
                {
                    $variables .= $clave.="='$valor'";
                }
                else
                {
                    $variables .= $clave.="='$valor',";
                }
            }
        }
        
        if($arg==="" && $value === "")
        {
            $cmd = "UPDATE $model[model_name]  SET $variables WHERE id='$id'";
            $consulta = mysqli_query($con->Con(),$cmd);
        }
        else if($arg != "" && $value == "")
        {  
            $cmd = "UPDATE $model[model_name]  SET $variables WHERE id='$id'";
            $query = mysqli_query($con->Con(),$cmd);
            if($query==true)
            {
                $cmd2 = "SELECT $arg FROM $model[model_name] WHERE id='$id'";
                $consulta = mysqli_query($con->Con(),$cmd2)->fetch_assoc();
            }
            
        }
        else if($arg != "" && $value != "")
        {
            $cmd = "UPDATE $model[model_name]  SET $arg='$value' WHERE id='$id'";
            $consulta = mysqli_query($con->Con(),$cmd);
        }
        
        return $consulta;
    }
    public function DeleteRecords($model, DB $con, $arg="")
    {
        $id="";
        if($arg=="")
        {
            foreach($model as $clave => $valor)
            {
                if($clave=="id")
                {
                    $id = $valor;
                }
            }
            $res_consulta = mysqli_query($con->Con(),"DELETE FROM $model[model_name] WHERE id='$id'");
        }
        else
        {
            foreach($model as $clave => $valor)
            {
                if($clave==$arg)
                {
                    $id = $valor;
                }
            }
            $cmd = "DELETE FROM $model[model_name] WHERE $arg='$id'";
            $res_consulta = mysqli_query($con->Con(),$cmd);
        }
        return $res_consulta;
    }
}