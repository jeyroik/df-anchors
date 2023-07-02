<?php

use deflou\components\extensions\anchors\ExtensionTriggerAnchor;
use deflou\components\plugins\anchors\PluginTriggerCreateAfter;
use deflou\interfaces\extensions\anchors\IExtensionTriggerAnchor;
use deflou\interfaces\triggers\ITrigger;
use extas\interfaces\extensions\IExtension;
use extas\interfaces\plugins\IPlugin;

return [
    "extensions" => [
        [
            IExtension::FIELD__CLASS => ExtensionTriggerAnchor::class,
            IExtension::FIELD__INTERFACE => IExtensionTriggerAnchor::class,
            IExtension::FIELD__SUBJECT => ITrigger::SUBJECT,
            IExtension::FIELD__METHODS => ['getAnchors', 'rebuildTriggerAnchor', 'rebuildPersonalAnchor']
        ]
    ],
    "plugins" => [
        [
            IPlugin::FIELD__CLASS => PluginTriggerCreateAfter::class,
            IPlugin::FIELD__STAGE => ['triggers.create.after']
        ]
    ]
];