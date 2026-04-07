<?php
$footer = $number = $mail = $footer1 = '';
$emlAddress = str_replace('@', '&#64;', $siteRegulars->email_address);
$emlAddress = str_replace('.', '&#46;', $emlAddress);

$emails = explode("<br>", $emlAddress);
if (!empty($emails)) {
  $mail = '<a href="mailto:' . $emails[0] . '">' . $emails[0] . '</a>';
}
$copyrightText = str_replace('{year}', date('Y'), $siteRegulars->copyright);
$contacts = explode("<br>", $siteRegulars->contact_info);
$number_divs = '';
foreach ($contacts as $contact) {
  if (empty(trim($contact)))
    continue;
  $numbers = explode("(", $contact);
  $tel = trim($numbers[0]);
  if ($contact != end($contacts)) {
    $number .= '<a href="tel:' . $tel . '" id="phone">' . $contact . '</a><br> ';
  } else {
    $number .= '<a href="tel:' . $tel . '" id="phone">' . $contact . '</a>';
  }
  $number_divs .= '
            <div class="footer-line">
              <i class="fa-solid fa-phone "></i>
              <a href="tel:' . $tel . '">' . $contact . '</a>
            </div>';
}



$footer1 .= '

     <footer class="footer ">
      <div class="container-fluid position-relative">

        <div class="footer-flex flex-wrap">
          
          <div class=" footer_info footer-col">
            <h4 class="footer-title">' . $siteRegulars->sitename . '</h4>

            <div class="footer-line">
              <i class="fa-solid fa-location-dot "></i>
              <span class="fw-semibold">NEPAL (REGISTERED OFFICE)</span>
            </div>

            <p class="footer-text">
             ' . $siteRegulars->fiscal_address . '
            </p>
            <br>
            <div class="footer-line">
              <i class="fa-solid fa-envelope "></i>
              ' . $mail . '
            </div>
            ' . $number_divs . '
          </div>
          
          <div class="footer-col footer_quicklinks">
            <h4 class="footer-title">Quick Links</h4>
            <ul class="footer-list">
              ' . $jVars['module:footer-menu-1'] . '
            </ul>
          </div>
          
          <div class=" footer-col">
            <h4 class="footer-title">Destination</h4>
            <ul class="footer-list">
              ' . $jVars['module:footer-destination'] . '
            </ul>
          </div>

          
          <div class="footer-curve mt-3">
            ' . $siteRegulars->breif . '

            <div class="curve-logos d-flex flex-wrap gap-5">
              <a href="' . BASE_URL . '"><img src="' . BASE_URL . 'template/web/assets/images/affiliation1.png" alt=""></a>
              <a href="#"><img src="' . BASE_URL . 'template/web/assets/images/affiliation2.png" alt=""></a>
              <a href="#"><img src="' . BASE_URL . 'template/web/assets/images/affiliation3.png" alt=""></a>
              <a href="#"><img src="' . BASE_URL . 'template/web/assets/images/affilisation3.png" alt=""></a>

            </div>
          </div>


        </div>
      </div>
      
      <ul class="footer-bottom mt-4 ">

        
        <li class="footer-social">
          <h4 class="footer-subtitle stay-connected">Stay Connected</h4>
           ' . $jVars['module:socilaLinkbtm'] . '
        </li>

        
        <li class="footer_we_accept">
          <h4 class="footer-subtitle we-accept">We Accept</h4>
          <div class="footer-payments">
            <img src="https://upload.wikimedia.org/wikipedia/commons/5/5c/Visa_Inc._logo_%282021%E2%80%93present%29.svg" alt="">
            <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" alt="">
            <img src="https://upload.wikimedia.org/wikipedia/commons/3/30/American_Express_logo.svg" alt="">
            <img src="' . BASE_URL . 'template/web/assets/images/maestro-logo-copy.png" alt="">
          </div>
        </li>
        <li>' . $copyrightText . '</li>
      </ul>

    </footer>


';

$jVars['module:footer'] = $footer1;


?>