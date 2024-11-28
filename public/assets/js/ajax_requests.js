$(document).ready(function () {



    /*------------------------
    Add Movie to favorites
    --------------------------*/

    $("#add_to_favorites").on("click", function (e) {

        e.preventDefault();

        var user_id = $(this).data("user-id");
        var movie_id = $(this).data("movie-id");


        $.ajax({
            url: "/AdaMov/public/favorites/addToFavorites",
            type: 'POST',
            data: {
                user_id: user_id,
                movie_id: movie_id
            },
            success: function (response) {

                var data = JSON.parse(response);

                if (data.success) {
                    alert(data.message);
                } else {
                    alert(data.message);
                }
            },
            error: function () {
                alert("An error occurred while adding to favorites.");
            }
        });
    });


    /*-----------------------------
        Remove Movie from favorites
    -------------------------------*/

    $(document).on("click", ".remove_from_favorites", function (e) {
        e.preventDefault();

        var user_id = $(this).data("user-id");
        var movie_id = $(this).data("movie-id");
        var tr = $(this).closest("tr");
        var movie_title = tr.find('td:eq(1)').text().trim();

        // Confirm the removal with movie title
        if (!confirm("Are you sure you want to remove \"" + movie_title + "\" from favorites?")) {
            return;
        }

        // Send Ajax Request Otherwise
        $.ajax({
            url: "/AdaMov/public/favorites/removeFromFavorites",
            type: 'POST',
            data: {
                user_id: user_id,
                movie_id: movie_id
            },
            success: function (response) {
                try {
                    var data = JSON.parse(response);

                    if (data.success) {
                        alert(data.message);
                        tr.fadeOut(300, function () {
                            $(this).remove();
                        });
                    } else {
                        alert(data.message);
                    }
                } catch (error) {
                    alert("Error parsing response: " + error);
                }
            },
            error: function () {
                alert("An error occurred while removing the movie from favorites.");
            }
        });

    });




    /*----------------------------
        Adding reviews for Movies
    ------------------------------*/

    let rating = 0;

    // Star Rating: Mouseover Highlight
    $("#star_rating i").on("mouseover", function () {
        let currentRating = $(this).data("rating");

        // Highlight all stars up to the hovered one
        $("#star_rating i").each(function () {
            if ($(this).data("rating") <= currentRating) {
                $(this).addClass("hovered");
            } else {
                $(this).removeClass("hovered");
            }
        });
    });

    // Star Rating: Remove Highlight on Mouse Leave
    $("#star_rating").on("mouseleave", function () {
        $("#star_rating i").removeClass("hovered");
    });

    // Star Rating: Set Rating on Click
    $("#star_rating i").on("click", function () {
        rating = $(this).data("rating");
        $("#rating_value").val(rating);

        // Update the selected stars
        $("#star_rating i").each(function () {
            if ($(this).data("rating") <= rating) {
                $(this).addClass("selected");
            } else {
                $(this).removeClass("selected");
            }
        });
    });

    // Add Comment and Rating
    $("#add_comment").on("click", function (e) {
        e.preventDefault();

        let user_id = $(this).data("user-id");
        let movie_id = $(this).data("movie-id");
        let comment = $("#comment").val().trim();

        if (!user_id || !movie_id || comment.length === 0 || rating === 0) {
            alert("All fields, including a rating, are required.");
            return;
        }

        // Send data via AJAX
        $.ajax({
            url: "/AdaMov/public/reviews/addReview",
            type: "POST",
            data: {
                user_id: user_id,
                movie_id: movie_id,
                comment: comment,
                rating: rating
            },
            success: function (response) {
                let data = JSON.parse(response);
                if (data.success) {
                    alert(data.message);

                    $("#comment").val("");
                    $("#rating_value").val(0);
                    $("#star_rating i").removeClass("selected");
                    rating = 0;

                    location.reload();

                } else {
                    alert(data.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("XHR:", xhr);
                console.error("Status:", status);
                console.error("Error:", error);
                alert("An error occurred while adding the comment and rating.");
            }
        });
    });


    /****************************
     *  Remove review (comment) *
     ****************************/
    $("#delete_review").on("click", function (e) {
        
        e.preventDefault();

        let review_id = $(this).data("review-id");
        let commentContainer = $(this).closest(".anime__review__item");
    
        if (!confirm("Are you sure you want to delete this comment?")) {
            return;
        }

        // Send data via AJAX
        $.ajax({
            url: "/AdaMov/public/reviews/deleteReview",
            type: "POST",
            data: {
                review_id: review_id
            },
            success: function (response) {
                let data = JSON.parse(response);
                if (data.success) {
                    alert(data.message);
                    commentContainer.fadeOut(300, function () {
                        $(this).remove();
                    });
                } else {
                    alert(data.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("XHR:", xhr);
                console.error("Status:", status);
                console.error("Error:", error);
                alert("An error occurred while deleting your comment.");
            }
        });

    });



    /************************
        Updating user Profile
    ************************/
    $('#update_profile').click(function (e) {
        e.preventDefault();

        // Select the form and its inputs
        const form = $('#updateProfileForm');
        const inputs = form.find('input');
        let isValid = true;

        // Remove previous validation states and messages
        inputs.removeClass('is-invalid');
        $('.invalid-feedback').remove();

        // Validate inputs (including social media URLs)
        inputs.each(function () {
            if (!this.value.trim()) {
                $(this).addClass('is-invalid');
                const invalidFeedback = $('<div>', {
                    class: 'invalid-feedback',
                    text: 'This field is required.'
                });
                $(this).after(invalidFeedback);
                isValid = false;
            }
            // Validate URL fields for proper format
            if ($(this).attr('type') === 'url' && this.value.trim()) {
                const urlPattern = /^(https?:\/\/[^\s/$.?#].[^\s]*)$/i;
                if (!urlPattern.test(this.value.trim())) {
                    $(this).addClass('is-invalid');
                    const invalidFeedback = $('<div>', {
                        class: 'invalid-feedback',
                        text: 'Please provide a valid URL.'
                    });
                    $(this).after(invalidFeedback);
                    isValid = false;
                }
            }
        });

        // If validation fails, exit
        if (!isValid) return;

        // Disable the update button to prevent multiple submissions
        $('#update_profile').prop('disabled', true);

        // Collect form data
        const formData = form.serialize();

        // Send AJAX request
        $.ajax({
            url: '/AdaMov/public/user/updateProfile',
            type: 'POST',
            data: formData,
            success: function (response) {
                $('#exampleModal').modal('hide');
                alert('Profile updated successfully!');
                location.reload();
            },
            error: function (xhr) {
                $('#update_profile').prop('disabled', false);
                alert('An error occurred: ' + xhr.responseText);
            }
        });
    });

    // Remove is-invalid class on input change
    $('#updateProfileForm input').on('input', function () {
        $(this).removeClass('is-invalid');
        $(this).next('.invalid-feedback').remove();
    });


    /**********************
     * Uploading new Avatar
     **********************/

    $('#avatarUpload').change(function(e) {

        const file = e.target.files[0];
        if (!file) return;

    
        const formData = new FormData();
        formData.append('avatar', file);


    
        // Send the AJAX request to upload the file
        $.ajax({
            url: '/AdaMov/public/user/uploadAvatar',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                const result = JSON.parse(response);
                if (result.success) {
                    const newAvatarPath = '/AdaMov/public/assets/' + result.new_avatar;
                    $('img[alt="Avatar"]').attr('src', newAvatarPath);
                    $('img[alt="Avatar"]').attr('src', newAvatarPath);
                    alert('Avatar updated successfully!');
                } else {
                    alert(result.message || 'An error occurred. Please try again.');
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('An error occurred while uploading the avatar.');
            }
        });

    });
    



    /******************************
        Handling the search queries
     ******************************/

    $(document).on('input', '#search-input', function () {
        var query = $(this).val().trim();

        if (query.length > 2) {
            $.ajax({
                url: '/AdaMov/public/search/search',
                type: 'POST',
                data: { query: query },
                success: function (response) {
                    var data = JSON.parse(response);

                    if (data.success) {
                        renderSearchResults(data.results);
                    } else {
                        clearSearchResults();
                        $('#search-results').html(`<p class="text-warning">${data.message}</p>`);
                    }
                },
                error: function () {
                    clearSearchResults();
                    $('#search-results').html('<p class="text-danger">An error occurred while performing the search.</p>');
                }
            });
        } else {
            clearSearchResults();
        }
    });

    // Function to render search results
    function renderSearchResults(results) {
        var resultsContainer = $('#search-results');
        resultsContainer.empty();

        if (results.length > 0) {
            let html = `
                <div class="table-responsive">
                    <table class="table table-hover table-dark text-light">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Thumbnail</th>
                                <th scope="col">Title</th>
                                <th scope="col">Description</th>
                                <th scope="col">Genre</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
            `;
            results.forEach(function (result, index) {
                html += `
                    <tr>
                        <th scope="row">${index + 1}</th>
                        <td>
                            <img 
                                src="/AdaMov/public/assets/${result.thumbnail}" 
                                alt="${result.title}" 
                                class="img-fluid rounded"
                                height="50"
                                width="50"
                            >
                        </td>
                        <td>${result.title}</td>
                        <td>${result.description}</td>
                        <td>${result.genre}</td>
                        <td>
                            <a 
                                href="/AdaMov/public/movies/show/${result.id}" 
                                class="btn btn-sm btn-success" 
                                title="View Movie"
                            >
                                <i class="fa fa-eye"></i> View
                            </a>
                        </td>
                    </tr>
                `;
            });
            html += `
                        </tbody>
                    </table>
                </div>
            `;
            resultsContainer.html(html);
        } else {
            resultsContainer.html('<p class="text-warning text-center">No results found.</p>');
        }
    }


    // Function to clear search results
    function clearSearchResults() {
        $('#search-results').empty();
    }

    // Clear input value when search modal is closed
    $(document).on('click', '.search-close-switch', function () {
        $('#search-input').val('');
        clearSearchResults();
    });



});
