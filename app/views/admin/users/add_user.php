<?php require ADMINVIEWS."layouts/header.php"; ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add New User</h1>
        <p class="text-muted">Fill in the details below to add a new user.</p>
    </div>

    <!-- Add User Form -->
    <div class="row">
        <div class="col-lg-12 mx-auto">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">User Details</h6>
                </div>
                <div class="card-body">
                    <form id="addUserForm" action="" method="POST" enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="firstName">First Name</label>
                                <input type="text" class="form-control" id="firstName" name="first_name" placeholder="Enter first name">
                                <div class="invalid-feedback">Please enter a valid first name.</div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="lastName">Last Name</label>
                                <input type="text" class="form-control" id="lastName" name="last_name" placeholder="Enter last name">
                                <div class="invalid-feedback">Please enter a valid last name.</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="2" placeholder="Enter address"></textarea>
                            <div class="invalid-feedback">Please enter a valid Address.</div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
                            <div class="invalid-feedback">Please enter a valid email address.</div>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                        </div>
                        <div class="form-group">
                            <label for="avatar">Avatar</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="avatar" name="avatar" accept="image/*">
                                <label class="custom-file-label" for="avatar">Choose file</label>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" id="addUserBtn" class="btn btn-primary btn-block">Add User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    // Update file input label with selected file name
    document.querySelector('.custom-file-input').addEventListener('change', function (e) {
        let fileName = e.target.files[0]?.name || "Choose file";
        e.target.nextElementSibling.textContent = fileName;
    });

</script>


<?php require ADMINVIEWS."layouts/footer.php"; ?>
