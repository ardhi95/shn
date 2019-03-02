<?php echo $this->start("script");?>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/plugins/moment.min.js"></script>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/plugins/bootstrap/bootstrap-file-input.js"></script>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/plugins/morris/raphael-min.js"></script>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/plugins/morris/morris.min.js"></script>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/date.js"></script>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/plugins/cropper/cropper.min.js"></script>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/lang/<?php echo Configure::read('Config.language')?>/demo_edit_profile.js"></script>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/jquery-prettyPhoto.js"></script>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/plugins/daterangepicker/daterangepicker.js"></script>

<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/DataTables/DataTables/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/DataTables/Buttons/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/DataTables/Buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/DataTables/Buttons/js/buttons.bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/DataTables/JSZip/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/DataTables/pdfmake/pdfmake.min.js"></script>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/DataTables/pdfmake/vfs_fonts.js"></script>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/DataTables/Buttons/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/DataTables/Buttons/js/buttons.print.min.js"></script>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/DataTables/Buttons/js/buttons.colVis.min.js"></script>

<!-- START THIS PAGE PLUGINS-->        
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places&key=AIzaSyCV4QFXiixx190iTfXWeDPSuvnEaHHxsE8"></script>
<script type="text/javascript">

    var last30    = moment().subtract('days', 29).format('YYYY-MM-DD');
    var today     = moment().format('YYYY-MM-DD');
    var jsontable = (function () {
          var json = null;
          $.ajax({
            'async': false,
            'global': false,
            'url': '<?php echo $settings["cms_url"]?>Api/GetReportOrder?token=e56d867b3506917898f348720130b55d&firstdate='+last30+'&enddate='+today+'',
            'dataType': "json",
            'success': function (data) {
              json = data;
          }
      });
          return json;
      })();

    $(function(){
    /* reportrange */
    if($("#reportrange").length > 0){   
        $("#reportrange").daterangepicker({                    
            ranges: {
               'Today': [moment(), moment()],
               'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
               'Last 7 Days': [moment().subtract(6, 'days'), moment()],
               'Last 30 Days': [moment().subtract(29, 'days'), moment()],
               'This Month': [moment().startOf('month'), moment().endOf('month')],
               'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            opens: 'left',
            buttonClasses: ['btn btn-default'],
            applyClass: 'btn-small btn-primary',
            cancelClass: 'btn-small',
            format: 'MM.DD.YYYY',
            separator: ' to ',
            startDate: moment().subtract('days', 29),
            endDate: moment()            
          },function(start, end) {
              
              var stdate  =   start.format('YYYY-MM-DD');
              var endate  =   end.format('YYYY-MM-DD');

              var jsontable = (function () {
                  var json = null;
                  $.ajax({
                    'async': false,
                    'global': false,
                    'url': '<?php echo $settings["cms_url"]?>Api/GetReportOrder?token=e56d867b3506917898f348720130b55d&firstdate='+stdate+'&enddate='+endate+'',
                    'dataType': "json",
                    'success': function (data) {
                      json = data;
                  }
              });
                  return json;
              })();

              var dbTable = $('#example').DataTable();
              dbTable.clear().rows.add(jsontable.data).draw();

              $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        });
        
        $("#reportrange span").html(moment().subtract('days', 29).format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
    }
    /* end reportrange */
});

    initDataTables(jsontable.data);
    function initDataTables(data) {
        // body...
        $('#example').DataTable({
            "searching": false,
            dom: 'Bfrtip',
            buttons: [ 'copy', 'excel', 'pdf', 'print', 'colvis' ],
            "aaData": data,
            "aoColumns": [
                { "mDataProp": "no" },
                { "mDataProp": "orderId" },
                { "mDataProp": "date" },
                { "mDataProp": "stores" },
                { "mDataProp": "sales" },
                { "mDataProp": "address" },
                {
                  "mDataProp": null,
                  "bSortable": false,
                  "mRender": function(data, type, full) {
                    return "<a href='<?php echo $settings['cms_url'];?>Orders/Detail/"+data.orderId+"/1/50' class='btn btn-primary btn-condensed btn-sm' data-toggle='tooltip' data-placement='top'><i class='fa fa-eye'></i></a>";
                    }
                }
            ]
            
        });
    }

$(document).ready(function() {
/*"defaultContent": "<a href='<?php echo $settings['cms_url'];?>Orders/Detail/"+data.orderId+"/1/50' class='btn btn-primary btn-condensed btn-sm' data-toggle='tooltip' data-placement='top'><i class='fa fa-eye'></i></a>"*/
} );
</script>

<?php echo $this->end();?>
<style type="text/css">
    
    .img-circle{
        border: 2px solid #F5F5F5;
        -moz-border-radius: 50%;
        -webkit-border-radius: 50%;
        border-radius: 50%;
        width: 40px;
        margin-right: 10px
    }
    a{
        color: white;
    }
    a:hover{
        color: rgb(211, 211, 211);
    }
    .resize{
        padding: 0px;
        margin: 0px;
        font-weight: 1;
    }
</style>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="javascript:void(0);">Home</a></li>
    <li>Dashboard</li>
    <li class="active">Report Order</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE TITLE -->
<div class="page-title">
    <h2><span class="fa fa-desktop"></span> Report Order</h2>
</div>
<!-- END PAGE TITLE -->
<!-- START PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-3">                        
            <div class="tile tile-primary"> 
                <div class="col-xs-4 resize">
                    <span class="fa fa-calendar"></span>
                    <p><?php echo date('d M') ?></p>
                </div>
                <div class="col-xs-8 resize">
                    <?php echo $totaltoday[0]['today']; ?>
                    <p>Order Today</p>
                </div>
            </div>                        
        </div>
        <div class="col-md-3">                        
            <div class="tile tile-info">
                <div class="col-xs-4 resize">
                    <span class="fa fa-calendar"></span>
                    <p><?php echo date('M') ?></p>
                </div>
                <div class="col-xs-8 resize">
                    <?php echo $totalmonth[0]['month']; ?>
                    <p>Order This Month</p>
                </div>
            </div>                        
        </div>
        <div class="col-md-3">                        
            <div class="tile tile-danger">
                <div class="col-xs-4 resize">
                    <span class="fa fa-calendar"></span>
                    <p><?php echo date("M", strtotime("-1 months")); ?></p>
                </div>
                <div class="col-xs-8 resize">
                    <?php echo $totallast[0]['last']; ?>
                    <p>Order Last Month</p>
                </div>
            </div>                        
        </div>
        <div class="col-md-3">                        
            <div class="tile tile-success">
                <div class="col-xs-4 resize">
                    <span class="fa fa-calendar"></span>
                    <p><?php echo date('Y'); ?></p>
                </div>
                <div class="col-xs-8 resize">
                    <?php echo $totalyear[0]['year']; ?>
                    <p>Order This Year</p>
                </div>
            </div>                        
        </div>
    </div>

<!-- Test -->
        <div class="col-md-12">
            <!-- START DEFAULT DATATABLE -->
            <div class="panel panel-default">
                <div class="panel-heading">                                
                    <h3 class="panel-title">Detail income</h3>
                    <ul class="panel-controls">
                        <li>
                            <div id="reportrange" class="dtrange">                                            
                                <span></span><b class="caret"></b>
                            </div> 
                        </li>
                        <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                        <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                        <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                    </ul>                                
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="example">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>Sales</th>
                                    <th>Store</th>
                                    <th>Address</th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <!-- END DEFAULT DATATABLE -->
        </div>
        <!-- End Test -->
</div>
<!-- END PAGE CONTENT WRAPPER -->
