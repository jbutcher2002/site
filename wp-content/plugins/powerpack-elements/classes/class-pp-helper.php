<?php
namespace PowerpackElements\Classes;

use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class PP_Posts_Helper.
 */
class PP_Helper {
	
	/**
	 * Get Google Map Languages
	 *
	 * @since 1.4.11.2
	 * @access public
	 */
    public static function get_google_map_languages() {
        
        $languages = array( 
            'af'		=> __( 'AFRIKAAN', 'powerpack' ),
            'sq'		=> __( 'ALBANIAN', 'powerpack' ),
            'am'		=> __( 'AMHARIC', 'powerpack' ),
            'ar'		=> __( 'ARABIC', 'powerpack' ),
            'hy'		=> __( 'ARMENIAN', 'powerpack' ),
            'az'		=> __( 'AZERBAIJANI', 'powerpack' ),
			'eu'		=> __( 'BASQUE', 'powerpack' ),
			'be'		=> __( 'BELARUSIAN', 'powerpack' ),
			'bn'		=> __( 'BENGALI', 'powerpack' ),
			'bs'		=> __( 'BOSNIAN', 'powerpack' ),
			'bg'		=> __( 'BULGARIAN', 'powerpack' ),
			'my'		=> __( 'BURMESE', 'powerpack' ),
			'ca'		=> __( 'CATALAN', 'powerpack' ),
			'zh'		=> __( 'CHINESE', 'powerpack' ),
			'zh-CN'		=> __( 'CHINESE (SIMPLIFIED)', 'powerpack' ),
			'zh-HK'		=> __( 'CHINESE (HONG KONG)', 'powerpack' ),
			'zh-TW'		=> __( 'CHINESE (TRADITIONAL)', 'powerpack' ),
			'hr'		=> __( 'CROATIAN', 'powerpack' ),
			'cs'		=> __( 'CZECH', 'powerpack' ),
			'da'		=> __( 'DANISH', 'powerpack' ),
			'nl'		=> __( 'DUTCH', 'powerpack' ),
			'en'		=> __( 'ENGLISH', 'powerpack' ),
			'en-AU'		=> __( 'ENGLISH (AUSTRALIAN)', 'powerpack' ),
			'en-GB'		=> __( 'ENGLISH (GREAT BRITAIN)', 'powerpack' ),
			'et'		=> __( 'ESTONIAN', 'powerpack' ),
			'fa'		=> __( 'FARSI', 'powerpack' ),
			'fi'		=> __( 'FINNISH', 'powerpack' ),
			'fil'		=> __( 'FILIPINO', 'powerpack' ),
			'fr'		=> __( 'FRENCH', 'powerpack' ),
			'fr-CA'		=> __( 'FRENCH (CANADA)', 'powerpack' ),
			'gl'		=> __( 'GALICIAN', 'powerpack' ),
			'ka'		=> __( 'GEORGIAN', 'powerpack' ),
			'de'		=> __( 'GERMAN', 'powerpack' ),
			'el'		=> __( 'GREEK', 'powerpack' ),
			'gu'		=> __( 'GUJARATI', 'powerpack' ),
			'iw'		=> __( 'HEBREW', 'powerpack' ),
			'hi'		=> __( 'HINDI', 'powerpack' ),
			'hu'		=> __( 'HUNGARIAN', 'powerpack' ),
			'is'		=> __( 'ICELANDIC', 'powerpack' ),
			'id'		=> __( 'INDONESIAN', 'powerpack' ),
			'it'		=> __( 'ITALIAN', 'powerpack' ),
			'ja'		=> __( 'JAPANESE', 'powerpack' ),
			'kn'		=> __( 'KANNADA', 'powerpack' ),
			'kk'		=> __( 'KAZAKH', 'powerpack' ),
			'km'		=> __( 'KHMER', 'powerpack' ),
			'ko'		=> __( 'KOREAN', 'powerpack' ),
			'ky'		=> __( 'KYRGYZ', 'powerpack' ),
			'lo'		=> __( 'LAO', 'powerpack' ),
			'lv'		=> __( 'LATVIAN', 'powerpack' ),
			'lt'		=> __( 'LITHUANIAN', 'powerpack' ),
			'mk'		=> __( 'MACEDONIAN', 'powerpack' ),
			'ms'		=> __( 'MALAY', 'powerpack' ),
			'ml'		=> __( 'MALAYALAM', 'powerpack' ),
			'mr'		=> __( 'MARATHI', 'powerpack' ),
			'mn'		=> __( 'MONGOLIAN', 'powerpack' ),
			'ne'		=> __( 'NEPALI', 'powerpack' ),
			'no'		=> __( 'NORWEGIAN', 'powerpack' ),
			'pl'		=> __( 'POLISH', 'powerpack' ),
			'pt'		=> __( 'PORTUGUESE', 'powerpack' ),
			'pt-BR'		=> __( 'PORTUGUESE (BRAZIL)', 'powerpack' ),
			'pt-PT'		=> __( 'PORTUGUESE (PORTUGAL)', 'powerpack' ),
			'pa'		=> __( 'PUNJABI', 'powerpack' ),
			'ro'		=> __( 'ROMANIAN', 'powerpack' ),
			'ru'		=> __( 'RUSSIAN', 'powerpack' ),
			'sr'		=> __( 'SERBIAN', 'powerpack' ),
			'si'		=> __( 'SINHALESE', 'powerpack' ),
			'sk'		=> __( 'SLOVAK', 'powerpack' ),
			'sl'		=> __( 'SLOVENIAN', 'powerpack' ),
			'es'		=> __( 'SPANISH', 'powerpack' ),
			'es-419'	=> __( 'SPANISH (LATIN AMERICA)', 'powerpack' ),
			'sw'		=> __( 'SWAHILI', 'powerpack' ),
			'sv'		=> __( 'SWEDISH', 'powerpack' ),
			'ta'		=> __( 'TAMIL', 'powerpack' ),
			'te'		=> __( 'TELUGU', 'powerpack' ),
			'th'		=> __( 'THAI', 'powerpack' ),
			'tr'		=> __( 'TURKISH', 'powerpack' ),
			'uk'		=> __( 'UKRAINIAN', 'powerpack' ),
			'ur'		=> __( 'URDU', 'powerpack' ),
			'uz'		=> __( 'UZBEK', 'powerpack' ),
			'vi'		=> __( 'VIETNAMESE', 'powerpack' ),
			'zu'		=> __( 'ZULU', 'powerpack' ),
        );

        return $languages;
    }	
}