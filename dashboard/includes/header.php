<header>
    <nav class="navbar navbar-expand-md bg-light navbar-light rounded-xlg mt-2">
        <!-- Brand -->
        <a class="navbar-brand" href="#">Kia<sup>2</sup> FIX</a>

        <!-- Toggler/collapsibe Button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link text-theme font-weight-bold" href="#"><i class="fa fa-home"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-theme font-weight-bold" href="#"><i class="fa fa-globe"></i></a>
                </li>
                <!-- Dropdown -->
                <?php if(isset($uUsername)): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-theme font-weight-bold" href="#" id="navbardrop" data-toggle="dropdown" title="Add New">
                        <i class="fa fa-plus"></i>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="roles.php?do=add-role&min=true">Role</a>
                        <a class="dropdown-item" href="genders.php?do=add-gender&min=true">Gender</a>
                        <a class="dropdown-item" href="states.php?do=add-state&min=true">State</a>
                        <a class="dropdown-item" href="administrators.php?do=add-administrator&min=true">Admin User</a>
                    </div>
                </li>
                <!-- Dropdown -->
                <li class="nav-item dropdown ml-5  rounded-xlg">
                    <a class="nav-link dropdown-toggle text-white font-weight-bold" href="#" id="navbardrop" data-toggle="dropdown">
                        <img src="../assets/media/images/user.png" width="50" alt="" class="rounded-circle img-fluid mr-3"> <?= "$uFname $uLname" ?>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#"><i class="fa fa-id-card-o mr-2"></i>My Account</a>
                        <a class="dropdown-item" href="#"><i class="fa fa-cog mr-2"></i>Settings</a>
                        <a class="dropdown-item" href="Logout.php"><i class="fa fa-outdent mr-2"></i>Logout</a>
                    </div>
                </li>
                <?php endif ?>
            </ul>
        </div>
    </nav>
</header>
