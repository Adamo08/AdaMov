<?php require VIEWS."layouts/header.php"; ?>


    <div class="container text-white">
        <div class="main-body">
            
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="main-breadcrumb">
                <ol class="breadcrumb bg-transparent text-white">
                    <li class="breadcrumb-item"><a href="<?php echo url(""); ?>" class="text-primary">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)" class="text-primary">User</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Profile</li>
                </ol>
            </nav>
            <!-- /Breadcrumb -->
            
            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                    <div class="card bg-transparent border-0 shadow-lg">

                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img 
                                    src="
                                        <?php 
                                            if (!empty($avatar)) {
                                                echo ASSETS . $avatar; 
                                            } else {
                                                echo 'https://ui-avatars.com/api/?background=0D8ABC&color=fff&rounded=true&name=' . urlencode($user['fname'].' '.$user['lname']);
                                            }
                                        ?>"
                                    alt="Avatar" 
                                    class="rounded-circle mb-3" 
                                    width="150"
                                >
                                <div class="mt-3">
                                    <h4>
                                        <?php echo $user['fname'].' '.$user['lname']; ?>
                                    </h4>
                                    <p class="text-light font-size-sm">
                                        <?php echo $user['address']; ?>
                                    </p>
                                    <!-- Custom File Input -->
                                    <label 
                                        for="avatarUpload" 
                                        class="btn btn-primary btn-sm mt-2"
                                    >
                                        Upload New Avatar
                                    </label>
                                    <input 
                                        type="file" 
                                        id="avatarUpload" 
                                        accept="image/*" 
                                        style="display: none;" 
                                    >
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card mt-3 bg-transparent border-0 shadow-lg">
                        <ul class="list-group list-group-flush bg-transparent">
                            <?php foreach($social_links as $key => $value): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap bg-transparent border-0 text-white">
                                    <i class="fa fa-<?php echo strtolower($key); ?>"></i>
                                    <span class="text-secondary">
                                        <a 
                                            href="<?php echo htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); ?>" 
                                            target="_blank"
                                            class="text-primary"
                                        >
                                            <?php echo ucfirst($key); ?>
                                        </a>
                                    </span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card mb-3 bg-transparent border-0 shadow-lg">
                        <div class="card-body text-white">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">First Name</h6>
                                </div>
                                <div class="col-sm-9 text-light">
                                    <?php echo $user['fname'] ?>
                                </div>
                            </div>
                            <hr class="bg-light">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Last Name</h6>
                                </div>
                                <div class="col-sm-9 text-light">
                                    <?php echo $user['lname'] ?>
                                </div>
                            </div>
                            <hr class="bg-light">
                            <div class="row">
                                <div class="col-sm-3">
                                <h6 class="mb-0">Email</h6>
                                </div>
                                <div class="col-sm-9 text-light">
                                    <?php echo $user['email']; ?>
                                </div>
                            </div>
                            <hr class="bg-light">
                            <div class="row">
                                <div class="col-sm-3">
                                <h6 class="mb-0">Address</h6>
                                </div>
                                <div class="col-sm-9 text-light">
                                    <?php echo $user['address']; ?>
                                </div>
                            </div>
                            <hr class="bg-light">
                            <div class="row">
                                <div class="col-sm-12">
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Update Profile</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row gutters-sm shadow-lg">
                        <div class="col-12">
                            <div class="card bg-transparent border-0">
                                <div class="card-header text-white">
                                    <h5>Recently Added Favorites</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover text-light">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Image</th>
                                                    <th scope="col">Title</th>
                                                    <th scope="col">Description</th>
                                                    <th scope="col">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(!empty($recent_favorites)):?>
                                                    <?php $i = 0; ?>
                                                    <?php foreach($recent_favorites as $favorite): ?>
                                                        <tr>
                                                            <th scope="row"><?= ++$i ?></th>
                                                            <td>
                                                                <img 
                                                                    src="<?php echo ASSETS.$favorite['thumbnail']; ?>" 
                                                                    alt="<?php echo $favorite['title']; ?>" 
                                                                    height="50"
                                                                    width="50"
                                                                    class="img-fluid rounded"
                                                                >
                                                            </td>
                                                            <td class="text-white">
                                                                <?php echo $favorite['title']; ?>
                                                            </td>
                                                            <td class="text-white">
                                                                <?php echo $favorite['description']; ?>
                                                            </td>
                                                            <td>
                                                                <a href="<?php echo url("movies/show/".$favorite['id'])?>" class="text-success pr-1" title="Visit">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                                <button 
                                                                    class="btn btn-link text-danger remove_from_favorites p-0" 
                                                                    title="Delete"
                                                                    data-user-id="<?php echo $userId?>"
                                                                    data-movie-id="<?php echo $favorite['id']?>"
                                                                >
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        No Favorites Added Yet. Browse <a href="<?= url("genres/")?>">Genres</a> And Try To Add Movies To Favorites
                                                    </tr>
                                                <?php endif;?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="updateProfileForm" novalidate>
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Profile</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- First Name -->
                        <div class="form-group">
                            <label for="firstName">First Name</label>
                            <div class="input-group">
                                <input 
                                    type="text" class="form-control" 
                                    id="firstName" 
                                    name="firstName" 
                                    placeholder="First Name" 
                                    value="<?php echo $user['fname']; ?>" 
                                    required
                                >
                                <div class="invalid-feedback">Please provide a valid first name.</div>
                            </div>
                        </div>

                        <!-- Last Name -->
                        <div class="form-group">
                            <label for="lastName">Last Name</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name" value="<?php echo $user['lname']; ?>" required>
                                <div class="invalid-feedback">Please provide a valid last name.</div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email">Email</label>
                            <div class="input-group">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $user['email']; ?>" required>
                                <div class="invalid-feedback">Please provide a valid email address.</div>
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="form-group">
                            <label for="address">Address</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="<?php echo $user['address']; ?>" required>
                                <div class="invalid-feedback">Please provide a valid address.</div>
                            </div>
                        </div>
                        <!-- Social Links -->
                        <h6 class="mt-4">Social Profiles</h6>
                        <?php foreach ($social_links as $key => $value): ?>
                            <div class="form-group">
                                <label for="social_<?php echo $key; ?>"><?php echo ucfirst($key); ?></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-<?php echo strtolower($key); ?>"></i></span>
                                    </div>
                                    <input 
                                        type="url" 
                                        class="form-control" 
                                        id="social_<?php echo $key; ?>" 
                                        name="social[<?php echo $key; ?>]" 
                                        placeholder="<?php echo ucfirst($key); ?> URL" 
                                        value="<?php echo htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); ?>" 
                                        required>
                                    <div class="invalid-feedback">Please provide a valid <?php echo ucfirst($key); ?> URL.</div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="update_profile" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



<?php require VIEWS."layouts/footer.php"; ?>
