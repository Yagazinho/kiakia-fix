<?php 
include("includes/config.php");

define("TITLE", "Template");
define("HEADER", "Template");
define("BREADCRUMB", "Temp");

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
                        <div class="card border-0 rounded-xlg">
                            <div class="card-body">
                                <div class="border-bottom py-2 mb-3">
                                    <div class="btn-group">
                                        <a href="" class="btn btn-dark btn-sm bg-dark"><i class="fa fa-plus"></i></a>
                                        <a href="" class="btn btn-dark btn-sm bg-dark"><i class="fa fa-list"></i></a>
                                    </div>
                                    <div class="btn-group float-right">
                                        <a href="" class="btn btn-dark btn-sm bg-dark"><i class="fa fa-refresh"></i></a>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card border-0 shadow-lg">
                                            <div class="card-body text-dark">
                                                <h6 class="card-title">Add New</h6>
                                                <form action="">
                                                    <p class="lead"><strong>NB:</strong> All fields marked with (<span class="text-danger">*</span>) must be filled accordignly</p>

                                                    <div class="card border-0 shadow-sm">
                                                        <div class="card-body">
                                                            <fieldset class="border-bottom">
                                                                <legend>Bio Info</legend>
                                                                <div class="row">
                                                                    <div class="form-group col-md-6">
                                                                        <input type="text" placeholder="First Name *" class="form-control">
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <input type="text" placeholder="Last Name *" class="form-control">
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for=""><small>Date of Birth</small></label>
                                                                        <input type="date" placeholder="" class="form-control">
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <select name="" id="" class="form-control form-control-select">
                                                                            <option value="">choose gender</option>
                                                                            <option value="">Male</option>
                                                                            <option value="">Female</option>
                                                                            <option value="">Bob</option>
                                                                            <option value="">Brown</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <select name="" id="" class="form-control form-control-select">
                                                                            <option value="">choose occupation</option>
                                                                            <option value="">Armed Robber</option>
                                                                            <option value="">Kidnapper</option>
                                                                            <option value="">Yahoo Yahoo</option>
                                                                            <option value="">Hookup</option>
                                                                            <option value="">Ritualist</option>
                                                                            <option value="">Bandit</option>
                                                                            <option value="">Looter</option>
                                                                            <option value="">Ungun Known Men</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </fieldset>
                                                            <fieldset class="border-bottom">
                                                                <legend>Contact Info</legend>
                                                                <div class="row">
                                                                    <div class="form-group col-md-6">
                                                                        <input type="text" placeholder="Email Address *" class="form-control">
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <input type="text" placeholder="Phone Number *" class="form-control">
                                                                    </div>
                                                                    <div class="form-group col-md-12">
                                                                        <input type="text" placeholder="Home Address 1 *" class="form-control">
                                                                    </div>
                                                                    <div class="form-group col-md-12">
                                                                        <input type="text" placeholder="Home Address 2" class="form-control">
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <select name="" id="" class="form-control">
                                                                            <option value="">choose state</option>
                                                                            <option value="">Ogun</option>
                                                                            <option value="">Lagos</option>
                                                                            <option value="">Enugu</option>
                                                                            <option value="">Abia</option>
                                                                            <option value="">Cross River</option>
                                                                            <option value="">Rivers</option>
                                                                            <option value="">Edo</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <select name="" id="" class="form-control">
                                                                            <option value="">choose lga</option>
                                                                            <option value="">NNLG</option>
                                                                            <option value="">Amac</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </fieldset>
                                                            <div class="">
                                                                <button class="btn btn-block bg-dark text-white"><i class="fa fa-thumbs-up mr-2"></i>Register</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card border-0 shadow-lg">
                                            <div class="card-body text-dark">
                                                <h6 class="card-title mb-5">Manage All</h6>
                                                <table class="table datatable table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Firstname</th>
                                                            <th>Lastname</th>
                                                            <th>Email</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>John</td>
                                                            <td>Doe</td>
                                                            <td>john@example.com</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Mary</td>
                                                            <td>Moe</td>
                                                            <td>mary@example.com</td>
                                                        </tr>
                                                        <tr>
                                                            <td>July</td>
                                                            <td>Dooley</td>
                                                            <td>july@example.com</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
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
