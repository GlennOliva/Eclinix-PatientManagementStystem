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
    <h1 class="title">Archive Equipment</h1>
    <ul class="breadcrumbs">
        <li><a href="#">Admin</a></li>
        <li class="divider">/</li>
        <li><a href="#" class="active">Archive Equipment</a></li>
    </ul>

    <div class="container mt-3 table-border">
    
        <table class="table table-hover"  id="admin_table">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Equipment_Name</th>
                    <th>Quantity</th>
                    <th>Image</th>
                    <th>Created_at</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM tbl_archiveequipment";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    $count = mysqli_num_rows($result);
                    $ids = 1;
                    if ($count > 0) {
                        while ($rows = mysqli_fetch_assoc($result)) {
                            $id = $rows['id'];
                            $equipment_id = $rows['equipment_id'];
                            $equipment_name = $rows['equipment_name'];
                            $equipment_slot = $rows['equipment_slot'];
                            $image = $rows['image'];
                            $created_at = $rows['created_at'];
                            ?>
                            <tr>
                                <td><?php echo $ids++; ?></td>
                                <td><?php echo $equipment_name; ?></td>
                                <td><?php echo $equipment_slot; ?></td>
                                <td><img src="equipment_image/<?php echo $image ?>" style="width: 70px;"></td>
                                <td><?php echo $created_at; ?></td>

                                <td>
                                <button type="button" class="btn btn-primary " value="<?php echo $id; ?>">Restored Details</button>
                                <form action="code.php" method="post">
                                        <button type="button" class="btn-del delete_equipmentbtn" value="<?= $id; ?>">Delete Permanent</button>
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
        const equipmentId = this.getAttribute('value');

        if (confirm("Are you sure you want to restore this equipment?")) {
            fetch(`restore_equipment.php?id=${equipmentId}`, {
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
                    alert("Failed to restore the equipment.");
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert("An error occurred while restoring the equipment.");
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
<script src="js/equipment.js"></script>
