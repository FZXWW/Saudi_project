<?php
session_start();
include 'db_connect.php';

if (isset($_GET['id']) && isset($_SESSION['admin_id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM content WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: dashboard.php?msg=deleted");
    }
}
?>