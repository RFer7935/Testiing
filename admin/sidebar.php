<?php
// Get the current page filename
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<div class="sidebar">
    <div class="text-center mb-4">
        <h4>Wisata Air Panas Wong Pulungan</h4>
    </div>
    <a href="2_dashboard.php" class="<?= ($currentPage === '2_dashboard.php') ? 'active' : '' ?>">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>
    <a href="3_management_resource.php" class="<?= ($currentPage === '3_management_resource.php') ? 'active' : '' ?>">
        <i class="bi bi-gear"></i> Management Web
    </a>
    <a href="edit_description.php" class="<?= ($currentPage === 'edit_description.php') ? 'active' : '' ?>">
        <i class="bi bi-pencil"></i> Edit Deskripsi
    </a>
    <a href="edit_price.php" class="<?= ($currentPage === 'edit_price.php') ? 'active' : '' ?>">
        <i class="bi bi-currency-dollar"></i> Edit Harga
    </a>
    <a href="edit_event.php" class="<?= ($currentPage === 'edit_event.php') ? 'active' : '' ?>">
        <i class="bi bi-calendar-event"></i> Edit Event
    </a>
    <a href="edit_wahana.php" class="<?= ($currentPage === 'edit_wahana.php') ? 'active' : '' ?>">
        <i class="bi bi-tree"></i> Edit Wahana
    </a>
</div>