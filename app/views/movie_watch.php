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
                        <a href="#">
                            <?php echo $category; ?>
                        </a>
                        <span>
                            <?php echo $movie['title']?>
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
            <div class="row">
                <div class="col-lg-12">
                    <div class="anime__video__player">
                        <video id="player" playsinline controls>
                            <source src="<?= ASSETS.$movie['file_name']?>" type="video/mp4" />
                            <!-- Captions are optional -->
                            <track kind="captions" label="English captions" src="#" srclang="en" default />
                        </video>
                    </div>
                    <!-- <div class="anime__details__episodes">
                        <div class="section-title">
                            <h5>List Name</h5>
                        </div>
                        <a href="#">Ep 01</a>
                        <a href="#">Ep 02</a>
                        <a href="#">Ep 03</a>
                        <a href="#">Ep 04</a>
                        <a href="#">Ep 05</a>
                        <a href="#">Ep 06</a>
                        <a href="#">Ep 07</a>
                        <a href="#">Ep 08</a>
                        <a href="#">Ep 09</a>
                        <a href="#">Ep 10</a>
                        <a href="#">Ep 11</a>
                        <a href="#">Ep 12</a>
                        <a href="#">Ep 13</a>
                        <a href="#">Ep 14</a>
                        <a href="#">Ep 15</a>
                        <a href="#">Ep 16</a>
                        <a href="#">Ep 17</a>
                        <a href="#">Ep 18</a>
                        <a href="#">Ep 19</a>
                    </div> -->
                </div>
            </div>

            <!-- Reviews Section Start  -->
            <div class="row">
                <div class="col-lg-8">
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
            </div>
        </div>
    </section>
    <!-- Anime Section End -->

    <!-- Jquery  -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Script js to handle adding movies to favorites  -->
    <script src="<?php echo JS;?>ajax_requests.js"></script>

<?php require VIEWS."layouts/footer.php"; ?>
