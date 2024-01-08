<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Copy File</title>
</head>

<?php
$getF = $get_fulldata->row();
?>

<body>

    <form action="<?= base_url('fpdi/pdf_copy.php') ?>" method="POST">
        <div class="container">
            <div class="form-row">
                <div><label>รหัสเอกสาร :</label>&nbsp;&nbsp;<label><?= $getF->dc_data_doccode ?></label></div>
            </div>
            <div class="form-row">
                <div><label>ชื่อเอกสาร :</label>&nbsp;&nbsp;<label><?= $getF->dc_data_docname ?></label></div>
            </div>
            <div class="form-row">
                <div><label>ชื่อไฟล์เอกสาร :</label>&nbsp;&nbsp;<label><a href="<?= base_url() ?><?= $getF->dc_data_file_location; ?><?= $getF->dc_data_file ?>" target="_blank"><?= $getF->dc_data_file ?></a></label></div>
            </div>

            <div class="form-row">
                <input type="text" name="copy_doccode" id="copy_doccode" value="<?= $getF->dc_data_doccode ?>">
                <input type="text" name="copy_docname" id="copy_docname" value="<?= $getF->dc_data_docname ?>">
                <input type="text" name="copy_docfile" id="copy_docfile" value="<?= $getF->dc_data_file_location; ?><?= $getF->dc_data_file ?>">
                <input type="submit" value="ยืนยัน" name="btn_copy" id="btn_copy">
            </div>
        </div>




    </form>

</body>

</html>