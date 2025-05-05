<?php
session_start();

// Verificar si se seleccionaron asientos
if (!isset($_SESSION['asientos_seleccionados']) || !is_array($_SESSION['asientos_seleccionados'])) {
    echo "No hay asientos seleccionados. Por favor, selecciona al menos un asiento primero.";
    exit();
}

include __DIR__ . '/conexion.php';

// Obtener los detalles de los asientos seleccionados
$asientos_ids = $_SESSION['asientos_seleccionados'];
$placeholders = implode(',', array_fill(0, count($asientos_ids), '?'));
$sql = "SELECT * FROM asientos WHERE id IN ($placeholders)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param(str_repeat('i', count($asientos_ids)), ...$asientos_ids);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    echo "Los asientos seleccionados no existen.";
    exit();
}

$asientos = [];
$total_precio = 0;

while ($fila = $resultado->fetch_assoc()) {
    $asientos[] = $fila;
    $total_precio += $fila['precio'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header class="header">
        <h1 class="logo">PHANTOM TICKETS</h1>
    </header>
    <main class="main-container">
        <section class="section">
            <h2 class="body-unete">Detalles de los Asientos</h2>
            <div class="detalle-asiento">
                <?php foreach ($asientos as $asiento): ?>
                    <p><strong>Número de Asiento:</strong> <?= htmlspecialchars($asiento['numero_asiento']) ?></p>
                    <p><strong>Precio:</strong> $<?= htmlspecialchars($asiento['precio']) ?></p>
                    <hr>
                <?php endforeach; ?>
                <p><strong>Total a Pagar:</strong> $<?= htmlspecialchars($total_precio) ?></p>
            </div>

            <h2 class="body-unete">Realizar Pago</h2>
            <div id="paypal-button-container" class="paypal-container"></div>
        </section>
    </main>
    <footer class="footer">
        <p>&copy; 2025 PHANTOM TICKETS. Todos los derechos reservados.</p>
    </footer>

    <script src="https://www.paypal.com/sdk/js?client-id=ATL4UBEJ_LCZBcy2j17E6bvLQuAoBl2VNZPcFSaMfrw9pgGMeADZng28hX_wynKKYXxUSXqKjUuRxKfT&currency=MXN"></script>
    <script>
        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '<?= htmlspecialchars($total_precio) ?>'
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    alert('Pago completado por ' + details.payer.name.given_name);
                    window.location.href = "confirmacion.php";
                });
            }
        }).render('#paypal-button-container');
    </script>
</body>
</html>
