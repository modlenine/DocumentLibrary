<!doctype html>

<html lang="en">

<?php



error_reporting(E_ALL & ~E_NOTICE);

// header("refresh:0; url=".base_url('login/maweb/'));
// die;

?>

<head>

    <link rel="icon" type="image/png" href="<?= base_url('assets/images/') ?>slc.ico" />
    <script src="<?= base_url("js/jquery.min.js") ?>"></script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
    <meta name="msapplication-tap-highlight" content="no">


    <link href="<?= base_url("main.css"); ?>" rel="stylesheet">
    <link href="<?= base_url("css/custom.css"); ?>" rel="stylesheet">
    <script src="<?= base_url("js/dc.js") ?>"></script>
    <script src="<?=base_url('assets/js/axios.min.js')?>"></script>

    <!-- Data table -->
    <!-- <link rel="stylesheet" href="<?= base_url('css/jquery.dataTables.min.css') ?>">
    <script src="<?= base_url("js/jquery.dataTables.min.js") ?>"></script>
    <script src="<?= base_url("js/dataTables.responsive.min.js") ?>"></script>
    <link rel="stylesheet" type="text/css" href="<?= base_url('css/responsive.dataTables.min.css') ?>" />
    <script src="<?= base_url("js/dataTables2.responsive.min.js") ?>"></script> -->
    
    <!-- Data table -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/datatable/')?>dataTables.bootstrap4.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/datatable/')?>bootstrap.css"/>
    <!-- <script src="https://code.jquery.com/jquery-3.7.0.js"></script> -->
    <script src="<?= base_url('assets/datatable/')?>jquery.dataTables.min.js"></script>
    <script src="<?= base_url('assets/datatable/')?>dataTables.bootstrap4.min.js"></script>


    <!-- Date pickadate Style -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('css/pickadate/classic.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?= base_url('css/pickadate/classic.date.css') ?>" />
    <!-- Date pickadate Style -->

    <link rel="stylesheet" type="text/css" href="<?=base_url('assets/')?>sweetalert2/sweetalert2.css">

    <style>
        /* thai */
        @font-face {
            font-family: 'Sarabun';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: local('Sarabun Regular'), local('Sarabun-Regular'), url(<?= base_url('assets/fonts/DtVjJx26TKEr37c9aAFJn2QN.woff2') ?>) format('woff2');
            unicode-range: U+0E01-0E5B, U+200C-200D, U+25CC;
        }

        /* vietnamese */
        @font-face {
            font-family: 'Sarabun';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: local('Sarabun Regular'), local('Sarabun-Regular'), url(<?= base_url('assets/fonts/DtVjJx26TKEr37c9aBpJn2QN.woff2') ?>) format('woff2');
            unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
        }

        /* latin-ext */
        @font-face {
            font-family: 'Sarabun';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: local('Sarabun Regular'), local('Sarabun-Regular'), url(<?= base_url('assets/fonts/DtVjJx26TKEr37c9aBtJn2QN.woff2') ?>) format('woff2');
            unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }

        /* latin */
        @font-face {
            font-family: 'Sarabun';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: local('Sarabun Regular'), local('Sarabun-Regular'), url(<?= base_url('assets/fonts/DtVjJx26TKEr37c9aBVJnw.woff2') ?>) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        * {
            font-family: 'Sarabun', sans-serif;
        }


        body {
            font-size: .85rem !important;
        }

        .form-control {
            font-size: .85rem !important;
        }

        table {
            font-size: .85rem !important;
        }



        .status_color {
            color: green;
        }



        #overlay {
            position: absolute;
            top: 0px;
            left: 0px;
            background: #333333;
            width: 100%;
            height: 100%;
            opacity: .95;
            filter: alpha(opacity=95);
            -moz-opacity: .95;
            z-index: 999;
            background: #fff url(http://intranet.saleecolour.com/intsys/doc_library/asset/KUJoe.gif) 50% 50% no-repeat;
        }

        .col-search-input {
            width: 100% !important;
        }
    </style>





    <?php
        $getuser = $this->login_model->getuser();
        $getuserCon = $this->doc_get_model->convertName($getuser->Fname, $getuser->Lname);
        get_modal();
    ?>

    <link rel="shortcut icon" href="slc.ico">
</head>



<div id="overlay"></div>

<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        <!-- Topbar -->
        <div class="app-header header-shadow">

            <!-- Logo section -->
            <div class="app-header__logo">
                <div class="logo-src"></div>
                <div class="header__pane ml-auto">
                    <div>
                        <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>

            <input hidden type="text" name="checkPage" id="checkPage" value="<?= $this->uri->segment(2) ?>">
            <!-- Logo section -->


            <div class="app-header__mobile-menu">
                <div>
                    <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>


            <div class="app-header__menu">
                <span>
                    <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                        <span class="btn-icon-wrapper">
                            <i class="fa fa-ellipsis-v fa-w-6"></i>
                        </span>
                    </button>
                </span>
            </div>


            <!-- Header content -->
            <div class="app-header__content">
                <!-- Topmenu left -->
                <div class="app-header-left">
                </div>
                <!-- Topmenu left -->

                <!-- Top menu right -->
                <div class="app-header-right">
                    <div class="header-btn-lg pr-0">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left">

                                    <?php
                                    $username = $_SESSION['username'];
                                    $result = get_group($username);
                                    $getdatarow = $result->row();
                                    $deptcode = get_deptcode_new($username)->dc_user_new_dept_code;
                                    ?>

                                    <!-- Check Section -->
                                    <input hidden type="text" name="check_group" id="check_group" value="<?= $getdatarow->dc_gp_permis_name ?>" />

                                    <input hidden type="text" name="check_username" id="check_username" value="<?= $getuserCon ?>">

                                    <input hidden type="text" name="check_new_deptcode" id="check_new_deptcode" value="<?= $deptcode ?>">
                                    <!-- Check Section -->
                                </div>

                                <div class="widget-content-left  ml-3 header-user-info">
                                    <div class="widget-heading">
                                        <?= $getuserCon; ?>
                                        <input hidden type="text" name="check_userlogin" id="check_userlogin" value="<?= $getuserCon; ?>">
                                        <input hidden type="text" name="checkNewDeptCode" id="checkNewDeptCode" value="<?= getUserN($getuser->ecode)->dc_user_new_dept_code ?>">
                                        <!-- Check user permission for btn_edit -->
                                    </div>

                                    <div class="widget-subheading">
                                        <?= $getuser->ecode; ?> - <?= $getuser->DeptCode; ?>
                                    </div>
                                </div>

                                <div class="widget-content-right header-user-info ml-3">
                                    <a href="<?= base_url('login/logout'); ?>"><button type="button" class="btn-shadow p-1 btn btn-primary btn-sm" onclick="javascript:return confirm('คุณต้องการออกจากระบบใช่หรือไม่')">
                                            <i class="fas fa-sign-out-alt pr-1 pl-1" style="font-size:16px;"></i>
                                        </button>
                                    </a>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
                <!-- Top menu right -->
            </div>
            <!-- Header content -->

        </div>

        <!-- Topbar -->









        <div class="app-main">
            <!-- Slide Nav bar left -->
            <div class="app-sidebar sidebar-shadow">
                <div class="app-header__logo">
                    <div class="logo-src"></div>
                    <div class="header__pane ml-auto">
                        <div>
                            <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="app-header__mobile-menu">
                    <div>
                        <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>

                <div class="app-header__menu">
                    <span>
                        <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                            <span class="btn-icon-wrapper">
                                <i class="fa fa-ellipsis-v fa-w-6"></i>
                            </span>
                        </button>
                    </span>
                </div>


                <!-- Left Menu -->
                <div class="scrollbar-sidebar">
                    <div class="app-sidebar__inner">
                        <?php
                        if ($this->uri->segment(2) == "dashboard") {
                            $dashmain = ' mm-active';
                            $dashli = 'mm-active';
                        } else {
                            $dashmain = '';
                            $dashli = '';
                        }
                        ?>

                        <ul class="vertical-nav-menu">
                            <li class="app-sidebar__heading">Dashboards</li>
                            <li class="<?= $dashmain ?>">
                                <a href="<?= base_url('document/dashboard'); ?>" class="<?= $dashli ?>">
                                    <!-- <i class="metismenu-icon pe-7s-rocket"></i> -->
                                    <i class="metismenu-icon fas fa-chart-line"></i>
                                    Dashboard
                                </a>
                            </li>

                            <?php
                            if ($this->uri->segment(2) == "isoPge" || $this->uri->segment(2) == "view_document" || $this->uri->segment(2) == "viewFull_document") {
                                $li_search = ' mm-active ';
                                $search_dept = 'mm-active';
                                $search_center = '';
                                $search_me = '';
                                $search_control = '';
                            } else if ($this->uri->segment(2) == "document_center" || $this->uri->segment(2) == "viewfull_gl_document" || $this->uri->segment(2) == "view_gl_document") {
                                $search_center = 'mm-active';
                                $li_search = ' mm-active ';
                                $search_me = '';
                                $search_dept = '';
                                $search_control = '';
                            } else if ($this->uri->segment(2) == "document_me") {
                                $search_center = '';
                                $li_search = ' mm-active ';
                                $search_me = '';
                                $search_dept = '';
                                $search_me = 'mm-active';
                                $search_control = '';
                            }else if($this->uri->segment(2) == "control_document" || $this->uri->segment(2) == "viewfull_library_ctrldoc"){
                                $search_center = '';
                                $li_search = ' mm-active ';
                                $search_me = '';
                                $search_dept = '';
                                $search_me = '';
                                $search_control = ' mm-active ';
                            } else {
                                $search_center = '';
                                $li_search = '';
                                $search_me = '';
                                $search_dept = '';
                                $search_me = '';
                            }
                            ?>

                            <li class="app-sidebar__heading"></i>Document</li>
                            <li class="<?= $li_search ?>">
                                <a href="#">
                                    <i class="metismenu-icon fas fa-archive"></i>
                                    ค้นหาเอกสาร
                                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                </a>
                                <ul>
                                    <!-- <li>
                                        <a href="<?= base_url('librarys') ?>" class="<?= $search_dept ?>">
                                            <i class="metismenu-icon"></i>
                                            ตู้เอกสาร ISO
                                        </a>
                                    </li> -->

                                    <li>
                                        <a href="<?= base_url('librarys/isoPge') ?>" class="<?= $search_dept ?>">
                                            <i class="metismenu-icon"></i>
                                            ตู้เอกสาร ISO
                                        </a>
                                    </li>

                                    <li>
                                        <a href="<?= base_url('ctrldoc/control_document') ?>" class="<?= $search_control ?>">
                                            <i class="metismenu-icon"></i>
                                            ตู้เอกสาร ควบคุม
                                        </a>
                                    </li>

                                    <li>
                                        <a href="<?= base_url('librarys/document_center') ?>" class="<?= $search_center ?>">
                                            <i class="metismenu-icon"></i>
                                            ตู้เอกสาร ทั่วไป
                                        </a>
                                    </li>
                                </ul>
                            </li>


                            <?php
                            if ($this->uri->segment(2) == "list_dar" || $this->uri->segment(2) == "viewfull") {
                                $doc_list = ' mm-active';
                                $doc_list_iso = 'mm-active';
                                $doc_list_ctrl = '';
                                $doc_list_gl = '';
                            } else if ($this->uri->segment(2) == "list_generel" || $this->uri->segment(2) == "gl_view_doc") {
                                $doc_list = ' mm-active';
                                $doc_list_iso = '';
                                $doc_list_ctrl = '';
                                $doc_list_gl = 'mm-active';
                            }else if($this->uri->segment(2) == "list_docctrl"){
                                $doc_list = ' mm-active';
                                $doc_list_iso = '';
                                $doc_list_ctrl = 'mm-active';
                                $doc_list_gl = '';
                            } else {
                                $doc_list = '';
                                $doc_list_iso = '';
                                $doc_list_ctrl = '';
                                $doc_list_gl = '';
                            }
                            ?>

                            <li class="<?= $doc_list ?>">
                                <a href="#">
                                    <i class="metismenu-icon fas fa-folder"></i>
                                    รายการคำร้อง&nbsp;
                                    <span class="badge badge-pill badge-success"><?= count_darfile() ?></span>
                                    <span class="badge badge-pill badge-primary"><?= count_ctrlDocfile() ?></span>
                                    <span class="badge badge-pill badge-warning"><?= count_glfile() ?></span>
                                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                </a>

                                <ul>
                                    <li>
                                        <a class="navleft <?= $doc_list_iso ?>" href="<?= base_url("document/list_dar") ?>">
                                            <i class="metismenu-icon">
                                            </i><span class="badge badge-pill badge-success"><?= count_darfile() ?></span>&nbsp;&nbsp;รายการคำร้องเอกสาร ISO
                                        </a>
                                    </li>

                                    <li>
                                        <a class="navleft <?= $doc_list_ctrl ?>" href="<?= base_url("ctrldoc/list_docctrl") ?>">
                                            <i class="metismenu-icon">
                                            </i><span class="badge badge-pill badge-primary"><?= count_ctrlDocfile() ?></span>&nbsp;&nbsp;รายการคำร้องเอกสารควบคุม
                                        </a>
                                    </li>

                                    <li>
                                        <a class="navleft <?= $doc_list_gl ?>" href="<?= base_url("document/list_generel"); ?>">
                                            <i class="metismenu-icon">
                                            </i><span class="badge badge-pill badge-warning"><?= count_glfile() ?></span>&nbsp;&nbsp;รายการคำร้องเอกสารทั่วไป
                                        </a>
                                    </li>
                                </ul>
                            </li>


                            <!-- MENU -->
                            <?php
                            if ($this->uri->segment(2) == "add_dar") {
                                $add_doc = 'mm-active';
                                $add_iso = 'mm-active';
                                $add_gl = '';
                                $add_ctrldoc = '';
                                $add_ctrldoc_manual = '';
                            } else if ($this->uri->segment(2) == "add_gl_doc") {
                                $add_doc = 'mm-active';
                                $add_gl = 'mm-active';
                                $add_iso = '';
                                $add_ctrldoc = '';
                                $add_ctrldoc_manual = '';
                            } else if ($this->uri->segment(2) == "add_dar_manual") {
                                $add_doc = 'mm-active';
                                $add_iso = '';
                                $add_iso_manual = 'mm-active';
                                $add_gl = '';
                                $add_ctrldoc = '';
                                $add_ctrldoc_manual = '';
                            }else if($this->uri->segment(2) == "add_ctrldoc"){
                                $add_doc = 'mm-active';
                                $add_iso = '';
                                $add_iso_manual = '';
                                $add_gl = '';
                                $add_ctrldoc = 'mm-active';
                                $add_ctrldoc_manual = '';
                            }else if($this->uri->segment(2) == "add_ctrldoc_manual"){
                                $add_doc = 'mm-active';
                                $add_iso = '';
                                $add_iso_manual = '';
                                $add_gl = '';
                                $add_ctrldoc = '';
                                $add_ctrldoc_manual = 'mm-active';
                            } else {
                                $add_doc = '';
                                $add_gl = '';
                                $add_iso = '';
                                $add_ctrldoc = '';
                                $add_ctrldoc_manual = '';
                            }
                            ?>

                            <li class="<?= $add_doc ?>">
                                <a href="#">
                                    <i class="metismenu-icon fas fa-folder-plus"></i>
                                    เพิ่มคำร้อง
                                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                </a>

                                <ul>
                                    <li>
                                        <a class="navleft <?= $add_iso ?>" href="<?= base_url("document/add_dar"); ?>">
                                            <i class="metismenu-icon">
                                            </i>เพิ่มคำร้องเอกสาร ISO
                                        </a>
                                    </li>

                                    <li id="admin_section">
                                        <a class="navleft <?= $add_iso_manual ?>" href="<?= base_url("document/add_dar_manual"); ?>">
                                            <i class="metismenu-icon">
                                            </i>เพิ่มคำร้องเอกสาร ISO Manual
                                        </a>
                                    </li>

                                    <li>
                                        <a class="navleft <?= $add_ctrldoc?>" href="<?= base_url("ctrldoc/add_ctrldoc"); ?>">
                                            <i class="metismenu-icon">
                                            </i>เพิ่มคำร้องเอกสารควบคุม
                                        </a>
                                    </li>

                                    <li id="admin_section">
                                        <a class="navleft <?= $add_ctrldoc_manual ?>" href="<?= base_url("ctrldoc/add_ctrldoc_manual"); ?>">
                                            <i class="metismenu-icon">
                                            </i>เพิ่มคำร้องเอกสารควบคุม (Manual)
                                        </a>
                                    </li>

                                    <li>
                                        <a class="navleft <?= $add_gl ?>" href="<?= base_url('document/add_gl_doc') ?>">
                                            <i class="metismenu-icon">
                                            </i>เพิ่มคำร้องเอกสาร ทั่วไป
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!-- MENU -->

                            <?php
                            if ($this->uri->segment(2) == "") {
                                $isolist = 'mm-active';
                            } else if ($this->uri->segment(2) == "manage_dept") {
                                $foradmin = 'mm-active';
                                $manage_dept = 'mm-active';
                                $isolist = '';
                            } else if ($this->uri->segment(2) == "view_user") {
                                $foradmin = 'mm-active';
                                $view_user = 'mm-active';
                                $manage_dept = '';
                            } else if ($this->uri->segment(2) == "manage_dashboard") {
                                $manage_dash = 'mm-active';
                                $manage_dash_iso = 'mm-active';
                                $manage_dashli = 'mm-active';
                            } else if ($this->uri->segment(2) == "manage_dashboard_gl") {
                                $manage_dash_gl = 'mm-active';
                                $manage_dash = 'mm-active';
                            }
                            ?>


                            <li id="admin_section" class="app-sidebar__heading"></i>For Admin</li>
                            <li id="admin_section" class="<?= $foradmin ?>">
                                <a href="#">
                                    <i class="metismenu-icon fas fa-user-shield"></i>
                                    สำหรับผู้ดูแลระบบ
                                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                </a>

                                <ul>
                                    <li>
                                        <a class="navleft <?= $manage_dept ?>" href="<?= base_url('staff/manage_dept') ?>">
                                            <i class="metismenu-icon"></i>
                                            จัดการตู้เอกสารทั่วไป
                                        </a>
                                    </li>

                                    <li>
                                        <a class="navleft <?= $view_user ?>" href="<?= base_url('staff/view_user') ?>">
                                            <i class="metismenu-icon"></i>
                                            จัดการผู้ใช้งาน
                                        </a>
                                    </li>

                                    <!-- <li class="<?= $manage_dash ?>">
                                        <a class="navleft" href="#">
                                            <i class="metismenu-icon"></i>
                                            จัดการ DashBoard
                                        </a>

                                        <ul>
                                            <li>
                                                <a class="navleft <?= $manage_dash_iso ?>" href="<?= base_url('staff/manage_dashboard') ?>">
                                                    <i class="metismenu-icon"></i>
                                                    ปักหมุดเอกสาร ISO
                                                </a>
                                            </li>

                                            <li>
                                                <a class="navleft <?= $manage_dash_gl ?>" href="<?= base_url('staff/manage_dashboard_gl') ?>">
                                                    <i class="metismenu-icon"></i>
                                                    ปักหมุดเอกสาร ทั่วไป
                                                </a>
                                            </li>
                                        </ul>
                                    </li> -->

                                </ul>
                            </li>


                            <?php
                            if ($this->uri->segment(2) == "admin_iso_list") {
                                $isolistmain = 'mm-active';
                                $isolistli = 'mm-active';
                            } else {
                                $isolistmain = '';
                                $isolistli = '';
                            }
                            ?>


                            <li id="admin_section" class="<?= $isolistmain ?>">
                                <a href="#">
                                    <i class="metismenu-icon fas fa-folder"></i>
                                    รายการเอกสาร
                                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                </a>

                                <ul>
                                    <li>
                                        <a href="<?= base_url('staff') ?>" class="<?= $isolistli ?>">
                                            <i class="metismenu-icon"></i>
                                            ตู้เอกสาร ISO
                                        </a>
                                    </li>
                                </ul>

                            </li>





                            <?php
                            if ($this->uri->segment(2) == "darLogSheet") {
                                $reportMain = 'mm-active';
                                $darLogSheet = 'mm-active';
                                $ctrldocumentList = '';
                            } else if ($this->uri->segment(2) == "documentList") {
                                $reportMain = 'mm-active';
                                $documentList = 'mm-active';
                                $ctrldocumentList = '';
                            }else if($this->uri->segment(2) == "controlDocumentList"){
                                $reportMain = 'mm-active';
                                $documentList = '';
                                $ctrldocumentList = 'mm-active';
                            } else {
                                $reportMain = '';
                                $darLogSheet = '';
                            }
                            ?>

                            <li id="admin_section" class="<?= $reportMain ?>">
                                <a href="#">
                                    <i class="metismenu-icon fas fa-poll-h"></i>
                                    รายงาน
                                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                </a>

                                <ul>
                                    <li>
                                        <a href="<?= base_url('staff/documentList') ?>" class="<?= $documentList ?>">
                                            <i class="metismenu-icon"></i>
                                            ทะเบียนเอกสาร
                                        </a>
                                    </li>

                                    <li>
                                        <a href="<?= base_url('staff/controlDocumentList') ?>" class="<?= $ctrldocumentList ?>">
                                            <i class="metismenu-icon"></i>
                                            ทะเบียนเอกสารควบคุม
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>


                    </div>
                </div>
                <!-- Left Menu -->



            </div>

            <!-- Slide Nav bar left -->