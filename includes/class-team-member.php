<?php


$Nuc_meta_key_team = 'CHfwPostSetting';
$Nuc_postID      = isset( $_GET['post'] ) ? $_GET['post'] : null;//post  id  for edit
$Nuc_post_type   = ( get_post_type( $Nuc_postID ) );//get type
$Nuc_post_type_post = isset( $_REQUEST['post_type'] ) ? $_REQUEST['post_type'] : 'post';//for new


/**
 * add_meta_boxes
 * @link https://developer.wordpress.org/reference/functions/add_meta_box/
 */
class Nuc_metabox_engine_team_member {
	public $nonce = 'st_studio';
	private $meta_key;
	private $fields;
	private $current_id;

	public function __construct( $fields ) {
		global $Nuc_meta_key_team ;
		$this->meta_key = $Nuc_meta_key_team;

		if ( is_admin() ) {
			$this->fields = $fields;

			add_action( 'load-post.php', array( $this, 'init_metabox' ) );
			add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
		}
	}

	public function init_metabox() {
		// add meta box
		add_action( 'add_meta_boxes', array(
			&$this,
			'add_custom_meta_box'
		) );

		// metabox save
		add_action( 'save_post', array(
			&$this,
			'meta_box_save'
		) );
	}



	/**
	 * Save the Meta box values
	 */
	public function meta_box_save( $post_id ) {


		if ( wp_is_post_autosave( $post_id ) ) {
			return;
		}

		// Check if not a revision.
		if ( wp_is_post_revision( $post_id ) ) {
			return;
		}

		// Stop the script when doing autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}



		$post_meta_ = array();

		// var_dump($this->fields);

		foreach ( $this->fields as $fields ) {
			foreach ( $fields['fields'] as $key => $field ) {
				$post_meta_[ $field['name'] ] = isset( $_POST[ $field['name'] ] ) ? $_POST[ $field['name'] ] : '';
			}
		}

		// Update the meta field in the database.
		update_post_meta( $post_id, $this->meta_key, $post_meta_ );

	}

	/**
	 * Register the Meta box
	 */
	public function add_custom_meta_box() {
	//	print_r ($this->fields);
		
		
		foreach ( $this->fields as $key => $field ) {
			//print_r ($field);
			add_meta_box(
				$field['name'],
				__( $field['title'], 'st_studioEngine' ),
				array( &$this, 'meta_box_output' ),
				$field['page'],
				$field['context'],
				$field['priority'],
				$field
			);
		}
	}

