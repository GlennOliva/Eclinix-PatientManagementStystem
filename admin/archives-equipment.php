<?php
include('../config/dbcon.php'); // Include your database connection file

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $equipment_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($equipment_id > 0) {
        // Fetch equipment data from tbl_equipment
        $query = "SELECT * FROM tbl_equipment WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $equipment_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $equipment = mysqli_fetch_assoc($result);

            // Insert into tbl_archiveequipment
            $insert_query = "INSERT INTO tbl_archiveequipment 
                             (equipment_name, equipment_id, equipment_slot, image, created_at) 
                             VALUES (?, ?, ?, ?, NOW())";
            $stmt = mysqli_prepare($conn, $insert_query);
            mysqli_stmt_bind_param($stmt, 'siss', 
                                  $equipment['equipment_name'], 
                                  $equipment_id, 
                                  $equipment['equipment_slot'], 
                                  $equipment['image']);
            $inserted = mysqli_stmt_execute($stmt);

            if ($inserted) {
                // Delete from tbl_equipment after successful insertion into tbl_archiveequipment
                $delete_query = "DELETE FROM tbl_equipment WHERE id = ?";
                $stmt = mysqli_prepare($conn, $delete_query);
                mysqli_stmt_bind_param($stmt, 'i', $equipment_id);
                $deleted = mysqli_stmt_execute($stmt);

                if ($deleted) {
                    // Return success response
                    echo json_encode(['success' => true]);
                    exit;
                }
            }
        }
    }

    // If something goes wrong, return a failure response
    echo json_encode(['success' => false]);
}
?>
