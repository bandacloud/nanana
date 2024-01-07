<body class="animsition">
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
        <header class="header-mobile d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                        <a class="logo" href="news.php">
                            <img src="./images/icon/esds.png" style="max-width:110px;" alt="ESDS" />
                        </a>
                        <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <nav class="navbar-mobile">
                <div class="container-fluid">
                    <ul class="navbar-mobile__list list-unstyled">
                        <li class="news-m">
                            <a href="../admin/">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <li class="patients-m">
                            <a href="../admin/patient-info.php">
                                <i class="fa fa-user-md"></i> Patient Info
                            </a>
                        </li>
                        <?php
                        if ($user_type == 1) {
                        ?>
                            <li class="users-m">
                                <a href="users.php">
                                    <i class="fas fa-users"></i> Users
                                </a>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- END HEADER MOBILE-->

        <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar d-none d-lg-block">
            <div class="logo">
                <a href="#">
                    <img src="./images/icon/esds.png" style="max-width:120px;" alt="ESDS" />
                </a>
            </div>
            <div class="menu-sidebar__content js-scrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">

                        <li class="news">
                            <a href="../admin/">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <li class="patients">
                            <a href="../admin/patient-info.php">
                                <i class="fa fa-user-md"></i> Patient Info
                            </a>
                        </li>
                        <?php
                        if ($user_type == 1) {
                        ?>
                            <li class="users">
                                <a href="users.php">
                                    <i class="fas fa-users"></i> Users
                                </a>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->