<?php

$fechaGeneracion = date('d/m/Y H:i');

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte NutriControl</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            padding: 35px;
            font-family: Arial, Helvetica, sans-serif;
            color: #1e293b;
            background: #ffffff;
        }
        .toolbar {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-bottom: 20px;
        }
        button {
            border: 0;
            border-radius: 8px;
            padding: 10px 16px;
            cursor: pointer;
            font-weight: 700;
        }
        .btn-print { background: #2563eb; color: #fff; }
        .btn-close { background: #475569; color: #fff; }
        .header {
            border-bottom: 3px solid #2563eb;
            padding-bottom: 18px;
            margin-bottom: 25px;
        }
        .header h1 {
            margin: 0 0 5px;
            font-size: 28px;
        }
        .header p {
            margin: 3px 0;
            color: #64748b;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 25px;
        }
        .stat {
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
        }
        .stat strong {
            display: block;
            font-size: 25px;
            margin-bottom: 5px;
        }
        .stat span { color: #64748b; font-size: 13px; }
        .section { margin-top: 24px; }
        .section h2 {
            font-size: 18px;
            margin: 0 0 10px;
            border-bottom: 1px solid #cbd5e1;
            padding-bottom: 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }
        th {
            background: #2563eb;
            color: #fff;
            padding: 9px;
            text-align: left;
        }
        td {
            padding: 9px;
            border-bottom: 1px solid #e2e8f0;
        }
        .empty { color: #64748b; text-align: center; }
        .footer {
            margin-top: 30px;
            padding-top: 12px;
            border-top: 1px solid #cbd5e1;
            color: #64748b;
            font-size: 11px;
            text-align: center;
        }
        @media print {
            body { padding: 0; }
            .toolbar { display: none; }
            .section { break-inside: avoid; }
        }
        @media (max-width: 700px) {
            body { padding: 18px; }
            .stats { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>

<div class="toolbar">
    <button class="btn-print" onclick="window.print()">
        Guardar como PDF
    </button>
    <button class="btn-close" onclick="window.close()">
        Cerrar
    </button>
</div>

<div class="header">
    <h1>NutriControl La Sallista</h1>
    <p>Reporte general del sistema</p>
    <p>Generado: <?= htmlspecialchars($fechaGeneracion) ?></p>
</div>

<div class="stats">
    <div class="stat">
        <strong><?= (int)($estadisticas['usuarios'] ?? 0) ?></strong>
        <span>Usuarios</span>
    </div>
    <div class="stat">
        <strong><?= (int)($estadisticas['refrigerios'] ?? 0) ?></strong>
        <span>Refrigerios</span>
    </div>
    <div class="stat">
        <strong><?= (int)($estadisticas['entregas'] ?? 0) ?></strong>
        <span>Entregas</span>
    </div>
</div>

<div class="section">
    <h2>Últimas entregas</h2>
    <table>
        <thead>
            <tr>
                <th>Grado</th>
                <th>Refrigerio</th>
                <th>Fecha</th>
                <th>Hora</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($ultimasEntregas)): ?>
            <tr><td colspan="4" class="empty">No hay registros.</td></tr>
        <?php else: ?>
            <?php foreach ($ultimasEntregas as $fila): ?>
                <tr>
                    <td><?= htmlspecialchars($fila['grado'] ?? 'Sin grado') ?></td>
                    <td><?= htmlspecialchars($fila['refrigerio'] ?? '') ?></td>
                    <td>
                        <?= !empty($fila['fecha']) ? date('d/m/Y', strtotime($fila['fecha'])) : '-' ?>
                    </td>
                    <td><?= htmlspecialchars($fila['hora'] ?? '') ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="section">
    <h2>Refrigerios con bajo stock</h2>
    <table>
        <thead>
            <tr>
                <th>Refrigerio</th>
                <th>Cantidad</th>
                <th>Mínimo</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($refrigeriosStock)): ?>
            <tr><td colspan="3" class="empty">Sin novedades.</td></tr>
        <?php else: ?>
            <?php foreach ($refrigeriosStock as $fila): ?>
                <tr>
                    <td><?= htmlspecialchars($fila['nombre'] ?? '') ?></td>
                    <td><?= (int)($fila['cantidad'] ?? 0) ?></td>
                    <td><?= (int)($fila['stock_minimo'] ?? 0) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="section">
    <h2>Refrigerios próximos a vencer</h2>
    <table>
        <thead>
            <tr>
                <th>Refrigerio</th>
                <th>Vencimiento</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($refrigeriosVencer)): ?>
            <tr><td colspan="2" class="empty">Sin novedades.</td></tr>
        <?php else: ?>
            <?php foreach ($refrigeriosVencer as $fila): ?>
                <tr>
                    <td><?= htmlspecialchars($fila['nombre'] ?? '') ?></td>
                    <td>
                        <?= !empty($fila['fecha_vencimiento']) ? date('d/m/Y', strtotime($fila['fecha_vencimiento'])) : '-' ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="footer">
    NutriControl La Sallista · Reporte generado desde el sistema
</div>

<script>
window.addEventListener('load', function () {
    setTimeout(function () {
        window.print();
    }, 500);
});
</script>

</body>
</html>
