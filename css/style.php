<?php
/**
 * Generator for styles this plugin is using. Only used on compiling the plugin for release
 * or during development via ant.
 *
 * @see readme.md
 * @package nested-ordered-lists-block-editor
 */

// Set header to text/css.
header( 'Content-type: text/css' );
?>
/* Default listing */
body ol[type=a1], body ol[type=a1] ol {
	list-style-type: lower-alpha;
}
body ol[type=a1] > li {
	list-style-type: lower-alpha !important;
}

body ol[type=a2], body ol[type=a2] ol {
	list-style-type: upper-alpha;
}
body ol[type=a2] > li {
	list-style-type: upper-alpha !important;
}

body ol[type=i1], body ol[type=i1] ol {
	list-style-type: lower-roman;
}
body ol[type=i1] > li {
	list-style-type: lower-roman !important;
}

body ol[type=i2], body ol[type=i2] ol {
	list-style-type: upper-roman;
}
body ol[type=i2] > li {
	list-style-type: upper-roman !important;
}

body ol.nolg-list, body ol.nolg-list ol {
	list-style: none;
}
body ol.nolg-list > li {
	list-style: none !important;
}

body ol.nolg-list, body ol.nolg-list ol {
	counter-reset: l1 0 l2 0 l3 0;
}

body ol.nolg-list, body ol.nolg-list:not(.nolg-list-intent) ol {
	padding-left: 0;
}

body ol.nolg-list > li:before, body ol.nolg-list li > ol > li:before {
	counter-increment: l1;
	content: counters(l1, ".") ". ";
}

body ol.nolg-list[type=a1] > li:before, body ol.nolg-list[type=a1] li > ol > li:before {
	counter-increment: l1;
	content: counters(l1, ".", lower-alpha) " ";
}

body ol.nolg-list[type=a2] > li:before, body ol.nolg-list[type=a2] li > ol > li:before {
	counter-increment: l1;
	content: counters(l1, ".", upper-alpha) " ";
}

body ol.nolg-list[type=i1] > li:before, body ol.nolg-list[type=i1] li > ol > li:before {
	counter-increment: l1;
	content: counters(l1, ".", lower-roman) " ";
}

body ol.nolg-list[type=i2] > li:before, body ol.nolg-list[type=i2] li > ol > li:before {
	counter-increment: l1;
	content: counters(l1, ".", upper-roman) " ";
}

body ol.nolg-list li ol > li:before {
	content: counters(l1, ".") " ";
}

body ol.nolg-list[reversed] > li:before {
	counter-increment: l1 -1;
}

body ol.nolg-list[start] > li:first-child:before, body ol.nolg-list[reversed] > li:first-child:before {
	counter-increment: none !important;
}

<?php
// max level to generate.
$max_level = 5;
if ( ! empty( $argv[1] ) ) {
	$max_level = abs( $argv[1] );
}

// set level-selector.
$css_level_selector = '';

/**
 * Define types of styles.
 *
 * We use custom keys, not the css-defaults, as chrome cannot differ between "i" and "I".
 *
 * @source https://caniuse.com/?search=case-sensitive
 */
$types = array(
	'1'  => 'decimal',
	'a1' => 'lower-alpha',
	'a2' => 'upper-alpha',
	'i1' => 'lower-roman',
	'i2' => 'upper-roman',
);

// loop through max level from settings.
for ( $m2 = 2;$m2 < $max_level;$m++ ) {

	$css_level_selector .= '[data-startl' . $m2 . ']';

	foreach ( $types as $key => $value ) {

		// define list-point-style from level 1 ongoing depending on level-selector (will be concat).
		$css_content = '';
		for ( $i = $m2 - 1; $i > 0; $i-- ) {
			$css_content .= 'counter(l' . $i . ', ' . $value . ')"."';
		}

		// define reset-var.
		$css_counter_reset = '';

		// define selector-structure (will be concat per level).
		$selector           = array();
		$add_to_css_content = array();

		// loop as long max level is not reached and any type for each level is set.
		for ( $l = $m2 + 1; $l < $m2 + $max_level; $l++ ) {
			// level, e.g.: > li> ol OR > li > ol > li > ol.

			// set counter reset for this level.
			$css_counter_reset = ' l' . ( $l - 1 );

			// add selector for this level.
			$selector[ $l ] = ( ! empty( $selector[ $l - 1 ] ) ? $selector[ $l - 1 ] : '' ) . ( ( $l - 1 ) > $m2 ? ' > li > ol' : '' );

			// set what we want to add to css.
			$add_to_css_content[ $l ] = 'counter(l' . ( $l - 1 ) . ', ' . $value . ')" "';

			// set content which this level will use.
			$css_content_use = $css_content . $add_to_css_content[ $l ];

			// add to output.
			echo '
                body ol.nolg-list[start]' . $css_level_selector . $selector[ $l ] . ' {
                    counter-reset:' . $css_counter_reset . ' 0;
                }
        
                body ol.nolg-list[start]' . $css_level_selector . '[type="' . $key . '"]' . $selector[ $l ] . ' > li:before {
                    counter-increment: l' . ( $l - 1 ) . ';
                    content: ' . $css_content_use . ';
                }
            ';
			// add content to the list (with point at the end).
			$css_content .= 'counter(l' . ( $l - 1 ) . ', ' . $value . ')"."';
		}
	}
}

