$(document).ready(function(){


    $('.delete_appointbtn').click(function (e){
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
                    'appoint_id': id,
                    'delete_appointbtn': true
                },
                success: function(response)
                {
                    if(response == 10)
                    {
                        swal("Success!","Appoint Successfully delete" , "success");
                        $("#admin_table").load(location.href + " #admin_table");
                    }
                    else if (response == 15){
                        swal("Error!","Failed to delete" , "error");
                    }
                }
              });
            }
          });
    });


  
  

    
    
    





});





