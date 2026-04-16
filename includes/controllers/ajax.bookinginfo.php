<?php 
	// Load the header files first
	header("Expires: 0"); 
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
	header("cache-control: no-store, no-cache, must-revalidate"); 
	header("Pragma: no-cache");

	// Load necessary files then...
	require_once('../initialize.php');

	$usermail = User::field_by_id('1', 'email');
	$sitename = Config::getField('sitename',true);
	$bccmail = User::field_by_id('1','optional_email');
	
	$action = $_REQUEST['action'];
	
	switch($action) 
	{						
		case "request_inquiry":
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
			foreach($_POST as $key=>$val) { $$key=$val; }

			// For tbl_bookinginfo
			$bokRec = new Bookinginfo();

//			$n = explode(':', base64_decode($date_rate));
			$bokRec->pkg_id 		= $pkg_id;
            $bokRec->fixed_date_id = (!empty($fixed_date_id)) ? $fixed_date_id : '';
			$bokRec->trip_date 		= $date;
			$bokRec->trip_currency  = 'USD';
//			$bokRec->date_rate 		= $n[1];
			$bokRec->trip_pax		= $pax + 1;
//			$bokRec->trip_flight 	= $trip_flight;
//			$bokRec->accesskey		= $trans_key;
//			$bokRec->person_title 	= $person_title;
			$bokRec->person_fname 	= $full_name;
//			$bokRec->person_mname 	= $person_mname;
//			$bokRec->person_lname	= $person_lname;

			$bokRec->person_phone 	= $phone;
			$bokRec->person_email	= $email;
			$bokRec->person_address	= $address1;
			$bokRec->person_country = $country;
			$bokRec->person_country_code = Countries::find_by_name($country);
			$bokRec->person_city 	= isset($province) ? $province : '';
			$bokRec->person_postal 	= isset($state) ? $state : '';
//			$bokRec->person_ctype 	= implode(' / ', $person_ctype); // (!empty($person_ctype[0])?$person_ctype[0]:'').' '.(!empty($person_ctype[1])?$person_ctype[1]:'');
            $bokRec->person_hear    = (!empty($address2)) ? $address2 : '';
			$bokRec->person_comment = $message;

			$bokRec->ip_address 	= $_SERVER['REMOTE_ADDR'];
			$bokRec->pay_type 		= 'Inquiry';
			$bokRec->sortorder 		= Bookinginfo::find_maximum();;
			$bokRec->added_date 	= registered();


            $db->begin();
            if ($bokRec->save()) {
                
                $enq = new Enquiry();
                $enq->type = Enquiry::TYPE_BOOKING;
                $enq->full_name = $full_name;
                $enq->email = $email;
                $enq->phone = $phone;
                $enq->country = $country;
                $enq->city = isset($province) ? $province : '';
                $enq->trip_name = Package::field_by_id($pkg_id, 'title');
                $enq->trip_date = getDateFormat($date);
                $enq->pax = (int)$pax + 1;
                $enq->message = $message;
                $enq->source_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
                $enq->ip_address = $_SERVER['REMOTE_ADDR'];
                $enq->status = 1;
                $enq->is_deleted = 0;
                $enq->save();

                include(SITE_ROOT.'book_mail.php');
                $db->commit();
                if (!empty($additional_name)) {
                    $booking_id = $db->insert_id();
                    $length = sizeof($additional_name);
                    for ($i = 0; $i < $length; $i++) {
                        $csql = "INSERT INTO tbl_bookinginfo_additional SET 
                                  booking_id='" . $booking_id . "', 
                                  name='" . $additional_name[$i] . "', 
                                  phone='" . $additional_phone[$i] . "', 
                                  address='" . $additional_address[$i] . "' ";
                        $db->query($csql);
                    }
                }

                $message = 'Success ! Your information has been sent. You will soon be notified by admin about booking through email.';
                echo json_encode(array("action" => "success", "message" => $message));
            }
			else {
				$db->rollback();
				$message='Error ! Could not book the trip !';
				echo json_encode(array("action"=>"error", "message"=>$message));
			}	
			break;

		case "delete":
			$id = $_REQUEST['id'];
			$record = Bookinginfo::find_by_id($id);			
			$db->query("DELETE FROM tbl_bookinginfo WHERE id='{$id}'");			
			reOrder("tbl_bookinginfo", "sortorder");		

			$records = Bookinginfo::find_all();
			$fixedOrder = "sortOrder";
			foreach($records as $order):
				$fixedOrder.= "|".$order->sortorder;
			endforeach;			

			echo "Delete Booking Record [".$record->accesskey."]".$GLOBALS['basic']['deletedSuccess']."||1>>".$fixedOrder;
			log_action("Delete Booking Record [".$record->accesskey."]".$GLOBALS['basic']['deletedSuccess']."");	

		break;

	}
?>