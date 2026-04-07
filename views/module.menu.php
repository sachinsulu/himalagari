<?php
$result = '';

$menuRec = Menu::getMenuByParent(0, 1);

$current_url = $_SERVER["REQUEST_URI"];
$data = explode('/', $current_url);

if ($menuRec):
    $result .= '<ul class="navbar-nav flex-row ms-auto gap-3 align-items-center">';
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

        if ($menusubRec):
            $result .= '<li class="nav-item dropdown d-none d-lg-block">';
            $result .= '<a class="nav-link dropdown-toggle ' . $linkActive . $PlinkActive . '" href="#" role="button" data-bs-toggle="dropdown">' . $menuRow->name . '</a>';
            $result .= '<ul class="dropdown-menu dropdown-menu-dark">';
            foreach ($menusubRec as $menusubRow):
                $subactive = (substr($_SERVER['REQUEST_URI'], $tot) == $menusubRow->linksrc) ? " active" : "";
                $result .= '<li><a class="dropdown-item ' . $subactive . '" href="' . BASE_URL . $menusubRow->linksrc . '">' . $menusubRow->name . '</a></li>';
            endforeach;
            $result .= '</ul>';
        else:
            $result .= '<li class="nav-item d-none d-lg-block">';
            $result .= '<a class="nav-link ' . $linkActive . $PlinkActive . '" href="' . BASE_URL . $menuRow->linksrc . '">' . $menuRow->name . '</a>';
        endif;
        $result .= '</li>';
    endforeach;
    $result .= '</ul>';
endif;


$jVars['module:menu'] = $result;

// Home Menu
$menu_home = '';
$menuRec = Menu::getMenuByParent(0, 1);
if ($menuRec):
    $menu_home .= '<ul class="navbar-nav flex-row ms-auto hero-navbar gap-3 align-items-center">';
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

        if ($menusubRec):
            $menu_home .= '<li class="nav-item dropdown d-none d-lg-block">';
            $menu_home .= '<a class="nav-link dropdown-toggle ' . $linkActive . $PlinkActive . '" href="#" role="button" data-bs-toggle="dropdown">' . $menuRow->name . '</a>';
            $menu_home .= '<ul class="dropdown-menu dropdown-menu-dark">';
            foreach ($menusubRec as $menusubRow):
                $subactive = (substr($_SERVER['REQUEST_URI'], $tot) == $menusubRow->linksrc) ? " active" : "";
                $menu_home .= '<li><a class="dropdown-item ' . $subactive . '" href="' . BASE_URL . $menusubRow->linksrc . '">' . $menusubRow->name . '</a></li>';
            endforeach;
            $menu_home .= '</ul>';
        else:
            $menu_home .= '<li class="nav-item d-none d-lg-block">';
            $menu_home .= '<a class="nav-link ' . $linkActive . $PlinkActive . '" href="' . BASE_URL . $menuRow->linksrc . '">' . $menuRow->name . '</a>';
        endif;
        $menu_home .= '</li>';
    endforeach;
    $menu_home .= '</ul>';
endif;

$jVars['module:menu_home'] = $menu_home;

// Offcanvas Menu
$res_offcanvas = '';
$menuRec = Menu::getMenuByParent(0, 1);
if ($menuRec):
    $res_offcanvas .= '<ul class="list-unstyled">';
    foreach ($menuRec as $menuRow):
        $menusubRec = Menu::getMenuByParent($menuRow->id, 1);
        if ($menusubRec):
            $accordionId = 'accordion_' . $menuRow->id;
            $collapseId = 'collapse_' . $menuRow->id;
            $res_offcanvas .= '
            <li class="accordion menu-item" id="' . $accordionId . '">
              <div class="accordion-item border-0">
                <h2 class="accordion-header">
                  <button
                    class="accordion-button collapsed custom-accordion-btn"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#' . $collapseId . '"
                  >
                    ' . $menuRow->name . '
                  </button>
                </h2>
                <div id="' . $collapseId . '" class="accordion-collapse collapse">
                  <div class="accordion-body p-0">
                    <ul class="submenu list-unstyled">';
            foreach ($menusubRec as $menusubRow):
                $res_offcanvas .= '<li>' . $menusubRow->name . '</li>';
            endforeach;
            $res_offcanvas .= '
                    </ul>
                  </div>
                </div>
              </div>
            </li>';
        else:
            $res_offcanvas .= '<li class="menu-item">' . $menuRow->name . '</li>';
        endif;
    endforeach;
    $res_offcanvas .= '</ul>';
endif;

$jVars['module:offcanvas-menu'] = $res_offcanvas;


//Footer Menu
$result1 = '';
$FmenuRec = Menu::getMenuByParent(0, 2);
if ($FmenuRec):

    foreach ($FmenuRec as $FmenuRow):
        $result1 .= '<li>';
        $result1 .= getMenuList($FmenuRow->name, $FmenuRow->linksrc, $FmenuRow->linktype, 'parent');
        //		   $subRec = Menu::getMenuByParent($FmenuRow->id,2);
        $result1 .= '</li>';
    endforeach;
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