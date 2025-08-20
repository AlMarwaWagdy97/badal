    <section id="menu-bar">
        <div class="container-md bg-white rounded mainmenu-nav">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="navbar-brand py-2 m-0" href="<?php echo URLROOT; ?>">
                    <img class="" src="<?php echo empty($data['settings']['site']->logo) ? URLROOT . '/templates/namaa/images/logo.png' : MEDIAURL . '/' . $data['settings']['site']->logo; ?>" alt="Namaa" height="66" />
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse navbar-light bg-white" id="navbarCollapse">
                    <button class="navbar-toggler icofont-close" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="true" aria-label="Toggle navigation"></button>
                    <ul class="nav justify-content-center mr-auto h5 user-icons icofont-lg">
                        <li class="nav-item">
                            <a href="<?php echo URLROOT; ?>"><i class="icofont-search-2 px-2 text-success border-right"></i></a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="tooltip" data-placement="top" title="سجل التبرعات" href="<?php echo URLROOT . "/donors/login"; ?>"><i class="icofont-user-male px-2 text-primary border-right"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="cart-total" data-toggle="tooltip" data-placement="right" title="<?php echo isset($_SESSION['cart']) ? $_SESSION['cart']['totalQty'] : 0; ?> منتج" href="<?php echo URLROOT . "/carts"; ?>">
                                <i class="icofont-shopping-cart px-2 text-warning"></i>
                            </a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="<?php echo URLROOT; ?>" class="nav-link active icofont-home icofont-lg"></a>
                        </li>
                        <?php
                        foreach ($data['menu'] as $menu) {
                            if ($menu->level == 1) { //load level one
                                echo '<li class="nav-item">
                                        <a href="' . $menu->url . '" class="nav-link">' . $menu->name . '</a>
                                        <ul class="dropdown-menu">';
                                foreach ($data['menu'] as $submenu) { // load level 2
                                    if ($submenu->parent_id == $menu->menu_id) {
                                        echo '<li class="nav-item">
                                                <a href="' . $submenu->url . '" class="nav-link">' . $submenu->name . '</a>
                                                <ul class="dropdown-menu">';
                                        foreach ($data['menu'] as $subsub) { // load level 3
                                            if ($subsub->parent_id == $submenu->menu_id) {
                                                echo '<li class="nav-item">
                                                        <a href="' . $subsub->url . '" class="nav-link">' . $subsub->name . '</a>
                                                    </li>';
                                            }
                                        }
                                        echo '</ul>
                                            </li>';
                                    }
                                }
                                echo '</ul></li>';
                            }
                        }
                        ?>
                    </ul>
                </div>
            </nav>
        </div>
    </section>
    <!-- main menu end -->