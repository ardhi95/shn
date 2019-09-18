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
            <h2><span class="fa fa-th-large"></span> City</h2>
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
</div>
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
                    
                    <?php echo $this->Form->input("name",
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
                    
                    <button type="submit" onclick="OnClickSaveStay()" class="btn btn-primary pull-right" ><?php echo __('Save and stay')?><span class="fa fa-floppy-o fa-right"></span></button>
                </div>
                </form>
           	</div>
        </div>
        <!-- END TAB1 -->
	</div>
    <!-- END CONTENT FRAME BODY -->