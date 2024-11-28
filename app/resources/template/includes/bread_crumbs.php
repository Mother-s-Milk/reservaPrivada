<!-- /*BC_link_anterior muestra el link para volver a la pestaña de atras, el $BC_actual representa en donde estamos ubicados y $$BC_anterior el anterior(estos últimos 2 están representados como textos) y estos valores se asignan en el controller*/ -->
<nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
    <ol class="breadcrumb bg-white rounded-pill shadow-lg p-3">
        <li class="breadcrumb-item">
            <a href="<?= $BC_link_anterior ?>" class="text-decoration-none text-primary fw-bold"><?= htmlspecialchars($BC_anterior) ?></a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            <span class="text-secondary fw-bold"><?= htmlspecialchars($BC_actual) ?></span>
        </li>
    </ol>
</nav>