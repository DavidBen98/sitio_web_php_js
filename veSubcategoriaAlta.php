<?php 
    include("encabezado.php");
    include_once('funciones.php');

    if (!perfil_valido(1)) {
        header("location:index.php");
    }

    $lista = obtenerCategorias();

    $formulario = "
        <form class='cont' action='veFuncSubcategoriaAlta.php' onsubmit='return validarAltaSubcategoria()' enctype='multipart/form-data'>     
            <label for='nombre'class='col-sm-2 form-label'>Nombre de subcategoría</label>
            <input type='text' name='tNombre' id='nombre' title='Ingrese el nombre de la subcategoria' value=''>  
            
            <label for='categoria'class='col-sm-2 form-label'>Categoría</label>
            $lista
            
            <div class='archivo'>
                <label for='imagen'>Imagen de portada</label>
                <input type='file' class='form-control' name='imagen' id='imagen' aria-label='Upload'>           
            </div>   
            
            <div class= 'agregar'>
                <input type='submit' class='btn' name='bAgregarSubCat' id='bAgregarSubCat' title='Agregar subcategoria' value='Agregar subcategoria'>    
            </div>
    ";
            
    if (isset($_GET['alta'])){
        $formulario .= "
            <div class='contenedor' id='error'>
                <p> ¡Se ha añadido la subcategoría con éxito! </p>
            </div>
        ";
    }
    else if (isset($_GET['error'])){
        $error = $_GET['error'];

        $formulario .= "
            <div class='contenedor' id='error'>
        ";

        if ($error === '1'){
            $formulario .= "
                <p> Error: ha ocurrido un inconveniente al subir la imagen, 
                    verifique que la extensión es .png, .jpg o .jpeg y 
                    reintente en un momento por favor. 
                </p>
            ";
        } else if ($error === '2'){
            $formulario .= "
                <p> Error: el nombre ingresado ya existe, reintente con otro por favor. </p>
            ";
        }else if ($error === '3'){
            $formulario .= "
                <p> Error: el nombre ingresado no cumple con los requisitos. </p>
            ";
        } else if ($error === '4'){
            $formulario .= "
                <p> Error: seleccione una imagen por favor. </p>
            ";
        } else if ($error === '5'){
            $formulario .= "
                <p> Error: la categoria no existe, seleccione una de las disponibles. </p>
            ";
        } else if ($error === '6'){
            $formulario .= "
                <p> Error: seleccione una categoria por favor. </p>
            ";
        }

        $formulario .= "
            </div>
        ";
    }

    $formulario .= "</form>";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="js/funciones.js"></script>
    <link type="text/css"  href="assets/css/estilos.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="assets/css/ve_estilos.css" media="screen">
    <title>Muebles Giannis - Las mejores marcas</title>
    <style>
        .cont{
            width:40%;
            height: auto;
            justify-content:center;
        }

        .cont input, .cont label, .cont select{
            width:100%;
            height:40px;
            text-align:center;
            margin-bottom: 10px;
        }

        .cont label{
            font-size: 1.3rem;
        }

        .archivo{
            display:flex;
            justify-content:center;
            flex-wrap:wrap;
            width:100%;
            margin:20px;
        }

        .archivo label{
            width: 100%;
            text-align:center;
        }

        .archivo input{
            width: auto;
        }

    </style>
</head>
<body>

    <header id='header'>
        <?= $encabezado; ?>
	</header>

    <main id='main'>
        <?= $formulario; ?>
    </main> 

</body>
</html>