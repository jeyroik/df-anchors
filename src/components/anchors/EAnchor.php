<?php
namespace deflou\components\anchors;

use Ramsey\Uuid\Uuid;

enum EAnchor: string
{
    case Trigger = 'tl';
    case Personal = 'pl';
    case Event = 'el';

    public function generateKey(): string
    {
        return $this->value . Uuid::uuid4()->toString();
    }
}
