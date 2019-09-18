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
	    viewMode: "months", //this
    	minViewMode: "months",//and this
        autoclose: true,
    });
    //======= DATETIMEPICKER =======/

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
	//======= END TAB =========/
});

</script>
<?php $this->end();?>

<?php $this->start("css");?>
<link rel="stylesheet" type="text/css" id="theme" href="<?php echo $this->webroot?>css/prettyPhoto.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $this->webroot?>css/bootstrap-datetimepicker.min.css" media="all" />
<?php $this->end();?>

<!-- START BREADCRUMB -->
<ul class="breadcrumb push-down-0">
    <li><a href="<?php echo $settings["cms_url"].$ControllerName?>"><?php echo Inflector::humanize(Inflector::underscore($ControllerName))?></a></li>
    <li class="active"><?php echo __('Add New Data')?></li>
</ul>
<!-- END BREADCRUMB -->


<div class="content-frame">

	<!-- PAGE TITLE -->
    <div class="content-frame-top">
        <div class="page-title">
            <h2><span class="fa fa-th-large"></span> <?php echo Inflector::humanize(Inflector::underscore($ControllerName))?></h2>
        </div>
        <div class="pull-right">
            <a href="<?php echo $settings['cms_url'].$ControllerName?>" class="btn btn-primary">
                <i class="fa fa-bars"></i> <?php echo __('List Data')?>
            </a>
        </div>
    </div>
    <!-- END PAGE TITLE -->
</div>
    <!-- START CONTENT FRAME BODY -->
    <div class="content-frame-body">
    	<?php if(!empty($errMessage)):?>
    	<div class="alert alert-danger" id="errorDiv">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only"><?php echo __('Close')?></span></button>
            <strong><?php echo __('Error')?></strong>
            <ol>
            	<?php foreach($errMessage as $message):?>
            	<li><?php echo $message?></li>
                <?php endforeach;?>
            </ol>
        </div>
        <?php endif;?>
        
        <!-- START TAB1 -->
        <div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <?php echo __('Profile Information')?>
                    </h3>
                </div>
                <?php echo $this->Form->create($ModelName, array('url' => array("controller"=>$ControllerName,"action"=>"Add"),'class' => 'form-horizontal',"type"=>"file","novalidate")); ?>
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
                                        "class"			=>	'form-control datetimepicker',
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
