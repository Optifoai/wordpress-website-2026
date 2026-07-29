<?php
/**
 * Default / dummy content from original HTML template.
 *
 * @package Optifo
 */

defined( 'ABSPATH' ) || exit;

/**
 * Default theme options.
 *
 * @return array
 */
function optifo_default_theme_options() {
	return array(
		'app_store_url'        => 'https://apps.apple.com/us/app/optifo-automated-car-studio/id1539383737',
		'play_store_url'       => 'https://play.google.com/store/apps/details?id=com.mobcoder.optifo&hl=en_US&pli=1',
		'header_login_text'    => 'LOGIN',
		'header_login_url'     => '#',
		'contact_email'        => 'info@optifo.com',
		'contact_phone'        => 'Tel. +45 28 49 50 60',
		'seo_description'      => 'Professional AI-powered photo and video editing for car dealers. Optifo creates consistent, high-quality vehicle images effortlessly.',
		'social_facebook'      => '#',
		'social_instagram'     => '#',
		'social_youtube'       => '#',
		'social_whatsapp'      => '#',
		'social_tiktok'        => '#',
		'map_center_lat'       => '22.9734',
		'map_center_lng'       => '78.6569',
		'map_zoom'             => 5,
	);
}

/**
 * All section default data keyed by section ID.
 *
 * @return array
 */
function optifo_get_all_section_defaults() {
	return array(
		'hero'            => optifo_default_hero_section(),
		'counter'         => optifo_default_counter_section(),
		'why_use'         => optifo_default_why_use_section(),
		'how_it_works'    => optifo_default_how_it_works_section(),
		'web_mobile'      => optifo_default_web_mobile_section(),
		'store_buttons'   => array( 'enabled' => 1 ),
		'dashboard'       => optifo_default_dashboard_section(),
		'pricing'         => optifo_default_pricing_section(),
		'featured_in'     => optifo_default_featured_in_section(),
		'studio_quality'  => optifo_default_studio_quality_section(),
		'behind_design'   => optifo_default_behind_design_section(),
		'worldwide_trust' => optifo_default_worldwide_trust_section(),
		'contact'         => optifo_default_contact_section(),
		'faqs'            => optifo_default_faqs_section(),
	);
}

/**
 * Get defaults for one section.
 *
 * @param string $section_id Section ID.
 * @return array
 */
function optifo_get_section_defaults( $section_id ) {
	$all = optifo_get_all_section_defaults();
	return $all[ $section_id ] ?? array();
}

/**
 * Deep-merge saved section data with defaults (empty values keep defaults).
 *
 * @param array $defaults Default data.
 * @param array $saved    Saved data.
 * @return array
 */
function optifo_merge_section_data( $defaults, $saved ) {
	if ( ! is_array( $saved ) || empty( $saved ) ) {
		return $defaults;
	}

	$merged = $defaults;

	foreach ( $saved as $key => $value ) {
		if ( ! array_key_exists( $key, $defaults ) ) {
			if ( '' !== $value && null !== $value && array() !== $value ) {
				$merged[ $key ] = $value;
			}
			continue;
		}

		if ( is_array( $value ) && is_array( $defaults[ $key ] ) ) {
			if ( optifo_is_list_array( $value ) || optifo_is_list_array( $defaults[ $key ] ) ) {
				$merged[ $key ] = optifo_merge_repeater_list( $defaults[ $key ], $value );
			} else {
				$merged[ $key ] = optifo_merge_section_data( $defaults[ $key ], $value );
			}
			continue;
		}

		if ( is_numeric( $value ) && 0 === (int) $value && is_numeric( $defaults[ $key ] ) && 0 === (int) $defaults[ $key ] ) {
			continue;
		}

		if ( '' !== $value && null !== $value ) {
			$merged[ $key ] = $value;
		}
	}

	return $merged;
}

/**
 * Merge repeater rows by index so saved image IDs are preserved per card.
 *
 * @param array $defaults Default rows.
 * @param array $saved    Saved rows.
 * @return array
 */
