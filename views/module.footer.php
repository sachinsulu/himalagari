<?php
$footer = $number = $mail = '';
$emlAddress = str_replace('@', '&#64;', $siteRegulars->email_address);
$emlAddress = str_replace('.', '&#46;', $emlAddress);

$emails = explode("<br>", $emlAddress);
foreach($emails as $email){
    if ($email != end($emails)) {
        $mail .= '<a href="mailto:' . $email . '" id="email_footer">' . $email . '</a><br>';
    } else {
        $mail .= '<a href="mailto:' . $email . '" id="email_footer">' . $email . '</a>';
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
$footer .= '
    <footer class="revealed footer-revealed">
        <div class="container">
            <div class="row">
                <!--<div class="col-md-4 col-sm-12 col-xs-12">
                    <h3>Contact With Us</h3>
                    <p> ' . $siteRegulars->fiscal_address . '</p>
                    <p><i class="fas fa-phone-alt"></i>' . $number . '
                        <a href="mailto:' . $emlAddress . '" id="email_footer">' . $emlAddress . '</a>

                    <h3>Follow us</h3>
                    <div class="footer-socials mt-20">
                        ' . $jVars['module:socilaLinkbtm'] . '
                    </div>
                </div>-->

                <div class="col-md-2 col-sm-12 col-xs-1">
                    <h3>Destinations</h3>
                    ' . $jVars['module:footer-menu-1'] . '
                </div>
                <div class="col-md-2 col-sm-12 col-xs-1">
                    <h3>Activities</h3>
                    ' . $jVars['module:footer-menu-2'] . '
                </div>
                <div class="col-md-4 col-sm-12 col-xs-1">
                    <h3>Others</h3>
                    ' . $jVars['module:footer-menu-3'] . '
                </div>

                <div class="col-md-4 col-sm-12 col-xs-1">
                    <h3>Affiliations</h3>
                    <ul class="affilation-footer">
                        <li><a href="https://www.taan.org.np/" target="_blank"><img src="'.IMAGE_PATH.'/taan.png" class="width-50" alt="TAAN"></a></li>
                        <li><a href="https://www.facebook.com/nattapage/" target="_blank"><img src="'.IMAGE_PATH.'/natta.png" class="width-50" alt="NATTA"></a></li>
                        <li><a href="https://www.nepal.gov.np/" target="_blank"><img src="'.IMAGE_PATH.'/tourism.jpg" class="width-50" alt="Nepal Government"></a></li>
                        <li><a href="https://www.welcomenepal.com/" target="_blank"><img src="'.IMAGE_PATH.'/ntb.png" class="width-50" alt="NTB"></a></li>
                        <li><a href="https://www.nepalmountaineering.org/" target="_blank"><img src="'.IMAGE_PATH.'/nma.png" class="width-50" alt="NMA"></a></li>
                        <li><a href="https://keepnepal.org/" target="_blank"><img src="'.IMAGE_PATH.'/keep.jpg" class="width-43" alt="Keep Nepal"></a></li>
                    </ul>
                     <p>' . $siteRegulars->fiscal_address . '</p>
                    <p class="footer-aff"><i class="fas fa-phone"></i> ' . $number . '</p>
                    <p class="footer-aff">
                        <i class="fas fa-envelope"></i> '.$mail.'</p>
                    <div class="footer-socials mt-20">
                        ' . $jVars['module:socilaLinkbtm'] . '
                    </div>
                    
                    <!--<form class="footer-newsletter mt-20">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Email address">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button"><i class="far fa-envelope"></i></button>
                            </div>
                        </div>
                    </form>-->
                    <h3>We Accept</h3>
                    <div class="footer-socials mt-20">
                        <style>.footer-socials img{width: 160px;}</style>
                        <img src="' . BASE_URL . 'template/web/img/payment.jpg" alt="Payment">
                    </div>
                </div>
                <div class="col-md-8 col-sm-12 partnr1">
                    <h3>Partner Companies</h3>
                    <ul>
                        <li><a href="https://www.facebook.com/firstflight20" target="_blank" title="First Flight Travel Pvt.Ltd"><img src="' . BASE_URL . 'template/web/img/partner1.png" alt="Payment"></a></li>
                        <li><a href="https://www.facebook.com/easyexportandimportservice" target="_blank" title="Easy Export & Import Service"><img src="' . BASE_URL . 'template/web/img/partner2.png" alt="Payment"></a></li>
                        <li><a href="https://www.facebook.com/flyingskyinternational" target="_blank" title="Flying Sky International Logistics"><img src="' . BASE_URL . 'template/web/img/partner3.png" alt="Payment"></a></li>
                    </ul>
                </div>
            </div><!-- End row -->

            <div class="row">
            <div class="footer1">
                <div class="col-md-10">
                    <div id="social_footer">
                        <p class="footer-copy-right">' . $jVars['site:copyright'] . '</p>
                    </div>
                </div>
                <div class="col-md-2">
                    <div id="social_footer">
                        ' . $jVars['module:socilaLinkbtmFooter'] . '
                    </div>
                </div>
                </div>
            </div><!-- End row -->
        </div><!-- End container -->
    </footer>
';

$jVars['module:footer'] = $footer;


?>