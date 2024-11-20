    <?php require VIEWS."layouts/header.php"; ?>


    <?php 
        
        if ($isLoggedIn){
            // If a user is already logged in
            header("Location: ".SITE_NAME);
            exit();
        }
    
    ?>

    <!-- Normal Breadcrumb Begin -->
    <section class="normal-breadcrumb set-bg" data-setbg="<?php echo IMAGES; ?>normal-breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="normal__breadcrumb__text">
                        <h2>Login</h2>
                        <p>Access your account and explore the world of movies!</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Normal Breadcrumb End -->

    <!-- Login Section Begin -->
    <section class="login spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="login__form">
                        <!-- Show the verification success message -->
                        <?php if (isset($verify_success)): ?>
                            <div class="alert alert-success my-5">
                                <?php echo $verify_success; unset($verify_success); ?>
                            </div>
                        <?php endif?>
                        <?php if (isset($failed)): ?>
                            <div class="alert alert-danger my-5">
                                <?php echo $failed; unset($failed); ?>
                            </div>
                        <?php endif?>
                        <h3>Login</h3>
                        <form action="<?=url("auth/login")?>" method="POST">
                            <div class="input__item">
                                <input type="text" name="email" placeholder="Email address">
                                <span class="icon_mail"></span>
                            </div>
                            <div class="input__item">
                                <input type="password" name="password" placeholder="Password">
                                <span class="icon_lock"></span>
                            </div>
                            <button type="submit" class="site-btn">Login Now</button>
                        </form>
                        <a href="#" class="forget_pass">Forgot Your Password?</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login__register">
                        <h3>Don't Have An Account?</h3>
                        <a href="<?=url("auth/signup")?>" class="primary-btn">Register Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Login Section End -->

    <?php require VIEWS."layouts/footer.php"; ?>
