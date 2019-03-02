<?php $this->start("script");?>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/jquery-prettyPhoto.js"></script>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/plugins/bootstrap/bootstrap-file-input.js"></script>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/plugins/tagsinput/jquery.tagsinput.min.js"></script>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/ckeditor/ckeditor.js"></script>

<script>
$(document).ready(function(){
	$("a[rel^='lightbox']").prettyPhoto({
		social_tools :''
	});
	
	//=============== WYSIWYG EDITOR ========================//
    CKEDITOR.config.allowedContent = {
    	$1:
    	{
    		elements: CKEDITOR.dtd,
    		attributes: true,
    		styles: false,
    		classes: false
    	}
    };

    CKEDITOR.config.toolbar_Basic =
    [
    	{ name: 'document', items : [ 'Source','Preview'] },
    	{ name: 'clipboard', items : ['Undo','Redo' ] },
    	{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
    	{ name: 'links', items : [ 'Link','Unlink'] },
    	{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'] },
    	{ name: 'insert', items : [ 'HorizontalRule','SpecialChar','PageBreak'] },
    	{ name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] },
    	{ name: 'colors', items : [ 'TextColor','BGColor' ] },
    	{ name: 'tools', items : [ 'Maximize'] }
    ];
    CKEDITOR.config.toolbar = 'Basic';
    CKEDITOR.config.disallowedContent = 'script; *[on*]; *[on*];span;div;input;form;fieldset;table;html;title;header;footer;meta;';
    CKEDITOR.replace( '<?php echo $ModelName?>Description');
    CKEDITOR.on("instanceReady", function(event)
    {
        onload();
    });
    //=============== WYSIWYG EDITOR ========================//
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
    <li>
    	<a href="<?php echo $settings['cms_url'].$ControllerName?>">
			<?php echo Inflector::humanize(Inflector::underscore($ControllerName))?>
        </a>
    </li>
    <li class="active"><?php echo __("Broadcast Message")?></li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE TITLE -->
<div class="content-frame">
    <div class="content-frame-top">
        <div class="page-title">
            <h2><span class="fa fa-th-large"></span> Broadcast Message</h2>
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
        	<?php echo $this->Form->create($ModelName, array('url' => array("controller"=>$ControllerName,"action"=>"Add"),'class' => 'form-horizontal',"type"=>"file","novalidate")); ?>

            <?php echo $this->Form->hidden("save_flag",array("id"=>"SaveFlag","value"=>"0"))?>

            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <?php echo __("New Message")?>
                    </h3>
                </div>
                <div class="panel-body">
                	<div class="col-md-12">
                    
                    	<?php echo $this->Form->input("recipient_id",
                            array(
                                "div"			=>	array("class"=>"form-group"),
                                "label"			=>	array("class"	=>	"col-md-3 control-label","text"=>__("Sales (*)")),
                                "between"		=>	'<div class="col-md-5">',
                                "after"			=>	"</div>",
                                "autocomplete"	=>	"off",
                                "options"		=>	$sales_id_list,
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
								"multiple"					=>	true,
								"data-live-search"			=>	true,
								"title"						=>	__("Select sales"),
								"data-selected-text-format"	=>	"count",
								"data-actions-box"			=>	true,
								"data-size"					=>	10
                            )
                        )?>
                        
                        <?php echo $this->Form->input("title",
                            array(
                                "div"			=>	array("class"=>"form-group"),
                                "label"			=>	array("class"	=>	"col-md-3 control-label","text"=>__("Title (*)")),
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
								"escape"		=>	false
                            )
                        )?>
                        
                    	<?php echo $this->Form->input("message",
                            array(
                                "div"			=>	array("class"=>"form-group"),
                                "label"			=>	array("class"	=>	"col-md-3 control-label","text"=>__("Sort Description (*)")),
                                "between"		=>	'<div class="col-md-5">',
                                "after"			=>	"</div>",
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
								"escape"		=>	false,
								"maxlength"		=>	50
                            )
                        )?>
                        
                        <?php echo $this->Form->input("description",
                            array(
                                "div"			=>	array("class"=>"form-group"),
                                "label"			=>	array(
														"class"	=>	"col-md-3 control-label",
														"text"	=>	"Detail Message (*)"
													),
                                "between"		=>	'<div class="col-md-9">',
                                "after"			=>	'<span class="help-block"></span></div>',
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
                            )
                        )?>
                        
                    </div>
                </div>
                <div class="panel-footer">
                	<a href="<?php echo $settings['cms_url'].$ControllerName?>" class="btn btn-danger"><span class="fa fa-times fa-left"></span> <?php echo __('Cancel')?></a>
                    <button type="submit" onclick="OnClickSaveStay()" class="btn btn-primary pull-right" ><?php echo __('Save and send')?><span class="fa fa-floppy-o fa-right"></span></button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
