<?php
phpinfo();die();
echo 'Prueba';die();

// Conectar a la base de datos usando PDO
$dsn = 'mysql:host=localhost;dbname=skapeople_db;charset=utf8';
$username = 'root';
$password = '';


/*date_default_timezone_set('America/Bogota');
echo date('Y-m-d H:i:s');die();*/
$year = date('Y');
//echo $year;die();
$url = "https://date.nager.at/Api/v2/PublicHolidays/" . $year . "/US";

// Obtener la respuesta de la API
$response = file_get_contents($url);
$festivos = json_decode($response, true);

// Verificar si la respuesta es válida
if (json_last_error() !== JSON_ERROR_NONE) {
    die('Error en la respuesta de la API');
}

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    /*$query = "DELETE FROM festivos;";
    $stmt = $pdo->prepare($query);
    $stmt->execute();*/

    foreach ($festivos as $festivo) {
        $fecha = $festivo['date'];
        $descripcion = $festivo['localName'];

        // Preparar la consulta para evitar inyecciones SQL
        $query = "INSERT INTO festivos (fecha, nombre) VALUES (:fecha, :descripcion)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([':fecha' => $fecha, ':descripcion' => $descripcion]);
    }

    echo "Festivos insertados correctamente.";
} catch (PDOException $e) {
    echo "Error en la conexión: " . $e->getMessage();
}
