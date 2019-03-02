<!-- START BREADCRUMB -->
<ul class="breadcrumb push-down-0">
    <li>
    	<a href="<?php echo $settings['cms_url'].$ControllerName?>">
			<?php echo Inflector::humanize(Inflector::underscore($ControllerName))?>
       	</a>
    </li>
    <li class="active"><?php echo __('Detail Schedule')?></li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE TITLE -->
<div class="content-frame">
    <div class="content-frame-top">
        <div class="page-title">
            <h2><span class="fa fa-th-large"></span>
			<?php echo date("D, d M Y H:i",strtotime($detail[$ModelName]["schedule_date"]))?></h2>
        </div>
        <div class="pull-right">
            <a href="<?php echo $settings['cms_url'].$ControllerName?>" class="btn btn-primary">
                <i class="fa fa-bars"></i> <?php echo __('List Data')?>
            </a>
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
                	<h3><span class="glyphicon glyphicon-time"></span> Schedule</h3>
                </div>
                <div class="panel-body form-group-separated">
                	<form action="#" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-md-4 col-xs-5 control-label">Sales</label>
                            <div class="col-md-8 col-xs-7 line-height-30">
								<?php echo $detail["Sales"]["fullname"]?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 col-xs-5 control-label">Schedule Date</label>
                            <div class="col-md-8 col-xs-7 line-height-30">
								<?php echo date("D, d M Y H:i",strtotime($detail[$ModelName]["schedule_date"]))?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 col-xs-5 control-label">Store</label>
                            <div class="col-md-8 col-xs-7 line-height-30">
								<?php echo $this->General->IsEmptyVal($detail["Store"]['name'])?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 col-xs-5 control-label">
                            	Checkin Status
                            </label>
                            <div class="col-md-8 col-xs-7 line-height-30">
								<?php echo $this->General->CheckinStatus($detail["CheckinStatus"]['id'],$detail["CheckinStatus"]['name']) ?>
                            </div>
                        </div>
                        <?php if($detail[$ModelName]["checkin_status_id"] == "2"):?>
                        <div class="form-group">
                            <label class="col-md-4 col-xs-5 control-label">
                            	Checkin Date
                             </label>
                            <div class="col-md-8 col-xs-7 line-height-30">
								<?php echo date("D, d M Y H:i",strtotime($detail[$ModelName]["checkin_date"]))?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 col-xs-5 control-label">
                            	Notes:
                             </label>
                            <div class="col-md-8 col-xs-7 line-height-30">
								<?php echo $this->General->IsEmptyVal($detail["Schedule"]['check_rival_notes'])?>
                            </div>
                        </div>
                        <?php endif;?>
                        
                        
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-5">
        	<div class="panel panel-primary">
                <div class="panel-body">
                	<h3><span class="fa fa-tag"></span> Rival Info</h3>
                </div>
                <div class="panel-body form-group-separated">
                	<form action="#" class="form-horizontal">
                    	<?php foreach($scheduleLog as $scheduleLog):?>
                        <div class="form-group">
                            <label class="col-md-4 col-xs-5 control-label"><?php echo $scheduleLog["CompetitorProduct"]["name"]?></label>
                            <div class="col-md-8 col-xs-7 line-height-30">
								<?php
                                	if(!empty($scheduleLog["ScheduleLog"]["id"]))
									{
										echo number_format($scheduleLog["ScheduleLog"]['qty']);
									}
									else
									{
										echo "-";
									}
								?>
                            </div>
                        </div>
                        <?php endforeach;?>
                    </form>
                </div>
            </div>
            
        	<div class="panel panel-primary">
                <div class="panel-body">
                	<h3><span class="fa fa-shopping-cart"></span> Order Information</h3>
                </div>
                <div class="panel-body form-group-separated">
                	<?php if(!empty($checkOrder)):?>
                	<form action="#" class="form-horizontal">
                    	<div class="form-group" style="background-color:#E8E8E8;">
                            <label class="col-md-3 col-xs-3 control-label" style="height:30px; margin:0px;padding-top:0px; padding-bottom:0px;">
                            	<b>Product</b>
                            </label>
                            <div class="col-md-3 col-xs-3 line-height-30" style="text-align:right;height:30px;margin:0px; padding-top:0px; padding-bottom:0px;">
								<b>Quantity</b>
                            </div>
                            <div class="col-md-3 col-xs-3 line-height-30" style="text-align:right;height:30px;margin:0px; padding-top:0px; padding-bottom:0px;">
								<b>Item Price</b>
                            </div>
                            <div class="col-md-3 col-xs-3 line-height-30" style="text-align:right;height:30px;margin:0px; padding-top:0px; padding-bottom:0px;">
								<b>Subtotal</b>
                            </div>
                        </div>
                        <?php $total		=	0;?>
                        <?php $qtyTotal		=	0;?>
                        <?php $qtyItemPrice	=	0;?>
                        
                        <?php foreach($checkOrder["OrderList"] as $orderList):?>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-3 control-label">
								<?php echo $orderList["Product"]["name"]?>
                            </label>
                            <div class="col-md-3 col-xs-3 line-height-30" style="text-align:right;">
								<?php echo number_format($orderList["qty"])?>
                            </div>
                            <div class="col-md-3 col-xs-3 line-height-30" style="text-align:right;">
								<?php echo number_format($orderList["Product"]["price"])?>
                            </div>
                            <div class="col-md-3 col-xs-3 line-height-30" style="text-align:right;">
                            	<?php $subtotal		=	$orderList["qty"] * $orderList["Product"]["price"];?>
                                <?php $total		+=  $subtotal;?>
                                <?php $qtyTotal		+=	$orderList["qty"];?>
                                <?php $qtyItemPrice	+=	$orderList["Product"]["price"];?>
								<?php echo number_format($subtotal)?>
                            </div>
                        </div>
                        <?php endforeach;?>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-3 control-label">
                                <strong>TOTAL</strong>
                            </label>
                            <div class="col-md-3 col-xs-3 line-height-30" style="text-align:right;">
                                <strong><?php echo number_format($qtyTotal)?></strong>
                            </div>
                            <div class="col-md-3 col-xs-3 line-height-30" style="text-align:right;">
                                <strong><?php echo number_format($qtyItemPrice)?></strong>
                            </div>
                            <div class="col-md-3 col-xs-3 line-height-30" style="text-align:right;">
                                <strong><?php echo number_format($total)?></strong>
                            </div>
                        </div>
                    </form>
                    <?php else:?>
                    <div class="col-md-12" style="margin-top:10px;">
                        <div class="alert alert-danger" role="alert">
                            <?php echo __('No order available')?>
                        </div>
                    </div>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
    	<div class="col-md-12">
        	<div id="contents_area">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">ORDER HISTORY</h3>
                    </div>
                    
                    <div class="panel-body panel-body-table">
                        <div class="table-responsive">
                        	<table class="table table-bordered table-striped table-actions">
                                <thead>
                                    <tr>
                                    	<th style="width:8%;">
                                        	No
                                        </th>
                                        <th style="width:23%;">
                                        	Product
                                        </th>
                                        <th style="width:23%;">
                                        	Qty
                                        </th>
                                        <th style="width:23%;">
                                        	Item Price
                                        </th>
                                        <th style="width:23%;">
                                        	Subtotal
                                        </th>
                                    </tr>
                                </thead>
                				<tbody>
                                	<?php if(!empty($orderLog)):?>
                                	<?php foreach($orderLog as $orderLog):?>
                                    <?php
									$label	=	"";
                                    switch($orderLog["OrderLogType"]["id"])
									{
										case "1":
											$label	=	"label-info";
											break;
										case "2":
											$label	=	"label-warning";
											break;
										case "3":
											$label	=	"label-danger";
											break;
										case "4":
											$label	=	"label-success";
											break;
									}
									?>
                                	<tr>
                                    	<td colspan="5" style="background:#d9edf7; width:100%;">
                                        	<div class="col-md-6">
                                                <strong>Order ID : <?php echo $orderLog["OrderLog"]["order_id"]?></strong>
                                                <span class="label <?PHP echo $label?>"><?php echo strtolower($orderLog["OrderLogType"]["name"])?></span>
                                            </div>
                                            <div class="col-md-6 pull-right" style="text-align:right;">
                                            	<div class="col-md-12">
                                                    <strong>
                                                        <?php echo date("d M Y H:i",strtotime($orderLog["OrderLog"]["created"]))?>
                                                    </strong>
                                                </div>
                                                <?php if(!empty($orderLog["OrderLog"]["notes"])):?>
                                                <div class="col-md-12" style="color:#950000;">
                                                		&ldquo;<?php echo $this->General->IsEmptyVal($orderLog["OrderLog"]["notes"])?>
                                                        &rdquo;
                                                </div>
                                                <?php endif;?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php if(!empty($orderLog["OrderLogList"])):?>
                                    <?php foreach($orderLog["OrderLogList"] as $OrderLogList):?>
                                    <?php if(intval($OrderLogList["qty"]) > 0):?>
                                    <?php $subtotal = ($OrderLogList["Product"]["price"]*$OrderLogList["qty"])?>
                                	<tr>
                                    	<td>1</td>
                                        <td><?php echo $OrderLogList["Product"]["name"]?></td>
                                        <td><?php echo $OrderLogList["qty"]?></td>
                                        <td>Rp <?php echo number_format($OrderLogList["Product"]["price"])?></td>
                                        <td>Rp <?php echo number_format($subtotal)?></td>
                                    </tr>
                                    <?php endif;?>
                                    <?php endforeach;?>
                                    <?php endif;?>
                                    <?php endforeach;?>
                                    <?php else:?>
                                    <tr>
                                    	<td colspan="5">
                                        	<div class="alert alert-danger" role="alert">
												<?php echo __('No order history available')?>
                                            </div>
                                        </td>
                                     </tr>
                                    <?php endif;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="panel-footer">
                		<div class="dataTables_info">
                        	&nbsp;
                        </div>
                   	</div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- START PAGE CONTENT WRAPPER -->