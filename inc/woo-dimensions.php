<?php
// just a few lines of CSS for the admin side
function dts_meta_box_style(){
    $current_screen = get_current_screen();
    if( 'product' === $current_screen->post_type ){
        wp_enqueue_style('dts-admin-styles', get_stylesheet_directory_uri().'/css/dts-admin.css');
    }
}

add_action('admin_enqueue_scripts', 'dts_meta_box_style');

class AWC_Woo_Dimensions {
    
    public function __construct(){
        $this->init();
    }

    public function init(){
        add_action( 'the_content', array($this, 'woo_dimensions'), 11 );
    }

    public function woo_dimensions( $content ){
        // something
        if( is_product() && is_single() ){
            $afterContent = $this->getProductDimensions();
            // $afterContent = '<h1>HELLO!!!</h1>';
            $allContent = $content . $afterContent;
            return $allContent;
        }else{
            return $content;
        }
    }

    private function getProductDimensions(){
        global $post;
    
        $length = get_post_meta( $post->ID, 'product_dimensions_length', true );
        $width  = get_post_meta( $post->ID, 'product_dimensions_width', true );
        $height = get_post_meta( $post->ID, 'product_dimensions_height', true );
        $op = '';
        if( $length || $width || $height ){
            $op .= '<div class="product-dimensions clear-fix clearfix clear">';
            $op .= '<h3>Dimensions</h3>';
            $op .= '<ul>';
            if( $length ){
                $op .= $this->dimensionListItem( $length, 'Length' );
            }
            if( $width ){
                $op .= $this->dimensionListItem( $width, 'Width' );
            }
            if( $height ){
                $op .= $this->dimensionListItem( $height, 'Height' );
            }
            $op .= '</ul>';
            $op .= $this->convertButton();
            $op .= '</div>';
        }
        return $op;
    }

    private function dimensionListItem( $content, $label = '' ){
        $li = '<li>' . $label . ': <span class="dimension-value metric" data-metric="' . $content . '" data-imperial="' . ($content * 2.54) . '">' . $content . '</span> <span class="dimension-system">cm</span></li>';
        return $li;
    }

    private function convertButton(){
        $button = '<button class="convert-measurement button" data-system="metric">Convert to <span class="imperial systemType" id="systemType">Imperial</span></button>';
        return $button;
    }
}

new AWC_Woo_Dimensions;