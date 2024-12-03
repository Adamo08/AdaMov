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
                        <tbody>
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
                                        <a href="" class="btn btn-danger btn-circle btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <a href="" class="btn btn-primary btn-circle btn-sm">
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

<?php require ADMINVIEWS."layouts/footer.php"; ?>
