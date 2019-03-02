<?php if(!empty($data)): ?>

<?php
	$order		=	array_keys($this->params['paging'][$ModelName]['order']);
	$direction	=	$this->params['paging'][$ModelName]["order"][$order[0]];
	$ordered	=	($order[0]!==0) ? "/sort:".$order[0]."/direction:".$direction: "";
?>
<?php $this->Paginator->options(array(
				'url'	=> array(
					'controller'	=> $ControllerName,
					'action'		=> 'ListItem/limit:'.$viewpage,
				),
				'onclick'=>"return onClickPage(this,'#contents_area',$(this).attr('href'));")
			);
?>

<script>

function ActionChecked()
{
	var checked	=	"";
	$("input[id^=chck_]").each(function(index){
		if($(this).prop("checked"))
		{
			checked			+=		$(this).val()+",";
		}
	});
	checked		=	checked.substring(0,checked.length-1);

	if(checked.length == 0)
	{
		noty({text:"<?php echo __('Please check item!')?>", layout: 'topCenter', type: 'error',timeout:2000});
	}
	else
	{
		if($("#action").val() == "")
		{
			noty({text:"<?php echo __('Please select action!')?>", layout: 'topCenter', type: 'error',timeout:2000});
		}
		else
		{
			if( $("#action").val() == "delete" )
			{
				noty({
					text: "<?php echo __('Do you realy want to delete all selected item ?')?>",
					layout: 'topCenter',
					timeout:2000,
					buttons: [
							{
								addClass: 'btn btn-success btn-clean', text: '<?php echo __('Yes')?>', onClick: function($noty) {
									$noty.close();
									var fullScreenMode	=	Before(".dataTables_wrapper");
									$.getJSON("<?php echo $settings["cms_url"].$ControllerName?>/DeleteMultiple/",{

											"id":checked

										},function(result)
									{
										if(result.data.status == "1")
										{
											noty({text:result.data.message,timeout:2000, layout: 'topCenter', type: 'success'});
											$("#contents_area").load("<?php echo $settings["cms_url"].$ControllerName?>/ListItem/page:<?php echo $page?>/limit:<?php echo $viewpage.$ordered?>/fullScreenMode:"+fullScreenMode,function(){
												CallBack(fullScreenMode);
											});
										}
										else
										{
											noty({text:result.data.message,timeout:2000, layout: 'topCenter', type: 'error'});
											$(".panel-refresh-layer").remove();
											$("#contents_area > div.panel").removeClass("panel-refreshing");
										}
									});
							}
							},
							{
								addClass: 'btn btn-danger btn-clean', text: '<?php echo __('Cancel')?>', onClick: function($noty) {
									$noty.close();
								}
							}
						]
				});
			}
			else if( $("#action").val() == "hide" )
			{
				noty({
					text: "<?php echo __('Do you realy want deactivate all selected item ?')?>",
					layout: 'topCenter',
					timeout:2000,
					buttons: [
							{
								addClass: 'btn btn-success btn-clean', text: '<?php echo __('Yes')?>', onClick: function($noty) {
									$noty.close();
									var fullScreenMode	=	Before(".dataTables_wrapper");
									$.getJSON("<?php echo $settings["cms_url"].$ControllerName?>/ChangeStatusMultiple/",{

											"id":checked,
											"status":"0"
										},function(result)
									{
										if(result.data.status == "1")
										{
											noty({text:result.data.message,timeout:2000, layout: 'topCenter', type: 'success'});
											$("#contents_area").load("<?php echo $settings["cms_url"].$ControllerName?>/ListItem/page:<?php echo $page?>/limit:<?php echo $viewpage.$ordered?>/fullScreenMode:"+fullScreenMode,function(){
												CallBack(fullScreenMode);
											});
										}
										else
										{
											noty({text:result.data.message,timeout:2000, layout: 'topCenter', type: 'error'});
											$(".panel-refresh-layer").remove();
											$("#contents_area > div.panel").removeClass("panel-refreshing");
										}
									});
							}
							},
							{
								addClass: 'btn btn-danger btn-clean', text: '<?php echo __('Cancel')?>', onClick: function($noty) {
									$noty.close();
								}
							}
						]
				});
			}
			else if( $("#action").val() == "show" )
			{
				noty({
					text: "<?php echo __('Do you realy want activate all selected item ?')?>",
					timeout:2000,
					layout: 'topCenter',
					buttons: [
							{
								addClass: 'btn btn-success btn-clean', text: '<?php echo __('Yes')?>', onClick: function($noty) {
									$noty.close();
									var fullScreenMode	=	Before(".dataTables_wrapper");
									$.getJSON("<?php echo $settings["cms_url"].$ControllerName?>/ChangeStatusMultiple/",{

											"id":checked,
											"status":"1"
										},function(result)
									{
										if(result.data.status == "1")
										{
											noty({text:result.data.message,timeout:2000, layout: 'topCenter', type: 'success'});
											$("#contents_area").load("<?php echo $settings["cms_url"].$ControllerName?>/ListItem/page:<?php echo $page?>/limit:<?php echo $viewpage.$ordered?>/fullScreenMode:"+fullScreenMode,function(){
												CallBack(fullScreenMode);
											});
										}
										else
										{
											noty({text:result.data.message,timeout:2000, layout: 'topCenter', type: 'error'});
											$(".panel-refresh-layer").remove();
											$("#contents_area > div.panel").removeClass("panel-refreshing");
										}
									});
							}
							},
							{
								addClass: 'btn btn-danger btn-clean', text: '<?php echo __('Cancel')?>', onClick: function($noty) {
									$noty.close();
								}
							}
						]
				});
			}
		}
	}
}

