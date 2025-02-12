<?php
session_start();
require_once '../includes/db_connection.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$query = "SELECT COUNT(*) as total FROM Productos";
$result = $conn->query($query);
$total_products = $result->fetch_assoc()['total'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Luxury Jewels</title>
    <link rel="stylesheet" href="../css/admin-styles.css">
</head>
<body>
    <div class="admin-container">
        <h1>Bienvenido, <?php echo $_SESSION['admin_username']; ?></h1>
        <nav>
            <ul>
                <li><a href="products.php">Gestionar Productos</a></li>
                <li><a href="categories.php">Gestionar Categorías</a></li>
                <li><a href="materials.php">Gestionar Materiales</a></li>
                <li><a href="manage_users.php">Gestionar Usuarios</a></li>
                <li><a href="logout.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
        <div class="dashboard-summary">
            <h2>Resumen</h2>
            <p>Total de productos: <?php echo $total_products; ?></p>
        </div>
    </div>
</body>
</html>

