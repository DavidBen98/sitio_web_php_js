<!DOCTYPE html>
<?php 
    include ('inc/conn.php');

    global $db;

    $codigo = $_POST['codigo'];

    $descripcion = (isset($_POST['descripcion']) && $_POST['descripcion'] !== "")? ucfirst($_POST['descripcion']): null;
    
    $material = (isset($_POST['material']) && $_POST['material'] !== "")? ucfirst($_POST['material']): null;
    
    $color = (isset($_POST['color']))? ucfirst($_POST['color']): null;
    
    $caracteristicas = (isset($_POST['caracteristicas']))? $_POST['caracteristicas']: null;
    
    $marca = (isset($_POST['marca']) && $_POST['marca'] !== "")? $_POST['marca']: null;
    
    $cant = (isset($_POST['cant']) && $_POST['cant'] !== "" && $_POST['cant'] >= 0)? $_POST['cant']: null;
    
    $precio = (isset($_POST['precio']) && $_POST['precio'] > 0)? $_POST['precio']: null;
    
    $descuento = (isset($_POST['descuento']) && $_POST['descuento'] != "" && $_POST['descuento'] >= 0)? 
                    $_POST['descuento']: null;

    if ($codigo !== null && $descripcion !== null && $material !== null && $color !== null && 
        $caracteristicas !== null && $marca !== null && $cant !== null && $precio !== null && $descuento !== null){

        if (strpos($codigo,"ofsi") !== false){
            $caract = "Altura del respaldo: ".$caracteristicas[0]."cm,altura del piso al asiento: ". $caracteristicas[1]."cm";
        }
        else if (strpos($codigo,"doco") !== false){
            $caract = "Largo: ".$caracteristicas[0]. "cm,ancho: ". $caracteristicas[1] ."cm,alto: ". $caracteristicas[2] ."cm";
        }
        else if (strpos($codigo,"doca")!== false){
            $caract = "Plazas: ".$caracteristicas[0]. "cm,largo: ". $caracteristicas[1] ."cm,ancho: ". $caracteristicas[2] ."cm";
        }
        else if (strpos($codigo,"come")=== false && strpos($codigo,"cosi")=== false && strpos($codigo,"ofsi")=== false){
            $caract = "Alto: ".$caracteristicas[0]. "cm,ancho: ".$caracteristicas[1] ."cm,profundidad: ". $caracteristicas[2] ."cm";
        }
        else{
            $caract = "Alto: ".strval($caracteristicas[0]). "cm,ancho: ".strval($caracteristicas[1]) ."cm";
        }

        $sql = "UPDATE producto SET descripcion = '$descripcion', material = '$material', color = $color,
                caracteristicas = '$caract', marca = '$marca', stock = '$stock', precio = '$precio', 
                descuento= '$descuento'
                WHERE codigo = '$codigo'
        ";

        $rs = $db->query($sql);
    }
    else{
        header ("location: ve_prod_mod.php?error=data");
    }
?>