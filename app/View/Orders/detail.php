<?php $this->start("script");?>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/bootstrap-datetimepicker.min.js"></script>

<script>

$(document).ready(function(){
	<?php if(!empty($this->data[$ModelName]["update_status_id"])):?>
	ChangeStatus('<?php echo $this->data[$ModelName]["update_status_id"]?>');
	<?php endif;?>
});

function ChangeStatus(updateStatusId)
{
	if(updateStatusId == "3")
	{
		$("#notesLyt").show(300);
		$("#deliveryDateLyt").hide(300);
		$("#OrderDeliveryDate").val('');
	}
	else if(updateStatusId == "4")
	{
		$("#notesLyt").hide(300);
		$("#deliveryDateLyt").show(300);
		$("#OrderNotes").val('');
	}
	else
	{
		$("#notesLyt").hide(300);
		$("#OrderNotes").val('');
	}
}
</script>
<?php $this->end()?>

<?php $this->start("css");?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->webroot?>css/bootstrap-datetimepicker.min.css" media="all" />
<?php $this->end();?>


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
			<?php echo $detail["Schedule"]["Store"]["name"]." (".date("D, d M Y H:i",strtotime($detail[$ModelName]["modified"])).")"?></h2>
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
        <div class="col-md-12">
        	<?php echo $this->Session->flash();?>
        </div>
    	<div class="col-md-6">
        	<div class="panel panel-primary">
                <div class="panel-body">
                	<h3><span class="fa fa-shopping-cart"></span> List Order</h3>
                </div>
                <div class="panel-body form-group-separated">
                	<form action="#" class="form-horizontal">
                    	<div class="form-group" style="background-color:#E8E8E8;">
                            <label class="col-md-3 col-xs-3 control-label" >
                            	<b>Product</b>
                            </label>
                            <div class="col-md-3 col-xs-3 line-height-30" style="text-align:right;">
								<b>Quantity</b>
                            </div>
                            <div class="col-md-3 col-xs-3 line-height-30" style="text-align:right;">
								<b>Item Price</b>
                            </div>
                            <div class="col-md-3 col-xs-3 line-height-30" style="text-align:right;">
								<b>Subtotal</b>
                            </div>
                        </div>
                        <?php $total		=	0;?>
                        <?php $qtyTotal		=	0;?>
                        <?php $qtyItemPrice	=	0;?>
                        
                        <?php foreach($detail["OrderList"] as $orderList):?>
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
                </div>
            </div>
           
        </div>
        <div class="col-md-6">
        	<div class="panel panel-primary">
                <div class="panel-body">
                	<h3><span class="glyphicon glyphicon-time"></span> Order Information</h3>
                </div>
                <?php echo $this->Form->create("Order",array("url"=>array("controller"=>$ControllerName,"action"=>"Detail",$ID,$page,$viewpage),"class"=>"form-horizontal","novalidate"))?>
                <?php
					echo $this->Form->input('id', array(
						'type'			=>	'hidden',
						'readonly'		=>	'readonly'
					));
				?>
                <div class="panel-body form-group-separated">
                    <div class="form-group">
                        <label class="col-md-4 col-xs-5 control-label">Sales</label>
                        <div class="col-md-8 col-xs-7 line-height-30">
                            <?php echo $detail["Schedule"]["Sales"]["fullname"]?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 col-xs-5 control-label">Schedule Date</label>
                        <div class="col-md-8 col-xs-7 line-height-30">
                            <?php echo date("D, d M Y H:i",strtotime($detail["Schedule"]["schedule_date"]))?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 col-xs-5 control-label">Store</label>
                        <div class="col-md-8 col-xs-7 line-height-30">
                            <?php echo $this->General->IsEmptyVal($detail["Schedule"]["Store"]['name'])?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-4 col-xs-5 control-label">Notes</label>
                        <div class="col-md-8 col-xs-7 line-height-30">
                            <?php echo $this->General->IsEmptyVal($detail["Order"]["notes"])?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-4 col-xs-5 control-label">Order Date</label>
                        <div class="col-md-8 col-xs-7 line-height-30">
                            <?php echo date("D, d M Y H:i",strtotime($detail["Order"]["modified"]))?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 col-xs-5 control-label">Order Status</label>							
                        <?php 
                            $classStatus	=	"label-default";
                            switch($detail["OrderStatus"]["id"])
                            {
                                case "1":
                                    $classStatus	=	"label-warning";
                                    break;
                                case "2":
                                    $classStatus	=	"label-info";
                                    break;
                                case "3":
                                    $classStatus	=	"label-danger";
                                    break;
                                case "4":
                                    $classStatus	=	"label-success";
                                    break;
                                default:
                                    $classStatus	=	"label-default";
                                    break;
                                    
                            }
                        ?>
                        <div class="col-md-8 col-xs-7 line-height-30">
                            <span class="label label-form <?php echo $classStatus?>"><?php echo $detail["OrderStatus"]["name"]?></span>
                        </div>
                    </div>
                    
                    <?php if($detail["Order"]["order_status_id"] == "4" ):?>
                    <div class="form-group">
                        <label class="col-md-4 col-xs-5 control-label">Delivery Date</label>	
                        <div class="col-md-8 col-xs-7 line-height-30">
                        	<?php if(!empty($detail["Order"]["delivery_date"])):?>
                            <?php echo date("D, d M Y",strtotime($detail["Order"]["delivery_date"]))?>
                            <?php else :?>
                             <span class="label label-form label-danger">Untracked</span>
                            <?php endif;?>
                        </div>
                    </div>
                    <?php endif;?>
                    
                    <?php if(in_array($detail["OrderStatus"]["id"],array("1"))):?>
                    	<?php echo $this->Form->input("id",array("value"=>$ID,"type"=>"hidden","readonly"=>"readonly"))?>
                        <?php echo $this->Form->input("update_status_id",
                        array(
                            "div"			=>	array("class"	=>	"form-group"),
                            "label"			=>	array("class"	=>	"col-md-4 col-xs-5 control-label","text"=>__("Update status to :")),
                            "between"		=>	'<div class="col-md-8 col-xs-7 line-height-30">',
                            "after"			=>	"</div>",
                            "autocomplete"	=>	"off",
                            "options"		=>	$order_status_id_list,
                            "class"			=>	'form-control select',
                            'error' 		=>	array(
                                'attributes' => array(
                                    'wrap' 	=> 'label',
                                    'class' => 'error'
                                )
                            ),
                            "format"		=>	array(
                                'before',
                                'label',
                                'between',
                                'input',
                                'error',
                                'after',
                            ),
                            "empty"					=>	__("Update Status"),
                            "data-live-search"		=>	"false",
							"onchange"				=>	"ChangeStatus(this.value)"
                        )
                    )?>
                    <div id="deliveryDateLyt" style="display:none;">
                    	<?php echo $this->Form->input("delivery_date",
                            array(
                                "div"			=>	array("class"=>"form-group"),
                                "label"			=>	array("class"	=>	"col-md-4 control-label","text"=>__("Delivery Date (*)")),
                                "between"		=>	'<div class="col-md-8">',
                                "after"			=>	"</div>",
                                "autocomplete"	=>	"off",
                                "type"			=>	"text",
                                "class"			=>	'form-control datepicker',
								'error' 		=>	array(
									'attributes' => array(
										'wrap' 	=> 'label',
										'class' => 'error'
									)
								),
								"format"		=>	array(
									'before',
									'label',
									'between',
									'input',
									'error',
									'after',
								),
								"escape"		=>	false
                            )
                        )?>
                    </div>
                    <div id="notesLyt" style="display:none;">
                    	<?php echo $this->Form->input("notes",
							array(
								"div"			=>	array("class"=>"form-group"),
								"label"			=>	array(
														"class"	=>	"col-md-4 col-xs-5 control-label",
														"text"	=>	"Notes"
													),
								"between"		=>	'<div class="col-md-8 col-xs-7 line-height-30">',
								"after"			=>	'</div>',
								"autocomplete"	=>	"off",
								"type"			=>	"textarea",
								"class"			=>	'form-control',
								'error' 		=>	array(
									'attributes' => array(
										'wrap' 	=> 'label',
										'class' => 'error'
									)
								),
								"format"		=>	array(
									'before',
									'label',
									'between',
									'input',
									'error',
									'after',
								),
								"rows"			=>	10
							)
						)?>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 col-xs-5 control-label">
                        	&nbsp;
                        </label>
                        <div class="col-md-8 col-xs-7 line-height-30">
                            <button type="submit" onclick="OnClickSaveDirect()" class="btn btn-primary">
								<?php echo __('UPDATE STATUS')?>
                                <span class="fa fa-floppy-o fa-right"></span>
                            </button>
                        </div>
                    </div>
                    <?php endif;?>
                </div>
                </form>
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
                                            	<div class="col-md-12">
                                                    <strong>Order ID : <?php echo $orderLog["OrderLog"]["order_id"]?></strong>
                                                    <span class="label <?PHP echo $label?>"><?php echo strtolower($orderLog["OrderLogType"]["name"])?></span>
                                                </div>
                                                <div class="col-md-12">
                                                   Crated By : <b><?php echo $orderLog["MyAro"]["alias"]?></b>
                                                </div>
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