<?php
/**
 * Astra Addon Updates
 *
 * Functions for updating data, used by the background updater.
 *
 * @package Astra Addon
 * @version 2.1.3
 */

defined( 'ABSPATH' ) || exit;

/**
 * Do not apply new default colors to the Elementor & Gutenberg Buttons for existing users.
 *
 * @since 2.1.4
 *
 * @return void
 */
function astra_addon_page_builder_button_color_compatibility() {
	$theme_options = get_option( 'astra-settings', array() );

	// Set flag to not load button specific CSS.
	if ( ! isset( $theme_options['pb-button-color-compatibility-addon'] ) ) {
		$theme_options['pb-button-color-compatibility-addon'] = false;
		error_log( 'Astra Addon: Page Builder button compatibility: false' ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
		update_option( 'astra-settings', $theme_options );
	}
}

/**
 * Apply Desktop + Mobile to parallax device.
 *
 * @since 2.3.0
 *
 * @return bool
 */
function astra_addon_page_header_parallax_device() {

	$posts = get_posts(
		array(
			'post_type'   => 'astra_adv_header',
			'numberposts' => -1,
		)
	);

	foreach ( $posts as $post ) {
		$ids = $post->ID;
		if ( false == $ids ) {
			return false;
		}

		$settings = get_post_meta( $ids, 'ast-advanced-headers-design', true );

		if ( isset( $settings['parallax'] ) && $settings['parallax'] ) {
			$settings['parallax-device'] = 'both';
		} else {
			$settings['parallax-device'] = 'none';
		}
		update_post_meta( $ids, 'ast-advanced-headers-design', $settings );
	}
}

/**
 * Migrate option data from Content background option to its desktop counterpart.
 *
 * @since 2.4.0
 *
 * @return void
 */
function astra_responsive_content_background_option() {

	$theme_options = get_option( 'astra-settings', array() );

	if ( false === get_option( 'content-bg-obj-responsive', false ) && isset( $theme_options['content-bg-obj'] ) ) {

		$theme_options['content-bg-obj-responsive']['desktop'] = $theme_options['content-bg-obj'];
		$theme_options['content-bg-obj-responsive']['tablet']  = array(
			'background-color'      => '',
			'background-image'      => '',
			'background-repeat'     => 'repeat',
			'background-position'   => 'center center',
			'background-size'       => 'auto',
			'background-attachment' => 'scroll',
		);
		$theme_options['content-bg-obj-responsive']['mobile']  = array(
			'background-color'      => '',
			'background-image'      => '',
			'background-repeat'     => 'repeat',
			'background-position'   => 'center center',
			'background-size'       => 'auto',
			'background-attachment' => 'scroll',
		);
	}

	update_option( 'astra-settings', $theme_options );
}

/**
 * Migrate multisite css file generation option to sites indiviually.
 *
 * @since 2.3.3
 *
 * @return void
 */
function astra_addon_css_gen_multi_site_fix() {

	if ( is_multisite() ) {
		$is_css_gen_enabled = get_site_option( '_astra_file_generation', 'disable' );
		if ( 'enable' === $is_css_gen_enabled ) {
			update_option( '_astra_file_generation', $is_css_gen_enabled );
			error_log( 'Astra Addon: CSS file generation: enable' ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
		}
	}
}

/**
 * Check if we need to change the default value for tablet breakpoint.
 *
 * @since 2.4.0
 * @return void
 */
function astra_addon_update_theme_tablet_breakpoint() {

	$theme_options = get_option( 'astra-settings' );

	if ( ! isset( $theme_options['can-update-addon-tablet-breakpoint'] ) ) {
		// Set a flag to check if we need to change the addon tablet breakpoint value.
		$theme_options['can-update-addon-tablet-breakpoint'] = false;
	}

	update_option( 'astra-settings', $theme_options );
}

/**
 * Apply missing editor_type post meta to having code enabled custom layout posts.
 *
 * @since 2.5.0
 *
 * @return bool
 */
function custom_layout_compatibility_having_code_posts() {

	$posts = get_posts(
		array(
			'post_type'   => 'astra-advanced-hook',
			'numberposts' => -1,
		)
	);

	foreach ( $posts as $post ) {

		$post_id = $post->ID;

		if ( ! $post_id ) {
			return;
		}

		$post_with_code_editor = get_post_meta( $post_id, 'ast-advanced-hook-with-php', true );

		if ( isset( $post_with_code_editor ) && 'enabled' === $post_with_code_editor ) {
			update_post_meta( $post_id, 'editor_type', 'code_editor' );
		} else {
			update_post_meta( $post_id, 'editor_type', 'wordpress_editor' );
		}
	}
}

/**
 * Added new submenu color options for Page Headers.
 *
 * @since 2.5.0
 *
 * @return bool
 */
function astra_addon_page_header_submenu_color_options() {

	$posts = get_posts(
		array(
			'post_type'   => 'astra_adv_header',
			'numberposts' => -1,
		)
	);

	foreach ( $posts as $post ) {

		$id = $post->ID;
		if ( false == $id ) {
			return false;
		}

		$settings = get_post_meta( $id, 'ast-advanced-headers-design', true );

		if ( ( isset( $settings['primary-menu-h-color'] ) && $settings['primary-menu-h-color'] ) && ! isset( $settings['primary-menu-a-color'] ) ) {
			$settings['primary-menu-a-color'] = $settings['primary-menu-h-color'];
		}
		if ( ( isset( $settings['above-header-h-color'] ) && $settings['above-header-h-color'] ) && ! isset( $settings['above-header-a-color'] ) ) {
			$settings['above-header-a-color'] = $settings['above-header-h-color'];
		}
		if ( ( isset( $settings['below-header-h-color'] ) && $settings['below-header-h-color'] ) && ! isset( $settings['below-header-a-color'] ) ) {
			$settings['below-header-a-color'] = $settings['below-header-h-color'];
		}

		update_post_meta( $id, 'ast-advanced-headers-design', $settings );
	}
}

/**
 * Manage flags & run backward compatibility process for following cases.
 *
 * 1. Sticky header inheriting colors in normal headers as well.
 *
 * @since 2.6.0
 * @return void
 */
function astra_addon_header_css_optimizations() {

	$theme_options = get_option( 'astra-settings' );

	if (
		! isset( $theme_options['can-inherit-sticky-colors-in-header'] ) &&
		(
			( isset( $theme_options['header-above-stick'] ) && $theme_options['header-above-stick'] ) ||
			( isset( $theme_options['header-main-stick'] ) && $theme_options['header-main-stick'] ) ||
			( isset( $theme_options['header-below-stick'] ) && $theme_options['header-below-stick'] )
		) &&
		(
			(
				( isset( $theme_options['sticky-above-header-megamenu-heading-color'] ) && '' !== $theme_options['sticky-above-header-megamenu-heading-color'] ) ||
				( isset( $theme_options['sticky-above-header-megamenu-heading-h-color'] ) && '' !== $theme_options['sticky-above-header-megamenu-heading-h-color'] )
			) || (
				( isset( $theme_options['sticky-primary-header-megamenu-heading-color'] ) && '' !== $theme_options['sticky-primary-header-megamenu-heading-color'] ) ||
				( isset( $theme_options['sticky-primary-header-megamenu-heading-h-color'] ) && '' !== $theme_options['sticky-primary-header-megamenu-heading-h-color'] )
			) || (
				( isset( $theme_options['sticky-below-header-megamenu-heading-color'] ) && '' !== $theme_options['sticky-below-header-megamenu-heading-color'] ) ||
				( isset( $theme_options['sticky-below-header-megamenu-heading-h-color'] ) && '' !== $theme_options['sticky-below-header-megamenu-heading-h-color'] )
			)
		)
	) {
		// Set a flag to inherit sticky colors in the normal header as well.
		$theme_options['can-inherit-sticky-colors-in-header'] = true;
	}

	update_option( 'astra-settings', $theme_options );
}

/**
 * Regenerate Astra cache files.
 * Added this function for this version because from theme at same version we migrating old header & footer layout to make it compatible with new Header-Footer Builder.
 *
 * @since 3.0.0
 * @return void
 */
function astra_addon_clear_assets_cache() {
	Astra_Minify::refresh_assets();
}

/**
 * Page Header's color options compatibility with new Header builder layout.
 *
 * @since 3.5.0
 * @return void
 */
function astra_addon_page_headers_support_to_builder_layout() {

	$theme_options = get_option( 'astra-settings' );

	if ( ! isset( $theme_options['can-update-page-header-compatibility-to-header-builder'] ) ) {
		// Set a flag to avoid direct changes on frontend.
		$theme_options['can-update-page-header-compatibility-to-header-builder'] = true;
	}

	update_option( 'astra-settings', $theme_options );
}

/**
 * Do not apply new font-weight heading support CSS in editor/frontend directly.
 *
 * 1. Adding Font-weight support to widget titles.
 * 2. Customizer font CSS not supporting in editor.
 *
 * @since 3.5.1
 *
 * @return void
 */
function astra_addon_headings_font_support() {
	$theme_options = get_option( 'astra-settings', array() );

	if ( ! isset( $theme_options['can-support-widget-and-editor-fonts'] ) ) {
		$theme_options['can-support-widget-and-editor-fonts'] = false;
		update_option( 'astra-settings', $theme_options );
	}
}

/**
 * Cart color not working in old header > cart widget. As this change can reflect on frontend directly, adding this backward compatibility.
 *
 * @since 3.5.1
 * @return void
 */
function astra_addon_cart_color_not_working_in_old_header() {

	$theme_options = get_option( 'astra-settings' );

	if ( ! isset( $theme_options['can-reflect-cart-color-in-old-header'] ) ) {
		// Set a flag to avoid direct changes on frontend.
		$theme_options['can-reflect-cart-color-in-old-header'] = false;
	}

	update_option( 'astra-settings', $theme_options );
}

/**
 * Till now "Header Sections" addon has dependency conflict with new header builder, unless & until this addon activate dynamic CSS does load for new header layouts.
 * As we deprecate "Header Sections" for new header builder layout, conflict appears here.
 *
 * Adding backward compatibility as changes can directly reflect on frontend.
 *
 * @since 3.5.7
 * @return void
 */
function astra_addon_remove_header_sections_deps_new_builder() {

	$theme_options = get_option( 'astra-settings' );

	if ( ! isset( $theme_options['remove-header-sections-deps-in-new-header'] ) ) {
		// Set a flag to avoid direct changes on frontend.
		$theme_options['remove-header-sections-deps-in-new-header'] = false;
	}

	update_option( 'astra-settings', $theme_options );
}

/**
 * In old header for Cart widget we have background: #ffffff; for outline cart, whereas this CSS missed in new HFB > Cart element. Adding it now as per support requests. This case is only for new header builder > WooCommerce cart.
 *
 * @since 3.5.7
 * @return void
 */
function astra_addon_outline_cart_bg_color_support() {
	$theme_options = get_option( 'astra-settings', array() );

	if ( ! isset( $theme_options['add-outline-cart-bg-new-header'] ) ) {
		$theme_options['add-outline-cart-bg-new-header'] = false;
		update_option( 'astra-settings', $theme_options );
	}
}

/**
 * Swap section on Mobile Device not working in old header. As this change can reflect on frontend directly, adding this backward compatibility.
 *
 * @since 3.5.7
 * @return void
 */
function astra_addon_swap_section_not_working_in_old_header() {

	$theme_options = get_option( 'astra-settings', array() );

	if ( ! isset( $theme_options['support-swap-mobile-header-sections'] ) ) {
		$theme_options['support-swap-mobile-header-sections'] = false;
		update_option( 'astra-settings', $theme_options );
	}
}
