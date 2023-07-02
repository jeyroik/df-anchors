<?php

use extas\components\repositories\RepoItem;

return [
    "name" => "jeyroik/df-achors",
    "tables" => [
        "anchors" => [
            "namespace" => "deflou\\repositories",
            "item_class" => "deflou\\components\\anchors\\Anchor",
            "pk" => "id",
            "aliases" => ["anchors"],
            "code" => [
                'create-before' => '\\' . RepoItem::class . '::setId($item);'
            ]
        ]
    ]
];
