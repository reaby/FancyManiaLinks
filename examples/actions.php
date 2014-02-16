<?php

// Include FML
require_once __DIR__ . '/../FML/autoload.php';

// Create manialink
$maniaLink = new \FML\ManiaLink();

// Static action
$homeLabel = new \FML\Controls\Label();
$maniaLink->add($homeLabel);
$homeLabel->setX(-10);
$homeLabel->setText('Home');
$homeLabel->setAction(\FML\Types\Actionable::ACTION_HOME);

// Dynamic action triggering
$enterLabel = new \FML\Controls\Label();
$maniaLink->add($enterLabel);
$enterLabel->setX(10);
$enterLabel->setText('Enter');
$maniaLink->getScript()->addPageActionTrigger($enterLabel, \FML\Types\Actionable::ACTION_ENTER);

// Print xml
$maniaLink->render(true);