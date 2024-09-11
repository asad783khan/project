<?php
header('Content-Type: application/json');
require 'database.php'; // Include database connection

// Example of generating a system report
$reports = [
    "Report 1: System usage statistics.",
    "Report 2: User activity log.",
    "Report 3: Performance metrics."
];

echo json_encode($reports);

$conn->close();
?>
