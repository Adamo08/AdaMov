<!-- Footer Section Begin -->
<footer class="footer">
        <div class="page-up">
            <a href="#" id="scrollToTopButton"><span class="arrow_carrot-up"></span></a>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="footer__logo">
                        <a href="<?php echo url()?>"><img src="<?php echo IMAGES;?>logo.png" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="footer__nav">
                        <ul>
                            <li><a href="<?=url("genres")?>">Genres</a></li>
                            <li><a href="<?=url("home/about")?>">Our Blog</a></li>
                            <li><a href="<?=url("home/contact")?>">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    Copyright &copy;
                    <script>document.write(new Date().getFullYear());</script> 
                    All rights reserved | This template is made with 
                    <i class="fa fa-heart" aria-hidden="true"></i> 
                    by 
                    <a 
                        href="https://colorlib.com"
                        target="_blank"
                    >Colorlib</a>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>

                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End  -->
    
    <!-- Search model Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch"><i class="icon_close"></i></div>
            <div class="search-content text-white">
                <form class="search-model-form" id="search-form">
                    <input 
                        type="text" 
                        id="search-input" 
                        placeholder="Search here....." 
                        autocomplete="off" 
                    >
                </form>
                <div id="search-results" class="mt-4">
                    <!-- Dynamic search results will be loaded here -->
                </div>
            </div>
        </div>
    </div>
    <!-- Search model end -->

    <!-- Js Plugins -->
    <script src="<?php echo JS;?>jquery-3.3.1.min.js"></script>
    <script src="<?php echo JS;?>bootstrap.min.js"></script>
    <script src="<?php echo JS;?>player.js"></script>
    <script src="<?php echo JS;?>jquery.nice-select.min.js"></script>
    <script src="<?php echo JS;?>mixitup.min.js"></script>
    <script src="<?php echo JS;?>jquery.slicknav.js"></script>
    <script src="<?php echo JS;?>owl.carousel.min.js"></script>
    <script src="<?php echo JS;?>main.js"></script>

    <!-- Jquery  -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

    <!-- Script js to handle adding movies to favorites  -->
    <script src="<?php echo JS;?>ajax_requests.js"></script>

</body>

</html>