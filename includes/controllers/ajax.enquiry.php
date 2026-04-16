<?php 
	// Load the header files first
	header("Expires: 0"); 
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
	header("cache-control: no-store, no-cache, must-revalidate"); 
	header("Pragma: no-cache");

	// Load necessary files then...
	require_once('../initialize.php');

	// Authentication Check
	$accsid    = $session->get('u_id');
	$accsagent = $session->get('acc_agent');
	$accscode  = $session->get('accesskey');
	$actionpaeg = access_permission($accsid,$accsagent,$accscode);
	if($actionpaeg === 'false'){
		echo json_encode(array("action"=>"error", "message"=>"Unauthorized."));
		exit;
	}

	$action = $_REQUEST['action'];
	
	switch($action) 
	{						
		case "delete":
			$id = $_REQUEST['id'];
			$record = Enquiry::find_by_id($id);	
			if($record) {
				$record->is_deleted = 1;
				if($record->save()){
					echo json_encode(array("action"=>"success", "message"=>"Enquiry has been deleted successfully."));
					log_action("Deleted Enquiry [".$record->id."] from IP ".$record->ip_address."");	
				} else {
					echo json_encode(array("action"=>"error", "message"=>"Could not delete the enquiry."));
				}
			} else {
				echo json_encode(array("action"=>"error", "message"=>"Record not found."));
			}
		break;
		
		case "toggleStatus":
			$id = $_REQUEST['id'];
			$record = Enquiry::find_by_id($id);
			if($record) {
				$status = (isset($_REQUEST['status'])) ? $_REQUEST['status'] : ($record->status == 1 ? 0 : 1);
				$record->status = $status;
				if($record->save()){
					echo json_encode(array("action"=>"success", "message"=>"Status updated successfully."));
				} else {
					echo json_encode(array("action"=>"error", "message"=>"Could not update status."));
				}
			} else {
				echo json_encode(array("action"=>"error", "message"=>"Record not found."));
			}
		break;

		case "bulkToggleStatus":
			$id = $_REQUEST['idArray'];
			$allid = explode("|", $id);
			$return = "0";
			for($i=1; $i<count($allid); $i++){
				$record = Enquiry::find_by_id($allid[$i]);
				$record->status = ($record->status == 1) ? 0 : 1 ;
				$record->save();
			}
			echo "";
		break;

		case "bulkDelete":
			$id = $_REQUEST['idArray'];
			$allid = explode("|", $id);
			$return = "0";
			$db->begin();
			for($i=1; $i<count($allid); $i++){
				$record = Enquiry::find_by_id($allid[$i]);
				if($record) {
					$record->is_deleted = 1;
					$res = $record->save();
					$return = 1;
				}
			}
			if($return == 1) {
				$db->commit();
				echo json_encode(array("action"=>"success", "message"=>"Selected enquiries have been deleted."));
			} else {
				$db->rollback();
				echo json_encode(array("action"=>"error", "message"=>"No records were deleted."));
			}
		break;
	}
?>
