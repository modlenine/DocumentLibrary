<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= label("add_title", $this); ?></title>
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">




</head>

<body>

    <div class="app-main__outer">
        <!-- Content Zone -->
        <div class="app-main__inner mb-5">
            <!-- Content Zone -->

            <div class="container-fulid border p-4 bg-white">
                <!-- Main Section -->
                <div class="row">
                        <div class="col-md-3">
                        <select name="choose_method" id="choose_method" class="form-control">
    <option value="">กรุณาเลือก หัวข้อ ที่ท่านกำลังจะดำเนินการ</option>

    <?php
    foreach($get_reason->result_array() as $get_reasons){ ?>

    <option value="<?=$get_reasons['dc_reason_code'];?>"><?=$get_reasons['dc_reason_name'];?></option>

<?php
    }
    ?>

</select>
                        </div>
                </div>

<div id="show_add"></div>
            </div>
            <!-- Main Section -->







        </div><!-- Content Zone -->
    </div><!-- Content Zone -->

</body>


</html>