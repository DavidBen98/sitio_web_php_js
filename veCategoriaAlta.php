<?php 
    include("encabezado.php");
    if (!perfil_valido(1)) {
        header("location:index.php");
    }

    $formulario ="
            <form action='veFuncCategoriaAlta.php' onsubmit='return validarAltaCategoria()' enctype='multipart/form-data' class='cont' method='post'>            
                <h1 style='width:100%;text-align:center;'>Alta categoría</h1>

                <div class='contenedor'>
                    <label for='nombre'>Nombre de categoría</label>
                    <input type='text' class='form-control' name='nombre' id='nombre' title='Nombre' value=''> 
                </div>

                <div class='archivo'>
                    <input type='file' class='form-control' id='imagen' name='imagen' aria-label='Upload'>           
                </div>    

                <div class= 'agregar'>
                    <input type='submit' class='btn btn-secondary btn-lg' name='bAceptar' id='bAceptar' title='bAceptar' value='Agregar Categoría'>
                </div>
            ";
            
            if (isset($_GET['alta'])){
                $formulario .= "
                    <div class='contenedor' id='error'>
                        <p> ¡Se ha añadido la categoría con éxito! </p>
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
                }

                $formulario .= "
                    </div>
                ";
            }

    $formulario .= "</form>         
    ";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css"  href="assets/css/estilos.css" rel="stylesheet"/>
	<script src="js/funciones.js"></script>
    <title>Muebles Giannis - Las mejores marcas</title>
    <link rel="stylesheet" type="text/css" href="assets/css/ve_estilos.css" media="screen">
    <style>
        .cont{
            width:40%;
            height: auto;
        }

        .btn{
            margin:auto;
        }

        .archivo{
            display:flex;
            justify-content:center;
            width:100%;
            margin:20px;
        }

        .contenedor label{
            height:40px;
            font-size: 1.2rem;
        }

        .agregar {
            margin: auto;
            display: flex;
            justify-content:center;
            flex-wrap: wrap;
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