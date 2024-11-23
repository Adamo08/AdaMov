    <?php require VIEWS."layouts/header.php"; ?>


    <?php 

        $Genre = new Genre();
        $Movie = new Movie();
        $Review = new Review();

        if (isset($category) && strtolower($category) != "all" ){
            $genres = (array) $Genre->getGenreByGenre(ucfirst($category));
        }
        else {
            $genres = $Genre->all();
        }

        $currentCategory = $category ?? "All";
        $categoryExists = !empty($genres);

        $user_id = $isLoggedIn ? $_SESSION['user_id'] : 0;

        $recommended_movies = $Movie->recommendMoviesForUser($user_id);
    
    ?>


    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="<?php echo url();?>"><i class="fa fa-home"></i> Home</a>
                        <a href="<?php echo url("genres")?>">Genres</a>
                        <span>
                            <?php echo ucfirst($currentCategory); ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Genres Section Begin  -->
    <section class="product spad">
        <div class="container">
            <div class="row">

                <div class="col-lg-8">

                    <?php if ($categoryExists):?>
                        <!-- Genres section started -->
                        <?php foreach($genres as $genre) : ?>
                            <div class="section__product mt-4">

                                <div class="row">
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <div class="section-title">
                                            <h4><?= $genre['name']?> Movies</h4>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="row">

                                    <?php 
                                        // Get all movies for the current genre
                                        $movies = $Movie->getMovies($genre['id']);
                                        foreach ($movies as $movie) : 
                                    ?>
                                        <div class="col-lg-4 col-md-6 col-sm-6">
                                            <div class="product__item">
                                                <div class="product__item__pic set-bg" data-setbg="<?php echo ASSETS.$movie['thumbnail']?>">
                                                    <div class="ep">
                                                        <?php displayRating($movie['id']); ?>
                                                    </div>
                                                    <div class="comment">
                                                        <i class="fa fa-comments"></i>
                                                        <?php echo $movie['comments_count']?>
                                                    </div>
                                                    <div class="view">
                                                        <i class="fa fa-eye"></i>
                                                        <?php echo $movie['views_count']?>
                                                    </div>
                                                </div>
                                                <div class="product__item__text">
                                                    <ul>
                                                        <li class="bg-<?= ($movie['status'] == "available") ? "success" : "danger"?>">
                                                            <?= $movie['status']?>
                                                        </li>
                                                        <li>
                                                            <?= $Genre->getName($movie['genre_id']) ?>
                                                        </li>
                                                    </ul>
                                                    <h5>
                                                        <a href="<?php echo url("movies/show/".$movie['id'])?>">
                                                            <?= $movie['title']?>
                                                        </a>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                            </div>
                        <?php endforeach; ?>
                        <!-- Genres section ended -->
                    <?php else:?>
                        <div class="section__product mt-4">
                            <div class="alert alert-danger d-flex align-items-center" style="padding: 15px; border-radius: 5px;">
                                <div style="margin-right: 10px; font-size: 24px;">
                                    <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                </div>
                                <div>
                                    <p style="margin: 0;">No movies found for the selected category. see <a href="<?php echo url("genres/")?>">All</a> instead</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <img src="<?php echo IMAGES?>no_movies.png" alt="No Movies Found">
                            </div>
                        </div>
                    <?php endif?>


                </div>

                <div class="col-lg-4 col-md-6 col-sm-8">
                    <div class="product__sidebar">
                        <div class="product__sidebar__view">
                        </div>
                    </div>
                    <div class="product__sidebar__comment">
                        <div class="section-title">
                            <h5>For You</h5>
                        </div>
                        <?php if ($isLoggedIn): ?>
                            <?php if (!empty($recommended_movies)): ?>
                                <?php foreach ($recommended_movies as $movie): ?>
                                    <div class="product__sidebar__comment__item d-flex align-items-center">
                                        <div class="product__sidebar__comment__item__pic">
                                            <img 
                                                src="<?php echo ASSETS.htmlspecialchars($movie['thumbnail'])?>" 
                                                alt="<?php echo htmlspecialchars($movie['title']); ?>"
                                                width="100" 
                                                height="150"
                                            >
                                        </div>
                                        <div class="product__sidebar__comment__item__text">
                                            <ul>
                                                <li class="bg-<?= ($movie['status'] == "available") ? "success" : "danger"?>">
                                                    <?= $movie['status']?>
                                                </li>
                                                <li>
                                                    <?= $Genre->getName($Movie->getMovieGenre($movie['id']))?>
                                                </li>
                                            </ul>
                                            <h5>
                                                <a 
                                                    href="<?php echo url("movies/show/".$movie['id'])?>"
                                                >
                                                    <?php echo htmlspecialchars($movie['title']); ?>
                                                </a>
                                            </h5>
                                            <span>
                                                <i class="fa fa-eye"></i> 
                                                <?php echo htmlspecialchars($movie['views_count']); ?> Views
                                            </span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="alert alert-info">
                                    No recommended movies available at the moment.
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <p>Please log in to see movie recommendations.</p>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Genres Section End -->

    <?php require VIEWS."layouts/footer.php"; ?>


