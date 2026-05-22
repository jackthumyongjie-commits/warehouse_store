<?php
session_start();
require "db.php";

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// ADD RECORD
if (isset($_POST['save'])) {
    $date = $_POST['inbound_date'];
    $product = $_POST['product_name'];
    $ship = $_POST['shipment_no'];
    $qty = $_POST['total_quantity'];

    $conn->query("INSERT INTO shipments (inbound_date, product_name, shipment_no, total_quantity)
    VALUES ('$date', '$product', '$ship', '$qty')");
}

// DELETE
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM shipments WHERE id=$id");
}

// FETCH DATA
$result = $conn->query("SELECT * FROM shipments");

include 'inc/header.php';
?>

<div class="card">
    <h2>Admin Dashboard</h2>
    <div style="margin-top:12px">
        <form method="POST" class="card">
            <div style="display:flex;gap:8px;flex-wrap:wrap">
                <input type="date" name="inbound_date" required>
                <input type="text" name="product_name" placeholder="Product Name" required>
                <input type="text" name="shipment_no" placeholder="Shipment No" required>
                <input type="number" name="total_quantity" placeholder="Total Quantity" required>
                <button type="submit" name="save">Save</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <h3>Shipment List</h3>
    <table>
    <tr>
        <th>ID</th>
        <th>Date</th>
        <th>Product</th>
        <th>Shipment No</th>
        <th>Total Qty</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    <?php while($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['inbound_date'] ?></td>
        <td><?= $row['product_name'] ?></td>
        <td><?= $row['shipment_no'] ?></td>
        <td><?= $row['total_quantity'] ?></td>

        <td>
            <span class="status-dot">🔴 Not Checked</span>
        </td>

        <td class="actions">
            <a href="edit.php?id=<?= $row['id'] ?>">Edit</a>
            <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete?')">Delete</a>
        </td>
    </tr>
    <?php } ?>

    </table>
</div>

<?php include 'inc/footer.php'; ?>