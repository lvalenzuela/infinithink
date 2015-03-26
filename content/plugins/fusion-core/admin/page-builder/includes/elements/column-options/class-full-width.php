<?php
/**
 * FullWidthContainer implementation, it extends DDElementTemplate like all other elements
 */
	class TF_FullWidthContainer extends DDElementTemplate {
		
		public function __construct() {
			 
			parent::__construct();
		}

		// Implementation for the element structure.
		public function create_element_structure() {
			// Add name of the class to deserialize it again when the element is sent back to the server from the web page
			$this->config['php_class'] 	= get_class($this);
			// element id
			$this->config['id']	   	= 'full_width_container';
			// element name
			$this->config['name']	 	= __('Full Width Container', 'fusion-core');
			// element icon
			$this->config['icon_url']  	= "icons/sc-icon_box.png";
			// css class related to this element
			$this->config['css_class'] 	= "item-wrapper fusion_full_width sortable-element drag-element fusion_layout_column fusion_full_width item-container sort-container ui-draggable";
			// element icon class
			$this->config['icon_class']	= 'fusion-icon builder-options-icon fusiona-move-horizontal';
			// tooltip that will be displyed upon mouse over the element
			//$this->config['tool_tip']  	= 'Creates a Full Width Container';
			// any special html data attribute (i.e. data-width) needs to be passed
			// drop_level: elements with higher drop level can be dropped in elements with lower drop_level, 
			// i.e. element with drop_level = 2 can be dropped in element with drop_level = 0 or 1 only.
			$this->config['data'] 		= array("drop_level"   => "2");
		}

		// override default implemenation for this function as this element have special view
		public function create_visual_editor( $params ) {
			
			$innerHtml  = '<div class="fusion_iconbox textblock_element textblock_element_style">';
			$innerHtml .= '<div class="bilder_icon_container"><span class="fusion_iconbox_icon"><i class="icon-move-horizontal"></i><sub class="sub">Full Width Container</sub></span></div>';
			$innerHtml .= '</div>';
			$this->config['innerHtml'] = '';
		}
		
		//this function defines FullWidth sub elements or structure
		function popup_elements() {
			$this->config['layout_opt']  = true;
			$border_size 	= Helper::fusion_create_dropdown_data( 1, 10 );
			$padding_data 	= Helper::fusion_create_dropdown_data( 1, 100 );
			
			$this->config['subElements'] = array(
			
				array("name" 			=> __('Background Color', 'fusion-core'),
					  "desc" 			=> __('Controls the background color. Leave blank for theme option selection.', 'fusion-core'),
					  "id" 				=> "fusion_backgroundcolor",
					  "type" 			=> ElementTypeEnum::COLOR,
					  "value" 			=> ""
					  ),
					  
				array("name" 			=> __('Background Image', 'fusion-core'),
					  "desc" 			=> __('Upload an image to display in the background', 'fusion-core'),
					  "id" 				=> "fusion_backgroundimage",
					  "type" 			=> ElementTypeEnum::UPLOAD,
					  "upid" 			=> "1",
					  "value" 			=> ""
					  ),
					  
				array("name" 			=> __('Background Repeat', 'fusion-core'),
					  "desc" 			=> __('Choose how the background image repeats.', 'fusion-core'),
					  "id" 				=> "fusion_backgroundrepeat",
					  "type" 			=> ElementTypeEnum::SELECT,
					  "value" 			=> "no-repeat",
					  "allowedValues" 	=> array('no-repeat' 		=> __('No Repeat', 'fusion-core'),
												 'repeat' 			=> __('Repeat Vertically and Horizontally', 'fusion-core'),
												 'repeat-x' 		=> __('Repeat Horizontally', 'fusion-core'),
												 'repeat-y' 		=> __('Repeat Vertically', 'fusion-core')) 
					  ),
					  
				array("name" 			=> __('Background Position', 'fusion-core'),
					  "desc" 			=> __('Choose the postion of the background image', 'fusion-core'),
					  "id" 				=> "fusion_backgroundposition",
					  "type" 			=> ElementTypeEnum::SELECT,
					  "value" 			=> "left top",
					  "allowedValues" 	=> array('left top' 		=> __('Left Top', 'fusion-core'),
												 'left center' 		=> __('Left Center', 'fusion-core'),
												 'left bottom' 		=> __('Left Bottom', 'fusion-core'),
												 'right top' 		=> __('Right Top', 'fusion-core'),
												 'right center' 	=> __('Right Center', 'fusion-core'),
												 'right bottom' 	=> __('Right Bottom', 'fusion-core'),
												 'center top' 		=> __('Center Top', 'fusion-core'),
												 'center center' 	=> __('Center Center', 'fusion-core'),
												 'center bottom' 	=> __('Center Bottom', 'fusion-core')) 
					  ),
					  
				array("name" 			=> __('Background Scroll', 'fusion-core'),
					  "desc" 			=> __('Choose how the background image scrolls', 'fusion-core'),
					  "id" 				=> "fusion_backgroundattachment",
					  "type" 			=> ElementTypeEnum::SELECT,
					  "value" 			=> "scroll",
					  "allowedValues" 	=> array('scroll' 			=> __('Scroll: background scrolls along with the element', 'fusion-core'),
												 'fixed' 			=> __('Fixed: background is fixed giving a parallax effect', 'fusion-core'),
												 'local' 			=> __('Local: background scrolls along with the element\'s contents', 'fusion-core')) 
					  ),

				array("name" 			=> __('Video WebM Upload', 'fusion-core'),
					  "desc" 			=> __('Video must be in a 16:9 aspect ratio. Add your WebM video file. WebM and MP4 format must be included to render your video with cross browser compatibility. OGV is optional.', 'fusion-core'),
					  "id" 				=> "fusion_video_webm",
					  "type" 			=>  ElementTypeEnum::INPUT,
					  "value" 			=> ""
					  ),

				array("name" 			=> __('Video MP4 Upload', 'fusion-core'),
					  "desc" 			=> __('Video must be in a 16:9 aspect ratio. Add your WebM video file. WebM and MP4 format must be included to render your video with cross browser compatibility. OGV is optional.', 'fusion-core'),
					  "id" 				=> "fusion_video_mp4",
					  "type" 			=>  ElementTypeEnum::INPUT,
					  "value" 			=> ""
					  ),

				array("name" 			=> __('Video OGV Upload', 'fusion-core'),
					  "desc" 			=> __('Add your OGV video file. This is optional.', 'fusion-core'),
					  "id" 				=> "fusion_video_ogv",
					  "type" 			=>  ElementTypeEnum::INPUT,
					  "value" 			=> ""
					  ),

				array("name" 			=> __('Video Preview Image', 'fusion-core'),
					  "desc" 			=> __('IMPORTANT: This field must be used for self hosted videos. Self hosted videos do not work correctly on mobile devices. The preview image will be seen in place of your video on older browsers or mobile devices.', 'fusion-core'),
					  "id" 				=> "fusion_video_preview_image",
					  "type" 			=> ElementTypeEnum::UPLOAD,
					  "upid" 			=> "2",
					  "value" 			=> ""
					  ),

				array("name" 			=> __('Video Overlay Color', 'fusion-core'),
					  "desc" 			=> __('Select a color to show over the video as an overlay. Hex color code, <strong>ex: #fff</strong>', 'fusion-core'),
					  "id" 				=> "fusion_overlay_color",
					  "type" 			=> ElementTypeEnum::COLOR,
					  "value" 			=> ""
					  ),
					  
				array("name" 			=> __('Video Overlay Opacity', 'fusion-core'),
					  "desc" 			=> __('Opacity ranges between 0 (transparent) and 1 (opaque). ex: .4', 'fusion-core'),
					  "id" 				=> "fusion_overlay_opacity",
					  "type" 			=>  ElementTypeEnum::INPUT,
					  "value" 			=> "0.5"
					  ),

				array("name" 			=> __('Mute Video', 'fusion-core'),
					  "desc" 			=> '',
					  "id" 				=> "fusion_video_mute",
					  "type" 			=> ElementTypeEnum::SELECT,
					  "value" 			=> "yes",
					  "allowedValues" 	=> array('yes'	=> __('Yes', 'fusion-core'),
												 'no'	=> __('No', 'fusion-core')) 
					  ),

				array("name" 			=> __('Loop Video', 'fusion-core'),
					  "desc" 			=> '',
					  "id" 				=> "fusion_video_loop",
					  "type" 			=> ElementTypeEnum::SELECT,
					  "value" 			=> "yes",
					  "allowedValues" 	=> array('yes'	=> __('Yes', 'fusion-core'),
												 'no'	=> __('No', 'fusion-core')) 
					  ),

				array("name" 			=> __('Fading Animation', 'fusion-core'),
					  "desc" 			=> __('Choose to have the background image fade and blur on scroll. WARNING: Only works for images. This will cause video backgrounds to not display. ', 'fusion-core'),
					  "id" 				=> "fusion_fade",
					  "type" 			=> ElementTypeEnum::SELECT,
					  "value" 			=> "no",
					  "allowedValues" 	=> array('no'	=> __('No', 'fusion-core'),
												 'yes'	=> __('Yes', 'fusion-core')) 
					  ),

				array("name" 			=> __('Border Size', 'fusion-core'),
					  "desc" 			=> __('In pixels (px), ex: 1px. Leave blank for theme option selection.', 'fusion-core'),
					  "id" 				=> "fusion_bordersize",
					  "type" 			=>  ElementTypeEnum::INPUT,
					  "value" 			=> "0px"
					  ),
					  
				array("name" 			=> __('Border Color', 'fusion-core'),
					  "desc" 			=> __('Controls the border color. Leave blank for theme option selection.', 'fusion-core'),
					  "id" 				=> "fusion_bordercolor",
					  "type" 			=> ElementTypeEnum::COLOR,
					  "value" 			=> ""
					  ),
					  
				array("name" 			=> __('Border Style', 'fusion-core'),
					  "desc" 			=> __('Controls the border style.', 'fusion-core'),
					  "id" 				=> "fusion_borderstyle",
					  "type" 			=> ElementTypeEnum::SELECT,
					  "value" 			=> "",
					  "allowedValues" 	=> array('solid' 			=> __('Solid', 'fusion-core'),
												 'dashed' 			=> __('Dashed', 'fusion-core'),
												 'dotted' 			=> __('Dotted', 'fusion-core')) 
					  ),
					  
				array("name" 			=> __('Padding Top', 'fusion-core'),
					  "desc" 			=> __('In pixels.  Use a number without px.', 'fusion-core'),
					  "id" 				=> "fusion_paddingtop",
					  "type" 			=> ElementTypeEnum::INPUT,
					  "value" 			=> "20",
					  ),
					  
				array("name" 			=> __('Padding Bottom', 'fusion-core'),
					  "desc" 			=> __('In pixels. Use a number without px.', 'fusion-core'),
					  "id" 				=> "fusion_paddingbottom",
					  "type" 			=> ElementTypeEnum::INPUT,
					  "value" 			=> "20",
					  ),

				array("name"	  => __('Padding Left', 'fusion-core'),
							  "desc"	  => __('In pixels. Use a number without px.', 'fusion-core'),
							  "id"		=> "fusion_paddingleft",
							  "type"	  => ElementTypeEnum::INPUT,
							  "value"	   => "0",
					),
					
				array("name"	  => __('Padding Right', 'fusion-core'),
							  "desc"	  => __('In pixels. Use a number without px.', 'fusion-core'),
							  "id"		=> "fusion_paddingright",
							  "type"	  => ElementTypeEnum::INPUT,
							  "value"	   => "0",
					),
					  
				array("name" 			=> __('Name Of Menu Anchor', 'fusion-core'),
					  "desc" 			=> __('This name will be the id you will have to use in your one page menu.', 'fusion-core'),
					  "id" 				=> "fusion_menuanchor",
					  "type" 			=> ElementTypeEnum::INPUT,
					  "value" 			=> ""
					  ),
					  
				array("name" 			=> __('Set Columns to Euqal Height', 'fusion-core'),
					  "desc" 			=> __('Select to set all column shortcodes that are used inside the container to have equal height.', 'fusion-core'),
					  "id" 				=> "equal_height_columns",
					  "type" 			=> ElementTypeEnum::SELECT,
					  "value" 			=> "no",
					  "allowedValues" 	=> array('no' 			=> __('No', 'fusion-core'),
					  							 'yes' 			=> __('Yes', 'fusion-core'),
												 ) 
					  ),					  
					  
				array("name" 			=> __('100% Interior Content Width', 'fusion-core'),
					  "desc" 			=> __('Select if the interior content is contained to site width or 100% width. Selecting "Yes" will remove left/right padding. ', 'fusion-core'),
					  "id" 				=> "fusion_hundred_percent",
					  "type" 			=> ElementTypeEnum::SELECT,
					  "value" 			=> "no",
					  "allowedValues" 	=> array('no' 			=> __('No', 'fusion-core'),
					  							 'yes' 			=> __('Yes', 'fusion-core'),
												 ) 
					  ),

				array("name" 			=> __('CSS Class', 'fusion-core'),
					  "desc"			=> __('Add a class to the wrapping HTML element.', 'fusion-core'),
					  "id" 				=> "fusion_class",
					  "type" 			=> ElementTypeEnum::INPUT,
					  "value" 			=> "" 
					  ),
					  
				array("name" 			=> __('CSS ID', 'fusion-core'),
					  "desc"			=> __('Add an ID to the wrapping HTML element.', 'fusion-core'),
					  "id" 				=> "fusion_id",
					  "type" 			=> ElementTypeEnum::INPUT,
					  "value" 			=> "" 
					  ),
				);
		}
	}