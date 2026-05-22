<?php
session_start();
require __DIR__ . '/../admin/db.php';

$user_id = $_SESSION['user_id'];

$id = $_GET['id'];

$result = $conn->query("SELECT * FROM user_counts WHERE id=$id AND user_id=$user_id");
$row = $result->fetch_assoc();

if (isset($_POST['update'])) {
    $shipment = $_POST['shipment_no'];
    $product = $_POST['product_name'];
    $date = $_POST['count_date'];
    $start = $_POST['start_time'];
    $end = $_POST['end_time'];
    $qty = $_POST['total_count'];
    $by = $_POST['counted_by'];
    $remarks = $_POST['remarks'];

    $conn->query("UPDATE user_counts SET 
        shipment_no='$shipment',
        product_name='$product',
        count_date='$date',
        start_time='$start',
        end_time='$end',
        total_count='$qty',
        counted_by='$by',
        remarks='$remarks'
        WHERE id=$id AND user_id=$user_id
    ");

    header("Location: user_dashboard.php");
}
?>
include __DIR__ . '/../admin/inc/header.php';

?>

<div class="card" style="max-width:700px;margin:24px auto;">
    <h3>Edit Record #<?= htmlspecialchars($id) ?></h3>
    <form method="POST">
        <div style="display:flex;gap:8px;flex-wrap:wrap">
            <input type="text" name="shipment_no" value="<?= $row['shipment_no'] ?>" required>
            <input type="text" name="product_name" value="<?= $row['product_name'] ?>" required>
            <input type="date" name="count_date" value="<?= $row['count_date'] ?>" required>
            <input type="time" name="start_time" value="<?= $row['start_time'] ?>" required>
            <input type="time" name="end_time" value="<?= $row['end_time'] ?>" required>
            <input type="number" name="total_count" value="<?= $row['total_count'] ?>" required>
            <input type="text" name="counted_by" value="<?= $row['counted_by'] ?>" required>
            <textarea name="remarks"><?= $row['remarks'] ?></textarea>
        </div>
        <div style="margin-top:12px">
            <button type="submit" name="update">Update</button>
            <a href="user_dashboard.php" style="margin-left:8px;color:#6b7280;text-decoration:none">Cancel</a>
        </div>
    </form>
</div>

<?php include __DIR__ . '/../admin/inc/footer.php'; ?>