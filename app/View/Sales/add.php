<?php $this->start("script");?>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/plugins/bootstrap/bootstrap-file-input.js"></script>
<script>
$(document).ready(function(){
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
</script>
<?php $this->end();?>

<?php $this->start("css");?>
<link rel="stylesheet" type="text/css" id="theme" href="<?php echo $this->webroot?>css/prettyPhoto.css"/>
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
    
    <!-- START CONTENT FRAME LEFT -->
    <div class="content-frame-left" style="display:block;">
        <div class="panel panel-default">
            <div class="panel-body list-group border-bottom">
            	<a href="#tab1" class="list-group-item active" data-toggle="tab">
					<?php echo __('Profile Information')?>
                </a>
                <a href="#tab2" class="list-group-item" data-toggle="tab">
					<?php echo __('Target Information')?>
                </a>
			</div>
		</div>
	</div>
    <!-- END CONTENT FRAME LEFT -->
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
        <div class="tab-pane active" id="tab1" >
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
                    <?php echo $this->Form->input("images",
                            array(
                                "div"			=>	array("class"=>"form-group"),
                                "label"			=>	array("class"	=>	"col-md-3 control-label","text"=>__("Photo")),
                                "between"		=>	'<div class="col-md-7">
								<div class="col-md-4" style="display:none;padding:0px 10px 0px 0px;" id="imagePrev">
									<div class="gallery">
										<a class="gallery-item" href="javascript:void(0);" style="padding:0px;width:100%;height:150px;overflow:hidden;" id="previewLink" rel="lightbox">
											<div class="image">
												<img src="" id="previewImg"/>
											</div>
										</a>
									</div>
								</div>
								<div class="col-md-6" style="padding:0px; 10px; 0px; 0px;">
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
                    
                    <button type="submit" onclick="OnClickSaveDirect()" class="btn btn-primary pull-right" style="margin-left:10px;"><?php echo __('Save and set target')?><span class="fa fa-floppy-o fa-right"></span></button>
                    <button type="submit" onclick="OnClickSaveStay()" class="btn btn-primary pull-right" ><?php echo __('Save and stay')?><span class="fa fa-floppy-o fa-right"></span></button>
                </div>
                </form>
           	</div>
        </div>
        <!-- END TAB1 -->
        
        <!-- START TAB2 -->
        <div class="tab-pane active" id="tab2" style=" display:none;">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <?php echo __('Target Information')?>
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                    	<div class="alert alert-danger" role="alert">
							<?php echo __('You must save sales first before set target')?>
                        </div>
                    </div>
            	</div>
           	</div>
        </div>
        <!-- END TAB2 -->
        
	</div>
    <!-- END CONTENT FRAME BODY -->
</div>
