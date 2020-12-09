<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDO - Create a Record - PHP CRUD Tutorial</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>

</head>
<body>
    <div class="container">

        <div class="page-header">
            <h1>Create Product</h1>
        </div>

       <?php
        if($_POST){
            // Incluye/usa la conexion a la base de datos
            include 'config/database.php';

            try {
                // query del insert
                $query = "INSERT INTO products SET name=:name, description=:description, price=:price, created=:created";

                //preparar la ejecucion de la query
                $stmt = $con->prepare($query);
                
                // valores posteados
                $name = htmlspecialchars(strip_tags($_POST['name']));
                $description = htmlspecialchars(strip_tags($_POST['description']));
                $price = htmlspecialchars(strip_tags($_POST['price']));

                // esconder los parametros
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':price', $price);


                //especificar cuando se insertan los datos de la db
                $created = date('Y-m-d H:i:s');
                $stmt->bindParam(':created', $created);

                // Ejecuta la query
                if ($stmt->execute()) {
                    echo "<div class='alert alert-success'>Datos guardados.</div>";
                } else {
                    echo "<div class='alert alert-danger'>No es posible guardar los datos.</div>";
                }

                //mostrar el error
            } catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        }
       ?>


        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    <table class='table table-hover table-responsive table-bordered'>
        <tr>
            <td>Nombre</td>
            <td><input type='text' name='name' class='form-control' /></td>
        </tr>
        <tr>
            <td>Descripcion</td>
            <td><textarea name='description' class='form-control'></textarea></td>
        </tr>
        <tr>
            <td>Precio</td>
            <td><input type='text' name='price' class='form-control' /></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type='submit' value='Save' class='btn btn-primary' />
                <a href='index.php' class='btn btn-danger'>Volver a productos</a>
            </td>
        </tr>
    </table>
</form>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

<!-- Latest compiled and minified Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>
</html>