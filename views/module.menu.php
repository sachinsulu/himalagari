<?php
$result = '';

$menuRec = Menu::getMenuByParent(0, 1);

$current_url = $_SERVER["REQUEST_URI"];
$data = explode('/', $current_url);

if ($menuRec):
    $result .= '<ul class="main-nav">';
    foreach ($menuRec as $menuRow):
        $linkActive = $PlinkActive = '';
        $tot = strlen(SITE_FOLDER) + 2;
        $data = substr($_SERVER['REQUEST_URI'], $tot);

        if (!empty($data)):
            $linkActive = ($menuRow->linksrc == $data) ? " active" : "";
            $parentInfo = Menu::find_by_linksrc($data);
            if ($parentInfo):
                $PlinkActive = ($menuRow->id == $parentInfo->parentOf) ? " active" : "";
            endif;
        endif;

        $menusubRec = Menu::getMenuByParent($menuRow->id, 1);
//        $subclass = ($menusubRec) ? ' dropdown-toggle disabled' : '';
//        $tags = ($menusubRec) ? ' data-toggle="dropdown"' : '';
        $subclass = ($menusubRec) ? '' : '';
        $tags = ($menusubRec) ? '' : '';
        $result .= '<li>';
        $result .= getMenuList($menuRow->name, $menuRow->linksrc, $menuRow->linktype, $linkActive . $PlinkActive . $subclass, $tags);
        /* Second Level Menu */
        if ($menusubRec):
            $result .= '<ul>';
            foreach ($menusubRec as $menusubRow):
                $menusub2Rec = Menu::getMenuByParent($menusubRow->id, 1);
                $subclass2 = ($menusub2Rec) ? ' class="dropdown-submenu"' : '';
                $subclass = (!empty($menusub2Rec)) ? ' dropdown-toggle disabled' : '';
                $tags = ($menusub2Rec) ? ' data-toggle="dropdown"' : '';

                $result .= '<li id="menu-item-' . $menusubRow->id . '" ' . $subclass2 . '>';
                $result .= getMenuList($menusubRow->name, $menusubRow->linksrc, $menusubRow->linktype, $subclass, $tags);
                /* Third Level Menu */
                if ($menusub2Rec):
                    $result .= '<ul class="dropdown-menu">';
                    foreach ($menusub2Rec as $menusub2Row):
                        $menusub3Rec = Menu::getMenuByParent($menusub2Row->id, 1);
                        $subclass3 = ($menusub3Rec) ? ' class="dropdown-submenu"' : '';
                        $subclass = (!empty($menusub3Rec)) ? ' dropdown-toggle disabled' : '';
                        $tags = ($menusub3Rec) ? ' data-toggle="dropdown"' : '';
                        $result .= '<li id="menu-item-' . $menusub2Row->id . '" ' . $subclass3 . '>';
                        $result .= getMenuList($menusub2Row->name, $menusub2Row->linksrc, $menusub2Row->linktype, $subclass, $tags);
                        /* Fourth Level Menu */
                        if ($menusub3Rec):
                            $result .= '<ul class="dropdown-menu">';
                            foreach ($menusub3Rec as $menusub3Row):
                                $menusub4Rec = Menu::getMenuByParent($menusub3Row->id, 1);
                                $chkparent4 = (!empty($menusub4Rec)) ? ' class="dropdown-submenu"' : '';
                                $subclass = (!empty($menusub4Rec)) ? ' dropdown-toggle disabled' : '';
                                $tags = ($menusub4Rec) ? ' data-toggle="dropdown"' : '';
                                $result .= '<li id="menu-item-' . $menusub3Row->id . '" ' . $chkparent4 . '>';
                                $result .= getMenuList($menusub3Row->name, $menusub3Row->linksrc, $menusub3Row->linktype, $subclass, $tags);
                                /* Fifth Level Menu */
                                if ($menusub4Rec):
                                    $result .= '<ul class="dropdown-menu">';
                                    foreach ($menusub4Rec as $menusub4Row):
                                        $menusub5Rec = Menu::getMenuByParent($menusub4Row->id, 1);
                                        $chkparent5 = (!empty($menusub4Rec)) ? 1 : 0;
                                        $result .= '<li>' . getMenuList($menusub4Row->name, $menusub4Row->linksrc, $menusub4Row->linktype, $chkparent5) . '</li>';
                                    endforeach;
                                    $result .= '</ul>';
                                endif;
                                $result .= '</li>';
                            endforeach;
                            $result .= '</ul>';
                        endif;
                        $result .= '</li>';
                    endforeach;
                    $result .= '</ul>';
                endif;
                $result .= '</li>';
            endforeach;
            $result .= '</ul>';
        endif;
        $result .= '</li>';
    endforeach;
    $result .= '</ul>';
endif;

$jVars['module:menu'] = $result;


//Footer Menu
$result1 = '';
$FmenuRec = Menu::getMenuByParent(0, 2);
if ($FmenuRec):
    $result1 .= '<ul>';
    foreach ($FmenuRec as $FmenuRow):
        $result1 .= '<li>';
        $result1 .= getMenuList($FmenuRow->name, $FmenuRow->linksrc, $FmenuRow->linktype, 'parent');
//		   $subRec = Menu::getMenuByParent($FmenuRow->id,2);
        $result1 .= '</li>';
    endforeach;
    $result1 .= '</ul>';
endif;
$jVars['module:footer-menu-1'] = $result1;

$result2 = '';
$FmenuRec = Menu::getMenuByParent(0, 3);
if ($FmenuRec):
    $result2 .= '<ul>';
    foreach ($FmenuRec as $FmenuRow):
        $result2 .= '<li>';
        $result2 .= getMenuList($FmenuRow->name, $FmenuRow->linksrc, $FmenuRow->linktype, 'parent');
//		   $subRec = Menu::getMenuByParent($FmenuRow->id,2);
        $result2 .= '</li>';
    endforeach;
    $result2 .= '</ul>';
endif;
$jVars['module:footer-menu-2'] = $result2;

$result3 = '';
$FmenuRec = Menu::getMenuByParent(0, 4);
if ($FmenuRec):
    $result3 .= '<ul>';
    foreach ($FmenuRec as $FmenuRow):
        $result3 .= '<li>';
        $result3 .= getMenuList($FmenuRow->name, $FmenuRow->linksrc, $FmenuRow->linktype, 'parent');
//		   $subRec = Menu::getMenuByParent($FmenuRow->id,2);
        $result3 .= '</li>';
    endforeach;
    $result3 .= '</ul>';
endif;
$jVars['module:footer-menu-3'] = $result3;

?>