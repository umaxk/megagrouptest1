<?php
header('Content-Type: application/json; charset=utf-8');
/**
 * 
 */
$csv = file('e.csv', FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES);
$headers = str_getcsv(array_shift($csv), ','); 

foreach ($csv as $line) {
    $products[] = array_combine(
        $headers,
        str_getcsv($line, ','),
    );
}

usort($products, function($a, $b){
    return ($a['parent_id'] - $b['parent_id']);
});

$list = [];
$listIndex = [];

foreach ($products as $val) {
    $elem = ['name' => $val['name']];
    if ($val['parent_id'] == 0) {
        $list[$val['id']] = $elem;
        $listIndex[$val['id']] = &$list[$val['id']];
    } 
    else {
        if (($list[$val['parent_id']]??0) != 0) {
            $list[$val['parent_id']]['children'][$val['id']] = $elem;
            $listIndex[$val['id']] = &$list[$val['parent_id']]['children'][$val['id']];
        }
        else {
            foreach ($listIndex as $key => &$valIndex) {
                if ($key == $val['parent_id']) {
                    if (($valIndex['children']??0) == 0) {
                        $valIndex['children'] = [];
                    }

                    $valIndex['children'][$val['id']] = $elem;
                    $listIndex[$val['id']] = &$valIndex['children'][$val['id']];
                }
            }
        }
    }
}

echo json_encode(
    [
        'data' => $products,
        'result' => $list
    ]
);