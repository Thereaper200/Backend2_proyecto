<?php include('template/cabecera.php');?>

<body>
    <div class="container mt-4">
        <h1>Consulta de Factura</h1>
        <form method="get" action="">
            <div class="form-group">
                <label for="factura_id">Ingrese ID de Factura:</label>
                <input type="text" class="form-control" id="factura_id" name="factura_id" required>
            </div>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>

        <div class="mt-4" id="resultados">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['factura_id'])) {
                $factura_id = $_GET['factura_id'];
                $api_url = "http://localhost:8000/factura/" . urlencode($factura_id);

                // Hacer solicitud GET a la API
                $json_data = file_get_contents($api_url);
                $response = json_decode($json_data, true);

                // Mostrar resultados
                if (isset($response['serial_numbers']) && count($response['serial_numbers']) > 0) {
                    echo "<h3>Números de Serie de la Factura: $factura_id</h3>";
                    echo "<ul>";
                    foreach ($response['serial_numbers'] as $serial_number) {
                        echo "<li>$serial_number</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>No se encontraron números de serie para la factura: $factura_id</p>";
                }
            }
            ?>
        </div>
    </div>

    <?php include('template/pie.php');?>