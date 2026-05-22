<?php
require "db.php";

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM shipments WHERE id=$id");
$row = $result->fetch_assoc();

if (isset($_POST['update'])) {
    $date = $_POST['inbound_date'];
    $product = $_POST['product_name'];
    $ship = $_POST['shipment_no'];
    $qty = $_POST['total_quantity'];

    $conn->query("UPDATE shipments SET 
        inbound_date='$date',
        product_name='$product',
        shipment_no='$ship',
        total_quantity='$qty'
        WHERE id=$id
    ");

    header("Location: admin_dashboard.php");
    exit();
}

include 'inc/header.php';
?>

<div class="card" style="max-width:700px;margin:24px auto;">
    <h3>Edit Shipment #<?= htmlspecialchars($id) ?></h3>
    <form method="POST">
        <div style="display:flex;gap:8px;flex-wrap:wrap">
            <input type="date" name="inbound_date" value="<?= $row['inbound_date'] ?>" required>
            <input type="text" name="product_name" value="<?= $row['product_name'] ?>" required>
            <input type="text" name="shipment_no" value="<?= $row['shipment_no'] ?>" required>
            <input type="number" name="total_quantity" value="<?= $row['total_quantity'] ?>" required>
        </div>
        <div style="margin-top:12px">
            <button type="submit" name="update">Update</button>
            <a href="admin_dashboard.php" style="margin-left:8px;color:#6b7280;text-decoration:none">Cancel</a>
        </div>
    </form>
</div>

<?php include 'inc/footer.php'; ?>