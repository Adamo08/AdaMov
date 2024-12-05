<?php require ADMINVIEWS."layouts/header.php"; ?>

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="mb-4">
            <h1 class="h3 mb-0 text-gray-800">Admins</h1>
        </div>


        <pre>
            <?php //print_r($admins)?>
        </pre>

        <!-- Movies DataTales -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Admins DataTable</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>##</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Joined At</th>
                                <th>Added By</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>##</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Joined At</th>
                                <th>Added By</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php 
                                $i = 0;
                                $admin_id = $_SESSION['admin_id'];
                            ?>
                            <?php foreach ($admins as $admin): ?>
                                <tr>
                                    <td>
                                        <?php echo ++$i ?>
                                    </td>
                                    <td>
                                        <img 
                                            src="<?php echo ADMINASSETS . $admin['avatar'] ?>" 
                                            alt="Admin Avatar"
                                            width="50"
                                            height="50"
                                        >
                                    </td>
                                    <td>
                                        <?php echo htmlspecialchars($admin['fname'], ENT_QUOTES, 'UTF-8'); ?>
                                    </td>
                                    <td>
                                        <?php echo htmlspecialchars($admin['lname'], ENT_QUOTES, 'UTF-8'); ?>
                                    </td>
                                    <td>
                                        <?php echo formatDate($admin['created_at']); ?>
                                    </td>
                                    <td>
                                        <?php echo htmlspecialchars($admin['added_by'], ENT_QUOTES, 'UTF-8'); ?>
                                    </td>
                                    <td>
                                        <!-- Delete Button -->
                                        <a 
                                            href="" 
                                            class="btn btn-danger btn-circle btn-sm <?php echo ($admin_id == $admin['id']) ? 'disabled' : ($admin_id != $admin['added_by'] ? 'disabled' : ''); ?>" 
                                            title="Delete Admin"
                                        >
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        
                                        <!-- Edit Button -->
                                        <a 
                                            href="edit_admin.php?id=<?php echo $admin['id']; ?>" 
                                            class="btn btn-warning btn-circle btn-sm <?php echo ($admin_id == $admin['id']) ? '' : ($admin_id != $admin['added_by'] ? 'disabled' : ''); ?>" 
                                            title="Edit Admin"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <!-- Message Button -->
                                        <a 
                                            href="message_admin.php?id=<?php echo $admin['id']; ?>" 
                                            class="btn btn-primary btn-circle btn-sm <?php echo ($admin_id == $admin['id']) ? 'disabled' : ''; ?>" 
                                            title="Message Admin"
                                        >
                                            <i class="fas fa-comment"></i>
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
