<?php
    require_once 'assets/php/admin-header.php';
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card border-success mt-4"> <!-- Agregué la clase "mt-4" para añadir un margen superior -->
                <div class="card-header bg-success text-white">
                    <h4 class="m-0">Total Registered Users</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive" id="showAllUsers">
                        <p class="text-center align-self-center lead">Please Wait...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Display Users in Details Modal -->
    <div class="modal fade" id="showUserDetailsModal">
    <div class="modal-dialog modal-dialog-centered mw-100 w-50">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="getName"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="card-deck">
                    <div class="card border-primary">
                        <div class="card-body">
                            <p id="getEmail"></p>
                            <p id="getPhone"></p>
                            <p id="getDob"></p>
                            <p id="getGender"></p>
                            <p id="getCreated"></p>
                            <p id="getVerified"></p>
                        </div>
                    </div>
                    <div class="card align-self-center" id="getImage"></div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
    
</div>

<!-- Footer Area -->


</div>
</div>
</div>


<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-2.0.7/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
    $(document).ready(function(){



        //Fetch All users Ajax Request
        //Fetch All users Ajax Request
    fetchAllUsers();

    function fetchAllUsers(){
        $.ajax({
            url: 'assets/php/admin-action.php',
            method: 'post',
            data: { action: 'fetchAllUsers' },
            success:function(response){
                $("#showAllUsers").html(response); // Corrección: Agregar "#" para seleccionar por ID
                $("table").DataTable({
                    order: [0, 'desc']
                });
            }
        });
    }

    //Display Users in Details Ajax Request

    $("body").on("click", ".userDetailsIcon", function(e){
        e.preventDefault();

        details_id = $(this).attr('id');

        $.ajax({
            url: 'assets/php/admin-action.php',
            type: 'post',
            data: { details_id: details_id},
            success: function(response){
                data = JSON.parse(response);
                $("#getName").text(data.name+'  ' + '(ID: '+data.id+')');
                $("#getEmail").text('Email : '+data.email);
                $("#getPhone").text('Phone : '+data.telefono );
                $("#getGender").text('Gender : '+data.gender);

                $("#getDob").text('DOB : '+data.dob);

                $("#getCreated").text('Joined On : '+data.created_at);
                $("#getVerified").text('Verified : '+data.verified);


                if (data.photo != '') {
                    $("#getImage").html('<img src="../assets/php/' + data.photo + '" class="img-thumbnail img-fluid align-self-center" width="280px">');
                } else {
                    $("#getImage").html('<img src="../assets/img/profile.png" class="img-thumbnail img-fluid align-self-center" width="280px">');
                }





            }
        })


    });

    //delete an user ajax request
    $("body").on("click", ".deleteUserIcon", function(e){
    e.preventDefault();
    var del_id = $(this).attr('id'); // Use .data('id') to get the data-id attribute value
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'assets/php/admin-action.php',
                method: 'post',
                data: { del_id: del_id },
                success:function(response){
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your register has been deleted.",
                        icon: "success"
                    });
                    fetchAllUsers();
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error: ", status, error);
                }
            });
        }
    });
});

    });
</script>
</body>
</html>