function optifo_merge_repeater_list( $defaults, $saved ) {
	if ( ! is_array( $saved ) || empty( $saved ) ) {
		return is_array( $defaults ) ? $defaults : array();
	}

	$saved = array_values(
		array_filter(
			$saved,
			function ( $row, $key ) {
				return is_array( $row ) && ( is_int( $key ) || ( is_string( $key ) && ctype_digit( $key ) ) );
			},
			ARRAY_FILTER_USE_BOTH
		)
	);

	if ( empty( $saved ) ) {
		return is_array( $defaults ) ? $defaults : array();
	}

	$defaults = is_array( $defaults ) ? $defaults : array();
	$count    = max( count( $defaults ), count( $saved ) );
	$merged   = array();

	for ( $i = 0; $i < $count; $i++ ) {
		$def_row = $defaults[ $i ] ?? array();
		$sav_row = $saved[ $i ] ?? array();

		if ( empty( $sav_row ) ) {
			$merged[] = $def_row;
		} elseif ( empty( $def_row ) ) {
			$merged[] = $sav_row;
		} else {
			$merged[] = optifo_merge_section_data( $def_row, $sav_row );
		}
	}

	return $merged;
}

/**
 * Check if array is a list (repeater rows).
 *
 * @param array $arr Array.
 * @return bool
 */
function optifo_is_list_array( $arr ) {
	if ( ! is_array( $arr ) || empty( $arr ) ) {
		return false;
	}
	return array_keys( $arr ) === range( 0, count( $arr ) - 1 );
}

/**
 * Default hero section.
 *
 * @return array
 */
function optifo_default_hero_section() {
	return array(
		'enabled'       => 1,
		'heading_light' => 'AI',
		'heading_bold'  => 'IMAGING APP',
		'title_light'   => 'ELEVATE YOUR SALES WITH',
		'title_bold'    => 'OPTIFOS AI IMAGING APP',
		'title_end'     => ' FOR CAR DEALERS!',
		'description'   => "Professional, AI-powered photo & video editing for car dealers—\ncreate consistent, high-quality vehicle images effortlessly.",
		'price_label'   => '129 EURO/MONTH',
		'price_subtitle'=> 'UNLIMITED CREDITS',
		'banner_image'  => 0,
	);
}

/**
 * Default counter section.
 *
 * @return array
 */
function optifo_default_counter_section() {
	return array(
		'enabled'  => 1,
		'counters' => array(
			array( 'title' => '+55%', 'subtitle' => 'CTR Growth' ),
			array( 'title' => '+80%', 'subtitle' => 'Cost Reduction' ),
			array( 'title' => '+85%', 'subtitle' => 'Faster Time-to-Market' ),
			array( 'title' => '+100%', 'subtitle' => 'Consistent Images' ),
		),
	);
}

/**
 * Default why use section.
 *
 * @return array
 */
function optifo_default_why_use_section() {
	return array(
		'enabled'       => 1,
		'heading_light' => 'WHY USE',
		'heading_bold'  => 'OPTIFO.AI?',
		'image_before'  => 0,
		'image_after'   => 0,
		'info_boxes'    => array(
			array(
				'title' => '01- Take Consistent Photos and videos of your cars with our guidelines!',
				'items' => array(
					'The whole photo process takes under 30 seconds.',
					'App. - available in Appstore and Google Play',
					'unlimited retakes',
					'Simple interface integration to your DMS or vehicle administration tool. the pictures are automatically transferred and published online.',
				),
			),
			array(
				'title' => '02- AI-Automated editing',
				'items' => array(
					'Adjust size and colour',
					'Add a unique background',
					'Complete the photo with your logo',
				),
			),
			array(
				'title' => '03 - Download',
				'items' => array(
					'Ready to use within seconds',
					'Unlimited Photos for only 129 Euro/month.',
				),
			),
		),
	);
}

/**
 * Default how it works section.
 *
 * @return array
 */
