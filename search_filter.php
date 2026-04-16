<?php
require_once("includes/initialize.php");

$result = $navigation = '';
if (isset($_POST['action']) and ($_POST['action'] == 'filter_data')) {

    foreach ($_POST as $key => $val) {
        $$key = $val;
    }

    global $db;
    /*
    $sql = "SELECT pkg.id, pkg.title, pkg.slug, pkg.breif, pkg.days, pkg.image, pkg.price, pkg.difficulty,pkg.accomodation,
            act.title as activity, act.slug as activity_slug, 
            dst.title as destination, dst.slug as destination_slug
            FROM tbl_package  pkg 
            INNER JOIN tbl_destination  dst 
            ON pkg.destinationId = dst.id 
            INNER JOIN tbl_activities act 
            ON pkg.activityId = act.id 
            WHERE pkg.status=1 ";
    */
    $sql = "SELECT pkg.id, pkg.title, pkg.slug, pkg.breif, pkg.days, pkg.image, pkg.price, pkg.offer_price, pkg.difficulty, pkg.accomodation,
            dst.title as destination, dst.slug as destination_slug
            FROM tbl_package  pkg 
            INNER JOIN tbl_destination  dst 
            ON pkg.destinationId = dst.id 
            WHERE pkg.status=1 ";

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
    if (!empty($qdestination)) {
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
    if (!empty($qactivities)) {
        foreach ($qactivities as $qact) {
            if (sizeof($qactivities) > 1) {
                if (array_values($qactivities)[0] == $qact) {
                    //$sql .= " AND ( act.id = '$qact' ";
                    $sql .= " AND ( pkg.activityId = '$qact' ";
                } elseif (end($qactivities) == $qact) {
                    //$sql .= " OR act.id = '$qact' )";
                    $sql .= " OR pkg.activityId = '$qact' )";
                } else {
                    //$sql .= " OR act.id = '$qact' ";
                    $sql .= " OR pkg.activityId = '$qact' ";
                }
            } else {
                //$sql .= " AND act.id = '$qact' ";
                $sql .= " AND pkg.activityId = '$qact' ";
            }
        }
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

    $page = 1;
    $limit = 15;
    $total_num = $db->num_rows($db->query($sql));
    $startpoint = ($page * $limit) - $limit;
    $start = $startpoint + 1;
    $end = (($startpoint + $limit) > $total_num) ? $total_num : $startpoint + $limit;
    $sql .= " ORDER BY pkg.sortorder ASC";
    $sql .= " LIMIT " . $startpoint . "," . $limit;

    $res = $db->query($sql);
    $total = $db->affected_rows($res);

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

            $result .= '<div class="package-card">
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
                $result .= '
                                    <div class="info">
                                        <span class="label">Activities</span>
                                        <span class="value green" title="' . htmlspecialchars($activityTitleClean, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($activityTitleDisplay, ENT_QUOTES, 'UTF-8') . '</span>
                                    </div>
                                    <div class="row-divider"></div>';
            }
            $result .= '
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
        $result .= '
            <div class="col-12 text-center" style="grid-column: 1 / -1;">
                <h3>No Result Found</h3>
             </div>';
    }

    echo json_encode(array("action" => "success", "result" => $result, "nav" => $navigation));
}

?>