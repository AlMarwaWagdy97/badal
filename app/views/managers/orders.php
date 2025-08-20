<?php require APPROOT . '/app/views/inc/header.php'; ?>
<?php flash('order_msg'); ?>
<!-- Categories -->
<section id="categories" class="my-5 text-right">
    <div class=" undermenu">
        <h4 class="card-title container">
            <a class="btn-danger btn float-left" href="<?php root('managers/logout') ?>">Logout</a>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary float-left mx-2" data-toggle="modal" data-target="#modelId">
                تعديل كلمة المرور
            </button>
            <img src="<?php echo URLROOT; ?>/templates/default/images/namaa-icon.png" alt="Smiley face" class="ml-2"> سجل التبرعات المتاجر الفرعية ل : <?php echo $data['manager']->name; ?>

        </h4>
        <div class="col-12">
            <form action="" method="post">
                <div class="table-responsive small">
                    <table class="table table-striped table-bordered rounded bulk_action">
                        <thead class="">
                            <tr>
                                <th class="bulk-actions bg-info" colspan="15">
                                    <span> تنفيذ علي الكل :</span>
                                    <input type="submit" name="publish" value="تأكيد" class="btn btn-success btn-sm" />
                                    <input type="submit" name="unpublish" value="تعليق" class="btn btn-warning btn-sm" />
                                    <input type="submit" name="canceled" value="الغاء" class="btn btn-danger  btn-sm" />
                                    <input type="submit" name="waiting" value="في الانتظار" class="btn btn-info btn-sm" />
                                    <span class="control-label">الحالات :</span>
                                    <?php
                                    foreach ($data['statuses'] as $status) {
                                        echo ' <button type="submit" name="status_id"  value="' . $status->status_id . '" class="btn btn-dark btn-sm">' . $status->name . '</button> ';
                                    }
                                    ?>
                                    <span class="control-label"> حذف الحالة :</span>
                                    <input type="submit" name="clear" value="Clear" onclick="return confirm('Are you sure?') ? true : false" class="btn btn-warning btn-sm" />
                                </th>
                            </tr>
                            <tr class="headings orders">
                                <th>
                                    <!-- <input type="checkbox" id="check-all" class="flat"> -->
                                </th>
                                <th class="column-title">معرف التبرع <input type="search" placeholder="بحث بالمعرف" name="search[order_identifier]" value="<?php printIsset(cleanSearchVar('order_identifier')); ?>" class="w100"></th>
                                <th class="column-title">القيمة <br>
                                    <input type="search" placeholder="من" name="search[total_from]" value="<?php printIsset(cleanSearchVar('total_from')); ?>" class="w50">
                                    <input type="search" placeholder="الي" name="search[total_to]" value="<?php printIsset(cleanSearchVar('total_to')); ?>" class="w50">
                                </th>
                                <th class="column-title">اسم المتبرع <input type="search" placeholder="بحث بالمتبرع" name="search[full_name]" value="<?php printIsset(cleanSearchVar('full_name')); ?>" class="w100"></th>
                                <th class="column-title">الجوال <input type="search" placeholder="بحث بالجوال" name="search[mobile]" value="<?php printIsset(cleanSearchVar('mobile')); ?>" class="w100"></th>
                                <th class="column-title">المشروع</th>
                                <th class="column-title no-link last">الموقع
                                    <select name="search[store_id]">
                                        <option value="">المتاجر</option>
                                        <?php foreach ($data['stores'] as $store) {  ?>
                                            <option value="<?= $store->store_id ?>"> <?= $store->name ?> </option>
                                        <?php } ?>
                                    </select>
                                </th>
                                <th class="column-title">وسيلة التبرع <br>
                                </th>
                                <th class="column-title">بيانات الإهداء </th>
                                <th class="column-title">تأكيد التحويل </th>
                                <th class="column-title">تفاصيل Payfort </th>
                                <th class="column-title">تاريخ التبرع <br>
                                    <input type="date" placeholder=" من" name="search[date_from]" value="<?php if (returnIsset(cleanSearchVar('date_from'))) echo date('Y-m-d', returnIsset(cleanSearchVar('date_from'))); ?>" class="">
                                    <input type="date" placeholder=" الي" name="search[date_to]" value="<?php if (returnIsset(cleanSearchVar('date_to'))) echo date('Y-m-d', returnIsset(cleanSearchVar('date_to') - 86400 )); ?>" class="">
                                </th>
                                <th class="column-title">الحالة
                                </th>
                                <th class="column-title no-link last"><span class="nobr">نوع العملية</span><br>
                                    <select name="search[status]">
                                        <option value=""></option>
                                        <option value="1">مؤكد </option>
                                        <option value="5"> غير مؤكد </option>
                                        <option value="3"> في الانتظار </option>
                                        <option value="4">ملغاه </option>
                                    </select>
                                </th>
                                <th class="column-title w50">
                                    <input type="submit" name="search[submit]" value="بحـث" class="btn btn-sm btn-primary search-query" />
                                    <input type="submit" name="search[clearSearch]" value="مسح" class="btn btn-sm btn-warning search-query" />
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['orders'] as $order) : ?>
                                <tr class="even pointer">
                                    <td class="a-center ">
                                        <input type="checkbox" class="records flat" name="record[]" value="<?php echo $order->order_id; ?>">
                                    </td>
                                    <td><?php echo $order->order_identifier; ?></td>
                                    <td><?php echo $order->total; ?></td>
                                    <td><?php echo $order->donor; ?></td>
                                    <td class="ltr"><?php echo $order->mobile; ?></td>
                                    <td width="200px"><?php echo $order->projects; ?></td>
                                    <td><?php echo $order->store; ?></td>
                                    <td><?php echo $order->payment_method; ?></td>
                                    <td>
                                        <?php if ($order->gift) { ?>
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#gift<?php echo $order->order_id; ?>">تفاصيل</button>
                                            <div class="modal fade" id="gift<?php echo $order->order_id; ?>" role="dialog">
                                                <div class="modal-dialog">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-body text-right" dir="ltr">
                                                            <ul class="text-capitalize">
                                                                <?php
                                                                ($order->gift) ? $gifts = json_decode($order->gift_data) : $gifts = [];
                                                                foreach ($gifts as $key => $value) {
                                                                    if ($key == 'enable') continue;
                                                                    if ($key == 'card') {
                                                                        echo '<li class="h5">' . $key . " : <img width='200' src= '" . MEDIAURL . '/' . $value . "'></li>\n";
                                                                    } else {
                                                                        echo '<li class="h5">' . $key . " : " . $value . "</li>\n";
                                                                    }
                                                                }
                                                                ?>
                                                            </ul>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </td>
                                    <td><?php if (!empty($order->banktransferproof)) : ?>
                                            <a class="btn btn-success btn-sm" href="<?php echo URLROOT . "/media/files/banktransfer/" . $order->banktransferproof; ?>" target="blank">تحميل</a>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($order->meta) { ?>
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#meta<?php echo $order->order_id; ?>">تفاصيل</button>
                                            <div class="modal fade" id="meta<?php echo $order->order_id; ?>" role="dialog">
                                                <div class="modal-dialog">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-body text-right" dir="ltr">
                                                            <ul class="text-capitalize">
                                                                <?php
                                                                ($order->meta) ? $metas = json_decode($order->meta) : $metas = [];
                                                                foreach ($metas as $key => $value) {
                                                                    echo '<li class="h5">' . $key . " : " . $value . "</li>\n";
                                                                }
                                                                ?>
                                                            </ul>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </td>
                                    <td class="ltr"><?php echo date('Y/ m/ d | H:i a', $order->create_date); ?></td>
                                    <td><?php echo $order->status_name; ?></td>
                                    <td class="form-group w200" colspan="2">
                                        <?php
                                        if (!$order->status) {
                                            echo '<a class="btn btn-sm btn-warning" type="button" data-toggle="tooltip" data-original-title="غير مؤكد"><i class="fa fa-ban"></i>غير مؤكد</a>';
                                        } elseif ($order->status == 1) {
                                            echo '<a class="btn btn-sm btn-success" type="button" data-toggle="tooltip" data-original-title="مؤكد"><i class="fa fa-check"></i>مؤكد</a>';
                                        } elseif ($order->status == 3) {
                                            echo '<a class="btn btn-sm btn-info" type="button" data-toggle="tooltip" data-original-title="في الانتظار"><i class="fa fa-clock-o"></i>في الانتظار</a>';
                                        } elseif ($order->status == 4) {
                                            echo '<a class="btn btn-sm btn-default" type="button" data-toggle="tooltip" data-original-title="ملغاه"><i class="fa fa-close"></i>ملغاه</a>';
                                        }
                                        ?>
                                        <!-- <a href="<?php echo URLROOT . '/orders/show/' . $order->order_id; ?>" class="btn btn-sm btn-success" data-placement="top" data-toggle="tooltip" data-original-title="عرض"><i class="fa fa-eye"></i></a>
                                                <a href="<?php echo URLROOT . '/orders/edit/' . $order->order_id; ?>" class="btn btn-sm btn-primary" data-placement="top" data-toggle="tooltip" data-original-title="تعديل"><i class="fa fa-edit"></i></a> -->
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <tr class="tab-selected">
                                <th></th>
                                <th class="column-title" colspan="4"> العدد الكلي : <?php echo $data['recordsCount']; ?> </th>
                                <th class="column-title" colspan="10"> عرض
                                    <select name="perpage" onchange="if (this.value)
                                                window.location.href = '<?php echo URLROOT . '/managers/orders/' . $data['current']; ?>' + '/' + this.value">
                                        <option value="10" <?php echo ($data['perpage'] == 10) ? 'selected' : null; ?>>10 </option>
                                        <option value="50" <?php echo ($data['perpage'] == 50) ? 'selected' : null; ?>>50 </option>
                                        <option value="100" <?php echo ($data['perpage'] == 100) ? 'selected' : null; ?>>100 </option>
                                        <option value="200" <?php echo ($data['perpage'] == 200) ? 'selected' : null; ?>>200 </option>
                                        <option value="500" <?php echo ($data['perpage'] == 500) ? 'selected' : null; ?>>500 </option>
                                        <option value="1000" <?php echo ($data['perpage'] == 1000) ? 'selected' : null; ?>>1000 </option>
                                    </select>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <ul class="pagination text-center navigation ">
                    <?php
                    pagination($data['recordsCount'], $data['current'], $data['perpage'], 4, URLROOT . '/managers/', 'orders');
                    ?>
                </ul>
            </form>
        </div>
    </div>
</section>
<!-- Modal -->
<div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title text-center"> تعديل كلمة المرور</h5>
            </div>
            <div class="modal-body">
                <form autocomplete="off" action="<?php echo URLROOT ?>/managers/password" method="post">
                    <div class="form-group">
                        <label for="password">كلمة المرور الجديدة</label>
                        <input type="text" autocomplete="off" required minlength="6" class="form-control" name="password" placeholder="Password">
                        <input type="hidden" name="manager_id" value="<?php echo $data['manager']->manager_id ?>">
                    </div>
                    <button type="button" class="btn btn-secondary mx-1" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end Categories -->

<?php require APPROOT . '/app/views/inc/footer.php'; ?>