

<?php $this->start("script");?>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/plugins/bootstrap/bootstrap-file-input.js"></script>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/plugins/bootstrap/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/autoNumeric-1.9.18.js"></script>
<script>
$(document).ready(function(){

	$("#SalesTargetTotal").autoNumeric('init', {  
			lZero: 'deny', 
			aSep: ',', 
			mDec: 0,
			vMin:0,
			vMax:9999999999,
		});
	
	//======= DATETIMEPICKER =======/
    $(".datetimepicker").datepicker({
        format: "MM yyyy",
	    viewMode: "months",
    	minViewMode: "months",
        autoclose: true,
    });
    //======= DATETIMEPICKER =======/

	
});


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
                    
                    <?php echo $this->Form->input("target",
						array(
							"div"			=>	array("class"=>"form-group"),
							"label"			=>	array("class"	=>	"col-md-3 control-label","text"=>__("Target")),
							"between"		=>	'<div class="col-md-5">',
							"after"			=>	"</div>",
							"autocomplete"	=>	"off",
							"type"			=>	"text",
							"class"			=>	'form-control',
							"id"			=>	'SalesTargetTotal',
							'error' 		=>	array(
								'attributes' => array(
									'wrap' 	=> 'label',
									'class' => 'error',
									'id'	=> 'error',
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
                    <?php echo $this->Form->input("target_date",
                    	array(
                    		"div"			=>	array("class"=>"form-group"),
                    		"label"			=>	array("class"	=>	"col-md-3 control-label","text"=>__("Date")),
                    		"between"		=>	'<div class="col-md-5">',
                    		"after"			=>	'</div>',
                    		"autocomplete"	=>	"off",
                    		"type"			=>	"text",
                    		"class"			=>	'form-control datetimepicker disabled',
                    		"disabled"		=>	true,
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
                    
                    <button type="submit" onclick="OnClickSaveStay()" class="btn btn-primary pull-right" ><?php echo __('Save and stay')?><span class="fa fa-floppy-o fa-right"></span></button>
                </div>
                </form>
           	</div>
        </div>
        <!-- END TAB1 -->
	</div>
    <!-- END CONTENT FRAME BODY -->