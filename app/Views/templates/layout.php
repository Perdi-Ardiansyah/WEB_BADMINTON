<?= $this->include('templates/header') ?>
<?php if (session('role') === 'admin'): ?>
    <?= view('templates/sidebar_admin') ?>
<?php else: ?>
    <?= view('templates/sidebar_client') ?>
<?php endif; ?>
<!-- Dynamic Content -->
<?= $this->renderSection('content') ?>
<?= $this->include('templates/footer') ?>
