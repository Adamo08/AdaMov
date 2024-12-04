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
                            <?php $i=0?>
                            <?php foreach($users as $user):?>
                                <tr id="row_<?= $user['id']?>">
                                    <td class="row-number"><?= ++$i?></td>
                                    <td>
                                        <img 
                                            src="<?= ASSETS.$user['avatar']?>" 
                                            alt="User Avatar" 
                                            class="img-fluid"
                                            style="width: 50px; height: 50px;"
                                        >
                                    </td>
                                    <td>
                                        <?= $user['fname']?>
                                    </td>
                                    <td>
                                        <?= $user['lname']?>
                                    </td>
                                    <td>
                                        <?= $user['address']?>
                                    </td>
                                    <td>
                                        <?= $user['email']?>
                                    </td>
                                    <td>
                                        <?= formatDate($user['created_at'])?>
                                    </td>
                                    <td>
                                        <a 
                                            href="" 
                                            class="btn btn-danger btn-circle btn-sm remove_user_btn"
                                            data-user-id="<?= $user['id']?>"
                                        >
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <a 
                                            href="" 
                                            class="btn btn-primary btn-circle btn-sm edit_user_btn" 
                                            data-toggle="modal" 
                                            data-target="#editUserModal" 
                                            data-user-id="<?= $user['id'] ?>" 
                                            data-fname="<?= $user['fname'] ?>" 
                                            data-lname="<?= $user['lname'] ?>" 
                                            data-address="<?= $user['address'] ?>" 
                                            data-email="<?= $user['email'] ?>" 
                                            data-avatar="<?= ASSETS . $user['avatar'] ?>"
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
                            <img id="edit_user_avatar" src="" alt="User Avatar" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px;">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="edit_user_avatar_file" name="avatar">
                                <label class="custom-file-label" for="edit_user_avatar_file">Choose new avatar</label>
                            </div>
                        </div>

                        <!-- User Details -->
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="edit_user_fname">First Name</label>
                                <input type="text" class="form-control" id="edit_user_fname" name="fname" placeholder="Enter first name">
                            </div>
                            <div class="form-group">
                                <label for="edit_user_lname">Last Name</label>
                                <input type="text" class="form-control" id="edit_user_lname" name="lname" placeholder="Enter last name">
                            </div>
                            <div class="form-group">
                                <label for="edit_user_address">Address</label>
                                <input type="text" class="form-control" id="edit_user_address" name="address" placeholder="Enter address">
                            </div>
                            <div class="form-group">
                                <label for="edit_user_email">Email Address</label>
                                <input type="email" class="form-control" id="edit_user_email" name="email" placeholder="Enter email">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveChangesBtn">Save Changes</button>
            </div>
        </div>
    </div>
</div>


<?php require ADMINVIEWS."layouts/footer.php"; ?>
