<!DOCTYPE HTML>
<html>
<head>
	<title>PDO - Read One Record - PHP CRUD Tutorial</title>

    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />

</head>
<body>


    <!-- container -->
    <div class="container">
 
        <div class="page-header">
            <h1>Read Product</h1>
        </div>
		
        <!-- PHP leer un producto -->

        <?php
        // obtener el valor del parametro, en este caso el ID
        // para esto usamosla funcion isset() que verifica si hay un valor o no

        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: ID no encontrado');
        
        //usar la conexion a base de datos

        include 'config/database.php';

        //Leer datos del id actual

        try {
            // preparar la query
            $query = "SELECT id, name, description, price FROM products WHERE id = ? LIMIT 0,1";
            $stmt = $con->prepare( $query );
            
            //primer id marcado

            $stmt->bindParam(1, $id);
            
            // ejecutar la query

            $stmt->execute();

            //guardar los datos en una variable

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            //valores para rellenar el formulario

            $name = $row['name'];
            $description = $row['description'];
            $price = $row['price'];

        } catch (PDOException $exception) {
            //mostrar error
            die('ERROR: ' . $exception->getMessage());
        }

        ?>

        <!-- HTML tabla para un producto -->

        <table class='table table-hover table-responsive table-bordered'>
            <tr>
                <td>Nombre</td>
                <td><?php echo htmlspecialchars($name, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Descripcion</td>
                <td><?php echo htmlspecialchars($description, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Precio</td>
                <td><?php echo htmlspecialchars($price, ENT_QUOTES) . ' $';  ?></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <a href='index.php' class='btn btn-danger'>Volver a lista</a>
                </td>
            </tr>
        </table>

	</div> <!-- end .container -->
	
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  
<!-- Latest compiled and minified Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>
</html>