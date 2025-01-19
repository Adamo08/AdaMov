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
                        <tbody id="user-table-body">
                            <?php 
                                $i = 0;
                                $placeholder_img = ASSETS . "avatars/placeholder_avatar.png";
                            ?>
                            <?php foreach ($users as $user): ?>
                                <tr id="row_<?= htmlspecialchars($user['id']) ?>">
                                    <!-- Row Number -->
                                    <td class="row-number"><?= ++$i ?></td>
                                    
                                    <!-- User Avatar -->
                                    <td>
                                        <img 
                                            src="<?= htmlspecialchars($user['avatar'] ? ASSETS . $user['avatar'] : $placeholder_img) ?>" 
                                            alt="<?= htmlspecialchars($user['fname'] . " " . $user['lname']) ?>'s Avatar" 
                                            class="img-fluid rounded-circle"
                                            style="width: 50px; height: 50px;"
                                        >
                                    </td>
                                    
                                    <!-- User First Name -->
                                    <td><?= htmlspecialchars($user['fname']) ?></td>
                                    
                                    <!-- User Last Name -->
                                    <td><?= htmlspecialchars($user['lname']) ?></td>
                                    
                                    <!-- User Address (with fallback and styling) -->
                                    <td>
                                        <?= $user['address'] ?? '<span style="font-weight: bold; color: #ff0000;">N/A</span>' ?>
                                    </td>
                                    
                                    <!-- User Email -->
                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                    
                                    <!-- Account Creation Date -->
                                    <td><?= formatDate($user['created_at']) ?></td>
                                    
                                    <!-- Action Buttons -->
                                    <td>
                                        <!-- Delete Button -->
                                        <a 
                                            href="javascript:void(0);" 
                                            class="btn btn-danger btn-circle btn-sm remove_user_btn"
                                            data-user-id="<?= htmlspecialchars($user['id']) ?>"
                                            title="Delete User"
                                        >
                                            <i class="fas fa-trash"></i>
                                        </a>

                                        <!-- Edit Button -->
                                        <a 
                                            href="javascript:void(0);" 
                                            class="btn btn-primary btn-circle btn-sm edit_user_btn" 
                                            data-toggle="modal" 
                                            data-target="#editUserModal" 
                                            data-user-id="<?= htmlspecialchars($user['id']) ?>" 
                                            data-fname="<?= htmlspecialchars($user['fname']) ?>" 
                                            data-lname="<?= htmlspecialchars($user['lname']) ?>" 
                                            data-address="<?= htmlspecialchars($user['address'] ?? '') ?>" 
                                            data-email="<?= htmlspecialchars($user['email']) ?>" 
                                            data-avatar="<?= htmlspecialchars(ASSETS . $user['avatar'] ?? $placeholder_img) ?>"
                                            title="Edit User"
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


    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User Details</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <form id="editUserForm">
                        <input type="hidden" id="edit_user_id" name="user_id">

                        <div class="row">
                            <!-- Avatar -->
                            <div class="col-md-4 text-center">
                                <div class="position-relative">
                                    <img 
                                        id="edit_user_avatar" 
                                        src="" 
                                        alt="User Avatar" 
                                        class="img-fluid rounded-circle mb-3 shadow"
                                        data-toggle="tooltip" 
                                        title="Only the user can update their avatar."
                                    >
                                </div>
                            </div>

                            <!-- User Details -->
                            <div class="col-md-8">
                                <div class="p-3 border rounded bg-light">
                                    <div class="form-group">
                                        <label for="edit_user_fname" class="font-weight-bold">First Name</label>
                                        <input type="text" class="form-control" id="edit_user_fname" name="fname" placeholder="Enter first name">
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_user_lname" class="font-weight-bold">Last Name</label>
                                        <input type="text" class="form-control" id="edit_user_lname" name="lname" placeholder="Enter last name">
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_user_address" class="font-weight-bold">Address</label>
                                        <input type="text" class="form-control" id="edit_user_address" name="address" placeholder="Enter address">
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_user_email" class="font-weight-bold">Email Address</label>
                                        <input type="email" class="form-control" id="edit_user_email" name="email" placeholder="Enter email">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-success" id="saveChangesBtn">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>



<?php require ADMINVIEWS."layouts/footer.php"; ?>
