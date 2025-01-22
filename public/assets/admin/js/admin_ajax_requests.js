$(document).ready(function () {
    
    /**************************************************
     *                                                *
     *      Users related actions                     *
     *                                                *
     **************************************************/

    
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


    /******************
        Updating users
    *******************/

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
    $('#saveChangesBtn').on('click', function (e) {

        e.preventDefault();

        const formData = $('#editUserForm').serialize();
    
        $.ajax({
            type: 'POST',
            url: '/AdaMov/public/admin/update_user',
            data: formData,
            success: function (response) {
                const data = JSON.parse(response);
                if (data.success) {
                    alert('User updated successfully!');
                    location.reload();
                } else {
                    alert('Failed to update user: ' + data.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("XHR:", xhr);
                console.error("Status:", status);
                console.error("Error:", error);
                alert('An error occurred. Please try again.');
            }
        });
    });


    /*****************
        Adding users
    ******************/

    $('#addUserForm').on('submit', function (e) {
        e.preventDefault();

        // Perform client-side validation
        let isValid = true;

        // Validate First Name
        const firstName = $('#firstName').val().trim();
        if (!firstName) {
            $('#firstName').addClass('is-invalid');
            isValid = false;
        } else {
            $('#firstName').removeClass('is-invalid');
        }

        // Validate Last Name
        const lastName = $('#lastName').val().trim();
        if (!lastName) {
            $('#lastName').addClass('is-invalid');
            isValid = false;
        } else {
            $('#lastName').removeClass('is-invalid');
        }

        // Validate Address
        const address = $('#address').val().trim();
        if (!address) {
            $('#address').addClass('is-invalid');
            isValid = false;
        } else {
            $('#address').removeClass('is-invalid');
        }

        // Validate Email
        const email = $('#email').val().trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!email || !emailRegex.test(email)) {
            $('#email').addClass('is-invalid');
            isValid = false;
        } else {
            $('#email').removeClass('is-invalid');
        }

        // Validate Password
        const password = $('#password').val().trim();
        if (!password || password.length < 6) {
            $('#password').addClass('is-invalid');
            isValid = false;
        } else {
            $('#password').removeClass('is-invalid');
        }

        // Stop if validation fails
        if (!isValid) {
            return;
        }

        // Collect form data, including files
        const formData = new FormData(this);

        // Send AJAX request to add the user
        $.ajax({
            url: '/AdaMov/public/admin/addUser',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            beforeSend: function () {
                console.log('Sending AJAX request...');
            },
            success: function (response) {
                console.log('AJAX request successful:', response);
                if (response.success) {
                    alert('User added successfully!');
                    $('#addUserForm')[0].reset();
                    $('.custom-file-label').text('Choose file');
                    $('.form-control').removeClass('is-invalid');
                } else {
                    alert(response.message || 'Failed to add user. Please try again.');
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX request failed.');
                console.error('XHR:', xhr);
                console.error('Status:', status);
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            },
            complete: function () {
                console.log('AJAX request completed.');
            }
        });
    });


    // Remove invalid class on input change
    $('.form-control').on('input change', function () {
        $(this).removeClass('is-invalid');
    });




    /**************************************************
     *                                                *
     *      Movies related actions                    * 
     *                                                *
     **************************************************/

    /********************
        Removing movies *
    *********************/
    
    $("#movie-table-body").on('click', '.remove_movie_btn', function (e) {

        e.preventDefault();

        let movieId = $(this).data('movie-id');
        let userRow = $(this).closest('tr');

        if (movieId && confirm("Are you sure you want to delete this Movie?")) {
            $.ajax({
                url: "/AdaMov/public/admin/remove_movie",
                type: "POST",
                data: { movie_id: movieId },
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        // Remove the row
                        userRow.remove();

                        // Update row numbers
                        $("#movie-table-body .row-number").each(function (index) {
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

    /********************
        Editing movies *
    *********************/

    $(document).on('click', '.edit_movie_btn', function () {
        const movieId = $(this).data('movie-id');
        const title = $(this).data('title');
        const genreId = $(this).data('genre-id');
        const duration = $(this).data('duration');
        const status = $(this).data('status');
        const releaseDate = $(this).data('release-date');
        const thumbnail = $(this).data('thumbnail');
        const fileName = $(this).data('file-name');
        const description = $(this).data('description');
        const quality = $(this).data('quality');

        console.log({
            movieId,
            title,
            genreId,
            duration,
            status,
            releaseDate,
            thumbnail,
            fileName,
            description,
            quality,
        });
    
        // Populate the modal fields with the extracted data
        $('#edit_movie_id').val(movieId);
        $('#edit_movie_title').val(title);
        $('#edit_movie_genre').val(genreId);
        $('#edit_movie_duration').val(duration);
        $('#edit_movie_status').val(status);
        $('#edit_movie_release_date').val(releaseDate);
        $('#edit_movie_thumbnail').attr('src', `/AdaMov/public/assets/${thumbnail}`);
        $('#edit_movie_file_name').val(fileName);
        $('#edit_movie_description').val(description);
        $('#edit_movie_quality').val(quality);

    });
    
    // Save changes
    $('#saveMovieChangesBtn').on('click', function () {
        // Serialize the form data
        const formData = $('#editMovieForm').serialize();
    
        // Perform an AJAX request to save the changes
        $.ajax({
            url: '/AdaMov/public/admin/update_movie',
            type: 'POST',
            data: formData,
            success: function (response) {
                
                const jsonResponse = JSON.parse(response);
    
                if (jsonResponse.status === 'success') {
                    alert(jsonResponse.message);
                    $('#editMovieModal').modal('hide');
                    location.reload();
                } else {
                    alert(jsonResponse.message);
                }
            },
            error: function () {
                alert('An error occurred while processing your request. Please try again.');
            },
        });
    });
    
        


});