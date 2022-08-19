<?php

use CodeIgniter\HTTP\URI;

$descriptionMenu = 'rubrica';

$uri = new URI(current_url(true));

$part = $uri->getSegment(3);
?>

<!--menu-open na class para manter aberto-->
<li class="nav-item <?=$descriptionMenu === $part ? 'menu-open' : ''?>">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-copy"></i>
        <p>
            Rubrica
            <i class="fas fa-angle-left right"></i>
            <span class="badge badge-info right">6</span>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <?= anchor('/rubrica/add', '<i class="far fa-circle nav-icon"></i>
                                        <p>Adicionar</p>', ['class' => 'nav-link']); ?>

        </li>
        <li class="nav-item">
            <?= anchor('/rubrica/list', '<i class="far fa-circle nav-icon"></i>
                                        <p>Listar</p>', ['class' => 'nav-link']); ?>

        </li>
    </ul>
</li>
<div class="dropdown-divider"></div>