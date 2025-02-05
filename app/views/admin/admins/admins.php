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
                        <tbody id="admin-table-body">
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
                                            href="javascript:void(0);" 
                                            class="btn btn-danger btn-circle btn-sm remove_admin_btn <?php echo ($admin_id == $admin['id']) ? 'disabled' : ($admin_id != $admin['added_by'] ? 'disabled' : ''); ?>"
                                            data-admin-id="<?php echo htmlspecialchars($admin['id']); ?>"
                                            title="Delete Admin"
                                        >
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        
                                        <!-- Edit Button -->
                                        <a 
                                            href="javascript:void(0);" 
                                            class="btn btn-warning btn-circle btn-sm edit_admin_btn 
                                                <?php echo ($admin_id == $admin['id']) ? '' : ($admin_id != $admin['added_by'] ? 'disabled' : ''); ?>" 
                                            data-toggle="modal" 
                                            data-target="#editAdminModal"
                                            title="Edit Admin"
                                            data-admin-id="<?php echo htmlspecialchars($admin['id']); ?>"
                                            data-admin-fname="<?php echo htmlspecialchars($admin['fname']); ?>"
                                            data-admin-lname="<?php echo htmlspecialchars($admin['lname']); ?>"
                                            data-admin-email="<?php echo htmlspecialchars($admin['email']); ?>"
                                            data-admin-avatar="<?php echo htmlspecialchars("/AdaMov/public/assets/admin/".$admin['avatar']); ?>"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        
                                        <!-- Message Button -->
                                        <a 
                                            href="javascript:void(0);" 
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



    <!-- Edit Admin Modal -->
    <div class="modal fade" id="editAdminModal" tabindex="-1" aria-labelledby="editAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editAdminModalLabel">Edit Admin Details</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <form id="editAdminForm">
                        <input type="hidden" id="edit_admin_id" name="admin_id">

                        <div class="row">
                            <!-- Avatar -->
                            <div class="col-md-4 text-center">
                                <div class="position-relative">
                                    <img 
                                        id="edit_admin_avatar" 
                                        src="" 
                                        alt="Admin Avatar" 
                                        class="img-fluid rounded-circle mb-3 shadow-lg border border-secondary p-1"
                                        data-toggle="tooltip" 
                                        title="Only the admin can update their avatar."
                                        style="cursor: pointer; transition: transform 0.3s;"
                                    >
                                </div>
                            </div>

                            <!-- Admin Details -->
                            <div class="col-md-8">
                                <div class="p-4 border rounded bg-light shadow-sm">
                                    <div class="form-group">
                                        <label for="edit_admin_fname" class="font-weight-bold">First Name</label>
                                        <input type="text" class="form-control" id="edit_admin_fname" name="fname" placeholder="Enter first name">
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_admin_lname" class="font-weight-bold">Last Name</label>
                                        <input type="text" class="form-control" id="edit_admin_lname" name="lname" placeholder="Enter last name">
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_admin_email" class="font-weight-bold">Email Address</label>
                                        <input type="email" class="form-control" id="edit_admin_email" name="email" placeholder="Enter email">
                                    </div>
                                    <div class="form-group position-relative">
                                        <label for="edit_admin_password" class="font-weight-bold">Password</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="edit_admin_password" name="password" placeholder="Enter new password">
                                            <div class="input-group-append">
                                                <span class="input-group-text" style="cursor: pointer;" onclick="togglePassword()">
                                                    <i class="fas fa-eye"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-success" id="saveAdminChangesBtn">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            let passwordField = document.getElementById('edit_admin_password');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
            } else {
                passwordField.type = 'password';
            }
        }
    </script>




<?php require ADMINVIEWS."layouts/footer.php"; ?>
