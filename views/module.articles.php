<?php
/*
* Articles Module
*/
$resbcumb = '';
$resartcle = '';

if (defined('ARTICLE_PAGE')) {
    $page = isset($_REQUEST['slug']) ? addslashes($_REQUEST['slug']) : '';
    $Record = Articles::getArticles($page);
    if ($Record) {
        // Banner image
        $imgNm = '';
        $file_path = SITE_ROOT . 'images/articles/' . $Record->image;
        if (file_exists($file_path) and !empty($Record->image)) {
            $imgNm .= IMAGE_PATH . 'articles/' . $Record->image;
        } else {
            $imgNm .= IMAGE_PATH . 'static/article-banner.jpg';
        }


        $resartcle .= '
            '.$Record->content.'
            ';

        

    }
}

$jVars['module:articlebcumb'] = $resbcumb;
$jVars['module:articlepage'] = $resartcle;


/*
/news list at homepage
*/
$reshome = '';
if (defined('HOME_PAGE')) {
    $rechome = Articles::homepageArticles(1);
    if ($rechome) {
        foreach ($rechome as $row) {
            $content = explode('<hr id="system_readmore" style="border-style: dashed; border-color: orange;" />', trim($row->content));
            
            $file_path = SITE_ROOT . 'images/articles/' . $row->image;
            $imgsrc = (file_exists($file_path) && !empty($row->image)) ? IMAGE_PATH . 'articles/' . $row->image : BASE_URL . 'template/web/assets/images/aboutimg2.jpg';

            $reshome .= '
            <section class="about-hero components">
                <div class="about-hero-inner">
                <!-- LEFT CONTENT -->
                <div class="about-text">
                    <span class="about-label">'.$row->type.'</span>

                    <h2>' . $row->title . '</h2>

                    <p>
                    ' . strip_tags($content[0]) . '
                    </p>
                    <!-- uiverse btn -->
                    <a href="' . BASE_URL . 'pages/about-us" class="explore_btn inquiry-btn">
                    <p>View More</p>
                    </a>
                </div>

                <!-- RIGHT IMAGE -->
                <div class="about-media">
                    <img src="' . $imgsrc . '" alt="' . $row->title . '" />
                </div>
                </div>
            </section>';
        }
    }
}

$jVars['module:showhome'] = $reshome;


/*
/ Blog list for Homepage
*/
$resbloghome = '';
if (defined('HOME_PAGE')) {
    $rechomeblog = Articles::homepageArticles(6);
    if ($rechomeblog) {
        $resbloghome .= '
        <section class="popular-packages mx-auto blog_wrapper deals-grid text-center components">
            <h4 class="text-center">Top Travel Inspirations</h4>
            <h2 class="mb-5 green-title text-center">
                Destinations and stories
                <span class="orange-text">Worth Exploring</span>
            </h2>

            <ul class="packages-grid mx-auto">';
        
        foreach ($rechomeblog as $row) {
            $file_path = SITE_ROOT . 'images/articles/' . $row->image;
            $imgsrc = (file_exists($file_path) && !empty($row->image)) ? IMAGE_PATH . 'articles/' . $row->image : BASE_URL . 'template/web/assets/images/everestbasecamp.jpg';
            
            $content = explode('<hr id="system_readmore" style="border-style: dashed; border-color: orange;" />', trim($row->content));
            $short_desc = !empty($content[0]) ? strip_tags($content[0]) : '';
            $short_desc = (strlen($short_desc) > 120) ? substr($short_desc, 0, 117) . '...' : $short_desc;
            
            $date = date('j', strtotime($row->added_date));
            $month = date('M', strtotime($row->added_date));
            $year = date('Y', strtotime($row->added_date));
            $suffix = date('S', strtotime($row->added_date));

            $resbloghome .= '
            <li class="package-card deal-card">
                <div class="deal-image">
                    <a href="' . BASE_URL . 'pages/' . $row->slug . '"><img src="' . $imgsrc . '" alt="' . $row->title . '" /></a>
                </div>
                <div class="card-content">
                    <div class="author">
                        <p>By Admin</p>
                        <p>
                            <span>' . $date . '</span> <sup>' . $suffix . '</sup> ' . $month . ' <br />
                            ' . $year . '
                        </p>
                    </div>

                    <div class="blog-content">
                        <a href="' . BASE_URL . 'pages/' . $row->slug . '">
                            <h6>' . $row->title . '</h6>
                        </a>
                        <p>' . $short_desc . '</p>
                    </div>
                    <hr />
                    <a href="' . BASE_URL . 'pages/' . $row->slug . '">
                        <div class="author">
                            <p>Continue Reading</p>
                            <i class="fa-solid fa-arrow-right fa-1x py-2"></i>
                        </div>
                    </a>
                </div>
            </li>';
        }

        $resbloghome .= '
            </ul>
            <a href="' . BASE_URL . 'blog_listing.html" class="explore_btn inquiry-btn mx-auto mt-4">
                <p>View More</p>
            </a>
        </section>';
    }
}

$jVars['module:articles-home-list'] = $resbloghome;

/* 
/ Explore Locally section from Article "home"
*/
$res_explore_home = '';
if (defined('HOME_PAGE')) {
    $rec_explore = Articles::getArticles('home');
    if ($rec_explore) {
        $res_explore_home = $rec_explore->content;
    }
}
$jVars['module:explore-home'] = $res_explore_home;

?>