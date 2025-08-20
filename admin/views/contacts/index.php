<?php
/*
 * Copyright (C) 2018 Easy CMS Framework Ahmed Elmahdy
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License
 * @license    https://opensource.org/licenses/GPL-3.0
 *
 * @package    Easy CMS MVC framework
 * @author     Ahmed Elmahdy
 * @link       https://ahmedx.com
 *
 * For more information about the author , see <http://www.ahmedx.com/>.
 */

// loading  plugin style
$data['header'] = '';

require ADMINROOT . '/views/inc/header.php';
?>

<!-- page content -->

<div class="right_col" role="main">
    <div class="clearfix"></div>
    <?php flash('contact_msg');?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['title']; ?> <small>عرض كافة <?php echo $data['title']; ?> </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/contacts/add" class="btn btn-success pull-left">انشاء جديد <i class="fa fa-plus"></i></a>
            <a href="<?php echo ADMINURL; ?>/settings/edit/10#contacts" class="btn btn-primary pull-left">الاعدادات <i class="fa fa-plus"></i></a>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">

            <form action="" method="post" >
                <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action">
                        <thead>
                            <tr class=" form-group-sm">
                                <th width="70px"><input type="submit" name="search[submit]" value="بحث" class="btn btn-sm btn-primary search-query" /></th>
                                <th width="36px"></th>
                                <th class=""><input type="search" class="form-control" placeholder="بحث بالعنوان" name="search[subject]" value="" ></th>
                                <th class=""><input type="search" class="form-control" placeholder="بحث بالمرسل" name="search[full_name]" value="" ></th>
                                <th class=""><input type="search" class="form-control" placeholder="بحث بالمدينة" name="search[city]" value="" ></th>
                                <th class=""><input type="search" class="form-control" placeholder="بحث بالبريد" name="search[email]" value="" ></th>
                                <th class=""><input type="search" class="form-control" placeholder="بحث بنوع الرسالة" name="search[phone]" value="" ></th>
                                <th class=""><input type="search" class="form-control" placeholder="بحث بالوصف" name="search[type]" value="" ></th>
                                <th class="" colspan= "2"></th>
                                <th width="150px">
                                    <select class="form-control" name="search[status]" >
                                        <option value=""></option>
                                        <option value="1">مقروء </option>
                                        <option value="0"> غير مقروء </option>
                                    </select>
                                </th>
                            </tr>
                            <tr class="headings">
                                <th>
                                    <input type="checkbox" id="check-all" class="flat">
                                </th>
                                <th class=""> </th>
                                <th class="column-title">عنوان الرسالة </th>
                                <th class="column-title">اسم المرسل </th>
                                <th class="column-title">المدينة </th>
                                <th class="column-title">البريد الالكتروني </th>
                                <th class="column-title">الهاتف </th>
                                <th class="column-title">الغرض </th>
                                <th class="column-title">تاريخ الانشاء </th>
                                <th class="column-title">آخر تحديث </th>
                                <th class="column-title no-link last"><span class="nobr">اجراءات</span>
                                </th>
                                <th class="bulk-actions" colspan="9">
                                    <span> تنفيذ علي الكل     :</span>
                                    <input type="submit" name="publish" value="مقروءة" class="btn btn-success btn-xs" />
                                    <input type="submit" name="unpublish" value="غير مقروءة" class="btn btn-warning btn-xs" />
                                    <input type="submit" name="delete" value="حذف" onclick="return confirm('Are you sure?') ? true : false" class="btn btn-danger btn-xs" />
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['contacts'] as $contact): ?>

                                <tr class="even pointer <?php echo $contact->status? '':' selected '; ?>">
                                    <td class="a-center">
                                        <input type="checkbox" class="records flat" name="record[]" value="<?php echo $contact->contact_id; ?>">
                                    </td>
                                    <td class=""></td>
                                    <td class=""><?php echo $contact->subject; ?></td>
                                    <td class=""><?php echo $contact->full_name; ?></td>
                                    <td class=""><?php echo $contact->city; ?></td>
                                    <td class=""><?php echo $contact->email; ?></td>
                                    <td class=""><?php echo $contact->phone; ?></td>
                                    <td class=""><?php echo $contact->type; ?></td>
                                    <td class="ltr"><?php echo date('Y/ m/ d | H:i a', $contact->create_date); ?></td>
                                    <td class="ltr"><?php echo date('Y/ m/ d | H:i a', $contact->modified_date); ?></td>
                                    <td class="form-group">
                                        <?php
                                        if (!$contact->status) {
                                            echo '<a href="' . ADMINURL . '/contacts/publish/' . $contact->contact_id . '" class="btn btn-xs btn-warning" type="button" data-toggle="tooltip" data-original-title="غير مقروء"><i class="fa  fa-envelope-o"></i></a>';
                                        } elseif ($contact->status == 1) {
                                            echo '<a href="' . ADMINURL . '/contacts/unpublish/' . $contact->contact_id . '" class="btn btn-xs btn-success" type="button" data-toggle="tooltip" data-original-title="مقروء"><i class="fa fa-envelope"></i></a>';
                                        }
                                        ?>
                                        <a href="<?php echo ADMINURL . '/contacts/show/' . $contact->contact_id; ?>" class="btn btn-xs btn-success" data-placement="top" data-toggle="tooltip" data-original-title="عرض"><i class="fa fa-eye"></i></a>
                                        <a href="<?php echo ADMINURL . '/contacts/edit/' . $contact->contact_id; ?>" class="btn btn-xs btn-primary" data-placement="top" data-toggle="tooltip" data-original-title="تعديل"><i class="fa fa-edit"></i></a>
                                        <a href="<?php echo ADMINURL . '/contacts/delete/' . $contact->contact_id; ?>" class="btn btn-xs btn-danger" data-placement="top" data-toggle="tooltip" data-original-title="حذف" onclick="return confirm('Are you sure?') ? true : false"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach;?>

                            <tr class="tab-selected">
                                <th></th>
                                <th></th>
                                <th class="column-title"> العدد الكلي  :   <?php echo $data['recordsCount']; ?>  </th>
                                <th class="column-title"  colspan= "2"> </th>
                                <th class="column-title"> عرض
                                    <select name="perpage" onchange="if (this.value)
                                                window.location.href = '<?php echo ADMINURL . '/contacts/index/' . $data['current']; ?>' + '/' + this.value">
                                        <option value="10" <?php echo ($data['perpage'] == 10) ? 'selected' : null; ?>>10 </option>
                                        <option value="50" <?php echo ($data['perpage'] == 50) ? 'selected' : null; ?>>50 </option>
                                        <option value="100" <?php echo ($data['perpage'] == 100) ? 'selected' : null; ?>>100 </option>
                                        <option value="200" <?php echo ($data['perpage'] == 200) ? 'selected' : null; ?>>200 </option>
                                        <option value="500" <?php echo ($data['perpage'] == 500) ? 'selected' : null; ?>>500 </option>
                                        <option value="1000" <?php echo ($data['perpage'] == 1000) ? 'selected' : null; ?>>1000 </option>
                                    </select>
                                </th>
                                <th class="column-title no-link last" colspan= "5"></th>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <ul class="pagination text-center" >
                    <?php
                    pagination($data['recordsCount'], $data['current'], $data['perpage'], 4, ADMINURL . '/contacts');
                    ?>
                </ul>


            </form>

        </div>
    </div>
</div>
<?php
// loading  plugin
$data['footer'] = '';

require ADMINROOT . '/views/inc/footer.php';
