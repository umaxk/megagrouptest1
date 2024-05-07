<?php
header('Content-Type: application/json; charset=utf-8');

/**
 * 
 * Вариант решения с классом 
 * Зачем?
 * - проще модифицировать код
 * - можно добавить тесты 
 * - напрашивается с ходу функция которая обрабатывает исключения
 * 
 */
final class convertCsvToTreeNoRecursion {
    public $product;

    function __construct(string $file) {
        $this->product = $this->loadCsv($file);
    }

    private function loadCsv($file):array {
        $file = file($file, FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES);
        $headers = str_getcsv(array_shift($file), ','); 

        foreach ($file as $line) {
            $products[] = array_combine(
                $headers,
                str_getcsv($line, ','),
            );
        }

        usort($products, function($a, $b){
            return ($a['parent_id'] - $b['parent_id']);
        });

        return $products;
    }

    public function convert():array {
        $list = [];
        $listIndex = [];

        foreach ($this->product as $val) {
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

        return $list;
    }

}

$csv = new convertCsvToTreeNoRecursion('e.csv');
echo json_encode($csv->convert());