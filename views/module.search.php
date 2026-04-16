<?php
$destination = $activity = $days = '';
if (isset($_REQUEST)) {
    foreach ($_REQUEST as $key => $val) {
        $$key = $val;
    }
}

$resisearch = $respkglist = $bread = $bread_title = $bread_text = $bread_text_extra = $navigation = '';
if (defined('SEARCH_PAGE')) {

    /* search page search form start*/
    /* destination filter start*/
    $destination_filter = '';
    $destinationRec = Destination::get_destination();
    foreach ($destinationRec as $destinationRow) {
        if (@$gdestination_slug) {
            $sel = (@$gdestination_slug == $destinationRow->slug) ? 'checked' : '';
        } else {
            $sel = @in_array($destinationRow->id, @$qdestination) ? 'checked' : '';
        }
        $tot = Package::get_total_destination_packages($destinationRow->id);
        $destination_filter .= '
                <div class="form-check mb-2">
                    <input class="form-check-input qdestination" type="checkbox" name="qdestination[]" ' . $sel . ' id="dest-' . $destinationRow->id . '" value="' . $destinationRow->id . '">
                    <label class="form-check-label d-flex justify-content-between align-items-center w-100" for="dest-' . $destinationRow->id . '">
                        <span>' . $destinationRow->title . '</span>
                        <span class="badge rounded-pill bg-light text-dark border">' . $tot . '</span>
                    </label>
                </div>
        ';
    }
    /* destination filter end*/

    /* activites filter start*/
    $activities_filter = '';
    $ActivitiesRec = Activities::get_activities();
    foreach ($ActivitiesRec as $ActivitiesRow) {
        if (@$gactivity_slug) {
            $sel = (@$gactivity_slug == $ActivitiesRow->slug) ? 'checked' : '';
        } else {
            $sel = (@$qactivities[0] == $ActivitiesRow->id) ? 'checked' : '';
        }
        $tot = 0;
        $tot += Package::get_total_activities_packages($ActivitiesRow->id);
        $activities_filter .= '
                <div class="form-check mb-2">
                    <input class="form-check-input qactivities" type="checkbox" name="qactivities[]" ' . $sel . ' id="acti-' . $ActivitiesRow->id . '" value="' . $ActivitiesRow->id . '">
                    <label class="form-check-label d-flex justify-content-between align-items-center w-100" for="acti-' . $ActivitiesRow->id . '">
                        <span>' . $ActivitiesRow->title . '</span>
                        <span class="badge rounded-pill bg-light text-dark border">' . $tot . '</span>
                    </label>
                </div>
        ';
    }
    /* activites filter end*/

    /* Activity (Difficulty) Level filter start*/
    $difficulty_filter = '';
    $difficultyRec = array('1' => 'Easy', '2' => 'Moderate', '3' => 'Moderate To Strenous', '4' => 'Strenous', '5' => 'Very Strenous');
    foreach ($difficultyRec as $k => $v) {
        $sel = (@in_array($k, @$gdifficulty)) ? 'checked' : '';
        $tot = 0;
        $sql = "SELECT id FROM tbl_package WHERE difficulty='" . $v . "' AND status=1";
        $tot = $db->num_rows($db->query($sql));
        $difficulty_filter .= '
                <div class="form-check mb-2">
                    <input class="form-check-input gdifficulty" type="checkbox" name="gdifficulty[]" ' . $sel . ' id="diff-' . $k . '" value="' . $k . '">
                    <label class="form-check-label d-flex justify-content-between align-items-center w-100" for="diff-' . $k . '">
                        <span>' . $v . '</span>
                        <span class="badge rounded-pill bg-light text-dark border">' . $tot . '</span>
                    </label>
                </div>
        ';
    }
    /* Activity Level filter end*/

    /* Duration start*/
    $duration_filter = '';
    $durationRec = array('5' => '1-5 Days', '10' => '6-10 Days', '15' => '11-15 Days', 'morethan15' => 'More than 15 Days');
    foreach ($durationRec as $k => $v) {
        $sel = ($k == @$days) ? 'checked' : '';
        $tot = 0;
        switch ($k) {
            case '5':
                $sql = "SELECT id FROM tbl_package WHERE status=1 AND days <= 5 ";
                break;
            case '10':
                $sql = "SELECT id FROM tbl_package WHERE status=1 AND ( days > 5 AND days <= 10 ) ";
                break;
            case '15':
                $sql = "SELECT id FROM tbl_package WHERE status=1 AND ( days > 10 AND days <= 15 ) ";
                break;
            case 'morethan15':
                $sql = "SELECT id FROM tbl_package WHERE status=1 AND days >= 16 ";
                break;
        }
        $tot = $db->num_rows($db->query($sql));
        $duration_filter .= '
                    <div class="form-check mb-2">
                        <input class="form-check-input gdays" type="radio" name="days" ' . $sel . ' id="days-' . $k . '" value="' . $k . '">
                        <label class="form-check-label d-flex justify-content-between align-items-center w-100" for="days-' . $k . '">
                            <span>' . $v . '</span>
                            <span class="badge rounded-pill bg-light text-dark border">' . $tot . '</span>
                        </label>
                    </div>
        ';
    }
    /* Duration end*/

    $resisearch .= '
            <aside class="sidebar-wrapper pv p-4 bg-white shadow-sm rounded-4">
                    <form action="' . BASE_URL . 'searchlist" method="post" id="search_form">
                                               
                        <div class="sidebar-box mb-4">
                            <div class="box-title mb-3 border-bottom pb-2"><h5 class="fw-bold text-dark">Destination</h5></div>
                            <div class="box-content custom-scrollbar" style="max-height: 250px; overflow-y: auto; padding-right: 10px;">
                                ' . $destination_filter . '
                            </div>
                        </div>
        
                        <div class="sidebar-box mb-4">
                            <div class="box-title mb-3 border-bottom pb-2"><h5 class="fw-bold text-dark">Activities</h5></div>
                            <div class="box-content custom-scrollbar" style="max-height: 250px; overflow-y: auto; padding-right: 10px;">
                                ' . $activities_filter . '
                            </div>
                        </div>
                        
                        <div class="sidebar-box mb-4">
                            <div class="box-title mb-3 border-bottom pb-2"><h5 class="fw-bold text-dark">Duration</h5></div>
                            <div class="box-content">
                                ' . $duration_filter . '
                            </div>
                        </div>
        
                        <div class="sidebar-box mb-4">
                            <div class="box-title mb-3 border-bottom pb-2"><h5 class="fw-bold text-dark">Activity Level</h5></div>
                            <div class="box-content">
                                ' . $difficulty_filter . '
                            </div>
                        </div>

                    </form>
            </aside>
            <style>
                .custom-scrollbar::-webkit-scrollbar {
                    width: 6px;
                }
                .custom-scrollbar::-webkit-scrollbar-track {
                    background: #f1f1f1;
                    border-radius: 10px;
                }
                .custom-scrollbar::-webkit-scrollbar-thumb {
                    background: #28a745; 
                    border-radius: 10px;
                }
                .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                    background: #218838; 
                }
            </style>
            ';
    /* search page search form end*/

    global $db;
    /*$sql = "SELECT pkg.id, pkg.title, pkg.slug, pkg.breif, pkg.days, pkg.image, pkg.price, pkg.difficulty, pkg.accomodation,
            act.title as activity, act.slug as activity_slug, 
            dst.title as destination, dst.slug as destination_slug
            FROM tbl_package  pkg 
            INNER JOIN tbl_destination  dst 
            ON pkg.destinationId = dst.id 
            INNER JOIN tbl_activities act 
            ON pkg.activityId = act.id 
            WHERE pkg.status=1 ";*/
    $sql = "SELECT pkg.id, pkg.title, pkg.slug, pkg.breif, pkg.days, pkg.image, pkg.price, pkg.offer_price, pkg.difficulty, pkg.accomodation,
            dst.title as destination, dst.slug as destination_slug
            FROM tbl_package  pkg 
            INNER JOIN tbl_destination  dst 
            ON pkg.destinationId = dst.id 
            WHERE pkg.status=1 ";
    if (@$qdestination[0] != 'all' and !empty($qdestination)) {
        foreach ($qdestination as $qdest) {
            if (sizeof($qdestination) > 1) {
                if (array_values($qdestination)[0] == $qdest) {
                    $sql .= " AND ( pkg.destinationId = $qdest ";
                } elseif (end($qdestination) == $qdest) {
                    $sql .= " OR pkg.destinationId = $qdest )";
                } else {
                    $sql .= " OR pkg.destinationId = $qdest ";
                }
            } else {
                $sql .= " AND pkg.destinationId = $qdest ";
            }
        }
    }
    if (@$gdestination_slug) {
        $dest = Destination::find_by_slug($gdestination_slug);
        $sql .= " AND pkg.destinationId = $dest->id ";
    }
    if (@$qactivities[0] != 'all' and !empty($qactivities)) {
        foreach ($qactivities as $qact) {
            if (sizeof($qactivities) > 1) {
                if (array_values($qactivities)[0] == $qact) {
                    $sql .= " AND ( pkg.activityId = '$qact' ";
                } elseif (end($qactivities) == $qact) {
                    $sql .= " OR pkg.activityId = '$qact' )";
                } else {
                    $sql .= " OR pkg.activityId = '$qact' ";
                }
            } else {
                $sql .= " AND pkg.activityId = '$qact' ";
            }
        }
    }
    if (@$gactivity_slug) {
        $act = Activities::find_by_slug($gactivity_slug);
        $sql .= " AND pkg.activityId = $act->id ";
    }
    if (!empty($gdifficulty)) {
        foreach ($gdifficulty as $gdiff) {
            if (sizeof($gdifficulty) > 1) {
                if (array_values($gdifficulty)[0] == $gdiff) {
                    $sql .= " AND ( pkg.difficulty = $gdiff ";
                } elseif (end($gdifficulty) == $gdiff) {
                    $sql .= " OR pkg.difficulty = $gdiff )";
                } else {
                    $sql .= " OR pkg.difficulty = $gdiff ";
                }
            } else {
                $sql .= " AND pkg.difficulty = $gdiff ";
            }
        }
    }
    if (!empty($days)) {
        switch ($days) {
            case '5':
                $sql .= " AND pkg.days <= $days ";
                break;
            case '10':
                $sql .= " AND ( pkg.days > 5 AND pkg.days <= $days ) ";
                break;
            case '15':
                $sql .= " AND ( pkg.days > 10 AND pkg.days <= $days ) ";
                break;
            case 'morethan15':
                $sql .= " AND pkg.days >= 16 ";
                break;
        }
    }
    if (!empty($gprice)) {
        switch ($gprice) {
            case '1000':
                $sql .= " AND pkg.price <= $gprice ";
                break;
            case '2000':
                $sql .= " AND (pkg.price > 1000 AND pkg.price <= $gprice)";
                break;
            case 'morethan2000':
                $sql .= " AND pkg.price > 2000 ";
                break;
        }
    }

    /* Breadcrumb Start*/
    $bread = '';
    /* Breadcrumb End*/        
    /* Breadcrumb End*/

    $page = (isset($_REQUEST["pageno"]) and !empty($_REQUEST["pageno"])) ? $_REQUEST["pageno"] : 1;
    $limit = 15;
    $total_num = $db->num_rows($db->query($sql));
    $startpoint = ($page * $limit) - $limit;
    $start = $startpoint + 1;
    $end = (($startpoint + $limit) > $total_num) ? $total_num : $startpoint + $limit;
    $sql .= " ORDER BY pkg.sortorder ASC";
    $sql .= " LIMIT " . $startpoint . "," . $limit;

    $res = $db->query($sql);
    $total = $db->affected_rows($res);
