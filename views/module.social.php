<?php
/*
 * Top Social Links
 */
$resocl = '';

$socialRec = SocialNetworking::getSocialNetwork();


if (!empty($socialRec)) {
    $resocl .= '<ul>';

    foreach ($socialRec as $socialRow) {
        $resocl .= '<li><a target="_blank" href="' . $socialRow->linksrc . '">
		<i class="fa ' . $socialRow->image . ' fa" aria-hidden="true"></i>
	    	
	  	</a></li>';
    }

    $resocl .= '</ul>';
}

$jVars['module:socilaLinktop'] = $resocl;


/*
 *  Social link
 */
$ressl = '';


if (!empty($socialRec)) {
    foreach ($socialRec as $socialRow) {
        $ressl .= '<a href="' . $socialRow->linksrc . '" target="_blank" ><i class="' . $socialRow->image . '"></i></a> ';
    }
}

$jVars['module:socilaLinkbtm'] = $ressl;


/*
 *   Footer
 */
$ressl = '';

if (!empty($socialRec)) {
    $ressl .= '<style>.affilation-footer{float:right;}</style><ul class="affilation-footer">';
    foreach ($socialRec as $socialRow) {
        $ressl .= '<li><a href="' . $socialRow->linksrc . '" target="_blank"><i class="fab ' . $socialRow->image . '"></i></a></li>';
    }
    $ressl .= '</ul>';
}

$jVars['module:socilaLinkbtmFooter'] = $ressl;

?>