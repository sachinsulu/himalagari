<?php
require_once("includes/initialize.php");

if (isset($_POST['action']) and ($_POST['action'] == 'forcoment' || $_POST['action'] == 'plan_trip')):
    // reCAPTCHA validation
    if (isset($_POST['g-recaptcha-response'])) {
        $secret = '6LdNE7osAAAAAGfi-AdaaLGAnpNqwoRtgqSN79-9';
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
        $responseData = json_decode($verifyResponse);
        if (!$responseData->success) {
            echo json_encode(array("action" => "unsuccess", "message" => "reCAPTCHA verification failed. Please try again."));
            exit;
        }
    }
    $usermail = User::field_by_id(1, 'email');
    $ccmail = User::field_by_id('1', 'optional_email');
    $sitename = Config::getField('sitename', true);

    foreach ($_POST as $key => $val) {
        $$key = $val;
    }

    $priceValue = isset($price) ? trim($price) : '';

    $enq = new Enquiry();
    
    if ($_POST['action'] == 'plan_trip') {
        $enq->type = Enquiry::TYPE_PLAN;
        $enq->full_name = $name;
        $enq->email = $email;
        $enq->phone = $country_code . ' ' . $phone;
        $enq->country = $country;
        
        $pkgTitle = "N/A";
        if (!empty($package)) {
            $pkgRec = Package::find_by_id($package);
            if ($pkgRec) $pkgTitle = $pkgRec->title;
        }
        $enq->trip_name = $pkgTitle;
        $enq->trip_date = $trip_date;
        $enq->pax = $pax;
        $enq->message = $message . (!empty($priceValue) ? "\n\nPrice: " . $priceValue : '');
    } else {
        $enq->type = Enquiry::TYPE_CONTACT;
        $enq->full_name = $name;
        $enq->email = $email;
        $enq->phone = (!empty($country_code) ? $country_code . ' ' : '') . $emobile;
        $enq->country = isset($country) ? $country : null;
        $enq->message = "Address: " . (isset($address) ? $address : 'N/A') . "\n\n" . $message;
    }

    $enq->source_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
    $enq->ip_address = $_SERVER['REMOTE_ADDR'];
    $enq->status = 1;
    $enq->is_deleted = 0;
    $enq->save();

    if ($_POST['action'] == 'plan_trip') {
      $priceHtmlRow = !empty($priceValue) ? '<strong>Estimated Price</strong> : ' . $priceValue . '<br />' : '';
        $body = '<table width="100%" border="0" cellpadding="0" style="font:12px Arial, serif;color:#222;">
                  <tr>
                    <td><p>Dear Sir,</p></td>
                  </tr>
                  <tr>
                    <td><p><span style="color:#0065B3; font-size:14px; font-weight:bold">Plan Your Trip Details</span><br />
                      The details provided are:</p>
                        <p>
                            <strong>Full Name</strong> : ' . $name . '<br />	
                            <strong>Email Address</strong> : ' . $email . '<br />	
                            <strong>Country</strong> : ' . $country . '<br />	
                            <strong>Contact No</strong> : ' . $country_code . ' ' . $phone . '<br />	
                            <strong>Package</strong> : ' . $pkgTitle . '<br />	
                            <strong>Travel Date</strong> : ' . $trip_date . '<br />	
                            <strong>No. of Pax</strong> : ' . $pax . '<br />	
                            ' . $priceHtmlRow . '
                            <strong>Message / Details</strong>: <br />' . nl2br($message) . '<br />
                        </p>
                    </td>
                  </tr>
                  <tr>
                    <td><p>&nbsp;</p>
                    <p>Thank you,<br />
                    ' . $name . '
                    </p></td>
                  </tr>
                </table>';
        $subject = "Trip Plan Inquiry from " . $name;
    } else {
        $body = '<table width="100%" border="0" cellpadding="0" style="font:12px Arial, serif;color:#222;">
                  <tr>
                    <td><p>Dear Sir,</p></td>
                  </tr>
                  <tr>
                    <td><p><span style="color:#0065B3; font-size:14px; font-weight:bold">Enquiry message</span><br />
                      The details provided are:</p>
                        <p>
                            <strong>Full Name</strong> : ' . $name . '<br />	
                            <strong>Email Address</strong> : ' . $email . '<br />	
                            <strong>Contact No</strong> : ' . (!empty($country_code) ? $country_code . ' ' : '') . $emobile . '<br />	
                            <strong>Address</strong> : ' . (isset($address) ? $address : 'N/A') . '<br />	
                            <strong>Country</strong> : ' . (isset($country) ? $country : 'N/A') . '<br />	
                            <strong>Message</strong>: <br />' . nl2br($message) . '<br />
                        </p>
                    </td>
                  </tr>
                  <tr>
                    <td><p>&nbsp;</p>
                    <p>Thank you,<br />
                    ' . $name . '
                    </p></td>
                  </tr>
                </table>';
        $subject = "Enquiry from " . $name;
    }

    $mail = get_mailer();
    $mail->AddReplyTo($email, $name);
    $mail->AddAddress($usermail, $sitename);

    if ($ccmail) {
        $recs = explode(';', $ccmail);
        foreach ($recs as $k => $v) {
            $mail->AddCC($v, $sitename);
        }
    }
    $mail->Subject = $subject;
    $mail->MsgHTML($body);

    if (!$mail->Send()):
        error_log('enquiry_mail PHPMailer error: ' . $mail->ErrorInfo);
        echo json_encode(array("action" => "unsuccess", "message" => "Sorry! could not send your message."));
    else:
        echo json_encode(array("action" => "success", "message" => "Your message has been successfully received."));
    endif;
endif;
?>