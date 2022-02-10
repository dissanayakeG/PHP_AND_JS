<?php
$flat = [
    ['id' => 1, 'parent_id' => 0, 'name' => 'root1'],
    ['id' => 2, 'parent_id' => 0, 'name' => 'root1'],

    ['id' => 3, 'parent_id' => 1, 'name' => 'ch-1'],
    ['id' => 4, 'parent_id' => 1, 'name' => 'ch-1'],

    ['id' => 5, 'parent_id' => 3, 'name' => 'ch-1-1'],
    ['id' => 6, 'parent_id' => 3, 'name' => 'ch-1-1'],

    ['id' => 7, 'parent_id' => 0, 'name' => 'root2'],
    ['id' => 8, 'parent_id' => 0, 'name' => 'root2'],

    ['id' => 9, 'parent_id' => 7, 'name' => 'ch3-1'],
    ['id' => 10, 'parent_id' => 7, 'name' => 'ch3-1']
];


$tree = buildTree($flat);

function buildTree(array $flat)
{
    $grouped = [];
    foreach ($flat as $node) {
        $grouped[$node['parent_id']][] = $node;
    }

    $fnBuilder = function ($siblings) use (&$fnBuilder, $grouped) {
        foreach ($siblings as $k => $sibling) {
            $id = $sibling['id'];
            if (isset($grouped[$id])) {
                $sibling['children'] = $fnBuilder($grouped[$id]);
            }
            $siblings[$k] = $sibling;
        }
        return $siblings;
    };
    return $fnBuilder($grouped[0]);
}

$groupd = groupedTree($tree);

echo json_encode($groupd, JSON_PRETTY_PRINT);


function groupedTree($tree)
{
    $groupedByFuncTableName = array_reduce($tree, function (array $accumulator, array $element) {
        if (isset($element['children'])) {
            $element['children'] = groupedTree($element['children']);
        }
        $accumulator[$element['name']][] = $element;

        return $accumulator;
    }, []);
    return $groupedByFuncTableName;
}
