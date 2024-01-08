<?php  
$getuser = $this->get_lib_model->get_new_user();
$get_deptlib = $this->get_lib_model->get_deptlib($getuser->dc_user_new_dept_code);
$rsget = $get_deptlib->row();

?>


<table id="admin_search" class="table table-striped table-bordered dt-responsive" style="width:100%">
    <thead>
        <tr>
            <th>#</th>
            <th>รหัสเอกสาร</th>
            <th>ชื่อเอกสาร</th>
            <th>วันที่ร้องขอ</th>
            <th>เลขที่ใบ DAR</th>
            <th>สถานะ</th>
        </tr>
    </thead>
    <tbody>


        <?php $i = 1;
        foreach ($rs->result_array() as $rss) { 
            if ($rss['lib_main_status'] == "active") {
                $color_status = " style='color:green' ";
            } else {
                $color_status = " style='color:red' ";
            }
            
            ?>

            <tr>
                <td><?= $i ?></td>
                <td><a href="<?= base_url('librarys/viewFull_document/') . $rss['dc_data_sub_type'] . "/" . $rsget->related_code . "/" . $rss['lib_main_doccode'] ?>"><i class="fas fa-file-pdf" style="color:#CC0000;"></i>&nbsp;&nbsp;<?= $rss['dc_data_doccode_display']; ?></a></td>
                <td><?= $rss['dc_data_docname']; ?></td>
                <td><?= con_date($rss['dc_data_date']) ?></td>
                <td><?= $rss['lib_main_darcode']; ?></td>
                <td <?= $color_status ?>><b><?= $rss['lib_main_status']; ?></b></td>
            </tr>


        <?php $i++;
        } ?>

    </tbody>
</table>