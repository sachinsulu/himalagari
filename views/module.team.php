<?php
$res_team = '';

// Fetch Executive Team (Role 1)
$executives = team::find_all_by_role(1);

// Fetch Tour Guides (Role 2)
$guides = team::find_all_by_role(2);

if ($executives || $guides) {
    $res_team .= '
    <h2 class="green-title">Meet Our <span class="orange-text">Team</span></h2>
    <section class="team-section container mx-auto">

      <!-- Tabs -->
      <div class="team-tabs">';
        if ($executives) {
            $res_team .= '<button class="tab active" data-tab="executive">Executive Team</button>';
        }
        if ($guides) {
            $guide_active = (!$executives) ? ' active' : '';
            $res_team .= '<button class="tab' . $guide_active . '" data-tab="meet">Tour Guides</button>';
        }
    $res_team .= '</div>';

    if ($executives) {
        $res_team .= '
        <!-- Executive Team -->
        <div class="team-content active" id="executive">';
            foreach ($executives as $row) {
                $imgNm = '';
                $file_path = SITE_ROOT . 'images/team/' . $row->image;
                if (file_exists($file_path) && !empty($row->image)) {
                    $imgNm = IMAGE_PATH . 'team/' . $row->image;
                } else {
                    $imgNm = IMAGE_PATH . 'static/default-team.jpg'; // Fallback image
                }

                // Shorten content for preview (first 250 chars)
                $short_content = mb_strimwidth(strip_tags($row->content), 0, 250, "...");

                $res_team .= '
                <div class="team-member">
                  <img src="' . $imgNm . '" alt="' . $row->name . '">
                  <div class="member-info">
                    <span class="position">' . $row->title . '</span>
                    <h3 class="name">' . $row->name . '</h3>
                    <p class="description">' . $short_content . '</p>
                    <a href="#" class="show-more">+ show more</a>
                    <div class="popup-overlay">
                      <div class="popup-box">
                        <a href="#" class="close-btn">&times;</a>
                        <h2>' . $row->title . '</h2>
                        <p class="name-text">' . $row->name . '</p>
                        <div class="detail-desc">
                          ' . $row->content . '
                        </div>
                      </div>
                    </div>
                  </div>
                </div>';
            }
        $res_team .= '</div>';
    }

    if ($guides) {
        $guide_active = (!$executives) ? ' active' : '';
        $res_team .= '
        <!-- Meet the Team (Tour Guides) -->
        <div class="team-content' . $guide_active . '" id="meet">';
            foreach ($guides as $row) {
                $imgNm = '';
                $file_path = SITE_ROOT . 'images/team/' . $row->image;
                if (file_exists($file_path) && !empty($row->image)) {
                    $imgNm = IMAGE_PATH . 'team/' . $row->image;
                } else {
                    $imgNm = IMAGE_PATH . 'static/default-team.jpg';
                }

                $short_content = mb_strimwidth(strip_tags($row->content), 0, 250, "...");

                $res_team .= '
                <div class="team-member">
                  <img src="' . $imgNm . '" alt="' . $row->name . '">
                  <div class="member-info">
                    <span class="position">' . $row->title . '</span>
                    <h3 class="name">' . $row->name . '</h3>
                    <p class="description">' . $short_content . '</p>
                    <a href="#" class="show-more">+ show more</a>
                    <div class="popup-overlay">
                      <div class="popup-box">
                        <a href="#" class="close-btn">&times;</a>
                        <h2>' . $row->title . '</h2>
                        <p class="name-text">' . $row->name . '</p>
                        <div class="detail-desc">
                          ' . $row->content . '
                        </div>
                      </div>
                    </div>
                  </div>
                </div>';
            }
        $res_team .= '</div>';
    }

    $res_team .= '</section>';
}

$jVars['module:team_list'] = $res_team;
?>

