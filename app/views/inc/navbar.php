<nav class="col-12 mt-1 sub-menu collapse" id="navbar-toggler">
    <?php
    foreach ($data['pagesLinks'] as $link) :
        if ($link->type == 'dynamic') :
            echo '<a class="nav-link" href="' . URLROOT . $link->url . '">' . $link->name . '</a>';
        else :
            echo '<a class="nav-link" href="' . $link->url . '">' . $link->name . '</a>';
        endif;
    endforeach;
    ?>
</nav>