<?php
/**
 * When implemented, set the following for each list:
 * - Class "nolg-list".
 * - style "counter-reset" with individual values
 * - for reversed only in parent OL set counter-reset in l1 to the number of child elements
 */

$preset = '<li>Erstens
        <ol>
            <li>Sub 1</li>
            <li>Sub 2
                <ol>
                    <li>Sub 1a</li>
                    <li>Sub 1b</li>
                </ol>
            </li>
        </ol>
    </li>
    <li>Zweitens</li>
    <li>Drittens
        <ol>
            <li>Sub 1</li>
            <li>Sub 2</li>
        </ol>
    </li>
    <li>Viertens
        <ol>
            <li>Sub 1</li>
            <li>Sub 2
                <ol>
                    <li>Sub 2a</li>
                    <li>Sub 2b
                        <ol>
                            <li>Sub 2a1</li>
                            <li>Sub 2a2
                                <ol>
                                    <li>Sub 2a1a</li>
                                    <li>Sub 2a1b</li>
                                </ol>
                            </li>
                        </ol>
                    </li>
                </ol>
            </li>
        </ol>
    </li>';
?>
<style>
    /* Default listing */
    body ol.nolg-list, body ol.nolg-list ol {
        list-style: none;
    }

    body ol.nolg-list, body ol.nolg-list ol {
        counter-reset: l1 0 l2 0 l3 0;
    }

    body ol.nolg-list, body ol.nolg-list:not(.nolg-list-intent) ol {
        padding-left: 0;
    }

    body ol.nolg-list li:before {
        counter-increment: l1;
        content: counters(l1, ".") " ";
    }

    body ol.nolg-list[type="i1"] li:before {
        counter-increment: l1;
        content: counters(l1, ".", lower-roman) " ";
    }

    body ol.nolg-list[type="i2"] li:before {
        counter-increment: l1;
        content: counters(l1, ".", upper-roman) " ";
    }

    body ol.nolg-list[reversed] > li:before {
        counter-increment: l1 -1;
    }

    body ol.nolg-list[start] > li:first-child:before, body ol.nolg-list[reversed] > li:first-child:before {
        counter-increment: none !important;
    }

    <?php
    // max level to generate
    $maxLevel = 8;

    // set level-selector
    $cssLevelSelector = '';

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

            // add to output
            echo '
                body ol.nolg-list[start]'.$cssLevelSelector.$selector.' {
                    counter-reset:'.$cssCounterReset.' 0;
                }
    
                body ol.nolg-list[start]'.$cssLevelSelector.$selector.' > li:before {
                    counter-increment: l'.($l-1).';
                    content: '.$cssContentUse.';
                }
            ';
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
    ?>
</style>
<h2 id="test10">ordered list with roman letters</h2>
<ol class="nolg-list" type="i2">
	<?php echo $preset; ?>
</ol>

<h2 id="test9">Mit Start auf mehreren Leveln: 2.5.7.9.2 but reversed</h2>
<ol class="nolg-list" start="2" reversed data-startl2="5" data-startl3="6" data-startl4="9" data-startl5="2" style="counter-reset: l1 2 l2 5 l3 7 l4 9 l5 5">
	<?php echo $preset; ?>
</ol>

<h2 id="test8">Mit Start Level 1 ab 2 und Level 2 ab 4 => 2.4 but reversed</h2>
<ol class="nolg-list" start="2" reversed data-startl2="4" style="counter-reset: l1 2 l2 4 l3 0 l4 0 l5 0 l6 0">
	<?php echo $preset; ?>
</ol>

<h2 id="test7">Mit Start Level 1 ab 2 => 2 but reversed</h2>
<ol class="nolg-list" start="2" reversed style="counter-reset: l1 4">
	<?php echo $preset; ?>
</ol>

<h2 id="test6">ordered list without settings but reversed</h2>
<ol class="nolg-list" reversed style="counter-reset: l1 4">
	<?php echo $preset; ?>
</ol>

<h2 id="test5">Mit Start auf mehreren Leveln: 2.5.7.9.2</h2>
<ol class="nolg-list" start="2" data-startl2="5" data-startl3="6" data-startl4="9" data-startl5="2" style="counter-reset: l1 2 l2 5 l3 7 l4 9 l5 2">
	<?php echo $preset; ?>
</ol>

<h2 id="test4">Mit Start auf mehreren Leveln: 2.5.7.9</h2>
<ol class="nolg-list" start="2" data-startl2="5" data-startl3="6" data-startl4="9" style="counter-reset: l1 2 l2 5 l3 7 l4 9">
	<?php echo $preset; ?>
</ol>

<h2 id="test3">Mit Start Level 1 ab 2 und Level 2 ab 4 => 2.4</h2>
<ol class="nolg-list" start="2" data-startl2="4" style="counter-reset: l1 2 l2 4">
	<?php echo $preset; ?>
</ol>

<h2 id="test2">Mit Start Level 1 ab 2 => 2</h2>
<ol class="nolg-list" start="2" style="counter-reset: l1 2">
	<?php echo $preset; ?>
</ol>

<h2 id="test1">ordered list without settings</h2>
<ol class="nolg-list" style="counter-reset l1 0;">
	<?php echo $preset; ?>
</ol>

<h2>Default</h2>
<ol>
    <?php echo $preset; ?>
</ol>