<?php
namespace deflou\components\extensions\anchors;

use deflou\components\anchors\AnchorService;
use deflou\components\anchors\EAnchor;
use deflou\components\triggers\ETrigger;
use deflou\interfaces\anchors\IAnchor;
use deflou\interfaces\extensions\anchors\IExtensionTriggerAnchor;
use deflou\interfaces\triggers\ITrigger;
use extas\components\exceptions\MissedOrUnknown;
use extas\components\extensions\Extension;

class ExtensionTriggerAnchor extends Extension implements IExtensionTriggerAnchor
{
    public function getAnchors(ITrigger &$trigger = null): array
    {
        $instanceId = $trigger->getInstanceId(ETrigger::Event);
        $eventName = $trigger->buildEvent()->getName();

        $anchorService = new AnchorService();

        $eventAnchor = $anchorService->anchors()->one([
            IAnchor::FIELD__INSTANCE_ID => $instanceId,
            IAnchor::FIELD__EVENT_NAME => $eventName
        ]);

        // get trigger-anchor and personal-anchors
        $triggersAnchors = $anchorService->anchors()->all([
            IAnchor::FIELD__TRIGGER_ID => $trigger->getId()
        ]);

        if ($eventAnchor) {
            $triggersAnchors[] = $eventAnchor;
        }

        return $triggersAnchors;
    }

    public function rebuildTriggerAnchor(int $expiredAt, ITrigger &$trigger = null): string
    {
        $anchorService = new AnchorService();

        /**
         * @var IAnchor $triggerAnchor
         */
        $triggerAnchor = $anchorService->anchors()->one([
            IAnchor::FIELD__TRIGGER_ID => $trigger->getId(),
            IAnchor::FIELD__TYPE => EAnchor::Trigger->value
        ]);

        if (!$triggerAnchor) {
            throw new MissedOrUnknown('trigger-anchor for trigger #' . $trigger->getId());
        }

        $triggerAnchor->setKey(EAnchor::Trigger->generateKey());
        $anchorService->anchors()->update($triggerAnchor);

        return $triggerAnchor->getKey();
    }

    public function rebuildPersonalAnchor(int $expiredAt,ITrigger &$trigger = null): string
    {
        $anchorService = new AnchorService();

        /**
         * @var IAnchor $triggerAnchor
         */
        $triggerAnchor = $anchorService->anchors()->one([
            IAnchor::FIELD__TRIGGER_ID => $trigger->getId(),
            IAnchor::FIELD__PLAYER_NAME => $trigger->buildVendor()->getName(),
            IAnchor::FIELD__TYPE => EAnchor::Personal->value
        ]);

        if (!$triggerAnchor) {
            throw new MissedOrUnknown('personal-anchor for trigger #' . $trigger->getId());
        }

        $triggerAnchor->setKey(EAnchor::Personal->generateKey());
        $anchorService->anchors()->update($triggerAnchor);

        return $triggerAnchor->getKey();
    }
}
