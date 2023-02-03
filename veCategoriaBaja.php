<?php 
    include("encabezado.php");
    include ("inc/conn.php");
    
    if (!perfil_valido(1)) {
        header("location:index.php");
    }
?>
<!DOCTYPE html>
<?php  
    $listas = obtenerCategorias();

	$formulario =" 
        <form action='controlador/veFuncCategoriaBaja.php' onsubmit='return validarBajaCategoria()' method='post' class='cont'>
            <h1 style='width:100%;text-align:center;'>Baja categoría</h1>

            <label for='categoria'>CATEGORÍA</label>
            $listas
            <div class= 'agregar'>
                <input type='submit' class='btn btn-enviar' name='eliminar' id='eliminar' title='Eliminar' value='Eliminar categoría'>
            </div>
    ";

    if (isset($_GET['elim'])){
        $formulario .= "
            <div class='contenedor mensaje' id='mensaje'>
                <p> ¡Se ha eliminado la categoría con éxito! </p>
            </div>
        ";
    }
    else if (isset($_GET['error'])){
        $formulario .="
            <div class='contenedor mensaje' id='mensaje'>
                <p> Error: los datos ingresados no son correctos, reintente por favor </p>
            </div>
        ";
    }

    $formulario .="</form>";
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Muebles Giannis - Las mejores marcas</title>
    <link type="text/css"  href="assets/css/estilos.css" rel="stylesheet"/>
	<script src="js/funciones.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/css/ve_estilos.css" media="screen">
    <style>
        .cont{
            width:30%;
            justify-content:center;
            height: auto;
        }

        form label, #categoria{
            width:100%;
            text-align:center;
        }

        #categoria{
            border-radius:5px;
            font-size: 1.1rem;
        }

        .agregar {
            margin: auto;
            display: flex;
            justify-content:center;
            flex-wrap: wrap;
        }

        #mensaje, .mensaje{
            background-color: black;
            color : white;
            margin-top : 20px;
            margin-bottom : 20px;
            padding : 10px;
            border-radius : .5rem;
            text-align : center;
        }

        .agregar, .btn{
            width: 100%;
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