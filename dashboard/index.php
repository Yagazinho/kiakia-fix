<?php 
include("includes/config.php");
include("includes/auth.php");

define("TITLE", "Dashboard");
define("HEADER", "Dashboard");
define("BREADCRUMB", "dashboard");
include("includes/head.php");



?>


<body class="bg-dark">

    <div class="container-fluid">
        <div class="mx-md-5 mx-0">
            <?php include("includes/header.php"); ?>
            <main>
                <?php include("includes/page-header.php"); ?>

                <div class="row">
                    <?php include("includes/nav.php"); ?>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <div class="card border-0 rounded-xlg">
                                    <div class="card-body">
                                        <div class="d-inline-flex">
                                            <div class="p-3 pb-0">
                                                <i class="fa fa-5x fa-users"></i>
                                            </div>
                                            <div class="p-3 text-right border-left bd-w-4">
                                                <h3 class="card-title">Providers</h3>
                                                <p class="fa-3x mb-0 "><?= countRows('providers'); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card border-0 rounded-xlg">
                                    <div class="card-body">
                                        <div class="d-inline-flex">
                                            <div class="p-3 pb-0">
                                                <i class="fa fa-5x fa-list-alt"></i>
                                            </div>
                                            <div class="p-3 text-right border-left bd-w-4">
                                                <h3 class="card-title">Users</h3>
                                                <p class="fa-3x mb-0 "><?= countRows('users'); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card border-0 rounded-xlg">
                                    <div class="card-body">
                                        <div class="d-inline-flex">
                                            <div class="p-3 pb-0">
                                                <i class="fa fa-5x fa-list-alt"></i>
                                            </div>
                                            <div class="p-3 text-right border-left bd-w-4">
                                                <h3 class="card-title">Services</h3>
                                                <p class="fa-3x mb-0 "><?= countRows('services'); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card border-0 rounded-xlg">
                                    <div class="card-body">
                                        <div class="d-inline-flex">
                                            <div class="p-3 pb-0">
                                                <i class="fa fa-5x fa-comments"></i>
                                            </div>
                                            <div class="p-3 text-right border-left bd-w-4">
                                                <h3 class="card-title">Testimonial</h3>
                                                <p class="fa-3x mb-0 "><?= countRows('testimonials'); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card border-0 rounded-xlg">
                                    <div class="card-body">
                                        <div class="d-inline-flex">
                                            <div class="p-3 pb-0">
                                                <i class="fa fa-5x fa-id-card-0"></i>
                                            </div>
                                            <div class="p-3 text-right border-left bd-w-4">
                                                <h3 class="card-title">Genders</h3>
                                                <p class="fa-3x mb-0 "><?= countRows('genders'); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card border-0 rounded-xlg">
                                    <div class="card-body">
                                        <div class="d-inline-flex">
                                            <div class="p-3 pb-0">
                                                <i class="fa fa-5x fa-id-card-0"></i>
                                            </div>
                                            <div class="p-3 text-right border-left bd-w-4">
                                                <h3 class="card-title">Roles</h3>
                                                <p class="fa-3x mb-0 "><?php echo countRows('roles'); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                n
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card border-0 rounded-xlg">
                                    <div class="card-body">
                                        <div class="d-inline-flex">
                                            <div class="p-3 pb-0">
                                                <i class="fa fa-5x fa-id-card-0"></i>
                                            </div>
                                            <div class="p-3 text-right border-left bd-w-4">
                                                <h3 class="card-title">NINs</h3>
                                                <p class="fa-3x mb-0 "><?php echo countRows('nins'); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card border-0 rounded-xlg">
                                    <div class="card-body">
                                        <div class="d-inline-flex">
                                            <div class="p-3 pb-0">
                                                <i class="fa fa-5x fa-id-card-0"></i>
                                            </div>
                                            <div class="p-3 text-right border-left bd-w-4">
                                                <h3 class="card-title">States</h3>
                                                <p class="fa-3x mb-0 "><?php echo countRows('states '); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="card rounded-xlg border-0">
                                    <div class="card-body">
                                        <h4 class="card-title mb-5">Pending Enteries</h4>
                                        <ul class="nav nav-pills">
                                            <li class="nav-item">
                                                <a class="nav-link active text-theme font-weight-bolder" data-toggle="pill" href="#home">Providers</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link text-theme font-weight-bolder" data-toggle="pill" href="#menu1">Users</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link text-theme font-weight-bolder" data-toggle="pill" href="#menu2">Testimonials</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link text-theme font-weight-bolder" data-toggle="pill" href="#menu2">Contacts</a>
                                            </li>
                                        </ul>

                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <div class="tab-pane container active" id="home">...</div>
                                            <div class="tab-pane container fade" id="menu1">...</div>
                                            <div class="tab-pane container fade" id="menu2">...</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>


            <?php include("includes/foot.php"); ?>
            <?php include("includes/footer.php"); ?>
