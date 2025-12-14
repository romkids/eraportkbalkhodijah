<?php
echo "<h1>SERVER DEBUG INFO</h1>";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "Script Filename: " . $_SERVER['SCRIPT_FILENAME'] . "<br>";
echo "Current Dir: " . __DIR__ . "<br>";
echo "Time: " . date('Y-m-d H:i:s') . "<br>";
?>