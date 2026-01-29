<?php

// Update total_harga for existing reservations
// Run this script once to update existing data

require_once __DIR__ . '/../system/bootstrap.php';

$db = \Config\Database::connect();

$query = $db->query("
    UPDATE reservasi
    SET total_harga = (
        SELECT harga_per_jam
        FROM lapangan
        WHERE lapangan.id_lapangan = reservasi.id_lapangan
    )
    WHERE total_harga IS NULL OR total_harga = 0
");

echo "Update completed. Affected rows: " . $db->affectedRows() . "\n";
