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

// Dynamic packages for inquiry form
$packagesHTML = '<option value="" disabled selected>Select a Package</option>';
$packageRec = Package::get_packages();
if ($packageRec) {
    foreach ($packageRec as $pkgRow) {
        $prc = !empty($pkgRow->offer_price) ? $pkgRow->offer_price : (!empty($pkgRow->price) ? $pkgRow->price : '');
        $packagesHTML .= '<option value="' . $pkgRow->id . '" data-price="' . htmlspecialchars($prc) . '">' . htmlspecialchars($pkgRow->title) . '</option>';
    }
}

// Country list with dial codes
$countriesList = [
    'AF' => ['name' => 'Afghanistan',          'code' => '+93'],
    'AL' => ['name' => 'Albania',               'code' => '+355'],
    'DZ' => ['name' => 'Algeria',               'code' => '+213'],
    'AR' => ['name' => 'Argentina',             'code' => '+54'],
    'AU' => ['name' => 'Australia',             'code' => '+61'],
    'AT' => ['name' => 'Austria',               'code' => '+43'],
    'BD' => ['name' => 'Bangladesh',            'code' => '+880'],
    'BE' => ['name' => 'Belgium',               'code' => '+32'],
    'BR' => ['name' => 'Brazil',                'code' => '+55'],
    'CA' => ['name' => 'Canada',                'code' => '+1'],
    'CN' => ['name' => 'China',                 'code' => '+86'],
    'CO' => ['name' => 'Colombia',              'code' => '+57'],
    'HR' => ['name' => 'Croatia',               'code' => '+385'],
    'CZ' => ['name' => 'Czech Republic',        'code' => '+420'],
    'DK' => ['name' => 'Denmark',               'code' => '+45'],
    'EG' => ['name' => 'Egypt',                 'code' => '+20'],
    'FI' => ['name' => 'Finland',               'code' => '+358'],
    'FR' => ['name' => 'France',                'code' => '+33'],
    'DE' => ['name' => 'Germany',               'code' => '+49'],
    'GR' => ['name' => 'Greece',                'code' => '+30'],
    'HK' => ['name' => 'Hong Kong',             'code' => '+852'],
    'HU' => ['name' => 'Hungary',               'code' => '+36'],
    'IN' => ['name' => 'India',                 'code' => '+91'],
    'ID' => ['name' => 'Indonesia',             'code' => '+62'],
    'IE' => ['name' => 'Ireland',               'code' => '+353'],
    'IL' => ['name' => 'Israel',                'code' => '+972'],
    'IT' => ['name' => 'Italy',                 'code' => '+39'],
    'JP' => ['name' => 'Japan',                 'code' => '+81'],
    'JO' => ['name' => 'Jordan',                'code' => '+962'],
    'KZ' => ['name' => 'Kazakhstan',            'code' => '+7'],
    'KE' => ['name' => 'Kenya',                 'code' => '+254'],
    'KR' => ['name' => 'South Korea',           'code' => '+82'],
    'KW' => ['name' => 'Kuwait',                'code' => '+965'],
    'MY' => ['name' => 'Malaysia',              'code' => '+60'],
    'MX' => ['name' => 'Mexico',                'code' => '+52'],
    'NL' => ['name' => 'Netherlands',           'code' => '+31'],
    'NZ' => ['name' => 'New Zealand',           'code' => '+64'],
    'NG' => ['name' => 'Nigeria',               'code' => '+234'],
    'NO' => ['name' => 'Norway',                'code' => '+47'],
    'NP' => ['name' => 'Nepal',                 'code' => '+977'],
    'OM' => ['name' => 'Oman',                  'code' => '+968'],
    'PK' => ['name' => 'Pakistan',              'code' => '+92'],
    'PH' => ['name' => 'Philippines',           'code' => '+63'],
    'PL' => ['name' => 'Poland',                'code' => '+48'],
    'PT' => ['name' => 'Portugal',              'code' => '+351'],
    'QA' => ['name' => 'Qatar',                 'code' => '+974'],
    'RO' => ['name' => 'Romania',               'code' => '+40'],
    'RU' => ['name' => 'Russia',                'code' => '+7'],
    'SA' => ['name' => 'Saudi Arabia',          'code' => '+966'],
    'SG' => ['name' => 'Singapore',             'code' => '+65'],
    'ZA' => ['name' => 'South Africa',          'code' => '+27'],
    'ES' => ['name' => 'Spain',                 'code' => '+34'],
    'LK' => ['name' => 'Sri Lanka',             'code' => '+94'],
    'SE' => ['name' => 'Sweden',                'code' => '+46'],
    'CH' => ['name' => 'Switzerland',           'code' => '+41'],
    'TH' => ['name' => 'Thailand',              'code' => '+66'],
    'TR' => ['name' => 'Turkey',                'code' => '+90'],
    'AE' => ['name' => 'UAE',                   'code' => '+971'],
    'GB' => ['name' => 'United Kingdom',        'code' => '+44'],
    'US' => ['name' => 'United States',         'code' => '+1'],
    'VN' => ['name' => 'Vietnam',               'code' => '+84'],
];

$countriesHTML = '<option value="" disabled selected>Select Country</option>';
foreach ($countriesList as $iso => $info) {
    $countriesHTML .= '<option value="' . $iso . '" data-code="' . $info['code'] . '">' . $info['name'] . '</option>';
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
          <form class="row g-3 align-items-end" id="navSearchForm" action="' . BASE_URL . 'searchlist" method="post">
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
                    <label>Package <span>*</span></label>
                    <select id="inq_package" name="package" required>
                      ' . $packagesHTML . '
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
                    <input type="number" id="inq_pax" name="pax" min="1" required />
                  </div>

                  <div class="form-group">
                    <label>Price <span class="required">*</span></label>
                    <input type="text" id="inq_price" name="price" required />
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
                    <select id="planCountry" name="country" required>
                      ' . $countriesHTML . '
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
              <script>
                (function() {
                  var sel = document.getElementById("planCountry");
                  var codeInput = document.getElementById("planCountryCode");
                  if (sel && codeInput) {
                    sel.addEventListener("change", function() {
                      var opt = this.options[this.selectedIndex];
                      codeInput.value = opt.getAttribute("data-code") || "";
                    });
                  }

                  var pkgSel = document.getElementById("inq_package");
                  var priceInput = document.getElementById("inq_price");
                  var paxInput = document.getElementById("inq_pax");

                  function updatePrice() {
                    var opt = pkgSel.options[pkgSel.selectedIndex];
                    if (!opt) return;
                    var priceAttr = opt.getAttribute("data-price");
                    
                    if (priceAttr) {
                      var priceVal = parseFloat(priceAttr);
                      if (!isNaN(priceVal)) {
                        var pax = parseInt(paxInput.value) || 1;
                        priceInput.value = priceVal * pax;
                      } else {
                        priceInput.value = priceAttr;
                      }
                    } else {
                      priceInput.value = "";
                    }
                  }

                  if (pkgSel && priceInput && paxInput) {
                    pkgSel.addEventListener("change", function() {
                      if (!paxInput.value) paxInput.value = 1;
                      updatePrice();
                    });
                    paxInput.addEventListener("input", updatePrice);
                  }
                })();
              </script>
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