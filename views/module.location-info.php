<?php
/*
 * Location Information
 */

$reslocbreif = '';
$emlAddress = str_replace('@', '&#64;', $siteRegulars->email_address);
$emlAddress = str_replace('.', '&#46;', $emlAddress);
$emails = explode("<br>", $emlAddress);
if (!empty($emails)) {
    $mail = '<a href="mailto:' . $emails[0] . '">' . $emails[0] . '</a>';
}

$contacts = explode("<br>", $siteRegulars->contact_info);

$number_divs = '';
$count = 0;

foreach ($contacts as $contact) {
    $contact = trim($contact);

    if (empty($contact))
        continue;
    if ($count >= 2)
        break; // ✅ limit to 2 numbers

    // ✅ Remove text inside parentheses
    $cleanContact = preg_replace('/\s*\(.*?\)/', '', $contact);

    // ✅ Extract tel number (remove spaces for tel link)
    $tel = preg_replace('/\s+/', '', $cleanContact);

    $number_divs .= '
        <div class="footer-line">
          <i class="fa-solid fa-phone "></i>
          <a href="tel:' . $tel . '">' . trim($cleanContact) . '</a>
        </div>
    ';

    $count++;
}


$reslocinfo = '';
$reslocinfo1 = '';

$reslocinfo .= '
<div class="contact-info">
    <h4 class="color-dark-2"><strong>Contact Info</strong></h4>
    
    <div class="media-contact-info">
      <i class="fa fa-map-marker" aria-hidden="true"></i> 
      <span>' . $siteRegulars->fiscal_address . '</span>, <span>' . $siteRegulars->city . '</span>
    </div>
    <div class="media-contact-info">
       <i class="fa fa-phone" aria-hidden="true"></i>';
$contacts = explode(',', $siteRegulars->contact_info);
$mobile = explode(',', $siteRegulars->contact_info2);
foreach ($contacts as $contact) {
    $reslocinfo .= '
        <span><a style="color:#616161;" href="tel:' . $contact . '">' . $contact . ',</a></span>
      ';
}

$reslocinfo .= '</div> <div class="media-contact-info">
      <i class="fa fa-phone" aria-hidden="true"></i>
      <span><a style="color:#616161;" href="tel:' . $mobile[0] . '">' . $mobile[0] . '</a>' . @$mobile[1] . '</span>
    </div> 
            
    <div class="media-contact-info">    
      <i class="fa fa-envelope-o" aria-hidden="true"></i>
      <span>' . $siteRegulars->mail_address . '</span>
    </div>          

</div>';

$reslocinfo1 = '

<div class="contact-info">
            <h4>Nepal (Registered Office)</h4>
            <div class="info-item">
              <i class="fa-solid fa-location-dot"></i>
              <p>
                ' . $siteRegulars->fiscal_address . '
              </p>
            </div>

            <div class="info-item">
              <i class="fa-solid fa-envelope"></i>
              <p>
                ' . $mail . '
              </p>
            </div>

            ' . $number_divs . '

            <!-- MAP -->
            <div class="map-wrapper">
              <iframe
                src="' . $siteRegulars->location_map . '"
                width="400"
                height="300"
                style="border: 0"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
              ></iframe>
            </div>
          </div>
';

$reslocbreif .= '
'.$siteRegulars->breif.' 
';

$jVars['module:locationinfo'] = $reslocinfo1;

$jVars['module:locationbreif'] = $reslocbreif;



/*
/top helpline
*/

$helpline = '';
$contacts = explode(',', $siteRegulars->contact_info);
$helpline .= '<ul> ';
foreach ($contacts as $contact) {
    $helpline .= '<li> <i class="fa fa-phone" aria-hidden="true"></i> <a href="tel:' . $contact . '">' . $contact . '</a></li>';
}
$helpline .= '<li> &nbsp;Email: <a href="mailto:' . $siteRegulars->mail_address . '"> ' . $siteRegulars->mail_address . '</a></li>
    <li><div id="google_translate_element"></div><script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: \'en\',layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, \'google_translate_element\');
}
</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script></li>
        
          </ul>';
$jVars['module:helplinetop'] = $helpline;


/*
 * Contact Form Location Info
 */
$rescnt = $number = $fax_number = $mail = '';
$emlAddress = str_replace('@', '&#64;', $siteRegulars->email_address);
$emlAddress = str_replace('.', '&#46;', $emlAddress);

$emails = explode("<br>", $emlAddress);
foreach ($emails as $email) {
    if ($email != end($emails)) {
        $mail .= '<a href="mailto:' . $email . '">' . $email . '</a><br>';
    } else {
        $mail .= '<a href="mailto:' . $email . '">' . $email . '</a>';
    }
}

$contacts = explode("<br>", $siteRegulars->contact_info);
foreach ($contacts as $contact) {
    $numbers = explode("(", $contact);
    if ($contact != end($contacts)) {
        $number .= '<a href="tel:' . $numbers[0] . '" id="phone">' . $contact . '</a><br> ';
    } else {
        $number .= '<a href="tel:' . $numbers[0] . '" id="phone">' . $contact . '</a>';
    }
}
$faxs = explode(",", $siteRegulars->contact_info2);
foreach ($faxs as $fax) {
    if ($fax != end($faxs)) {
        $fax_number .= '<a href="tel:' . $fax . '" id="phone">' . $fax . '</a>, ';
    } else {
        $fax_number .= '<a href="tel:' . $fax . '" id="phone">' . $fax . '</a>';
    }
}
$rescnt .= '
        <ul class="contact-list-01">
            <li>
                <span class="icon-font"><i class="ion-android-pin"></i></span>
                <h6>Address</h6>
                    ' . $siteRegulars->fiscal_address . '
            </li>

            <li>
                <span class="icon-font"><i class="ion-android-mail"></i></span>
                <h6>Email</h6>
                    ' . $mail . '
            </li>

            <li>
                <span class="icon-font"><i class="ion-android-call"></i></span>
                <h6>Phone</h6>
                    ' . $number . '
            </li>

            <!--<li>
                <span class="icon-font"><i class="ion-android-print"></i></span>
                <h6>Fax</h6>
                    ' . $fax_number . '
            </li>-->
        </ul>
';

$jVars['module:contactinfo'] = $rescnt;

/*
 * Office location map/image
 */

$reslocmi = '';

if ($siteRegulars->location_type == '1') {
    $reslocmi .= $siteRegulars->location_map;
}
// End google map

if ($siteRegulars->location_type != '1') {
    if (file_exists(SITE_ROOT . 'images/preference/locimage/' . $siteRegulars->location_image)) {
        $reslocmi .= '<div class="img-hover">
      <img class="img-responsive" alt="location image" src="' . IMAGE_PATH . 'preference/locimage/' . $siteRegulars->location_image . '">
    </div>';
    }
}
// End image map

$jVars['module:contact-mapimage'] = $reslocmi;


/*
 * Google map
 */
$resgmap = '';
if ($siteRegulars->location_type == 1) {
    $maps = explode('<br/>', $siteRegulars->location_map);
    foreach ($maps as $map) {
        $resgmap .= '
            <div class="col-md-12">
                <iframe src=' . $map . ' width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
            </div>
        ';
    }
} else {
    $resgmap .= '<div class="nopadding nomargin" id="overlay">
        <img src="' . IMAGE_PATH . 'preference/locimage/' . $siteRegulars->location_image . '" alt="' . $siteRegulars->sitetitle . '" class="img-responsive">
    </div>';
}

$jVars['module:location-map'] = $resgmap;

?>