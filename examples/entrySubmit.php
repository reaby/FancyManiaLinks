<?php

// Include FML
require_once __DIR__ . '/../autoload.php';

// Create manialink
$maniaLink = new \FML\ManiaLink();

// Create entry element to allow input
$entry = new \FML\Controls\Entry();
$maniaLink->add($entry);
$entry->setSize(50, 7);
$entry->setName('input');
$entry->setAutoComplete(true);

// Add submit feature
$entry->addSubmitFeature('fancyml?entrysubmit');

// Display input if any is given
if (!empty($_GET['input'])) {
	$outputLabel = new \FML\Controls\Label();
	$maniaLink->add($outputLabel);
	$outputLabel->setY(-30);
	$outputLabel->setText("Your Input: '{$_GET['input']}'");
}

// Print xml
$maniaLink->render(true);
