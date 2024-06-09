<?php 
$s = array();
foreach (json_decode($show) as $value) {
    $s[] = "<th>".ucfirst(str_replace("_", " ", $value))."</th>";
}

$header = implode('', $s);


$string = "
  <?php error_reporting(0); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class=\"content-wrapper\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">
      <h1>".ucwords(str_replace('_',' ',$controller))."</h1>
      <h5 style=\"padding-left:1px;\"></h5>
    </section>

    <!-- Main content -->
    <section class=\"content\">
      <div class=\"row\">
        <div class=\"col-md-12\">
          <div class=\"panel panel-success\">
            <div class=\"panel-heading\">
              <!-- FILTER  -->
              <div class=\"row\">
                <form action='' method='POST'>
                <div class=\"col-md-12\">
                <a class=\"btn btn-success pull-right btn-flat\" href=\"<?= base_url('report/".$controller."/getExcel/') ?>\" target=\"_blank\"><i class=\"fa fa-file-excel-o\"></i> Export Excel</a>
                </div>
                <div class=\"col-md-12\">
                  <div class=\"row\">
                    <div class=\"col-md-4\">
                      <label>Tanggal Awal</label>
                      <input type='date' class=\"form-control\" name='date_start' value=\"<?= \$_SESSION['date_start'] ?>\">
                    </div>
                    <div class=\"col-md-4\">
                      <label>Tanggal Akhir</label>
                      <input type='date' class=\"form-control\" name='date_end' value=\"<?= \$_SESSION['date_end'] ?>\">
                    </div>
                    <div class=\"col-md-4\">
                      <label>Filter Sekarang?</label>
                      <input type='submit' class=\"form-control btn-primary\" value=\"FILTER SEKARANG\">
                    </div>
                  </div>
                  </form>
                </div>
              </div>
              <!-- FILTER  -->
            </div>
            <div class=\"panel-body\">
                <table class=\"table table-hover table-bordered\" id=\"idTable\" style=\"width: 100%\">
                  <thead>
                    <tr class=\"bg-success\">
                      <th>No</th>
                      ".ucwords($header)."
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
            </div>
          </div>
        </div>
      </div>

    </section>
  </div>

<script type=\"text/javascript\">
  var table;
  $(document).ready(function() {
    //datatables
    table = $('#idTable').DataTable({ 
        \"processing\": true, //Feature control the processing indicator.
        \"serverSide\": true, //Feature control DataTables' server-side processing mode.
        \"order\": [], //Initial no order.
        \"scrollX\": true,
        // Load data for the table's content from an Ajax source
        \"ajax\": {
          \"url\": \"<?php echo base_url('report/".$controller."/ajaxall/')?>\",
          \"type\": \"POST\"
        },
        //Set column definition initialisation properties.
        \"columnDefs\": [
        { 
            \"targets\": [ 0 ], //first column / numbering colum
            \"orderable\": true, //set not orderable
          },
          ],
        });
  });
</script>
";

// echo $string;
$this->template->createFile($string, $path);

 ?>