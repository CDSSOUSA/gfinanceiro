<?php

use CodeIgniter\HTTP\URI;

$uri = new URI(current_url(true));

$part = $uri->getSegment(3);
?>
<nav class="mt-2 ">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <?php
        // echo view('menu/menu-account.php');
        // echo view('menu/menu-rubrica.php');
        // echo view('menu/menu-movement.php');



        foreach (session('menu') as $menu) { ?>
            <?php foreach ($menu['item'] as $k =>  $item) { ?>
                <li class="nav-item  <?= $k === $part ? 'menu-open' : ''; ?>">
                    <a href="#" class="nav-link">
                        <i class="fa fa-money"></i>
                        <?= $item['icon']; ?>
                        <p>
                            <?= $item['title']; ?>
                            <i class="fas fa-angle-left right"></i>
                            <span class="badge badge-info right"><?= count($item['links']); ?></span>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php
                        foreach ($item['links'] as $key => $link) {
                        ?>
                            <?php

                            if (is_array($link) == 1) : ?>
                                <li class="nav-item <?= $k === $part ? 'menu-open' : ''; ?>">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            <?= $key; ?>
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php foreach ($link as $keyOther => $links) : ?>
                                            <li class="nav-item">
                                                <?= anchor($links, nbsp(3).'<i class="far fa-circle nav-icon"></i>
                                        <p>' . $keyOther . '</p>', ['class' => 'nav-link']); ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>

                </li>

            <?php else : ?>
                <li class="nav-item">
                    <?= anchor($link, '<i class="far fa-circle nav-icon"></i>
                                        <p>' . $key . '</p>', ['class' => 'nav-link']); ?>

                <?php endif; ?>
                </li>
            <?php } ?>
    </ul>
    <li>
        <div class="dropdown-divider"></div>
    <?php } ?>
<?php }
?>
    <!-- <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="nav-icon far fa-plus-square"></i>
            <p>
                Extras
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview" style="display: none;">
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                        Consultar
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="pages/examples/login.html" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Login v1</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="pages/examples/register.html" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Register v1</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="pages/examples/forgot-password.html" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Forgot Password v1</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="pages/examples/recover-password.html" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Recover Password v1</p>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </li>
    </ul> -->
</nav>
