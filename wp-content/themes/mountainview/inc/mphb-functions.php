<?php

add_filter( 'mphb_single_room_type_gallery_image_size', function ($size){
    return 'mountainview-small';
});

add_filter( 'mphb_loop_room_type_gallery_nav_slider_image_size', function ($size){
    return 'mountainview-small';
});

add_filter( 'mphb_loop_room_type_gallery_main_slider_image_size', function ($size){
    return 'mountainview-medium';
});

add_filter( 'mphb_loop_room_type_thumbnail_size', function ($size){
    return 'mountainview-medium';
});

add_filter('mphb_loop_room_type_gallery_nav_slider_columns', function (){
    return 5;
});

add_filter('mphb_single_room_type_gallery_columns', function (){
    return 5;
});


add_filter('mphb_sc_rooms_wrapper_class', 'mountainview_mphb_accommodation_list_type');
if(!function_exists('mountainview_mphb_accommodation_list_type')){
    function mountainview_mphb_accommodation_list_type($classes){

        $list_layout =  get_theme_mod('mountainview_accommodation_list_layout', 'default');
        if($list_layout){
            $classes.= ' '.$list_layout;
        }


        return $classes;
    }
}


if(get_theme_mod('mountainview_accommodation_list_layout', 'default') == 'list'){
    add_action('mphb_sc_rooms_item_bottom', 'mountainview_mphb_after_room_description');
    add_action('mphb_sc_rooms_render_title', 'mountainview_mphb_before_room_description', 5);
    add_action('mphb_sc_rooms_item_top', 'mountainview_mphb_before_room_images');
}
if(!function_exists('mountainview_mphb_before_room_description')){
    function mountainview_mphb_before_room_description(){
        ?>
        </div>
        <div class="accommodation-list-room-description">
        <?php
    }
}
if(!function_exists('mountainview_mphb_after_room_description')){
    function mountainview_mphb_after_room_description(){
        ?>
        </div>
        <?php
    }
}
if(!function_exists('mountainview_mphb_before_room_images')){
    function mountainview_mphb_before_room_images(){
        ?>
        <div class="accommodation-list-room-images">
        <?php
    }
}