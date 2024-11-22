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
