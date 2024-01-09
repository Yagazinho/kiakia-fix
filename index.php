<?php
include("dashboard/includes/config.php");

include("includes/head.php");
?>


<body>

    <?php include("includes/header.php"); ?>
    <main>
        <section id="banner" class="section px-5 pt-3">
            <div id="mainslider" class="carousel slide" data-ride="carousel">

                <!-- Indicators -->
                <ul class="carousel-indicators">
                    <li data-target="#mainslider" data-slide-to="0" class="active"></li>
                    <li data-target="#mainslider" data-slide-to="1"></li>
                </ul>

                <!-- The slideshow -->
                <div class="carousel-inner rounded-xlg">
                    <div class="carousel-item active slider-img img-1">
                        <div class="carousel-caption">
                            <h3>Get Top Notch Service with a Click</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias veniam, architecto!</p>
                            <a href="" class="btn btn-lg btn-info">Get Help!</a>
                            <a href="" class="btn btn-lg bg-white">Learn More</a>
                        </div>
                    </div>
                    <div class="carousel-item slider-img img-2">
                        <div class="carousel-caption">
                            <h3>High Time You <span class="font-theme text-dark bg-light rounded px-2 py-2">shift+del</span> Panic Mode</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quaerat aspernatur, at.</p>
                            <a href="" class="btn btn-lg bg-white">Learn More</a>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <section id="banner" class="section mt-3 rounded-xlg mx-5 bg-light">
            <div class="container">
                <h3 class="text-center mb-5">Kindly enter your search content below to continue</h3>
                <form action="" class="search-form">
                    <div class="row">
                        <div class="col-10">
                            <input type="text" class="form-control form-control-lg w-100 rounded-xlg">
                        </div>
                        <div class="col-2">
                            <button class="btn btn-lg btn-block btn-dark rounded-xlg">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
        <section id="services" class="section mt-3 px-5 mx-md-5">
            <div class="container">
                <div class="section-header font-theme text-center">
                    <h2>We Offer These Services</h2>
                </div>
                <div class="row mt-5 d-flex justify-content-center">
                    <?php
                    $no = 1;
                    $query = mysqli_query($conStr, "SELECT * FROM services WHERE status='active' LIMIT 6");
                    while($row = mysqli_fetch_array($query)){
                    ?>
                    <div class="col-md-4 mb-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body service-bg img-1 rounded-xlg d-flex justify-content-center align-items-center">
                                <h2 class="card-title text-white"><?= $row['name'] ?></h2>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </section>
        <section id="banner" class="section mt-3 px-5 bg-light mx-md-5 rounded-xlg">
            <div class="container">
                <div class="section-header font-theme text-center">
                    <h2>Top Providers</h2>
                </div>

                <div id="providerSlider" class="carousel slide mt-5" data-ride="carousel">

                    <!-- Indicators -->
                    <ul class="carousel-indicators fancy-indicators">
                        <li data-target="#providerSlider" data-slide-to="0" class="active"></li>
                        <li data-target="#providerSlider" data-slide-to="1"></li>
                    </ul>

                    <!-- The slideshow -->
                    <div class="carousel-inner rounded-xlg">
                        <div class="carousel-item active">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-lg">
                                        <div class="card-body rounded-xlg">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="p-3">
                                                        <img src="assets/media/images/user.png" alt="" class="rounded-circle img-fluid">
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <p class="stars text-right">
                                                        <i class="fa fa-star text-warning mr-2"></i>
                                                        <i class="fa fa-star text-warning mr-2"></i>
                                                        <i class="fa fa-star text-warning mr-2"></i>
                                                        <i class="fa fa-star text-warning mr-2"></i>
                                                        <i class="fa fa-star text-warning mr-2"></i>
                                                    </p>
                                                    <h4 class="card-title">John Doe - <small><em>Barber</em></small></h4>
                                                    <p class="text-muted">
                                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officia nam, amet qui!
                                                    </p>
                                                    <div class="btn-group">
                                                        <a href="" class="btn btn-outline-dark btn-sm rounded-circle" title="View Details">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <a href="" class="btn btn-outline-dark btn-sm rounded-circle ml-2" title="Submit Review">
                                                            <i class="fa fa-comment"></i>
                                                        </a>
                                                    </div>

                                                    <div class="btn-group float-right">
                                                        <a href="" class="btn btn-sm" title="Views">
                                                            <i class="fa fa-eye mr-2"></i>276
                                                        </a>
                                                        <a href="" class="btn btn-sm ml-2" title="Reviews">
                                                            <i class="fa fa-comment mr-2"></i>17
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-lg">
                                        <div class="card-body rounded-xlg">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="p-3">
                                                        <img src="assets/media/images/user.png" alt="" class="rounded-circle img-fluid">
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <p class="stars text-right">
                                                        <i class="fa fa-star text-warning mr-2"></i>
                                                        <i class="fa fa-star text-warning mr-2"></i>
                                                        <i class="fa fa-star text-warning mr-2"></i>
                                                        <i class="fa fa-star text-warning mr-2"></i>
                                                        <i class="fa fa-star text-warning mr-2"></i>
                                                    </p>
                                                    <h4 class="card-title">John Doe - <small><em>Barber</em></small></h4>
                                                    <p class="text-muted">
                                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officia nam, amet qui!
                                                    </p>
                                                    <div class="btn-group">
                                                        <a href="" class="btn btn-outline-dark btn-sm rounded-circle" title="View Details">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <a href="" class="btn btn-outline-dark btn-sm rounded-circle ml-2" title="Submit Review">
                                                            <i class="fa fa-comment"></i>
                                                        </a>
                                                    </div>

                                                    <div class="btn-group float-right">
                                                        <a href="" class="btn btn-sm" title="Views">
                                                            <i class="fa fa-eye mr-2"></i>276
                                                        </a>
                                                        <a href="" class="btn btn-sm ml-2" title="Reviews">
                                                            <i class="fa fa-comment mr-2"></i>17
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-lg">
                                        <div class="card-body rounded-xlg">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="p-3">
                                                        <img src="assets/media/images/user.png" alt="" class="rounded-circle img-fluid">
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <p class="stars text-right">
                                                        <i class="fa fa-star text-warning mr-2"></i>
                                                        <i class="fa fa-star text-warning mr-2"></i>
                                                        <i class="fa fa-star text-warning mr-2"></i>
                                                        <i class="fa fa-star text-silver mr-2"></i>
                                                        <i class="fa fa-star text-silver mr-2"></i>
                                                    </p>
                                                    <h4 class="card-title">John Doe - <small><em>Barber</em></small></h4>
                                                    <p class="text-muted">
                                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officia nam, amet qui!
                                                    </p>
                                                    <div class="btn-group">
                                                        <a href="" class="btn btn-outline-dark btn-sm rounded-circle" title="View Details">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <a href="" class="btn btn-outline-dark btn-sm rounded-circle ml-2" title="Submit Review">
                                                            <i class="fa fa-comment"></i>
                                                        </a>
                                                    </div>

                                                    <div class="btn-group float-right">
                                                        <a href="" class="btn btn-sm" title="Views">
                                                            <i class="fa fa-eye mr-2"></i>276
                                                        </a>
                                                        <a href="" class="btn btn-sm ml-2" title="Reviews">
                                                            <i class="fa fa-comment mr-2"></i>17
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-lg">
                                        <div class="card-body rounded-xlg">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="p-3">
                                                        <img src="assets/media/images/user.png" alt="" class="rounded-circle img-fluid">
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <p class="stars text-right">
                                                        <i class="fa fa-star text-warning mr-2"></i>
                                                        <i class="fa fa-star text-warning mr-2"></i>
                                                        <i class="fa fa-star text-warning mr-2"></i>
                                                        <i class="fa fa-star text-warning mr-2"></i>
                                                        <i class="fa fa-star text-warning mr-2"></i>
                                                    </p>
                                                    <h4 class="card-title">John Doe - <small><em>Barber</em></small></h4>
                                                    <p class="text-muted">
                                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officia nam, amet qui!
                                                    </p>
                                                    <div class="btn-group">
                                                        <a href="" class="btn btn-outline-dark btn-sm rounded-circle" title="View Details">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <a href="" class="btn btn-outline-dark btn-sm rounded-circle ml-2" title="Submit Review">
                                                            <i class="fa fa-comment"></i>
                                                        </a>
                                                    </div>

                                                    <div class="btn-group float-right">
                                                        <a href="" class="btn btn-sm" title="Views">
                                                            <i class="fa fa-eye mr-2"></i>276
                                                        </a>
                                                        <a href="" class="btn btn-sm ml-2" title="Reviews">
                                                            <i class="fa fa-comment mr-2"></i>17
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <section id="banner" class="section mt-3 px-5 mx-md-5">
            <div class="container">
                <div class="section-header font-theme text-center">
                    <h2>Testimonials</h2>
                </div>

                <div id="testimonialSlider" class="carousel slide mt-5" data-ride="carousel">

                    <!-- Indicators -->
                    <ul class="carousel-indicators fancy-indicators">
                        <li data-target="#testimonialSlider" data-slide-to="0" class="active"></li>
                        <li data-target="#testimonialSlider" data-slide-to="1"></li>
                    </ul>

                    <!-- The slideshow -->
                    <div class="carousel-inner rounded-xlg">
                        <div class="carousel-item active">
                            <div class="row d-flex justify-content-center">
                                <div class="col-md-6">
                                    <div class="text-center">
                                        <img src="assets/media/images/user.png" alt="" class="rounded-circle img-fluid w-25">
                                        <h4 class="card-title mt-3">Ikemefuna Amadioha - <small><em>Force PRO</em></small></h4>
                                        <h6>Nigerian Police Headquarters, FCT</h6>
                                        <p class="my-3 lead">
                                            <span class="quote"><i class="fa fa-quote-left text-muted"></i></span>
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maiores, aspernatur est ducimus quaerat mollitia modi quibusdam atque dolore cum similique, alias, numquam recusandae facere quis.
                                            <span class="quote"><i class="fa fa-quote-right text-muted"></i></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="row d-flex justify-content-center">
                                <div class="col-md-6">
                                    <div class="text-center">
                                        <img src="assets/media/images/user.png" alt="" class="rounded-circle img-fluid w-25">
                                        <h4 class="card-title mt-3">Paleninha Delgado - <small><em>Super Striker</em></small></h4>
                                        <h6>Boko Haram FC</h6>
                                        <p class="my-3 lead">
                                            <span class="quote"><i class="fa fa-quote-left text-muted"></i></span>
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maiores, aspernatur est ducimus quaerat mollitia modi quibusdam atque dolore cum similique, alias, numquam recusandae facere quis.
                                            <span class="quote"><i class="fa fa-quote-right text-muted"></i></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php include("includes/footer.php"); ?>
    <?php include("includes/foot.php"); ?>

    
