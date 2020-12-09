<!DOCTYPE HTML>
<html>
<head>
	<title>PDO - Read Records - PHP CRUD Tutorial</title>
	
	<!-- Latest compiled and minified Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
		
	<!-- custom css -->
	<style>
	.m-r-1em{ margin-right:1em; }
	.m-b-1em{ margin-bottom:1em; }
	.m-l-1em{ margin-left:1em; }
	.mt0{ margin-top:0; }
	</style>

</head>
<body>

    <!-- container -->
    <div class="container">
 
        <div class="page-header">
            <h1>Read Products</h1>
        </div>
	
        <!-- PHP code to read records will be here -->

        <?php
        //conexion a la db
        include 'config/database.php';

        // Varibales para paginacion

        // pagina actual, si no hay nada, se setea con '1'
        $page = isset($_GET['page']) ? $_GET['page'] : 1;

        // set de numero de lineas 
        $records_per_page = 5;

        // calcullo para clausula LIMIT
        $from_record_num = ($records_per_page * $page) - $records_per_page;

        //Mensaje de borrado irá aquí

        //Seleccionar todos los datos
        // Con la clausula limit, ponemos un limite de lineas por pagina

        $query = "SELECT id, name, description, price FROM products ORDER BY id DESC
                  LIMIT :from_record_num, :records_per_page";


        $stmt = $con -> prepare($query);
        $stmt-> bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
        $stmt-> bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
        
        $stmt -> execute();

        //como obtener el numero de lineas devueltas

        $num = $stmt -> rowCount();

        //link al formulario para añadir items
        echo "<a href='create.php' class='btn btn-primary m-b-1em'>Añadir Nuevo Producto</a>";

        //comprobar si hay mas de un dato encontrado

        if ($num > 0) {
            //los datos van aqui

            //inicio de la tabla
            echo "<table class='table table-hover table-responsive table-bordered'>";

                //Creando la cabecera de la tabla
                echo "<tr>";
		            echo "<th>ID</th>";
		            echo "<th>Nombre</th>";
		            echo "<th>Descripcion</th>";
		            echo "<th>Precio</th>";
		            echo "<th>Accion</th>";
                echo "</tr>";
            
                //Cuerpo de la tabla

                //recuperar el contenido de la tabla

                while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
                    //extraer el valor de la linea
                    extract($row);

                    //crear una nueva linea de tabla por cada registro
                    echo "<tr>";
                        echo "<td>{$id}</td>";
                        echo "<td>{$name}</td>";
                        echo "<td>{$description}</td>";
                        echo "<td>{$price} $</td>";
                        echo "<td>";
                            //leer un el registro de un unico producto

                            echo "<a href='read_one.php?id={$id}' class='btn btn-info m-r-1em'>Leer</a>";

                            //Actualizar productos
                            echo "<a href='update.php?id={$id}' class='btn btn-primary m-r-1em'>Editar</a>";

                            echo "<a href='#' onclick='delete_user({$id});' class='btn btn-danger'>Eliminar</a>";
                        echo "</td>";
                    echo "</tr>";
                }


            //final de la tabla
            echo "</table>";

        }
        //si no encuentra los datos
        else {
            echo "<div> class='alert alert-danger'>No se han encontrado productos.</div>";
        }
        ?>
		
    </div> <!-- end .container -->
	
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  
<!-- Latest compiled and minified Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!-- confirm delete record will be here -->

</body>
</html>