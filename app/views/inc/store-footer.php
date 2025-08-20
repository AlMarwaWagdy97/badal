<?php if ($data['site_settings']->show_categories): ?>

<div class="container">
    <section class="footer px-2">
        <div class="footer-top">
<?php if ($data['site_settings']->bootom) echo $data['site_settings']->bootom ;   ?>

        </div>
        <div class="footer-bottom text-white text-center py-1 small">
            <p class="pt-3 m-0"><?php echo $data['contact_settings']->address ?></p>
            <p class="p-0 m-0"><i class="icofont-phone"></i> <a class=" text-white mr-5" href="tel:<?php echo $data['store']->mobile ?>"><?php echo $data['store']->mobile ?></a>
            <i class="icofont-email"></i> <a class=" text-white" href="mailto:<?php echo $data['contact_settings']->email ?>"><?php echo $data['contact_settings']->email ?></a></p>
        </div>
    </section>
</div>
<?php endif;?>

<!-- javascript -->
<script src="<?php echo URLROOT; ?>/templates/default/vendors/jquery.min.js"></script>
<script src="<?php echo URLROOT; ?>/templates/default/js/bootstrap.min.js"></script>
<script src="<?php echo URLROOT; ?>/templates/default/vendors/owlcarousel/owl.carousel.js"></script>
<script src="<?php echo URLROOT; ?>/templates/default/js/wow.min.js"></script>
<?php echo isset($footer) ? $footer : ''; ?>
<script src="<?php echo URLROOT; ?>/templates/default/js/main.js"></script>
<?php echo isset($data['site_settings']->footer_code) ? $data['site_settings']->footer_code : ''; ?>

</body>

</html>