<?php
require APPROOT . '/app/views/inc/header.php';
?>
<div class="container mt-5 py-5">
    <?php flash('msg'); ?>
    <div class="card cart">
        <div class="card-header text-center">
            <h4 class=""> البحث</h4>
        </div>
        <div class="card-body text-right">
            <div class="card-text">
                <form action="<?php root('search'); ?>" method="get">
                    <div class="search-box input-group ltr">
                        <div class="input-group-prepend">
                            <div class="form-group">
                                <select class="form-control" name="section" id="">
                                    <option value="projects">المشروعات</option>
                                    <option value="categories">الاقسام</option>
                                    <option value="pages">الصفحات</option>
                                </select>
                            </div>
                        </div>
                        <input type="text" class="form-control" name="keyword" aria-label="">
                        <div class="input-group-append d-block">
                            <button class="btn btn-secondary" name="search" type="submit"> بحث </button>
                        </div>
                    </div>
                </form>
                <table class="table table-striped table-inverse table-bordered">
                    <tbody>
                        <?php
                        if (count($data['result']) > 0) {
                            foreach ($data['result'] as $key => $row) {
                                if (isset($row->page_id)) $url = URLROOT . '/pages/show/' . $row->page_id;
                                if (isset($row->project_id)) $url = URLROOT . '/projects/show/' . $row->project_id;
                                if (isset($row->parent_id)) $url = URLROOT . '/projectCategories/show/' . $row->category_id;
                                echo '<tr>
                                <td>' . $key++ . '</td>
                                <td><a href="' . $url . '" target="_blank" rel="noopener noreferrer">' . $row->name . '</a></td>
                            </tr>';
                            }
                        }

                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <a class="btn btn-success px-5 my-4 mx-auto" href="<?php echo URLROOT; ?>">العودة الي الرئيسية</a>
    </div>
</div>
<?php
require APPROOT . '/app/views/inc/footer.php'; ?>