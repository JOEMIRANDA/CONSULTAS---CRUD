<?php
require_once('database.php');

// Procesar el formulario de registro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $nombres = $_POST["nombres"];
    $apellido_pa = $_POST["apellido_pa"];
    $apellido_ma = $_POST["apellido_ma"];
    $dni = $_POST["dni"];
    $telefono = $_POST["telefono"];
    $direccion = $_POST["direccion"];
    $nacimiento = $_POST["nacimiento"];
    $distrito = $_POST["distrito"];
    $sexo = $_POST["sexo"];

    $sql = "INSERT INTO informacion (nombres, apellido_pa, apellido_ma, DNI, telefono, direccion, nacimiento, distrito, sexo) VALUES ('$nombres', '$apellido_pa', '$apellido_ma', '$dni', '$telefono', '$direccion', '$nacimiento', '$distrito', '$sexo')";

    if ($conn->query($sql) === TRUE) {
        header("Location: crud.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Consultar y mostrar registros existentes
$sql = "SELECT * FROM informacion";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>

<head>
    <title>CRUD</title>
    <!-- Incluye Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="editar.png">
</head>
<style>
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="number"] {
        -moz-appearance: textfield;
        /* Para Firefox */
    }
</style>


<body>
    <div class="container">
        <h1 class="mt-4">Registro de Información</h1>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="nombres" class="form-label">Nombres:</label>
                <input type="text" class="form-control" id="nombres" name="nombres" required>
            </div>

            <div class="mb-3">
                <label for="apellido_pa" class="form-label">Apellido Paterno:</label>
                <input type="text" class="form-control" id="apellido_pa" name="apellido_pa" required>
            </div>

            <div class="mb-3">
                <label for="apellido_ma" class="form-label">Apellido Materno:</label>
                <input type="text" class="form-control" id="apellido_ma" name="apellido_ma" required>
            </div>

            <div class="mb-3">
                <label for="nacimiento" class="form-label">Fecha de Nacimiento:</label>
                <input type="date" class="form-control" id="nacimiento" name="nacimiento" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Sexo:</label>
                <div class="form-check">
                    <input type="radio" class="form-check-input" id="masculino" name="sexo" value="M" required>
                    <label class="form-check-label" for="masculino">M</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" id="femenino" name="sexo" value="F" required>
                    <label class="form-check-label" for="femenino">F</label>
                </div>
            </div>

            <div class="mb-3">
                <label for="dni" class="form-label">DNI:</label>
                <input type="number" class="form-control" id="dni" name="dni" required oninput="checkDNI(this)">
                <div id="dniLengthError" style="color: red; display: none;">Debe tener exactamente 8 dígitos.</div>
            </div>

            <div class="mb-3">
                <label for="distrito" class="form-label">Distrito:</label>
                <input type="text" class="form-control" id="distrito" name="distrito" required>
            </div>

            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección:</label>
                <input type="text" class="form-control" id="direccion" name="direccion" required>
            </div>

            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono:</label>
                <input type="number" class="form-control" id="telefono" name="telefono" required>
            </div>

            <button type="submit" class="btn btn-primary" name="register" id="registerButton">Registrar</button>
        </form>

        <?php
        // Mostrar registros existentes en una tabla
        if ($result->num_rows > 0) {
            echo "<h2 class='mt-4'>Registros existentes:</h2>";
            echo "<table class='table table-striped'>";
            echo "<thead>
                    <tr>
                        <th>Nombres</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Fecha de Nacimiento</th>
                        <th>Sexo</th>
                        <th>DNI</th>
                        <th>Distrito</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        <th>Opciones</th>
                    </tr>
                </thead>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["nombres"] . "</td>";
                echo "<td>" . $row["apellido_pa"] . "</td>";
                echo "<td>" . $row["apellido_ma"] . "</td>";
                echo "<td>" . $row["nacimiento"] . "</td>";
                echo "<td>" . $row["sexo"] . "</td>";
                echo "<td>" . $row["dni"] . "</td>";
                echo "<td>" . $row["distrito"] . "</td>";
                echo "<td>" . $row["direccion"] . "</td>";
                echo "<td>" . $row["telefono"] . "</td>";
                echo "<td>
                    <a href='editar.php?id=" . $row["id"] . "' class='btn btn-info'>Editar</a>
                    <a href='eliminar.php?id=" . $row["id"] . "' class='btn btn-danger'>Eliminar</a>
                </td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "No se encontraron registros.";
        }

        $conn->close();
        ?>
    </div>

    <!-- Incluye Bootstrap JS (opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <script>
        function checkDNI(input) {
            var dni = input.value;
            var errorElement = document.getElementById("dniLengthError");
            var registerButton = document.getElementById("registerButton");
            var form = input.form;

            if (/^\d{8}$/.test(dni)) {
                errorElement.style.display = "none";
                enableFormFields(form);
                registerButton.disabled = false; // Habilitar el botón
            } else {
                errorElement.style.display = "block";
                disableFormFields(form);
                registerButton.disabled = true; // Deshabilitar el botón
            }
        }

        function disableFormFields(form) {
            var fields = form.querySelectorAll("input");
            fields.forEach(function(field) {
                if (field.id !== "dni") {
                    field.disabled = true;
                }
            });
        }

        function enableFormFields(form) {
            var fields = form.querySelectorAll("input");
            fields.forEach(function(field) {
                field.disabled = false;
            });
        }
    </script>

</body>

</html>