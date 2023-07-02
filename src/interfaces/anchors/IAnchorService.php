<?php
namespace deflou\interfaces\anchors;

use extas\interfaces\IItem;

interface IAnchorService extends IItem
{
    public const SUBJECT = 'deflou.anchor.service';

    public function createTriggerAnchor(string $triggerId, int $expiredAt = 0): string;

    public function createEventAnchor(string $instanceId, string $eventName, int $expiredAt = 0): string;

    public function createPersonalAnchor(string $triggerId, string $playerName, int $expiredAt = 0): string;
}
