<?php
include('../config/dbcon.php'); // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $equipment_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($equipment_id > 0) {
        // Fetch the patient record from tbl_archivepatient
        $query = "SELECT * FROM tbl_archiveequipment WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $equipment_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $equipment = mysqli_fetch_assoc($result);

            // Insert into tbl_patient
            $insert_query = "INSERT INTO tbl_equipment 
                            (equipment_name, equipment_slot, image, created_at) 
                            VALUES (?, ?, ?,  NOW())";
            $stmt = mysqli_prepare($conn, $insert_query);
            mysqli_stmt_bind_param($stmt, 'sss', 
                                  $equipment['equipment_name'], 
                                  $equipment['equipment_slot'], 
                                  $equipment['image']);
            $inserted = mysqli_stmt_execute($stmt);

            if ($inserted) {
                // Delete the record from tbl_archivepatient after successful insertion
                $delete_query = "DELETE FROM tbl_archiveequipment WHERE id = ?";
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

    // If something goes wrong, return an error response
    echo json_encode(['success' => false]);
}
?>
