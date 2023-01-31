<?php
/**
 * Generator for styles this plugin is using. Only used on compiling the plugin for release
 * or during development via ant.
 *
 * @see readme.md
 */
header("Content-type: text/css");

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
// max level to generate
$maxLevel = 5;
if( !empty($argv[1]) ) {
	$maxLevel = abs($argv[1]);
}

// set level-selector
$cssLevelSelector = '';

/**
 * Define types of styles.
 *
 * We use custom keys, not the css-defaults, as chrome cannot differ between "i" and "I".
 *
 * @source https://caniuse.com/?search=case-sensitive
 */
$types = [
    '1' => 'decimal',
    'a1' => 'lower-alpha',
    'a2' => 'upper-alpha',
    'i1' => 'lower-roman',
    'i2' => 'upper-roman',
];

// loop through max level from settings
for( $m=2;$m<$maxLevel;$m++ ) {

	$cssLevelSelector .= '[data-startl' . $m . ']';

	foreach( $types as $key => $value ) {

		// define list-point-style from level 1 ongoing depending on level-selector (will be concat)
		$cssContent = '';
		for ( $i = $m - 1; $i > 0; $i -- ) {
			$cssContent .= 'counter(l' . $i . ', ' . $value . ')"."';
		}

		// define reset-var
		$cssCounterReset = '';

		// define selector-structure (will be concat per level)
		$selector        = [];
		$addToCssContent = [];

		// loop as long max level is not reached
		// and any type for each level is set
		for ( $l = $m + 1; $l < $m + $maxLevel; $l ++ ) {
			// level, e.g.: > li> ol OR > li > ol > li > ol

			// set counter reset for this level
			$cssCounterReset = ' l' . ( $l - 1 );

			// add selector for this level
			$selector[ $l ] = ( ! empty( $selector[ $l - 1 ] ) ? $selector[ $l - 1 ] : '' ) . ( ( $l - 1 ) > $m ? ' > li > ol' : '' );

            // set what we want to add to css
            $addToCssContent[ $l ] = 'counter(l' . ( $l - 1 ) . ', ' . $value . ')" "';

            // set content which this level will use
            $cssContentUse = $cssContent . $addToCssContent[ $l ];

            // add to output
            echo '
                body ol.nolg-list[start]' . $cssLevelSelector . $selector[ $l ] . ' {
                    counter-reset:' . $cssCounterReset . ' 0;
                }
        
                body ol.nolg-list[start]' . $cssLevelSelector . '[type="' . $key . '"]' . $selector[ $l ] . ' > li:before {
                    counter-increment: l' . ( $l - 1 ) . ';
                    content: ' . $cssContentUse . ';
                }
            ';
			// add content to the list (with point at the end)
			$cssContent .= 'counter(l' . ( $l - 1 ) . ', ' . $value . ')"."';
		}
	}
}

// erzeuge pro level alle möglichen Kombinationen der typen
$typeString = '';
$valueString = '';
$selector = '';
for( $m=1;$m<$maxLevel;$m++ ) {
	foreach ( $types as $key => $value ) {
		$typeString = '[data-typel' . $m . '=' . $key . ']';
		$valueString = 'counter(l' . $m . ', ' . $value . ')" "';
		echo 'body ol.nolg-list[start]' . $typeString . $selector.' li:before { content: ' . $valueString . '; }';
		echo "\n";
		deeper($m, $typeString, $valueString, $types, $maxLevel, $selector);
	}
	echo "\n";
}


function deeper( $m, $typeString, $valueString, $types, $maxLevel, $selector ) {
	for( $s=$m+1;$s>$m;$s-- ) {
		foreach ( $types as $key2 => $value2 ) {
			$typeString2 = $typeString.'[data-typel' . $s . '=' . $key2.']';
			$valueString2 = $valueString.'counter(l' . $s . ', ' . $value2 . ')" "';
			echo 'body ol.nolg-list[start]'.$typeString2. $selector . ' li:before { content: '.$valueString2.'; }';
			echo "\n";
			if( $s < $maxLevel ) {
				deeper( $s, $typeString2, $valueString2, $types, $maxLevel, $selector );
			}
		}
	}
}

// set level-selector
$cssLevelSelector = '[reversed]';

// loop through max level from settings
for( $m=2;$m<$maxLevel;$m++ ) {

    $cssLevelSelector .= '[data-startl'.$m.']';

    // define list-point-style from level 1 ongoing depending on level-selector (will be concat)
    $cssContent = '';
    for( $i=$m-1;$i>0;$i-- ) {
	    $cssContent = 'counter(l'.$i.')"."'.$cssContent;
    }

    // define reset-var
    $cssCounterReset = '';

    // define selector-structure (will be concat)
    $selector = '';

    // loop as long max level is not reached
    for( $l=$m+1;$l<$m+6;$l++ ) {
	    // set counter reset
	    $cssCounterReset = ' l'.($l-1);

	    // set content which this level will use
	    $cssContentUse = $cssContent.'counter(l'.($l-1).')" "';

	    // add content to the list (with point at the end)
	    $cssContent .= 'counter(l'.($l-1).')"."';

	    // add selector
	    $selector .= ($l-1) > $m ? ' > li > ol' : '';

	    // set level addition
	    $levelAddition = -1;
	    if( $l >= ($m+2) ) { $levelAddition = 1; }

	    // add to output
	    echo '
            body ol.nolg-list[start]'.$cssLevelSelector.$selector.' {
                counter-reset:'.$cssCounterReset.' 0;
            }

            body ol.nolg-list[start]'.$cssLevelSelector.$selector.' > li:before {
                counter-increment: l'.($l-1).' '.$levelAddition.';
                content: '.$cssContentUse.';
            }
        ';
    }
}
