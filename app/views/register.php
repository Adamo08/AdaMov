    <?php require VIEWS."layouts/header.php"; ?>

    <!-- Normal Breadcrumb Begin -->
    <section class="normal-breadcrumb set-bg" data-setbg="<?php echo IMAGES; ?>normal-breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="normal__breadcrumb__text">
                        <h2>Register</h2>
                        <p>Create your account and join our movie-loving community!</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Normal Breadcrumb End -->

    <!-- Signup Section Begin -->
    <section class="signup spad">
        <div class="container">
            <div class="row">
                <!-- Image Column -->
                <div class="col-md-6 d-flex align-items-center justify-content-center">
                    <img src="https://via.placeholder.com/400x400" alt="Placeholder Image" class="img-fluid">
                </div>
                <!-- Signup Form Column -->
                <div class="col-md-6">
                    <div class="login__form">
                        <!-- Show the error message -->
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger my-5">
                                <?php echo $error; unset($error); ?>
                            </div>
                        <?php endif?>
                        <!-- Show the success (verification email sent) message -->
                        <?php if (isset($success)): ?>
                            <div class="alert alert-success my-5">
                                <?php echo $success; unset($success); ?>
                            </div>
                        <?php endif?>
                        <h3>Sign Up</h3>
                        <form action="<?= url("auth/register")?>" method="POST">
                            <div class="input__item">
                                <input type="text" name="fname" placeholder="First Name">
                                <span class="icon_profile"></span>
                            </div>
                            <div class="input__item">
                                <input type="text" name="lname" placeholder="Last Name">
                                <span class="icon_profile"></span>
                            </div>
                            <div class="input__item">
                                <input class="col-md-12" type="text" name="email" placeholder="Email address">
                                <span class="icon_mail"></span>
                            </div>
                            <div class="input__item">
                                <input type="password" name="password" placeholder="Password">
                                <span class="icon_lock"></span>
                            </div>
                            <button type="submit" class="site-btn">Sign Up</button>
                        </form>
                        <h5>Already have an account? <a href="<?=url("auth/")?>">Log In!</a></h5>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Signup Section End -->

    <?php require VIEWS."layouts/footer.php"; ?>