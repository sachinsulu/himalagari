<?php
/*
 * header module
 */

$header_components = '';
$header1 = '';
$home_header = '';

$destinationsHTML = '<option value="" disabled selected>Where to?</option>';
$destinationRec = Destination::get_destination();
if ($destinationRec) {
    foreach ($destinationRec as $dstRow) {
        $destinationsHTML .= '<option value="' . $dstRow->id . '">' . $dstRow->title . '</option>';
    }
}

$activitiesHTML = '<option value="" disabled selected>Select activity</option>';
$ActivitiesRec = Activities::get_activities();
if ($ActivitiesRec) {
    foreach ($ActivitiesRec as $actRow) {
        $activitiesHTML .= '<option value="' . $actRow->id . '">' . $actRow->title . '</option>';
    }
}

$durationHTML = '<option value="" disabled selected>Select duration</option>';
$durationRec = array('5' => '1-5 Days', '10' => '6-10 Days', '15' => '11-15 Days', 'morethan15' => 'More than 15 Days');
foreach ($durationRec as $k => $v) {
    $durationHTML .= '<option value="' . $k . '">' . $v . '</option>';
}

$header_components = '
      <div class="offcanvas offcanvas-end" id="menuCanvas">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title">Menu</h5>
          <button
            class="btn-close"
            title="menu"
            data-bs-dismiss="offcanvas"
          ></button>
        </div>
        <div class="offcanvas-body sidebar">
          <jcms:module:offcanvas-menu/>
        </div>
      </div>


      <div class="bottom-search bottomSearch" id="bottomSearch">
        <div class="container">
          <!-- FORM -->
          <form class="row g-3 align-items-center" id="navSearchForm" action="' . BASE_URL . 'searchlist" method="post">
            <div class="col-md-3">
              <label class="form-label">Destination</label>
              <select id="destination" name="qdestination[]" class="form-control">
                ' . $destinationsHTML . '
              </select>
            </div>

            <div class="col-md-3">
              <label class="form-label">Activity</label>
              <select id="activity" name="qactivities[]" class="form-control">
                ' . $activitiesHTML . '
              </select>
            </div>

            <div class="col-md-3">
              <label class="form-label">Duration</label>
              <select id="duration" name="days" class="form-control">
                ' . $durationHTML . '
              </select>
            </div>

            <div class="col-md-3 d-grid">
              <button type="submit" class="explore_btn" id="inquiry-btn">Search</button>
            </div>
          </form>
        </div>
      </div>
      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas_inquiry" aria-labelledby="offcanvas_inquiryLabel">
        <div class="offcanvas-header">
          <!-- <h5 class="offcanvas-title" id="offcanvas_inquiryLabel">Offcanvas</h5> -->
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="inquiry_text">
          <div class="offcanvas-body">
            <div class="inquiry_title orange-text">
              <span>Plan</span> Your Trip
              <form>
                <!-- Packages & Date -->
                <div class="form-row">
                  <div class="form-group">
                    <label>Packages <span>*</span></label>
                    <select id="country" name="country" required>
                      <option value="">Select a country</option>
                      <option value="NP" data-code="+977">Nepal</option>
                      <option value="IN" data-code="+91">India</option>
                      <option value="US" data-code="+1">United States</option>
                      <option value="AU" data-code="+61">Australia</option>
                      <option value="GB" data-code="+44">United Kingdom</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Travel Date <span>*</span></label>
                    <input type="date" class="travel-date" required />
                  </div>
                </div>

                <!-- Pax & Price -->
                <div class="form-row">
                  <div class="form-group">
                    <label>No. of Pax <span class="required">*</span></label>
                    <input type="text" required />
                  </div>

                  <div class="form-group">
                    <label>Price <span class="required">*</span></label>
                    <input type="text" required />
                  </div>
                </div>

                <!-- Name & Email -->
                <div class="form-row">
                  <div class="form-group">
                    <label>Full Name <span class="required">*</span></label>
                    <input type="text" required />
                  </div>

                  <div class="form-group">
                    <label>Email Address <span class="required">*</span></label>
                    <input type="email" required />
                  </div>
                </div>

                <!-- Country, Code & Phone -->
                <div class="form-row">
                  <div class="form-group">
                    <label>Country <span class="required">*</span></label>
                    <select id="planCountry" required>
                      <option value="">Select Country</option>
                      <option value="NP" data-code="+977">Nepal</option>
                      <option value="IN" data-code="+91">India</option>
                    </select>
                  </div>

                  <div class="form-group" style="max-width: 90px;">
                    <label>Code</label>
                    <input
                      type="text"
                      id="planCountryCode"
                      readonly
                    />
                  </div>

                  <div class="form-group phone-box">
                    <label>Contact No. <span class="required">*</span></label>
                    <input type="tel" required />
                  </div>
                </div>

                <!-- Message -->
                <div class="form-group">
                  <label>Tour Details <span class="required">*</span></label>
                  <textarea required></textarea>
                </div>

                <button type="submit">Submit</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      ';


$header1 = '


      <nav class="navbar navbar-dark">
        <div class="container-fluid">
          <!-- LOGO (ALWAYS) -->
          ' . $jVars['site:logo'] . '

          <!-- NAV LINKS -->

        <jcms:module:menu/>

          <!-- RIGHT ICONS (ALWAYS) -->
          <div class="d-flex align-items-center gap-3">
            <!-- SEARCH ICON -->
            <button
              title="search"
              class="icon-btn searchToggle"
              id="searchToggle"
            >
              <i class="fa-solid fa-magnifying-glass"></i>
            </button>

            <button
              id="inquiry-btn"
              class="explore_btn"
              data-bs-toggle="offcanvas"
              data-bs-target="#offcanvas_inquiry"
              class="d-none d-sm-block"
            >
              <p>Plan Your Trip</p>
            </button>

            <button
              title="menu"
              class="navbar-toggler"
              type="button"
              data-bs-toggle="offcanvas"
              data-bs-target="#menuCanvas"
            >
              <span class="navbar-toggler-icon"></span>
            </button>
          </div>
        </div>
      </nav>

      
  '. $header_components .'
';


  $home_header = '
  
        <nav class="navbar navbar-dark original_nav">
        <div class="container-fluid">
          <!-- LOGO (ALWAYS) -->
           ' . $jVars['site:logo'] . '

          <!-- NAV LINKS -->
          <jcms:module:menu_home/>

          <!-- RIGHT ICONS (ALWAYS) -->
          <div class="d-flex align-items-center">
            <!-- SEARCH ICON -->
            <button title="search" class="icon-btn searchToggle">
              <i class="fa-solid fa-magnifying-glass"></i>
            </button>

            <button class="explore_btn inquiry-btn actual_navbar" data-bs-toggle="offcanvas"
              data-bs-target="#offcanvas_inquiry">
              <p>Plan Your Trip</p>
            </button>

            <button title="menu" class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
              data-bs-target="#menuCanvas">
              <span class="navbar-toggler-icon"></span>
            </button>
          </div>
        </div>
      </nav>

  
  
  ';




$jVars['module:header'] = $header1;
$jVars['module:home_header'] = $home_header;
$jVars['module:header_components'] = $header_components;

?>