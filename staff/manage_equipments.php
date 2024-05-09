<?php
include('../components/staff_header-equip.php');
include('../config/dbcon.php');

?>


<?php
if(!isset($_SESSION['staff_id']))
{
    echo '<script>
                                    swal({
                                        title: "Error",
                                        text: "You must login first before you proceed!",
                                        icon: "error"
                                    }).then(function() {
                                        window.location = "staff_login.php";
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
			<h1 class="title">Manage Equipments</h1>
			<ul class="breadcrumbs">
				<li><a href="#">Staff</a></li>
				<li class="divider">/</li>
				<li><a href="#" class="active">Manage Equipments</a></li>
			</ul>

            <div class="container mt-3 table-border">
                <a href="add_equipment.php" class="btn btn-success btn-sm">Create</a>
                <table class="table table-hover" id="admin_table">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Equipment Name</th>
                            <th>Quantity</th>
                            <th>Created_at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php




                        //query to get all data from tbl_admin database
                $sql = "SELECT * FROM tbl_equipment";

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
                            $equipment_name = $rows['equipment_name'];
                            $equipment_slot = $rows['equipment_slot'];
                            $image_name = $rows['image'];
                            $date = $rows['created_at'];


                             // Define slot count color classes
            $slot_warning_class = '';
            if ($equipment_slot >= 40 && $equipment_slot <= 50) {
                $slot_warning_class = 'green';
            } elseif ($equipment_slot >= 30 && $equipment_slot < 40) {
                $slot_warning_class = 'yellow';
            } elseif ($equipment_slot >= 10 && $equipment_slot < 30) {
                $slot_warning_class = 'orange';
            } elseif ($equipment_slot >= 0 && $equipment_slot < 10) {
                $slot_warning_class = 'red';
            }

                            ?>
                        <tr>

                       
                        
                            <td><?php echo $ids++;?></td>
                            <td><img src="../admin/equipment_image/<?php echo $image_name?>" style="width: 70px;"></td>
                            <td><?php echo $equipment_name;?></td>
                            <td class="<?php echo $slot_warning_class; ?>"><?php echo $equipment_slot; ?></td> <!-- Add class for slot warning -->
                            <td><?php echo $date;?></td>
                            <td>
                                <a href="update_equipment.php?id=<?php echo $id;?>" class="btn btn-primary btn-sm">Update</a>
                                <!-- <form action="../admin/code.php" method="post">
                                    <button type="button"  class="btn-del delete_equipmentbtn" value="<?= $id;?>">Delete</button>
                                    </form> -->
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

	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
	<script src="../script.js"></script>
    <script src="../admin/js/equipment.js"></script>
</body>
</html>