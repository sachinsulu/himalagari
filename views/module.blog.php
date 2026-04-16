<?php
$bl = '';

if (defined('BLOGLIST_PAGE')) {
    $record = Blog::get_allblog();

    $bl .= '
    <section class="popular-packages deals-grid text-center components">
      <header class="page-header">
        <h2 id="blog_title" class="green-title">Travel <span class="orange-text">Blogs</span></h2>
        <h6>Destinations and stories Worth Exploring</h6>
      </header>
      <br>
      <div class="package-grid-wrapper">
        <ul class="package-grid" id="packageGrid">';

    if (!empty($record)) {
        foreach ($record as $homebl) {
            $linkTarget = '';
            if (!empty($homebl->linksrc)) {
                $linkTarget = ((int) $homebl->linktype === 1) ? ' target="_blank"' : '';
                $linksrc = ((int) $homebl->linktype === 1) ? $homebl->linksrc : BASE_URL . ltrim($homebl->linksrc, '/');
            } else {
                $linksrc = BASE_URL . 'blog/' . $homebl->slug;
            }

            $title = htmlspecialchars($homebl->title, ENT_QUOTES, 'UTF-8');
            $author = !empty($homebl->author) ? htmlspecialchars($homebl->author, ENT_QUOTES, 'UTF-8') : 'Admin';
            $brief = !empty($homebl->brief) ? strip_tags($homebl->brief) : '';
            $brief = strlen($brief) > 150 ? substr($brief, 0, 147) . '...' : $brief;
            $imgSrc = !empty($homebl->image)
                ? IMAGE_PATH . 'blog/' . $homebl->image
                : BASE_URL . 'template/web/assets/images/pop-pack-1.png';
            $blogDate = date('d M Y', strtotime($homebl->blog_date));

            $bl .= '
            <li class="package-card deal-card">
              <div class="deal-image">
                <a href="' . $linksrc . '"' . $linkTarget . '><img src="' . $imgSrc . '" alt="' . $title . '"></a>
              </div>
              <div class="card-content">
                <div class="author">
                  <p>By ' . $author . '</p>
                  <p>' . $blogDate . '</p>
                </div>
                <div class="blog-content">
                  <a href="' . $linksrc . '"' . $linkTarget . '><h6>' . $title . '</h6></a>
                  <p>' . $brief . '</p>
                </div>
                <hr>
                <a href="' . $linksrc . '"' . $linkTarget . '>
                  <div class="author ">
                    <p>Continue Reading</p>
                    <i class="fa-solid fa-arrow-right fa-1x py-2"></i>
                  </div>
                </a>
              </div>
            </li>';
        }
    } else {
        $bl .= '<li class="package-card deal-card"><div class="card-content"><p>No blogs found.</p></div></li>';
    }

    $bl .= '
        </ul>
      </div>
    </section>';
}
$jVars['module:bloglist'] = $bl;
$linkTarget = '';
$homebloglist = '';
$homeblogs = '';
if (defined('HOME_PAGE')) {
    $homeblog = Blog::get_latestblog_by(3);
    if (!empty($homeblog)) {
        foreach ($homeblog as $homebl) {
            if (!empty($homebl->linksrc)) {
                $linkTarget = ((int) $homebl->linktype === 1) ? ' target="_blank"' : '';
                $linksrc = ((int) $homebl->linktype === 1) ? $homebl->linksrc : BASE_URL . ltrim($homebl->linksrc, '/');
            } else {
                $linkTarget = '';
                $linksrc = BASE_URL . 'blog/' . $homebl->slug;
            }

            $title = htmlspecialchars($homebl->title, ENT_QUOTES, 'UTF-8');
            $author = !empty($homebl->author) ? htmlspecialchars($homebl->author, ENT_QUOTES, 'UTF-8') : 'Admin';
            $brief = !empty($homebl->brief) ? strip_tags($homebl->brief) : '';
            $brief = strlen($brief) > 130 ? substr($brief, 0, 127) . '...' : $brief;
            $imgSrc = !empty($homebl->image)
                ? IMAGE_PATH . 'blog/' . $homebl->image
                : BASE_URL . 'template/web/assets/images/everestbasecamp.jpg';

            $day = date('d', strtotime($homebl->blog_date));
            $monthYear = date('M', strtotime($homebl->blog_date)) . ' <br />' . date('Y', strtotime($homebl->blog_date));

            $homebloglist .= '
      <li class="package-card deal-card">
        <div class="deal-image">
          <a href="' . $linksrc . '"' . $linkTarget . '><img src="' . $imgSrc . '" alt="' . $title . '" /></a>
        </div>
        <div class="card-content">
          <div class="author">
            <p>By ' . $author . '</p>
            <p>
              <span>' . $day . '</span> <br />
              ' . $monthYear . '
            </p>
          </div>

          <div class="blog-content">
            <a href="' . $linksrc . '"' . $linkTarget . '>
              <h6>' . $title . '</h6>
            </a>
            <p>' . $brief . '</p>
          </div>
          <hr />
          <a href="' . $linksrc . '"' . $linkTarget . '>
            <div class="author">
              <p>Continue Reading</p>
              <i class="fa-solid fa-arrow-right fa-1x py-2"></i>
            </div>
          </a>
        </div>
      </li>';
        }

        $homeblogs = '
  <section class="popular-packages mx-auto blog_wrapper deals-grid text-center components">
    <h4 class="text-center">Top Travel Inspirations</h4>
    <h2 class="mb-5 green-title text-center">
      Destinations and stories
      <span class="orange-text">Worth Exploring</span>
    </h2>

    <ul class="packages-grid mx-auto">
      ' . $homebloglist . '
    </ul>

    <a href="' . BASE_URL . 'blog" class="explore_btn inquiry-btn mx-auto mt-4">
      <p>View More</p>
    </a>
  </section>';
    }
}

