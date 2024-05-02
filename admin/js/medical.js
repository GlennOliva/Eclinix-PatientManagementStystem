$(document).ready(function(){


    $('.delete_medicalbtn').click(function (e){
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
                    'medical_id': id,
                    'delete_medicalbtn': true
                },
                success: function(response)
                {
                    if(response == 300)
                    {
                        swal("Success!","Medical Successfully delete" , "success");
                        $("#admin_table").load(location.href + " #admin_table");
                    }
                    else if (response == 600){
                        swal("Error!","Failed to delete" , "error");
                    }
                }
              });
            }
          });
    });


  
  

    
    
    





});





