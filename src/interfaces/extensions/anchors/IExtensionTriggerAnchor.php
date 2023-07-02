<?php
namespace deflou\interfaces\extensions\anchors;

use deflou\interfaces\anchors\IAnchor;

interface IExtensionTriggerAnchor
{
    /**
     * Get all applicable to trigger anchors.
     *
     * @return IAnchor[]
     */
    public function getAnchors(): array;

    public function rebuildTriggerAnchor(int $expiredAt): string;
    public function rebuildPersonalAnchor(int $expiredAt): string;
}
