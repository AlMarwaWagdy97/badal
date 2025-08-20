<?php require APPROOT . '/app/views/inc/header.php'; ?>
<!-- Categories -->
<section id="donors" class="undermenu bg-light">
    <div class="container bg-white">
        <?php flash('msg'); ?>
        <div class="row mt-3">
            <div class="col-md-3">
                <?php require APPROOT . '/app/views/inc/donor-sidenavbar.php'; ?>
            </div>
            <div class="col-md-9">
                <div class="card mt-3 mb-3 card-info border-0 text-right" dir="rtl">
                    <div class="card-body h-100">
                        <h5 class="text-right mb-3"> سجل التبرعات</h5>
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
                    </div>
                </div>
            </div>
        </div>
</section>
<!-- end Categories -->
<?php
require APPROOT . '/app/views/inc/footer.php';
?>