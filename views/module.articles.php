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
            $reshome .= $content[0];
        }
    }
}

$jVars['module:showhome'] = $reshome;
?>