	/**
	 * Output the Meta box
	 */
	public function meta_box_output( $post, $field_arg ) {

		$fields = ( $field_arg['args'] );

		// wp_nonce_field('my_meta_box_nonce', 'meta_box_nonce');
		echo '<input type="hidden" name="' . $this->nonce . '" value="', wp_create_nonce( basename( __FILE__ ) ), '" />';
		echo '<div class="wp-core-ui  st_studio-Engine-Form" style="' . $fields['style'] . '"  class="' . $fields['class'] . $fields['name'] . '"><ul>';

		if ( $fields['title_h2'] ) {
			echo '<li><h2  data-required="Nuc_pageSetting_background_repeat"><strong>' . $fields['title'] . '</strong></h2> </li>';
		}

		foreach ( $fields['fields'] as $key => $values ) {

			switch ( $values['type'] ) {
				case 'info':
					echo '<li class="' . $values['class_li'] . '"  id="' . $values['name'] . '_li"> <h2><strong>' . $values['title'] . '</strong></h2>  <br>   <span style="padding-left: 15px;">' . $values['description'] . '</span>     <hr>   </li>';
					break;

				case 'image_select':
					echo '<li  class="' . $values['class_li'] . '" id="' . $values['name'] . '_li"><label for="' . $values['name'] . '">' . $values['title'] . '</label>
                <select  style="' . $values['style'] . '" class="image_select_metabox image-picker show-labels ' . $values['class'] . '"  name="' . $values['name'] . '" id="' . $values['name'] . '">
                ' . $this->post_options_image_select( $values['options'], $values['name'] ) . '
                </select>
               ' . $this->post_options_description( $values['description'] ) . '</li>';
					break;

				case 'select':
					echo '<li class="' . $values['class_li'] . '" id="' . $values['name'] . '_li"><label for="' . $values['name'] . '">' . $values['title'] . '</label>
                <select  style="' . $values['style'] . '"  class="' . $values['class'] . '"  name="' . $values['name'] . '" id="' . $values['name'] . '">
                ' . $this->post_options_select( $values['options'], $values['name'] ) . '
                </select>
               ' . $this->post_options_description( $values['description'] ) . '</li>';
					break;
				case 'textarea':
					echo '<li class="' . $values['class_li'] . '" id="' . $values['name'] . '_li"><label for="' . $values['name'] . '">' . $values['title'] . '</label>
                 <textarea name="' . $values['name'] . '" class="' . $values['class'] . '" style="' . $values['style'] . '"  id="' . $values['name'] . '" cols="40" rows="6" >' . $this->get_meta( $values['name'] ) . '</textarea>
               ' . $this->post_options_description( $values['description'] ) . '</li>';
					break;
				case 'text':
					echo '<li class="' . $values['class_li'] . '" id="' . $values['name'] . '_li"><label for="' . $values['name'] . '">' . $values['title'] . '</label>
              <input type="text" value="' . $this->get_meta( $values['name'] ) . '" class="' . $values['class'] . '" style="' . $values['style'] . '"  name="' . $values['name'] . '" id="' . $values['name'] . '"/>
               ' . $this->post_options_description( $values['description'] ) . '</li>';
					break;
				case 'checkbox':
					echo '<li id="' . $values['class_li'] . '_li"><label for="' . $values['name'] . '">' . $values['title'] . '</label>
              <input type="checkbox" value="on"  ' . $this->post_options_checked( $values['name'] ) . '   class="' . $values['class'] . '" style="' . $values['style'] . '"  name="' . $values['name'] . '" id="' . $values['name'] . '"/>
               ' . $this->post_options_description( $values['description'] ) . '</li>';
					break;

				case 'radio':
					echo '<li class="' . $values['class_li'] . '" id="' . $values['name'] . '_li"><label for="' . $values['name'] . '">' . $values['title'] . '</label>';
					foreach ( $values['values'] as $key => $value ) {
						echo ' <input type="radio" value="' . $key . '"  ' . $this->post_options_radio( $values['name'], $key ) . '  class="' . $values['class'] . '" style="' . $values['style'] . '"  name="' . $values['name'] . '" id="' . $values['name'] . '"/>';
						echo '<span>' . $value . '</span>';
					}

					echo $this->post_options_description( $values['description'] ) . '</li>';
					break;

				case 'color':
					echo '<li class="' . $values['class_li'] . '" id="' . $values['name'] . '_li"><label for="' . $values['name'] . '">' . $values['title'] . '</label>
              <input type="text" value="' . $this->get_meta( $values['name'] ) . '"  class="ch-color-picker ' . $values['class'] . '" style="' . $values['style'] . 'background-color:' . $this->get_meta( $values['name'] ) . '" name="' . $values['name'] . '" id="' . $values['name'] . '"/>
               ' . $this->post_options_description( $values['description'] ) . '</li>';
					break;

				/*UPLOAD */
				case 'upload':
					echo '<li class="' . $values['class_li'] . '" id="' . $values['name'] . '_li"><label for="' . $values['name'] . '">' . $values['title'] . '</label>
              <input type="text" value="' . $this->get_meta( $values['name'] ) . '"  class="' . $values['class'] . '" style="display:none;' . $values['style'] . '" name="' . $values['name'] . '" id="' . $values['name'] . '"/>
              <input  id="' . $values['name'] . '_extra"   class="page_upload_trigger_element button button-primary button-large" name="' . $values['name'] . '_extra" type="button" value="' . $values['button_text'] . '"  style="' . $values['button_style'] . '"/>
        ' . $this->post_options_description( $values['description'] ) . '
        <br>
        <div class="background_attachment_metabox_container">';
					if ( ! empty( $this->get_meta( $values['name'] ) ) ) {
						$fileExtension = $this->fileExtension( $this->get_meta( $values['name'] ) );
						if ( $fileExtension == "jpg" || $fileExtension == "jpeg" || $fileExtension == "png" || $fileExtension == "gif" ) {
							echo '<div class="images-containerBG"><div class="single-imageBG"><span class="delete">X</span>';
							echo '  <img  data-targetID="' . $values['name'] . '" alt="' . $values['name'] . '" class="attachment-100x100 wp-post-image" witdh="100" height="100" src="' . $this->get_meta( $values['name'] ) . '">';
							echo '</div></div>';
						} else {
							?>
							<div class="images-containerBG">
								<div style="width: 53px; height: 53px;" class="single-imageBG">
									<span data-targetID="<?php echo $values['name'] ?>" class="delete_media">X</span>
									<span style="font-size: 46px" class="info dashicons dashicons-admin-media"></span>
								</div>
							</div>
							<?php
						}
					}
					echo '</div></li>';
					break;

				// Media Gallery Code
				case 'media-gallery':
					$imagewow2=array();
					$imagesBUll_ = $this->get_meta( $values['name'] );
					if ( ! empty( $imagesBUll_ ) ) {
						$imagesBUlls = explode( ',', $imagesBUll_ );
						$imagesBUlls = array_unique( $imagesBUlls );

						foreach ( $imagesBUlls as $key => $val ) {
							if ( $val == '' ) {
								unset( $imagesBUlls[ $key ] );
							}
						}
					}
					if ( ! empty( $imagesBUlls ) ) :
						foreach ( $imagesBUlls as $imagesBUll ) :
							$imagewow   = wp_get_attachment_image_src( ( $imagesBUll ), 'wow-BlogList_MediumSmall_SidebarOpen' );
							$imagewow2 []= $imagewow[0];
						endforeach;
					endif;
					echo '<li class="' . $values['class_li'] . '" id="' . $values['name'] . '_li">
                                <div class="drop_meta_item gallery">
	                            <label for="' . $values['name'] . '">' . $values['title'] . '</label>
	                            <div class="st_studio-metadata">
	                            <div class="images-container"></div>
	                            <div class="images-container2">
                                <input id="' . $values['name'] . '"   class="meta_field media_field_content"  value="' . implode(',',$imagewow2) .'"   name="' . $values['name'] . '" type="hidden"   style="' . $values['style'] . '"/>
	                            <input type="button" name="uploader" class="STNCupload_button button button-primary" value="' . __( 'Add Images', 'CHfw' ) . '">
	                            </div>
	                            </div>
	                            </div>
	                      </li>';
					break;
			}
		}


		echo '  </ul>
    </div>';
	}

