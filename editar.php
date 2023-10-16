<?php
require_once('database.php');

// Verificar si se proporcionó un ID válido a través de la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Consultar el registro con el ID proporcionado
    $sql = "SELECT * FROM informacion WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    } else {
        echo "ID de registro no válido.";
        exit();
    }
} else {
    echo "ID de registro no especificado.";
    exit();
}

// Procesar el formulario de edición
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit'])) {
    $nombres = $_POST["nombres"];
    $apellido_pa = $_POST["apellido_pa"];
    $apellido_ma = $_POST["apellido_ma"];
    $dni = $_POST["dni"];
    $telefono = $_POST["telefono"];
    $direccion = $_POST["direccion"];
    $nacimiento = $_POST["nacimiento"];
    $distrito = $_POST["distrito"];
    $sexo = $_POST["sexo"];

    $sql = "UPDATE informacion SET nombres = '$nombres', apellido_pa = '$apellido_pa', apellido_ma = '$apellido_ma', DNI = '$dni', telefono = '$telefono', direccion = '$direccion', nacimiento = '$nacimiento', distrito = '$distrito', sexo = '$sexo' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: crud.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
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
        <h1 class="my-4">Editar Registro</h1>

        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <div class="mb-3">
                <label for="nombres" class="form-label">Nombres:</label>
                <input type="text" class="form-control" id="nombres" name="nombres" value="<?php echo $row["nombres"]; ?>" required>
            </div>

            <div class="mb-3">
                <label for="apellido_pa" class="form-label">Apellido Paterno:</label>
                <input type="text" class="form-control" id="apellido_pa" name="apellido_pa" value="<?php echo $row["apellido_pa"]; ?>" required>
            </div>

            <div class="mb-3">
                <label for="apellido_ma" class="form-label">Apellido Materno:</label>
                <input type="text" class="form-control" id="apellido_ma" name="apellido_ma" value="<?php echo $row["apellido_ma"]; ?>" required>
            </div>

            <div class="mb-3">
                <label for="nacimiento" class="form-label">Fecha de Nacimiento:</label>
                <input type="date" class="form-control" id="nacimiento" name="nacimiento" value="<?php echo $row["nacimiento"]; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Sexo:</label>
                <div class="form-check">
                    <input type="radio" class="form-check-input" id="masculino" name="sexo" value="M" <?php echo ($row["sexo"] === "M") ? "checked" : ""; ?> required>
                    <label class="form-check-label" for="masculino">M</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" id="femenino" name="sexo" value="F" <?php echo ($row["sexo"] === "F") ? "checked" : ""; ?> required>
                    <label class="form-check-label" for="femenino">F</label>
                </div>
            </div>

            <div class="mb-3">
                <label for="dni" class="form-label">DNI:</label>
                <input type="number" class="form-control" id="dni" name="dni" value="<?php echo $row["dni"]; ?>" required>
            </div>

            <div class="mb-3">
                <label for="distrito" class="form-label">Distrito:</label>
                <input type="text" class="form-control" id="distrito" name="distrito" value="<?php echo $row["distrito"]; ?>" required>
            </div>

            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección:</label>
                <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $row["direccion"]; ?>" required>
            </div>

            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono:</label>
                <input type="number" class="form-control" id="telefono" name="telefono" value="<?php echo $row["telefono"]; ?>" required>
            </div>

            <button type="submit" class="btn btn-primary" name="edit">Guardar Cambios</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>