// erzeuge pro level alle möglichen Kombinationen der typen.
$type_string  = '';
$value_string = '';
$selector     = '';
for ( $m3 = 1;$m3 < $max_level;$m3++ ) {
	foreach ( $types as $key => $value ) {
		$type_string  = '[data-typel' . $m3 . '=' . $key . ']';
		$value_string = 'counter(l' . $m3 . ', ' . $value . ')" "';
		echo 'body ol.nolg-list[start]' . $type_string . $selector . ' li:before { content: ' . $value_string . '; }';
		echo "\n";
		deeper( $m3, $type_string, $value_string, $types, $max_level, $selector );
	}
	echo "\n";
}

/**
 * Generate deeper CSS-selektors.
 *
 * @param int    $m
 * @param string $type_string
 * @param string $value_string
 * @param array  $types
 * @param int    $max_level
 * @param string $selector
 * @return void
 */
function deeper( int $m, string $type_string, string $value_string, array $types, int $max_level, string $selector ): void {
	for ( $s = $m + 1;$s > $m;$s-- ) {
		foreach ( $types as $key2 => $value2 ) {
			$type_string2  = $type_string . '[data-typel' . $s . '=' . $key2 . ']';
			$value_string2 = $value_string . 'counter(l' . $s . ', ' . $value2 . ')" "';
			echo 'body ol.nolg-list[start]' . $type_string2 . $selector . ' li:before { content: ' . $value_string2 . '; }';
			echo "\n";
			if ( $s < $max_level ) {
				deeper( $s, $type_string2, $value_string2, $types, $max_level, $selector );
			}
		}
	}
}

// set level-selector.
$css_level_selector = '[reversed]';

// loop through max level from settings.
for ( $m4 = 2;$m4 < $max_level;$m4++ ) {

	$css_level_selector .= '[data-startl' . $m4 . ']';

	// define list-point-style from level 1 ongoing depending on level-selector (will be concat).
	$css_content = '';
	for ( $i = $m4 - 1;$i > 0;$i-- ) {
		$css_content = 'counter(l' . $i . ')"."' . $css_content;
	}

	// define reset-var.
	$css_counter_reset = '';

	// define selector-structure (will be concat).
	$selector = '';

	// loop as long max level is not reached.
	for ( $l = $m4 + 1;$l < $m4 + 6;$l++ ) {
		// set counter reset.
		$css_counter_reset = ' l' . ( $l - 1 );

		// set content which this level will use.
		$css_content_use = $css_content . 'counter(l' . ( $l - 1 ) . ')" "';

		// add content to the list (with point at the end).
		$css_content .= 'counter(l' . ( $l - 1 ) . ')"."';

		// add selector.
		$selector .= ( $l - 1 ) > $m4 ? ' > li > ol' : '';

		// set level addition.
		$level_addition = -1;
		if ( $l >= ( $m4 + 2 ) ) {
			$level_addition = 1; }

		// add to output.
		echo '
            body ol.nolg-list[start]' . $css_level_selector . $selector . ' {
                counter-reset:' . $css_counter_reset . ' 0;
            }

            body ol.nolg-list[start]' . $css_level_selector . $selector . ' > li:before {
                counter-increment: l' . ( $l - 1 ) . ' ' . $level_addition . ';
                content: ' . $css_content_use . ';
            }
        ';
	}
}
