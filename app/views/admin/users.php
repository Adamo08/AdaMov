<?php require ADMINVIEWS."layouts/header.php"; ?>

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="mb-4">
            <h1 class="h3 mb-0 text-gray-800">Users</h1>
        </div>

        <pre>
            <?php //print_r($users)?>
        </pre>

        <!-- Users DataTales -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Users DataTable</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Avatar</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Address</th>
                                <th>Email</th>
                                <th>Joined At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Avatar</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Address</th>
                                <th>Email</th>
                                <th>Joined At</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php $i=0?>
                            <?php foreach($users as $user):?>
                                <tr>
                                    <th><?= ++$i?></th>
                                    <th>
                                        <img 
                                            src="<?= ASSETS.$user['avatar']?>" 
                                            alt="User Avatar" 
                                            class="img-fluid"
                                            style="width: 50px; height: 50px;"
                                        >
                                    </th>
                                    <th>
                                        <?= $user['fname']?>
                                    </th>
                                    <th>
                                        <?= $user['lname']?>
                                    </th>
                                    <th>
                                        <?= $user['address']?>
                                    </th>
                                    <th>
                                        <?= $user['email']?>
                                    </th>
                                    <th>
                                        <?= formatDate($user['created_at'])?>
                                    </th>
                                    <th>
                                        <a href="" class="btn btn-danger btn-circle btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <a href="" class="btn btn-primary btn-circle btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </th>
                                </tr>
                            <?php endforeach?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

<?php require ADMINVIEWS."layouts/footer.php"; ?>
