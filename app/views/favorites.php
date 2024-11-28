<?php require VIEWS . "layouts/header.php"; ?>

<div class="container mt-5">
    <div class="row gutters-sm shadow-lg">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb bg-transparent text-white">
                <li class="breadcrumb-item"><a href="<?php echo url(""); ?>" class="text-primary">Home</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)" class="text-primary">User</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Favorites</li>
            </ol>
        </nav>
        <!-- /Breadcrumb -->
        <div class="col-12">
            <div class="card bg-transparent border-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover text-light">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Genre</th>
                                    <th scope="col">Added At</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($favorites)): ?>
                                    <?php $i = 0; ?>
                                    <?php foreach ($favorites as $favorite): ?>
                                        <tr class="table-item">
                                            <th scope="row"><?= ++$i ?></th>
                                            <td>
                                                <img 
                                                    src="<?php echo ASSETS . $favorite['thumbnail']; ?>" 
                                                    alt="<?php echo $favorite['title']; ?>" 
                                                    height="50"
                                                    width="50"
                                                    class="img-fluid rounded"
                                                    data-toggle="tooltip" 
                                                    title="Click to view movie details"
                                                >
                                            </td>
                                            <td class="text-white">
                                                <?php echo $favorite['title']; ?>
                                            </td>
                                            <td class="text-white">
                                                <?php echo $favorite['description']; ?>
                                            </td>
                                            <td class="text-white">
                                                <a 
                                                    href="<?= url('genres/show/' . urlencode($favorite['genre'])) ?>" 
                                                    class="badge badge-pill badge-primary text-light"
                                                    data-toggle="tooltip" 
                                                    title="View more movies in this genre"
                                                >
                                                    <?php echo $favorite['genre']; ?>
                                                </a>
                                            </td>
                                            <td class="text-white">
                                                <?php echo date('F j, Y', strtotime($favorite['favorite_at'])); ?>
                                            </td>
                                            <td>
                                                <a 
                                                    href="<?php echo url("movies/show/" . $favorite['id']); ?>" 
                                                    class="btn btn-sm btn-outline-success" 
                                                    title="Visit"
                                                    data-toggle="tooltip"
                                                    data-placement="top"
                                                    title="View Movie"
                                                >
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <button 
                                                    class="btn btn-sm remove_from_favorites btn-outline-danger" 
                                                    title="Delete"
                                                    data-user-id="<?php echo $userId?>"
                                                    data-movie-id="<?php echo $favorite['id']?>"
                                                    data-toggle="tooltip"
                                                    data-placement="top"
                                                    title="Remove from favorites"
                                                >
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-white">
                                            <strong>No Favorites Added Yet. Browse <a href="<?= url("genres/") ?>" class="text-light badge-primary rounded px-1">Genres</a> and add some movies to your favorites!</strong>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php require VIEWS . "layouts/footer.php"; ?>


