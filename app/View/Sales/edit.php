<?php
$tab1	=	"";
$tab2	=	"";

if($tab_index == "tab1")
	$tab1	=	" active";
else if($tab_index == "tab2")
	$tab2	=	" active";
	
?>

<?php $this->start("script");?>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/plugins/bootstrap/bootstrap-file-input.js"></script>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/jquery-prettyPhoto.js"></script>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/autoNumeric-1.9.18.js"></script>
<script>
$(document).ready(function(){
	
	//======= LIGHT BOX =========/
	$("a[rel^='lightbox']").prettyPhoto({
		social_tools :''
	});
	//======= LIGHT BOX =========/
	
	//======= START TAB =========/
	$(".list-group-item").bind("click",function(){
		$(".list-group-item").each(function(index, element) {
            $(this).removeClass("active");
			var href	=	$(this).attr("href");
			$(href).hide();
        });
		$(this).addClass("active");
		var href	=	$(this).attr("href");
		$(href).show();
        onload();
		$("#flashMessage,#errorDiv").hide();
	});

	$(".list-group-item").each(function(){
		var href	=	$(this).attr("href");

		if($(this).hasClass('active'))
		{
			$(href).show();
		}
		else
		{
			$(href).hide();
		}
	});
	
	<?php if($tab_index == "tab2"):?>
	AddNewTargetButton();
	<?php endif;?>
	//======= END TAB =========/
	
	//======= TAGET DATE =========/
	$("#SalesTargetStartDate").datepicker({
		format: 'dd MM yyyy',
		autoclose:'true',
		startDate:new Date()
	}).on('changeDate', function(ev){
		$("#SalesTargetEndDate").removeAttr("disabled");
		$('#SalesTargetEndDate').val('');
		$("#SalesTargetEndDate").datepicker('setStartDate',$(this).val());
		var StartDateUtc	= 	new Date($(this).datepicker('getUTCDate').toString());
		var EndDateUtc		=	StartDateUtc.setMonth(StartDateUtc.getMonth()+1);
		$("#SalesTargetEndDate").datepicker('update',new Date(EndDateUtc));
	});
	
	$("#SalesTargetEndDate").datepicker({
		format: 'dd MM yyyy',
		autoclose:'true'
	}).on('changeDate', function(ev){
		
	});
	//======= TAGET DATE =========/
	
	$("#SalesTargetTotal").autoNumeric('init', {  lZero: 'deny', aSep: ',', mDec: 0,vMin:0,vMax:9999999999});
	
	//======= SHOW TARGET LIST =========/
	LoadDataTarget();
	//======= SHOW TARGET LIST =========/
});

function PreviewImage(fileId,imageId,lighbox) {
	if ( window.FileReader && window.File && window.FileList && window.Blob )
	{
		var oFReader = new FileReader();
		oFReader.readAsDataURL(document.getElementById(fileId).files[0]);
		oFReader.onload = function (oFREvent) {
			document.getElementById(imageId).src = oFREvent.target.result;
			$(lighbox).attr("href",oFREvent.target.result);
			$("#imagePrev").hide(300);
			$("#imagePrev").show(300);
		};
	}
};

function AddNewTargetButton()
{
	$('#AddNewTargetForm').show();
	$('#AddNewTargetButton').hide();
}

function CancelAddTargetButton()
{	
	$('#AddNewTargetForm').hide();
	$('#AddNewTargetButton').show();	
}

function AddNewTargetForm()
{
	$("#AddNewTargetForm").ajaxSubmit({
		url:"<?php echo $settings['cms_url'].$ControllerName ?>/AddNewTargetForm",
		type:'POST',
		dataType: "json",
		clearForm:false,
		beforeSend:function()
		{
			$("#loaderAddNewTargetForm").show();
		},
		complete:function(data,html)
		{
		},
		error:function(XMLHttpRequest, textStatus,errorThrown)
		{
			$("#loaderAddNewTargetForm").hide();
			noty({text:"<?php echo __('There is problem when add new data!')?>", layout: 'topCenter', type: 'error',timeout:5000});
		},
		success:function(json)
		{
			$("#loaderAddNewTargetForm").hide();
			
			var status		=	json.status;
			var message		=	json.message;

			if(status == "1")
            {
				LoadDataTarget();
				
                if( $('#SaveFlag').val() == "1")
                    location.href   ='<?php echo $settings['cms_url'].$ControllerName."/Index/".$page."/".$viewpage?>';
                else
				{
                    noty({text:message, layout: 'topCenter', type: 'success',timeout:5000});
					$("#SalesTargetStartDate").val('');
					$("#SalesTargetEndDate").val('');
					$("#SalesTargetTotal").val('');
					$("#SalesTargetEndDate").attr('disabled','disabled');
				}
            }
			else
				noty({text:message, layout: 'topCenter', type: 'error',timeout:5000});
		}
	});
	return false;
}