function Delete(el,msg,id)
{
	noty({
		text: msg,
		layout: 'topCenter',
		timeout:2000,
		buttons: [
				{
					addClass: 'btn btn-success btn-clean', text: '<?php echo __('Yes')?>', onClick: function($noty) {
						$noty.close();
						var fullScreenMode	=	Before(el);
						$.getJSON("<?php echo $settings["cms_url"].$ControllerName?>/Delete/"+id,function(result)
						{
							if(result.data.status == "1")
							{
								noty({text:result.data.message,timeout:2000, layout: 'topCenter', type: 'success'});
								$("#contents_area").load("<?php echo $settings["cms_url"].$ControllerName?>/ListItem/page:<?php echo $page?>/limit:<?php echo $viewpage.$ordered?>/fullScreenMode:"+fullScreenMode,function(){
									CallBack(fullScreenMode);
								});
							}
							else
							{
								noty({text:result.data.message,timeout:2000, layout: 'topCenter', type: 'error'});
								$(".panel-refresh-layer").remove();
								$("#contents_area > div.panel").removeClass("panel-refreshing");
							}
						});
				}
				},
				{
					addClass: 'btn btn-danger btn-clean', text: '<?php echo __('Cancel')?>', onClick: function($noty) {
						$noty.close();
					}
				}
			]
	});
	return false;
}

function ChangeStatus(el,msg,id,status)
{
	noty({
		text: msg,
		layout: 'topCenter',
		timeout:2000,
		buttons: [
				{
					addClass: 'btn btn-success btn-clean', text: '<?php echo __('Yes')?>', onClick: function($noty) {
						$noty.close();
						var fullScreenMode	=	Before(el);
						$.getJSON("<?php echo $settings["cms_url"].$ControllerName?>/ChangeStatus/"+id+"/"+status,function(result)
						{
							if(result.data.status == "1")
							{
								noty({text:result.data.message,timeout:2000, layout: 'topCenter', type: 'success'});
								$("#contents_area").load("<?php echo $settings["cms_url"].$ControllerName?>/ListItem/page:<?php echo $page?>/limit:<?php echo $viewpage.$ordered?>/fullScreenMode:"+fullScreenMode,function(){
									CallBack(fullScreenMode);
								});
							}
							else
							{
								noty({text:result.data.message,timeout:2000, layout: 'topCenter', type: 'error'});
								$(".panel-refresh-layer").remove();
								$("#contents_area > div.panel").removeClass("panel-refreshing");
							}
						});
				}
				},
				{
					addClass: 'btn btn-danger btn-clean', text: '<?php echo __('Cancel')?>', onClick: function($noty) {
						$noty.close();
					}
				}
			]
	});
	return false;
}

