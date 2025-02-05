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

    /*******************
        Editing movies *
    ********************/

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



    /******************
        Adding Movies *
    ******************/

    $('#addMovieButton').click(function(e) {
        e.preventDefault();
        
        // Perform client-side validation
        let isValid = true;
    
        // Validate Movie Title
        const title = $('#title').val().trim();
        if (!title) {
            $('#title').addClass('is-invalid');
            isValid = false;
        } else {
            $('#title').removeClass('is-invalid');
        }
    
        // Validate Description
        const description = $('#description').val().trim();
        if (!description) {
            $('#description').addClass('is-invalid');
            isValid = false;
        } else {
            $('#description').removeClass('is-invalid');
        }
    
        // Validate Release Date
        const releaseDate = $('#releaseDate').val().trim();
        if (!releaseDate) {
            $('#releaseDate').addClass('is-invalid');
            isValid = false;
        } else {
            $('#releaseDate').removeClass('is-invalid');
        }
    
        // Validate Genre
        const genre = $('#genre').val();
        console.log(genre);
        if (!genre) {
            $('#genre').addClass('is-invalid');
            isValid = false;
        } else {
            $('#genre').removeClass('is-invalid');
        }
    
        // Validate Thumbnail
        const thumbnail = $('#thumbnail').get(0).files.length;
        if (thumbnail === 0) {
            $('#thumbnail').addClass('is-invalid');
            isValid = false;
        } else {
            $('#thumbnail').removeClass('is-invalid');
        }
    
        // Validate Movie File
        const fileName = $('#fileName').get(0).files.length;
        if (fileName === 0) {
            $('#fileName').addClass('is-invalid');
            isValid = false;
        } else {
            $('#fileName').removeClass('is-invalid');
        }
    
        // Validate Duration
        const duration = $('#duration').val().trim();
        if (!duration || isNaN(duration) || duration <= 0) {
            $('#duration').addClass('is-invalid');
            isValid = false;
        } else {
            $('#duration').removeClass('is-invalid');
        }
    
        // Validate Quality
        const quality = $('#quality').val();
        if (!quality) {
            $('#quality').addClass('is-invalid');
            isValid = false;
        } else {
            $('#quality').removeClass('is-invalid');
        }
    
        // Stop if validation fails
        if (!isValid) {
            return;
        }
    
        // Collect form data, including files
        const formData = new FormData($('#addMovieForm')[0]);
    
        // Send AJAX request to add the movie
        $.ajax({
            url: '/AdaMov/public/admin/addMovie',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            beforeSend: function () {
                console.log('Sending AJAX request...');
                // console.log(formData);
            },
            success: function (response) {
                console.log('AJAX request successful:', response);
                if (response && response.success) {
                    alert('Movie added successfully!');
                    $('#addMovieForm')[0].reset();
                    $('.custom-file-label').text('Choose file');
                    $('.form-control').removeClass('is-invalid');
                } else {
                    alert(response.message || 'Failed to add movie. Please try again.');
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX request failed.', xhr.responseText);
                console.error('Status:', status);
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            },
            complete: function () {
                console.log('AJAX request completed.');
            }
        });
    });
    

    // Update file input labels with selected file names
    $('.custom-file-input').on('change', function (e) {
        var fileName = e.target.files[0]?.name || "Choose file";
        $(this).next('.custom-file-label').html(fileName);
    });

    



    /**************************************************
     *                                                *
     *      Genres related actions                    * 
     *                                                *
     **************************************************/

    /*******************
        Editing Genres *
    ********************/

    $("#genre-table-body").on('click', '.edit_genre_btn', function () {
        
        const genreId = $(this).data('genre-id');
        const name = $(this).data('genre-name');
        const description = $(this).data('genre-description');  
        
        console.log({
            genreId,
            name,
            description,
        });
        
        
        // Populate the modal fields with the extracted data
        $('#genreId').val(genreId);
        $('#genreName').val(name);
        $('#genreDescription').val(description);
    });

    // Save changes
    $('#saveGenreChangesBtn').on('click', function () {
        // Serialize the form data
        const formData = $('#editGenreForm').serialize();

        // Perform an AJAX request to save the changes
        $.ajax({
            url: '/AdaMov/public/admin/update_genre',
            type: 'POST',
            data: formData,
            success: function (response) {

                const jsonResponse = JSON.parse(response);
    
                if (jsonResponse.status === 'success') {
                    alert(jsonResponse.message);
                    $('#editGenreModal').modal('hide');
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


    /********************
        Removing genres *
    *********************/

    $("#genre-table-body").on('click', '.remove_genre_btn', function (e) {

        e.preventDefault();

        let genreId = $(this).data('genre-id');
        let genreRow = $(this).closest('tr');

        if (genreId && confirm("Are you sure you want to delete this Genre?")) {
            $.ajax({
                url: "/AdaMov/public/admin/remove_genre",
                type: "POST",
                data: { genreId: genreId },
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        // Remove the row
                        genreRow.remove();

                        // Update row numbers
                        $("#genre-table-body .row-number").each(function (index) {
                            $(this).text(index + 1);
                        });

                        alert(response.message);
                    } else {
                        alert(response.message || "Error deleting genre.");
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
        Adding Genres *
    *******************/

    $('#addGenreButton').on('click', function (e) {
        e.preventDefault();

        // Perform client-side validation
        let isValid = true;

        // Validate Genre Name
        const genreName = $('#genreName').val().trim();

        if (!genreName) {
            $('#genreName').addClass('is-invalid');
            isValid = false;
        } else {
            $('#genreName').removeClass('is-invalid');
        }

        // Validate the Genre Description
        const genreDescription = $('#genreDescription').val().trim();
        if (!genreDescription) {
            $('#genreDescription').addClass('is-invalid');
            isValid = false;
        } else {
            $('#genreDescription').removeClass('is-invalid');
        }

        // Stop if validation fails
        if (!isValid) {
            return;
        }

        // Collect form data
        const formData = $('#addGenreForm').serialize();

        // Send AJAX request to add the genre
        $.ajax({
            url: '/AdaMov/public/admin/addGenre',
            type: 'POST',
            data: formData,
            dataType: 'json',
            beforeSend: function () {
                console.log('Sending AJAX request...');
                console.log(formData);
            },
            success: function (response) {
                console.log('AJAX request successful:', response);
                if (response.success) {
                    alert('Genre added successfully!');
                    $('#addGenreForm')[0].reset();
                    $('.form-control').removeClass('is-invalid');
                } else {
                    alert(response.message || 'Failed to add genre. Please try again.');
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
     *      Admins related actions                    * 
     *                                                *
     **************************************************/

    /*******************
        Editing Admins *
    ********************/

    $("#admin-table-body").on('click', '.edit_admin_btn', function () {
    
        const adminId = $(this).data('admin-id');
        const fname = $(this).data('admin-fname');
        const lname = $(this).data('admin-lname');
        const email = $(this).data('admin-email');
        const avatar = $(this).data('admin-avatar');

        console.log({
            adminId,
            fname,
            lname,
            email,
            avatar,
        });

        // Populate the modal fields with the extracted data
        $('#edit_admin_id').val(adminId);
        $('#edit_admin_fname').val(fname);
        $('#edit_admin_lname').val(lname);
        $('#edit_admin_email').val(email);
        $('#edit_admin_avatar').attr('src', avatar);

    });

    // Save changes
    $('#saveAdminChangesBtn').on('click', function (e) {
        e.preventDefault();

        let isValid = true;

        // Get input values
        const adminId = $('#edit_admin_id').val().trim();
        const fname = $('#edit_admin_fname').val().trim();
        const lname = $('#edit_admin_lname').val().trim();
        const email = $('#edit_admin_email').val().trim();
        const password = $('#edit_admin_password').val().trim();

        // Reset validation classes
        $('.form-control').removeClass('is-invalid');

        // Validate First Name
        if (!fname) {
            $('#edit_admin_fname').addClass('is-invalid');
            isValid = false;
        }

        // Validate Last Name
        if (!lname) {
            $('#edit_admin_lname').addClass('is-invalid');
            isValid = false;
        }

        // Validate Email
        if (!email || !validateEmail(email)) {
            $('#edit_admin_email').addClass('is-invalid');
            isValid = false;
        }

        // Validate Password (if provided, ensure it's at least 6 characters)
        if (password && password.length < 6) {
            $('#edit_admin_password').addClass('is-invalid');
            isValid = false;
        }

        // Stop if validation fails
        if (!isValid) {
            return;
        }

        // Prepare data object
        let formData = {
            admin_id: adminId,
            fname: fname,
            lname: lname,
            email: email
        };

        // Include password if provided
        if (password) {
            formData.password = password;
        }

        // Send AJAX request
        $.ajax({
            url: '/AdaMov/public/admin/updateAdmin',
            type: 'POST',
            data: formData,
            dataType: 'json',
            beforeSend: function () {
                console.log('Sending AJAX request...', formData);
            },
            success: function (response) {
                console.log('AJAX request successful:', response);
                if (response.success) {
                    alert("Admin details updated successfully!");
                    $('#editAdminModal').modal('hide');
                    location.reload();
                } else {
                    alert(response.message || "An error occurred. Please try again.");
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX request failed:', error);
                alert("Failed to update admin details. Please try again later.");
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

    // Email validation function
    function validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }


    /********************
        Removing admins *
    *********************/

    $("#admin-table-body").on('click', '.remove_admin_btn', function (e) {

        e.preventDefault();

        let adminId = $(this).data('admin-id');
        let adminRow = $(this).closest('tr');

        if (adminId && confirm("Are you sure you want to delete this Admin?")) {
            $.ajax({
                url: "/AdaMov/public/admin/removeAdmin",
                type: "POST",
                data: { admin_id: adminId },
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        // Remove the row
                        adminRow.remove();

                        // Update row numbers
                        $("#admin-table-body .row-number").each(function (index) {
                            $(this).text(index + 1);
                        });

                        alert(response.message);
                    } else {
                        alert(response.message || "Error deleting admin.");
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error:", error);
                    alert("An error occurred. Please try again.");
                },
            });
        }
    });


});