<?php require ADMINVIEWS."layouts/header.php"; ?>

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="mb-4">
            <h1 class="h3 mb-0 text-gray-800">Genres</h1>
        </div>

        <pre>
            <?php //print_r($genres)?>
        </pre>

        <!-- Genres DataTales -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Genres DataTable</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Total Movies</th>
                                <th>Added At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Total Movies</th>
                                <th>Added At</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody id="genre-table-body">
                            <?php $i=0?>
                            <?php foreach($genres as $genre):?>
                                <tr>
                                    <td>
                                        <?php echo ++$i; ?>
                                    </td>
                                    <td>
                                        <?php echo $genre['name']?>
                                    </td>
                                    <td>
                                        <?php echo $genre['description']?>
                                    </td>
                                    <td>
                                        <?php echo $genre['total_movies']?>
                                    </td>
                                    <td>
                                        <?php echo formatDate($genre['created_at'])?>
                                    </td>
                                    <td>
                                        <a 
                                            href="javascript:void(0);" 
                                            class="btn btn-danger btn-circle btn-sm remove_genre_btn"
                                            data-genre-id="<?= htmlspecialchars($genre['id']) ?>"
                                            title="Delete Genre"
                                        >
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <a 
                                            href="javascript:void(0);" 
                                            class="btn btn-primary btn-circle btn-sm edit_genre_btn"
                                            data-toggle="modal" 
                                            data-target="#editGenreModal"
                                            data-genre-id="<?= htmlspecialchars($genre['id']) ?>"
                                            data-genre-name="<?= htmlspecialchars($genre['name']) ?>"
                                            data-genre-description="<?= htmlspecialchars($genre['description']) ?>"
                                            title="Edit Genre"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>



    <!-- Edit Genre Modal -->
    <div class="modal fade" id="editGenreModal" tabindex="-1" aria-labelledby="editGenreModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editGenreModalLabel">Edit Genre</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editGenreForm">
                        <input type="hidden" id="genreId" name="genreId">
                        
                        <!-- Genre Name -->
                        <div class="mb-3">
                            <label for="genreName" class="form-label">Genre Name</label>
                            <input type="text" class="form-control" id="genreName" name="name" required>
                        </div>
                        
                        <!-- Genre Description -->
                        <div class="mb-3">
                            <label for="genreDescription" class="form-label">Genre Description</label>
                            <textarea class="form-control" id="genreDescription" name="description" rows="4" required></textarea>
                        </div>
                        
                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                <i class="fas fa-times"></i> Cancel
                            </button>
                            <button type="button" class="btn btn-success" id="saveGenreChangesBtn">
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


<?php require ADMINVIEWS."layouts/footer.php"; ?>
