<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

        <h1>

            STUDENT APPLICATION FORM

            <small>EDIT BY MARKETING</small>

        </h1>

        <ol class="breadcrumb">

            <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>


            <li class="#">STUDENT APPLICATION FORM</li>

            <li class="active">EDIT BY MARKETING</li>

        </ol>

    </section>

    <!-- Main content -->

    <section class="content">


        <div class="row">

            <div class="col-md-6">
                <form method="POST" action="<?= base_url('master/Student_application_form/update') ?>"
                    id="upload-create" enctype="multipart/form-data">

                    <input disabled disabled type="hidden" name="id" value="<?= $student_application_form['id'] ?>">


                    <div class="box">

                        <div class="box-header-material box-header-material-text">
                            <div class="row">
                                <div class="col-xs-10">
                                    PREVIEW APPLICATION FORM
                                </div>
                                <div class="col-xs-2">
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                                class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-body">

                            <div class="show_error"></div>
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="row">
                                        <div class="form-group col-md-6">

                                            <label for="form-registration_date">REGISTRATION DATE</label>

                                            <input disabled disabled autocomplete="off" type="text"
                                                class="form-control pull-right tgl" id="datepicker"
                                                name="dt[registration_date]"
                                                value="<?= $student_application_form['registration_date'] ?>">

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-application_number">APPLICATION NUMBER</label>

                                            <input disabled disabled type="text" class="form-control"
                                                id="form-application_number" placeholder="Insert Application Number"
                                                name="dt[application_number]"
                                                value="<?= $student_application_form['application_number'] ?>">

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-full_name">FULL NAME</label>

                                            <input disabled disabled type="text" class="form-control"
                                                id="form-full_name" placeholder="Insert Full Name" name="dt[full_name]"
                                                value="<?= $student_application_form['full_name'] ?>">

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-full_name">NICK NAME</label>

                                            <input disabled disabled type="text" class="form-control"
                                                id="form-full_name" placeholder="Insert Nick Name" name="dt[nick_name]"
                                                value="<?= $student_application_form['nick_name'] ?>">

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-place_of_birth">PLACE OF BIRTH</label>

                                            <input disabled disabled type="text" class="form-control"
                                                id="form-place_of_birth" placeholder="Insert Place Of Birth"
                                                name="dt[place_of_birth]"
                                                value="<?= $student_application_form['place_of_birth'] ?>">

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-gender">GENDER</label>

                                            <input disabled disabled type="text" class="form-control" id="form-gender"
                                                placeholder="Insert Gender" name="dt[gender]"
                                                value="<?= $student_application_form['gender'] ?>">

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-identity_card_no">IDENTITY CARD NO</label>

                                            <input disabled disabled type="text" class="form-control"
                                                id="form-identity_card_no" placeholder="Insert Identity Card No"
                                                name="dt[identity_card_no]"
                                                value="<?= $student_application_form['identity_card_no'] ?>">

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-date_of_birth">DATE OF BIRTH</label>
                                            <input disabled disabled autocomplete="off" type="text"
                                                class="form-control pull-right tgl" id="datepicker"
                                                name="dt[date_of_birth]"
                                                value="<?= $student_application_form['date_of_birth'] ?>">

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-weight">WEIGHT</label>

                                            <input disabled disabled type="text" class="form-control" id="form-weight"
                                                placeholder="Insert Weight" name="dt[weight]"
                                                value="<?= $student_application_form['weight'] ?>">

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-height">HEIGHT</label>

                                            <input disabled disabled type="text" class="form-control" id="form-height"
                                                placeholder="Insert Height" name="dt[height]"
                                                value="<?= $student_application_form['height'] ?>">

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-address">ADDRESS</label>

                                            <input disabled disabled type="text" class="form-control" id="form-address"
                                                placeholder="Insert Address" name="dt[address]"
                                                value="<?= $student_application_form['address'] ?>">

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-city">CITY</label>

                                            <input disabled disabled type="text" class="form-control" id="form-city"
                                                placeholder="Insert City" name="dt[city]"
                                                value="<?= $student_application_form['city'] ?>">

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-zip_code">ZIP CODE</label>

                                            <input disabled disabled type="text" class="form-control" id="form-zip_code"
                                                placeholder="Insert Zip Code" name="dt[zip_code]"
                                                value="<?= $student_application_form['zip_code'] ?>">

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-domicile_address">DOMICILE ADDRESS</label>

                                            <input disabled disabled type="text" class="form-control"
                                                id="form-domicile_address" placeholder="Insert Domicile Address"
                                                name="dt[domicile_address]"
                                                value="<?= $student_application_form['domicile_address'] ?>">

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-domicile_city">DOMICILE CITY</label>

                                            <input disabled disabled type="text" class="form-control"
                                                id="form-domicile_city" placeholder="Insert Domicile City"
                                                name="dt[domicile_city]"
                                                value="<?= $student_application_form['domicile_city'] ?>">

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-domicile_zip">DOMICILE ZIP</label>

                                            <input disabled disabled type="text" class="form-control"
                                                id="form-domicile_zip" placeholder="Insert Domicile Zip"
                                                name="dt[domicile_zip]"
                                                value="<?= $student_application_form['domicile_zip'] ?>">

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-home_telephone_number">HOME TELEPHONE NUMBER</label>

                                            <input disabled disabled type="text" class="form-control"
                                                id="form-home_telephone_number"
                                                placeholder="Insert Home Telephone Number"
                                                name="dt[home_telephone_number]"
                                                value="<?= $student_application_form['home_telephone_number'] ?>">

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-mobile_phone_number">MOBILE PHONE NUMBER</label>

                                            <input disabled disabled type="text" class="form-control"
                                                id="form-mobile_phone_number" placeholder="Insert Mobile Phone Number"
                                                name="dt[mobile_phone_number]"
                                                value="<?= $student_application_form['mobile_phone_number'] ?>">

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-marital_status">MARITAL STATUS</label>

                                            <input disabled disabled type="text" class="form-control"
                                                id="form-marital_status" placeholder="Insert Marital Status"
                                                name="dt[marital_status]"
                                                value="<?= $student_application_form['marital_status'] ?>">

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-email">EMAIL</label>

                                            <input disabled disabled type="text" class="form-control" id="form-email"
                                                placeholder="Insert Email" name="dt[email]"
                                                value="<?= $student_application_form['email'] ?>">

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-religion">RELIGION</label>

                                            <input disabled disabled type="text" class="form-control" id="form-religion"
                                                placeholder="Insert Religion" name="dt[religion]"
                                                value="<?= $student_application_form['religion'] ?>">

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-nationality">NATIONALITY</label>

                                            <input disabled disabled type="text" class="form-control"
                                                id="form-nationality" placeholder="Insert Nationality"
                                                name="dt[nationality]"
                                                value="<?= $student_application_form['nationality'] ?>">

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-nationality">T-SHIRT SIZE</label>

                                            <input disabled disabled type="text" class="form-control"
                                                id="form-nationality" placeholder="Insert T-Shirt Size"
                                                name="dt[t_shirt_size]"
                                                value="<?= $student_application_form['t_shirt_size'] ?>">

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-nationality">SHOES SIZE</label>

                                            <input disabled disabled type="text" class="form-control"
                                                id="form-nationality" placeholder="Insert Shoes Size"
                                                name="dt[shoes_size]"
                                                value="<?= $student_application_form['shoes_size'] ?>">

                                        </div>
                                        <div class="form-group col-md-12">

                                            <label for="form-nationality">CURRENT BATCH</label>

                                            <select disabled style='width:100%' name="dt[batch]"
                                                class="form-control select2" id="batch">
                                                <option value=''>SELECT BATCH</option>
                                                <?php

                        $curriculum = $this->mymodel->selectWithQuery("SELECT a.*, b.name as curriculum FROM batch a LEFT JOIN syllabus_curriculum b ON a.curriculum = b.code ORDER BY a.batch ASC");

                        foreach ($curriculum as $curriculum_record) {

                          $text = "";

                          if ($curriculum_record['code'] == $student_document['batch']) {

                            $text = "selected";
                          }



                          echo "<option value='" . $curriculum_record['code'] . "' " . $text . " >" . $curriculum_record['batch'] . ' - ' . $curriculum_record['curriculum'] . "</option>";
                        }

                        ?>

                                            </select>
                                        </div>

                                        <div class="form-group col-md-12">

                                            <label for="form-training_requirement">TRAINING REQUIREMENT COURSE</label>
                                            <br>

                                            <div id="training">

                                                <?php
                        $training_requirement = json_decode($student_application_form['training_requirement'], true);
                        // print_r($training_requirement);

                        $batch = $student_application_form['batch'];
                        $batch = $this->mymodel->selectDataOne('batch', array('id' => $batch));
                        $curriculum = $this->mymodel->selectDataOne('curriculum', array('id' => $batch['curriculum']));
                        $id_curriculum = $curriculum['id'];

                        $id_curriculum = $curriculum['id'];
                        $data = $this->mymodel->selectWithQuery("SELECT * FROM training_type WHERE curriculum='$id_curriculum' ORDER BY pos ASC");
                        foreach ($data as $key => $val) {

                          $text = "";
                          if (strpos($course['configuration'], $val['id']) !== false) {
                            $text = "checked";
                          }

                          $table_body = '';

                          $configuration = '"val":"' . $val['id'] . '"';
                          $course = $this->mymodel->selectWithQuery("SELECT * FROM course WHERE curriculum = '$id_curriculum' AND configuration LIKE '%$configuration%' ORDER BY position ASC");

                          $grand_total_duration = array();
                          foreach ($course as $key2 => $val2) {
                            $text = '';
                            if ($training_requirement[$val['id']]['item'][$val2['id']]['val'] == $val2['id']) {
                              $text = 'checked';
                            }

                            $course = $val2['id'];
                            $curriculum = $val2['curriculum'];
                            $type = $val['id'];
                            // $this->db->order_by("position ASC");
                            $mission = $this->mymodel->selectWithQuery("SELECT * FROM tpm_syllabus_all_course WHERE course = '$course' AND type_of_training = '$type' AND curriculum = '$curriculum' ORDER BY position ASC");

                            $total_duration = array();
                            foreach ($mission as $key3 => $val3) {
                              if (strpos($val3['duration'], ':') !== false) {
                                array_push($total_duration, $val3['duration']);
                              }
                            }
                            if ($training_requirement[$val['id']]['item'][$val2['id']]['val'] == $val2['id']) {
                              $total_duration = $this->template->sum_time($total_duration);
                              array_push($grand_total_duration, $total_duration);
                            } else {
                              $total_duration = '-';
                            }



                            $table_body .= '
                    <tr>   
                        <td><input disabled ' . $text . ' type="checkbox" name="dtt[' . $val['id'] . '][item][' . $val2['id'] . '][val]" value="' . $val2['id'] . '"></td>
                        <td class="text-left">' . $val2['course_code'] . ' - ' . $val2['course_name'] . '</td>
                        <td>' . $total_duration . '</td>
                       
                    </tr>
                    ';
                          }
                          // print_r($grand_total_duration);
                          $grand_total_duration = $this->template->sum_time($grand_total_duration);

                          $table_body .= '
                <tr>   
                    <th class="text-right" colspan="2">TOTAL</th>
                    <th>' . $grand_total_duration . '</th>
                   
                </tr>
                ';

                          $text = '';
                          if ($training_requirement[$val['id']]['val']['name'] == $val['id']) {
                            $text = 'checked';
                          }

                          $table = ' 
                <table class="table table-bordered">
                    <tr class="bg-orange">
                        <th style="width:10px;"><input disabled ' . $text . ' type="checkbox" name="dtt[' . $val['id'] . '][val][name]" value="' . $val['id'] . '"></th>
                        <th class="text-left"> ' . $val['training_type'] . '</th>
                        <th class="text-left" style="width:20px;">DURATION</th>
                    </tr>
                    ' . $table_body . '
                </table>';

                        ?>

                                                <?= $table; ?>

                                                <?php } ?>

                                                <?php

                        $data = $this->mymodel->selectWithQuery("SELECT * FROM type_of_training");
                        $no = 0;
                        foreach ($data as $key => $val) {
                          $text = "";
                          if (strpos($course['configuration'], $val['type_of_training']) !== false) {
                            $text = "checked";
                          }

                          $table_body = '';

                          $configuration = '"val":"' . $val['type_of_training'] . '"';
                          $course = $this->mymodel->selectWithQuery("SELECT * FROM course WHERE curriculum = '$id_curriculum' AND configuration LIKE '%$configuration%' ORDER BY position ASC");

                          $grand_total_duration_flight = array();
                          $grand_total_duration = array();
                          foreach ($course as $key2 => $val2) {
                            $text = '';
                            if ($training_requirement[$val['value']]['item'][$val2['id']]['val'] == $val2['id']) {
                              $text = 'checked';
                            }

                            $course = $val2['id'];
                            $curriculum = $val2['curriculum'];
                            $type = $val['type_of_training'];
                            // $this->db->order_by("position ASC");
                            $mission = $this->mymodel->selectWithQuery("SELECT * FROM tpm_syllabus_all_course WHERE course = '$course' AND type_of_training = '$type' AND curriculum = '$curriculum' ORDER BY position ASC");

                            $total_duration = array();
                            $total_dual = array();
                            $total_solo = array();
                            $total_pic = array();
                            $total_pic_solo = array();
                            $total = array();
                            foreach ($mission as $key3 => $val3) {
                              if (strpos($val3['duration'], ':') !== false) {
                                array_push($total_duration, $val3['duration']);
                              }

                              if (strpos($val3['duration_dual'], ':') !== false) {
                                array_push($total_dual, $val3['duration_dual']);
                              }
                              if (strpos($val3['duration_solo'], ':') !== false) {
                                array_push($total_solo, $val3['duration_solo']);
                              }
                              if (strpos($val3['duration_pic'], ':') !== false) {
                                array_push($total_pic, $val3['duration_pic']);
                              }
                              if (strpos($val3['duration_pic_solo'], ':') !== false) {
                                array_push($total_pic_solo, $val3['duration_pic_solo']);
                              }
                            }
                            if ($training_requirement[$val['value']]['item'][$val2['id']]['val'] == $val2['id']) {
                              $total_duration = $this->template->sum_time($total_duration);
                              array_push($grand_total_duration, $total_duration);
                            } else {
                              $total_duration = '-';
                            }


                            $total_dual = $this->template->sum_time($total_dual);
                            $total_solo = $this->template->sum_time($total_solo);
                            $total_pic = $this->template->sum_time($total_pic);
                            $total_pic_solo = $this->template->sum_time($total_pic_solo);

                            $total[0] = $total_dual;
                            $total[1] = $total_solo;
                            $total[2] = $total_pic;
                            $total[3] = $total_pic_solo;

                            if ($training_requirement[$val['value']]['item'][$val2['id']]['val'] == $val2['id']) {
                              $total =  $this->template->sum_time($total);
                              array_push($grand_total_duration_flight, $total);
                            } else {
                              $total =  '-';
                            }



                            if ($val['type_of_training'] == 'FLIGHT') {
                              $table_body .= '
                    <tr>   
                        <td><input disabled ' . $text . ' type="checkbox" name="dtt[' . $val['value'] . '][item][' . $val2['id'] . '][val]" value="' . $val2['id'] . '"></td>
                        <td class="text-left">' . $val2['course_code'] . ' - ' . $val2['course_name'] . '</td>
                        <td>' . $total . '</td>
                       
                    </tr>
                    ';
                            } else {
                              $table_body .= '
                    <tr>   
                        <td><input disabled ' . $text . ' type="checkbox" name="dtt[' . $val['value'] . '][item][' . $val2['id'] . '][val]" value="' . $val2['id'] . '"></td>
                        <td class="text-left">' . $val2['course_code'] . ' - ' . $val2['course_name'] . '</td>
                        <td>' . $total_duration . '</td>
                       
                    </tr>
                    ';
                            }
                          }


                          if ($val['type_of_training'] == 'FLIGHT') {
                            $grand_total_duration_flight = $this->template->sum_time($grand_total_duration_flight);
                            $table_body .= '
                        <tr>   
                            <th class="text-right" colspan="2">TOTAL</th>
                          
                            <th>' . $grand_total_duration_flight . '</th>
                        </tr>
                        ';
                          } else {
                            $grand_total_duration = $this->template->sum_time($grand_total_duration);
                            $table_body .= '
                    <tr>   
                        <th class="text-right" colspan="2">TOTAL</th>
                      
                        <th>' . $grand_total_duration . '</th>
                    </tr>
                    ';
                          }
                          $text = '';
                          if ($training_requirement[$val['value']]['val']['name'] == $val['value']) {
                            $text = 'checked';
                          }

                          $table = ' 
                <table class="table table-bordered">
                    <tr class="bg-orange">
                        <th style="width:10px;"><input disabled ' . $text . ' type="checkbox" name="dtt[' . $val['value'] . '][val][name]" value="' . $val['value'] . '"></th>
                        <th class="text-left"> ' . $val['value'] . '</th>
                        <th class="text-left" style="width:20px;">DURATION</th>
                    </tr>
                    ' . $table_body . '
                </table>';

                        ?>

                                                <?= $table; ?>

                                                <?php $no++;
                        } ?>


                                            </div>
                                        </div>



                                        <div class="form-group col-md-12">

                                            <label for="form-file">ATTACHMENT </label>

                                            <?php

                      if ($file['dir'] != "") { ?>
                                            <a href="<?= base_url($file['dir']) ?>" target="_blank"><i
                                                    class="fa fa-download"></i> <?= $file['name'] ?></a>


                                            <?php } ?>
                                            <input disabled disabled type="file" class="form-control" id="form-file"
                                                placeholder="Insert File" name="file">
                                        </div>


                                    </div>
                                </div>


                                <div class="col-md-6">

                                    <div class="row">

                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <div class="col-md-6">
                                    <div class="row">
                                        <a class="btn btn-primary btn-send float-add" data-placement="top"
                                            title="EDIT APPLICANT DATA"
                                            href="<?= base_url() ?>master/student_application_form/edit/<?= $student_application_form['id'] ?>"><i
                                                class="mdi mdi mdi-pencil"></i></a>



                                        <a href="" class="btn btn-danger float-2" href="#!" data-toggle="modal"
                                            data-target="#modal-delete-1" data-placement="top"
                                            title="DELETE APPLICANT DATA"><i class="mdi mdi-delete"></i></a>





                                    </div>


                                </div>

                            </div>

                            <!-- /.box-body -->

                        </div>

                        <!-- /.box -->



                        <!-- /.box -->

                    </div>
                </form>
            </div>

            <div class="col-md-6">

                <div class="box">

                    <div class="box-header-material box-header-material-text">
                        <div class="row">
                            <div class="col-xs-10">
                                ATTACHMENT LIST
                            </div>
                            <div class="col-xs-2">
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-body">


                        <div class="row">


                            <div class="col-md-12">

                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <!-- <label for="form-file">ATTACHMENT LIST</label> -->
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th class="text-left" rowspan="2">NO.
                                                    </th>
                                                    <th class="text-left" rowspan="2">ATTACHMENT NAME
                                                    </th>
                                                    <th colspan="2">VALID DATE
                                                    </th>
                                                    <th rowspan="2">REMARK
                                                    </th>
                                                    <th class="text-left" rowspan="2" style="width:30px;">

                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th style="width:110px;">START
                                                    </th>
                                                    <th style="width:110px;">UNTIL
                                                    </th>
                                                </tr>
                                                <?php
                        $attachment_list = $this->mymodel->selectWithQuery("SELECT * FROM student_file WHERE status = 'ENABLE' ORDER BY number ASC");
                        $att = json_decode($student_application_form['attachment'], true);
                        $i = 0;

                        $price = array();
                        // foreach ($attachment_list as $key => $row)
                        // {
                        //     $price[$key] = $row['number'];
                        // }
                        // array_multisort($price, SORT_ASC, $attachment_list);
                        // print_r($attachment_list);

                        foreach ($attachment_list as $key => $val) {
                          // echo $val['id'];
                          // echo $val['number'];
                          // $data = $this->mymodel->selectDataOne('student_file',array('id'=>$val['type']));
                        ?>
                                                <tr>
                                                    <td style="width:25px;">
                                                        <?= $i + 1 ?>
                                                    </td>
                                                    <td class="text-left">
                                                        <?= $val['student_file'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $this->template->date_indo(($att[$val['id']]['valid_date_start'])) ?>
                                                    </td>
                                                    <td>
                                                        <?= $this->template->date_indo(($att[$val['id']]['valid_date_until'])) ?>
                                                    </td>
                                                    <td class="text-left">
                                                        <?= $att[$val['id']]['description'] ?>
                                                    </td>
                                                    <td class="text-left">
                                                        <!-- <a href="#!" class="btn btn-primary btn-xs mb-5 btn-block">EDIT</a> -->

                                                        <!-- <a href="#!" class="btn btn-warning btn-xs btn-delete"  href="#!" data-toggle="modal" data-target="#modal-upload-<?= $i ?>"><i class="mdi mdi-pencil"></i></a> -->
                                                        <!-- <a href="#!" class="btn btn-danger btn-xs btn-delete"  href="#!" data-toggle="modal" data-target="#modal-delete-<?= $i ?>"><i class="mdi mdi-delete"></i></a> -->
                                                        <?php
                              if ($att[$val['id']]['file']) { ?>
                                                        <a href="<?= base_url() ?>webfile/student_file/<?= $att[$val['id']]['file'] ?>"
                                                            target="_blank" class="btn btn-delete btn-xs btn-info"><i
                                                                class="mdi mdi-eye"></i></a>
                                                        <?php } ?>


                                                        <div class="modal modal-success fade"
                                                            id="modal-upload-<?= $i ?>">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span
                                                                                aria-hidden="true">&times;</span></button>
                                                                        <h4 class="modal-title">UPDATE ATTACHMENT FILE
                                                                        </h4>
                                                                    </div>
                                                                    <div class="modal-body"
                                                                        style="color:#fff!important;">
                                                                        <form
                                                                            action="<?= base_url() ?>master/student_application_form/update_file/<?= $student_application_form['id'] ?>/<?= $val['id'] ?>"
                                                                            method="POST" enctype="multipart/form-data">
                                                                            <div class="form-group">
                                                                                <input type="hidden" name="type"
                                                                                    value="student">
                                                                                <label>Attachment Type</label>

                                                                                <input autocomplete="off" readonly
                                                                                    type="text" class="form-control"
                                                                                    name="dttt[id]"
                                                                                    value="<?= $val['student_file'] ?>">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <input autocomplete="off" required
                                                                                    type="hidden" class="form-control"
                                                                                    name="dttt[id]"
                                                                                    value="<?= $val['id'] ?>">

                                                                                <label>Valid Date Start</label>
                                                                                <input autocomplete="off" required
                                                                                    type="text" class="form-control tgl"
                                                                                    name="dttt[valid_date_start]"
                                                                                    value="<?= $att[$val['id']]['valid_date_start'] ?>">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>Valid Date Until</label>
                                                                                <input autocomplete="off" required
                                                                                    type="text" class="form-control tgl"
                                                                                    name="dttt[valid_date_until]"
                                                                                    value="<?= $att[$val['id']]['valid_date_until'] ?>">
                                                                            </div>
                                                                            <!-- <div class="form-group">
                <label>Attachment Number</label>
                <input autocomplete="off" required type="text" class="form-control" name="dttt[number]" value="<?= $val['number'] ?>">
                </div> -->
                                                                            <div class="form-group">
                                                                                <label>Description</label>
                                                                                <input autocomplete="off" required
                                                                                    type="text" class="form-control"
                                                                                    name="dttt[description]"
                                                                                    value="<?= $att[$val['id']]['description'] ?>">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>Attachment File</label> *empty if
                                                                                not updated.
                                                                                <input type="file" class="form-control"
                                                                                    name="file">
                                                                            </div>

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                            class="btn btn-outline pull-left"
                                                                            data-dismiss="modal">Close</button>
                                                                        <button type="submit"
                                                                            class="btn btn-outline">Upload File</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                                <!-- /.modal-content -->
                                                            </div>
                                                            <!-- /.modal-dialog -->
                                                        </div>


                                                        <div class="modal modal-danger fade"
                                                            id="modal-delete-<?= $i ?>">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span
                                                                                aria-hidden="true">&times;</span></button>
                                                                        <h4 class="modal-title">DELETE ATTACHMENT</h4>
                                                                    </div>
                                                                    <div class="modal-body"
                                                                        style="color:#fff!important;">
                                                                        <form action="">
                                                                            <span style="font-weight:100">Are you sure
                                                                                you want to delete this file?</span>
                                                                        </form>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                            class="btn btn-outline pull-left"
                                                                            data-dismiss="modal">Close</button>
                                                                        <a type="button" class="btn btn-outline"
                                                                            href="<?= base_url() ?>master/student_application_form/delete_file/<?= $student_application_form['id'] ?>/<?= $val['id'] ?>?type=student">Delete
                                                                            Now</a>
                                                                    </div>
                                                                </div>
                                                                <!-- /.modal-content -->
                                                            </div>
                                                            <!-- /.modal-dialog -->
                                                        </div>



                                                    </td>
                                                </tr>
                                                </tr>
                                                <?php
                          $i++;
                        } ?>
                                            </table>
                                        </div>

                                        <!-- <a class="btn btn-success float-4" href="#!" data-toggle="modal" data-target="#modal-upload"  data-placement="top" title="ADD NEW ATTACHMENT" ><i class="mdi mdi-attachment"></i></a> -->

                                        <!-- <a class="btn btn-success float-upload" href="#!" data-toggle="modal" data-target="#modal-upload-log"  data-placement="top" title="ADD NEW PAYMENT" ><i class="mdi mdi-credit-card"></i></a> -->


                                        <div class="modal modal-success fade" id="modal-upload-log">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title">ADD PAYMENT HISTORY</h4>
                                                    </div>
                                                    <div class="modal-body" style="color:#fff!important;">
                                                        <form
                                                            action="<?= base_url() ?>master/student_application_form/upload_file/<?= $student_application_form['id'] ?>"
                                                            method="POST" enctype="multipart/form-data">
                                                            <div class="form-group">
                                                                <label>Payment Status</label>
                                                                <select required style="width:100%;" class="select2"
                                                                    name="dttt[type]">
                                                                    <option value="">SELECT STATUS
                                                                    </option>
                                                                    <?php
                                  $attachment = $this->mymodel->selectWithQuery("SELECT * FROM status_history");
                                  foreach ($attachment as $key2 => $val2) { ?>
                                                                    <option value="<?= $val2['id'] ?>">
                                                                        <?= $val2['status_history'] ?>
                                                                    </option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Date</label>
                                                                <input autocomplete="off" required required type="text"
                                                                    class="form-control tgl" name="dttt[date]">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Due Date</label>
                                                                <input autocomplete="off" required required type="text"
                                                                    class="form-control tgl" name="dttt[due_date]">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Nominal Inv</label>
                                                                <input autocomplete="off" required required type="text"
                                                                    class="form-control" name="dttt[nominal_inv]">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Nominal Paid</label>
                                                                <input autocomplete="off" required required type="text"
                                                                    class="form-control" name="dttt[nominal_paid]">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Description</label>
                                                                <input autocomplete="off" required required type="text"
                                                                    class="form-control" name="dttt[description]">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Attachment File</label>
                                                                <input type="file" class="form-control" name="file">
                                                            </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline pull-left"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-outline">Upload
                                                            File</button>
                                                        </form>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>


                                        <div class="modal modal-success fade" id="modal-upload">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title">UPLOAD ATTACHMENT FILE</h4>
                                                    </div>
                                                    <div class="modal-body" style="color:#fff!important;">
                                                        <form
                                                            action="<?= base_url() ?>master/student_application_form/upload_file/<?= $student_application_form['id'] ?>"
                                                            method="POST" enctype="multipart/form-data">
                                                            <div class="form-group">
                                                                <input type="hidden" name="type" value="student">
                                                                <label>Attachment Type</label>
                                                                <select required style="width:100%;" class="select2"
                                                                    name="dttt[type]">
                                                                    <option value="">SELECT ATTACHMENT
                                                                    </option>
                                                                    <?php foreach ($attachment_student as $key2 => $val2) { ?>
                                                                    <option value="<?= $val2['id'] ?>">
                                                                        <?= $val2['student_file'] ?>
                                                                    </option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Valid Date Start</label>
                                                                <input autocomplete="off" required required type="text"
                                                                    class="form-control tgl"
                                                                    name="dttt[valid_date_start]">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Valid Date Until</label>
                                                                <input autocomplete="off" required required type="text"
                                                                    class="form-control tgl"
                                                                    name="dttt[valid_date_until]">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Attachment Number</label>
                                                                <input autocomplete="off" required type="text"
                                                                    class="form-control" name="dttt[number]">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Description</label>
                                                                <input autocomplete="off" required required type="text"
                                                                    class="form-control" name="dttt[description]">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Attachment File</label>
                                                                <input type="file" class="form-control" name="file">
                                                            </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline pull-left"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-outline">Upload
                                                            File</button>
                                                        </form>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- /.box-body -->


                    </div>


                    <!-- /.box -->



                    <!-- /.box -->

                </div>

            </div>
        </div>
</div>
</div>
</div>



<!-- /.row -->








</section>


<!-- /.content -->

</div>


<div class="modal modal-danger fade" id="modal-delete-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">DELETE STUDENT APPLICATION FORM</h4>
            </div>
            <div class="modal-body" style="color:#fff!important;">
                <form
                    action="<?= base_url() ?>master/student_application_form/delete/<?= $student_application_form['id'] ?>">
                    <span style="font-weight:100">Are you sure you want to delete this student application form?</span>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline">Delete Now</button>
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- /.content-wrapper -->

<script type="text/javascript">
$("#upload-create").submit(function() {

    var form = $(this);

    var mydata = new FormData(this);

    $.ajax({

        type: "POST",

        url: form.attr("action"),

        data: mydata,

        cache: false,

        contentType: false,

        processData: false,

        beforeSend: function() {

            $(".btn-send").addClass("disabled").html("<i class='fa fa-spinner fa-spin'></i>").attr(
                'disabled', true);

            form.find(".show_error").slideUp().html("");

        },

        success: function(response, textStatus, xhr) {

            // alert(mydata);

            var str = response;

            if (str.indexOf("success") != -1) {

                form.find(".show_error").hide().html(response).slideDown("fast");

                setTimeout(function() {

                    window.location.href =
                        "<?= base_url('master/student_application_form') ?>";

                }, 1000);

                $(".btn-send").removeClass("disabled").html('<i class="mdi mdi-content-save"></i>')
                    .attr('disabled', false);





            } else {

                form.find(".show_error").hide().html(response).slideDown("fast");

                $(".btn-send").removeClass("disabled").html('<i class="mdi mdi-content-save"></i>')
                    .attr('disabled', false);



            }

        },

        error: function(xhr, textStatus, errorThrown) {

            console.log(xhr);

            $(".btn-send").removeClass("disabled").html('<i class="mdi mdi-content-save"></i>')
                .attr('disabled', false);

            form.find(".show_error").hide().html(xhr).slideDown("fast");



        }

    });

    return false;



});
</script>