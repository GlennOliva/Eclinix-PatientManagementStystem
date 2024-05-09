<?php
include('../config/dbcon.php'); // Include your database connection file

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $record_id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    if ($record_id > 0) {
        // Start a transaction
        mysqli_begin_transaction($conn);

        try {
            // Retrieve the record to archive from tbl_records
            $query = "SELECT * FROM tbl_records WHERE id = ?";
            $stmt = mysqli_prepare($conn, $query);
            if ($stmt === false) {
                throw new Exception("Failed to prepare SELECT statement");
            }

            mysqli_stmt_bind_param($stmt, 'i', $record_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result && mysqli_num_rows($result) > 0) {
                $record = mysqli_fetch_assoc($result);

                // Insert the record into tbl_archivepatientrecords
                $insert_query = "INSERT INTO tbl_archivepatientrecords 
                                 (patient_id, medical_id, record_id, `treatment`, `prescriptions`, `illness`, `laboratory_req`, age ) 
                                 VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

                $stmt = mysqli_prepare($conn, $insert_query);
                if ($stmt === false) {
                    throw new Exception("Failed to prepare INSERT statement");
                }

                // Bind parameters for the INSERT query
                mysqli_stmt_bind_param($stmt, 'iiissssi', 
                                      $record['patient_id'], 
                                      $record['medical_id'], 
                                      $record_id, // original record ID
                                      $record['treatment'], 
                                      $record['prescriptions'], 
                                      $record['illness'], 
                                      $record['laboratory_req'], 
                                      $record['age']);

                $inserted = mysqli_stmt_execute($stmt);

                if ($inserted) {
                    // Delete from tbl_records after successful insertion into tbl_archivepatientrecords
                    $delete_query = "DELETE FROM tbl_records WHERE id = ?";
                    $stmt = mysqli_prepare($conn, $delete_query);
                    if ($stmt === false) {
                        throw new Exception("Failed to prepare DELETE statement");
                    }

                    mysqli_stmt_bind_param($stmt, 'i', $record_id);
                    $deleted = mysqli_stmt_execute($stmt);

                    if ($deleted) {
                        // Commit the transaction
                        mysqli_commit($conn);

                        // Return success response
                        echo json_encode(['success' => true]);
                        return;
                    }
                }
            }

            // If something goes wrong, rollback the transaction
            mysqli_rollback($conn);
            throw new Exception("Record not found or failed to insert/delete");

        } catch (Exception $ex) {
            mysqli_rollback($conn); // Rollback on exception
            echo json_encode(['success' => false, 'error' => $ex->getMessage()]); // Detailed error message
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid record ID']);
    }
}
