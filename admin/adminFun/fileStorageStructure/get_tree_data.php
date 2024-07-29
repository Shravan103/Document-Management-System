<?php
function getTreeData($dir) {
    $result = [];
    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }
        $path = $dir . DIRECTORY_SEPARATOR . $item;
        $node = [
            'text' => $item,
            'id' => $path,
            'icon' => is_dir($path) ? 'fa fa-folder' : 'fa fa-file',
            'li_attr' => [
                'class' => is_dir($path) ? 'folder-node' : 'file-node' // Add class for styling
            ],
            'state' => [
                'selected' => false // Add for checkbox functionality
            ]
        ];
        if (is_dir($path)) {
            $node['children'] = getTreeData($path);
        }
        $result[] = $node;
    }
    return $result;
}

$directory = '/xampp/htdocs/dms/filesTemp';
header('Content-Type: application/json');
echo json_encode(getTreeData($directory));
?>
