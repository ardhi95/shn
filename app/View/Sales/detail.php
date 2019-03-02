<?php $this->start("script");?>
<script type="text/javascript" src="<?php echo $this->webroot?>js/plugins/jquery/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $this->webroot?>js/jquery-prettyPhoto.js"></script>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/plugins/moment.min.js"></script>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/plugins/bootstrap/bootstrap-file-input.js"></script>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/plugins/morris/raphael-min.js"></script>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/plugins/morris/morris.min.js"></script>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/date.js"></script>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/plugins/cropper/cropper.min.js"></script>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/lang/<?php echo Configure::read('Config.language')?>/demo_edit_profile.js"></script>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/DataTables/Buttons/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/jquery-prettyPhoto.js"></script>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/plugins/daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/plugins/datatables/jquery.dataTables.min.js"></script>
<script>
  var cords; 
  var marker;
  var morrisLine;
  /*===== SET FIRST MORRIS LINE CHART =====*/
  
  var last30    = moment().subtract('days', 29).format('YYYY-MM-DD');
  var today     = moment().format('YYYY-MM-DD');
  /*Get data from json*/
  var jsonfunc = (function () {
    var json = null;
    $.ajax({
      'async': false,
      'global': false,
      'url': '<?php echo $settings["cms_url"]?>Api/SelesChartData?token=e56d867b3506917898f348720130b55d&firstdate='+last30+'&enddate='+today+'&user_id=<?php echo $ID; ?>',
      'dataType': "json",
      'success': function (data) {
        json = data;
      }
    });
    return json;
  })();

  /*Set data morris*/

  /*===== END SET FIRST MORRIS LINE CHART =====*/

  /*===== SET DATA TABLES =====*/
  var jsontable = (function () {
    var json = null;
    $.ajax({
      'async': false,
      'global': false,
      'url': '<?php echo $settings["cms_url"]?>Api/GetDetailIncome?token=e56d867b3506917898f348720130b55d&firstdate='+last30+'&enddate='+today+'&user_id=<?php echo $ID; ?>',
      'dataType': "json",
      'success': function (data) {
        json = data;
      }
    });
    return json;
  })();
  /*===== END SET DATA TABLES =====*/

  /*===== SET TRACKING SALES =====*/
  function myMap() {
    var lat;
    var long;
    
    var dtlating = '<?php echo $detail['User']['current_latitude']; ?>';

    if(dtlating !== null && dtlating !== '') {
      lat = '<?php echo $detail['User']['current_latitude']; ?>';
      long = '<?php echo $detail['User']['current_longitude']; ?>';  
    }else{
      lat = -6.175520;
      long = 106.827153;
    }  

    var mapOptions = {
      center: new google.maps.LatLng(lat, long),
      zoom: 18
    }
    
    var map = new google.maps.Map(document.getElementById("map"), mapOptions);
    cords   = new google.maps.LatLng(lat,long);
    marker  = new google.maps.Marker({
      position: cords, 
      map: map,
      icon: '<?php echo $this->webroot?>'+'img/pin.png'
    });

    setInterval(function() {
      $.getJSON("<?php echo $settings["cms_url"]?>Api/GetLocation?token=e56d867b3506917898f348720130b55d&user_id=<?php echo $ID; ?>",function(json){
        var latitude    = json.latitude;
        var longitude   = json.longitude;

        var mapLatlng   =   new google.maps.LatLng(latitude, longitude);
        marker.setPosition(mapLatlng);   
        map.setCenter(mapLatlng);
      })
    },5000);
  }

  /*===== END SET TRACKING SALES =====*/

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
      $("#dashboard-line-1").html("");
      var stdate  =   start.format('YYYY-MM-DD');
      var endate  =   end.format('YYYY-MM-DD');
      initMorris();

      var jsonfunc = (function () {
        var json = null;
        $.ajax({
          'async': false,
          'global': false,
          'url': '<?php echo $settings["cms_url"]?>Api/SelesChartData?token=e56d867b3506917898f348720130b55d&firstdate='+stdate+'&enddate='+endate+'&user_id=<?php echo $ID; ?>',
          'dataType': "json",
          'success': function (data) {
            json = data;
          }
        });
        return json;
      })();

      
      if(jsonfunc.data){
        setMorris(jsonfunc.data);
      }else{
        $("#dashboard-line-1").innerHTML = Date();
      }

      $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    });

      $("#reportrange span").html(moment().subtract('days', 29).format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
    }
    /* end reportrange */

    /* reportrange */
    if($("#reportrangeTable").length > 0){   
      $("#reportrangeTable").daterangepicker({                    
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
      /**/
      var stdate  =   start.format('YYYY-MM-DD');
      var endate  =   end.format('YYYY-MM-DD');

      var jsontable = (function () {
        var json = null;
        $.ajax({
          'async': false,
          'global': false,
          'url': '<?php echo $settings["cms_url"]?>Api/GetDetailIncome?token=e56d867b3506917898f348720130b55d&firstdate='+stdate+'&enddate='+endate+'&user_id=<?php echo $ID; ?>',
          'dataType': "json",
          'success': function (data) {
            json = data;
          }
        });
        return json;
      })();

      var dbTable = $('#example').DataTable();
      dbTable.clear().rows.add(jsontable.data).draw();

      $('#reportrangeTable span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    });

      $("#reportrangeTable span").html(moment().subtract('days', 29).format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
    }
    /* end reportrange */

  });

  /*===== MORRIS CHART FUNCTION =====*/
  function initMorris() {
    morrisLine = Morris.Line({
      element: 'dashboard-line-1',
      xkey: 'y',
      ykeys: ['a'],
      labels: ['Income'],
      resize: true,
      hideHover: true,
      xLabels: 'day',
      gridTextSize: '10px',
      lineColors: ['#3FBAE4','#33414E'],
      gridLineColor: '#E5E5E5',
      xLabelFormat:function(x)
      {
        var mydate = new Date(x.toString());
        var str = mydate.toString("dd MMM");
        return str;
      }
    });
  }

  /*SET DATA MORRIS FUNCTION*/
  function setMorris(data) {
    morrisLine.setData(data);
  }

  /*initDataTables(jsontable.data);*/
  /*=====END MORRIS CHART FUNCTION =====*/
  initDataTables(jsontable.data);
  function initDataTables(data) {
        // body...
        $('#example').DataTable({
          "aLengthMenu": [[5, 10, 50, 100, 500, -1], [5, 10, 50, 100, 500, "All"]],
          "iDisplayLength": 5,
          "aaData": data,
          "aoColumns": [
          { "mDataProp": "no" },
          { "mDataProp": "orderId" },
          { "mDataProp": "stores" },
          { "mDataProp": "address" },
          { "mDataProp": "date" },
          { "mDataProp": "income" }
          ]
        });
      }

    </script>

    <script type="text/javascript">
      $(document).ready(function(){
        initMorris();
        setMorris(jsonfunc.data);
        $('a[rel^="lightbox"]').prettyPhoto({
            // any configuration options as per the online documentation.
          });
      });
    </script>
    
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCuxq4uAyTN0l6jV9fdaH_0hUK9zbn3CKE&callback=myMap"></script>
    <!-- <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places&key=AIzaSyCV4QFXiixx190iTfXWeDPSuvnEaHHxsE8"></script> -->
    <?php $this->end()?>

    <?php $this->start("css");?>
    <link rel="stylesheet" type="text/css" id="theme" href="<?php echo $this->webroot?>css/theme-default.css"/>
    <link rel="stylesheet" type="text/css" id="theme" href="<?php echo $this->webroot?>css/prettyPhoto.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->webroot?>css/cropper/cropper.min.css"/>
    <?php $this->end()?>
    <!-- MODALS -->
    <div class="modal animated fadeIn" id="modal_change_photo" tabindex="-1" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
             <span aria-hidden="true">&times;</span>
             <span class="sr-only"><?php echo __('Close')?></span>
           </button>
           <h4 class="modal-title" id="smallModalHead"><?php echo __('Change photo')?></h4>
         </div>
         <form id="cp_crop" method="post" action="<?php echo $settings['cms_url'].$ControllerName?>/CropImage/<?php echo $ID?>">
          <div class="modal-body">
            <div class="text-center" id="cp_target">
             <?php echo __('Only (*.gif,*.jpeg,*.jpg,*.png) are allowed.')?>
           </div>
           <input type="hidden" name="cp_img_path" id="cp_img_path"/>
           <input type="hidden" name="ic_x" id="ic_x"/>
           <input type="hidden" name="ic_y" id="ic_y"/>
           <input type="hidden" name="ic_w" id="ic_w"/>
           <input type="hidden" name="ic_h" id="ic_h"/>
         </div>
       </form>
       <form id="cp_upload" method="post" enctype="multipart/form-data" action="<?php echo $settings['cms_url'].$ControllerName?>/UploadProfileImage/<?php echo $ID?>" >
        <div class="modal-body form-horizontal form-group-separated">
          <div class="form-group">
            <label class="col-md-4 control-label"><?php echo __('New Photo')?></label>
            <div class="col-md-4">
              <input type="file" class="fileinput btn-info" name="data[<?php echo $ModelName?>][images]" id="cp_photo" data-filename-placement="inside" title="<?php echo __('Select file')?>" accept="image/*"/>
            </div>
          </div>
        </div>
      </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-success disabled" id="cp_accept"><?php echo __('Accept')?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close')?></button>
      </div>
    </div>
  </div>
</div>

<!-- START BREADCRUMB -->
<ul class="breadcrumb push-down-0">
  <li>
   <a href="<?php echo $settings["cms_url"].$ControllerName?>">
    <?php echo Inflector::humanize(Inflector::underscore($ControllerName))?></a>
  </li>
  <li class="active"><?php echo __('View Data')?></li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE TITLE -->
<div class="content-frame">
  <div class="content-frame-top">
    <div class="page-title">
      <h2>
       <span class="fa fa-th-large"></span>
       <?php echo __('View Data')?> : <?php echo $detail[$ModelName]['fullname']?>
     </h2>
   </div>
   <div class="pull-right">
    <a href="<?php echo $settings['cms_url'].$ControllerName."/Index/".$page."/".$viewpage?>" class="btn btn-danger">
      <i class="fa fa-bars"></i> <?php echo __('List Data')?>
    </a>
  </div>
</div>
</div>
<!-- END PAGE TITLE -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

  <div class="row">
   <div class="col-md-12">
     <?php
     echo $this->Session->flash();
     ?>
   </div>
   <div class="col-md-4">

    <form action="#" class="form-horizontal">
      <div class="panel panel-default">
        <div class="panel-body" style="min-height: 290px;">
          <h3><span class="fa fa-user"></span> <?php echo $detail["User"]["fullname"];?></h3>
          <p><?php echo $detail["MyAro"]["alias"];?></p>
          <div class="text-center" id="user_image">
           <?php if(!empty($detail["Thumbnail"]["id"])):?>
            <a rel="lightbox" title="<?php echo $detail[$ModelName]['fullname'] ?>" href="<?php echo $detail["MaxWidth"]["host"].$detail["MaxWidth"]["url"]?>?time=<?php echo time()?>" style="border:0px;">
              <img src="<?php echo $detail["Thumbnail"]["host"].$detail["Thumbnail"]["url"]?>?time=<?php echo time()?>" width="200" height="200" class="img-thumbnail"/>
            </a>
          <?php else:?>
            <img src="<?php echo $this->webroot?>img/default_avatar.jpg" width="200" height="200" class="img-thumbnail"/>
          <?php endif;?>
        </div>
      </div>
    </div>
  </form>
</div>

<div class="col-md-4">
  <div class="panel panel-default form-horizontal">
    <div class="panel-body">
      <div class="col-md-6">
       <h3><span class="fa fa-pencil"></span> <?php echo __('Profile')?></h3>
     </div>
     <div class="col-md-6">
       <?php 
       $getstatus = $detail[$ModelName]['status'];
       if ($getstatus == 1) {
         $status 	= 	'Active';
         $btnStatus	=	'btn btn-success btn-rounded';
       }else{
         $status 	=	'Not Active';
         $btnStatus	=	'btn btn-danger btn-rounded';
       }
       ?>
       <div class="pull-right">
        <button class='<?php echo $btnStatus; ?>'>
         <?php echo $status; ?>
       </button>
     </div>
   </div>
 </div>
 <div class="panel-body form-group-separated" style="min-height: 230px;">
  <div class="form-group">
    <label class="col-md-4 col-xs-5 control-label"><?php echo __('First Name')?></label>
    <div class="col-md-8 col-xs-7 line-height-30">
     <?php echo $detail['User']['firstname']; ?>
   </div>
 </div>
 <div class="form-group">
  <label class="col-md-4 col-xs-5 control-label"><?php echo __('Last Name')?></label>
  <div class="col-md-8 col-xs-7 line-height-30">
   <?php
   echo $detail['User']['lastname'];
   ?>
 </div>
</div>
<div class="form-group">
  <label class="col-md-4 col-xs-5 control-label"><?php echo __('Email')?></label>
  <div class="col-md-8 col-xs-7 line-height-30">
   <?php echo $detail['User']["email"];?>
 </div>
</div>
<div class="form-group">
  <label class="col-md-4 col-xs-5 control-label"><?php echo __('Password')?></label>
  <div class="col-md-8 col-xs-7 line-height-30">
   <?php echo $detail['User']["password"];?>
 </div>
</div>
</div>
</div>
</div>
<div class="col-md-4">
  <div class="panel panel-default form-horizontal">
    <div class="panel-body">
      <h3><span class="fa fa-truck"></span> <?php echo __('Summary')?></h3>
    </div>
    <div class="panel-body form-group-separated" style="min-height: 230px;">
      <div class="form-group">
        <label class="col-md-6 col-xs-5 control-label"><?php echo __('Total Order')?></label>
        <div class="col-md-6 col-xs-7 line-height-30">
         <?php echo $dataTotal[0][0]['Total_order']; ?>
       </div>
     </div>
     <div class="form-group">
      <label class="col-md-6 col-xs-5 control-label"><?php echo __('Total Checkin')?></label>
      <div class="col-md-6 col-xs-7 line-height-30">
       <?php
       echo $dataCheck[0][0]['Total_checkin'];
       ?>
     </div>
   </div>
   <div class="form-group">
    <label class="col-md-6 col-xs-5 control-label"><?php echo __('Total Add Store')?></label>
    <div class="col-md-6 col-xs-7 line-height-30">
     <?php echo $dataAdd[0][0]['Total_add'];?>
   </div>
 </div>
 <div class="form-group">
  <label class="col-md-6 col-xs-5 control-label"><?php echo __('Total income')?></label>
  <div class="col-md-6 col-xs-7 line-height-30">
    <?php
    $angka = $dataTotal[0][0]['Total_income'];
    echo "Rp. ".number_format($angka,0,',','.');
    ?>
  </div>
</div>
</div>
</div>
</div>
<!-- Sales Chart -->

<div class="col-md-12">
  <!-- START SALES & EVENTS BLOCK -->
  <div class="panel panel-default">
    <div class="panel-heading">
      <div class="panel-title-box">
        <h3>Income</h3>
      </div>
      <ul class="panel-controls panel-controls-title">                                        
        <li>
          <div id="reportrange" class="dtrange">                                            
            <span></span><b class="caret"></b>
          </div>                                     
        </li>                                
        <li><a href="#" class="panel-fullscreen rounded"><span class="fa fa-expand"></span></a></li>
      </ul>
    </div>
    <?php if(!empty($dataChart)):?>
      <div class="panel-body padding-0">
        <div class="chart-holder" id="dashboard-line-1" style="height: 270px;">
        </div>
      </div>
    <?php else:?>
      <div class="chart-holder" id="dashboard-line-1" style="height: 1px;">
        <div class="col-md-12" style="margin-top:10px; height: 260px;">
          <div class="alert alert-danger" role="alert">
            <?php echo __('No data available')?>
          </div>
        </div>
      </div>
    <?php endif ?>
  </div>
  <!-- END SALES & EVENTS BLOCK -->
</div>

<!-- Test -->
<div class="col-md-12">
  <!-- START DEFAULT DATATABLE -->
  <div class="panel panel-default">
    <div class="panel-heading">                                
      <h3 class="panel-title">Detail income</h3>
      <ul class="panel-controls">
        <li>
          <div id="reportrangeTable" class="dtrange">                                            
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
        <table id="example" class="table table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Order ID</th>
              <th>Store</th>
              <th>Address</th>
              <th>Date</th>
              <th>Total Order</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>No</th>
              <th>Order ID</th>
              <th>Store</th>
              <th>Address</th>
              <th>Date</th>
              <th>Total Order</th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
  <!-- END DEFAULT DATATABLE -->
</div>
<!-- End Test -->

<div class="col-md-12">                        
  <!-- START GOOGLE MAP WITH MARKER -->
  <div class="panel panel-default">
    <div class="panel-heading">
      <div class="panel-title-box">
        <h3>Last location</h3>
      </div>
      <ul class="panel-controls" style="margin-top: 2px;">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>                                        
          <ul class="dropdown-menu">
            <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> Collapse</a></li>
            <li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Remove</a></li>
          </ul>                                        
        </li>                                        
      </ul>
    </div>
    <?php if (!empty($detail['User']['current_latitude'])): ?>
      <div class="panel-body panel-body-map">
        <div id="map" style="height: 260px;"></div>
      </div>
    <?php else:?>
      <div class="chart-holder" id="dashboard-line-1" style="height: 1px;">
        <div class="col-md-12" style="margin-top:10px; height: 260px;">
          <div class="alert alert-danger" role="alert">
            <?php echo __('No current location available')?>
          </div>
        </div>
      </div>
    <?php endif ?>
  </div>
  <!-- END GOOGLE MAP WITH MARKER -->
</div>

</div>
</div>
<!-- END PAGE CONTENT WRAPPER -->
