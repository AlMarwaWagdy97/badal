<?php require APPROOT . '/app/views/inc/header.php'; ?>
<?php flash('order_msg'); ?>
<!-- Categories -->
<section id="categories" class="my-5 text-right">
    <div class=" undermenu">
        <div class="container">
            <a class="btn-danger btn float-left" href="<?php root('stores/logout') ?>">Logout</a>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary float-left mx-2" data-toggle="modal" data-target="#modelId">
                تعديل كلمة المرور
            </button>
            <a href="<?php echo URLROOT . '/stores/projects' ?>" class="btn btn-success float-left mx-2" >
                عدد الزوار
            </a>
            <a href="<?php echo URLROOT . '/stores/orders' ?>" class="btn btn-success float-left mx-2" >
                 التبرعات
            </a>
            <h5 class="card-title">
                <img src="<?php echo URLROOT; ?>/templates/default/images/namaa-icon.png" alt="Smiley face" class="ml-2">سجل التبرعات : <?php echo $data['store']->name; ?>
            </h5>
            <p> رابط الموقع:
                <a dir="ltr" href="<?php echo URLROOT . '/stores/' . $data['store']->alias; ?>"><?php echo URLROOT . '/stores/' . $data['store']->alias; ?></a>
            </p>
        </div>
        <div class="col-12">
                <div class="table-responsive small">
                    <table class="table table-striped table-bordered rounded bulk_action">
                        <thead class="">
                            <tr class="headings orders">
                                <th class="column-title"> # <br>
                                <th class="column-title"> رقم المشروع <br>
                                <th class="column-title"> اسم المشروع <br>
                                <th class="column-title"> عدد الزوار  <br>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['projectsHits'] as $key =>  $order) : ?>
                                <tr class="even pointer">
                                    
                                    <td><?php echo $key + 1; ?></td>
                                    <td><?php echo $order->project_id; ?></td>
                                    <td><?php echo $order->name; ?></td>
                                    <td><?php echo $order->hits; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
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
                <form autocomplete="off" action="<?php echo URLROOT ?>/stores/password" method="post">
                    <div class="form-group">
                        <label for="password">كلمة المرور الجديدة</label>
                        <input type="text" autocomplete="off" required minlength="6" class="form-control" name="password" placeholder="Password">
                        <input type="hidden" name="store_id" value="<?php echo $data['store']->store_id ?>">
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