<?php
/*
* Testimonial module
*/

$tmonialRec = Review::find_for_homepage();

// Home Testimonial
$tstmresult = '';

if ($tmonialRec) {
    foreach ($tmonialRec as $row) {
        $rating_stars = '';
        $rating = !empty($row->rating) ? $row->rating : 5;
        for ($i = 0; $i < $rating; $i++) {
            $rating_stars .= '★ ';
        }

        $title = !empty($row->title) ? $row->title : 'Review';

        $tstmresult .= '
        <div class="testimonial-card">
            <div class="testimonial-header">
                <div class="mx-auto">
                    <span class="name">" ' . $title . ' "</span>
                    <p class="rating">' . trim($rating_stars) . '</p>
                </div>
                <a href="https://www.tripadvisor.com/" target="_blank" rel="noreferrer noopener ">
                    <span class="review-booked-via">
                    <p>Booked via :</p>
                    <img src="' . BASE_URL . 'template/web/assets/images/trip-advisor-logo.png" class="trip_advisor_logo" alt="" />
                    </span>
                </a>
                <span class="quote">
                    <i class="fa-solid fa-quote-left"></i>
                </span>
            </div>

            <p class="mt-4">
            ' . strip_tags($row->comments) . '
            </p>
            <div class="author_info">
                <p>- ' . $row->name . '</p>
                <p>Country : ' . $row->country . '</p>
            </div>
        </div>';
    }
}

$jVars['module:testimonial-list'] = $tstmresult;

/*
* Testimonial listing
*/
$reststmo = '';

if (defined('TESTIMONIAL_PAGE')) {
    $tlistRec = Testimonial::get_alltestimonial();
    if ($tlistRec) {
        $reststmo .= '<ul class="testimonial_detail">';
        foreach ($tlistRec as $tlistRow) {
            $reststmo .= '<li>';
            $file_path = SITE_ROOT . 'images/testimonial/' . $tlistRow->image;
            if (file_exists($file_path)):
                $reststmo .= '<div class="testimonial_img">
                        <img src="' . BASE_URL . 'phpthumb/phpThumb.php?w=241&h=150&src=' . IMAGE_PATH . 'testimonial/' . $tlistRow->image . '&zc=1"  title="' . $tlistRow->name . '" />                                             
                    </div>';
            endif;
            $reststmo .= '<div class="testimonail_det">' . $tlistRow->content . '
                <span>- ' . $tlistRow->name . ', ' . $tlistRow->country . '</span></div>
            </li>';
        }
        $reststmo .= '</ul>';
    }
}

$jVars['module:testimonialdetail'] = $reststmo;

$testimono = '';

$tstRand = Testimonial::get_alltestimonial();
if (!empty($tstRand)) {
    $testimono .= '<div class="testimonial-slider owl-carousel">';
    foreach ($tstRand as $testim) {


        $testimono .= '
<div class=" slider-item text-center">
                        <p>"' . ($testim->content) . '"</p>';
        $file_path = SITE_ROOT . 'images/testimonial/' . $testim->image;
        if (file_exists($file_path)):
            $testimono .= '<div class="testimonial_img text-center">
                                    <img style="width:50px;display: initial;" src="' . IMAGE_PATH . 'testimonial/' . $testim->image . '"  title="' . $testim->name . '" />                                           
                                </div>';
        endif;
        $testimono .= '<h5 >' . $testim->name . '</h5><h5 class="text-center"><i>-' . $testim->country . '</i></h5> 
                    </div>';
    }
    $testimono .= '</div>';
}
$jVars['module:testimonial-rand'] = $testimono;


?>