    <?php require VIEWS."layouts/header.php"; ?>


    <?php 

        $Genre = new Genre();
        $Movie = new Movie();
        $Review = new Review();

        $genres = $Genre->all();
        $movies = $Movie->all();
        $hero_movies = array_slice($movies,0,4);

        // Trending movies
        $trending_movies = $Movie->getTrendingMovies(6,500);
        
    
    ?>


    <!-- Hero Section Begin -->
    <section class="hero">
        <div class="container">
            <div class="hero__slider owl-carousel">

                <?php foreach ($hero_movies as $movie) : ?>
                    <div 
                        class="hero__items set-bg"
                        data-setbg="<?php echo ASSETS.$movie['thumbnail']?>"
                    >
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="hero__text">
                                    <div class="label">
                                        <?= $Genre->getName($movie['genre_id']) ?>
                                    </div>
                                    <h2>
                                        <?= $movie['title'] ?>
                                    </h2>
                                    <p>
                                        <?= $movie['description'] ?>
                                    </p>
                                    <a href="<?php echo url("movies/watch/".$movie['id'])?>"><span>Watch Now</span> <i class="fa fa-angle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">

                <div class="col-lg-8">

                    <!-- Trending movies section started  -->
                    <div class="section__product">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8">
                                <div class="section-title">
                                    <h4>Trending Now</h4>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="btn__all">
                                    <a href="<?php echo url("genres");?>" class="primary-btn">View All <span class="arrow_right"></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <?php foreach ($trending_movies as $movie) : ?>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="product__item">
                                        <div class="product__item__pic set-bg" data-setbg="<?php echo ASSETS.$movie['thumbnail']?>">
                                            <div class="ep">
                                                <?php for($i=0;$i<$Review->getTotalRating($movie['id']);$i++) : ?>
                                                    <i class="fa fa-star"></i>
                                                <?php endfor; ?>
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
                                                <li class="bg-success">Active</li>
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
                    <!-- Trending movies section ended  -->

                    <!-- Genres section started -->

                    <?php foreach($genres as $genre) : ?>
                        <div class="section__product mt-4">
                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <div class="section-title">
                                        <h4><?= $genre['name']?> Movies</h4>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <div class="btn__all">
                                        <a href="<?php echo url("genres/show/".$genre['name']);?>" class="primary-btn">View All <span class="arrow_right"></span></a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <?php foreach ($Movie->getMovies($genre['id'],3) as $movie) : ?>
                                    <div class="col-lg-4 col-md-6 col-sm-6">
                                        <div class="product__item">
                                            <div class="product__item__pic set-bg" data-setbg="<?php echo ASSETS.$movie['thumbnail']?>">
                                                <div class="ep">
                                                    <?php for($i=0;$i<$Review->getTotalRating($movie['id']);$i++) : ?>
                                                        <i class="fa fa-star"></i>
                                                    <?php endfor; ?>
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
                                                    <li class="bg-success">Active</li>
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
                        <div class="product__sidebar__comment__item">
                            <div class="product__sidebar__comment__item__pic">
                                <img src="assets/images/sidebar/comment-1.jpg" alt="">
                            </div>
                            <div class="product__sidebar__comment__item__text">
                                <ul>
                                    <li>Active</li>
                                    <li>Movie</li>
                                </ul>
                                <h5><a href="#">The Seven Deadly Sins: Wrath of the Gods</a></h5>
                                <span><i class="fa fa-eye"></i> 19.141 Viewes</span>
                            </div>
                        </div>
                        <div class="product__sidebar__comment__item">
                            <div class="product__sidebar__comment__item__pic">
                                <img src="assets/images/sidebar/comment-2.jpg" alt="">
                            </div>
                            <div class="product__sidebar__comment__item__text">
                                <ul>
                                    <li>Active</li>
                                    <li>Movie</li>
                                </ul>
                                <h5><a href="#">Shirogane Tamashii hen Kouhan sen</a></h5>
                                <span><i class="fa fa-eye"></i> 19.141 Viewes</span>
                            </div>
                        </div>
                        <div class="product__sidebar__comment__item">
                            <div class="product__sidebar__comment__item__pic">
                                <img src="assets/images/sidebar/comment-3.jpg" alt="">
                            </div>
                            <div class="product__sidebar__comment__item__text">
                                <ul>
                                    <li>Active</li>
                                    <li>Movie</li>
                                </ul>
                                <h5><a href="#">Kizumonogatari III: Reiket su-hen</a></h5>
                                <span><i class="fa fa-eye"></i> 19.141 Viewes</span>
                            </div>
                        </div>
                        <div class="product__sidebar__comment__item">
                            <div class="product__sidebar__comment__item__pic">
                                <img src="assets/images/sidebar/comment-4.jpg" alt="">
                            </div>
                            <div class="product__sidebar__comment__item__text">
                                <ul>
                                    <li>Active</li>
                                    <li>Movie</li>
                                </ul>
                                <h5><a href="#">Monogatari Series: Second Season</a></h5>
                                <span><i class="fa fa-eye"></i> 19.141 Viewes</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Product Section End -->


    <?php require VIEWS."layouts/footer.php"; ?>