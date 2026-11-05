<?php

$titulo = 'Reportes';

require APP_PATH . '/views/layouts/header.php';
require APP_PATH . '/views/layouts/sidebar.php';

?>

<div class="main-content">

<?php require APP_PATH . '/views/layouts/topbar.php'; ?>

<div class="page-header">

    <div>

        <h2>Reportes del Sistema</h2>

        <p>Consulta la información general de NutriControl La Sallista.</p>

    </div>

    <button
        type="button"
        class="btn btn-pdf"
        onclick="window.open('<?= BASE_URL ?>index.php?url=reportes/pdf', '_blank', 'noopener,noreferrer,width=1100,height=800')"
    >
        <i class="fa-solid fa-file-pdf"></i>
        Exportar PDF
    </button>

</div>

<div class="cards-reportes">

<div class="card-reporte">

<i class="fa-solid fa-users"></i>

<h3><?= $estadisticas['usuarios'] ?></h3>

<p>Usuarios</p>

</div>



<div class="card-reporte">

<i class="fa-solid fa-bowl-food"></i>

<h3><?= $estadisticas['refrigerios'] ?></h3>

<p>Refrigerios</p>

</div>

<div class="card-reporte">

<i class="fa-solid fa-clipboard-check"></i>

<h3><?= $estadisticas['entregas'] ?></h3>

<p>Entregas</p>

</div>

</div>

<div class="reporte-grid">

<div class="reporte-card">

<h3>

<i class="fa-solid fa-clock-rotate-left"></i>

Últimas Entregas

</h3>

<table class="table">

<thead>

<tr>

<th>Estudiante</th>

<th>Refrigerio</th>

<th>Fecha</th>

<th>Hora</th>

</tr>

</thead>

<tbody>

<?php if(empty($ultimasEntregas)): ?>

<tr>

<td colspan="4">

No hay registros.

</td>

</tr>

<?php else: ?>

<?php foreach($ultimasEntregas as $fila): ?>

<tr>

<td><?= htmlspecialchars($fila['grado'] ?? 'Sin grado') ?></td>

<td><?= htmlspecialchars($fila['refrigerio']) ?></td>

<td><?= date('d/m/Y',strtotime($fila['fecha'])) ?></td>

<td><?= htmlspecialchars($fila['hora']) ?></td>

</tr>

<?php endforeach; ?>

<?php endif; ?>

</tbody>

</table>

</div>

<div class="reporte-card">

<h3>

<i class="fa-solid fa-triangle-exclamation"></i>

Refrigerios con Bajo Stock

</h3>

<table class="table">

<thead>

<tr>

<th>Refrigerio</th>

<th>Cantidad</th>

<th>Mínimo</th>

</tr>

</thead>

<tbody>

<?php if(empty($refrigeriosStock)): ?>

<tr>

<td colspan="3">

Sin novedades.

</td>

</tr>

<?php else: ?>

<?php foreach($refrigeriosStock as $fila): ?>

<tr>

<td><?= htmlspecialchars($fila['nombre']) ?></td>

<td><?= htmlspecialchars($fila['cantidad']) ?></td>

<td><?= htmlspecialchars($fila['stock_minimo']) ?></td>

</tr>

<?php endforeach; ?>

<?php endif; ?>

</tbody>

</table>

</div>

<div class="reporte-card">

<h3>

<i class="fa-solid fa-calendar-xmark"></i>

Refrigerios Próximos a Vencer

</h3>

<table class="table">

<thead>

<tr>

<th>Refrigerio</th>

<th>Vencimiento</th>

</tr>

</thead>

<tbody>

<?php if(empty($refrigeriosVencer)): ?>

<tr>

<td colspan="2">

Sin novedades.

</td>

</tr>

<?php else: ?>

<?php foreach($refrigeriosVencer as $fila): ?>

<tr>

<td><?= htmlspecialchars($fila['nombre']) ?></td>

<td><?= date('d/m/Y',strtotime($fila['fecha_vencimiento'])) ?></td>

</tr>

<?php endforeach; ?>

<?php endif; ?>

</tbody>

</table>

</div>

</div>

</div>

<?php

require APP_PATH . '/views/layouts/footer.php';

?>