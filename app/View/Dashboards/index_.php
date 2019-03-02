<?php echo $this->start("script");?>
<script type="text/javascript" src="<?php echo $this->webroot?>js/plugins/morris/raphael-min.js"></script>
<script type="text/javascript" src="<?php echo $this->webroot?>js/plugins/morris/morris.min.js"></script>
<script type="text/javascript" src="<?php echo $this->webroot?>js/date.js"></script>
<script>
/* Line dashboard chart */
    Morris.Line({
      element: 'dashboard-line-1',
      data: [
        <?php foreach ($dataChart as $key):?>
            {
                y:'<?php echo $key[0]['tanggal']; ?>',
                a:<?php echo $key[0]['gelas']; ?>,
                b:<?php echo $key[0]['galon']; ?>
            },
        <?php endforeach ?>
      ],
      xkey: 'y',
      ykeys: ['a','b'],
      labels: ['Glass','Galon'],
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
    /* EMD Line dashboard chart */

    /* Donut dashboard chart */
    Morris.Donut({
        element: 'dashboard-donut',
        data: [
        <?php foreach ($dataComp as $dcKey): ?>
            {
                label:"<?php echo $dcKey['CompetitorProducts']['name']; ?>",
                value:"<?php echo $dcKey[0]['total']; ?>"
            },
        <?php endforeach ?>
        ],
        colors: ['#33414E', '#3FBAE4', '#FEA223','#ed00e5','#ed0003','#fceb00','#45f400','#3c423f','#6d39c6','#ce6d54'],
        resize: true
    });
    /* END Donut dashboard chart */

    /* Google Maps */
    $(document).ready(function(){

        /* Google maps */
		
		
		
		
        if($("#google_ptm_map").length > 0){
            var gPTMCords = new google.maps.LatLng(-6.220652, 106.848377);
            var gPTMOptions = {zoom: 11,center: gPTMCords, mapTypeId: google.maps.MapTypeId.ROADMAP}    
            var gPTM = new google.maps.Map(document.getElementById("google_ptm_map"), gPTMOptions);        

            var cords; 
            var marker;
            var infowindow
            var infowindow = new google.maps.InfoWindow();

            <?php foreach ($dataStore as $dskey): ?>
                cords   = new google.maps.LatLng(<?php echo $dskey['stores']['latitude']; ?>, <?php echo $dskey['stores']['longitude']; ?>);
                marker  = new google.maps.Marker({
                    position: cords, 
                    map: gPTM, 
                    icon: '<?php echo $this->webroot?>'+'img/ic_store_web.png',
                    title: "<?php echo $dskey['stores']['name']; ?>"
                });
                var content = "<h2><?php echo $dskey['stores']['name']; ?></h2>";
                google.maps.event.addListener(marker,'click', (function(marker,content,infowindow){ 
                    return function() {
                        infowindow.setContent(content);
                        infowindow.open(gPTM,marker);
                    };
                })(marker,content,infowindow)); 
            <?php endforeach ?>
        }

    });

</script>

<!-- START THIS PAGE PLUGINS-->        
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places&key=AIzaSyCuxq4uAyTN0l6jV9fdaH_0hUK9zbn3CKE"></script>

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
</style>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="javascript:void(0);">Home</a></li>
    <li class="active">Dashboard</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE TITLE -->
<div class="page-title">
    <h2><span class="fa fa-desktop"></span> <?php echo Inflector::humanize(Inflector::underscore($ControllerName))?></h2>
</div>
<!-- END PAGE TITLE -->

<!-- START PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <!-- HEADER -->
    <div class="row">
    	<!-- PANEL -->
    	<div class="col-md-3">
            <div class="widget widget-success widget-item-icon">
                <div class="widget-item-left">
                    <span class="fa fa-user"></span>
                </div>
                <!-- <div class="widget-data">
                    <div class="widget-title">
                        Target
                    </div>
                    <div class="widget-subtitle">
                        this month
                    </div>
                    <?php if (!empty($datatarget['Target']['target'])): ?>
                        <div class="widget-int num-count" id="salesactive">
                            <?php 
                                $totalOrder = $datatarget['Target']['target'];
                                $lenS   =   strlen($totalOrder); 
                                if ($lenS <= 6) {
                                    $totalOrderToday    =   number_format($totalOrder,0,',','.');
                                }elseif ($lenS < 10) {
                                    $bagiS  =   $totalOrder/1000000;
                                    $fixS   =   floor($bagiS);
                                    $totalOrderToday    =   $fixS." Jt";
                                }else{
                                    $bagiS  =   $totalOrder/1000000000;
                                    $fixS   =   round($bagiS, 1);
                                    $totalOrderToday    =   $fixS." M";
                                }
                                echo 'Rp. '.$totalOrderToday;
                            ?>
                        </div>
                    <?php else: ?>
                        <div class="widget-int num-count" id="salesactive" style="cursor:pointer" onclick="location.href='<?php echo $settings['cms_url'] ?>Targets'">
                            Not Set
                        </div>
                    <?php endif ?>
                </div> -->
                <div class="widget-data">
                    <div class="widget-int num-count" id="salesactive">
                        <?php echo $data; ?>        
                    </div>
                    <div class="widget-title">
                        Active Sales
                    </div>
                    <!-- <div class="widget-subtitle">
                        this month
                    </div> -->
                </div>
                <div class="widget-controls">                                
                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget">
                    	<span class="fa fa-times"></span>
                    </a>
                </div>                            
            </div>
        </div>
        <!-- /PANEL -->
        
        <!-- PANEL -->
        <div class="col-md-3">
            <div class="widget widget-danger widget-item-icon" style="cursor:pointer" onclick="location.href='<?php echo $settings['cms_url'] ?>Dashboards/ReportOrder'">
                <div class="widget-item-left">
                    <span class="fa fa-shopping-cart"></span>
                </div>
                </a>
                <div class="widget-data">
                    <div class="widget-int num-count">
                    	<?php echo $dataOr; ?>
                    </div>
                    <div class="widget-title">
                    	Order
                    </div>
                    <div class="widget-subtitle">
                    	at this month
                    </div>
                </div>
                <div class="widget-controls">                                
                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget">
                    	<span class="fa fa-times"></span>
                    </a>
                </div>
            </div>
        </div>
        <!-- /PANEL -->
        
        <!-- PANEL -->
        <div class="col-md-3">
        	<div class="widget widget-primary">
                <div class="widget-title">TOTAL</div>
                <div class="widget-subtitle"><?php echo date('F')." ".date('Y'); ?></div>
                <a href="">
                    <div class="widget-int">Rp <span data-toggle="counter" data-to="1564">
                    	<?php 
                            echo $convTotal;
                        ?></span>
                    </div>
                </a>
                <div class="widget-controls">                                
                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget">
                    	<span class="fa fa-times"></span>
                    </a>
                </div>
            </div>
        </div>
        <!-- /PANEL -->
        
        <!-- PANEL -->
        <div class="col-md-3">
            <div class="widget widget-info widget-padding-sm">                            
                <div class="widget-item-left">
                	<input class="knob" data-width="100" data-height="100" data-min="0" data-max="100" data-displayInput=false data-bgColor="#d6f4ff" data-fgColor="#FFF" value="<?php echo $persenTarget ?>%" data-readOnly="true" data-thickness=".2"/>
                </div>
                <div class="widget-data">
                    <div class="widget-subtitle">
                        Target this month
                    </div>
                    <div class="widget-big-int">
                    	<span class="num-count"><?php echo round($persenTarget); ?></span>%
                    </div>
                    <!-- <div class="widget-subtitle">
                        from
                    </div> -->
                    <div class="widget-title" style="font-size:12px;">
                        From: 
                    	<?php 
                                $totalOrder = $datatarget['Target']['target'];
                                $lenS   =   strlen($totalOrder); 
                                if ($lenS <= 6) {
                                    $totalOrderToday    =   number_format($totalOrder,0,',','.');
                                }elseif ($lenS < 10) {
                                    $bagiS  =   $totalOrder/1000000;
                                    $fixS   =   floor($bagiS);
                                    $totalOrderToday    =   $fixS." Jt";
                                }else{
                                    $bagiS  =   $totalOrder/1000000000;
                                    $fixS   =   round($bagiS, 1);
                                    $totalOrderToday    =   $fixS." M";
                                }
                                echo 'Rp. '.$totalOrderToday;
                            ?>
                    </div>
                </div>                            
                <div class="widget-controls">                                
                	<a href="#" class="widget-control-right">
                    	<span class="fa fa-times"></span>
                    </a>
                </div>
            </div>
        </div>
        <!-- /PANEL -->
    </div>
    <!-- /HEADER -->
    
    <!-- STATISTIC -->
    <div class="row">
    	<div class="col-md-4">
        	<!-- START PROJECTS BLOCK -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title-box">
                        <h3>Schedule</h3>
                        <span>Today activity</span>
                    </div>                                    
                    <ul class="panel-controls" style="margin-top: 2px;">
                        <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>                                        
                            <ul class="dropdown-menu">
                                <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> Collapse</a></li>
                                <li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Remove</a></li>
                            </ul>                                        
                        </li>                                        
                    </ul>
                </div>
                <div class="panel-body panel-body-table">
                    
                    <div class="table-responsive" style="height:230px;overflow-y:auto;">
                        <?php if(!empty($dataSchedules)):?>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="30%">Sales</th>
                                    <th width="30%">Income</th>
                                    <th width="40%">Target</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dataSchedules as $dataSchedules):?>
                                <tr>
                                    <td><strong><?php echo $dataSchedules['Users']['firstname']; ?></strong></td>
                                    <td>Rp. <?php echo number_format($dataSchedules["Income"]["totalOrder"]); ?></td>
                                    <td>
                                        <div class="col-md-8" style="padding: 0px; margin-right: 5px;">
                                            <div class="progress progress-small progress-striped active">
                                                <div class="<?php echo $dataSchedules["Income"]["bar"]; ?>" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $dataSchedules["Income"]["percent"]."%"; ?>;">
                                                </div>
                                            </div>
                                        </div>
                                        <?php echo  $dataSchedules["Income"]["percent"]."%"; ?>
                                    </td>
                                </tr>
                               <?php endforeach ?>
                            </tbody>
                        </table>
                        <?php else:?>
                            <div class="col-md-12" style="margin-top:10px;">
                                <div class="alert alert-danger" role="alert">
                                    <?php echo __('No schedule available')?>
                                </div>
                            </div>
                        <?php endif ?>
                    </div>
                    
                </div>
            </div>
            <!-- END PROJECTS BLOCK -->
        </div>
        <div class="col-md-4">
            <!-- CONTACTS WITH CONTROLS -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title-box">
                        <h3>Top Sales</h3>
                        <span>This month</span>
                    </div>
                    <ul class="panel-controls" style="margin-top: 2px;">
                        <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>                                        
                            <ul class="dropdown-menu">
                                <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> Collapse</a></li>
                                <li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Remove</a></li>
                            </ul>                                        
                        </li>                                        
                    </ul>        
                </div>
                <div class="panel-body panel-body-table">
                    
                    <div class="table-responsive" style="height:230px;overflow-y:auto;">
                        <?php if(!empty($dataTop)):?>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="60%">Sales</th>
                                    <th width="30%">Income</th>
                                    <th width="10%">Rank</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 0; ?>
                                <?php foreach ($dataTop as $keyTop): ?>
                                    <?php $no++; ?>
                                <tr>
                                    <td>
                                        <?php 
                                            if(!empty($keyTop['contents']['url'])) {
                                                $img = $keyTop['contents']['url'];
                                            }else{
                                                $img = "img/default_avatar.jpg";
                                            }
                                         ?>
                                        <a href="<?php echo $settings['cms_url']."Sales";?>/Detail/<?php echo $keyTop['User']["id"]?>">
                                            <img src="<?php echo $this->webroot; echo $img; ?>" class="img-circle"/>
                                        </a>
                                        <span class="contacts-title">
                                            <?php echo $keyTop['User']['firstname']; ?>        
                                        </span>
                                    </td>
                                    <td>
                                        <p>
                                            <?php
                                                $angka = $keyTop[0]['Subtotal'];
                                                echo "Rp. ".number_format($angka,0,',','.');
                                            ?>
                                        </p>
                                    </td>
                                    <?php 
                                        if ($no == 1) {
                                            $btn = "btn btn-success btn-rounded";
                                        }elseif ($no == 2) {
                                            $btn = "btn btn-warning btn-rounded";
                                        }elseif ($no == 3) {
                                            $btn = "btn btn-info btn-rounded";
                                        }else{
                                            $btn = "btn btn-default btn-rounded";
                                        }
                                    ?>
                                    <td>
                                        <a href="<?php echo $settings['cms_url']."Sales";?>/Detail/<?php echo $keyTop['User']["id"]?>">
                                            <button class="<?php echo $btn; ?>">
                                                <?php echo $no; ?>
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                        <?php else:?>
                            <div class="col-md-12" style="margin-top:10px;">
                                <div class="alert alert-danger" role="alert">
                                    <?php echo __('No data this month')?>
                                </div>
                            </div>
                        <?php endif ?>
                    </div>
                    
                </div>
            </div>
            <!-- END CONTACTS WITH CONTROLS -->
        </div>

        <div class="col-md-4">

            <!-- START VISITORS BLOCK -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title-box">
                        <h3>Competitors</h3>
                        <span>This month</span>
                    </div>
                    <ul class="panel-controls" style="margin-top: 2px;">
                        <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>                                        
                            <ul class="dropdown-menu">
                                <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> Collapse</a></li>
                                <li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Remove</a></li>
                            </ul>                                        
                        </li>                                        
                    </ul>
                </div>
                <?php if (!empty($dataComp)): ?>
                    <div class="panel-body padding-0">
                        <div class="chart-holder" id="dashboard-donut" style="height: 230px;"></div>
                    </div> 
                <?php else: ?>   
                    <div class="chart-holder" id="dashboard-donut" style="height: 285px;">
                        <div class="col-md-12" style="margin-top:10px;">
                            <div class="alert alert-danger" role="alert">
                                <?php echo __('No data available')?>
                            </div>
                        </div>
                    </div>
                <?php endif ?>
            </div>
            <!-- END VISITORS BLOCK -->

        </div>

        <div class="col-md-6">                        
            <!-- START GOOGLE MAP WITH MARKER -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title-box">
                        <h3>Store that ordered in</h3>
                        <span><?php echo date('F')." ".date('Y'); ?></span>
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
                <div class="panel-body panel-body-map">
                    <div id="google_ptm_map" style="height: 260px;"></div>
                </div>
            </div>
            <!-- END GOOGLE MAP WITH MARKER -->
        </div>

        <div class="col-md-6">
            <!-- START SALES & EVENTS BLOCK -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title-box">
                        <h3>Sales this month</h3>
                        <span><?php echo date('F')." ".date('Y'); ?></span>
                    </div>
                    <ul class="panel-controls" style="margin-top: 2px;">
                        <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>                                        
                            <ul class="dropdown-menu">
                                <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> Collapse</a></li>
                                <li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Remove</a></li>
                            </ul>                                        
                        </li>                                        
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
                                <?php echo __('No sales available')?>
                            </div>
                        </div>
                    </div>
            <?php endif ?>
            </div>
            <!-- END SALES & EVENTS BLOCK -->
        </div>


    </div>
    <!-- STATISTIC -->
</div>
<!-- END PAGE CONTENT WRAPPER -->
