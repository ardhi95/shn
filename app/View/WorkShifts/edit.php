<?php $this->start("script");?>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/jquery-prettyPhoto.js"></script>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/plugins/bootstrap/bootstrap-file-input.js"></script>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/plugins/tagsinput/jquery.tagsinput.min.js"></script>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/autoNumeric-1.9.18.js"></script>

<script>


$(document).ready(function(){
	$("a[rel^='lightbox']").prettyPhoto({
		social_tools :''
	});
	$("#ProductPrice").autoNumeric('init', {  lZero: 'deny', aSep: ',', mDec: 0});
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
    <li class="active"><?php echo __('Edit Data')?></li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE TITLE -->
<div class="content-frame">
    <div class="content-frame-top">
        <div class="page-title">
            <h2><span class="fa fa-th-large"></span> <?php echo Inflector::humanize(Inflector::underscore($ControllerName))?></h2>
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
</div>
<!-- END PAGE TITLE -->

<!-- START PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <div class="row">
    	<div class="col-md-12">
        	<?php
				echo $this->Session->flash();
			?>
        	<?php echo $this->Form->create($ModelName, array('url' => array("controller"=>$ControllerName,"action"=>"Edit",$ID,$page,$viewpage),'class' => 'form-horizontal',"type"=>"file","novalidate")); ?>
            
            <?php echo $this->Form->hidden("save_flag",array("id"=>"SaveFlag","value"=>"0"))?>

            <?php
				echo $this->Form->input('id', array(
					'type'			=>	'hidden',
					'readonly'		=>	'readonly'
				));
			?>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <?php echo __('Edit Data')?>
                    </h3>
                </div>
                <div class="panel-body">
                	<div class="col-md-12">
                    	<?php echo $this->Form->input("name",
                            array(
                                "div"           =>  array("class"=>"form-group"),
                                "label"         =>  array("class"   =>  "col-md-3 control-label","text"=>__("Shift Name (*)")),
                                "between"       =>  '<div class="col-md-5">',
                                "after"         =>  "</div>",
                                "autocomplete"  =>  "off",
                                "type"          =>  "text",
                                "class"         =>  'form-control',
                                'error'         =>  array(
                                    'attributes' => array(
                                        'wrap'  => 'label',
                                        'class' => 'error'
                                    )
                                ),
                                "format"        =>  array(
                                    'before',
                                    'label',
                                    'between',
                                    'input',
                                    'error',
                                    'after',
                                ),
                                'maxLength'     =>  '100',
                                "escape"        =>  false
                            )
                        )?>
                        
                        <?php echo $this->Form->input("status",
                            array(
                                "div"           =>  array("class"=>"form-group"),
                                "before"        =>  '<label class="col-md-3 control-label">Status</label><div class="col-md-5"><label class="check">',
                                "after"         =>  '</label></div>',
                                "separator"     =>  '</label><label class="check">',
                                "label"         =>  false,
                                "options"       =>  array("1"=>__("Active"),"0"=>__("Not Active")),
                                "class"         =>  'iradio',
                                'error'         =>  array(
                                    'attributes' => array(
                                        'wrap'  => 'label',
                                        'class' => 'error'
                                    )
                                ),
                                "type"          =>  "radio",
                                "legend"        =>  false,
                                "default"       =>  "1"
                            )
                        )?>
                    </div>
                </div>
                <div class="panel-footer">
                	<a href="<?php echo $settings['cms_url'].$ControllerName?>" class="btn btn-danger"><span class="fa fa-times fa-left"></span> <?php echo __('Cancel')?></a>
                    <button type="submit" onclick="OnClickSaveDirect()" class="btn btn-primary pull-right" style="margin-left:10px;"><?php echo __('Save')?><span class="fa fa-floppy-o fa-right"></span></button>
                    <button type="submit" onclick="OnClickSaveStay()" class="btn btn-primary pull-right" ><?php echo __('Save and stay')?><span class="fa fa-floppy-o fa-right"></span></button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
