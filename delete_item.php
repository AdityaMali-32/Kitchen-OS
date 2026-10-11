<?php
include 'config/database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$item_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($item_id > 0) {
    $stmt = $conn->prepare("DELETE FROM items WHERE id = ? AND user_id = ?");
    $stmt->bind_param('ii', $item_id, $user_id);
    
    if ($stmt->execute() && $stmt->affected_rows > 0) {
        $_SESSION['message'] = 'Item deleted successfully!';
        $_SESSION['msg_type'] = 'success';
    } else {
        $_SESSION['message'] = 'Failed to delete item.';
        $_SESSION['msg_type'] = 'danger';
    }
    $stmt->close();
} else {
    $_SESSION['message'] = 'Invalid item.';
    $_SESSION['msg_type'] = 'danger';
}

header('Location: inventory.php');
exit();
?>
