<?php require APPROOT . '/app/views/inc/header.php'; ?>
<div class="container">
    <div class="msg"><?php flash('msg'); ?></div>
    <!-- Categories -->
    <section id="categories">
        <div class="row m-3 justify-content-center text-right">
            <h2 class="text-center col-12"> <img src="<?php echo URLROOT; ?>/templates/default/images/namaa-icon.png" alt="Smiley face" class="ml-2">بيانات الدفع</h2>
            <div class="col-12 card mt-2">
                <div class="form-group">
                    <label class="control-label h4 pt-2"><?php echo $data['payment_method']->title; ?>: </label>
                </div>
                <div class="content">
                    <?php if ($data['payment_method']->payment_id == 2) : ?>
                        <table class="table table-striped jambo_table text-center">
                            <thead>
                                <tr class="headings  text-center">
                                    <th class="">اسم الفرع </th>
                                    <th class="">العنوان </th>
                                    <th class="">رابط العنوان علي خرائط جوجل </th>
                                </tr>
                            </thead>
                            <tbody id="items">
                                <?php
                                $meta = json_decode($data['payment_method']->meta, true);
                                if (!empty($meta)) {
                                    $x = 1;
                                    foreach ($meta as $branch) {
                                        echo '<tr class="">
                                            <td class="form-group">' . $branch['branchname'] . '</td>
                                            <td class="form-group">' . $branch['address'] . '</td>
                                            <td class="form-group">
                                            <a href="' . $branch['url'] . '" rel="no-fllow" target="_blank" >ذهاب</a>
                                            </td>
                                        </tr>';
                                        $x++;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    <?php endif;
                    echo $data['payment_method']->content; ?>
                </div>
            </div>
        </div>
    </section>
    <!-- end Categories -->
</div>
<?php require APPROOT . '/app/views/inc/footer.php'; ?>