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
                $query = "INSERT INTO products SET name=:name, description=:description, price=:price, image=:image,created=:created";

                //preparar la ejecucion de la query
                $stmt = $con->prepare($query);
                
                // valores posteados
                $name = htmlspecialchars(strip_tags($_POST['name']));
                $description = htmlspecialchars(strip_tags($_POST['description']));
                $price = htmlspecialchars(strip_tags($_POST['price']));

                $image=!empty($_FILES["image"]["name"])
                        ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"])
                        : "";
                        
                $image=htmlspecialchars(strip_tags($image));
                // esconder los parametros
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':price', $price);
                $stmt->bindParam(':image', $image);


                //especificar cuando se insertan los datos de la db
                $created = date('Y-m-d H:i:s');
                $stmt->bindParam(':created', $created);

                // Ejecuta la query
                if ($stmt->execute()) {
                    echo "<div class='alert alert-success'>Datos guardados.</div>";
                    if($image){

                        // sha1_file() function is used to make a unique file name
                        $target_directory = "uploads/";
                        $target_file = $target_directory . $image;
                        $file_type = pathinfo($target_file, PATHINFO_EXTENSION);
                    
                        // error message is empty
                        $file_upload_error_messages="";

                        // comprobar que es una imagen real
                        $check = getimagesize($_FILES["image"]["tmp_name"]);
                        if($check!==false){
                            // submitted file is an image
                        }else {
                            $file_upload_error_messages.="<div>Submitted file is not an image.</div>";
                        }
                    }         
                    
                    // comprobar que es solo de cierto tipo de archivo
                    $allowed_file_types=array("jpg", "jpeg", "png", "gif");
                    if(!in_array($file_type, $allowed_file_types)){
                        $file_upload_error_messages.="<div>Only JPG, JPEG, PNG, GIF files are allowed.</div>";
                    }

                    // comprieba que el archivo no existe
                    if(file_exists($target_file)){
                        $file_upload_error_messages.="<div>Image already exists. Try to change file name.</div>";
                    }

                    // comprueba que no pesa mas de 1MB
                    if($_FILES['image']['size'] > (1024000)){
                        $file_upload_error_messages.="<div>Image must be less than 1 MB in size.</div>";
                    }

                    // comprueba que el directorio 'uploads' existe
                    // si no, lo crea
                    if(!is_dir($target_directory)){
                        mkdir($target_directory, 0777, true);
                    }



                    // if $file_upload_error_messages is still empty
                    if(empty($file_upload_error_messages)){
                        // it means there are no errors, so try to upload the file
                        if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)){
                            // it means photo was uploaded
                        }else{
                            echo "<div class='alert alert-danger'>";
                                echo "<div>Unable to upload photo.</div>";
                                echo "<div>Update the record to upload photo.</div>";
                            echo "</div>";
                        }
                    }

                    // if $file_upload_error_messages is NOT empty
                    else{
                        // it means there are some errors, so show them to user
                        echo "<div class='alert alert-danger'>";
                            echo "<div>{$file_upload_error_messages}</div>";
                            echo "<div>Update the record to upload photo.</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>No es posible guardar los datos.</div>";
                }

                //mostrar el error
            } catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        }
       ?>


        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form/data">
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
            <td>Foto</td>
            <td><input type="file" name="image"></td>
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