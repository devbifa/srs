<div class="row">
    <div class="col-md-12">
        <h3 class="box-title" align="center">All News</h3>
        <form role="form" action="<?= base_url('news') ?>" method="GET">
            <div class="form-group">
                <label for="exampleInputEmail1">Cari News</label>
                <input type="text" name="keyword" class="form-control" <?php if ($_GET['keyword']) {
                    echo 'value="' . $_GET['keyword'] . '"';
                } ?> id="filter-search">
            </div>
            <div class="form-group" align="center">
                <button type="submit" class="btn btn-lg btn-block btn-primary" style="">
                     Cari News
                </button>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div id="load_data">
    </div>
</div>
<div id="load_data_message"></div>
<script type="text/javascript">
    $(document).ready(function(){

        var limit = 6;
        var start = 0;
        var action = 'inactive'; 
        var search = 0;

        function load_data(limit, start){
            lazzy_loader(limit);
            search = $('#filter-search').val();

            $.ajax({
                url:"<?= base_url(); ?>blogs/fetch?keyword="+search,
                method:"POST",
                data:{limit:limit, start:start},
                cache: false,
                success:function(data)
                {
                    if(data == '') {
                        $('#load_data_message').html('<div class="row">'+
                            '<div class="col-xs-12" align="center">'+
                            'Semua Data Telah Ditampilkan'+
                            '</div>'+
                            '</div>');
                        action = 'active';
                    } else {
                        $('#load_data').append(data);
                        $('#load_data_message').html('<div class="row">'+
                            '<div class="col-xs-12" align="center">'+
                            'Tampilkan Lebih Banyak <br> <i class="fa fa-angle-down"></i>'+
                            '</div>'+
                            '</div>');
                        action = 'inactive';
                    }
                }
            })
        }

        if(action == 'inactive')
        {
            action = 'active';
            load_data(limit, start);
        }

        $(window).scroll(function(){
            if($(window).scrollTop() + $(window).height() > $("#load_data").height() && action == 'inactive')
            {
                lazzy_loader(limit);
                action = 'active';
                start = start + limit;
                setTimeout(function(){
                    load_data(limit, start);
                }, 1000);
            }
        });
    });
</script>