<?php
try {
    $pdo = new PDO(
        "mysql:host=shortline.proxy.rlwy.net;port=28704;dbname=railway",
        "root",
        "IZezOaVCEMegHhDKOcfYjetCvqxSQzEJ"
    );
    echo "✅ Connection successful!";
} catch (PDOException $e) {
    echo "❌ Connection failed: " . $e->getMessage();
}
