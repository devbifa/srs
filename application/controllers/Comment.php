<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Comment extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function edit($id)
    {
        $data['page'] = 'Gallery';
        $data['tbl_comment'] = $this->mymodel->selectDataone('tbl_comment', array('id' => $id));
        $this->template->load('template/template', 'comment/edit', $data);
    }

    public function update()
    {
        $id = $_POST['id'];
        $dt = $_POST['dt'];
        $dt['updated_at'] = date("Y-m-d H:i:s");
        $this->mymodel->updateData('tbl_comment', $dt, array('id' => $id));


        $gallery = $_POST['gallery_id'];
        header('Location: ' . base_url('gallery/commentview/' . $gallery));
    }


    public function delete($id, $galleryid, $view)
    {
        $this->mymodel->deleteData('tbl_comment',  array('id' => $id));

        if ($galleryid) {
            header('Location: ' . base_url('gallery/' . $view . '/' . $galleryid));
        } else {
            header('Location: ' . base_url('gallery/' . $view . '/' . $galleryid));
        }
    }

    public function fetch($id)
    {
        $output = '';
        $search = $_GET['title'];

        $tbl_comment = $this->mymodel->selectWithQuery('SELECT * FROM tbl_comment WHERE imagegroup_id = ' . $id . ' ORDER BY created_at DESC LIMIT ' . $this->input->post('limit') . ' OFFSET ' . $this->input->post('start'));

        if ($tbl_comment) {
            foreach ($tbl_comment as $row) {

                $name = '';
                $src = '';

                $verif = '';

                if ($row['id_raider']) {
                    $tbl_raider = $this->mymodel->selectDataone('tbl_raider', array('id' => $row['id_raider']));
                    $file = $this->mymodel->selectDataone('file', array('table_id' => $row['id_raider'], 'table' => 'tbl_raider'));

                    $url = $file['url'];
                    if (!$url) {
                        $url = 'https://m.nsoproject.com/webfiles/raider/raider_default.png';
                    }

                    $name = $tbl_raider['name'];
                    $src = $url;
                    $verif = $tbl_raider['verificacion'];
                } elseif ($row['id_user']) {
                    $user = $this->mymodel->selectDataone('user', array('id' => $row['id_user']));
                    $file = $this->mymodel->selectDataone('file', array('table_id' => $row['id_user'], 'table' => 'user'));

                    $url = $file['url'];
                    if (!$url) {
                        $url = 'https://admin.nsoproject.com/webfiles/users/6950c16c9bcc6995f376b297f163175942635.jpg';
                    }

                    $name = $user['name'];
                    $src = $url;
                    $verif = '';
                }

                $admin = '';
                if ($row['id_user']) {
                    $admin = "- <i>Admin</i>";
                }

                $createdandupdate = '';

                if ($row['updated_at']) {
                    $createdandupdate = "Diubah pada : " . date('d M Y H:i:s', strtotime($row['updated_at']));
                } else {
                    $createdandupdate = "Dibuat pada : " . date('d M Y H:i:s', strtotime($row['created_at']));
                }

                $check = '';
                if ($verif == 'ENABLE') {
                    $check = '<img src="' . base_url('assets/flaticon/verified.png') . '" width="15px" height="15px">';
                }

                $action = '';
                if ($row['id_raider'] == $this->session->userdata('id')) {
                    $action = '<div class="row" style="color:#737373;font-size: 12px; margin-bottom: 5px;">
                    <div class="col-xs-1">
                        <a href="' . base_url('comment/edit/') . $row['id'] . '">
                            Edit
                        </a>
                    </div>
                    <div class="col-xs-1">
                        <a href="' . base_url('comment/delete/') . $row['id'] . '/' . $row['imagegroup_id'] . '/commentview">
                            Hapus
                        </a>
                    </div>
                </div>';
                }

                $output .= '<div class="col-xs-2">
                <img src="' . $src . '" width="50px" height="50px" style="border-radius: 50%">
                </div>
                <div class="col-xs-10">
                <div class="comment">
                <b>' . $name . '</b> ' . $check . $admin . '<br>
                <p>' . $row['comment'] . '</p>
                <p style="color:#737373;font-size: 12px;">
                ' . $createdandupdate . '
                </p>
                </div>
                ' . $action . '
                </div>';
            }
        }
        echo $output;
    }
}
