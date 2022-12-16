<?php

function optionSelected($value, $value2)
{
    return $value == $value2 ? 'selected' : null;
}

function menuItem($name, $route, $icon = "")
{
    $class = url_is(implode("/", $route) . "*") ? "active" : "";
    $href = site_url($route);
    $icon = empty($icon) ? "" : " <i class=\"fas fa-$icon\"></i>";

    return "
        <li class=\"$class\">
            <a class=\"nav-link\" href=\"$href\">
            $icon
            <span>$name</span>
            </a>
        </li>
    ";
}

function dropdownMenu($name, $icon = "", $items = [])
{
    $class = "";
    $menuItems = "";
    foreach ($items as $item) {
        if (url_is(implode("/", $item['route']) . "*")) {
            $class = "active";
        }

        $menuItems .= menuItem($item['name'], $item['route'], isset($item['icon']) ? $item['icon'] : null);
    }
    $icon = empty($icon) ? "" : " <i class=\"fas fa-$icon\"></i>";
    $class .= " nav-item dropdown";

    return "
        <li class=\"$class\">
            <a href=\"#\" class=\"nav-link has-dropdown\">
                $icon
                <span>$name</span>
            </a>
            <ul class=\"dropdown-menu\">
                $menuItems
            </ul>
        </li>
    ";
}
