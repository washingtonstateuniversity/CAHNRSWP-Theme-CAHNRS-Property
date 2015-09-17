<?php

add_filter( 'spine_option_defaults', 'extension_spine_option_defaults' );
/**
 * Reset certain Spine customizer option defaults.
 */
function extension_spine_option_defaults( $defaults ) {
	$defaults['campus_location'] = 'extension';
	$defaults['bleed'] = false;
	$defaults['articletitle_show'] = false;
	$defaults['articletitle_header'] = true;
	return $defaults;
}

add_action( 'customize_register', 'extension_property_customize_register', 999 );
/**
 * Add custom settings and controls to the WP Customizer.
 *
 * @param WP_Customize_Manager $wp_customize
 */
function extension_property_customize_register( $wp_customize ) {

	// Remove some Spine options.
	$wp_customize->remove_control( 'campus_location' );
	$wp_customize->remove_control( 'spine_bleed' );
	$wp_customize->remove_control( 'spine_theme_style' );
	$wp_customize->remove_control( 'global_main_header_sup' );
	$wp_customize->remove_control( 'global_main_header_sub' );
	$wp_customize->remove_control( 'spine_options[articletitle_show]' );
	$wp_customize->remove_control( 'spine_options[articletitle_header]' );

	// CAHNRS Header options.
	$wp_customize->add_section( 'cahnrs_header', array(
		'title'    => __( 'CAHNRS Header' ),
		'priority' => 19,
	));

	$wp_customize->add_setting('spine_options[cahnrs_header_bg_color]', array(
		'default'    => '',
		'capability' => 'edit_theme_options',
		'type'       => 'option'
	));

	$wp_customize->add_control('cahnrs_header_bg_color', array(
		'settings'   => 'spine_options[cahnrs_header_bg_color]',
		'label'      => __('Background Color', 'spine'),
		'section'    => 'cahnrs_header',
		'type'       => 'select',
		'choices'    => array(
			'gray' => 'Gray',
			'green' => 'Green',
			'orange' => 'Orange',
			'blue' => 'Blue',
			'yellow' => 'Yellow',
		),
	));

	$wp_customize->add_setting('spine_options[cahnrs_header_bg_vellum]', array(
		'default' => '',
		'capability' => 'edit_theme_options',
		'type' => 'option'
	));

	$wp_customize->add_control('cahnrs_header_bg_vellum', array(
		'settings'   => 'spine_options[cahnrs_header_bg_vellum]',
		'label'      => __('Background Transparency', 'spine'),
		'section'    => 'cahnrs_header',
		'type'       => 'select',
		'choices'    => array(
			'default'    => '0%',
			'vellum-50'  => '50%',
			'vellum-100' => '100%',
		),
	));

	$wp_customize->add_setting('spine_options[cahnrs_header_fixed]', array(
		'default'    => '',
		'capability' => 'edit_theme_options',
		'type'       => 'option'
	));

	$wp_customize->add_control('cahnrs_header_fixed', array(
		'label' => 'Fixed',
		'section' => 'cahnrs_header',
		'settings' => 'spine_options[cahnrs_header_fixed]',
		'type' => 'checkbox',
	));

}