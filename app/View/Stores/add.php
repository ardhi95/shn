<?php $this->start("script");?>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/jquery-prettyPhoto.js"></script>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/plugins/bootstrap/bootstrap-file-input.js"></script>
<script type="text/javascript" src="<?php echo $settings['cms_url']?>js/plugins/tagsinput/jquery.tagsinput.min.js"></script>

<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $settings['map_browser_api_key']?>&language=id&libraries=places"></script>

<script>

//============ MAP ==============/
var map;
var marker;

var latitude	=	'<?php echo $settings['default_lat']?>';
var longitude	=	'<?php echo $settings['default_lng']?>';

<?php if(!empty($this->request->data[$ModelName]['latitude']) && !empty($this->request->data[$ModelName]['longitude'])):?>
latitude		=	'<?php echo $this->request->data[$ModelName]['latitude']?>';
longitude		=	'<?php echo $this->request->data[$ModelName]['longitude']?>';
<?php endif;?>

var infowindow 	=	new google.maps.InfoWindow();

var mapLatlng 	=	new google.maps.LatLng(latitude, longitude);
var mapOptions 	= {
  zoom: 15,
  center: mapLatlng,
  mapTypeId: 'roadmap'

};

function initMap()
{
	map 		= 	new google.maps.Map(document.getElementById('map'), mapOptions);
	marker		=	new google.maps.Marker({
						position	:	mapLatlng,
						map			:	map,
						draggable	:	true
					});
					
	<?php if(empty($this->request->data[$ModelName]['latitude']) && empty($this->request->data[$ModelName]['longitude'])):?>
		infowindow.setContent('Drag me to change location');
		infowindow.open(map, marker);
	<?php elseif(!empty($this->request->data[$ModelName]['latitude']) && !empty($this->request->data[$ModelName]['longitude'])):?>
		infowindow.setContent("Latitude : <?php echo $this->request->data[$ModelName]['latitude']?><br/>Longitude : <?php echo $this->request->data[$ModelName]['longitude']?>");
		infowindow.open(map, marker);
		
	<?php endif;?>
	
	marker.addListener('dragend', function(event){
		$("#latStudio").val(event.latLng.lat());
		$("#lngStudio").val(event.latLng.lng());
		infowindow.setContent("Latitude : "+event.latLng.lat()+"<br/>Longitude : "+event.latLng.lng());
		infowindow.open(map, marker);
	});
	
	marker.addListener('drag', function(event){
		infowindow.close();
	});
	
	var input 		=	document.getElementById('pac-input');
	$("#pac-input").focusin(function(){
		$(this).val('');
	});
	
	var searchBox 	=	new google.maps.places.SearchBox(input);
	map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
	map.addListener('bounds_changed', function() {
	  searchBox.setBounds(map.getBounds());
	});
	
	searchBox.addListener('places_changed', function() {
		var places = searchBox.getPlaces();
		if (places.length == 0) {
			return;
		}
		
		var bounds = new google.maps.LatLngBounds();
		places.forEach(function(place) {
			if (!place.geometry) {
				return;
			}
			
			if (place.geometry.viewport) {
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
			
			marker.setPosition(place.geometry.location);
			$("#latStudio").val(bounds.getCenter().lat());
			$("#lngStudio").val(bounds.getCenter().lng());
		});
		map.fitBounds(bounds);
		infowindow.setContent("Latitude : "+bounds.getCenter().lat()+"<br/>Longitude : "+bounds.getCenter().lng());
		infowindow.open(map, marker);
	});
}
//============ MAP ==============/


$(document).ready(function(){
	$("a[rel^='lightbox']").prettyPhoto({
		social_tools :''
	});
	
	//======== INIT MAP =============/
	initMap();
	//======== INIT MAP =============/
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
    <li class="active"><?php echo __("Add New Data")?></li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE TITLE -->
<div class="content-frame">
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
                        <?php echo __("Add New Data")?>
                    </h3>
                </div>
                <div class="panel-body">
                	<div class="col-md-12">
                    	<?php echo $this->Form->input("name",
                            array(
                                "div"			=>	array("class"=>"form-group"),
                                "label"			=>	array("class"	=>	"col-md-3 control-label","text"=>__("Store Name (*)")),
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
								'maxLength'		=>	'100',
								"escape"		=>	false
                            )
                        )?>
                        
                        <?php echo $this->Form->input("address",
                            array(
                                "div"			=>	array("class"=>"form-group"),
                                "label"			=>	array(
														"class"	=>	"col-md-3 control-label",
														"text"	=>	"Address (*)"
													),
                                "between"		=>	'<div class="col-md-5">',
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
                        
                        <div class="form-group">
                            <label class="col-md-3 control-label">Map Position (*)</label>
                            <div class="col-md-9"  style="padding-left:15px; padding-right:15px;">
                                <input type="text" id="pac-input" placeholder="Search Your Place" class="form-control"/>
                                <?php
                                $border	=	"#CCC";
                                if ($this->Form->isFieldError($ModelName.'.latitude'))
                                {
                                    $border	=	"#b64645";
                                }
                                ?>
                                <div id="map" style="display:block; float:left; height:400px; width:100%; border:1px solid <?php echo $border?>; border-radius:4px;">
                                </div>
                                
                                <?php echo $this->Form->error("$ModelName.latitude",null,array("wrap"=>"label","class"=>"error"))?>
                            </div>
                        </div>
                        
                        <?php echo $this->Form->hidden("latitude",array("id"=>"latStudio","readonly"=>"readonly"))?>
                        <?php echo $this->Form->hidden("longitude",array("id"=>"lngStudio","readonly"=>"readonly"))?>
                        
                        <?php echo $this->Form->input("owner",
                            array(
                                "div"			=>	array("class"=>"form-group"),
                                "label"			=>	array("class"	=>	"col-md-3 control-label","text"=>__("Owner Name (*)")),
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
								'maxLength'		=>	'100',
								"escape"		=>	false
                            )
                        )?>
                        
                        <?php echo $this->Form->input("phone1",
                            array(
                                "div"			=>	array("class"=>"form-group"),
                                "label"			=>	array("class"	=>	"col-md-3 control-label","text"=>__("Phone Number")),
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
								'maxLength'		=>	'100',
								"escape"		=>	false
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
                                "div"			=>	array("class"=>"form-group"),
								"before"		=>	'<label class="col-md-3 control-label">Status</label><div class="col-md-5"><label class="check">',
								"after"			=>	'</label></div>',
								"separator"		=>	'</label><label class="check">',
								"label"			=>	false,
                                "options"		=>	array("1"=>__("Active"),"0"=>__("Not Active")),
                                "class"			=>	'iradio',
								'error' 		=>	array(
									'attributes' => array(
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
                    <button type="submit" onclick="OnClickSaveDirect()" class="btn btn-primary pull-right" style="margin-left:10px;"><?php echo __('Save')?><span class="fa fa-floppy-o fa-right"></span></button>
                    <button type="submit" onclick="OnClickSaveStay()" class="btn btn-primary pull-right" ><?php echo __('Save and add more')?><span class="fa fa-floppy-o fa-right"></span></button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
