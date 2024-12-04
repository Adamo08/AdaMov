$(document).ready(function () {
    
    /***********************
        Removing users
    ************************/
    
    $("#user-table-body").on('click', '.remove_user_btn', function (e) {

        e.preventDefault();

        let userId = $(this).data('user-id');
        let userRow = $(this).closest('tr');

        if (userId && confirm("Are you sure you want to delete this user?")) {
            $.ajax({
                url: "/AdaMov/public/admin/remove_user",
                type: "POST",
                data: { user_id: userId },
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        // Remove the row
                        userRow.remove();

                        // Update row numbers
                        $("#user-table-body .row-number").each(function (index) {
                            $(this).text(index + 1);
                        });

                        alert(response.message);
                    } else {
                        alert(response.message || "Error deleting user.");
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error:", error);
                    alert("An error occurred. Please try again.");
                },
            });
        }
        
        
    });


    /*****************
        Updating users
    ******************/

    $(document).on('click', '.edit_user_btn', function () {
        // Get user data from the button attributes
        const userId = $(this).data('user-id');
        const fname = $(this).data('fname');
        const lname = $(this).data('lname');
        const address = $(this).data('address');
        const email = $(this).data('email');
        const avatar = $(this).data('avatar');
    
        // Populate the modal fields with the user data
        $('#edit_user_id').val(userId);
        $('#edit_user_fname').val(fname);
        $('#edit_user_lname').val(lname);
        $('#edit_user_address').val(address);
        $('#edit_user_email').val(email);
        $('#edit_user_avatar').attr('src', avatar);
    });
    
    // Save changes button click handler
    $('#saveChangesBtn').on('click', function () {

        const formData = new FormData($('#editUserForm')[0]);
    
        // $.ajax({
        //     type: 'POST',
        //     url: '/AdaMov/public/admin/update_user',
        //     data: formData,
        //     contentType: false,
        //     processData: false,
        //     success: function (response) {
        //         const data = JSON.parse(response);
        //         if (data.success) {
        //             alert('User updated successfully!');
        //             location.reload();
        //         } else {
        //             alert('Failed to update user: ' + data.message);
        //         }
        //     },
        //     error: function (xhr, status, error) {
        //         console.error("XHR:", xhr);
        //         console.error("Status:", status);
        //         console.error("Error:", error);
        //         alert('An error occurred. Please try again.');
        //     }
        // });
    });
        

});