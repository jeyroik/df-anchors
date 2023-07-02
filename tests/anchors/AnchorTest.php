<?php

use deflou\components\anchors\AnchorService;
use deflou\components\anchors\EAnchor;
use deflou\components\applications\AppWriter;
use deflou\components\instances\InstanceService;
use deflou\components\triggers\TriggerService;
use deflou\interfaces\anchors\IAnchor;
use deflou\interfaces\extensions\anchors\IExtensionTriggerAnchor;
use deflou\interfaces\triggers\events\ITriggerEvent;
use deflou\interfaces\triggers\ITrigger;
use tests\ExtasTestCase;

class AnchorTest extends ExtasTestCase
{
    protected array $libsToInstall = [
        'jeyroik/df-triggers' => ['php', 'php'],
        'jeyroik/df-applications' => ['php', 'json'],
        'jeyroik/extas-conditions' => ['php', 'json'],
        '' => ['php', 'php']
        //'vendor/lib' => ['php', 'json'] storage ext, extas ext
    ];
    protected bool $isNeedInstallLibsItems = true;
    protected string $testPath = __DIR__;

    public function testCreateAnchorAfterTriggerCreated()
    {
        $appService = new AppWriter();
        $app = $appService->createAppByConfigPath(__DIR__ . '/../resources/app.json', true);

        $instanceService = new InstanceService();
        $instance = $instanceService->createInstanceFromApplication($app, 'test-anchor');

        $triggerService = new TriggerService();
        
        /**
         * @var ITrigger|IExtensionTriggerAnchor $trigger
         */
        $trigger = $triggerService->createTriggerForInstance($instance, 'test_anchor');
        $trigger->setEvent([
            ITriggerEvent::FIELD__NAME => 'test_anchor_event'
        ]);

        $anchorService = new AnchorService();
        $anchorService->createEventAnchor($instance->getId(), 'test_anchor_event');

        $anchors = $trigger->getAnchors();

        $this->assertCount(3, $anchors);

        $typesIndex = 0;

        /**
         * @var IAnchor $eventAnchor
         */
        $eventAnchor = null;
        $triggerAnchor = null;
        $personalAnchor = null;

        foreach ($anchors as $anchor) {
            if ($anchor->buildType() == EAnchor::Event) {
                $typesIndex++;
                $this->assertFalse($anchor->isExpired());
                $this->assertEquals('test_anchor_event', $anchor->getEventName());
                $eventAnchor = $anchor;
                continue;
            }

            if ($anchor->buildType() == EAnchor::Trigger) {
                $typesIndex += 3;
                $triggerAnchor = $anchor->getKey();
                continue;
            }

            if ($anchor->buildType() == EAnchor::Personal) {
                $typesIndex += 5;
                $personalAnchor = $anchor->getKey();
                continue;
            }
        }

        $this->assertEquals($typesIndex, 9);

        $rebuilt = $trigger->rebuildTriggerAnchor(time() + 86400);
        $this->assertNotEquals($triggerAnchor, $rebuilt);

        $rebuilt = $trigger->rebuildPersonalAnchor(time() + 86400);
        $this->assertNotEquals($personalAnchor, $rebuilt);

        $eventAnchor->setEventName('other_anchor_event');
        $anchorService->anchors()->update($eventAnchor);

        $anchors = $trigger->getAnchors();

        $this->assertCount(2, $anchors);//missed event anchor, cause event_name changed to other_anchor_event

        foreach ($anchors as $anchor) {
            $this->assertFalse($anchor->isExpired());
        }
    }
}
