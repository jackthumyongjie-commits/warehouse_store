<?php
session_start();
require __DIR__ . '/../admin/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

include __DIR__ . '/../admin/inc/header.php';

// ADD RECORD
if (isset($_POST['save'])) {
    $shipment = $_POST['shipment_no'];
    $product = $_POST['product_name'];
    $date = $_POST['count_date'];
    $start = $_POST['start_time'];
    $end = $_POST['end_time'];
    $qty = $_POST['total_count'];
    $by = $_POST['counted_by'];
    $remarks = $_POST['remarks'];

    $conn->query("INSERT INTO user_counts 
    (user_id, shipment_no, product_name, count_date, start_time, end_time, total_count, counted_by, remarks)
    VALUES 
    ('$user_id','$shipment','$product','$date','$start','$end','$qty','$by','$remarks')");
}

// DELETE (own record only)
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM user_counts WHERE id=$id AND user_id=$user_id");
}

// FETCH
 $result = $conn->query("SELECT * FROM user_counts WHERE user_id=$user_id");
?>

<div class="card">
    <h2>User Dashboard</h2>
    <div style="margin-top:12px">
        <form method="POST" class="card">
            <div style="display:flex;gap:8px;flex-wrap:wrap">
                <input type="text" name="shipment_no" placeholder="Shipment No" required>
                <input type="text" name="product_name" placeholder="Product Name" required>
                <input type="date" name="count_date" required>
                <input type="time" name="start_time" required>
                <input type="time" name="end_time" required>
                <input type="number" name="total_count" placeholder="Total Count" required>
                <input type="text" name="counted_by" placeholder="Counted By" required>
                <textarea name="remarks" placeholder="Remarks" style="width:100%"></textarea>
                <button type="submit" name="save">Save</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <h3>Your Records</h3>
    <table>
    <tr>
        <th>ID</th>
        <th>Shipment</th>
        <th>Product</th>
        <th>Date</th>
        <th>Qty</th>
        <th>Action</th>
    </tr>

    <?php while($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['shipment_no'] ?></td>
        <td><?= $row['product_name'] ?></td>
        <td><?= $row['count_date'] ?></td>
        <td><?= $row['total_count'] ?></td>

        <td>
            <a href="edit_user.php?id=<?= $row['id'] ?>">Edit</a> |
            <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete?')">Delete</a>
        </td>
    </tr>
    <?php } ?>
    </table>
</div>

<?php include __DIR__ . '/../admin/inc/footer.php'; ?>