	/**
	 * engine select option list
	 */
	public function post_options_image_select( $arrays, $name ) {
		//echo '<pre>';print_r($arrays);
		$out = '';

		$meta = $this->get_meta( $name );
		foreach ( $arrays as $key => $option ) {
			///echo $key;		echo '<pre>';

			if ( $meta == $key ) {
				$out .= '<option data-img-label="' . $arrays[ $key ]['title'] . '"  data-img-src="' . $arrays[ $key ]['img'] . '" value="' . $key . '" selected="selected"> ' . $arrays[ $key ]['title'] . '</option>';
			} else {
				$out .= '<option data-img-label="' . $arrays[ $key ]['title'] . '"  data-img-src="' . $arrays[ $key ]['img'] . '" value="' . $key . '" > ' . $arrays[ $key ]['title'] . '</option>';
			}
		}

		return $out;
	}

	/**
	 * function to return a custom field value.
	 */
	public function get_meta( $value ) {
		global $post;
		$field = get_post_meta( $post->ID, $this->meta_key, true );
		if ( ! empty( $field ) ) {
			if ( array_key_exists( $value, $field ) ) {
				$field = $field[ $value ];
			}
		}
		if ( ! empty( $field ) ) {
			return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
		} else {
			return false;
		}
	}

	/**
	 * engine descripton
	 */
	public function post_options_description( $value ) {
		if ( $value != '' ) {
			return '<span class="form_hint">' . $value . '</span>';
		} else {
			return '';
		}
	}

	/**
	 * engine select option list
	 */
	public function post_options_select( $arrays, $name ) {
		$out = '';
		foreach ( $arrays as $key => $option ) {
			$meta = $this->get_meta( $name );
			if ( $meta == $key ) {
				$out .= '<option  value="' . $key . '" selected="selected"> ' . $option . '</option>';
			} else {
				$out .= '<option value="' . $key . '" > ' . $option . '</option>';
			}
		}
		return $out;
	}

	/**
	 * engine checked
	 */
	public function post_options_checked( $value ) {
		return $this->get_meta( $value ) === "on" ? "checked" : "";
	}

	/**
	 * engine checked
	 */
	public function post_options_radio( $id, $value ) {
		return $this->get_meta( $id ) === $value ? "checked" : "";
	}
}




function Nuc_team_options_() {
	include( 'metabox_team_options.php' );
	$ch_post_options_team['0'] = $Nuc_OptionsPageSettingteam;
	$engine_page_team          = new Nuc_metabox_engine_team_member( $ch_post_options_team );
}




if ( $Nuc_post_type == 'team' ) {
//team
	Nuc_team_options_();
}


if ( $Nuc_post_type_post == 'team' ) {
//team
	Nuc_team_options_();
}


function Nuc_team_options_locaiton() {
	include( 'metabox_team_options.php' );
	$ch_post_options_team['0'] = $Nuc_OptionsPageSettingteamLocaiton;
	$engine_page_team          = new Nuc_metabox_engine_team_member( $ch_post_options_team );
}



if ( $Nuc_post_type == 'team_location' ) {
//team
	Nuc_team_options_locaiton();
}


if ( $Nuc_post_type_post == 'team_location' ) {
//team
	Nuc_team_options_locaiton();
}



