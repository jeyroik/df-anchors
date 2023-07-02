<?php
namespace deflou\interfaces\anchors;

use deflou\components\anchors\EAnchor;
use deflou\interfaces\instances\IHaveInstance;
use deflou\interfaces\triggers\IHaveTrigger;
use extas\interfaces\IHasCreatedAt;
use extas\interfaces\IHasType;
use extas\interfaces\IHaveUUID;
use extas\interfaces\IItem;
use extas\interfaces\players\IHavePlayer;

interface IAnchor extends IItem, IHaveUUID, IHasCreatedAt, IHaveInstance, IHasType, IHaveTrigger, IHavePlayer
{
    public const SUBJECT = 'deflou.anchor';

    public const FIELD__EVENT_NAME = 'event_name';
    public const FIELD__EXPIRED_AT = 'expired_at';
    public const FIELD__KEY = 'key';

    public function getEventName(): string;
    public function getExpiredAt(): int;
    public function getKey(): string;

    public function buildType(): EAnchor;
    public function isExpired(): bool;

    public function setEventName(string $eventName): static;
    public function setExpiredAt(int $expiredAt): static;
    public function setKey(string $key): static;
}
