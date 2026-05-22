<?php
$conn = new mysqli("localhost", "root", "jack005432", "warehouse_system");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>