function ShowLoadingTarget()
{
	var panel	=	$("#targetDiv").parents(".panel");
	panel.append('<div class="panel-refresh-layer"><img src="<?php echo $this->webroot?>img/loaders/default.gif"/></div>');
	panel.find(".panel-refresh-layer").width(panel.width()).height(panel.height());
	panel.addClass("panel-refreshing");
	onload();
}

function LoadDataTarget()
{
	ShowLoadingTarget();
	
	var panel	=	$("#targetDiv").parents(".panel");
    
	$("#targetDiv").load("<?php echo $settings['cms_url'] . $ControllerName?>/ListItemTarget/<?php echo $ID?>",
	function(){
		panel.find(".panel-refresh-layer").remove();
    	panel.removeClass("panel-refreshing");
		$("a[rel^='lightbox']").prettyPhoto({
			social_tools :''
		});
		
		$(this).find(".icheckbox").iCheck({checkboxClass: 'icheckbox_minimal-grey'});
		
		$("input[id^=targetChk]").on('ifChecked', function(event){
			$("#DeleteBtnTarget").show();
		});

		$("input[id^=targetChk]").on('ifUnchecked', function(event){
			var checked	=	"";
			$("input[id^=productChk]").each(function(index){
				if($(this).prop("checked"))
				{
					checked			+=		$(this).val()+",";
				}

			});
			checked		=	checked.substring(0,checked.length-1);
			if(checked.length == 0)
			{
				$("#DeleteBtnTarget").hide();
			}
			else
			{
				$("#DeleteBtnTarget").show();
			}
		});
		
		$("#CheckAllTarget").on('ifChecked', function(event){
			$('input[id^=targetChk]').iCheck('check');
		});

		$("#CheckAllTarget").on('ifUnchecked', function(event){
			$('input[id^=targetChk]').iCheck('uncheck');
		});
	});
}


