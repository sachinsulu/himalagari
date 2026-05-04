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
            <li class="package-card deal-card blog-list-card">
              <div class="deal-image">
                <a href="' . $linksrc . '"' . $linkTarget . '><img src="' . $imgSrc . '" alt="' . $title . '"></a>
                <div class="blog-date-box">' . $blogDate . '</div>
              </div>
              <div class="card-content">
                <div class="blog-meta blog-text">
                  <div class="author-info">
                    <p>By ' . $author . '</p>
                  </div>
                </div>
                <div class="blog-content blog_continue_reading">
                  <a href="' . $linksrc . '"' . $linkTarget . '><h6>' . $title . '</h6></a>
                  <p>' . $brief . '</p>
                </div>
                <hr>
                <a href="' . $linksrc . '"' . $linkTarget . ' class="continue-reading">
                  <span>Continue Reading</span>
                  <i class="fa-solid fa-arrow-right"></i>
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
    $homeblog = Blog::get_latestblog_by(24);
    if (!empty($homeblog)) {
        $blogCount = 0;
        foreach ($homeblog as $homebl) {
            $blogCount++;
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
            $monthYear = date('M', strtotime($homebl->blog_date)) . ' ' . date('Y', strtotime($homebl->blog_date));

            $hideStyle = ($blogCount > 6) ? ' style="display:none;"' : '';

            $homebloglist .= '
      <li class="package-card deal-card blog-list-card"'. $hideStyle .'>
        <div class="deal-image">
          <a href="' . $linksrc . '"' . $linkTarget . '><img src="' . $imgSrc . '" alt="' . $title . '" /></a>
          <div class="blog-date-box">
            <span>' . $day . '</span>' . $monthYear . '
          </div>
        </div>
        <div class="card-content">
          <div class="blog-meta">
            <div class="author-info">
              <p>By ' . $author . '</p>
            </div>
          </div>

          <div class="blog-content">
            <a href="' . $linksrc . '"' . $linkTarget . '>
              <h6>' . $title . '</h6>
            </a>
            <p>' . $brief . '</p>
          </div>
          <hr />
          <a href="' . $linksrc . '"' . $linkTarget . ' class="continue-reading">
              <span>Continue Reading</span>
              <i class="fa-solid fa-arrow-right"></i>
          </a>
        </div>
      </li>';
        }

        $homeblogs = '
  <section class="popular-packages mx-auto blog_wrapper deals-grid text-center components packages-wrapper">
    <h4 class="text-center">Top Travel Inspirations</h4>
    <h2 class="mb-5 green-title text-center">
      Destinations and stories
      <span class="orange-text">Worth Exploring</span>
    </h2>

    <ul class="packages-grid mx-auto">
      ' . $homebloglist . '
    </ul>';

        if (count($homeblog) > 6) {
            $homeblogs .= '
      <div class="load-more-wrap text-center mt-4">
        <button type="button" class="explore_btn mx-auto inquiry-btn js-load-more-packages" data-initial="6" data-step="24" data-text-more="Load More Blogs" data-text-less="Show Less Blogs">
          <p>Load More Blogs</p>
        </button>
      </div>';
        }

        $homeblogs .= '
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

    $recents = Blog::get_latestblog_by(6);
    $validRecents = [];
    if (!empty($recents)) {
        foreach ($recents as $recent) {
            if ((int) $recent->id !== (int) $blog->id) {
                $validRecents[] = $recent;
            }
        }
    }
    $hasRelated = !empty($validRecents);

    // Split title in half for two-color styling
    $words = explode(' ', $title);
    $half = ceil(count($words) / 2);
    $firstHalf = implode(' ', array_slice($words, 0, $half));
    $secondHalf = implode(' ', array_slice($words, $half));
    $formattedTitle = $firstHalf . (!empty($secondHalf) ? ' <span class="orange-text">' . $secondHalf . '</span>' : '');

    $blog_detail .= '
    <section class="blog-section components" style="margin-top: 50px; margin-bottom: 50px;">
      <div class="container" style="' . (!$hasRelated ? 'grid-template-columns: 1fr;' : '') . '">
        <div class="blog-content share-wrapper" style="' . (!$hasRelated ? 'max-width: 100%;' : '') . '">
          ' . (!$hasRelated ? '<style>.blog-content p { max-width: 100% !important; }</style>' : '') . '
          <h2 class="green-title">' . $formattedTitle . '</h2>
          <p class="mb-3 text-muted">By ' . $author . ' | ' . $dateText . '</p>
          <div class="blog-image mb-4">
            <img src="' . $mainImage . '" alt="' . $title . '" style="width: 100%; height: auto; max-height: 500px; object-fit: cover; border-radius: 12px;">
          </div>
          <div class="mt-4">' . $blog->content . '</div>
        </div>';

    if ($hasRelated) {
        $blog_detail .= '
        <aside class="related-posts sticky-top" style="top: 100px; align-self: start;">
          <h3 class="green-title mb-4" style="font-size: 24px;">Related Posts</h3>';

        foreach ($validRecents as $recent) {
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
          <div class="related-item d-flex mb-4 align-items-center">
            <a href="' . $recentLink . '"' . $recentTarget . ' class="flex-shrink-0">
              <img src="' . $recentImage . '" alt="' . $recentTitle . '" style="width: 90px; height: 90px; object-fit: cover; border-radius: 8px; margin-right: 15px;">
            </a>
            <div>
              <span class="d-block text-muted mb-1" style="font-size: 12px;">' . $recentDate . '</span>
              <a href="' . $recentLink . '"' . $recentTarget . '" style="color: #333; font-weight: 600; font-size: 15px; text-decoration: none; line-height: 1.4; display: block;" onmouseover="this.style.color=\'#1C6408\'" onmouseout="this.style.color=\'#333\'">' . $recentTitle . '</a>
            </div>
          </div>';
        }

        $blog_detail .= '
        </aside>';
    }

    $blog_detail .= '
      </div>
    </section>';
}


$jVars['module:blog-detail'] = $blog_detail;
$jVars['module:blog-recent-posts'] = $recent_posts;


?>