function MoveUp(el,id)
{
	var fullScreenMode	=	Before(el);
	$.getJSON("<?php echo $settings["cms_url"].$ControllerName?>/MoveUp/"+id,function(result)
	{
		if(result.data.status == "1")
		{
			noty({text:result.data.message,timeout:2000, layout: 'topCenter', type: 'success'});
			$("#contents_area").load("<?php echo $settings["cms_url"].$ControllerName?>/ListItem/page:<?php echo $page?>/limit:<?php echo $viewpage.$ordered?>/fullScreenMode:"+fullScreenMode,function(){
				CallBack(fullScreenMode);
			});
		}
		else
		{
			noty({text:result.data.message,timeout:2000, layout: 'topCenter', type: 'error'});
			$(".panel-refresh-layer").remove();
			$("#contents_area > div.panel").removeClass("panel-refreshing");
		}
	});
	return false;
}

function MoveDown(el,id)
{
	var fullScreenMode	=	Before(el);
	$.getJSON("<?php echo $settings["cms_url"].$ControllerName?>/MoveDown/"+id,function(result)
	{
		if(result.data.status == "1")
		{
			noty({text:result.data.message,timeout:2000, layout: 'topCenter', type: 'success'});
			$("#contents_area").load("<?php echo $settings["cms_url"].$ControllerName?>/ListItem/page:<?php echo $page?>/limit:<?php echo $viewpage.$ordered?>/fullScreenMode:"+fullScreenMode,function(){
				CallBack(fullScreenMode);
			});
		}
		else
		{
			noty({text:result.data.message,timeout:2000, layout: 'topCenter', type: 'error'});
			$(".panel-refresh-layer").remove();
			$("#contents_area > div.panel").removeClass("panel-refreshing");
		}
	});
	return false;
}

