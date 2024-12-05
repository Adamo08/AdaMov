<?php require ADMINVIEWS."layouts/header.php"; ?>

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add New Genre</h1>
        <p class="text-muted">Fill in the details below to add a new genre to your catalog.</p>
    </div>

    <!-- Genre Form -->
    <div class="row">
        <div class="col-lg-12 mx-auto">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Genre Details</h6>
                </div>
                <div class="card-body">
                    <form action="/AdaMov/public/admin/add_genre" method="POST" id="addGenreForm">
                        <!-- Genre Name -->
                        <div class="form-group">
                            <label for="genreName">Genre Name</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="genreName" 
                                name="genre_name" 
                                placeholder="Enter genre name (e.g., Action, Comedy)" 
                                required
                                >
                        </div>

                        <!-- Genre Description -->
                        <div class="form-group">
                            <label for="genreDescription">Description</label>
                            <textarea 
                                class="form-control" 
                                id="genreDescription" 
                                name="genre_description" 
                                rows="4" 
                                placeholder="Write a brief description about the genre (optional)"
                            ></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-save"></i> Save Genre
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<?php require ADMINVIEWS."layouts/footer.php"; ?>
