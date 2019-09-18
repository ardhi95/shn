<!-- START BREADCRUMB -->
<ul class="breadcrumb push-down-0">
    <li>
    	<a href="<?php echo $settings['cms_url'].$ControllerName?>">
			<?php echo Inflector::humanize(Inflector::underscore($ControllerName))?>
       	</a>
    </li>
    <li class="active"><?php echo __('Detail Order')?></li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE TITLE -->
<div class="content-frame">
    <div class="content-frame-top">
        <div class="page-title">
            <h2><span class="fa fa-th-large"></span>
			<?php echo "#".$detail["Order"]["order_no"]?></h2>
        </div>
    </div>
</div>
<!-- END PAGE TITLE -->

<!-- START PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <div class="row">
    	<div class="col-md-7">
        	<div class="panel panel-primary">
                <div class="panel-body">
                	<h3><span class="fa fa-shopping-cart"></span> Data Order</h3>
                </div>
                <div class="panel-body form-group-separated">
                	<form action="#" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-md-4 col-xs-5 control-label">Order No</label>
                            <div class="col-md-8 col-xs-7 line-height-30"><?php echo $detail["Order"]["order_no"]?></div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 col-xs-5 control-label">Studio Name</label>
                            <div class="col-md-8 col-xs-7 line-height-30">
								<?php echo $detail["Studio"]["title"]?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 col-xs-5 control-label">Book Date</label>
                            <div class="col-md-8 col-xs-7 line-height-30">
								<?php echo date("l, d F Y",strtotime($detail["Order"]["created"]));
							   ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 col-xs-5 control-label">Play Date</label>
                            <div class="col-md-8 col-xs-7 line-height-30">
								<?php echo date("l, d F Y",strtotime($detail["Order"]["start_date"]));
							   ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 col-xs-5 control-label">Play Time</label>
                            <div class="col-md-8 col-xs-7 line-height-30">
								<?php echo date("H:i",strtotime($detail["Order"]["start_date"]))." - ".date("H:i",strtotime($detail["Order"]["end_date"]));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 col-xs-5 control-label">Duration</label>
                            <div class="col-md-8 col-xs-7 line-height-30">
								 <?php echo number_format($detail["Order"]["duration"],0)." Hour"?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 col-xs-5 control-label">Quantity</label>
                            <div class="col-md-8 col-xs-7 line-height-30">
								 <?php
                                 	if($detail["StudioPrice"]["unit_id"] == "2")
									{
										echo number_format($detail["Order"]["quantity"],0)." ".$detail["StudioPrice"]["Unit"]["name"]." (".$detail["StudioPrice"]["quantity"]." hour)";
									}
									else if($detail["StudioPrice"]["unit_id"] == "4")
									{
										echo number_format($detail["Order"]["quantity"],0)." ".$detail["StudioPrice"]["Unit"]["name"]." (".$detail["StudioPrice"]["quantity"]." shift)";
									}
									else
									{
										echo number_format($detail["Order"]["quantity"],0)." ".$detail["StudioPrice"]["Unit"]["name"];
									}
								 ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 col-xs-5 control-label">Booking Name</label>
                            <div class="col-md-8 col-xs-7 line-height-30">
								 <?php echo $detail["Order"]["booking_name"]?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 col-xs-5 control-label">Package</label>
                            <div class="col-md-8 col-xs-7 line-height-30">
								 <?php
                                 	if($detail["StudioPrice"]["unit_id"] == "2")
									{
										echo $detail["StudioPrice"]["Service"]["name"]." @Rp ".number_format($detail["StudioPrice"]["price"],0)."/".$detail["StudioPrice"]["Unit"]["name"]." (".$detail["StudioPrice"]["quantity"]." hour)";
									}
									else if($detail["StudioPrice"]["unit_id"] == "4")
									{
										echo $detail["StudioPrice"]["Service"]["name"]." @Rp ".number_format($detail["StudioPrice"]["price"],0)."/".$detail["StudioPrice"]["Unit"]["name"]." (".$detail["StudioPrice"]["quantity"]." shift)";
									}
									else
									{
										echo $detail["StudioPrice"]["Service"]["name"]." @Rp ".number_format($detail["StudioPrice"]["price"],0)."/".$detail["StudioPrice"]["Unit"]["name"];
									}
								 ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-5">
        	<div class="panel panel-primary">
                <div class="panel-body">
                	<h3><span class="fa fa-tag"></span> Price Info</h3>
                </div>
                <div class="panel-body form-group-separated">
                	<form action="#" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-md-4 col-xs-5 control-label">Subtotal</label>
                            <div class="col-md-8 col-xs-7 line-height-30">
								 <?php echo "Rp ".number_format($detail["Order"]["subtotal"],0)?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 col-xs-5 control-label">PPN 10%</label>
                            <div class="col-md-8 col-xs-7 line-height-30">
								 <?php echo "Rp ".number_format($detail["Order"]["tax"],0)?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 col-xs-5 control-label" style="font-weight:bold;">TOTAL</label>
                            <div class="col-md-8 col-xs-7 line-height-30" style="font-weight:bold;">
								 <?php echo "Rp ".number_format($detail["Order"]["total"],0)?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 col-xs-5 control-label">Status</label>
                            <div class="col-md-8 col-xs-7 line-height-30">
                            	
                            	<a href="<?php echo $settings['cms_url']?>PaymentConfirmations/Edit/<?php echo $PaymentConfirmation["PaymentConfirmation"]["id"]?>" class="btn btn-<?php echo $detail["OrderStatus"]["label_class"]?>">
									<?php echo $detail["OrderStatus"]["name2"]?>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            
            
        	<div class="panel panel-primary">
                <div class="panel-body">
                	<h3><span class="fa fa-user"></span> User Information</h3>
                </div>
                <div class="panel-body form-group-separated">
                	<form action="#" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-md-4 col-xs-5 control-label">Name</label>
                            <div class="col-md-8 col-xs-7 line-height-30">
								<?php echo $detail["User"]["fullname"]?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 col-xs-5 control-label">Email</label>
                            <div class="col-md-8 col-xs-7 line-height-30">
								<?php echo $detail["User"]["email"]?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- START PAGE CONTENT WRAPPER -->