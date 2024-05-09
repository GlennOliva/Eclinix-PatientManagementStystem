<?php
include('../components/header-patients.php');
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
    <h1 class="title">Archive Patient</h1>
    <ul class="breadcrumbs">
        <li><a href="#">Admin</a></li>
        <li class="divider">/</li>
        <li><a href="#" class="active">Archive Patient</a></li>
    </ul>

    <div class="container mt-3 table-border">
    
        <table class="table table-hover"  id="admin_table">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Full_Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Dob</th>
                    <th>Address</th>
                    <th>Phone_number</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM tbl_archivepatient";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    $count = mysqli_num_rows($result);
                    $ids = 1;
                    if ($count > 0) {
                        while ($rows = mysqli_fetch_assoc($result)) {
                            $id = $rows['id'];
                            $patient_id = $rows['patient_id'];
                            $full_name = $rows['full_name'];
                            $email = $rows['email'];
                            $Gender = $rows['gender'];
                            $Dob = $rows['dob'];
                            $address = $rows['address'];
                            $phone_number = $rows['phone_number'];
                            $image_name = $rows['image'];
                            ?>
                            <tr>
                                <td><?php echo $ids++; ?></td>
                                <td><?php echo $full_name; ?></td>
                                <td><?php echo $email; ?></td>
                                <td><?php echo $Gender; ?></td>
                                <td><?php echo $Dob; ?></td>
                                <td><?php echo $address; ?></td>
                                <td><?php echo $phone_number; ?></td>
                                <td><img src="patient_image/<?php echo $image_name ?>" style="width: 70px;"></td>
                                <td>
                                <button type="button" class="btn btn-primary " value="<?php echo $id; ?>">Restored Details</button>
                                <form action="code.php" method="post">
                                        <button type="button" class="btn-del delete_patientbtn" value="<?= $id; ?>">Delete Permanent</button>
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
    document.querySelectorAll('.btn.btn-primary').forEach(button => {
    button.addEventListener('click', function() {
        const patientId = this.getAttribute('value');

        if (confirm("Are you sure you want to restore this patient?")) {
            fetch(`restore_patient.php?id=${patientId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Hide or remove the row upon successful restoration
                    this.closest('tr').style.display = 'none';
                } else {
                    alert("Failed to restore the patient.");
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert("An error occurred while restoring the patient.");
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
<script src="js/patient.js"></script>
