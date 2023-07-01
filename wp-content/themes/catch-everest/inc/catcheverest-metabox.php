<?php
/**
 * Catch Everest Custom meta box
 *
 * @package Catch Themes
 * @subpackage Catch_Everest
 * @since Catch Everest 1.0
 */

 // Add the Meta Box
function catcheverest_add_custom_box() {
    add_meta_box(
        'catcheverest-options',                             //Unique ID
        esc_html__( 'Catch Everest Options', 'catch-everest' ),     //Title
        'catcheverest_meta_options',                    //Callback function
        array( 'page', 'post' ),                                            //show metabox in page
        'side'
    );
}
add_action( 'add_meta_boxes', 'catcheverest_add_custom_box' );

/**
 * @renders metabox to for sidebar layout
 */
function catcheverest_meta_options() {
    global $post;

    //Sidebar Layout Options
    $sidebar_layout = array(
        'default-sidebar' => array(
            'id'        => 'catcheverest-sidebarlayout',
            'value'     => 'default',
            'label'     => esc_html__( 'Default (Set in Customizer Options)', 'catch-everest' ),
        ),
       'right-sidebar' => array(
            'id'        => 'catcheverest-sidebarlayout',
            'value'     => 'right-sidebar',
            'label'     => esc_html__( 'Right sidebar', 'catch-everest' ),
        ),
        'left-sidebar' => array(
            'id'        => 'catcheverest-sidebarlayout',
            'value'     => 'left-sidebar',
            'label'     => esc_html__( 'Left sidebar', 'catch-everest' ),
        ),
        'no-sidebar' => array(
            'id'        => 'catcheverest-sidebarlayout',
            'value'     => 'no-sidebar',
            'label'     => esc_html__( 'No sidebar', 'catch-everest' ),
        ),
        'no-sidebar-full-width' => array(
            'id'        => 'catcheverest-sidebarlayout',
            'value'     => 'no-sidebar-full-width',
            'label'     => esc_html__( 'No sidebar, Full Width', 'catch-everest' ),
        ),
    );

    // Use nonce for verification
    wp_nonce_field( basename( __FILE__ ), 'custom_meta_box_nonce' );
    ?>
    <p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="catcheverest-sidebarlayout"><?php esc_html_e( 'Sidebar Layout', 'catch-everest' ); ?></label></p>
    <select class="widefat" name="catcheverest-sidebarlayout" id="catcheverest-sidebarlayout">
         <?php
            $meta_value = get_post_meta( $post->ID, 'catcheverest-sidebarlayout', true );
            
            if ( empty( $meta_value ) ){
                $meta_value = 'default';
            }
            
            foreach ( $sidebar_layout as $field =>$label ) {  
            ?>
                <option value="<?php echo esc_attr( $label['value'] ); ?>" <?php selected( $meta_value, $label['value'] ); ?>><?php echo esc_html( $label['label'] ); ?></option>
            <?php
            } // end foreach
        ?>
    </select>
<?php
}


/**
 * save the custom metabox data
 * @hooked to save_post hook
 */
function catcheverest_save_custom_meta( $post_id ) {
    global $header_image_options, $sidebar_layout, $sidebar_options, $featuredimage_options, $post;

    // Verify the nonce before proceeding.
    if ( !isset( $_POST[ 'custom_meta_box_nonce' ] ) || !wp_verify_nonce( $_POST[ 'custom_meta_box_nonce' ], basename( __FILE__ ) ) )
        return;

    // Stop WP from clearing custom fields on autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE)
        return;

    if ('page' == $_POST['post_type']) {
        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return $post_id;
        }
    } elseif ( ! current_user_can( 'edit_post', $post_id ) ) {
        return $post_id;
    }

    if ( ! update_post_meta ( $post_id, 'catcheverest-sidebarlayout', sanitize_key( $_POST['catcheverest-sidebarlayout'] ) ) ) {
        add_post_meta( $post_id, 'catcheverest-sidebarlayout', sanitize_key( $_POST['catcheverest-sidebarlayout'] ), true );
    }
}
add_action('save_post', 'catcheverest_save_custom_meta');
