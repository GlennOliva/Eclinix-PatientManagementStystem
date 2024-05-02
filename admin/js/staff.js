$(document).ready(function(){


    $('.delete_staffbtn').click(function (e){
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
                    'staff_id': id,
                    'delete_staffbtn': true
                },
                success: function(response)
                {
                    if(response == 3)
                    {
                        swal("Success!","staff Successfully delete" , "success");
                        $("#admin_table").load(location.href + " #staff_table");
                    }
                    else if (response == 4){
                        swal("Error!","Failed to delete" , "error");
                    }
                }
              });
            }
          });
    });


  
  

    
    
    





});