//     echo '<pre>'; print_r($sql); die();
    if ($total > 0) {
        while ($rows = $db->fetch_array($res)) {
            $file_path = SITE_ROOT . 'images/package/' . $rows['image'];
            $img = (!empty($rows['image']) and file_exists($file_path)) ? IMAGE_PATH . 'package/' . $rows['image'] : IMAGE_PATH . 'static/home-destination.jpg';

            $destinationTitle = !empty($rows['destination']) ? $rows['destination'] : '';
            if (isset($rows['activityId'])) {
                $activityTitle = !empty($rows['activityId']) ? Activities::field_by_id((int) $rows['activityId'], 'title') : '';
            } else {
                $activityTitle = ''; // activityId is not selected in current query
            }
            $accomodation = !empty($rows['accomodation']) ? $rows['accomodation'] : 'N/A';
            $difficulty = !empty($rows['difficulty']) ? $rows['difficulty'] : 'Moderate';
            $days = !empty($rows['days']) ? (int) $rows['days'] : 0;
            
            $popularBadge = '';
            if (isset($rows['popular']) && $rows['popular'] == 1) {
                $popularBadge = '<span class="badge">POPULAR</span>';
            }

            $destinationTitleClean = trim(strip_tags((string) $destinationTitle));
            $activityTitleClean = trim(strip_tags((string) $activityTitle));
            $accomodationClean = trim(strip_tags((string) $accomodation));
            $difficultyClean = trim(strip_tags((string) $difficulty));

            $destinationTitleDisplay = (strlen($destinationTitleClean) > 32) ? substr($destinationTitleClean, 0, 29) . '...' : $destinationTitleClean;
            $activityTitleDisplay = (strlen($activityTitleClean) > 32) ? substr($activityTitleClean, 0, 29) . '...' : $activityTitleClean;
            $accomodationDisplay = $accomodationClean;
            $difficultyDisplay = $difficultyClean;

            $respkglist .= '<div class="package-card">
                        <div class="image-wrapper">
                            <img src="' . $img . '" alt="' . htmlspecialchars($rows['title'], ENT_QUOTES, 'UTF-8') . '">
                            ' . $popularBadge . '
                        </div>

                        <div class="card-content">
                            <h3 class="title">' . htmlspecialchars($rows['title'], ENT_QUOTES, 'UTF-8') . '</h3>

                            <div class="card-info-wrapper">

                                <div class="info-row">
                                    <div class="info">
                                        <span class="label">Destination</span>
                                        <span class="value green" title="' . htmlspecialchars($destinationTitleClean, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($destinationTitleDisplay, ENT_QUOTES, 'UTF-8') . '</span>
                                    </div>
                                    <div class="row-divider"></div>
                                    <div class="info text-right">
                                        <span class="label">Accomodations</span>
                                        <span class="value green" title="' . htmlspecialchars($accomodationClean, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($accomodationDisplay, ENT_QUOTES, 'UTF-8') . '</span>
                                    </div>
                                </div>

                                <div class="action-row">
                                    <span class="days-badge">' . $days . ' days</span>
                                    <a href="' . BASE_URL . 'package/' . $rows['slug'] . '" class="explore_btn">
                                        <p>Explore</p>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                        </svg>
                                    </a>
                                </div>
                                <div class="info-row">';
            // We ignore activityTitle display if empty, to match original logic or just don't show it
            if ($activityTitleDisplay) {
                $respkglist .= '
                                    <div class="info">
                                        <span class="label">Activities</span>
                                        <span class="value green" title="' . htmlspecialchars($activityTitleClean, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($activityTitleDisplay, ENT_QUOTES, 'UTF-8') . '</span>
                                    </div>
                                    <div class="row-divider"></div>';
            }
            $respkglist .= '
                                    <div class="info text-right">
                                        <span class="label">Difficulty-level</span>
                                        <span class="value green" title="' . htmlspecialchars($difficultyClean, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($difficultyDisplay, ENT_QUOTES, 'UTF-8') . '</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
        }
        $navigation .= '
                    <div class="pager-innner">
                        <div class="row align-items-center text-center text-lg-left">
                            <div class="col-12 col-lg-5">
                                Showing result ' . $start . ' to ' . $end . ' from ' . $total_num . '
                            </div>
                            <div class="col-12 col-lg-7">';
        $navigation .= get_front_pagination_for_search($total_num, $limit, $page, BASE_URL . 'searchlist');
        $navigation .= '
                            </div>
                        </div>
                    </div>
        ';
    } else {
        $respkglist .= '
            <div class="col-12 text-center" style="grid-column: 1 / -1;">
                <h3>No Result Found</h3>
             </div>';
    }
    /*}else{
        $url = BASE_URL.'pages / errors';
        redirect_to($url);
    }*/
}

$jVars['module:search-searchform'] = $resisearch;
$jVars['module:package-search-breadcrumb'] = $bread;
$jVars['module:package-search-breadcrumb-title'] = $bread_title;
$jVars['module:package-search-breadcrumb-text'] = $bread_text;
$jVars['module:package-search-breadcrumb-extra'] = $bread_text_extra;
$jVars['module:package-searchlist'] = $respkglist;
$jVars['module:package-navigation'] = $navigation;
?>