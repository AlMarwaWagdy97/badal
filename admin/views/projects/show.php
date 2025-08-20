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

// loading plugin style
$data['header'] = '';
header("Content-Type: text/html; charset=utf-8");
require ADMINROOT . '/views/inc/header.php';
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="clearfix"></div>
    <?php flash('project_msg'); ?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['page_title']; ?> <small>عرض محتوي الصفحة </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/projects" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="form-group">
                <h3 class="prod_title">
                    <?php echo $data['project']->name; ?>
                </h3>
            </div>
            <div class="form-group">
                <h3 class="prod_title">
                    <label class="control-label">الرابط : </label>
                    <a href="<?php echo URLROOT . '/projects/show/' . $data['project']->project_id; ?>"><?php echo URLROOT . '/projects/show/' . $data['project']->project_id; ?></a>
                </h3>
            </div>
            <div class="well img-thumbnail col-md-6 col-sm-6">
                <label class="control-label">الصورة الرئيسية : </label>
                <?php if (!empty($data['project']->image)) :
                    $galery = explode(',', $data['project']->image);
                    foreach ($galery as $img) {
                        $img = MEDIAURL . '/' . str_replace('&#34;', '', trim(trim($img, ']'), '['));
                        echo
                            ' <img src="' . $img . '" class="img-responsive img-rounded"> ';
                    }
                endif; ?>
                <img src="<?php echo empty($data['project']->image) ? MEDIAURL . '/default.jpg' : ''; ?>" />
            </div>
            <div class="well img-thumbnail col-md-6 col-sm-6">
                <label class="control-label">الصورة الخارجية : </label>
                <img class="img-responsive img-rounded" src="<?php echo empty($data['project']->secondary_image) ? MEDIAURL . '/default.jpg' : MEDIAURL . '/' . $data['project']->secondary_image; ?>" />
            </div>
            <div class="form-group col-md-6 col-xs-6">
                <label class="control-label">الوصف : </label>
                <p><?php echo $data['project']->description ?: 'لا يوجد'; ?></p>
            </div>
            <div class="form-group col-md-6 col-xs-6">
                <label class="control-label">الرابط : </label>
                <p class="ltr"><a href="http://<?php echo URLROOT . $data['project']->alias; ?>" target="_blank" rel="noopener noreferrer"><?php echo URLROOT . $data['project']->alias; ?></a></p>
            </div>
            <div class="form-group col-md-6 col-xs-6">
                <label class="control-label">رقم المشروع : </label>
                <p class="ltr"><?php echo $data['project']->project_number; ?></p>
            </div>
            <div class="form-group col-md-6 col-xs-6">
                <label class="control-label">الترتيب : </label>
                <p><?php echo $data['project']->arrangement; ?></p>
            </div>
            <div class="form-group col-md-6 col-xs-6">
                <label class="control-label">يقبل الاضافة في السلة : </label>
                <p><?php echo $data['project']->enable_cart ? 'نعم' : 'لا'; ?></p>
            </div>
            <div class="form-group col-md-6 col-xs-6">
                <label class="control-label">يجب تأكيد الجوال : </label>
                <p><?php echo $data['project']->mobile_confirmation ? 'نعم' : 'لا'; ?></p>
            </div>
            <div class="form-group col-md-6 col-xs-6">
                <label class="control-label">يقبل الاهداء الخيري : </label>
                <p><?php echo $data['project']->gift ? 'نعم' : 'لا'; ?></p>
            </div>
            <div class="form-group col-md-6 col-xs-6">
                <label class="control-label">نوع التبرع : </label>
                <p><?php
                    $donation_type = json_decode($data['project']->donation_type, true);
                    echo $data['donation_type_list'][$donation_type['type']];
                    ?></p>
            </div>
            <div class="form-group col-md-6 col-xs-6">
                <label class="control-label">وسائل الدفع المدعومة : </label>
                <ul class="list-group">
                    <?php
                    foreach ($data['paymentMethodsList'] as $payMethod) {
                        echo '<li class="list-group-item ">' . $payMethod->title . '</li>';
                    }
                    ?>
                </ul>
            </div>
            <div class="form-group col-md-6 col-xs-6">
                <label class="control-label">المبلغ المستهدف : </label>
                <p><?php echo $data['project']->target_price ?: 'لا يوجد'; ?></p>
            </div>
            <div class="form-group col-md-6 col-xs-6">
                <label class="control-label"> المبلغ المستهدف المؤقت : </label>
                <p><?php echo $data['project']->fake_target ?: 'لا يوجد'; ?></p>
            </div>
            <div class="form-group col-md-6 col-xs-6">
                <label class="control-label">العودة للرئيسية : </label>
                <p><?php echo $data['project']->back_home ? 'نعم' : 'لا'; ?></p>
            </div>
            <div class="form-group col-md-6 col-xs-6">
                <label class="control-label">مميزة : </label>
                <p><?php echo $data['project']->featured ? 'نعم' : 'لا'; ?></p>
            </div>
            <div class="form-group col-md-6 col-xs-6">
                <label class="control-label">اغلاق التبرع : </label>
                <p><?php echo $data['project']->finished ? 'نعم' : 'لا'; ?></p>
            </div>
            <div class="form-group col-md-6 col-xs-6">
                <label class="control-label">النشر كا مخفي : </label>
                <p><?php echo $data['project']->hidden ? 'نعم' : 'لا'; ?></p>
            </div>
            <div class="form-group col-md-6 col-xs-6">
                <label class="control-label">حالة النشر : </label>
                <p><?php echo $data['project']->status ? 'منشور' : 'غير منشور'; ?></p>
            </div>
            <div class="form-group col-md-6 col-xs-6">
                <label class="control-label">تاريخ بداية النشر : </label>
                <p><?php echo $data['project']->modified_date ? date('d/ M/ Y', $data['project']->start_date) : 'لا'; ?></p>
            </div>
            <div class="form-group col-md-6 col-xs-6">
                <label class="control-label">تاريخ انتهاء النشر : </label>
                <p><?php echo $data['project']->create_date ? date('d/ M/ Y', $data['project']->end_date) : 'لا'; ?></p>
            </div>
            <div class="form-group col-md-6 col-xs-6">
                <label class="control-label">اخر تحديث : </label>
                <p><?php echo $data['project']->modified_date ? date('d/ M/ Y', $data['project']->modified_date) : 'لا'; ?></p>
            </div>
            <div class="form-group col-md-6 col-xs-6">
                <label class="control-label">وقت الإنشاء : </label>
                <p><?php echo $data['project']->create_date ? date('d/ M/ Y', $data['project']->create_date) : 'لا'; ?></p>
            </div>
            <div class="form-group col-md-6 col-xs-6">
                <label class="control-label"> رسالة الشكر : </label>
                <p><?php echo $data['project']->thanks_message ?: 'لا يوجد'; ?></p>
            </div>
            <div class="form-group col-md-6 col-xs-6">
                <label class="control-label"> رقم الهاتف : </label>
                <p><?php echo $data['project']->mobile ?: 'لا يوجد'; ?></p>
            </div>
            <div class="form-group col-md-6 col-xs-6">
                <label class="control-label"> رقم الواتس : </label>
                <p><?php echo $data['project']->whatsapp ?: 'لا يوجد'; ?></p>
            </div>
            <div class="form-group col-md-6 col-xs-6">
                <label class="control-label"> الزيارات : </label>
                <p><?php echo $data['project']->hits ?: 'لا يوجد'; ?></p>
            </div>
            <div class="form-group col-md-6 col-xs-6">
                <label class="control-label">وصف مختصر لمحرك البحث : </label>
                <div class="well">
                    <?php echo $data['project']->meta_description ?: 'لا يوجد'; ?>
                </div>
            </div>
            <div class="form-group col-md-6 col-xs-6">
                <label class="control-label tags">الكلمات الدلالية :</label>
                <div class=" well">
                    <?php echo $data['project']->meta_keywords ?: 'لا يوجد'; ?>
                </div>
            </div>
            <div class="form-group col-xs-12">
                <a class="btn btn-info" href="<?php echo ADMINURL . '/projects/edit/' . $data['project']->category_id; ?>">تعديل</a>
            </div>


        </div>
    </div>
</div>

<?php
// loading plugin
$data['footer'] = '';

require ADMINROOT . '/views/inc/footer.php';
