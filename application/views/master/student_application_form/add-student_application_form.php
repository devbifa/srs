<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

        <h1>

            STUDENT APPLICATION FORM

            <small>CREATE BY MARKETING</small>

        </h1>

        <ol class="breadcrumb">

            <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>


            <li class="#">STUDENT APPLICATION FORM</li>

            <li class="active">CREATE BY MARKETING</li>

        </ol>

    </section>

    <!-- Main content -->

    <section class="content">

        <form method="POST" action="<?= base_url('master/student_application_form/store') ?>" id="upload-create"
            enctype="multipart/form-data">



            <div class="row">

                <div class="col-md-6">

                    <div class="box">

                        <div class="box-header-material">

                            <h3 class="box-header-material-text">CREATE APPLICANT DATA
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i></button>
                                </div>
                        </div>
                        <div class="box-body">

                            <div class="show_error"></div>
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="row">
                                        <div class="form-group col-md-6">

                                            <label for="form-registration_date">REGISTRATION DATE</label>

                                            <input placeholder="Insert Registration Date" autocomplete="off" type="text"
                                                class="form-control pull-right tgl" id="datepicker"
                                                name="dt[registration_date]"
                                                value="<?= $student_application_form['registration_date'] ?>">

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-application_number">APPLICATION NUMBER</label>

                                            <input placeholder="Generate by system" disabled type="text"
                                                class="form-control" id="form-application_number"
                                                placeholder="Insert Application Number" name="dt[application_number]"
                                                value="<?= $student_application_form['application_number'] ?>">

                                        </div>
                                        <div class="form-group col-md-12">
                                            <h3 style="font-size:17px;font-weight:700">A. PERSONAL PARTICULARS</h3>
                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-full_name">FULL NAME</label>

                                            <input type="text" class="form-control" id="form-full_name"
                                                placeholder="Insert Full Name" name="dt[full_name]"
                                                value="<?= $student_application_form['full_name'] ?>">

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-full_name">NICK NAME</label>

                                            <input type="text" class="form-control" id="form-full_name"
                                                placeholder="Insert Nick Name" name="dt[nick_name]"
                                                value="<?= $student_application_form['nick_name'] ?>">

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-place_of_birth">PLACE OF BIRTH</label>

                                            <input type="text" class="form-control" id="form-place_of_birth"
                                                placeholder="Insert Place Of Birth" name="dt[place_of_birth]"
                                                value="<?= $student_application_form['place_of_birth'] ?>">

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-gender">GENDER</label>

                                            <input type="text" class="form-control" id="form-gender"
                                                placeholder="Insert Gender" name="dt[gender]"
                                                value="<?= $student_application_form['gender'] ?>">

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-identity_card_no">IDENTITY CARD NO</label>

                                            <input type="text" class="form-control" id="form-identity_card_no"
                                                placeholder="Insert Identity Card No" name="dt[identity_card_no]"
                                                value="<?= $student_application_form['identity_card_no'] ?>">

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-date_of_birth">DATE OF BIRTH</label>
                                            <input autocomplete="off" type="text" class="form-control pull-right tgl"
                                                id="datepicker" name="dt[date_of_birth]"
                                                value="<?= $student_application_form['date_of_birth'] ?>">

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-weight">WEIGHT</label>

                                            <input type="text" class="form-control" id="form-weight"
                                                placeholder="Insert Weight" name="dt[weight]"
                                                value="<?= $student_application_form['weight'] ?>">

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-height">HEIGHT</label>

                                            <input type="text" class="form-control" id="form-height"
                                                placeholder="Insert Height" name="dt[height]"
                                                value="<?= $student_application_form['height'] ?>">

                                        </div>
                                        <div class="form-group col-md-12">

                                            <label for="form-address">ADDRESS</label>

                                            <input type="text" class="form-control" id="form-address"
                                                placeholder="Insert Address" name="dt[address]"
                                                value="<?= $student_application_form['address'] ?>">

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-city">CITY</label>

                                            <input type="text" class="form-control" id="form-city"
                                                placeholder="Insert City" name="dt[city]"
                                                value="<?= $student_application_form['city'] ?>">

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-zip_code">ZIP CODE</label>

                                            <input type="text" class="form-control" id="form-zip_code"
                                                placeholder="Insert Zip Code" name="dt[zip_code]"
                                                value="<?= $student_application_form['zip_code'] ?>">

                                        </div>
                                        <div class="form-group col-md-12">

                                            <label for="form-domicile_address">DOMICILE ADDRESS</label>

                                            <input type="text" class="form-control" id="form-domicile_address"
                                                placeholder="Insert Domicile Address" name="dt[domicile_address]"
                                                value="<?= $student_application_form['domicile_address'] ?>">

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-domicile_city">DOMICILE CITY</label>

                                            <input type="text" class="form-control" id="form-domicile_city"
                                                placeholder="Insert Domicile City" name="dt[domicile_city]"
                                                value="<?= $student_application_form['domicile_city'] ?>">

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-domicile_zip">DOMICILE ZIP</label>

                                            <input type="text" class="form-control" id="form-domicile_zip"
                                                placeholder="Insert Domicile Zip" name="dt[domicile_zip]"
                                                value="<?= $student_application_form['domicile_zip'] ?>">

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-home_telephone_number">HOME TELEPHONE NUMBER</label>

                                            <input type="text" class="form-control" id="form-home_telephone_number"
                                                placeholder="Insert Home Telephone Number"
                                                name="dt[home_telephone_number]"
                                                value="<?= $student_application_form['home_telephone_number'] ?>">

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-mobile_phone_number">MOBILE PHONE NUMBER</label>

                                            <input type="text" class="form-control" id="form-mobile_phone_number"
                                                placeholder="Insert Mobile Phone Number" name="dt[mobile_phone_number]"
                                                value="<?= $student_application_form['mobile_phone_number'] ?>">

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-marital_status">MARITAL STATUS</label>

                                            <input type="text" class="form-control" id="form-marital_status"
                                                placeholder="Insert Marital Status" name="dt[marital_status]"
                                                value="<?= $student_application_form['marital_status'] ?>">

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-email">EMAIL</label>

                                            <input type="text" class="form-control" id="form-email"
                                                placeholder="Insert Email" name="dt[email]"
                                                value="<?= $student_application_form['email'] ?>">

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-religion">RELIGION</label>

                                            <input type="text" class="form-control" id="form-religion"
                                                placeholder="Insert Religion" name="dt[religion]"
                                                value="<?= $student_application_form['religion'] ?>">

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-nationality">NATIONALITY</label>

                                            <input type="text" class="form-control" id="form-nationality"
                                                placeholder="Insert Nationality" name="dt[nationality]"
                                                value="<?= $student_application_form['nationality'] ?>">

                                        </div>
                                        <div class="form-group col-md-12">
                                            <h3 style="font-size:17px;font-weight:700">B. FAMILY PARTICULARS</h3>
                                        </div>
                                        <?php $family = json_decode($student_application_form['family'], true); ?>
                                        <div class="form-group col-md-6">
                                            <label for="form-nationality">FATHER'S NAME</label>
                                            <input type="text" class="form-control" id="form-nationality"
                                                name="family[father_name]" value="<?= $family['father_name'] ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="form-nationality">PLACE & DATE OF BIRTH</label>
                                            <input type="text" class="form-control" id="form-nationality"
                                                name="family[father_place_of_birth]"
                                                value="<?= $family['father_place_of_birth'] ?>">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="form-nationality">FATHER'S ADDRESS</label>
                                            <input type="text" class="form-control" id="form-nationality"
                                                name="family[father_address]" value="<?= $family['father_address'] ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="form-nationality">CALL PHONE NUMBER</label>
                                            <input type="text" class="form-control" id="form-nationality"
                                                name="family[father_phone_number]"
                                                value="<?= $family['father_phone_number'] ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="form-nationality">FATHER'S OCCUPATION</label>
                                            <input type="text" class="form-control" id="form-nationality"
                                                name="family[father_occupation]"
                                                value="<?= $family['father_occupation'] ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="form-nationality">RESIDENCE PHONE NUMBER</label>
                                            <input type="text" class="form-control" id="form-nationality"
                                                name="family[father_residence_phone_number]"
                                                value="<?= $family['father_residence_phone_number'] ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="form-nationality">FATHER'S INCOME</label>
                                            <input type="text" class="form-control" id="form-nationality"
                                                name="family[father_income]" value="<?= $family['father_income'] ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="form-nationality">MOTHER'S NAME</label>
                                            <input type="text" class="form-control" id="form-nationality"
                                                name="family[mother_name]" value="<?= $family['mother_name'] ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="form-nationality">PLACE & DATE OF BIRTH</label>
                                            <input type="text" class="form-control" id="form-nationality"
                                                name="family[mother_place_of_birth]"
                                                value="<?= $family['mother_place_of_birth'] ?>">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="form-nationality">MOTHER'S ADDRESS</label>
                                            <input type="text" class="form-control" id="form-nationality"
                                                name="family[mother_address]" value="<?= $family['mother_address'] ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="form-nationality">CALL PHONE NUMBER</label>
                                            <input type="text" class="form-control" id="form-nationality"
                                                name="family[mother_phone_number]"
                                                value="<?= $family['mother_phone_number'] ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="form-nationality">MOTHER'S OCCUPATION</label>
                                            <input type="text" class="form-control" id="form-nationality"
                                                name="family[mother_occupation]"
                                                value="<?= $family['mother_occupation'] ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="form-nationality">RESIDENCE PHONE NUMBER</label>
                                            <input type="text" class="form-control" id="form-nationality"
                                                name="family[mother_residence_phone_number]"
                                                value="<?= $family['mother_residence_phone_number'] ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="form-nationality">MOTHER'S INCOME</label>
                                            <input type="text" class="form-control" id="form-nationality"
                                                name="family[mother_income]" value="<?= $family['mother_income'] ?>">
                                        </div>
                                        <?php
                    $list_family = json_decode($student_application_form['list_family'], true);
                    ?>
                                        <div class="form-group col-md-12">
                                            <label for="form-nationality">LIST OF NUCLEAR FAMILY (FILL IF ALREADY
                                                MARRIEAGE)</label>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <tr class="bg-success">
                                                        <th>NO</th>
                                                        <th>NAME</th>
                                                        <th>GENTER</th>
                                                        <th>DATE OF BIRTH</th>
                                                        <th>RELATIONSHIP</th>
                                                        <th>OCCUPATION</th>
                                                    </tr>
                                                    <?php for ($i = 0; $i < 5; $i++) { ?>
                                                    <tr>
                                                        <td><?= $i + 1 ?></td>
                                                        <td><input type="text" class="form-control"
                                                                name="list_family[<?= $i ?>][name]"
                                                                value="<?= $list_family[$i]['name'] ?>"></td>
                                                        <td><input type="text" class="form-control"
                                                                name="list_family[<?= $i ?>][gender]"
                                                                value="<?= $list_family[$i]['gender'] ?>"></td>
                                                        <td><input type="text" class="form-control"
                                                                name="list_family[<?= $i ?>][date_of_birth]"
                                                                value="<?= $list_family[$i]['date_of_birth'] ?>"></td>
                                                        <td><input type="text" class="form-control"
                                                                name="list_family[<?= $i ?>][relationship]"
                                                                value="<?= $list_family[$i]['relationship'] ?>"></td>
                                                        <td><input type="text" class="form-control"
                                                                name="list_family[<?= $i ?>][occupation]"
                                                                value="<?= $list_family[$i]['occupation'] ?>"></td>
                                                    </tr>
                                                    <?php } ?>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="form-nationality">IN EMERGENCY CASE WHO CAN BE CONTACTED, PREFER
                                                NON FAMILY MEMBERS</label>
                                            <label for="form-nationality">NAME</label>
                                            <input type="text" class="form-control" id="form-nationality"
                                                name="family[e_name]" value="<?= $family['e_name'] ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="form-nationality">RELATIONSHIP</label>
                                            <input type="text" class="form-control" id="form-nationality"
                                                name="family[e_relationship]" value="<?= $family['e_relationship'] ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="form-nationality">PHONE NUMBER</label>
                                            <input type="text" class="form-control" id="form-nationality"
                                                name="family[e_phone_number]" value="<?= $family['e_phone_number'] ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="form-nationality">ADDRESS</label>
                                            <input type="text" class="form-control" id="form-nationality"
                                                name="family[e_address]" value="<?= $family['e_address'] ?>">
                                        </div>

                                        <div class="form-group col-md-12">
                                            <h3 style="font-size:17px;font-weight:700">C. QUALIFICATION</h3>
                                        </div>


                                        <?php
                    $qualification = json_decode($student_application_form['qualification'], true);
                    ?>
                                        <div class="form-group col-md-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <tr class="bg-success">
                                                        <th>NO</th>
                                                        <th>EDUTYPE</th>
                                                        <th>SCHOOL/UNIVERSITY</th>
                                                        <th>GRADUATION YEAR</th>
                                                        <th>MAJOR</th>
                                                    </tr>
                                                    <?php for ($i = 0; $i < 5; $i++) { ?>
                                                    <tr>
                                                        <td><?= $i + 1 ?></td>
                                                        <td><input type="text" class="form-control"
                                                                name="qualification[<?= $i ?>][edutype]"
                                                                value="<?= $qualification[$i]['edutype'] ?>"></td>
                                                        <td><input type="text" class="form-control"
                                                                name="qualification[<?= $i ?>][school]"
                                                                value="<?= $qualification[$i]['school'] ?>"></td>
                                                        <td><input type="text" class="form-control"
                                                                name="qualification[<?= $i ?>][graduation_date]"
                                                                value="<?= $qualification[$i]['graduation_date'] ?>">
                                                        </td>
                                                        <td><input type="text" class="form-control"
                                                                name="qualification[<?= $i ?>][major]"
                                                                value="<?= $qualification[$i]['major'] ?>"></td>
                                                    </tr>
                                                    <?php } ?>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <h3 style="font-size:17px;font-weight:700">D. OTHER INFOMATIONS</h3>
                                        </div>
                                        <?php
                    $others = json_decode($student_application_form['others'], true);
                    ?>
                                        <div class="form-group col-md-12">

                                            <label for="form-nationality">HAVE YOU HAVE ANY ILLNESS OR INJURY? IF YES,
                                                PLEASE STATE</label>

                                            <input type="text" class="form-control" id="form-nationality"
                                                name="others[pertanyaan_1]" value="<?= $others['pertanyaan_1'] ?>">

                                        </div>
                                        <div class="form-group col-md-12">

                                            <label for="form-nationality">ARE YOU HAVING AN ALLERGY? PLEASE STATE THE
                                                COUSE OF THE ALLERGY?</label>

                                            <input type="text" class="form-control" id="form-nationality"
                                                name="others[pertanyaan_2]" value="<?= $others['pertanyaan_2'] ?>">

                                        </div>
                                        <div class="form-group col-md-12">
                                            <h3 style="font-size:17px;font-weight:700">E. STATEMENT DECLARE</h3>
                                        </div>
                                        <div class="form-group col-md-12">

                                            <label for="form-nationality">I UNDERSTAND IF ANY PARTCULARS SUPPLIED BY ME
                                                IN THIS FORM ARE PROVED UNTURE, I AM LIABLE TO BE SUMMARILY DISMISSED.
                                            </label>
                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-nationality">APPLICANT</label>
                                            <br>
                                            <?php
                      $a = '';
                      $b = '';
                      if ($others['applicant'] == 'YES') {
                        $a = 'checked';
                      } else {
                        $b = 'checked';
                      }
                      ?>
                                            <input <?= $a ?> type="radio" class="" id="form-nationality"
                                                name="others[applicant]" value="YES"> YES
                                            <input <?= $b ?> type="radio" class="" id="form-nationality"
                                                name="others[applicant]" value="NO"> NO

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-nationality">PARENT</label>
                                            <br>
                                            <?php
                      $a = '';
                      $b = '';
                      if ($others['parent'] == 'YES') {
                        $a = 'checked';
                      } else {
                        $b = 'checked';
                      }
                      ?>
                                            <input <?= $a ?> type="radio" class="" id="form-nationality"
                                                name="others[parent]" value="YES"> YES
                                            <input <?= $b ?> type="radio" class="" id="form-nationality"
                                                name="others[parent]" value="NO"> NO

                                        </div>

                                        <div class="form-group col-md-12">

                                            <label for="form-nationality">NOTE</label>

                                            <input type="text" class="form-control" id="form-nationality"
                                                name="others[note]" value="<?= $others['note'] ?>">

                                        </div>

                                        <div class="form-group col-md-12">
                                            <h3 style="font-size:17px;font-weight:700">#. OTHERS</h3>
                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-nationality">T-SHIRT SIZE</label>

                                            <input type="text" class="form-control" id="form-nationality"
                                                placeholder="Insert T-Shirt Size" name="dt[t_shirt_size]"
                                                value="<?= $student_application_form['t_shirt_size'] ?>">

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-nationality">SHOES SIZE</label>

                                            <input type="text" class="form-control" id="form-nationality"
                                                placeholder="Insert Shoes Size" name="dt[shoes_size]"
                                                value="<?= $student_application_form['shoes_size'] ?>">

                                        </div>
                                        <div class="form-group col-md-12">

                                            <label for="form-nationality">CURRENT BATCH</label>

                                            <select style='width:100%' name="dt[batch]" class="form-control select2"
                                                id="batch">
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
                                                PLEASE SELECT BATCH!

                                            </div>
                                        </div>





                                        <div class="form-group col-md-12">

                                            <label for="form-file">FOTO PROFILE </label>

                                            <?php

                      if ($file['dir'] != "") { ?>
                                            <a href="<?= base_url($file['dir']) ?>" target="_blank"><i
                                                    class="fa fa-download"></i> <?= $file['name'] ?></a>


                                            <?php } ?>
                                            <input type="file" class="form-control" id="form-file"
                                                placeholder="Insert File" name="file">
                                        </div>

                                        <div class="col-md-12">

                                            <button type="submit" class="btn btn-primary btn-send pull-right"><i
                                                    class="fa fa-save"></i> SAVE</button>



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
                                        <!-- <button type="submit" class="btn btn-primary btn-send float-add" data-placement="top" title="SAVE APPLICANT DATA" ><i class="fa fa-save"></i> SAVE</button> -->

                                        <!-- <a class="btn btn-success float-upload" href="#!" data-toggle="modal" data-target="#modal-upload"><i class="mdi mdi-attachment"></i></a> -->

                                    </div>


                                </div>

                            </div>

                            <!-- /.box-body -->

                        </div>

                        <!-- /.box -->



                        <!-- /.box -->

                    </div>

                    <!-- /.col AANG-->

                </div>
                <div class="col-md-6">
                    <div class="box">

                        <div class="box-header-material">

                            <h3 class="box-header-material-text">PREVIEW LIST
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i></button>
                                </div>
                        </div>
                        <div class="box-body">

                            <!-- <div class="show_error"></div> -->
                            <div class="row">

                                <div class="form-group col-md-12">
                                    <div class="table-responsive">

                                        <table class="table table-bordered" id="mytable" style="width:100%">

                                            <thead>

                                                <tr class="bg-success">

                                                    <th style="width:20px">NUM</th>
                                                    <th style="min-width:100px;">ACTION</th>
                                                    <th>BATCH</th>
                                                    <th>REGISTRATION DATE</th>
                                                    <th>APPLICATION NUMBER</th>
                                                    <th>FULL NAME</th>
                                                    <th>NICK NAME</th>

                                                    <th>PLACE OF BIRTH</th>

                                                    <th style="min-width:100px">DATE OF BIRTH</th>
                                                    <th>GENDER</th>
                                                    <th>PHONE NUMBER (WA)</th>
                                                    <th>EMAIL</th>


                                                </tr>

                                            </thead>

                                            <tbody>
                                                <?php foreach ($mydata as $key => $val) { ?>
                                                <tr>
                                                    <td><?= $key + 1 ?></td>
                                                    <td class="text-center">
                                                        <a href="<?= base_url() ?>master/student_application_form/edit/<?= $val['id'] ?>"
                                                            class="btn btn-primary btn-xs btn-rounded"><i
                                                                class="mdi mdi-pencil"></i></a>
                                                        <a href="#!" data-toggle="modal"
                                                            data-target="#modal-delete-<?= $val['id'] ?>"
                                                            class="btn btn-danger btn-rounded btn-xs"><i
                                                                class="mdi mdi-delete"></i></a>



                                                        <div class="modal modal-danger fade"
                                                            id="modal-delete-<?= $val['id'] ?>">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span
                                                                                aria-hidden="true">&times;</span></button>
                                                                        <h4 class="modal-title">DELETE DATA</h4>
                                                                    </div>
                                                                    <div class="modal-body"
                                                                        style="color:#fff!important;">
                                                                        <form action="">
                                                                            <span style="font-weight:100">Are you sure
                                                                                you want to delete this data?</span>
                                                                        </form>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                            class="btn btn-outline pull-left"
                                                                            data-dismiss="modal">Close</button>
                                                                        <a type="button" class="btn btn-outline"
                                                                            href="<?= base_url() ?>master/student_application_form/delete_data/<?= $val['id'] ?>">Delete
                                                                            Now</a>
                                                                    </div>
                                                                </div>
                                                                <!-- /.modal-content -->
                                                            </div>
                                                            <!-- /.modal-dialog -->
                                                        </div>
                                                    </td>
                                                    <td><?= $val['batch'] ?></td>
                                                    <td><?= $val['registration_date'] ?></td>
                                                    <td><?= $val['application_number'] ?></td>
                                                    <td><?= $val['full_name'] ?></td>
                                                    <td><?= $val['nick_name'] ?></td>
                                                    <td><?= $val['place_of_birth'] ?></td>
                                                    <td><?= $val['date_of_birth'] ?></td>
                                                    <td><?= $val['gender'] ?></td>
                                                    <td><?= $val['mobile_phone_number'] ?></td>
                                                    <td><?= $val['email'] ?></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>

                                        </table>

                                    </div>
                                    <br>
                                    <a href="#!" data-toggle="modal" data-target="#modal-submit"
                                        class="btn btn-primary pull-right">SUBMIT</a>


                                    <a href="#!" data-toggle="modal" data-target="#modal-reset"
                                        class="btn btn-danger pull-right" style="margin-right:10px;">RESET</a>




                                    <div class="modal modal-success fade" id="modal-submit">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title">CONFIRMATION SUBMIT DATA</h4>
                                                </div>
                                                <div class="modal-body" style="color:#fff!important;">
                                                    <form action="">
                                                        <span style="font-weight:100">Are you sure you want to submit
                                                            this data?</span>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline pull-left"
                                                        data-dismiss="modal">Close</button>
                                                    <a type="button" class="btn btn-outline"
                                                        href="<?= base_url() ?>master/student_application_form/submit">Submit
                                                        Now</a>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>


                                    <div class="modal modal-danger fade" id="modal-reset">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title">CONFIRMATION RESET DATA</h4>
                                                </div>
                                                <div class="modal-body" style="color:#fff!important;">
                                                    <form action="">
                                                        <span style="font-weight:100">Are you sure you want to reset
                                                            this data?</span>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline pull-left"
                                                        data-dismiss="modal">Close</button>
                                                    <a type="button" class="btn btn-outline"
                                                        href="<?= base_url() ?>master/student_application_form/reset">Reset
                                                        Now</a>
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
                </div>
            </div>

            <!-- /.row -->

        </form>



    </section>

    <!-- /.content -->

</div>

<!-- /.content-wrapper -->





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

                    //    window.location.href = "<?= base_url('master/student_application_form') ?>";
                    window.location.href = "";

                }, 1000);

                $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> SAVE').attr(
                    'disabled', false);





            } else {

                form.find(".show_error").hide().html(response).slideDown("fast");

                $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> SAVE').attr(
                    'disabled', false);



            }

        },

        error: function(xhr, textStatus, errorThrown) {

            console.log(xhr);

            $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> SAVE').attr(
                'disabled', false);

            form.find(".show_error").hide().html(xhr).slideDown("fast");



        }

    });

    return false;



});
</script>

<script>
$(document).ready(function() {
    $('#batch').change(function() {
        var batch = $('#batch').val();

        $("#training").html('<option>LOADING...</option>');
        if (batch) {
            $.ajax({
                url: '<?= base_url() ?>ajax/get_training/?batch=' + batch +
                    '&id_user=<?= $student_application_form['id'] ?>',
                success: function(html) {
                    $("#training").html(html);
                }
            });
        } else {
            // $('#kabupaten').html('<option value="">PILIH KABUPATEN/KOTA</option>'); 
        }

    });

});
</script>