function optifo_default_how_it_works_section() {
	return array(
		'enabled'       => 1,
		'heading_light' => 'HOW TO',
		'heading_bold'  => 'USE OPTIFO?',
		'description'   => 'In the video below, we briefly explain how Optifo works. Watch the video and start taking professional photos of your cars right away.',
		'video_url'     => 'https://www.youtube.com/embed/CBS-qVEGb5k?si=MtLM6Nw0p0Wvzquy&start=1',
		'poster'        => 0,
		'steps'         => array(
			array( 'number' => '1', 'title' => 'REGISTER IN OUR WEBPAGE' ),
			array( 'number' => '2', 'title' => 'OPEN OPTIFO' ),
			array( 'number' => '3', 'title' => 'TAKE PICTURE' ),
			array( 'number' => '4', 'title' => 'PRESS EDIT' ),
			array( 'number' => '5', 'title' => 'MAKE ADJUSTMENT' ),
			array( 'number' => '6', 'title' => 'SAVE THE IMAGES' ),
		),
	);
}

/**
 * Default web/mobile section.
 *
 * @return array
 */
function optifo_default_web_mobile_section() {
	return array(
		'enabled'         => 1,
		'heading_light'   => 'Web or Mobile—Your',
		'heading_bold'    => 'Convenience',
		'heading_bold_2'  => 'Choice',
		'heading_middle'  => ', Your ',
		'description'     => 'For your convenience, we have both a web application and a mobile application available. You can use whichever platform you prefer.',
		'cards'           => array_fill( 0, 5, array( 'image' => 0 ) ),
	);
}

/**
 * Default dashboard section.
 *
 * @return array
 */
function optifo_default_dashboard_section() {
	return array(
		'enabled' => 1,
		'image'   => 0,
	);
}

/**
 * Default pricing section.
 *
 * @return array
 */
function optifo_default_pricing_section() {
	return array(
		'enabled'       => 1,
		'heading_light' => 'PACKS AND',
		'heading_bold'      => 'PRICING',
		'heading_bold_line2'=> 'CRAFTED',
		'heading_light_2'   => 'TO MEET',
		'heading_bold_2'    => 'ANY SIZE',
		'subtitle'      => '1 Credit = 1 Image',
		'footnote'      => '*All packs exclude VAT.<br>You will pay in your local currency at checkout. Unlimited Credits pricing is for regular car dealers only—auto commission dealers, auction platforms, and large OEMs must contact us for pricing.',
		'cards'         => array(
			array(
				'title'       => '500 Credits',
				'subtitle'    => '€89 Per Transaction',
				'button_text' => 'GET STARTED',
				'button_url'  => '#',
				'image'       => 0,
			),
			array(
				'title'       => 'Unlimited',
				'subtitle'    => '129 € Per Transaction',
				'button_text' => 'GET STARTED',
				'button_url'  => '#',
				'image'       => 0,
			),
		),
	);
}

/**
 * Default featured in section.
 *
 * @return array
 */
function optifo_default_featured_in_section() {
	return array(
		'enabled' => 1,
		'title'   => 'FEATURED IN',
		'cards'   => array(
			array( 'image' => 0, 'fallback' => 'featured_in_logo_1.png' ),
			array( 'image' => 0, 'fallback' => 'featured_in_logo_2.png' ),
			array( 'image' => 0, 'fallback' => 'featured_in_logo_3.png' ),
		),
	);
}

/**
 * Default studio quality carousel.
 *
 * @return array
 */
function optifo_default_studio_quality_section() {
	return array(
		'enabled' => 1,
		'slides'  => array(
			array(
				'heading'      => 'Studio-quality visuals that Convert Browsers Into Buyers',
				'bg'           => 'bg-primary-dark',
				'type'         => 'compare',
				'before'       => 'car_clear.png',
				'after'        => 'car_blur.png',
				'button_text'  => 'Get in touch',
				'button_url'   => '#contact',
				'button2_text' => 'Explore in AI',
				'button2_url'  => '#',
			),
			array(
				'heading'      => 'Immersive 360° car views that captivate buyers and drive decisions.',
				'bg'           => '',
				'bg_color'     => '#111D40',
				'type'         => 'image',
				'fallback'     => 's1.png',
				'button_text'  => 'Get in touch',
				'button_url'   => '#contact',
				'button2_text' => 'Explore in AI',
				'button2_url'  => '#',
			),
			array(
				'heading'      => 'Studio-quality visuals that Convert Browsers Into Buyers',
				'bg'           => 'bg-primary-dark',
				'type'         => 'image',
				'fallback'     => 's2.png',
				'button_text'  => 'Get in touch',
				'button_url'   => '#contact',
				'button2_text' => 'Explore in AI',
				'button2_url'  => '#',
			),
		),
	);
}