$jVars['module:homebloglist'] = $homeblogs;

$blog_detail = $recent_posts = '';
if (defined("BLOG_PAGE")) {
    $slug = !empty($_REQUEST['slug']) ? trim($_REQUEST['slug']) : '';

    if (empty($slug)) {
        redirect_to(BASE_URL . 'blog');
    }

    $blog = Blog::find_by_slug($slug);

    if (empty($blog) || (int) $blog->status !== 1) {
        redirect_to(BASE_URL . 'blog');
    }

    $title = htmlspecialchars($blog->title, ENT_QUOTES, 'UTF-8');
    $author = !empty($blog->author) ? htmlspecialchars($blog->author, ENT_QUOTES, 'UTF-8') : 'Admin';
    $dateText = date('d M, Y', strtotime($blog->blog_date));
    $mainImage = !empty($blog->image)
        ? IMAGE_PATH . 'blog/' . $blog->image
        : BASE_URL . 'template/web/assets/images/langtangtrek.jpg';

    $blog_detail .= '
    <section class="blog-section">
      <div class="container">
        <div class="blog-content share-wrapper">
          <h2 class="green-title">' . $title . '</h2>
          <p class="mb-2">By ' . $author . ' | ' . $dateText . '</p>
          <div class="blog-image">
            <img src="' . $mainImage . '" alt="' . $title . '">
          </div>
          <div class="mt-4">' . $blog->content . '</div>
        </div>
        <aside class="related-posts">
          <h3>Related Post</h3>';

    $recents = Blog::get_latestblog_by(6);
    if (!empty($recents)) {
        foreach ($recents as $recent) {
            if ((int) $recent->id === (int) $blog->id) {
                continue;
            }

            $recentTitle = htmlspecialchars($recent->title, ENT_QUOTES, 'UTF-8');
            $recentDate = date('d M, Y', strtotime($recent->blog_date));
            $recentImage = !empty($recent->image)
                ? IMAGE_PATH . 'blog/' . $recent->image
                : BASE_URL . 'template/web/assets/images/everestbasecamp.jpg';

            if (!empty($recent->linksrc)) {
                $recentTarget = ((int) $recent->linktype === 1) ? ' target="_blank"' : '';
                $recentLink = ((int) $recent->linktype === 1)
                    ? $recent->linksrc
                    : BASE_URL . ltrim($recent->linksrc, '/');
            } else {
                $recentTarget = '';
                $recentLink = BASE_URL . 'blog/' . $recent->slug;
            }

            $blog_detail .= '
              <div class="related-item">
                <img src="' . $recentImage . '" alt="' . $recentTitle . '">
                <div>
                  <span>' . $recentDate . '</span>
                  <a href="' . $recentLink . '"' . $recentTarget . '>' . $recentTitle . '</a>
                </div>
              </div>';
        }
    }

    $blog_detail .= '
        </aside>
      </div>
    </section>';
}


$jVars['module:blog-detail'] = $blog_detail;
$jVars['module:blog-recent-posts'] = $recent_posts;


?>