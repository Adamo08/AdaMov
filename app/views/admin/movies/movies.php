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
                                            class="btn btn-primary btn-circle btn-sm"
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

<?php require ADMINVIEWS."layouts/footer.php"; ?>
