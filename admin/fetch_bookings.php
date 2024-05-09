<?php
include('../config/dbcon.php');

$date = isset($_GET['date']) ? $_GET['date'] : null;
if ($date) {
    $sql = "SELECT * FROM tbl_appoint WHERE date = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $date);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $appointments = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $row['appointment_date'] = date('F d, Y', strtotime($row['date']));
        $row['appointment_time'] = date('h:i A', strtotime($row['time']));
        $appointments[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($appointments);
}
