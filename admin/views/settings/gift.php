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

<!-- setting content -->

<div class="right_col" role="main">
    <div class="clearfix"></div>
    <?php flash('setting_msg'); ?>
    <div class="setting-title">
        <div class="title_right">
            <h3><small>التعديل علي </small><?php echo $data['title']; ?> </h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/settings" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>
    <div class="clearfix"></div>
    <form class="row" action="<?php echo ADMINURL . '/settings/edit/' . $data['setting_id']; ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
        <div class="form-group col-xs-12">
            <label class="control-label" for="settingTitle">عنوان الاعداد : </label>
            <div class="has-feedback">
                <input type="text" id="settingTitle" class="form-control" name="title" placeholder="عنوان الاعداد" value="<?php echo $data['title']; ?>">
            </div>
        </div>
        <div class="x_panel tile ">
            <h4 class="x_title">اعدادات رسالة تأكيد الأهداء </h4>
            <!-- <div class="form-group">
                <label class="control-label" for="subject">عنوان الرسالة : </label>
                <div class="has-feedback">
                    <input type="text" id="subject" class="form-control" name="value[subject]" placeholder="عنوان الرسالة" value="<?php echo $data['value']->subject; ?>">
                </div>
            </div> -->
            <div class="form-group col-xs-12 ">
                <br>
                <button type="button" class="btn btn-primary" onclick="$('#msg').val($('#msg').val() +'[[giver_name]]') ;return false;" value="">اسم المهدى إليه </button>
                <button type="button" class="btn btn-primary" onclick="$('#msg').val($('#msg').val() +'[[from_name]]') ;return false;" value="">اسم الهادي </button>
                <button type="button" class="btn btn-primary" onclick="$('#msg').val($('#msg').val() +'[[giver_group]]') ;return false;" value="">فئة الإهداء </button>
                <button type="button" class="btn btn-primary" onclick="$('#msg').val($('#msg').val() +'[[card]]') ;return false;" value="">ارفاق رابط الكارت  </button>
                <button type="button" class="btn btn-primary" onclick="$('#msg').val($('#msg').val() +'[[project]]') ;return false;" value="">ارفاق اسم المشروع </button>
                <small class="red ">سيتم استبدال المتغير الخاص بالقيمة </small>
            </div>
            <div class="form-group col-md-12">

                <label class="control-label">المحتوي : </label>
                <div class="row">
                    <textarea id="msg" name="value[msg]" rows="9" class="form-control"><?php echo ($data['value']->msg); ?></textarea>
                </div>
            </div>
        </div>
        <div id="gift-filed">
            <?php
            foreach ($data['value'] as $key => $row) {
                if ($key == 'subject' || $key == 'msg') continue;
            ?>
                <div>
                    <div class="form-group col-xs-6 ggg">
                        <label class="control-label">اسم الفئة : </label>
                        <div class="has-feedback">
                            <input type="text" class="form-control" name="value[row<?php echo $key; ?>][name]" placeholder="اسم الفئة " value="<?php echo $row->name; ?>">
                        </div>
                    </div>
                    <div class="form-group col-xs-6 ggg-card">
                        <label class="control-label" for="<?php  ?>">صورة الكارت :
                        </label>
                        <div class="glr-group ">
                            <a data-toggle="modal" href="javascript:;" data-target="#myModal<?php echo $key;  ?>" class="glr-btn col-xs-2" type="button">اختيار</a>
                            <input id="<?php echo $key;  ?>" readonly name="value[row<?php echo $key;  ?>][image]" class="glr-control  col-xs-9" type="text" value="<?php echo $row->image; ?>">
                            <a class="text-danger fa-lg remove-row">&nbsp<i class="fa fa-close fa-lg  "></i></a>
                        </div>
                        <!-- /.modal -->
                        <div class="modal fade" id="myModal<?php echo $key;  ?>" style=" margin-left: 0px;">
                            <div class="modal-dialog" style="width: 80%;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title">اختيار الصور</h4>
                                    </div>
                                    <div class="modal-body">
                                        <iframe width="100%" height="500" src="<?php echo ADMINURL; ?>/helpers/filemanager/dialog.php?type=2&field_id=<?php echo $key;  ?>&relative_url=1" frameborder="0" style="overflow: scroll; overflow-x: hidden; overflow-y: scroll; "></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.modal -->
                    </div>
                </div>
            <?php } ?>
        </div>

        <botton class="add-gift-filed btn btn-success">اضافة فئة جديدة</botton>
        <br class="clear">
        <div class="col-xs-6"><br><br>
            <button type="submit" name="save" class="btn btn-success">تعديل
                <i class="fa fa-save"> </i></button>
            <button type="submit" name="submit" class="btn btn-success">تعديل وعودة
                <i class="fa fa-save"> </i></button>
            <button type="reset" class="btn btn-danger">مسح
                <i class="fa fa-trash "> </i></button>
        </div>
    </form>
</div>

<?php
// loading plugin
$data['footer'] = '<script src="' . ADMINURL . '/template/default/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>' . "\n";

require ADMINROOT . '/views/inc/footer.php';
?>
<script>
    var max_fields = 20; //maximum input boxes allowed
    var wrapper = $("#gift-filed"); //Fields wrapper
    var add_button = $(".add-gift-filed"); //Add button class
    var x = $('#gift-filed .ggg').length; //initlal text box count
    //adding new bank account
    $(add_button).click(function(e) { //on add input button click
        e.preventDefault();
        if (x < max_fields) { //max input box allowed
            x++; //text box increment
            $(wrapper).append(
                '<div><div class="form-group col-xs-6 ggg">' +
                '       <label class="control-label">اسم الفئة  : </label>' +
                '       <div class="has-feedback">' +
                '           <input type="text" class="form-control" name="value[row' + x + '][name]" placeholder="اسم الفئة " >' +
                '       </div>' +
                '   </div>' +
                '   <div class="form-group col-xs-6">' +
                '       <label class="control-label" for="group' + x + '">صورة الكارت  :</label>' +
                '       <div class="glr-group ">' +
                '           <a data-toggle="modal"  href="javascript:;" data-target="#myModal' + x + '" class="glr-btn col-xs-2" type="button">اختيار</a>' +
                '           <input  id="group' + x + '" readonly name="value[row' + x + '][image]" class="glr-control  col-xs-9" type="text" >' +
                '       </div>' +
                '<!-- /.modal -->' +
                '       <div class="modal fade" id="myModal' + x + '" style=" margin-left: 0px;">' +
                '           <div class="modal-dialog" style="width: 80%;">' +
                '               <div class="modal-content">' +
                '                   <div class="modal-header">' +
                '                       <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>' +
                '                       <h4 class="modal-title">اختيار الصور</h4>' +
                '                   </div>' +
                '                   <div class="modal-body" >' +
                '                       <iframe width="100%" height="500" src="<?php echo ADMINURL; ?>/helpers/filemanager/dialog.php?type=2&field_id=group' + x + '&relative_url=1" frameborder="0" style="overflow: scroll; overflow-x: hidden; overflow-y: scroll; "></iframe>' +
                '                   </div>' +
                '               </div>' +
                '           </div>' +
                '       </div>' +
                '<!-- /.modal -->' +
                '</div></div>'
            ); //add input box
        }
    });

    // remove row
    $('.remove-row').click(function() {
        $(this).parent().parent().parent().remove()
    })
</script>