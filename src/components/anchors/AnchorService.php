<?php
namespace deflou\components\anchors;

use deflou\interfaces\anchors\IAnchorService;
use extas\components\Item;
use extas\interfaces\repositories\IRepository;

/**
 * @method IRepository anchors()
 */
class AnchorService extends Item implements IAnchorService
{
    public function createEventAnchor(string $instanceId, string $eventName, int $expiredAt = 0): string
    {
        $anchor = $this->anchors()->create(new Anchor([
            Anchor::FIELD__INSTANCE_ID => $instanceId,
            Anchor::FIELD__EVENT_NAME => $eventName,
            Anchor::FIELD__EXPIRED_AT => $expiredAt,
            Anchor::FIELD__TYPE => EAnchor::Event->value,
            Anchor::FIELD__KEY => EAnchor::Event->generateKey()
        ]));

        return $anchor->getKey();
    }

    public function createTriggerAnchor(string $triggerId, int $expiredAt = 0): string
    {
        $anchor = $this->anchors()->create(new Anchor([
            Anchor::FIELD__TRIGGER_ID => $triggerId,
            Anchor::FIELD__EXPIRED_AT => $expiredAt,
            Anchor::FIELD__TYPE => EAnchor::Trigger->value,
            Anchor::FIELD__KEY => EAnchor::Trigger->generateKey()
        ]));

        return $anchor->getKey();
    }

    public function createPersonalAnchor(string $triggerId, string $playerName, int $expiredAt = 0): string
    {
        $anchor = $this->anchors()->create(new Anchor([
            Anchor::FIELD__TRIGGER_ID => $triggerId,
            Anchor::FIELD__PLAYER_NAME => $playerName,
            Anchor::FIELD__EXPIRED_AT => $expiredAt,
            Anchor::FIELD__TYPE => EAnchor::Personal->value,
            Anchor::FIELD__KEY => EAnchor::Personal->generateKey()
        ]));

        return $anchor->getKey();
    }

    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
