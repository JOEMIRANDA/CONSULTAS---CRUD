<!DOCTYPE html>
<html>

<head>
    <title>CRUD</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="icon" href="editar.png">
</head>

<style>
    h1 {
        text-align: center;
    }

    form {
        text-align: center;
    }

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
        <h1 class="my-4">Consulta de Datos</h1>
        <form method="POST" action="" class="mb-4">
            <div class="form-group">
                <label for="dni">Ingrese su número de DNI:</label>
                <input type="number" id="dni" name="dni" class="form-control" required autocomplete="off" oninput="checkDNI(this)">
                <div id="dniLengthError" style="color: red; display: none;">No se pueden ingresar más de 8 números.</div>
            </div>
            <br>
            <button type="submit" class="btn btn-primary" id="consultButton">Buscar</button>
        </form>
    </div>
    <br>
    <br>
    <div style="display: flex; justify-content: center;">
        <button class="btn btn-secondary" id="redirectToCRUD" onclick="redirectCRUD()">Ir a CRUD</button>
    </div>


    <script>
        function checkDNI(input) {
            var dni = input.value;
            var errorElement = document.getElementById("dniLengthError");
            var consultButton = document.getElementById("consultButton");

            if (dni.length > 8) {
                errorElement.style.display = "block";
                consultButton.disabled = true;
            } else {
                errorElement.style.display = "none";
                consultButton.disabled = false;
            }
        }

        // Agregar la función para ocultar el mensaje después de 5 segundos
        function hideErrorMessage() {
            var errorMessage = document.getElementById("errorMessage");
            errorMessage.style.display = "none";
        }

        // Limpiar campos cuando se actualiza la página
        window.onload = function() {
            document.getElementById("dni").value = "";
        };
    </script>
</body>

<?php
require_once('database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dni = $_POST["dni"];

    // Consultar la base de datos para obtener los datos de la persona con el DNI proporcionado
    $sql = "SELECT * FROM informacion WHERE DNI = '$dni'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $nombres = $row["nombres"];
        $apellido_pa = $row["apellido_pa"];
        $apellido_ma = $row["apellido_ma"];
        $telefono = $row["telefono"];
        $direccion = $row["direccion"];
        $nacimiento = $row["nacimiento"];
        $distrito = $row["distrito"];
        $sexo = $row["sexo"];

        echo "<div class='container'>";
        echo "<h2 class='my-4'>Datos de la persona con DNI $dni:</h2>";
        echo "<p>Nombres: $nombres</p>";
        echo "<p>Apellido Paterno: $apellido_pa</p>";
        echo "<p>Apellido Materno: $apellido_ma</p>";
        echo "<p>Fecha de Nacimiento: $nacimiento</p>";
        echo "<p>Sexo: $sexo</p>";
        echo "<p>Distrito: $distrito</p>";
        echo "<p>Dirección: $direccion</p>";
        echo "<p>Teléfono: $telefono</p>";

        // Obtener el género a partir del nombre usando Gender-API
        $nombre = explode(" ", $nombres)[0]; // Tomar el primer nombre
        $genderApiUrl = "https://gender-api.com/get?name=" . urlencode($nombre) . "&key=vJwgS8rDxvseofTyRgnUTLUCaWvVUC6vCLud"; // Reemplaza TU_API_KEY con tu clave de acceso a Gender-API

        $genderApiResponse = file_get_contents($genderApiUrl);
        $genderData = json_decode($genderApiResponse, true);

        if ($genderData && $genderData['gender']) {
            $gender = $genderData['gender'];

            if ($gender === "male") {
                echo "<img src='hombre.png' alt='Hombre' />";
            } elseif ($gender === "female") {
                echo "<img src='mujer.png' alt='Mujer' />";
            }
        }

        echo "</div>";
    } else {
        echo "<div class='container'>";
        echo "<div id='errorMessage' style='color: red;'>No se encontraron datos para el DNI proporcionado.</div>";
        echo "</div>";

        // Agregar JavaScript para ocultar el mensaje después de 5 segundos
        echo "<script>setTimeout(hideErrorMessage, 5000);</script>";
    }
}



$conn->close();
?>

<script>
    function redirectCRUD() {
        window.location.href = 'crud.php';
    }
</script>

</html>