</script>
<!-- START DEFAULT DATATABLE -->
<?php
$fullscreened	=	($fullScreenMode == 1) ? 'panel-fullscreened' : '';
$faClass		=	($fullScreenMode == 1) ? 'fa-compress' : 'fa-expand';
?>
<?php if($fullScreenMode==1):?>
<div class="panel-fullscreen-wrap">
<?php endif;?>
<div class="panel panel-info <?php echo $fullscreened?>">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo Inflector::humanize(Inflector::underscore($ControllerName))?> - <?php echo $this->Paginator->counter(__('{:page} of {:pages}')); ?></h3>
        <ul class="panel-controls">
            <li><a href="#" class="panel-fullscreen"><span class="fa <?php echo $faClass?>"></span></a></li>
            <li><a href="javascript:void(0);" onClick="javascript:Refresh(this);"><span class="fa fa-refresh"></span></a></li>
        </ul>
    </div>

    <div class="dataTables_wrapper no-footer panel-heading">
    	<div style="display:block; width:33.33%;float:left; text-align:left;">
            <div class="dataTables_length" style="border:0px;width:100%;">
            	<?php
					$updateAction	=	array(
						"show"		=>	__("Activate"),
						"hide"		=>	__("Deactivate")
					);
					$deleteAction	=	array(
						"delete"	=>	__("Delete")
					);
					$action			=	array();

					if($access[$aco_id]["_delete"] == 1)
						$action		=	array_merge($action,$deleteAction);
					if($access[$aco_id]["_update"] == 1)
						$action		=	array_merge($action,$updateAction);
				?>
                <?php if(!empty($action)):?>
                <label>
                    <?php echo __('Action :')?>

                    <?PHP echo $this->Form->select("action",$action,
					array(
						"empty"		=>	__("Select Action"),
						"style"		=>	"width:150px;",
						"class"		=>	"form-control"
					));?>

                    <a href="javascript:void(0);" class="btn btn-primary btn-sm" style="margin-top:-5px;" onclick="ActionChecked()"><?php echo __('GO')?></a>
                </label>
                <?php endif;?>
            </div>
        </div>

		<?php if($this->Paginator->hasPrev() or $this->Paginator->hasNext()):?>
        <div style="display:block; width:33.33%;float:left; text-align:center; display:none;" id="pagination-center">
            <ul class="pagination pagination-sm">
            <?php
                echo $this->Paginator->prev("&laquo;",
                    array(
                        "escape"	=>	false,
                        'tag'		=>	"li"
                    ),
                    "<a href='javascript:void(0)'>&laquo;</a>",
                    array(
                        'tag'		=>	"li",
                        "escape"	=>	false,
                        "class"		=>	"disabled"
                    )
                );
                echo $this->Paginator->numbers(array(
                    'separator'		=>	null,
                    'tag'			=>	"li",
                    'currentTag'	=>	'span',
                    'currentClass'	=>	'active',
                    'modulus'		=>	4
                ));
                echo $this->Paginator->next("&raquo;",
                    array(
                        "escape"	=>	false,
                        'tag'		=>	"li"
                    ),
                    "<a href='javascript:void(0)'>&raquo;</a>",
                    array(
                        'tag'		=>	"li",
                        "escape"	=>	false,
                        "class"		=>	"disabled"
                    )
                );
            ?>
            </ul>
        </div>
        <?php endif;?>

        <div style="width:33.33%;" class="pull-right">
            <div class="dataTables_filter" style="border:0px;width:100%;">
                <label>
                    <?php echo __('Show entries :')?>
                    <?PHP echo $this->Form->select("view",array(1=>1,5=>5,10=>10,20=>20,50=>50,100=>100,200=>200,1000=>1000),array("onchange"=>"onClickPage(this,'#contents_area','".$settings["cms_url"].$ControllerName."/ListItem/limit:'+this.value+'".$ordered."/')","empty"=>false,"default"=>$viewpage,"class" => "form-control"))?>
                </label>
            </div>
    	</div>
    </div>

    <div class="panel-body panel-body-table">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-actions">
                <thead>
                    <tr>
                    	<?php
						if(
							$access[$aco_id]["_update"] == 1 or
							$access[$aco_id]["_delete"] == 1
						):
						?>
                    	<th class="text-center" style="width:5%">
                        	<input type="checkbox" class="icheckbox" id="CheckAll"/>
                        </th>
                        <?php endif;?>
                    	<th style="width:5%">No</th>
                        <th style="width:10%">
                        	<?php echo $this->Paginator->sort("$ModelName.order_no",__('Order No.'),array("class"=>"sorting"));?>
                        </th>
                        <th style="width:12%">
                        	<?php echo $this->Paginator->sort("User.fullname",__('User'),array("class"=>"sorting"));?>
                        </th>
                        
                        <th style="width:12%">
                        	<?php echo $this->Paginator->sort("Studio.name",__('Studio'),array("class"=>"sorting"));?>
                        </th>
                        
                        <th style="width:9%">
                        	<?php echo $this->Paginator->sort("Order.start_date",__("Date"),array("class"=>"sorting"));?>
                        </th>
                        
                        <th style="width:12%" class="text-center">
                        	<?php echo $this->Paginator->sort("OrderStatus.name",__('Status'),array("class"=>"sorting"));?>
                        </th>
                        
                        <th style="width:12%" class="text-center"><?php echo __('Actions')?></th>
                    </tr>
                </thead>
                <tbody>
                	<?php $count = 0;?>
					<?php foreach($data as $data): ?>
                    <?php $count++;?>
                    <?php $no		=	(($page-1)*$viewpage) + $count;?>
                    <?php
                    	$styleTr	=	"";
						if($data["Order"]["order_status_id"] == "2")
						{
							$styleTr	=	'class="highlight"';
						}
					?>
                    <tr <?php echo $styleTr?>>
                    	<?php
						if(
							$access[$aco_id]["_update"] == 1 or
							$access[$aco_id]["_delete"] == 1
						):
						?>
                    	<td class="text-center">
                        	<input type="checkbox" id="chck_<?php echo $data[$ModelName]['id']?>" value="<?php echo $data[$ModelName]['id']?>" class="icheckbox"/>
                        </td>
                        <?php endif;?>
                    	<td><?php echo $no ?></td>
                        <td>
							<?php echo $data[$ModelName]['order_no']?>
                        </td>
                        <td>
                        	<?php echo $this->General->IsEmptyVal($data["User"]['fullname'])?>
                        </td>
                        
                        <td>
							<?php echo $this->General->IsEmptyVal($data["Studio"]['title'])?>
                        </td>
                        <td>
							<?php echo date("d F Y",strtotime($data["Order"]['start_date']))." <br/> ".date("H:i",strtotime($data["Order"]['start_date']))."-".date("H:i",strtotime($data["Order"]['end_date']))?>
                        </td>
                        <td class="text-center" style=" font-weight:bold;">
							<?php echo $data["OrderStatus"]['name2']?>
                        </td>
                        <td class="text-center">
                        	<?php
								$disabledStatus	=	"disabled=disabled";
								$disabledEdit	=	"disabled=disabled";
								$disabledDelete	=	"disabled=disabled";

								if($access[$aco_id]["_update"] == 1)
								{
									$disabledEdit	=	"";
								}

								if($access[$aco_id]["_delete"] == 1)
								{
									$disabledDelete	=	"";
								}
							?>

							 <a href="<?php echo $settings['cms_url'].$ControllerName?>/Detail/<?php echo $data[$ModelName]["id"]?>/<?php echo $page?>/<?php echo $viewpage?>" class="btn btn-info btn-condensed btn-sm" data-toggle="tooltip" data-placement="top" title="<?php echo __('View')?>" <?php echo $disabledEdit?>><i class="fa fa-eye"></i></a>
                             
                            <!--a href="<?php echo $settings['cms_url'].$ControllerName?>/Edit/<?php echo $data[$ModelName]["id"]?>/<?php echo $page?>/<?php echo $viewpage?>" class="btn btn-info btn-condensed btn-sm" data-toggle="tooltip" data-placement="top" title="<?php echo __('Edit')?>" <?php echo $disabledEdit?>><i class="fa fa-pencil"></i></a>

                            <a href="javascript:void(0);" class="btn btn-danger btn-condensed btn-sm" data-toggle="tooltip" data-placement="top" title="<?php echo __('Delete')?>" onclick="Delete(this,'<?php echo __('Do you realy want to delete this item ?')?>','<?php echo $data[$ModelName]['id']?>')" <?php echo $disabledDelete?>><i class="fa fa-times"></i></a-->
                            
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="panel-footer">
                <div class="dataTables_info">
                	<?php echo $this->Paginator->counter(array('format' => __('Showing %start% to %end% of %count% entries')));?>
                </div>
                <?php if($this->Paginator->hasPrev() or $this->Paginator->hasNext()):?>
                <ul class="pagination pagination-sm pull-right">
                <?php
					echo $this->Paginator->prev("&laquo;",
						array(
							"escape"	=>	false,
							'tag'		=>	"li"
						),
						"<a href='javascript:void(0)'>&laquo;</a>",
						array(
							'tag'		=>	"li",
							"escape"	=>	false,
							"class"		=>	"disabled"
						)
					);
					echo $this->Paginator->numbers(array(
						'separator'		=>	null,
						'tag'			=>	"li",
						'currentTag'	=>	'span',
						'currentClass'	=>	'active',
						'modulus'		=>	4
					));
					echo $this->Paginator->next("&raquo;",
						array(
							"escape"	=>	false,
							'tag'		=>	"li"
						),
						"<a href='javascript:void(0)'>&raquo;</a>",
						array(
							'tag'		=>	"li",
							"escape"	=>	false,
							"class"		=>	"disabled"
						)
					);
				?>
                </ul>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>
<!-- END SIMPLE DATATABLE -->
<?php if($fullScreenMode==1):?>
</div>
<?php endif;?>
<?php else:?>
<div class="alert alert-danger" role="alert">
    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
    <?php echo __('Data is not available!')?>
</div>
<?php endif;?>
