<?php
include('../components/header-inventory.php');
include('../config/dbcon.php');

?>


<?php
if(!isset($_SESSION['admin_id']))
{
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


<style>
/* Define CSS classes for warning colors */
.green {
    color: lightgreen !important;

}



.yellow {
    color: yellow !important;
}

.orange {
    color: orange !important;
}

.red {
    color: red !important;
}

</style>

		<!-- MAIN -->
		<main>
			<h1 class="title">Manage Medicals</h1>
			<ul class="breadcrumbs">
				<li><a href="#">Admin</a></li>
				<li class="divider">/</li>
				<li><a href="#" class="active">Manage Medicals</a></li>
			</ul>

            <div class="container mt-3 table-border">
                <a href="add_inventory.php" class="btn btn-success btn-sm">Create</a>
                <table class="table table-hover" id="admin_table">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Medical Name</th>
                            <th>Quantity</th>
                            <th>Created_at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        //query to get all data from tbl_admin database
                $sql = "SELECT * FROM tbl_medical";

                //execute the query
                $result = mysqli_query($conn,$sql);

                //check whether if the query is execute or not

                if($result==True)
                {
                    //count the rows to check we have data in database or not
                    $count = mysqli_num_rows($result);

                    $ids=1;

                    //check the num of rows
                    if($count>0)
                    {
                        while($rows=mysqli_fetch_assoc($result))
                        {
                            $id = $rows['id'];
                            $medical_name = $rows['medical_name'];
                            $medical_slot = $rows['medical_slot'];
                            $image_name = $rows['image'];
                            $date = $rows['created_at'];

                              // Define slot count color classes
            $slot_warning_class = '';
            if ($medical_slot >= 40 && $medical_slot <= 50) {
                $slot_warning_class = 'green';
            } elseif ($medical_slot >= 30 && $medical_slot < 40) {
                $slot_warning_class = 'yellow';
            } elseif ($medical_slot >= 10 && $medical_slot < 30) {
                $slot_warning_class = 'orange';
            } elseif ($medical_slot >= 0 && $medical_slot < 10) {
                $slot_warning_class = 'red';
            }

                            ?>
                        <tr>

                       
                        
                            <td><?php echo $ids++;?></td>
                            <td><img src="medical_image/<?php echo $image_name?>" style="width: 70px;"></td>
                            <td><?php echo $medical_name;?></td>
                            <td class="<?php echo $slot_warning_class; ?>"><?php echo $medical_slot; ?></td>
                            <td><?php echo $date;?></td>
                            <td>
                                <a href="update_inventory.php?id=<?php echo $id;?>" class="btn btn-primary btn-sm">Update</a>
                                <form  method="post">
                                        <button type="button" class="btn-del " value="<?php echo $id; ?>">Archive</button>
                                    </form>
                            </td>
                        </tr>
                        <!-- More rows can be added here -->

                        <?php

                        }
                    }
                    
                }

                ?>
                        
                    </tbody>
                </table>
            </div>

			
		</main>
		<!-- MAIN -->
	</section>
	<!-- NAVBAR -->


    <script>
    document.querySelectorAll('.btn-del').forEach(button => {
    button.addEventListener('click', function() {
        const medicalId = this.getAttribute('value');

        if (confirm("Are you sure you want to archive this Inventory?")) {
            fetch(`archives-medical.php?id=${medicalId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Hide the row upon successful archiving
                    this.closest('tr').style.display = 'none';
                } else {
                    alert("Failed to archive the medical.");
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert("An error occurred while archiving the medical.");
            });
        }
    });
});


</script>

	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
	<script src="../script.js"></script>
    <script src="js/medical.js"></script>
</body>
</html>