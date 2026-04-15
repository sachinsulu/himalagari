<?php
/*
* Testimonial module
*/

$tmonialRec = Review::find_for_homepage();
$useLegacyTestimonial = false;

// Fallback: use testimonial table if homepage reviews are not configured.
if (empty($tmonialRec)) {
    $tmonialRec = Testimonial::get_alltestimonial();
    $useLegacyTestimonial = true;
}

// Secondary fallback: support plural table name used in some databases.
if (empty($tmonialRec)) {
    global $db;
    $tableCheck = $db->query("SHOW TABLES LIKE 'tbl_testimonials'");
    if ($db->num_rows($tableCheck) > 0) {
        $result = $db->query("SELECT name, content, country, grade, linksrc FROM tbl_testimonials WHERE status=1 ORDER BY id DESC");
        $rows = array();
        while ($record = $db->fetch_array($result)) {
            $rows[] = $record;
        }
        if (!empty($rows)) {
            $tmonialRec = $rows;
            $useLegacyTestimonial = true;
        }
    }
}

// Home Testimonial
$tstmresult = '';
if (defined('HOME_PAGE')) {
    $tmonialRec = Review::find_for_homepage();
     // Fallback: use testimonial table if homepage reviews are not configured.
    if (empty($tmonialRec)) {
        $tmonialRec = Testimonial::get_alltestimonial();
        $useLegacyTestimonial = true;
    }

if ($tmonialRec) {
    $getValue = function ($row, $field) {
        if (is_array($row)) {
            return isset($row[$field]) ? $row[$field] : '';
        }
        return isset($row->$field) ? $row->$field : '';
    };

    foreach ($tmonialRec as $row) {
        $rating_stars = '';
        $legacyGrade = $getValue($row, 'grade');
        $reviewRating = $getValue($row, 'rating');
        $rating = $useLegacyTestimonial ? (!empty($legacyGrade) ? (int)$legacyGrade : 5) : (!empty($reviewRating) ? (int)$reviewRating : 5);
        $rating = max(1, min(5, $rating));
        for ($i = 0; $i < $rating; $i++) {
            $rating_stars .= '★ ';
        }

        $nameValue = $getValue($row, 'name');
        $titleValue = $getValue($row, 'title');
        $contentValue = $getValue($row, 'content');
        $commentsValue = $getValue($row, 'comments');
        $countryValue = $getValue($row, 'country');
        $linksrcValue = $getValue($row, 'linksrc');

        $title = $useLegacyTestimonial ? (!empty($nameValue) ? $nameValue : 'Review') : (!empty($titleValue) ? $titleValue : 'Review');
        $comments = $useLegacyTestimonial ? (!empty($contentValue) ? $contentValue : '') : (!empty($commentsValue) ? $commentsValue : '');
        $name = !empty($nameValue) ? $nameValue : 'Guest';
        $country = !empty($countryValue) ? $countryValue : '';
        $reviewLink = ($useLegacyTestimonial && !empty($linksrcValue)) ? $linksrcValue : 'https://www.tripadvisor.com/';

        $tstmresult .= '
        <div class="testimonial-card">
            <div class="testimonial-header">
                <div class="mx-auto">
                    <span class="name">" ' . $title . ' "</span>
                    <p class="rating">' . trim($rating_stars) . '</p>
                </div>
                <a href="' . $reviewLink . '" target="_blank" rel="noreferrer noopener ">
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
            ' . strip_tags($comments) . '
            </p>
            <div class="author_info">
                <p>- ' . $name . '</p>
                <p>Country : ' . $country . '</p>
            </div>
        </div>';
    }
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