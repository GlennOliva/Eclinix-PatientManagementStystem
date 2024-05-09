<?php
include('../components/header-patient.php');
include('../config/dbcon.php');

?>

<?php
if(!isset($_SESSION['admin_id'])) {
    echo '<script>
        swal({
            title: "Error",
            text: "You must login first before you proceed!",
            icon: "error"
        }).then(function() {
            window.location = "admin_login.php";
        });
    </script>';
    exit;
}
?>

<!-- MAIN -->
<main>
    <h1 class="title">Manage Patient Records</h1>
    <ul class="breadcrumbs">
        <li><a href="#">Admin</a></li>
        <li class="divider">/</li>
        <li><a href="#" class="active">Manage Patient Records</a></li>
    </ul>

    <div class="container mt-3 table-border">
        
        <a href="add_patient_records.php" class="btn btn-success btn-sm" style="margin-bottom: 10px;">Create</a>
        <br>
        <table class="table table-hover"  id="admin_table">
            <thead class="thead-dark">
                <tr>
                    <th>Id</th>
                    <th>Patient</th>
                    <th>Medical</th>
                    <th>Illness</th>
                    <th>Treatments</th>
                    <th>Prescriptions</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT
                tr.id,
                tp.full_name AS full_name,
                tm.medical_name AS medical_name,
                tr.illness,
                tr.treatment,
                tr.prescriptions
            FROM
                tbl_records tr
            JOIN
                tbl_patient tp ON tr.patient_id = tp.id
            JOIN
                tbl_medical tm ON tr.medical_id = tm.id
            ";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    $count = mysqli_num_rows($result);
                    $ids = 1;
                    if ($count > 0) {
                        while ($rows = mysqli_fetch_assoc($result)) {
                            $id = $rows['id'];
                            $patient = $rows['full_name'];
                            $medical = $rows['medical_name'];
                            $illness = $rows['illness'];
                            $treatment = $rows['treatment'];
                            $prescriptions= $rows['prescriptions'];
                     
                            ?>
                            <tr>
                                <td><?php echo $ids++; ?></td>
                                <td><?php echo $patient; ?></td>
                                <td><?php echo $medical; ?></td>
                                <td><?php echo $illness; ?></td>
                                <td><?php echo $treatment; ?></td>
                                <td><?php echo $prescriptions; ?></td>
                                <td>
                                    <a href="update_patient_records.php?id=<?php echo $id; ?>" class="btn btn-primary btn-sm">Update</a>
                                    <form  method="post">
                                        <button type="button" class="btn-del " value="<?php echo $id; ?>">Archive</button>
                                    </form>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</main>

<script>
   document.querySelectorAll('.btn-del').forEach((button) => {
    button.addEventListener('click', function () {
        const recordId = this.getAttribute('value');

        if (confirm("Are you sure you want to archive this patient record?")) {
            fetch('archives-records.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id=${recordId}`, // Sending the record ID to archive
            })
            .then((response) => response.json()) // Parsing the JSON response
            .then((data) => {
                if (data.success) {
                    this.closest('tr').style.display = 'none'; // Hides the row upon successful archiving
                } else {
                    alert("Failed to archive the patient records: " + (data.error || 'Unknown error')); // Enhanced error handling
                }
            })
            .catch((error) => {
                console.error('Error:', error); // Log errors
                alert("An error occurred while archiving the patient records."); // General error handling
            });
        }
    });
});

</script>

<!-- JavaScript to filter the table -->
<script>
document.getElementById('searchButton').addEventListener('click', () => {
    filterTable();
});

document.getElementById('searchInput').addEventListener('keyup', () => {
    filterTable();
});

function filterTable() {
    // Get the input field value
    var input = document.getElementById('searchInput').value.toLowerCase();

    // Get the table rows
    var rows = document.querySelectorAll('#patientTable tbody tr');

    rows.forEach(row => {
        // Check if any cell content matches the search term
        var match = false;
        var cells = row.querySelectorAll('td');

        cells.forEach(cell => {
            if (cell.textContent.toLowerCase().includes(input)) {
                match = true;
            }
        });

        // Show or hide the row based on whether it matches
        row.style.display = match ? '' : 'none';
    });
}
</script>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="../script.js"></script>
<script src="js/record.js"></script>
