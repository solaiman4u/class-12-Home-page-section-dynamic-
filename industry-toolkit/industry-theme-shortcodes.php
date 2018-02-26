<?php 

//Slider ShortCode
function industry_slider_shortcode($atts){
    extract( shortcode_atts( array(
        'count' => 3,
        'loop' => 'true',
        'dots' => 'true',
        'nav' => 'true',
        'autoplay' => 'true',
        'autoplayTimeout' => 5000,

    ), $atts) );


    $arg = array(
        'post_type' => 'industry-slide',
        'posts_per_page' => 3,
    );

    $get_post = new WP_Query($arg);

    $slide_rendom_number = rand(630437,630438);

    $industry_slider_markup = '
    <script>
        jQuery(window).load(function ($) {
            jQuery("#industry-slide'.$slide_rendom_number.'").owlCarousel({
            items: 1,
            loop: '.$loop.',            
            dots: '.$dots.',            
            nav: '.$nav.',            
            autoplay: '.$autoplay.',            
            autoplayTimeout: '.$autoplayTimeout.',            
            navText: ["<i class=\'fa fa-angle-left\'></i>", "<i class=\'fa fa-angle-right\'></i>"],
                 
        });
    });
    </script>

    <div id="industry-slide'.$slide_rendom_number.'" class="owl-carousel industry_slider">';
        while($get_post->have_posts()) : $get_post->the_post();
            $post_id = get_the_ID();

            //Slider warnning condition solve
            if(get_post_meta( $post_id, 'industry_slide_meta', true )){
                $slide_meta = get_post_meta( $post_id, 'industry_slide_meta', true );
            }else{
                $slide_meta = array();
            }

            //Custom color change            
            if(array_key_exists('text_color', $slide_meta)){
                $text_color = $slide_meta['text_color'];
            }else{
                $text_color = '#333';
            }

            //Custom Overlay           
            if(array_key_exists('enable_overlay', $slide_meta)){
                $enable_overlay = $slide_meta['enable_overlay'];
            }else{
                $enable_overlay = 'false';
            }

            //Custom opacity           
            if(array_key_exists('overlay_color', $slide_meta)){
                $overlay_color = $slide_meta['overlay_color'];
            }else{
                $overlay_color = '#333';
            }

            //Custom opacity           
            if(array_key_exists('overlay_opacity', $slide_meta)){
                $overlay_opacity = $slide_meta['overlay_opacity'];
            }else{
                $overlay_opacity = '70';
            }

            $industry_slider_markup .= '
            <div style="background-image:url('.get_the_post_thumbnail_url($post_id,'large').')" class="industry-single-slide">';
            if($enable_overlay == true){
                $industry_slider_markup .= '<div style="opacity:.'.$overlay_opacity.';background-color:'.$overlay_color.' " class="industry-slide-overlay"></div>';
            }
                $industry_slider_markup .= '<div class="industry-single-slide-inner">
                    <div class="container">
                        <div class="row">
                            <div style="color:'.$text_color.'" class="col-md-6">
                                <h2>'.get_the_title($post_id).'</h2>
                                '.wpautop(get_the_content($post_id)) .'
                            </div>
                        </div>
                    </div>
                </div>                
            </div>';
        endwhile;
    $industry_slider_markup .= '</div>'; 

    wp_reset_query();

    return $industry_slider_markup;
   
}
add_shortcode('industry_slider', 'industry_slider_shortcode'); 


//Section Title ShortCode
function industry_section_title_shortcode($atts){
    extract( shortcode_atts( array(
        'sub_title' => '',
        'title' => '',
        'description' => '',
    ), $atts) );

	$industry_section_title_markup ='<div class="industry_section_title">';

	if(!empty($sub_title)){
		$industry_section_title_markup .= '<h4>'.esc_html( $sub_title ).'</h4>';
	}

	if(!empty($title)){
		$industry_section_title_markup .= '<h2>'.esc_html( $title ).'</h2>';
	}
	
	if(!empty($description)){
		$industry_section_title_markup .= ''.wpautop( esc_html( $description ) ).'';
	}

	$industry_section_title_markup .= '</div>'; 

    return $industry_section_title_markup;   
}
add_shortcode('industry_section_title', 'industry_section_title_shortcode'); 


//Service Box ShortCode
function industry_service_box_shortcode($atts){
    extract( shortcode_atts( array(
        'icon_type' => 1,
        'fa_icon' => 'fa fa-star',
        'img_icon' => '',
        'title' => '',
        'description' => '',
    ), $atts) );

    $industry_service_box_markup ='<div class="industry_service_box">';

    if($icon_type == 1){
        $industry_service_box_markup .= '<div class="service-icon">
            <i class="'.esc_attr( $fa_icon ).'"></i>
        </div>';
    }else{
        $service_icon_img_array = wp_get_attachment_image_src( $img_icon, 'thumbnail' );
        $industry_service_box_markup .= '<div class="service-img-icon">
            <img src="'.esc_url( $service_icon_img_array[0] ).'" alt="'.esc_html( $title ).'"/>
        </div>';
    }


    if(!empty($title)){
        $industry_service_box_markup .= '<h2>'.esc_html( $title ).'</h2>';
    }
    
    if(!empty($description)){
        $industry_service_box_markup .= ''.wpautop( esc_html( $description ) ).'';
    }

    $industry_service_box_markup .= '</div>';

    return $industry_service_box_markup;   
}
add_shortcode('industry_service_box', 'industry_service_box_shortcode');  

