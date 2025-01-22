<?php require ADMINVIEWS."layouts/header.php"; ?>

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="mb-4">
            <h1 class="h3 mb-0 text-gray-800">Movies</h1>
        </div>

        <pre>
            <?php //print_r($movies)?>
        </pre>

        <!-- Movies DataTales -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Movies DataTable</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>##</th>
                                <th>Title</th>
                                <th>Genre</th>
                                <th>Duration</th>
                                <th>
                                    <!-- Reviews icon -->
                                    <i class="fas fa-comments"></i>
                                </th>
                                <th>
                                    <!-- Views icon -->
                                    <i class="fas fa-eye"></i>
                                </th>
                                <th>Status</th>
                                <th>Release Date</th>
                                <th>Added At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>##</th>
                                <th>Title</th>
                                <th>Genre</th>
                                <th>Duration</th>
                                <th>
                                    <!-- Reviews icon -->
                                    <i class="fas fa-comments"></i>
                                </th>
                                <th>
                                    <!-- Views icon -->
                                    <i class="fas fa-eye"></i>
                                </th>
                                <th>Status</th>
                                <th>Release Date</th>
                                <th>Added At</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody id="movie-table-body">
                            <?php $i=0?>
                            <?php foreach($movies as $movie):?>
                                <tr id="row_<?= htmlspecialchars($movie['id']) ?>">
                                    <!-- Row Number -->
                                    <td class="row-number"><?= ++$i ?></td>
                                    <td>
                                        <img 
                                            src="<?php echo ASSETS.$movie['thumbnail']?>"
                                            alt="<?= $movie['title']?>"
                                            style="width: 50px; height: 70px;"
                                        >
                                    </td>
                                    <td><?= $movie['title']?></td>
                                    <td><?= $movie['genre']?></td>
                                    <td><?= formatMovieDuration($movie['duration'])?></td>
                                    <td><?= $movie['comments_count']?></td>
                                    <td><?= $movie['views_count']?></td>
                                    <td><?= $movie['status']?></td>
                                    <td><?= formatDate($movie['release_date'])?></td>
                                    <td><?= formatDate($movie['created_at'])?></td>
                                    <td>
                                        <a
                                            href="javascript:void(0);"
                                            class="btn btn-danger btn-circle btn-sm remove_movie_btn"
                                            data-movie-id="<?= htmlspecialchars($movie['id']) ?>"
                                            title="Delete Movie"
                                        >
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <a 
                                            href="javascript:void(0);"
                                            class="btn btn-primary btn-circle btn-sm edit_movie_btn"
                                            data-toggle="modal" 
                                            data-target="#editMovieModal" 
                                            data-movie-id="<?= htmlspecialchars($movie['id']) ?>" 
                                            data-title="<?= htmlspecialchars($movie['title']) ?>" 
                                            data-genre-id="<?= htmlspecialchars($movie['genre_id'] ?? '') ?>" 
                                            data-duration="<?= htmlspecialchars($movie['duration']) ?>" 
                                            data-status="<?= htmlspecialchars($movie['status']) ?>" 
                                            data-release-date="<?= htmlspecialchars($movie['release_date']) ?>" 
                                            data-thumbnail="<?= htmlspecialchars($movie['thumbnail']) ?>"
                                            data-file-name="<?= htmlspecialchars($movie['file_name'] ?? '') ?>" 
                                            data-description="<?= htmlspecialchars($movie['description'] ?? '') ?>" 
                                            data-quality="<?= htmlspecialchars($movie['quality'] ?? '') ?>" 
                                            title="Edit Movie"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </a>

                                    </td>
                                </tr>
                            <?php endforeach?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Movie Modal -->
    <div class="modal fade" id="editMovieModal" tabindex="-1" aria-labelledby="editMovieModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editMovieModalLabel">
                        <i class="fas fa-film"></i> Edit Movie Details
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <form id="editMovieForm">
                        <input type="hidden" id="edit_movie_id" name="movie_id">

                        <div class="row">
                            <!-- Thumbnail -->
                            <div class="col-md-4 text-center">
                                <div class="position-relative">
                                    <img 
                                        id="edit_movie_thumbnail" 
                                        src="" 
                                        alt="Movie Thumbnail" 
                                        class="img-fluid rounded mb-3 shadow"
                                        style="width: 100%; height: auto; max-height: 250px;"
                                    >
                                    <small class="text-muted d-block">Thumbnail Preview</small>
                                </div>
                            </div>

                            <!-- Movie Details -->
                            <div class="col-md-8">
                                <div class="p-3 border rounded bg-light">
                                    <!-- Title -->
                                    <div class="form-group">
                                        <label for="edit_movie_title" class="font-weight-bold">Title</label>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            id="edit_movie_title" 
                                            name="title" 
                                            placeholder="Enter movie title"
                                            required
                                        >
                                    </div>

                                    <!-- Genre -->
                                    <div class="form-group">
                                        <label for="edit_movie_genre" class="font-weight-bold">Genre</label>
                                        <select 
                                            class="form-control" 
                                            id="edit_movie_genre" 
                                            name="genre_id"
                                            required
                                        >
                                            <option value="">Select Genre</option>
                                            <?php foreach ($genres as $genre): ?>
                                                <option value="<?= htmlspecialchars($genre['id']) ?>">
                                                    <?= htmlspecialchars($genre['name']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>


                                    <!-- Duration -->
                                    <div class="form-group">
                                        <label for="edit_movie_duration" class="font-weight-bold">Duration (in seconds)</label>
                                        <input 
                                            type="number" 
                                            class="form-control" 
                                            id="edit_movie_duration" 
                                            name="duration" 
                                            placeholder="Enter duration"
                                            min="1"
                                            required
                                        >
                                    </div>

                                    <!-- Status -->
                                    <div class="form-group">
                                        <label for="edit_movie_status" class="font-weight-bold">Status</label>
                                        <select 
                                            class="form-control" 
                                            id="edit_movie_status" 
                                            name="status"
                                            required
                                        >
                                            <option value="available">Available</option>
                                            <option value="unavailable">Unavailable</option>
                                        </select>
                                    </div>

                                    <!-- Quality -->
                                    <div class="form-group">
                                        <label for="edit_movie_quality" class="font-weight-bold">Quality</label>
                                        <select 
                                            class="form-control" 
                                            id="edit_movie_quality" 
                                            name="quality"
                                        >
                                            <option value="720p">720p</option>
                                            <option value="1080p">1080p</option>
                                            <option value="1440p">1440p</option>
                                            <option value="4K">4K</option>
                                        </select>
                                    </div>

                                    <!-- Release Date -->
                                    <div class="form-group">
                                        <label for="edit_movie_release_date" class="font-weight-bold">Release Date</label>
                                        <input 
                                            type="date" 
                                            class="form-control" 
                                            id="edit_movie_release_date" 
                                            name="release_date"
                                            required
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- File Name and Description -->
                        <div class="form-group mt-3">
                            <label for="edit_movie_file_name" class="font-weight-bold">File Name</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="edit_movie_file_name" 
                                name="file_name" 
                                placeholder="Enter media file name"
                            >
                        </div>

                        <div class="form-group">
                            <label for="edit_movie_description" class="font-weight-bold">Description</label>
                            <textarea 
                                class="form-control" 
                                id="edit_movie_description" 
                                name="description" 
                                rows="4" 
                                placeholder="Enter movie description"
                            ></textarea>
                        </div>
                    </form>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-success" id="saveMovieChangesBtn">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>


<?php require ADMINVIEWS."layouts/footer.php"; ?>
