<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<?php
$rs_doc_detail = $viewfull_gl_document->row();
?>

<body>
    <div class="app-main__outer">
        <!-- Content Zone -->
        <div class="app-main__inner">
            <!-- Content Zone -->
            <div class="container border p-4 bg-white">

                <div class="card border-danger mb-3">
                    <div class="card-header bg-info text-white" style="font-size:18px;"><?= $rs_doc_detail->gl_doc_name ?></div>
                    <div class="card-body text-primary table-responsive">
                        <div class="row">
                            <div class="col-md-4">
                                <label style="font-size:18px;"><b>รหัสเอกสาร :</b></label>
                                <?= $rs_doc_detail->gl_doc_code ?>
                            </div>
                            <div class="col-md-8">
                                <label style="font-size:18px;"><b>ชื่อเอกสาร :</b></label>
                                <?= $rs_doc_detail->gl_doc_name ?>
                            </div>
                        </div>

                        <div class="row mt-2 mb-4">
                            <div class="col-md-12">
                                <label style="font-size:18px;"><b>รายละเอียด :</b></label>
                                <?= $rs_doc_detail->gl_doc_detail ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <embed src="<?= base_url('asset/general_document/') . $rs_doc_detail->gl_doc_file ?>" type="application/pdf" width="100%" height="600px" />
                            </div>
                        </div>

                    </div>
                </div>