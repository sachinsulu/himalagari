<?php
require_once("includes/initialize.php");

if (isset($_POST['action']) and ($_POST['action'] == 'forEnquiry')):
    $usermail = User::field_by_id(1, 'email');
    $ccmail = User::field_by_id('1', 'optional_email');
    $sitename = Config::getField('sitename', true);

    foreach ($_POST as $key => $val) {
        $$key = $val;
    }

    $priceValue = isset($price) ? trim($price) : '';

    $enq = new Enquiry();
    $enq->type = Enquiry::TYPE_ENQUIRY;
    $enq->full_name = $full_name;
    $enq->email = $email;
    $enq->phone = $phone;
    $enq->country = isset($country) ? $country : null;
    $enq->city = isset($city) ? $city : null;
    $enq->trip_name = isset($trip_name) ? $trip_name : null;
    $enq->trip_date = isset($trip_date) && !empty($trip_date) ? getDateFormat($trip_date) : null;
    $enq->pax = isset($pax) ? (int)$pax : null;
    $enq->message = $message . (!empty($priceValue) ? "\n\nPrice: " . $priceValue : '');
    $enq->source_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
    $enq->ip_address = $_SERVER['REMOTE_ADDR'];
    $enq->status = 1;
    $enq->is_deleted = 0;
    $enq->save();

    $priceHtmlRow = !empty($priceValue) ? '<strong>Estimated Price</strong>: ' . $priceValue . '<br />' : '';

    $body = '<table width="100%" border="0" cellpadding="0" style="font:12px Arial, serif;color:#222;">
			  <tr>
				<td><p>Dear Sir,</p>
				</td>
			  </tr>
			  <tr>
				<td><p><span style="color:#0065B3; font-size:14px; font-weight:bold">Enquiry message</span><br />
				  The details provided are:</p>
				  	<p><strong>Fullname</strong> : ' . $full_name . '<br />		
                      <strong>E-mail Address</strong>: ' . $email . '<br />
                      <strong>Phone Number</strong>: ' . $phone . '<br />
                      <strong>Country</strong>: ' . $country . '<br />
                      <strong>City</strong>: ' . $city . '<br /><br />
                      
                      <strong>Trip Name</strong>: ' . $trip_name . '<br />
                      <strong>Trip Date</strong>: ' . $trip_date . '<br />
                      <strong>No. of Pax</strong>: ' . $pax . '<br />
                      ' . $priceHtmlRow . '<br />
                      
                      <strong>Message</strong>: ' . $message . '
				  	</p>
				</td>
			  </tr>
			  <tr>
				<td><p>&nbsp;</p>
				<p>Thank you,<br />
				' . $full_name . '
				</p></td>
			  </tr>
			</table>';

    $mail = get_mailer();
    $mail->AddReplyTo($email, $full_name);
    $mail->AddAddress($usermail, $sitename);

    if ($ccmail) {
        $recs = explode(';', $ccmail);
        foreach ($recs as $k => $v) {
            $mail->AddCC($v, $sitename);
        }
    }
    $mail->Subject = "Enquiry from " . $full_name . " for " . (isset($trip_name) ? $trip_name : 'a trip');
    $mail->MsgHTML($body);

    if (!$mail->Send()):
        error_log('enquiry_package_mail PHPMailer error: ' . $mail->ErrorInfo);
        echo json_encode(array("action" => "unsuccess", "message" => "Sorry! could not send your message."));
    else:
        echo json_encode(array("action" => "success", "message" => "Your message has been successfully received."));
    endif;
endif;
?>