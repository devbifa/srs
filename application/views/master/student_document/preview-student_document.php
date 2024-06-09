<?php
// MARKETING
$value = $student_document;
$pass_payment = '0';
if (in_array($_SESSION['role'], array('5'))) {
  $pass_payment = '1';
?>
<?php if (in_array($value['status'], array('ACTIVE', 'HOLD', 'TERMINATED', 'GRADUATED'))) { ?>

<a href="#!" data-toggle="modal" data-target="#modal-graduate" class="btn btn-info  pull-right float-5"
    data-placement="top" title="GRADUATE STUDENT STATUS"><i class="fa fa-graduation-cap"></i></a>

<a href="#!" data-toggle="modal" data-target="#modal-active-document" class="btn btn-success  pull-right float-4"
    data-placement="top" title="ACTIVATE STUDENT STATUS"><i class="mdi mdi-checkbox-marked-circle-outline"></i></a>

<a href="#!" data-toggle="modal" data-target="#modal-hold" class="btn btn-warning  pull-right float-3"
    data-placement="top" title="HOLD STUDENT STATUS"><i class="mdi mdi-minus-circle-outline"></i></a>

<a href="#!" data-toggle="modal" data-target="#modal-terminated" class="btn btn-danger  pull-right float-2"
    data-placement="top" title="TERMINATE STUDENT STATUS"><i class="mdi mdi-close-circle-outline"></i></a>


<a href="<?= base_url() ?>master/student_document/edit/<?= $student_document['id'] ?>"
    class="btn btn-primary  pull-right float-1" data-placement="top" title="EDIT STUDENT STATUS"><i
        class="mdi mdi-pencil"></i></a>
<?php } else { ?>

<?php } ?>
<?php } ?>




<a href="<?= base_url() ?>master/student_document/edit/<?= $student_document['id'] ?>"
    class="btn btn-primary  pull-right float-add" data-placement="top" title="EDIT STUDENT STATUS"><i
        class="mdi mdi-pencil"></i></a>


