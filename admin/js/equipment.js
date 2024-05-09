$(document).ready(function(){


    $('.delete_equipmentbtn').click(function (e){
        e.preventDefault();

     
        var id = $(this).val();

        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              $.ajax({
                method: "POST",
                url: "code.php",
                data: {
                    'equipment_id': id,
                    'delete_equipmentbtn': true
                },
                success: function(response)
                {
                    if(response == 20)
                    {
                        swal("Success!","Equipment Successfully delete" , "success");
                        $("#admin_table").load(location.href + " #admin_table");
                    }
                    else if (response == 2){
                        swal("Error!","Failed to delete" , "error");
                    }
                }
              });
            }
          });
    });


  
  

    
    
    





});





