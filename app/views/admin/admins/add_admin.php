<?php require ADMINVIEWS."layouts/header.php"; ?>

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add New Admin</h1>
        <p class="text-muted">Fill in the details below to register a new admin for the system.</p>
    </div>

    <!-- Add Admin Form -->
    <div class="row">
        <div class="col-lg-12 mx-auto">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Admin Details</h6>
                </div>
                <div class="card-body">
                    <form action="/AdaMov/public/admin/add_admin" method="POST" enctype="multipart/form-data" id="addAdminForm">
                        
                        <!-- Hidden Input for Current Admin ID -->
                        <input type="hidden" name="added_by" value="<?= $_SESSION['admin_id'] ?>">

                        <!-- First Name -->
                        <div class="form-group">
                            <label for="firstName">First Name</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="firstName" 
                                name="first_name" 
                                placeholder="Enter first name" 
                                required
                            >
                        </div>

                        <!-- Last Name -->
                        <div class="form-group">
                            <label for="lastName">Last Name</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="lastName" 
                                name="last_name" 
                                placeholder="Enter last name" 
                                required
                            >
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input 
                                type="email" 
                                class="form-control" 
                                id="email" 
                                name="email" 
                                placeholder="Enter email address" 
                                required
                                >
                        </div>

                        <!-- Avatar Upload -->
                        <div class="form-group">
                            <label for="avatar">Avatar</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input 
                                        type="file" 
                                        class="custom-file-input" 
                                        id="avatar" 
                                        name="avatar" 
                                        accept=".jpg, .jpeg, .png" 
                                        required
                                    >
                                    <label class="custom-file-label" for="avatar">Choose file</label>
                                </div>
                            </div>
                            <small class="form-text text-muted">
                                Allowed formats: JPG, JPEG, PNG. Maximum size: 2MB.
                            </small>
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input 
                                type="password" 
                                class="form-control" 
                                id="password" 
                                name="password" 
                                placeholder="Enter password" 
                                required
                            >
                            <small class="form-text text-muted">
                                Password must be at least 8 characters long.
                            </small>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-user-plus"></i> Add Admin
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<?php require ADMINVIEWS."layouts/footer.php"; ?>
