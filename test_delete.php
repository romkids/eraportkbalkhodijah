<?php
// Test delete script
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/session.php';
require_once __DIR__ . '/helpers/helpers.php';
require_once __DIR__ . '/helpers/auth.php';

define('BASE_PATH', __DIR__);
define('BASE_URL', '/erapor');
define('UPLOAD_PATH', BASE_PATH . '/uploads/');

$portfolioId = $_GET['id'] ?? null;
$studentId = $_GET['student_id'] ?? 1;

echo "<h2>Test Delete Portfolio</h2>";

if ($portfolioId) {
    echo "<p>Attempting to delete portfolio ID: $portfolioId</p>";

    // Get portfolio data
    $portfolio = db()->fetch("SELECT * FROM portfolio WHERE id = ?", [$portfolioId]);

    if ($portfolio) {
        echo "<p>Found portfolio: " . print_r($portfolio, true) . "</p>";

        // Delete file
        $filePath = UPLOAD_PATH . 'portfolio/' . $portfolio['file'];
        echo "<p>File path: $filePath</p>";
        echo "<p>File exists: " . (file_exists($filePath) ? 'YES' : 'NO') . "</p>";

        if (file_exists($filePath)) {
            unlink($filePath);
            echo "<p>File deleted!</p>";
        }

        // Delete from database
        db()->query("DELETE FROM portfolio WHERE id = ?", [$portfolioId]);
        echo "<p>Database record deleted!</p>";

        echo "<p style='color: green;'><strong>SUCCESS!</strong></p>";
    } else {
        echo "<p style='color: red;'>Portfolio not found!</p>";
    }
} else {
    // Show all portfolios
    $portfolios = db()->fetchAll("SELECT * FROM portfolio ORDER BY id DESC LIMIT 10");
    echo "<h3>Recent Portfolios:</h3>";
    echo "<ul>";
    foreach ($portfolios as $p) {
        echo "<li>ID: {$p['id']} - {$p['description']} - <a href='?id={$p['id']}&student_id={$p['student_id']}'>DELETE THIS</a></li>";
    }
    echo "</ul>";
}
