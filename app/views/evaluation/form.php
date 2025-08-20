<?php require APPROOT . '/app/views/inc/header.php'; ?>

<div class="container bg-light text-right py-2">
    <?php flash('msg'); ?>


    <?php  if(! empty(flash('msg'))  == NULL )  { ?>
        <div class="row justify-content-md-center">
            <div class="col-lg-6 col-sm-12 py-5">
                <div class="text-center py-2">
                    <h2 class="text-secondary"> <?php echo $data['page_title'] ?></h2>
                </div>
                <form action="<?php URLROOT . '/Evaluation/index'; ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                    <div class="row mt-5">
                        <select name="client_type" class="form-control" id="type_questions" required>
                            <option value="" selected disabled>أختر </option>
                            <option value="employee">موظف</option>
                            <option value="student">طالب</option>
                        </select>
                    </div>

                    <div class="rowform-group mt-4 d-none  <?php echo (empty($data['answer_error'])) ?: 'has-error'; ?>"  id="employee_question">
                        <?php foreach ($data['questions'] as $key => $question) { ?>
                            <div class="row mt-3 px-5">
                                <p class="control-label fw-bold"> <strong> <?php echo $question ?> </strong> </p>
                                <div class="col-lg-12 col-sm-12">
                                    <?php foreach ($data['answers'][$key] as $val => $answer) {   ?>
                                        <div class="col-lg-12 col-sm-12">
                                            <input id="employee_<?=$val ?>_<?= $key ?>" class="employee_radio" type="radio" name="client_answer[<?php echo $key ?>]" value="<?php echo $val ?>" required>
                                            <label for="employee_<?= $val ?>_<?= $key ?>"><?php echo $answer ?></label>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                        <span class="invalid-feedback"><?php echo $data['answer_error']; ?></span>
                    </div>

                    <div class="rowform-group mt-4 d-none  <?php echo (empty($data['answer_error'])) ?: 'has-error'; ?>" id="student_question">
                        <?php foreach ($data['student_questions'] as $key => $question) { ?>
                            <div class="row mt-3 px-5">
                                <p class="control-label fw-bold"> <strong> <?php echo $question ?> </strong> </p>
                                <div class="col-lg-12 col-sm-12">
                                    <?php foreach ($data['student_answers'][$key] as $val => $answer) {   ?>
                                        <div class="col-lg-12 col-sm-12">
                                            <input id="student_<?= $val ?>_<?= $key ?>" class="student_radio" type="radio" name="student_answer[<?php echo $key ?>]" value="<?php echo $val ?>" required>
                                            <label for="student_<?= $val ?>_<?= $key ?>"><?php echo $answer ?></label>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                        <span class="invalid-feedback"><?php echo $data['answer_error']; ?></span>
                    </div>


                    <hr>
                    <div class="col-lg-12 col-sm-12 col-xs-12 mb-5 d-none"  id="customer_info">
                        <!-- name -->
                        <div class="form-group  <?php echo (empty($data['name_error'])) ?: 'has-error'; ?>">
                            <label class="control-label">الاسم بالكامل : </label>
                            <div class="has-feedback">
                                <input type="text" class="form-control <?php if (!empty($data['name'])) echo 'is-invalid'; ?>" name="name" placeholder="الاسم بالكامل" value="<?php echo $data['name']; ?>" required>
                                <span class="invalid-feedback"><?php echo $data['name_error']; ?></span>
                            </div>
                        </div>
                        <!-- mobile -->
                        <div class="form-group   <?php echo (empty($data['mobile_error'])) ?: 'has-error'; ?>">
                            <label class="control-label">رقم الجوال : </label>
                            <div class="has-feedback">
                                <input type="text" class="form-control <?php if (!empty($data['mobile_error'])) echo 'is-invalid'; ?>" name="mobile" placeholder="0500000000" id="mobile" data-inputmask="'mask': '9999999999'" value="<?php echo $data['mobile']; ?>" required>
                                <span class="fa fa-edit form-control-feedback" aria-hidden="true"></span>
                                <span class="invalid-feedback"><?php echo $data['mobile_error']; ?></span>
                            </div>
                        </div>
                        <!-- email -->
                        <div class="form-group  <?php echo (empty($data['email_error'])) ?: 'has-error'; ?>">
                            <label class="control-label">البريد الالكتروني : </label>
                            <div class="has-feedback">
                                <input type="text" class="form-control <?php if (!empty($data['email_error'])) echo 'is-invalid'; ?>" name="email" placeholder=" البريد الالكتروني" value="<?php echo $data['email']; ?>">
                                <span class="fa fa-edit form-control-feedback" aria-hidden="true"></span>
                                <span class="invalid-feedback"><?php echo $data['email_error']; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 text-center">
                        <button type="submit" name="submit" class="btn btn-success"> إرسال
                            <i class="fa fa-save"> </i></button>
                        <button type="reset" class="btn btn-danger">مسح
                            <i class="fa fa-trash "> </i></button>
                    </div>
                </form>
            </div>
        </div>
    <?php } ?>

    <script>
        const selectElement = document.getElementById('type_questions');
        const employeeDiv = document.getElementById('employee_question');
        const studentDiv = document.getElementById('student_question');
        const infoDev = document.getElementById('customer_info');

        selectElement.addEventListener('change', () => {
            const selectedValue = selectElement.value;
            
            infoDev.classList.remove('d-none');

            if (selectedValue === 'employee') {
                employeeDiv.classList.remove('d-none');
                studentDiv.classList.add('d-none');
                const studentRadioButtons = document.querySelectorAll('.student_radio');
                studentRadioButtons.forEach(radioButton => {
                    radioButton.removeAttribute('required');
                });

            } else if (selectedValue === 'student') {
                studentDiv.classList.remove('d-none');
                employeeDiv.classList.add('d-none');
                const employeeRadioButtons = document.querySelectorAll('.employee_radio');
                employeeRadioButtons.forEach(radioButton => {
                    radioButton.removeAttribute('required');
                });
            }
        });

    </script>
</div>

<?php
$data['settings']['site']->footer_code .= '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
require APPROOT . '/app/views/inc/footer.php';
?>