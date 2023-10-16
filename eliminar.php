<?php
require_once('database.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_delete'])) {
        // El usuario ha confirmado la eliminación
        $sql = "DELETE FROM informacion WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
            header("Location: crud.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Consulta para obtener la información del registro a eliminar
    $sql = "SELECT * FROM informacion WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $nombres = $row["nombres"];
?>

        <!DOCTYPE html>
        <html>

        <head>
            <title>CRUD</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
            <link rel="icon" href="editar.png">
        </head>

        <body>
            <div class="container">
                <h1 class="my-4">Eliminar Registro</h1>
                <p>¿Está seguro de que desea eliminar el registro de <?php echo $nombres; ?>?</p>
                <form method="POST" action="">
                    <button type="submit" class="btn btn-danger" name="confirm_delete">Confirmar Eliminación</button>
                    <a class="btn btn-secondary" href="crud.php">Cancelar</a>
                </form>
            </div>
        </body>

        </html>

<?php
    } else {
        echo "Registro no encontrado.";
    }

    $conn->close();
} else {
    echo "ID de registro no válido.";
}
?>