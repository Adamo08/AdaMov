<?php require VIEWS."layouts/header.php"; ?>

    <style>
        .rating i {
            font-size: 24px;
            color: #ccc;
        }

        .rating i.hovered, .rating i.selected {
            color: #f39c12;
        }
    </style>


    <?php 
        $ReviewModel = new Review();
        $UserModel = new User();
        $reviews = $ReviewModel->getAllReviewsByMovie($id);
    ?>


    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="./index.html"><i class="fa fa-home"></i> Home</a>
                        <a href="./categories.html">Categories</a>
                        <span>
                            <?php echo $category; ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Anime Section Begin -->
    <section class="anime-details spad">
        <div class="container">
            <div class="anime__details__content">
                <div class="row align-items-center">
                    <div class="col-lg-3">
                        <div class="anime__details__pic set-bg" data-setbg="<?php echo ASSETS.$movie['thumbnail']?>">
                            <div class="comment">
                                <i class="fa fa-comments"></i>
                                <?php echo $movie['comments_count']?>
                            </div>
                            <div class="view">
                                <i class="fa fa-eye"></i>
                                <?php echo $movie['views_count']?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="anime__details__text">
                            <div class="anime__details__title">
                                <h3>
                                    <?php echo $movie['title']?>
                                </h3>
                            </div>
                            <p>
                                <?php echo $movie['description']?>
                            </p>
                            <div class="anime__details__widget">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <ul>
                                            <li>
                                                <span>Genre:</span>
                                                <?php echo $category?>
                                            </li>
                                            <li>
                                                <span>Release Date:</span>
                                                <?php echo $movie['release_date']?>
                                            </li>
                                            <li>
                                                <span>Status:</span>
                                                <?php echo $movie['status']?>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <ul>
                                            <li>
                                                <span>Duration:</span> 
                                                <?php echo round($movie['duration'] / 60) ?> Min
                                            </li>
                                            <li>
                                                <span>Quality:</span>
                                                <?php echo $movie['quality']?>
                                            </li>
                                            <li>
                                                <span>Views:</span>
                                                <?php echo $movie['views_count']?>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="anime__details__btn">
                                <a 
                                    href="#" 
                                    class="follow-btn btn <?= !$isLoggedIn ? 'disabled' : ''; ?>" 
                                    id="add_to_favorites" 
                                    <?= !$isLoggedIn ? 'aria-disabled="true"' : ''; ?>
                                    data-movie-id="<?= $id; ?>"
                                    data-user-id="<?= @$_SESSION['user_id']; ?>"
                                >
                                    <i class="fa fa-heart-o"></i> 
                                    <span>Add to favorites</span>
                                </a>
                                <a 
                                    href="<?= $isLoggedIn ? url('movies/watch/' . $movie['id']) : '#'; ?>" 
                                    class="watch-btn btn <?= !$isLoggedIn ? 'disabled' : ''; ?>" 
                                    <?= !$isLoggedIn ? 'aria-disabled="true"' : ''; ?>
                                >
                                    <span>Watch Now</span> 
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-8">
                    <div class="anime__details__review">
                        <div class="section-title">
                            <h5>Reviews</h5>
                        </div>
                        <?php if($isLoggedIn): ?>
                            <?php if (!empty($reviews)):?>
                                <?php foreach($reviews as $review): ?>
                                    <div class="anime__review__item">
                                        <div class="anime__review__item__pic">
                                            <img src="<?=ASSETS.$UserModel->getAvatar($review['user_id'])?>" alt="">
                                        </div>
                                        <div class="anime__review__item__text">
                                            <h6>
                                                <?= ucfirst($UserModel->getfullName($review['user_id']))?>
                                                <span>
                                                    <?= getTimeAgo($ReviewModel->getReviewPassesSeconds($review['id']))?>
                                                </span>
                                            </h6>
                                            <p><?= $review['review']?></p>
                                        </div>
                                    </div>
                                <?php endforeach;?>
                            <?php else:?>
                                <div class="alert alert-info p-5">
                                    <p>No reviews yet for this movie. Be the first one to comment</p>
                                </div>
                            <?php endif;?>
                        <?php else: ?>
                            <div class="alert alert-danger text-center p-3" role="alert" style="border-radius: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
                                <strong>Oops!</strong> You need to 
                                <a href="<?php echo url('auth/'); ?>" class="alert-link" style="text-decoration: underline;">
                                    log in
                                </a> 
                                to see the reviews for this movie.
                            </div>

                        <?php endif; ?>
                    </div>
                    <div class="anime__details__form">
                        <div class="section-title">
                            <h5>Your Comment</h5>
                        </div>
                        <form action="">
                            <textarea 
                                placeholder="Your Comment" <?= !$isLoggedIn ? 'disabled' : ''; ?>
                                name="comment" 
                                id="comment" 
                            >
                            </textarea>
                            <!-- Star Rating Section -->
                            <div class="rating mb-3" id="star_rating">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i 
                                        class="fa fa-star-o" 
                                        data-rating="<?= $i; ?>" 
                                        style="cursor: pointer;"
                                    ></i>
                                <?php endfor; ?>
                            </div>
                            <input type="hidden" id="rating_value" name="rating" value="0">

                            <?php if($isLoggedIn): ?>
                                <button 
                                    type="button"
                                    id="add_comment"
                                    data-movie-id="<?= $id; ?>"
                                    data-user-id="<?= @$_SESSION['user_id']; ?>"
                                >
                                    <i class="fa fa-location-arrow"></i> 
                                    Review
                                </button>
                            <?php else: ?>
                                <button type="text" disabled>
                                    <i class="fa fa-warning"></i> 
                                    Login to add your review
                                </button>
                            <?php endif;?>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="anime__details__sidebar">
                        <div class="section-title">
                            <h5>you might like...</h5>
                        </div>
                        <?php foreach($related_movies as $related_movie): ?>
                            <div class="product__sidebar__view__item set-bg" data-setbg="<?php echo ASSETS.$related_movie['thumbnail']?>">
                                <div class="ep">
                                    <?php displayRating($movie['id']); ?>
                                </div>
                                <div class="view">
                                    <i class="fa fa-eye"></i>
                                    <?php echo $related_movie['views_count']?>
                                </div>
                                <h5>
                                    <a 
                                        href="<?php echo url("movies/show/".$related_movie['id'])?>"
                                        class="px-2 bg-success text-white rounded"
                                    >
                                        <?= $related_movie['title']?>
                                    </a>
                            </h5>
                            </div>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Anime Section End -->


    <!-- Jquery  -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Script js to handle adding movies to favorites  -->
    <script src="<?php echo JS;?>ajax_requests.js"></script>

<?php require VIEWS."layouts/footer.php"; ?>
