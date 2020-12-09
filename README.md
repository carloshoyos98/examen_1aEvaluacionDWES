Examen 9/12/2020


* Pregunta 4:

1. En el codigo html para insertar losdatos, concatenamos el precio, con el string '$'.


* Pregunta 5:

1. El tipo de dato en la base de datos es un string con el nombre del archivo.

2. Se comprobaran los siguientes casos antes de aceptar la subida de archivos:

    2.1. El tipo de archivo es aceptado (.jpeg, .png, .gif, etc.).

    2.2. No existe un archivo con el mismo nombre.

    2.3. El tamaño del archivo no es demasiado grande.

    2.4. El directorio con los archivos subidos existe.

3. En la db se guarda el nombre del archivo en un string.

4. El archivo de la imagen debe estar en un directorio aparte (uploads/).

5. Para recuperar la imagen (mostrarla en el read_one), sacamos el string del campo image y buscamos el string devuelto en la ruta uploads/ , donde se supone estan los archivos subidos.