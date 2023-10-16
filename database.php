<?php
$conn = mysqli_init();
mysqli_ssl_set($conn, NULL, NULL, "ssl/DigiCertGlobalRootCA.crt.pem", NULL, NULL);
mysqli_real_connect($conn, "databaseconsultas.mysql.database.azure.com", "JOE", "Profesionales147", "crud", 3306, MYSQLI_CLIENT_SSL);
