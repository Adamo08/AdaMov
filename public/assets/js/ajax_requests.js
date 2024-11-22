$(document).ready(function () {
    
    
    
    /*------------------------
    Add Movie to favorites
    --------------------------*/

    $("#add_to_favorites").on("click", function(e) {

        e.preventDefault();

        var user_id = $(this).data("user-id");
        var movie_id = $(this).data("movie-id");


        $.ajax({
            url: "http://localhost/AdaMov/public/favorites/addToFavorites",
            type: 'POST',
            data: {
                user_id: user_id, 
                movie_id: movie_id
            },
            success: function(response) {

                var data = JSON.parse(response);

                if (data.success) {
                    alert(data.message);
                } else {
                    alert(data.message);
                }
            },
            error: function() {
                alert("An error occurred while adding to favorites.");
            }
        });
    });


    /*-----------------------------
        Remove Movie from favorites
    -------------------------------*/

    $("#remove_from_favorites").on("click", function(e) {
        alert("Movie has been removed");
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
            url: "http://localhost/AdaMov/public/reviews/addReview",
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


});
