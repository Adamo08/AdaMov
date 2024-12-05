<?php require ADMINVIEWS."layouts/header.php"; ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add New Movie</h1>
        <p class="text-muted">Fill in the details below to add a new movie.</p>
    </div>

    <pre>
        <?php //print_r($genres)?>
    </pre>

    <!-- Add Movie Form -->
    <div class="row">
        <div class="col-lg-12 mx-auto">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Movie Details</h6>
                </div>
                <div class="card-body">
                    <form id="addMovieForm" action="/admin/add_movie" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title">Movie Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter movie title" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter movie description" required></textarea>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="releaseDate">Release Date</label>
                                <input type="date" class="form-control" id="releaseDate" name="release_date" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="genre">Genre</label>
                                <select class="form-control" id="genre" name="genre" required>
                                    <option value="" disabled selected>Select a genre</option>
                                    <?php foreach ($genres as $genre): ?>
                                        <option value="<?= htmlspecialchars($genre['id']) ?>">
                                            <?= htmlspecialchars($genre['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="thumbnail">Thumbnail (Image)</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="thumbnail" name="thumbnail" accept="image/*" required>
                                <label class="custom-file-label" for="thumbnail">Choose thumbnail</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="fileName">Movie File (MP4)</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="fileName" name="file_name" accept="video/mp4" required>
                                <label class="custom-file-label" for="fileName">Choose movie file</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="duration">Duration</label>
                                <input type="text" class="form-control" id="duration" name="duration" placeholder="e.g., 2h 15m" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="quality">Quality</label>
                                <select class="form-control" id="quality" name="quality" required>
                                    <option value="" disabled selected>Choose quality</option>
                                    <option value="1080p">1080p</option>
                                    <option value="720p">720p</option>
                                    <option value="1440p">1440p</option>
                                    <option value="4K">4K</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary btn-block">Add Movie</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Update file input labels with selected file names
    document.querySelectorAll('.custom-file-input').forEach(input => {
        input.addEventListener('change', function (e) {
            let fileName = e.target.files[0]?.name || "Choose file";
            e.target.nextElementSibling.textContent = fileName;
        });
    });
</script>

<?php require ADMINVIEWS."layouts/footer.php"; ?>
