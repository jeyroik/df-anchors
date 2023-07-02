<?php
namespace deflou\components\anchors;

use deflou\components\instances\THasInstance;
use deflou\components\triggers\THasTrigger;
use deflou\interfaces\anchors\IAnchor;
use extas\components\Item;
use extas\components\players\THasPlayer;
use extas\components\THasCreatedAt;
use extas\components\THasStringId;
use extas\components\THasType;

class Anchor extends Item implements IAnchor
{
    use THasStringId;
    use THasInstance;
    use THasTrigger;
    use THasPlayer;
    use THasType;
    use THasCreatedAt;

    public function getEventName(): string
    {
        return $this->config[static::FIELD__EVENT_NAME] ?? '';
    }

    public function getExpiredAt(): int
    {
        return $this->config[static::FIELD__EXPIRED_AT] ?? 0;
    }

    public function getKey(): string
    {
        return $this->config[static::FIELD__KEY] ?? '';
    }

    public function isExpired(): bool
    {
        $expiredAt = $this->getExpiredAt();

        if (!$expiredAt) { // endless anchor
            return false;
        }

        return time() >= $expiredAt;
    }

    public function setEventName(string $eventName): static
    {
        $this[static::FIELD__EVENT_NAME] = $eventName;

        return $this;
    }

    public function setExpiredAt(int $expiredAt): static
    {
        $this[static::FIELD__EXPIRED_AT] = $expiredAt;

        return $this;
    }

    public function setKey(string $key): static
    {
        $this[static::FIELD__KEY] = $key;

        return $this;
    }

    public function buildType(): EAnchor
    {
        return EAnchor::tryFrom($this->getType());
    }

    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
