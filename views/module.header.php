<?php
/*
 * header module
 */

$header_components = '';
$header1 = '';
$home_header = '';

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
          <form class="row g-3 align-items-center" id="navSearchForm">
            <div class="col-md-3">
              <label class="form-label">Destination</label>
              <select id="destination" class="form-control">
                <option value="" disabled selected>Where to?</option>
                <option value="Nepal">Nepal</option>
                <option value="Bhutan">Bhutan</option>
                <option value="Tibet">Tibet</option>
              </select>
            </div>

            <div class="col-md-3">
              <label class="form-label">Activity</label>
              <select id="activity" class="form-control">
                <option value="" disabled selected>Select activity</option>
                <option value="Adventure">Adventure</option>
                <option value="Relaxation">Relaxation</option>
                <option value="Culture">Culture</option>
              </select>
            </div>

            <div class="col-md-3">
              <label class="form-label">Duration</label>
              <select id="duration" class="form-control">
                <option value="" disabled selected>Select duration</option>
                <option value="4-5 days">4-5 days</option>
                <option value="10-15 days">10-15 days</option>
                <option value="1-3 months">1-3 months</option>
              </select>
            </div>

            <div class="col-md-3 d-grid">
              <button class="explore_btn" id="inquiry-btn">Search</button>
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