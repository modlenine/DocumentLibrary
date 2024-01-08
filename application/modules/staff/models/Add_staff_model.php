<?php
class Add_staff_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }

    public function save_folder()
    {
        $dept_id = $this->input->post("hide_dept_id");
        $ar_folder = array(
            "gl_folder_name" => $this->input->post("gl_folder_name"),
            "gl_folder_dept_id" => $this->input->post("hide_dept_id"),
            "gl_folder_dept_code" => $this->input->post("gl_folder_dept_code"),
            "gl_folder_number" => $this->input->post("gl_folder_number")
        );

        $result = $this->db->insert("gl_folder", $ar_folder);

        if (!$result) {
            echo "<script>";
            echo "alert('บันทึกข้อมูลไม่สำเร็จ')";
            echo "window.history.back(-1)";
            echo "</script>";
        } else {
            echo "<script>";
            echo "alert('บันทึกข้อมูลสำเร็จ')";
            echo "</script>";
            header("refresh:0; url=" . base_url('staff/select_dept/') . $dept_id);
        }
    }


    public function dept_update()
    {
        $ar_dept_update = array(
            "gl_dept_code" => $this->input->post("edit_gl_dept_code"),
            "gl_dept_name" => $this->input->post("edit_gl_dept_name")
        );
        $result = $this->db->where("gl_dept_id", $this->input->post("edit_gl_dept_id"));
        $result = $this->db->update("gl_department", $ar_dept_update);
        if (!$result) {
            echo "<script>";
            echo "alert('แก้ไขข้อมูลไม่สำเร็จ')";
            echo "</script>";
            header("refresh:0; url=" . base_url("staff/manage_dept"));
        } else {
            echo "<script>";
            echo "alert('แก้ไขข้อมูลสำเร็จ')";
            echo "</script>";
            header("refresh:0; url=" . base_url("staff/manage_dept"));
        }
    }


    public function save_edit_group()
    {
        if (isset($_POST['btnSaveEdit_group'])) {
            $ar_update_group = array(
                "dc_user_group" => $this->input->post("edit_group_permis")
            );
            $result = $this->db->where("dc_user_id", $this->input->post("get_gl_user_id"));
            $result = $this->db->update("dc_user", $ar_update_group);

            if (!$result) {
                echo "<script>";
                echo "alert('แก้ไขข้อมูลไม่สำเร็จ')";
                echo "</script>";
                header("refresh:0; url=" . base_url("staff/view_user"));
            } else {
                echo "<script>";
                echo "alert('แก้ไขข้อมูลสำเร็จ')";
                echo "</script>";
                header("refresh:0; url=" . base_url("staff/view_user"));
            }
        }
    }


    public function save_edit_user()
    {
        if (isset($_POST['btnSaveUser_edit'])) {
            $ar_edit_user = array(
                "dc_user_Fname" => $this->input->post("get_fname_edit"),
                "dc_user_Lname" => $this->input->post("get_lname_edit"),
                "dc_user_Dept" => $this->input->post("get_deptname_edit"),
                "dc_user_DeptCode" => $this->input->post("get_deptcode_edit"),
                "dc_user_ecode" => $this->input->post("get_ecode_edit"),
                "dc_user_memberemail" => $this->input->post("get_email_edit")
            );
            $result = $this->db->where("dc_user_id", $this->input->post("get_userid_edit"));
            $result = $this->db->update("dc_user", $ar_edit_user);

            if (!$result) {
                echo "<script>";
                echo "alert('แก้ไขข้อมูลไม่สำเร็จ')";
                echo "</script>";
                header("refresh:0; url=" . base_url("staff/view_user"));
            } else {
                echo "<script>";
                echo "alert('แก้ไขข้อมูลสำเร็จ')";
                echo "</script>";
                header("refresh:0; url=" . base_url("staff/view_user"));
            }
        }
    }

    public function delete_user($userid)
    {
        $result = $this->db->where("dc_user_id",$userid);
        $result = $this->db->delete("dc_user");
        if (!$result) {
            echo "<script>";
            echo "alert('ลบข้อมูลไม่สำเร็จ')";
            echo "</script>";
            header("refresh:0; url=" . base_url("staff/view_user"));
        } else {
            echo "<script>";
            echo "alert('ลบข้อมูลสำเร็จ')";
            echo "</script>";
            header("refresh:0; url=" . base_url("staff/view_user"));
        }
    }














}
