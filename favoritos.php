<?php 
    include ('config.php');
    include("encabezado.php"); 
    include("pie.php");
    include ("inc/conn.php");

    if (perfil_valido(3)) {
        header("location:login.php");
    }
    else if (perfil_valido(1)) {
        header("location:ve.php");
    } 
                 
    global $db;
    
    if (isset($_SESSION['idUsuario'])){ //si se inició sesion desde una cuenta nativa
        $id_usuario = $_SESSION['idUsuario'];
    }
    else if (isset($_SESSION['id'])){ //Si se inicio sesion desde Google
        $id_usuario = $_SESSION['id'];
    }
    else if (isset($_SESSION["user_id"])){ //Si se inicio sesion desde twitter
        $id_usuario = $_SESSION["user_id"];
    }

    if (!isset($_SESSION['idUsuario'])){
        $sql = "SELECT u.id
                FROM usuario as u
                INNER JOIN usuario_rs as rs ON rs.id = u.id
                WHERE rs.id_social = '$id_usuario'
        ";

        $rs = $db->query($sql);

        foreach ($rs as $row){
            $id_usuario = $row['id'];
        }
    }

    $sql= "SELECT `descripcion`, `material`, `color`, `caracteristicas`, `marca` , `precio`,`codigo`,p.`id`
            FROM `producto` as p 
            INNER JOIN `favorito` as f on p.id = f.id_producto 
            WHERE f.id_usuario = '$id_usuario'
    "; 

    $rs = $db->query($sql);

    $div = "<div class='consulta' id='consulta'>
                <div class='renglon' style='border-bottom:1px solid #858585; height:50px;'>      
                    <h1 style='margin: 0; display: flex; align-items: center; font-family: museosans500,arial,sans-serif; font-size:1.6rem;'>
                        Favoritos
                    </h1>
                </div>            
    ";
    $i = 0;

    foreach ($rs as $row){
        $i++;
    }

    $rs = $db->query($sql);

    $selectNumero = 1; 
    if ($i == 0){
                $div .= "<div style='margin:10px; width:100%; text-align:center; height:30px;'> Aún no hay productos favoritos</div>";

        $div .= "<div class='continuar' style='width: 100%; display: flex;'>
                        <button type='button' class='btn-final' id='continuar' style='margin:auto;'>
                            Continúa navegando
                        </button>
                </div>";

        if (isset($_GET['elim'])){
            $div .= "<div class='mensaje' id='mensaje'>¡El producto se ha eliminado correctamente!</div>";
        }
        $div .= "</div>";    
    }
    else{
        foreach ($rs as $row) { 
            $descripcion = $row['descripcion'];
            $material = $row['material'];
            $color = $row['color'];
            $caracteristicas = $row['caracteristicas'];
            $marca = $row['marca'];
            $precio = $row['precio'];
            $codigo = $row['codigo'];
            $id = $row['id'];
    
            $div.= "<div class='contenedor'>
                        <div class='descrip'> 
                            <div class='principal'>                                                                                          
                                <img src='images/$codigo.png' class='productos img-cat' alt='$codigo' style='border:none;'>
                                    <div class='titulo' style='text-align:left;'>
                                        <div class='cont-enlaces' style='display:flex; flex-wrap:wrap;'>
                                            <p class='enlace' style='color:#000; margin-top:10px; width:100%;'> $descripcion</p>
                                            <p class='enlace' style='font-size:16px; color: #858585;'> $marca</p>
                                        </div> 
                                        <div class='contenedor-eventos'>
                                            <div class='evento-producto' style='width:45%; padding-right: 8px; border-right: 1px solid #D3D3D3;' >
                                                <img src='images/eliminar.png' style='width:20px; height:20px; margin-right:1px;' alt='Eliminar producto'>
                                                <button class='elim-fav' value='$id'> Eliminar producto</button>
                                            </div>
                                            <div class='evento-producto' style='text-align:end;'>
                                                <img src='images/carrito.png' style='width:20px; height:20px; margin-right:1px;' alt='Agregar al carrito'>
                                                <a id='agregar-fav-$selectNumero' class='prod-fav' onclick='agregarProducto($id)'> Agregar al carrito</a>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div class='secundario'>
                                    <div class='definir'> 
                                        <b>Color:</b>
                                        <b>Material:</b>
                                        <b>Precio:</b>
                                    </div> 
                                    <div class='caract'> 
                                        <p>$color </p>
                                        <p>$material</p>
                                        <p>$$precio</p>
                                    </div>
                            </div>                                            
                        </div>
                    </div>
            ";
        
            $selectNumero++;
        }
        if (isset($_GET['elim'])){
            $div .= "<div class='mensaje' id='mensaje'>¡El producto se ha eliminado correctamente!</div>";
        }
        $div .= "</div>";
    }
