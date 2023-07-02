<?php
namespace deflou\components\plugins\anchors;

use deflou\components\anchors\AnchorService;
use deflou\interfaces\triggers\ITrigger;
use extas\components\plugins\Plugin;
use extas\interfaces\IItem;
use extas\interfaces\repositories\IRepository;
use extas\interfaces\stages\IStageCreateAfter;

class PluginTriggerCreateAfter extends Plugin implements IStageCreateAfter
{
    /**
     * Create trigger-anchor and personal-acnhor for triggers.
     *
     * @param  IItem|ITrigger            $createdItem
     * @param  IItem            $sourceItem
     * @param  IRepository|null $repository
     * @return void
     */
    public function __invoke(IItem &$createdItem, IItem $sourceItem, ?IRepository $repository = null): void
    {
        $anchorService = new AnchorService();
        $anchorService->createTriggerAnchor($createdItem->getId(), 0);
        $anchorService->createPersonalAnchor($createdItem->getId(), $createdItem->buildVendor()->getName(), 0);
    }
}