/**
 * Default behind the design section.
 *
 * @return array
 */
function optifo_default_behind_design_section() {
	return array(
		'enabled'        => 1,
		'badge_text'     => 'BEHIND THE DESIGN',
		'heading_bold'   => "CURIOUS WHAT ELSE I'VE CREATED?",
		'description'    => 'Explore more brand identities, packaging and design work in my extended portfolio.',
		'button_text'    => 'SEE MORE PROJECTS',
		'button_url'     => '#',
		'process_items'  => array(
			array( 'title' => 'Strategy & Planning' ),
			array( 'title' => 'Design & Development' ),
			array( 'title' => 'Launch & Growth' ),
			array( 'title' => 'Ongoing Support' ),
		),
	);
}

/**
 * Default worldwide trust section.
 *
 * @return array
 */
function optifo_default_worldwide_trust_section() {
	return array(
		'enabled'       => 1,
		'heading_light' => 'Worldwide',
		'heading_bold'  => 'Trust',
		'description'   => "We're proud that Optifo is being actively used by car dealerships worldwide. In fact, we're active in 25 countries, and more are joining us every day. Want to join the journey? Try Optifo right now.",
	);
}

/**
 * Default contact section.
 *
 * @return array
 */
function optifo_default_contact_section() {
	return array(
		'enabled'       => 1,
		'heading_light' => 'WE WOULD LOVE TO',
		'heading_bold'  => 'TALK TO YOU!',
		'description'   => 'If you would like to know more about Optifo and how we can help your dealer, please fill in your details below and a sales specialist will contact you.',
		'video_url'     => 'https://www.youtube.com/embed/CBS-qVEGb5k?si=MtLM6Nw0p0Wvzquy&start=1',
		'poster'        => 0,
	);
}

/**
 * Default FAQs section meta.
 *
 * @return array
 */
function optifo_default_faqs_section() {
	return array(
		'enabled'       => 1,
		'heading_light' => "Questions?\n We have",
		'heading_bold'  => 'got answers.',
		'description'   => 'Everything you need to know, all in one place.',
		'image'         => 0,
	);
}

/**
 * Default FAQ items (when no FAQ posts exist).
 *
 * @return array
 */
function optifo_get_default_faq_items() {
	return array(
		array(
			'question' => 'What is a credit?',
			'answer'   => 'A credit is a unit used to access services or features.',
			'open'     => false,
		),
		array(
			'question' => 'How to contact us?',
			'answer'   => 'You can contact us via email or support chat.',
			'open'     => false,
		),
		array(
			'question' => 'Can I select another pack?',
			'answer'   => 'Yes, you can switch plans anytime.',
			'open'     => false,
		),
		array(
			'question' => 'How long is the contract binding?',
			'answer'   => "At Optifo.ai, we trust in our products, our customers, and the entire process. That's why there's no binding period, however, termination is ongoing month + 30 days.",
			'open'     => true,
		),
		array(
			'question' => 'What if I am unsatisfied with the picture?',
			'answer'   => "We offer revisions until you're satisfied.",
			'open'     => false,
		),
	);
}

/**
 * Default pricing plan cards (when no pricing CPT posts).
 *
 * @return array
 */
function optifo_get_default_pricing_cards() {
	return optifo_default_pricing_section()['cards'];
}

/**
 * Seed all default options on theme activation.
 */
function optifo_seed_default_data() {
	if ( ! get_option( 'optifo_homepage_sections' ) ) {
		update_option( 'optifo_homepage_sections', optifo_default_homepage_sections() );
	}

	if ( ! get_option( 'optifo_theme_options' ) ) {
		update_option( 'optifo_theme_options', optifo_default_theme_options() );
	}

	if ( ! get_option( 'optifo_map_locations' ) ) {
		update_option( 'optifo_map_locations', optifo_default_map_locations() );
	}

	foreach ( optifo_get_all_section_defaults() as $section_id => $defaults ) {
		$option_key = 'optifo_section_' . $section_id;
		$existing   = get_option( $option_key, false );
		if ( false === $existing ) {
			update_option( $option_key, $defaults );
		}
	}
}
