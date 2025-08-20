<?php require APPROOT . '/app/views/inc/header.php'; ?>
<!-- Categories -->
<section id="donors" class="undermenu bg-light">
    <div class="container bg-white">
        <?php flash('msg'); ?>
        <div class=" text-right">
            <div class="card-body">
                <h4 class="card-title">
                    <a class="btn-danger btn float-left" href="<?php root('donors/logout') ?>">تسجيل الخروج</a>
                    <a class="btn-primary btn float-left mx-2" href="<?php root('donors/profile') ?>"> <i class="icofont-user"></i> الملف الشخصي</a>
                    <a class="btn-primary btn float-left mx-2" href="<?php root('donors/account') ?>"> <i class="icofont-chart-line"></i>  الحساب الشخصي</a>
                    <img src="<?php echo URLROOT; ?>/templates/default/images/namaa-icon.png" alt="Smiley face" class="ml-2"> سجل التبرعات
                </h4>
                <p class="card-text">
                <table class="table table-striped table-bordered rounded table-responsive">
                    <thead class="thead-inverse">
                        <tr>
                            <th class="column-title">معرف التبرع </th>
                            <th class="column-title">العدد </th>
                            <th class="column-title">الاجمالي </th>
                            <th class="column-title">المشروع </th>
                            <th class="column-title">وسيلة التبرع </th>
                            <th class="column-title">تاريخ التبرع </th>
                            <th class="column-title">حالة التبرع </th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php
                        echo (count($data['donations']) > 0) ? '' : '<tr><th colspan ="9">لا يوجد تبرعات سابقة  </th></tr>';
                        foreach ($data['donations'] as $donation) {
                            switch ($donation->status) {
                                case '0':
                                    $donation->status = '<a class="btn btn-warning py-1" data-toggle="tooltip" title="غير مؤكد"><i class="text-light icofont-not-allowed"></i></a>';
                                    break;
                                case '1':
                                    $donation->status = '<a class="btn btn-success py-1" data-toggle="tooltip" title="مؤكد"><i class="text-light icofont-check-circled"></i></a>';
                                    break;
                                case '3':
                                    $donation->status = '<a class="btn btn-info py-1" data-toggle="tooltip" title="في الانتظار"><i class="text-light icofont-history"></i></a>';
                                    break;
                                case '4':
                                    $donation->status = '<a class="btn btn-danger py-1" data-toggle="tooltip" title="ملغاه"><i class="text-light icofont-close-circled"></i></a>';
                                    break;
                            }
                            echo "<tr>
                                        <td>$donation->order_identifier</td>
                                        <td>$donation->quantity</td>
                                        <td>$donation->total</td>
                                        <td>$donation->projects</td>
                                        <td>$donation->payment_method</td>
                                        <td>" . date('Y/ m/ d | H:i a', $donation->modified_date) . "</td>
                                        <td>$donation->status</td>
                                    </tr>";
                        }; ?>

                    </tbody>
                </table>
                </p>
            </div>
        </div>
    </div>
</section>
<!-- end Categories -->
<?php require APPROOT . '/app/views/inc/footer.php'; ?>