<body class="hold-transition sidebar-mini layout-fixed dark-mode">
    <div class="wrapper">

        <!-- <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="<?php //base_url()?>/assets/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
        </div> -->
        <?= view('layouts/menu-top'); ?>

        <aside class="main-sidebar sidebar-dark-indigo elevation-4">

            <a href="index3.html" class="brand-link">
                <img src="<?= base_url(); ?>/assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">AdminLTE 3</span>
            </a>

            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?= base_url(); ?>/assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">CLEBER SOUSA</a>
                    </div>
                </div>
                <?= view('layouts/menu-side'); ?>
            </div>
        </aside>
        <div class="content-wrapper">
            <hr>
            <section class="content">
                <?= $this->renderSection('content'); ?>
            </section>
        </div>