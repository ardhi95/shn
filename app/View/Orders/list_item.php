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
		noty({timeout:2000,text:"<?php echo __('Please check item!')?>", layout: 'topCenter', type: 'error'});
	}
	else
	{
		if($("#action").val() == "")
		{
			noty({timeout:2000,text:"<?php echo __('Please select action!')?>", layout: 'topCenter', type: 'error'});
		}
		else
		{
			if( $("#action").val() == "delete" )
			{
				noty({timeout:2000,
					text: "<?php echo __('Do you realy want to delete all selected item ?')?>",
					layout: 'topCenter',
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
											noty({timeout:2000,text:result.data.message, layout: 'topCenter', type: 'success'});
											$("#contents_area").load("<?php echo $settings["cms_url"].$ControllerName?>/ListItem/page:<?php echo $page?>/limit:<?php echo $viewpage.$ordered?>/fullScreenMode:"+fullScreenMode,function(){
												CallBack(fullScreenMode);
											});
										}
										else
										{
											noty({timeout:2000,text:result.data.message, layout: 'topCenter', type: 'error'});
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
				noty({timeout:2000,
					text: "<?php echo __('Do you realy want deactivate all selected sales ?')?>",
					layout: 'topCenter',
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
											noty({timeout:2000,text:result.data.message, layout: 'topCenter', type: 'success'});
											$("#contents_area").load("<?php echo $settings["cms_url"].$ControllerName?>/ListItem/page:<?php echo $page?>/limit:<?php echo $viewpage.$ordered?>/fullScreenMode:"+fullScreenMode,function(){
												CallBack(fullScreenMode);
											});
										}
										else
										{
											noty({timeout:2000,text:result.data.message, layout: 'topCenter', type: 'error'});
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
				noty({timeout:2000,
					text: "<?php echo __('Do you realy want activate all selected item ?')?>",
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
											noty({timeout:2000,text:result.data.message, layout: 'topCenter', type: 'success'});
											$("#contents_area").load("<?php echo $settings["cms_url"].$ControllerName?>/ListItem/page:<?php echo $page?>/limit:<?php echo $viewpage.$ordered?>/fullScreenMode:"+fullScreenMode,function(){
												CallBack(fullScreenMode);
											});
										}
										else
										{
											noty({timeout:2000,text:result.data.message, layout: 'topCenter', type: 'error'});
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
	noty({timeout:2000,
		text: msg,
		layout: 'topCenter',
		buttons: [
				{
					addClass: 'btn btn-success btn-clean', text: '<?php echo __('Yes')?>', onClick: function($noty) {
						$noty.close();
						var fullScreenMode	=	Before(el);
						$.getJSON("<?php echo $settings["cms_url"].$ControllerName?>/Delete/"+id,function(result)
						{
							if(result.data.status == "1")
							{
								noty({timeout:2000,text:result.data.message, layout: 'topCenter', type: 'success'});
								$("#contents_area").load("<?php echo $settings["cms_url"].$ControllerName?>/ListItem/page:<?php echo $page?>/limit:<?php echo $viewpage.$ordered?>/fullScreenMode:"+fullScreenMode,function(){
									CallBack(fullScreenMode);
								});
							}
							else
							{
								noty({timeout:2000,text:result.data.message, layout: 'topCenter', type: 'error'});
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
	if(status == "0")
	{
		msg		=	"<?php echo __('Deactivate sales will make this sales no longer can login to mobile apps. Do you really want to continue ?')?>";
	}
	else if(status == "1")
	{
		msg		=	"<?php echo __('Do you really want to activate this sales ?')?>";
	}

	noty({timeout:2000,
		text: msg,
		layout: 'topCenter',
		buttons: [
				{
					addClass: 'btn btn-success btn-clean', text: '<?php echo __('Yes')?>', onClick: function($noty) {
						$noty.close();
						var fullScreenMode	=	Before(el);
						$.getJSON("<?php echo $settings["cms_url"].$ControllerName?>/ChangeStatus/"+id+"/"+status,function(result)
						{
							if(result.data.status == "1")
							{
								noty({timeout:2000,text:result.data.message, layout: 'topCenter', type: 'success'});
								$("#contents_area").load("<?php echo $settings["cms_url"].$ControllerName?>/ListItem/page:<?php echo $page?>/limit:<?php echo $viewpage.$ordered?>/fullScreenMode:"+fullScreenMode,function(){
									CallBack(fullScreenMode);
								});
							}
							else
							{
								noty({timeout:2000,text:result.data.message, layout: 'topCenter', type: 'error'});
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
			noty({timeout:2000,text:result.data.message, layout: 'topCenter', type: 'success'});
			$("#contents_area").load("<?php echo $settings["cms_url"].$ControllerName?>/ListItem/page:<?php echo $page?>/limit:<?php echo $viewpage.$ordered?>/fullScreenMode:"+fullScreenMode,function(){
				CallBack(fullScreenMode);
			});
		}
		else
		{
			noty({timeout:2000,text:result.data.message, layout: 'topCenter', type: 'error'});
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
			noty({timeout:2000,text:result.data.message, layout: 'topCenter', type: 'success'});
			$("#contents_area").load("<?php echo $settings["cms_url"].$ControllerName?>/ListItem/page:<?php echo $page?>/limit:<?php echo $viewpage.$ordered?>/fullScreenMode:"+fullScreenMode,function(){
				CallBack(fullScreenMode);
			});
		}
		else
		{
			noty({timeout:2000,text:result.data.message, layout: 'topCenter', type: 'error'});
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
						"show"		=>	__("Set status to process"),
						"hide"		=>	__("Set status to finished"),
						"asdasd"	=>	__("Set status to cancelled")
					);
					
					$action			=	array();
					
					if($access[$aco_id]["_update"] == 1)
						$action		=	array_merge($action,$updateAction);
				?>
                
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
                    	<th style="width:5%">No</th>
                        <th>
                        	<?php echo $this->Paginator->sort("$ModelName.id",__('Order ID'),array("class"=>"sorting"));?>
                        </th>
                        <th>
                        	<?php echo $this->Paginator->sort("Schedule.Store.name",__('Store'),array("class"=>"sorting"));?>
                        </th>
                        <th>
                        	<?php echo $this->Paginator->sort("Schedule.Sales.fullname",__('Sales'),array("class"=>"sorting"));?>
                        </th>
                        <th>
                        	<?php echo $this->Paginator->sort("$ModelName.modified",__('Date'),array("class"=>"sorting"));?>
                        </th>
                        <th>
                        	<?php echo $this->Paginator->sort("OrderStatus.name",__('Status'),array("class"=>"sorting"));?>
                        </th>
                        <th class="text-center"><?php echo __('Actions')?></th>
                    </tr>
                </thead>
                <tbody>
                	<?php $count = 0;?>
					<?php foreach($data as $data): ?>
                    <?php $count++;?>
                    <?php $no		=	(($page-1)*$viewpage) + $count;?>

                    <tr>
                    	<?php
						$disabledCheck	=	"";
						if(
							$access[$aco_id]["_update"] == 1 or
							$access[$aco_id]["_delete"] == 1
						):
						
						if(in_array($data["OrderStatus"]["id"],array(3,4)))
						{
							$disabledCheck	=	"disabled=disabled";
						}
						?>
                        <?php
						$label	=	"";
						switch($data["OrderStatus"]["id"])
						{
							case "1":
								$label	=	"label-warning";
								break;
							case "2":
								$label	=	"label-info";
								break;
							case "3":
								$label	=	"label-danger";
								break;
							case "4":
								$label	=	"label-success";
								break;
						}
						?>
                        <?php endif;?>
                    	<td><?php echo $no ?></td>
                        
                        <td>
							<?php echo $data[$ModelName]['id']?>
                        </td>
                        <td>
							<?php echo $this->General->IsEmptyVal($data["Schedule"]["Store"]['name'])?>
                        </td>
                        <td>
							<?php echo $this->General->IsEmptyVal($data["Schedule"]["Sales"]['fullname'])?>
                        </td>
                        <td class="text-center">
                        	<?php echo date("d M Y H:i",strtotime($data["Order"]['modified']))?>
                        </td>
                        <td class="text-center">
                        	<span class="label <?php echo $label?>">
                        		<?php echo $this->General->IsEmptyVal($data["OrderStatus"]['name'])?>
                            </span>
                        </td>
                        <td class="text-center">
                        	<?php
								$disabledStatus	=	"disabled=disabled";
								$disabledEdit	=	"disabled=disabled";
								$disabledDelete	=	"disabled=disabled";

								if($access[$aco_id]["_update"] == 1)
								{
									if($profile["User"]["id"] != $data[$ModelName]['id'])
										$disabledStatus	=	"";

									$disabledEdit	=	"";
								}

								if($access[$aco_id]["_delete"] == 1)
								{
									if($profile["User"]["id"] != $data[$ModelName]['id'])
										$disabledDelete	=	"";
								}
							?>
                             <a href="<?php echo $settings['cms_url'].$ControllerName?>/Detail/<?php echo $data[$ModelName]["id"]?>/<?php echo $page?>/<?php echo $viewpage?>" class="btn btn-primary btn-condensed btn-sm" data-toggle="tooltip" data-placement="top" title="<?php echo __('View')?>"><i class="fa fa-eye"></i></a>
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
