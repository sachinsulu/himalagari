<?php
$moduleTablename  = "tbl_enquiries";
$moduleId 		  = 50;				

if(isset($_GET['page']) && $_GET['page'] == "enquiry" && isset($_GET['mode']) && $_GET['mode']=="list"):     
?>
<h3>List Enquiries</h3>
<div class="my-msg"></div>
<div class="example-box">
    <div class="example-code">    
    <table cellpadding="0" cellspacing="0" border="0" class="table" id="example">
        <thead>
            <tr>
               <th style="display:none;"></th>
               <th class="text-center"><input class="check-all" type="checkbox"/></th>
               <th>Type</th>
               <th>Full Name</th> 
               <th>Contact Info</th>                   
               <th>Added Date</th> 
               <th class="text-center">Status</th>
               <th class="text-center"><?php echo $GLOBALS['basic']['action'];?></th>
            </tr>
        </thead> 
            
        <tbody>
            <?php $records = Enquiry::find_all_active(); 
            foreach($records as $key=>$record): ?>    
            <tr id="<?php echo $record->id;?>">
                <td style="display:none;"><?php echo $key+1;?></td>                
                <td class="text-center"><input type="checkbox" class="bulkCheckbox" bulkId="<?php echo $record->id;?>"/></td>                
                <td><?php echo set_na($record->type);?></td>                             
                <td><?php echo set_na($record->full_name);?></td>
                <td>Email: <?php echo set_na($record->email);?><br />Phone: <?php echo set_na($record->phone);?></td>
                <td><?php echo $record->added_date;?></td>
                <td class="text-center">
                    <?php
                    $statusImage = ($record->status == 1) ? "bg-green" : "bg-red";
                    $statusText = ($record->status == 1) ? "Mark as Unseen" : "Mark as Seen";
                    ?>
                    <a href="javascript:void(0);"
                       class="btn small <?php echo $statusImage; ?> tooltip-button statusToggler"
                       data-placement="top" title="<?php echo $statusText; ?>"
                       status="<?php echo $record->status; ?>" id="imgHolder_<?php echo $record->id; ?>"
                       moduleId="<?php echo $record->id; ?>">
                        <i class="glyph-icon <?php echo ($record->status == 1) ? "icon-check" : "icon-eye-slash";?>"></i>
                    </a>
                </td>
                <td class="text-center">                                            
                    <a href="<?php echo ADMIN_URL;?>enquiry/view/<?php echo $record->id;?>" class="btn small bg-blue-alt tooltip-button" data-placement="top" title="View">
                        <i class="glyph-icon icon-eye"></i>
                    </a>
                    <a href="javascript:void(0);" class="btn small bg-red tooltip-button" data-placement="top" title="Remove" onclick="recordDelete(<?php echo $record->id;?>);">
                        <i class="glyph-icon icon-remove"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
    <div class="pad0L col-md-2">
        <select name="dropdown" id="groupTaskField" class="custom-select">
            <option value="0"><?php echo $GLOBALS['basic']['choseAction'];?></option>
            <option value="delete"><?php echo $GLOBALS['basic']['delete'];?></option>
            <option value="toggleStatus"><?php echo $GLOBALS['basic']['toggleStatus'];?></option>
        </select>
    </div>
    <a class="btn medium primary-bg" href="javascript:void(0);" id="applySelected_btn">
        <span class="glyph-icon icon-separator float-right">
          <i class="glyph-icon icon-cog"></i>
        </span>
        <span class="button-content"> Click </span>
    </a>
</div>

<?php elseif(isset($_GET['mode']) && $_GET['mode'] == "view"): 
if(isset($_GET['id']) && !empty($_GET['id'])):
    $enquiryId   = addslashes($_REQUEST['id']);
    $enquiryRow  = Enquiry::find_by_id($enquiryId);
    if(!$enquiryRow) {
        redirect_to(ADMIN_URL.'enquiry/list');
    }
    // Auto mark as seen
    if($enquiryRow->status == 0) {
        $enquiryRow->status = 1;
        $enquiryRow->save();
    }
endif;  
?>

<h3>
    View Enquiry
    <a class="loadingbar-demo btn medium bg-blue-alt float-right" href="<?php echo ADMIN_URL;?>enquiry/list">
        <span class="glyph-icon icon-separator">
            <i class="glyph-icon icon-arrow-circle-left"></i>
        </span>
        <span class="button-content"> Back </span>
    </a>
</h3>
<div class="my-msg"></div>
<div class="example-box">
    <div class="example-code">
        <div class="col-sm-6">
            <h3>Personal Information</h3>
            <ul>
                <li><strong>Fullname : </strong><?php echo set_na($enquiryRow->full_name);?></li>
                <li><strong>Contact No. : </strong><?php echo set_na($enquiryRow->phone);?></li>
                <li><strong>Email Address : </strong><?php echo set_na($enquiryRow->email);?></li>
                <li><strong>City : </strong><?php echo set_na($enquiryRow->city);?></li>
                <li><strong>Country : </strong><?php echo set_na($enquiryRow->country);?></li>
            </ul>
        </div>
        <div class="col-sm-6">
            <h3>Enquiry Information</h3>
            <ul>
                <li><strong>Type : </strong><?php echo set_na($enquiryRow->type);?></li>
                <li><strong>Source URL : </strong><?php echo set_na($enquiryRow->source_url);?></li>
                <li><strong>Trip Name : </strong><?php echo set_na($enquiryRow->trip_name);?></li>
                <li><strong>Trip Date : </strong><?php echo set_na($enquiryRow->trip_date);?></li>
                <li><strong>No. of Pax : </strong><?php echo set_na($enquiryRow->pax);?></li>
                <li><strong>Inquiry Date : </strong><?php echo set_na($enquiryRow->added_date);?></li>
                <li><strong>Inquiry IP : </strong><?php echo set_na($enquiryRow->ip_address);?></li>
            </ul>
        </div>
        <div class="clear"></div>
        <div class="col-sm-12">
            <h3>Message</h3>
            <ul>
                <li><p><?php echo set_na($enquiryRow->message);?></p></li>
            </ul>
        </div>

    </div>
</div>  
<?php endif; ?>