?>
<!DOCTYPE html>
<html lang="es">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css"  href="assets/css/estilos.css" rel="stylesheet"/>
    <link rel="icon" type="image/png" href="images/logo_sitio.png">
    <title>Muebles Giannis</title> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="js/funciones.js"></script>
	<script>
        document.addEventListener ('DOMContentLoaded', () => {
            let continuar = document.getElementById('continuar');

            if (continuar != null){
                continuar.addEventListener("click", () => {
                    window.location = "productos.php?productos=todos";
                });  
            }

            let imagenes = document.getElementsByClassName('img-cat'); //Imagenes de los productos

            for (j=0;j<imagenes.length;j++){
                let articulo = imagenes[j].getAttribute('alt');
                imagenes[j].addEventListener("click", () => {
                    window.location = 'detalleArticulo.php?art='+articulo;
                });
            }

            let contenedorEnlaces = document.getElementsByClassName('cont-enlaces');

            for (j=0;j<imagenes.length;j++){
                let articulo = imagenes[j].getAttribute('alt');
                imagenes[j].addEventListener("click", () => {
                    window.location = 'detalleArticulo.php?art='+articulo;
                });

                contenedorEnlaces[j].addEventListener ("click" , () => {
                    window.location = 'detalleArticulo.php?art='+articulo;
                });
            }
        });
    </script>
    <style>
        main{
            display:flex;
            flex-wrap: wrap;
            justify-content:start;
        }

        .contenedor{
            display: flex;
            justify-content:space-between;
            flex-wrap:wrap;
            align-items:center;
            border-bottom: 1px solid #D3D3D3;
            width:100%;
            height:180px;
            padding:10px 0;
            margin: 0 10px;
        }

        .contenedor-btn{
            width:100%;
            background-color: white;
            border-radius: 5px;
            text-align:center;
            border: 1px solid #000;
            transition: all 0.3s linear;
        }

        .contenedor-btn div{
            width:100%;
            text-align:center;
            border-bottom: 1px solid #d3d3d3;
            transition: all 0.3s linear;
            padding: 10px 0;
        }

        .contenedor-btn div:hover{
            cursor: pointer;
            background-color: rgba(147, 81, 22,0.2);
            transition: all 0.3s linear;
        }

        .consulta{
            width:70%;
            background-color:white;
            display:flex;
            flex-wrap:wrap;
            justify-content: center;
            border-radius:5px;
            border: 1px solid black;
            margin-bottom: 30px;
            margin-left:4%;
            padding: 0 10px;
        }

        .renglon{
            width:100%;
            display:flex;
            justify-content:center;
            margin:0;
        }

        .productos{
            width: 30%;
            height:80%;
            padding-right: 10px;
            object-fit: contain;
        }

        .descrip{
            width:100%;
            height:100%;
            display:flex;
            justify-content: space-between;
        }

        .cont-btn{
            display:flex;
            justify-content:space-between;
            margin: 0 10px;
            height: 60px;
            border-bottom: 1px solid #D3D3D3;
            padding-top: 10px;
        }

        .checkout{
            width:200px;
        }

        .principal{
            width:60%;
            display:flex;
            justify-content: space-between;
            flex-wrap:wrap;
            height: 100%;
        }

        .principal p{
            width:200px;
            margin: 0;
            text-align:start;
            height: auto;
        }

        .secundario{
            width: 40%;
            display: flex;
            flex-wrap: wrap;
            align-content: start;
            justify-content: center;
        }

        .definir, .caract{
            width:65%;
            height:100%;
            display:flex;
            flex-wrap:wrap;
            align-items:start;
        }

        .definir{
            width:30%;
        }

        .caract p{
            margin:0;
            width:100%;
        }

        .mercadopago-button{
            height:40px;
            width: 250px;
            font-weight: 700;
        }

        .mercadopago-button:hover{
            background: #099;
            transition: all 0.3s linear;
        }

        .titulo{
            width: 60%;
            height: auto;
        }

        .contenedor-botones{
            justify-content: end;
            flex-wrap: wrap;
            padding-bottom: 10px;
            width:20%;
            display:block;
            margin: 0 20px 20px 10px;
        }

        .botones{
            height:100%;
            width:250px;
            margin: 0 10px;

        }

        .botones .checkout {
            height: 20%;
        }

        .continuar{
            height: 20%;
        }

        .btn-final{
            margin-top:10px;
        }

        .totales{
            display:flex;
            width:250px;
            margin: 0;
            justify-content:center;
        }

        .subtotal{
            background-color: #E9E9E9;
            font-size: 0.75rem;
        }

        .total{
            background-color: #D3D3D3;
        }

        .txt-totales{
            display:flex;
            align-items:center;
            width: 50%;
            font-family: museosans500,arial,sans-serif;
            padding-left: 10px;
            margin: 0;
            color: #000;
        }

        .continuar button{
            width:250px;
            height: 40px;
            background: rgba(147, 81, 22,0.5);
            border-radius: 5px;
            border: 1px solid #000;
            font-weight: 700;
            cursor: pointer;
        }

        .continuar button:hover{
            background-color: rgba(147, 81, 22,1);
            transition: all 0.3s linear;
            color: white;
            cursor:pointer;
        }

        .cant-compra{
            padding: 5px 10px;
        }

        .contenedor-eventos{
            display:flex;
            justify-content:space-between;
            width:100%;
            text-align:start;
            margin-top:20px;
            font-size: 0.8rem;
            align-items:center;
        }

        .evento-producto{
            color: #858585;
            display: flex;
            align-items: center;
        } 
        
        .prod-fav{
            padding-left: 2px;
            transition: all 0.5s linear;
            color: #858585;
        }

        .elim-fav {
            transition: all 0.5s linear;
            color: #858585;
            font-family: "Salesforce Sans", serif;
            line-height: 1.5rem;
            background-color: white;
            border: none;
            font-size: 0.8rem;
            padding-left: 4px;
            padding-right: 0;
        }

        .prod-fav:hover, .elim-fav:hover{
            color: #000;
            transition: all 0.5s linear;
            font-size: 0.9rem;
            cursor: pointer;
        }

        .mensaje{
            width:100%;
            margin: 10px;
            text-align: center;
            background-color: #000;
            color: white;
            border-radius:5px;
            padding: 10px 0;
            font-size: 1.1rem;
        }

        .mensaje a{
            text-decoration: underline;
            color: white;
            transition: all 0.5s linear;
        }

        .mensaje a:hover{
            font-size:1.2rem;
            transition: all 0.5s linear;
        }

        .parrafo-exito{
            background-color: #099;
			width:100%;
			padding: 10px 0;
			color: white;
			margin:10px;
			border-radius: 5px;
			text-align:center;
		}

        .carrito-compras{
            text-decoration: underline;
            color: white;
            transition: all 0.4s ease-in;
        }

        .carrito-compras:hover{
            font-size:1.3rem;
            transition: all 0.4s ease-in;
        }

        .img-cat:hover{
            cursor: pointer;
        }

        .enlace{
            transition: all 0.4s ease-in;
        }

        .enlace:hover{
            color: #000;
            font-size:1.2rem;
            transition: all 0.4s ease-in;;
            cursor: pointer;
        }
    </style>
</head>
<body id="body">
    <header>
        <?php echo $encab; ?> 
    </header>

    <main>
        <?php 
            echo "<ol class='ruta'>
                        <li style='margin-left:5px;'><a href='index.php'>Inicio</a></li>
                        <li style='border:none;text-decoration: none;'>Favoritos</li>
                  </ol>
            ";

            echo "<div class='contenedor-botones'>
                    $cont_usuarios
                  </div>";

            echo $div;
        ?>  
    </main>

    <footer id='pie'>
		<?= $pie; ?> 
	</footer>
</body>
</html>