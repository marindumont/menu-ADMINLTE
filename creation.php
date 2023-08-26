<?php
if (isset($_POST['generate'])) {
    $label = $_POST['label'];
    $iconName = $_POST['icon'];
    $iconClass = "fas fa-" . $iconName;
    $link = $_POST['link'];
    $subItems = $_POST['subItems'];

    $subItemsArray = array();
    if (!empty($subItems)) {
        $subItemsArray = explode(',', $subItems);
        foreach ($subItemsArray as &$subItem) {
            $subItem = trim($subItem);
        }
    }

    $menuItem = array(
        'label' => $label,
        'icon' => $iconClass,
        'link' => $link,
        'subItems' => array()
    );

    foreach ($subItemsArray as $subItemLabel) {
        $menuItem['subItems'][] = array('label' => $subItemLabel, 'icon' => 'far fa-circle', 'link' => '#');
    }

    // Generate the menu code
    $menuCode = generateMenuCode($menuItem);

    // Generate the complete HTML page with required styles
    $completeHTML = generateCompleteHTML($menuCode);

    // Write the generated HTML to a file named menu.php
    file_put_contents('menu.php', $completeHTML);

    echo '<p>Le code du menu a été enregistré dans le fichier menu.php.</p>';
}

function generateMenuCode($menu) {
    $code = '<ul class="sidebar-menu">';
    $code .= '<li class="treeview"><a href="' . $menu['link'] . '"><i class="' . $menu['icon'] . '"></i> <span>' . $menu['label'] . '</span></a>';
    if (!empty($menu['subItems'])) {
        $code .= '<ul class="treeview-menu">';
        foreach ($menu['subItems'] as $subItem) {
            $code .= '<li><a href="' . $subItem['link'] . '"><i class="' . $subItem['icon'] . '"></i> ' . $subItem['label'] . '</a></li>';
        }
        $code .= '</ul>';
    }
    $code .= '</li>';
    $code .= '</ul>';
    return $code;
}

function generateCompleteHTML($menuCode) {
    $styles = '
    <link rel="stylesheet" href="../dist/css/styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    ';
    
    $html = '
    <!DOCTYPE html>
    <html>
    <head>
        <title>Menu Généré</title>
        ' . $styles . '
    </head>
    <body>
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            ' . $menuCode . '
        </aside>
    </body>
    </html>
    ';
    
    return $html;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Générateur de Menu</title>
</head>
<body>
    <h1>Générateur de Menu</h1>
    <form method="post" action="">
        <label for="label">Label :</label>
        <input type="text" name="label" required><br><br>
        
        <label for="icon">Icône :</label>
        <input type="text" name="icon" required><br><br>
        
        <label for="link">Lien :</label>
        <input type="text" name="link" required><br><br>
        
        <label for="subItems">Sous-éléments (séparés par des virgules) :</label>
        <input type="text" name="subItems"><br><br>
        
        <input type="submit" name="generate" value="Générer le Menu">
    </form>
</body>
</html>
