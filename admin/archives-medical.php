<?php
include('../config/dbcon.php'); // Include your database connection file

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $medical_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($medical_id > 0) {
        // Fetch medical data from tbl_medical
        $query = "SELECT * FROM tbl_medical WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $medical_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $medical = mysqli_fetch_assoc($result);

            // Insert into tbl_archivemedical
            $insert_query = "INSERT INTO tbl_archivemedical 
                             (medical_name, medical_id, medical_slot, image, created_at) 
                             VALUES (?, ?, ?, ?, NOW())";
            $stmt = mysqli_prepare($conn, $insert_query);
            mysqli_stmt_bind_param($stmt, 'siss', 
                                  $medical['medical_name'], 
                                  $medical_id, 
                                  $medical['medical_slot'], 
                                  $medical['image']);
            $inserted = mysqli_stmt_execute($stmt);

            if ($inserted) {
                // Delete from tbl_medical after successful insertion into tbl_archivemedical
                $delete_query = "DELETE FROM tbl_medical WHERE id = ?";
                $stmt = mysqli_prepare($conn, $delete_query);
                mysqli_stmt_bind_param($stmt, 'i', $medical_id);
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