<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

        <h1>

            STUDENT ACTIVE

            <small>EDIT BY MARKETING</small>

        </h1>

        <ol class="breadcrumb">

            <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>


            <li class="#">STUDENT ACTIVE</li>

            <li class="active">EDIT BY MARKETING</li>

        </ol>

    </section>

    <!-- Main content -->

    <section class="content">



        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-header-material box-header-material-text">
                                <div class="row">
                                    <div class="col-xs-10">
                                        PAYMENT HISTORY
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
                                <?php


                ?>

                                <div class="row">


                                    <div class="col-md-12">

                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <!-- <label for="form-file">ATTACHMENT LIST</label> -->
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <tr class="bg-success">
                                                            <th class="text-center">NO.
                                                            </th>
                                                            <th class="text-center">PAYMENT
                                                            </th>
                                                            <th class="text-center">NOMINAL INV
                                                            </th>
                                                            <th class="text-center">NOMINAL PAID
                                                            </th>
                                                            <th class="text-center">BALANCE
                                                            </th>
                                                            <th class="text-center">DESCRIPTION
                                                            </th>
                                                            <th class="text-center">CREATED DATE
                                                            </th>
                                                            <th class="text-center">DUE DATE
                                                            </th>
                                                            <th class="text-center">PAID DATE
                                                            </th>
                                                            <th class="text-center">FILE
                                                            </th>


                                                        </tr>
                                                        <?php
                            $id_user = $student_document['id'];
                            $arr = $this->mymodel->selectWithQuery("SELECT * FROM log_payment WHERE id_user = '$id_user' AND status = 'ENABLE' ORDER BY inv_at ASC");
                            $i = 0;

                            $price = array();
                            // foreach ($attachment_list as $key => $row)
                            // {
                            //     $price[$key] = $row['date'];
                            // }
                            // array_multisort($price, SORT_ASC, $attachment_list);
                            // // print_r($attachment_list);

                            foreach ($arr as $key => $val) {
                              $val['gap'] = $val['paid'] - $val['nominal'];
                            ?>
                                                        <tr>
                                                            <td class="text-left" style="width:25px;">
                                                                <?= $i + 1 ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <?= $val['name'] ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <?= $this->template->rupiah($val['nominal']) ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <?= $this->template->rupiah($val['paid']) ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <?= $this->template->rupiah($val['gap']) ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <?= $val['description'] ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <?= $this->template->date_indo(($val['inv_at'])) ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <?= $this->template->date_indo(($val['due_at'])) ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <?= $this->template->date_indo(($val['paid_at'])) ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <?php
                                  if ($val['file']) { ?>
                                                                <a href="<?= base_url() ?>webfile/payment/<?= $val['file'] ?>?token=<?= DATE('Ymdhis', strtotime($val['updated_at'])) ?>"
                                                                    target="_blank"
                                                                    class="btn btn-delete btn-xs btn-info"><i
                                                                        class="mdi mdi-eye"></i></a>
                                                                <?php } ?>
                                                            </td>



                                                            </td>
                                                        </tr>
                                                        <?php
                              $i++;
                              $total_nominal_inv = $total_nominal_inv + $val['nominal'];
                              $total_nominal_paid = $total_nominal_paid + $val['paid'];
                              $total_nominal_gap = $total_nominal_gap + $val['paid'] - $val['nominal'];
                              $balance = $total_nominal_paid - $total_nominal_inv;
                              if ($total_nominal_paid >= $total_nominal_inv) {
                                $text = "Paid Off";
                              } else {
                                $text = "Not Yet Paid Off";
                              }
                            } ?>
                                                        <tr>
                                                            <th></th>
                                                            <th class="text-center">TOTAL</th>
                                                            <td class="text-center">
                                                                <?= $this->template->rupiah($total_nominal_inv) ?></td>
                                                            <td class="text-center">
                                                                <?= $this->template->rupiah($total_nominal_paid) ?></td>
                                                            <td class="text-center">
                                                                <?= $this->template->rupiah($total_nominal_gap) ?></td>
                                                            <td colspan="6" class="text-left">Balance Payment :
                                                                <?= $this->template->rupiah($total_nominal_gap) ?> ,
                                                                <?= $text ?></td>
                                                        </tr>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="">
                <div class="">
                    <div class="col-md-6">
                        <form method="POST" action="<?= base_url('master/Student_document/update') ?>"
                            id="upload-create" enctype="multipart/form-data">

                            <input disabled type="hidden" name="id" value="<?= $student_document['id'] ?>">


                            <div class="box">

                                <div class="box-header-material box-header-material-text">
                                    <div class="row">
                                        <div class="col-xs-10">
                                            REVIEW STUDENT ACTIVE : <?= $student_document['status'] ?>
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
                                    <div class="">
                                        <div class="col-md-12">

                                            <div class="row">

                                                <div class="form-group col-md-6">

                                                    <label for="form-registration_date">REGISTRATION DATE</label>

                                                    <input disabled autocomplete="off" type="text"
                                                        class="form-control pull-right tgl" id="datepicker"
                                                        name="dt[registration_date]"
                                                        value="<?= $student_document['registration_date'] ?>">

                                                </div>
                                                <div class="form-group col-md-6">

                                                    <label for="form-application_number">APPLICATION NUMBER</label>

                                                    <input disabled type="text" class="form-control"
                                                        id="form-application_number"
                                                        placeholder="Insert Application Number"
                                                        name="dt[application_number]"
                                                        value="<?= $student_document['application_number'] ?>">

                                                </div>

                                                <div class="form-group col-md-12">
                                                    <h3 style="font-size:17px;font-weight:700">#. LOG IN INFORMATION
                                                    </h3>
                                                </div>

                                                <div class="form-group col-md-6">

                                                    <label for="form-full_name">ID NUMBER</label>

                                                    <input disabled type="text" class="form-control" id="form-full_name"
                                                        placeholder="Insert ID Number" name="dt[id_number]"
                                                        value="<?= $student_document['id_number'] ?>">

                                                </div>

                                                <div class="form-group col-md-6">

                                                    <label for="form-curriculum">PASSWORD</label>

                                                    <input disabled autocomplete="off" style='width:100%'
                                                        name="password" class="form-control"
                                                        placeholder="Leave blank if you do not wish to change the password">

                                                </div>

                                                <div class="form-group col-md-12">
                                                    <h3 style="font-size:17px;font-weight:700">A. PERSONAL PARTICULARS
                                                    </h3>
                                                </div>
                                                <div class="form-group col-md-6">

                                                    <label for="form-full_name">FULL NAME</label>

                                                    <input disabled type="text" class="form-control" id="form-full_name"
                                                        placeholder="Insert Full Name" name="dt[full_name]"
                                                        value="<?= $student_document['full_name'] ?>">

                                                </div>
                                                <div class="form-group col-md-6">

                                                    <label for="form-full_name">NICK NAME</label>

                                                    <input disabled type="text" class="form-control" id="form-full_name"
                                                        placeholder="Insert Nick Name" name="dt[nick_name]"
                                                        value="<?= $student_document['nick_name'] ?>">

                                                </div>
                                                <div class="form-group col-md-6">

                                                    <label for="form-place_of_birth">PLACE OF BIRTH</label>

                                                    <input disabled type="text" class="form-control"
                                                        id="form-place_of_birth" placeholder="Insert Place Of Birth"
                                                        name="dt[place_of_birth]"
                                                        value="<?= $student_document['place_of_birth'] ?>">

                                                </div>
                                                <div class="form-group col-md-6">

                                                    <label for="form-gender">GENDER</label>

                                                    <input disabled type="text" class="form-control" id="form-gender"
                                                        placeholder="Insert Gender" name="dt[gender]"
                                                        value="<?= $student_document['gender'] ?>">

                                                </div>
                                                <div class="form-group col-md-6">

                                                    <label for="form-identity_card_no">IDENTITY CARD NO</label>

                                                    <input disabled type="text" class="form-control"
                                                        id="form-identity_card_no" placeholder="Insert Identity Card No"
                                                        name="dt[identity_card_no]"
                                                        value="<?= $student_document['identity_card_no'] ?>">

                                                </div>
                                                <div class="form-group col-md-6">

                                                    <label for="form-date_of_birth">DATE OF BIRTH</label>
                                                    <input disabled autocomplete="off" type="text"
                                                        class="form-control pull-right tgl" id="datepicker"
                                                        name="dt[date_of_birth]"
                                                        value="<?= $student_document['date_of_birth'] ?>">

                                                </div>
                                                <div class="form-group col-md-6">

                                                    <label for="form-weight">WEIGHT</label>

                                                    <input disabled type="text" class="form-control" id="form-weight"
                                                        placeholder="Insert Weight" name="dt[weight]"
                                                        value="<?= $student_document['weight'] ?>">

                                                </div>
                                                <div class="form-group col-md-6">

                                                    <label for="form-height">HEIGHT</label>

                                                    <input disabled type="text" class="form-control" id="form-height"
                                                        placeholder="Insert Height" name="dt[height]"
                                                        value="<?= $student_document['height'] ?>">

                                                </div>
                                                <div class="form-group col-md-12">

                                                    <label for="form-address">ADDRESS</label>

                                                    <input disabled type="text" class="form-control" id="form-address"
                                                        placeholder="Insert Address" name="dt[address]"
                                                        value="<?= $student_document['address'] ?>">

                                                </div>
                                                <div class="form-group col-md-6">

                                                    <label for="form-city">CITY</label>

                                                    <input disabled type="text" class="form-control" id="form-city"
                                                        placeholder="Insert City" name="dt[city]"
                                                        value="<?= $student_document['city'] ?>">

                                                </div>
                                                <div class="form-group col-md-6">

                                                    <label for="form-zip_code">ZIP CODE</label>

                                                    <input disabled type="text" class="form-control" id="form-zip_code"
                                                        placeholder="Insert Zip Code" name="dt[zip_code]"
                                                        value="<?= $student_document['zip_code'] ?>">

                                                </div>
                                                <div class="form-group col-md-12">

                                                    <label for="form-domicile_address">DOMICILE ADDRESS</label>

                                                    <input disabled type="text" class="form-control"
                                                        id="form-domicile_address" placeholder="Insert Domicile Address"
                                                        name="dt[domicile_address]"
                                                        value="<?= $student_document['domicile_address'] ?>">

                                                </div>
                                                <div class="form-group col-md-6">

                                                    <label for="form-domicile_city">DOMICILE CITY</label>

                                                    <input disabled type="text" class="form-control"
                                                        id="form-domicile_city" placeholder="Insert Domicile City"
                                                        name="dt[domicile_city]"
                                                        value="<?= $student_document['domicile_city'] ?>">

                                                </div>
                                                <div class="form-group col-md-6">

                                                    <label for="form-domicile_zip">DOMICILE ZIP</label>

                                                    <input disabled type="text" class="form-control"
                                                        id="form-domicile_zip" placeholder="Insert Domicile Zip"
                                                        name="dt[domicile_zip]"
                                                        value="<?= $student_document['domicile_zip'] ?>">

                                                </div>
                                                <div class="form-group col-md-6">

                                                    <label for="form-home_telephone_number">HOME TELEPHONE
                                                        NUMBER</label>

                                                    <input disabled type="text" class="form-control"
                                                        id="form-home_telephone_number"
                                                        placeholder="Insert Home Telephone Number"
                                                        name="dt[home_telephone_number]"
                                                        value="<?= $student_document['home_telephone_number'] ?>">

                                                </div>
                                                <div class="form-group col-md-6">

                                                    <label for="form-mobile_phone_number">MOBILE PHONE NUMBER</label>

                                                    <input disabled type="text" class="form-control"
                                                        id="form-mobile_phone_number"
                                                        placeholder="Insert Mobile Phone Number"
                                                        name="dt[mobile_phone_number]"
                                                        value="<?= $student_document['mobile_phone_number'] ?>">

                                                </div>
                                                <div class="form-group col-md-6">

                                                    <label for="form-marital_status">MARITAL STATUS</label>

                                                    <input disabled type="text" class="form-control"
                                                        id="form-marital_status" placeholder="Insert Marital Status"
                                                        name="dt[marital_status]"
                                                        value="<?= $student_document['marital_status'] ?>">

                                                </div>
                                                <div class="form-group col-md-6">

                                                    <label for="form-email">EMAIL</label>

                                                    <input disabled type="text" class="form-control" id="form-email"
                                                        placeholder="Insert Email" name="dt[email]"
                                                        value="<?= $student_document['email'] ?>">

                                                </div>
                                                <div class="form-group col-md-6">

                                                    <label for="form-religion">RELIGION</label>

                                                    <input disabled type="text" class="form-control" id="form-religion"
                                                        placeholder="Insert Religion" name="dt[religion]"
                                                        value="<?= $student_document['religion'] ?>">

                                                </div>
                                                <div class="form-group col-md-6">

                                                    <label for="form-nationality">NATIONALITY</label>

                                                    <input disabled type="text" class="form-control"
                                                        id="form-nationality" placeholder="Insert Nationality"
                                                        name="dt[nationality]"
                                                        value="<?= $student_document['nationality'] ?>">

                                                </div>
                                                <div class="form-group col-md-12">
                                                    <h3 style="font-size:17px;font-weight:700">B. FAMILY PARTICULARS
                                                    </h3>
                                                </div>
                                                <?php $family = json_decode($student_document['family'], true); ?>
                                                <div class="form-group col-md-6">
                                                    <label for="form-nationality">FATHER'S NAME</label>
                                                    <input disabled type="text" class="form-control"
                                                        id="form-nationality" name="family[father_name]"
                                                        value="<?= $family['father_name'] ?>">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="form-nationality">PLACE & DATE OF BIRTH</label>
                                                    <input disabled type="text" class="form-control"
                                                        id="form-nationality" name="family[father_place_of_birth]"
                                                        value="<?= $family['father_place_of_birth'] ?>">
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="form-nationality">FATHER'S ADDRESS</label>
                                                    <input disabled type="text" class="form-control"
                                                        id="form-nationality" name="family[father_address]"
                                                        value="<?= $family['father_address'] ?>">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="form-nationality">CALL PHONE NUMBER</label>
                                                    <input disabled type="text" class="form-control"
                                                        id="form-nationality" name="family[father_phone_number]"
                                                        value="<?= $family['father_phone_number'] ?>">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="form-nationality">FATHER'S OCCUPATION</label>
                                                    <input disabled type="text" class="form-control"
                                                        id="form-nationality" name="family[father_occupation]"
                                                        value="<?= $family['father_occupation'] ?>">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="form-nationality">RESIDENCE PHONE NUMBER</label>
                                                    <input disabled type="text" class="form-control"
                                                        id="form-nationality"
                                                        name="family[father_residence_phone_number]"
                                                        value="<?= $family['father_residence_phone_number'] ?>">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="form-nationality">FATHER'S INCOME</label>
                                                    <input disabled type="text" class="form-control"
                                                        id="form-nationality" name="family[father_income]"
                                                        value="<?= $family['father_income'] ?>">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="form-nationality">MOTHER'S NAME</label>
                                                    <input disabled type="text" class="form-control"
                                                        id="form-nationality" name="family[mother_name]"
                                                        value="<?= $family['mother_name'] ?>">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="form-nationality">PLACE & DATE OF BIRTH</label>
                                                    <input disabled type="text" class="form-control"
                                                        id="form-nationality" name="family[mother_place_of_birth]"
                                                        value="<?= $family['mother_place_of_birth'] ?>">
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="form-nationality">MOTHER'S ADDRESS</label>
                                                    <input disabled type="text" class="form-control"
                                                        id="form-nationality" name="family[mother_address]"
                                                        value="<?= $family['mother_address'] ?>">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="form-nationality">CALL PHONE NUMBER</label>
                                                    <input disabled type="text" class="form-control"
                                                        id="form-nationality" name="family[mother_phone_number]"
                                                        value="<?= $family['mother_phone_number'] ?>">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="form-nationality">MOTHER'S OCCUPATION</label>
                                                    <input disabled type="text" class="form-control"
                                                        id="form-nationality" name="family[mother_occupation]"
                                                        value="<?= $family['mother_occupation'] ?>">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="form-nationality">RESIDENCE PHONE NUMBER</label>
                                                    <input disabled type="text" class="form-control"
                                                        id="form-nationality"
                                                        name="family[mother_residence_phone_number]"
                                                        value="<?= $family['mother_residence_phone_number'] ?>">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="form-nationality">MOTHER'S INCOME</label>
                                                    <input disabled type="text" class="form-control"
                                                        id="form-nationality" name="family[mother_income]"
                                                        value="<?= $family['mother_income'] ?>">
                                                </div>
                                                <?php
                        $list_family = json_decode($student_document['list_family'], true);
                        ?>
                                                <div class="form-group col-md-12">
                                                    <label for="form-nationality">LIST OF NUCLEAR FAMILY (FILL IF
                                                        ALREADY MARRIEAGE)</label>
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
                                                                <td><input disabled disabled type="text"
                                                                        class="form-control"
                                                                        name="list_family[<?= $i ?>][name]"
                                                                        value="<?= $list_family[$i]['name'] ?>"></td>
                                                                <td><input disabled disabled type="text"
                                                                        class="form-control"
                                                                        name="list_family[<?= $i ?>][gender]"
                                                                        value="<?= $list_family[$i]['gender'] ?>"></td>
                                                                <td><input disabled disabled type="text"
                                                                        class="form-control"
                                                                        name="list_family[<?= $i ?>][date_of_birth]"
                                                                        value="<?= $list_family[$i]['date_of_birth'] ?>">
                                                                </td>
                                                                <td><input disabled disabled type="text"
                                                                        class="form-control"
                                                                        name="list_family[<?= $i ?>][relationship]"
                                                                        value="<?= $list_family[$i]['relationship'] ?>">
                                                                </td>
                                                                <td><input disabled disabled type="text"
                                                                        class="form-control"
                                                                        name="list_family[<?= $i ?>][occupation]"
                                                                        value="<?= $list_family[$i]['occupation'] ?>">
                                                                </td>
                                                            </tr>
                                                            <?php } ?>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label for="form-nationality">IN EMERGENCY CASE WHO CAN BE
                                                        CONTACTED, PREFER NON FAMILY MEMBERS</label>
                                                    <label for="form-nationality">NAME</label>
                                                    <input disabled type="text" class="form-control"
                                                        id="form-nationality" name="family[e_name]"
                                                        value="<?= $family['e_name'] ?>">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="form-nationality">RELATIONSHIP</label>
                                                    <input disabled type="text" class="form-control"
                                                        id="form-nationality" name="family[e_relationship]"
                                                        value="<?= $family['e_relationship'] ?>">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="form-nationality">PHONE NUMBER</label>
                                                    <input disabled type="text" class="form-control"
                                                        id="form-nationality" name="family[e_phone_number]"
                                                        value="<?= $family['e_phone_number'] ?>">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="form-nationality">ADDRESS</label>
                                                    <input disabled type="text" class="form-control"
                                                        id="form-nationality" name="family[e_address]"
                                                        value="<?= $family['e_address'] ?>">
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <h3 style="font-size:17px;font-weight:700">C. QUALIFICATION</h3>
                                                </div>


                                                <?php
                        $qualification = json_decode($student_document['qualification'], true);
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
                                                                <td><input disabled disabled type="text"
                                                                        class="form-control"
                                                                        name="qualification[<?= $i ?>][edutype]"
                                                                        value="<?= $qualification[$i]['edutype'] ?>">
                                                                </td>
                                                                <td><input disabled disabled type="text"
                                                                        class="form-control"
                                                                        name="qualification[<?= $i ?>][school]"
                                                                        value="<?= $qualification[$i]['school'] ?>">
                                                                </td>
                                                                <td><input disabled disabled type="text"
                                                                        class="form-control"
                                                                        name="qualification[<?= $i ?>][graduation_date]"
                                                                        value="<?= $qualification[$i]['graduation_date'] ?>">
                                                                </td>
                                                                <td><input disabled disabled type="text"
                                                                        class="form-control"
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
                        $others = json_decode($student_document['others'], true);
                        ?>
                                                <div class="form-group col-md-12">

                                                    <label for="form-nationality">HAVE YOU HAVE ANY ILLNESS OR INJURY?
                                                        IF YES, PLEASE STATE</label>

                                                    <input disabled type="text" class="form-control"
                                                        id="form-nationality" name="others[pertanyaan_1]"
                                                        value="<?= $others['pertanyaan_1'] ?>">

                                                </div>
                                                <div class="form-group col-md-12">

                                                    <label for="form-nationality">ARE YOU HAVING AN ALLERGY? PLEASE
                                                        STATE THE COUSE OF THE ALLERGY?</label>

                                                    <input disabled type="text" class="form-control"
                                                        id="form-nationality" name="others[pertanyaan_2]"
                                                        value="<?= $others['pertanyaan_2'] ?>">

                                                </div>
                                                <div class="form-group col-md-12">
                                                    <h3 style="font-size:17px;font-weight:700">E. STATEMENT DECLARE</h3>
                                                </div>
                                                <div class="form-group col-md-12">

                                                    <label for="form-nationality">I UNDERSTAND IF ANY PARTCULARS
                                                        SUPPLIED BY ME IN THIS FORM ARE PROVED UNTURE, I AM LIABLE TO BE
                                                        SUMMARILY DISMISSED.
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
                                                    <input disabled <?= $a ?> type="radio" class=""
                                                        id="form-nationality" name="others[applicant]" value="YES"> YES
                                                    <input disabled <?= $b ?> type="radio" class=""
                                                        id="form-nationality" name="others[applicant]" value="NO"> NO

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
                                                    <input disabled <?= $a ?> type="radio" class=""
                                                        id="form-nationality" name="others[parent]" value="YES"> YES
                                                    <input disabled <?= $b ?> type="radio" class=""
                                                        id="form-nationality" name="others[parent]" value="NO"> NO

                                                </div>

                                                <div class="form-group col-md-12">

                                                    <label for="form-nationality">NOTE</label>

                                                    <input disabled type="text" class="form-control"
                                                        id="form-nationality" name="others[note]"
                                                        value="<?= $others['note'] ?>">

                                                </div>

                                                <div class="form-group col-md-12">
                                                    <h3 style="font-size:17px;font-weight:700">#. OTHERS</h3>
                                                </div>
                                                <div class="form-group col-md-6">

                                                    <label for="form-nationality">T-SHIRT SIZE</label>

                                                    <input disabled type="text" class="form-control"
                                                        id="form-nationality" placeholder="Insert T-Shirt Size"
                                                        name="dt[t_shirt_size]"
                                                        value="<?= $student_document['t_shirt_size'] ?>">

                                                </div>
                                                <div class="form-group col-md-6">

                                                    <label for="form-nationality">SHOES SIZE</label>

                                                    <input disabled type="text" class="form-control"
                                                        id="form-nationality" placeholder="Insert Shoes Size"
                                                        name="dt[shoes_size]"
                                                        value="<?= $student_document['shoes_size'] ?>">

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

                                                    <label for="form-training_requirement">TRAINING REQUIREMENT
                                                        COURSE</label>
                                                    <br>

                                                    <div id="training">

                                                        <?php



                            $batch = $student_document['batch'];
                            $batch = $this->mymodel->selectDataOne('batch', array('batch' => $batch));
                            $curriculum = $this->mymodel->selectDataOne('syllabus_curriculum', array('code' => $batch['curriculum']));

                            $arr_type_of_training = json_decode($curriculum['type_of_training'], true);
                            $arr_course = json_decode($curriculum['course'], true);
                            $arr_mission = json_decode($curriculum['mission'], true);


                            $arr_type_of_training_selected = json_decode($student_document['type_of_training'], true);
                            $arr_course_selected = json_decode($student_document['course'], true);



                            $id_curriculum = $curriculum['code'];

                            //  $id_curriculum = $curriculum['id'];
                            $data = $this->mymodel->selectWithQuery("SELECT * FROM syllabus_type_of_training ORDER BY position ASC");

                            foreach ($data as $key => $val) {

                              if ($arr_type_of_training[$val['code']]['status'] == "ON") {



                                $table_body = '';

                                $configuration = '"val":"' . $val['id'] . '"';
                                $course = $this->mymodel->selectWithQuery("SELECT * FROM syllabus_course  ORDER BY position ASC");

                                $grand_total_duration = array();
                                foreach ($course as $key2 => $val2) {

                                  if ($arr_course[$val['code']][$val2['code']]['status'] == "ON") {

                                    $text = '';
                                    if ($training_requirement[$val['id']]['item'][$val2['id']]['val'] == $val2['id']) {
                                      $text = 'checked';
                                    }

                                    $course = $val2['code'];
                                    $curriculum = $val2['curriculum'];
                                    $type = $val['code'];


                                    foreach ($arr_mission[$val['code']][$val2['code']] as $k5 => $v5) {
                                      if ($v5['status'] == 'ON') {
                                        $text .= "'" . $k5 . "',";
                                      }
                                    }

                                    $text = substr($text, 0, -1);


                                    if ($text) {
                                      $mission = $this->mymodel->selectWithQuery("SELECT * FROM syllabus_mission WHERE type_of_training = '$type' AND code IN ($text) ORDER BY position ASC");
                                    }

                                    // print_r($mission);


                                    $duration = array();
                                    $duration_dual = array();
                                    $duration_solo = array();
                                    $duration_pic = array();
                                    $duration_pic_solo = array();
                                    $duration_non_rev = array();
                                    $duration_total = array();
                                    $total_duration = array();

                                    foreach ($mission as $key3 => $val3) {
                                      if ($arr_course_selected[$val['code']][$val2['code']]['status'] == "ON") {
                                        if ($arr_mission[$val['code']][$val2['code']][$val3['code']]['duration']) {
                                          $val3['duration'] = $arr_mission[$val['code']][$val2['code']][$val3['code']]['duration'];
                                        }
                                        if ($arr_mission[$val['code']][$val2['code']][$val3['code']]['price']) {
                                          $val3['price'] = $arr_mission[$val['code']][$val2['code']][$val3['code']]['price'];
                                        }
                                        if ($arr_mission[$val['code']][$val2['code']][$val3['code']]['duration_dual']) {
                                          $val3['duration_dual'] = $arr_mission[$val['code']][$val2['code']][$val3['code']]['duration_dual'];
                                        }
                                        if ($arr_mission[$val['code']][$val2['code']][$val3['code']]['duration_solo']) {
                                          $val3['duration_solo'] = $arr_mission[$val['code']][$val2['code']][$val3['code']]['duration_solo'];
                                        }
                                        if ($arr_mission[$val['code']][$val2['code']][$val3['code']]['duration_pic']) {
                                          $val3['duration_pic'] = $arr_mission[$val['code']][$val2['code']][$val3['code']]['duration_pic'];
                                        }
                                        if ($arr_mission[$val['code']][$val2['code']][$val3['code']]['duration_pic_solo']) {
                                          $val3['duration_pic_solo'] = $arr_mission[$val['code']][$val2['code']][$val3['code']]['duration_pic_solo'];
                                        }
                                        if ($arr_mission[$val['code']][$val2['code']][$val3['code']]['duration_non_rev']) {
                                          $val3['duration_non_rev'] = $arr_mission[$val['code']][$val2['code']][$val3['code']]['duration_non_rev'];
                                        }

                                        if ($val['code'] != 'FLIGHT') {
                                          if (strpos($val3['duration'], ':') !== false) {
                                            array_push($total_duration, $val3['duration']);
                                          }
                                        } else {
                                          if (strpos($val3['duration_dual'], ':') !== false) {
                                            array_push($duration_dual, $val3['duration_dual']);
                                          } else if (strpos($val3['duration_solo'], ':') !== false) {
                                            array_push($duration_solo, $val3['duration_solo']);
                                          } else if (strpos($val3['duration_pic'], ':') !== false) {
                                            array_push($duration_pic, $val3['duration_pic']);
                                          } else if (strpos($val3['duration_pic_solo'], ':') !== false) {
                                            array_push($duration_pic_solo, $val3['duration_pic_solo']);
                                          } else if (strpos($val3['duration_non_rev'], ':') !== false) {
                                            array_push($duration_non_rev, $val3['duration_non_rev']);
                                          }
                                          $duration_dual = $this->template->sum_time($duration_dual);
                                          $duration_solo = $this->template->sum_time($duration_solo);
                                          $duration_pic = $this->template->sum_time($duration_pic);
                                          $duration_pic_solo = $this->template->sum_time($duration_pic_solo);
                                          $duration_non_rev = $this->template->sum_time($duration_non_rev);
                                          $duration_total[] = $duration_dual;
                                          $duration_total[] = $duration_solo;
                                          $duration_total[] = $duration_pic;
                                          $duration_total[] = $duration_pic_solo;
                                          $duration_total[] = $duration_non_rev;
                                          // print_r($duration_total);
                                          $val3['duration'] = $this->template->sum_time($duration_total);

                                          if (strpos($val3['duration'], ':') !== false) {
                                            array_push($total_duration, $val3['duration']);
                                          }
                                        }
                                      }
                                    }
                                    $total_duration = $this->template->sum_time($total_duration);
                                    array_push($grand_total_duration, $total_duration);

                                    $text = "";
                                    if ($arr_course_selected[$val['code']][$val2['code']]['status'] == "ON") {
                                      $text = "checked";


                                      $table_body .= '
      <tr>   
          <td><input disabled ' . $text . ' type="checkbox" name="course[' . $val['code'] . '][' . $val2['code'] . '][status]" value="ON"></td>
          <td class="text-left">' . $val2['code_name'] . ' - ' . $val2['name'] . '</td>
          <td>' . $total_duration . '</td>
         
      </tr>
      ';
                                    }
                                  }
                                }
                                // print_r($grand_total_duration);
                                $grand_total_duration = $this->template->sum_time($grand_total_duration);
                                $table_body .= '
  <tr>   
      <th class="text-right" colspan="2">TOTAL</th>
      <th>' . $grand_total_duration . '</th>
     
  </tr>
  ';



                                $text = "";
                                if ($arr_type_of_training_selected[$val['code']]['status'] == "ON") {
                                  $text = "checked";



                                  $table .= ' 
  <table class="table table-bordered">
      <tr class="bg-orange">
          <th style="width:10px;"><input disabled ' . $text . ' type="checkbox" name="type_of_training[' . $val['code'] . '][status]" value="ON"></th>
          <th class="text-left"> ' . $val['name'] . '</th>
          <th class="text-left" style="width:20px;">DURATION</th>
      </tr>
      ' . $table_body . '
  </table>';
                                }
                              }
                            }

                            ?>

                                                        <?= $table; ?>




                                                    </div>
                                                </div>






                                                <div class="form-group col-md-12">

                                                    <label for="form-file">FOTO PROFILE </label>

                                                    <?php

                          if ($file['dir'] != "") { ?>
                                                    <a href="<?= base_url($file['dir']) ?>" target="_blank"><i
                                                            class="fa fa-download"></i> <?= $file['name'] ?></a>


                                                    <?php } ?>
                                                    <input disabled autocomplete="off" type="file" class="form-control"
                                                        id="form-file" placeholder="Insert File" name="file">
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
                                                <!-- <button type="submit" class="btn btn-primary btn-send float-add" data-placement="top" title="SAVE STUDENT STATUS"  ><i class="mdi mdi-content-save"></i></button> -->


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
                </div>
                <div class="">
                    <div class="col-md-6">



                        <div class="box">
                            <div class="box-header-material box-header-material-text">
                                <div class="row">
                                    <div class="col-xs-10">
                                        ARCHIVES DOCUMENT
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
                                                <!-- <label for="form-file">ARCHIVES DOCUMENT</label> -->
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th class="text-left" rowspan="2" style="width:50px;">NUM
                                                            </th>
                                                            <th class="text-left" rowspan="2" style="width:300px;">
                                                                ARCHIVE NAME
                                                            </th>
                                                            <th colspan="2" style="width:220px;">VALID DATE
                                                            </th>
                                                            <th rowspan="2">REMARK
                                                            </th>
                                                            <th rowspan="2" style="width:100px;">
                                                                FILE
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th style="width:110px;">START
                                                            </th>
                                                            <th style="width:110px;">UNTIL
                                                            </th>
                                                        </tr>
                                                        <?php
                            $attachment_list = $this->mymodel->selectWithQuery("SELECT * FROM student_file WHERE status = 'ENABLE' ORDER BY position ASC");
                            $att = json_decode($student_document['attachment'], true);
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
                                                            <td class="text-center" style="width:100px;">

                                                                <?php
                                  if ($att[$val['id']]['file']) { ?>
                                                                <a href="<?= base_url() ?>webfile/attachment/<?= $att[$val['id']]['file'] ?>?token=<?= DATE('Ymdhis', strtotime($val['updated_at'])) ?>"
                                                                    target="_blank"
                                                                    class="btn btn-delete btn-xs btn-info"><i
                                                                        class="mdi mdi-eye"></i></a>
                                                                <?php } ?>




                                                            </td>
                                                        </tr>
                                                        </tr>
                                                        <?php
                              $i++;
                            } ?>
                                                    </table>
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




                        <div class="box">
                            <div class="box-header-material box-header-material-text">
                                <div class="row">
                                    <div class="col-xs-10">
                                        RESULT TEST
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
                                                <!-- <label for="form-file">ARCHIVES DOCUMENT</label> -->
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th class="text-left" rowspan="2" style="width:50px;">NUM
                                                            </th>
                                                            <th class="text-left" rowspan="2" style="width:200px;">TEST
                                                            </th>
                                                            <th colspan="2" style="width:220px;">VALID DATE
                                                            </th>
                                                            <th rowspan="2" style="width:100px;">RESULTS
                                                            </th>
                                                            <th rowspan="2">REMARK
                                                            </th>
                                                            <th rowspan="2" style="width:100px;">
                                                                FILE
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th style="width:110px;">START
                                                            </th>
                                                            <th style="width:110px;">UNTIL
                                                            </th>
                                                        </tr>
                                                        <?php
                            $attachment_list = $this->mymodel->selectWithQuery("SELECT * FROM result_test WHERE status = 'ENABLE' ORDER BY position ASC");
                            $att = json_decode($student_document['result_test'], true);
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
                                                                <?= $val['name'] ?>
                                                            </td>
                                                            <td>
                                                                <?= $this->template->date_indo(($att[$val['id']]['valid_date_start'])) ?>
                                                            </td>
                                                            <td>
                                                                <?= $this->template->date_indo(($att[$val['id']]['valid_date_until'])) ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <?= $att[$val['id']]['score'] ?>
                                                            </td>
                                                            <td class="text-left">
                                                                <?= $att[$val['id']]['description'] ?>
                                                            </td>
                                                            <td class="text-center" style="width:100px;">
                                                                <?php
                                  if ($att[$val['id']]['file']) { ?>
                                                                <a href="<?= base_url() ?>webfile/result_test/<?= $att[$val['id']]['file'] ?>?token=<?= DATE('Ymdhis', strtotime($val['updated_at'])) ?>"
                                                                    target="_blank"
                                                                    class="btn btn-delete btn-xs btn-info"><i
                                                                        class="mdi mdi-eye"></i></a>
                                                                <?php } ?>




                                                            </td>
                                                        </tr>
                                                        </tr>
                                                        <?php
                              $i++;
                            } ?>
                                                    </table>
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




                        <div class="box">
                            <div class="box-header-material box-header-material-text">
                                <div class="row">
                                    <div class="col-xs-10">
                                        APPLICANT CHECKLIST
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
                                                <!-- <label for="form-file">ARCHIVES DOCUMENT</label> -->
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">

                                                        <tr>
                                                            <th class="text-left" style="width:50px;">NUM
                                                            </th>
                                                            <th class="text-left" style="width:420px;">REQUIREMENT
                                                            </th>
                                                            <th style="width:100px;">COMPLETE
                                                            </th>
                                                            <th>REMARK
                                                            </th>
                                                            <th style="width:100px;">
                                                                FILE
                                                            </th>
                                                        </tr>

                                                        <?php
                            $attachment_list = $this->mymodel->selectWithQuery("SELECT * FROM checklist WHERE status = 'ENABLE' ORDER BY position ASC");
                            $att = json_decode($student_document['checklist'], true);
                            $i = 0;
                            $price = array();

                            foreach ($attachment_list as $key => $val) {
                              $val['complete'] = "NO";
                              if ($att[$val['id']]['complete'] == "YES") {
                                $val['complete'] = "YES";
                              }
                            ?>
                                                        <tr>
                                                            <td style="width:25px;">
                                                                <?= $i + 1 ?>
                                                            </td>
                                                            <td class="text-left">
                                                                <?= $val['name'] ?>
                                                            </td>
                                                            <td>
                                                                <?= $val['complete'] ?>
                                                            </td>
                                                            <td class="text-left">
                                                                <?= $att[$val['id']]['description'] ?>
                                                            </td>
                                                            <td class="text-center" style="width:100px;">


                                                                <?php
                                  if ($att[$val['id']]['file']) { ?>
                                                                <a href="<?= base_url() ?>webfile/checklist/<?= $att[$val['id']]['file'] ?>?token=<?= DATE('Ymdhis', strtotime($val['updated_at'])) ?>"
                                                                    target="_blank"
                                                                    class="btn btn-delete btn-xs btn-info"><i
                                                                        class="mdi mdi-eye"></i></a>
                                                                <?php } ?>




                                                            </td>
                                                        </tr>
                                                        </tr>
                                                        <?php
                              $i++;
                            } ?>
                                                    </table>
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


                <div class="">
                    <div class="col-md-6">
                        <div class="box">


                            <div class="box-header-material box-header-material-text">
                                <div class="row">
                                    <div class="col-xs-10">
                                        STATUS HISTORY
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
                                                            <th class="text-left">NO.
                                                            </th>
                                                            <th class="text-left">STATUS
                                                            </th>
                                                            <th>DATE
                                                            </th>
                                                            <th class="text-left">PROCESSED BY
                                                            </th>
                                                        </tr>
                                                        <?php
                            $attachment_list = json_decode($student_document['log_perubahan_status'], true);
                            $nomor = 0;

                            $price = array();
                            // foreach ($attachment_list as $key => $row)
                            // {
                            //     $price[$key] = $row['number'];
                            // }
                            // array_multisort($price, SORT_ASC, $attachment_list);
                            // print_r($attachment_list);

                            foreach ($attachment_list as $key => $val) {
                              $nomor++;
                              $usr = $this->mymodel->selectDataOne('user', array('id' => $val['created_by']))
                              // echo $val['id'];
                              // echo $val['number'];
                              // $data = $this->mymodel->selectDataOne('student_file',array('id'=>$val['type']));
                            ?>
                                                        <tr>
                                                            <td style="width:25px;">
                                                                <?= $nomor ?>
                                                            </td>
                                                            <td class="text-left">
                                                                <?= $val['status'] ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <?= $val['created_at'] ?>
                                                            </td>
                                                            <td class="text-left">
                                                                <?= $usr['full_name'] ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                              $i++;
                            } ?>
                                                    </table>
                                                </div>

                                                <!-- <a class="btn btn-success float-4" href="#!" data-toggle="modal" data-target="#modal-upload"  data-placement="top" title="ADD NEW ATTACHMENT" ><i class="mdi mdi-attachment"></i></a> -->

                                                <!-- <a class="btn btn-success float-upload" href="#!" data-toggle="modal" data-target="#modal-upload-log"  data-placement="top" title="ADD NEW PAYMENT" ><i class="mdi mdi-credit-card"></i></a> -->


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
                        "<?= base_url('master/student_document/preview/' . $student_document['id']) ?>";

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


<script>
$(document).ready(function() {
    $('#batch').change(function() {
        var batch = $('#batch').val();

        $("#training").html('<option>LOADING...</option>');
        if (batch) {
            $.ajax({
                url: '<?= base_url() ?>ajax/get_training/?batch=' + batch,
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