function DeleteTarget(el,msg,id)
{
	var panel	=	$(el).parents(".panel");
	noty({
		text: msg,
		layout: 'topCenter',
		timeout:5000,
		buttons: [
				{
					addClass: 'btn btn-success btn-clean', text: '<?php echo __('Yes')?>', onClick: function($noty) {
						$noty.close();
						
						panel.append('<div class="panel-refresh-layer"><img src="<?php echo $this->webroot?>img/loaders/default.gif"/></div>');
						panel.find(".panel-refresh-layer").width(panel.width()).height(panel.height());
						panel.addClass("panel-refreshing");
							
						$.getJSON("<?php echo $settings["cms_url"].$ControllerName?>/DeleteTarget/"+id,function(result)
						{
							LoadDataTarget();
							if(result.data.status == "1")
							{
								noty({text:result.data.message, layout: 'topCenter', type: 'success',timeout:5000});
							}
							else
							{
								noty({text:result.data.message, layout: 'topCenter', type: 'error',timeout:5000});
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

function DeleteAllTarget(el)
{
    var panel	=	$(el).parents(".panel");
    var checked	=	"";
	$("input[id^=targetChk]").each(function(index){
		if($(this).prop("checked"))
		{
			checked			+=		$(this).val()+",";
		}

	});
	checked		=	checked.substring(0,checked.length-1);

	if(checked.length == 0)
	{
		noty({
			text: "<?php echo __('Please check target to be delete!')?>",
			layout: 'topCenter',
			timeout:5000,
			buttons: [{addClass: 'btn btn-success btn-clean', text: 'OK', onClick: function($noty){
				$noty.close();
			}}]
		});
	}
	else
	{
		noty({
			text: "<?php echo __('Do you realy want to delete all checked target ?')?>",
			layout: 'topCenter',
			timeout:5000,
			buttons: [
					{
						addClass: 'btn btn-success btn-clean', text: '<?php echo __('Yes')?>', onClick: function($noty) {
							$noty.close();
                            panel.append('<div class="panel-refresh-layer"><img src="<?php echo $this->webroot?>img/loaders/default.gif"/></div>');
                        	panel.find(".panel-refresh-layer").width(panel.width()).height(panel.height());
                        	panel.addClass("panel-refreshing");
							$.getJSON("<?php echo $settings["cms_url"].$ControllerName?>/DeleteMultipleTarget/",{
									"id":checked
								},function(result)
							{

                                panel.find(".panel-refresh-layer").remove();
                        		panel.removeClass("panel-refreshing");

                                LoadDataTarget();

								if(result.data.status == "1")
								{
									noty({text:result.data.message, layout: 'topCenter', type: 'success', timeout:5000});
								}
								else
								{
									noty({text:result.data.message, layout: 'topCenter', type: 'error',timeout:5000});
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


</script>
<?php $this->end();?>

<?php $this->start("css");?>
<link rel="stylesheet" type="text/css" id="theme" href="<?php echo $this->webroot?>css/prettyPhoto.css"/>
<?php $this->end();?>

<!-- START BREADCRUMB -->
<ul class="breadcrumb push-down-0">
    <li>
    	<a href="<?php echo $settings['cms_url'].$ControllerName?>">
			<?php echo Inflector::humanize(Inflector::underscore($ControllerName))?>
       	</a>
    </li>
    <li class="active"><?php echo __('Edit Data')?></li>
</ul>
<!-- END BREADCRUMB -->

<div class="content-frame">

	<!-- PAGE TITLE -->
    <div class="content-frame-top">
        <div class="page-title">
            <h2><span class="fa fa-th-large"></span> <?php echo $detail[$ModelName]['fullname']?></h2>
        </div>
        <div class="pull-right">
            <a href="<?php echo $settings['cms_url'].$ControllerName."/Index/".$page."/".$viewpage?>" class="btn btn-danger">
                <i class="fa fa-bars"></i> <?php echo __('List Data')?>
            </a>
            <a href="<?php echo $settings['cms_url'].$ControllerName?>/Add" class="btn btn-primary">
                <i class="fa fa-plus"></i> <?php echo __('Add New Data')?>
            </a>
        </div>
    </div>
    <!-- END PAGE TITLE -->
    
    <!-- START CONTENT FRAME LEFT -->
    <div class="content-frame-left" style="display:block;">
        <div class="panel panel-default">
            <div class="panel-body list-group border-bottom">
            	<a href="#tab1" class="list-group-item<?php echo $tab1?>" data-toggle="tab">
					<?php echo __('Profile Information')?>
                </a>
                <a href="#tab2" class="list-group-item<?php echo $tab2?>" data-toggle="tab">
					<?php echo __('Target Information')?>
                </a>
			</div>
		</div>
	</div>
    <!-- END CONTENT FRAME LEFT -->
    <!-- START CONTENT FRAME BODY -->
    <div class="content-frame-body">
    	<?php if(!empty($errMessage)):?>
    	<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only"><?php echo __('Close')?></span></button>
            <strong><?php echo __('Error')?></strong>
            <ol>
            	<?php foreach($errMessage as $message):?>
            	<li><?php echo $message?></li>
                <?php endforeach;?>
            </ol>
        </div>
        <?php endif;?>
        <?php echo $this->Session->flash();?>
        
        <!-- START TAB1 -->
        <div class="tab-pane active" id="tab1" >
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <?php echo __('Profile Information')?>
                    </h3>
                </div>
                
                <?php echo $this->Form->create($ModelName, array('url' => array("controller"=>$ControllerName,"action"=>"Edit",$ID,$page,$viewpage),'class' => 'form-horizontal',"type"=>"file","novalidate")); ?>
                
				<?php
					echo $this->Form->input('id', array(
						'type'			=>	'hidden',
						'readonly'		=>	'readonly'
					));
                ?>
                
                <?php echo $this->Form->hidden("save_flag",array("id"=>"SaveFlag","value"=>"0"))?>
                
                
                <div class="panel-body">
                    <div class="col-md-12">
                    
                    <?php echo $this->Form->input("firstname",
						array(
							"div"			=>	array("class"=>"form-group"),
							"label"			=>	array("class"	=>	"col-md-3 control-label","text"=>__("First Name")),
							"between"		=>	'<div class="col-md-5">',
							"after"			=>	"</div>",
							"autocomplete"	=>	"off",
							"type"			=>	"text",
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
						)
					)?>
					<?php echo $this->Form->input("lastname",
						array(
							"div"			=>	array("class"=>"form-group"),
							"label"			=>	array("class"	=>	"col-md-3 control-label","text"=>__("Last Name")),
							"between"		=>	'<div class="col-md-5">',
							"after"			=>	"</div>",
							"autocomplete"	=>	"off",
							"type"			=>	"text",
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
						)
					)?>
	
					<?php echo $this->Form->input("email",
						array(
							"div"			=>	array("class"=>"form-group"),
							"label"			=>	array("class"	=>	"col-md-3 control-label","text"=>__("Email")),
							"between"		=>	'<div class="col-md-5">',
							"after"			=>	"</div>",
							"autocomplete"	=>	"off",
							"type"			=>	"email",
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
						)
					)?>
	
					<?php echo $this->Form->input("password",
						array(
							"div"			=>	array("class"=>"form-group"),
							"label"			=>	array("class"	=>	"col-md-3 control-label","text"=>__('Password')),
							"between"		=>	'<div class="col-md-5">',
							"after"			=>	"</div>",
							"autocomplete"	=>	"new-password",
							"type"			=>	"password",
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
						)
					)?>
                    <?php
                        $imgPreview	=	(!empty($detail["Thumbnail"]["id"])) ? $detail["Thumbnail"]["host"].$detail["Thumbnail"]["url"]."?time=".time() : $this->webroot ."img/default_content.png";

						 $imgPreviewBig	=	(!empty($detail["MaxWidth"]["id"])) ? $detail["MaxWidth"]["host"].$detail["MaxWidth"]["url"]."?time=".time() : $this->webroot ."img/default_content.png";

						echo $this->Form->input("images",
                            array(
                                "div"			=>	array("class"=>"form-group"),
                                "label"			=>	array("class"	=>	"col-md-3 control-label","text"=>__("Images")),
                                "between"		=>	'<div class="col-md-7">
								<div class="col-md-4" style="padding:0px 10px 0px 0px;" id="imagePrev">
									<div class="gallery">
										<a class="gallery-item" href="'.$imgPreviewBig.'" style="padding:0px;width:100%;height:150px;overflow:hidden;" id="previewLink" rel="lightbox">
											<div class="image">
												<img src="'.$imgPreview.'" id="previewImg"/>
											</div>
										</a>
									</div>
								</div>
								<div class="col-md-4" style="padding:0px; 10px; 0px; 0px;">
								',
                                "after"			=>	'<span class="help-block">'.__('Will be scaled to %s X %s',array('300px','300px')).'</span></div></div>',
                                "autocomplete"	=>	"off",
                                "type"			=>	"file",
                                "class"			=>	"fileinput",
								'error' 		=>	array(
									'attributes' => array(
										'wrap' 	=> 'label',
										'class' => 'error'
									)
								),
								"onchange"		=>	"PreviewImage('".$ModelName."Images','previewImg','#previewLink')",
								"accept"		=>	"image/*",
								"format"		=>	array(
									'before',
									'label',
									'between',
									'input',
									'error',
									'after',
								),
                            )
                        );
						?>
                        
                        <?php echo $this->Form->input("status",
                            array(
                                "div"				=>	array("class"=>"form-group"),
								"before"			=>	'<label class="col-md-3 control-label">Status</label><div class="col-md-5"><label class="check">',
								"after"				=>	'</label></div>',
								"separator"			=>	'</label><label class="check">',
								"label"				=>	false,
                                "options"			=>	array("1"=>__("Active"),"0"=>__("Not Active")),
                                "class"				=>	'iradio',
								'error' 			=>	array(
									'attributes' 	=> array(
										'wrap' 	=> 'label',
										'class' => 'error'
									)
								),
								"type"			=>	"radio",
								"legend"		=>	false,
								"default"		=>	"1"
                            )
                        )?>
                        
                    </div>
                </div>
                <div class="panel-footer">
                    <a href="<?php echo $settings['cms_url'].$ControllerName?>" class="btn btn-danger"><span class="fa fa-times fa-left"></span> <?php echo __('Cancel')?></a>
                    
                    <button type="submit" onclick="OnClickSaveDirect()" class="btn btn-primary pull-right" style="margin-left:10px;"><?php echo __('Save and set target')?><span class="fa fa-floppy-o fa-right"></span></button>
                    <button type="submit" onclick="OnClickSaveStay()" class="btn btn-primary pull-right" ><?php echo __('Save and stay')?><span class="fa fa-floppy-o fa-right"></span></button>
                </div>
                </form>
           	</div>
        </div>
        <!-- END TAB1 -->
        
        <!-- START TAB2 -->
        <div class="tab-pane active" id="tab2" style="display:none;">
        	<?php echo $this->Form->create('SalesTarget', array(
				'url' 			=>	'#',
				'class' 		=>	'form-horizontal',
				'onsubmit'		=>	'return AddNewTargetForm()',
				"id"			=>	'AddNewTargetForm',
				"style"     	=>  "display:none;",
				"novalidate")); 
            ?>
            <?php echo $this->Form->hidden("sales_id",array("value"=>$detail[$ModelName]['id']));?>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title" id="panel_title_equipment">
                        <?php echo __('Add New Target')?>
                    </h3>
                    <ul class="panel-controls">
                        <li>
                            <a href="javascript:void(0);" onclick="CancelAddTargetButton()">
                            	<span class="fa fa-times"></span>
                            </a>
                        </li>
                    </ul>
            	</div>
                <div class="panel-body">
                	<div class="col-md-12">
                    	<?php echo $this->Form->input("start_date",
							array(
								"div"			=>	array("class"=>"form-group"),
								"label"			=>	array("class"	=>	"col-md-3 control-label","text"=>__("From")),
								"between"		=>	'<div class="col-md-5">',
								"after"			=>	"</div>",
								"autocomplete"	=>	"off",
								"type"			=>	"text",
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
							)
						)?>
                        <?php echo $this->Form->input("end_date",
							array(
								"div"			=>	array("class"=>"form-group"),
								"label"			=>	array("class"	=>	"col-md-3 control-label","text"=>__("To")),
								"between"		=>	'<div class="col-md-5">',
								"after"			=>	"</div>",
								"autocomplete"	=>	"off",
								"type"			=>	"text",
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
								"disabled"		=>	"disabled"
							)
						)?>
                        
                        <?php echo $this->Form->input("total",
							array(
								"div"			=>	array("class"=>"form-group"),
								"label"			=>	array("class"	=>	"col-md-3 control-label","text"=>__("Total Target")),
								"between"		=>	'<div class="col-md-5">',
								"after"			=>	"</div>",
								"autocomplete"	=>	"off",
								"type"			=>	"text",
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
							)
						)?>
                    </div>
                </div>
                <div class="panel-footer">
                    <a href="<?php echo $settings['cms_url'].$ControllerName?>" class="btn btn-danger"><span class="fa fa-times fa-left"></span> <?php echo __('Cancel')?></a>
                    
                    <button type="submit" class="btn btn-primary pull-right" style="margin-left:10px;" onclick="$('#SaveFlag').val('1')"><?php echo __('Save')?><span class="fa fa-floppy-o fa-right"></span></button>
                    
                    <button type="submit" class="btn btn-primary pull-right" style="margin-left:10px;" onclick="$('#SaveFlag').val('0')"><?php echo __('Save and stay')?><span class="fa fa-floppy-o fa-right"></span></button>
                    
                    <img src="<?php echo $this->webroot?>img/loaders/loader9.gif" class="pull-right" id="loaderAddNewTargetForm" style="display:none;"/>
                </div>
           	</div>
            </form>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <?php echo __('Target Information')?>
                    </h3>
                    <div class="pull-right" >
                        <button class="btn btn-primary pull-right <?php echo $disabled?> " 
                            onclick="DeleteAllTarget(this)"
                            style="margin-left:5px;display:none;"
                            id="DeleteBtnTarget">
                            <span class="fa fa-trash-o"></span>
                            <?php echo __('Delete')?>
                        </button>
                        
                        <button class="btn btn-primary pull-right" onClick="AddNewTargetButton();" id="AddNewTargetButton" >
                            <span class="fa fa-plus"></span>
                            <?php echo __('Add New Target')?>
                        </button>
                        
                    </div>
                </div>
                <div class="panel-body" id="targetDiv">
            	</div>
    		</div>
        </div>
        <!-- END TAB2 -->
        
	</div>
    <!-- END CONTENT FRAME BODY -->
</div>