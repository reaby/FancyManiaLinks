<?php

namespace FML\Script;

use FML\Controls\Control;
use FML\Types\Scriptable;
use FML\Controls\Label;

/**
 * Class representing the ManiaLink Script
 *
 * @author steeffeen
 */
class Script {
	/**
	 * Constants
	 */
	const CLASS_TOOLTIPS = 'FML_Tooltips';
	const CLASS_MENU = 'FML_Menu';
	const CLASS_MENUBUTTON = 'FML_MenuButton';
	const CLASS_PAGE = 'FML_Page';
	const CLASS_PAGER = 'FML_Pager';
	const CLASS_PAGELABEL = 'FML_PageLabel';
	const CLASS_PROFILE = 'FML_Profile';
	const CLASS_MAPINFO = 'FML_MapInfo';
	const OPTION_TOOLTIP_ONCLICK = 'FML_Tooltip_OnClick';
	const OPTION_TOOLTIP_STAYONCLICK = 'FML_Tooltip_StayOnClick';
	const OPTION_TOOLTIP_INVERT = 'FML_Tooltip_Invert';
	const OPTION_TOOLTIP_TEXT = 'FML_Tooltip_Text';
	const LABEL_ONINIT = 'OnInit';
	const LABEL_LOOP = 'Loop';
	const LABEL_ENTRYSUBMIT = 'EntrySubmit';
	const LABEL_KEYPRESS = 'KeyPress';
	const LABEL_MOUSECLICK = 'MouseClick';
	const LABEL_MOUSEOUT = 'MouseOut';
	const LABEL_MOUSEOVER = 'MouseOver';
	const CONSTANT_TOOLTIPTEXTS = 'C_FML_TooltipTexts';
	
	/**
	 * Protected Properties
	 */
	protected $tagName = 'script';
	protected $constants = array();
	protected $includes = array();
	protected $tooltips = false;
	protected $tooltipTexts = array();
	protected $menus = false;
	protected $pages = false;
	protected $profile = false;
	protected $mapInfo = false;

	/**
	 * Set an Include of the Script
	 *
	 * @param string $namespace
	 * @param string $file
	 * @return \FML\Script\Script
	 */
	public function setInclude($namespace, $file) {
		$this->includes[$namespace] = $file;
		return $this;
	}

	/**
	 * Set a Constant of the Script
	 *
	 * @param string $name
	 * @param string $value
	 * @return \FML\Script\Script
	 */
	public function setConstant($name, $value) {
		$this->constants[$name] = $value;
		return $this;
	}

	/**
	 * Add a Tooltip Behavior
	 *
	 * @param Control $hoverControl The Control that shows the Tooltip
	 * @param Control $tooltipControl The Tooltip to display
	 * @param string $options,... (optional) Unlimited Number of Tooltip Options
	 * @return \FML\Script\Script
	 */
	public function addTooltip(Control $hoverControl, Control $tooltipControl) {
		if (!($hoverControl instanceof Scriptable)) {
			trigger_error('Scriptable Control needed as HoverControl for Tooltips!');
			return $this;
		}
		$tooltipControl->checkId();
		$tooltipControl->setVisible(false);
		$hoverControl->checkId();
		$hoverControl->setScriptEvents(true);
		$hoverControl->addClass(self::CLASS_TOOLTIPS);
		$options = $this->spliceParameters(func_get_args(), 2);
		foreach ($options as $option => $value) {
			$hoverControl->addClass($option);
			if ($option == self::OPTION_TOOLTIP_TEXT) {
				$hoverId = $hoverControl->getId();
				$tooltipId = $tooltipControl->getId();
				if (!isset($this->tooltipTexts[$tooltipId])) {
					$this->tooltipTexts[$tooltipId] = array();
				}
				$this->tooltipTexts[$tooltipId][$hoverId] = $value;
			}
		}
		$this->tooltips = true;
		return $this;
	}

	/**
	 * Add a Menu Behavior
	 *
	 * @param Control $clickControl
	 * @param Control $menuControl
	 * @param string $menuId
	 * @return \FML\Script\Script
	 */
	public function addMenu(Control $clickControl, Control $menuControl, $menuId = null) {
		if (!($clickControl instanceof Scriptable)) {
			trigger_error('Scriptable Control needed as ClickControl for Menus!');
			return $this;
		}
		if (!$menuId) $menuId = '_';
		$menuControl->checkId();
		$menuControl->addClass(self::CLASS_MENU);
		$menuControl->addClass($menuId);
		$clickControl->setScriptEvents(true);
		$clickControl->addClass(self::CLASS_MENUBUTTON);
		$clickControl->addClass($menuId . '-' . $menuControl->getId());
		$this->setInclude('TextLib', 'TextLib');
		$this->menus = true;
		return $this;
	}

	/**
	 * Add a Page for a Paging Behavior
	 *
	 * @param Control $pageControl
	 * @param int $pageNumber
	 * @param string $pagesId
	 * @return \FML\Script\Script
	 */
	public function addPage(Control $pageControl, $pageNumber, $pagesId = null) {
		$pageNumber = (int) $pageNumber;
		if (!$pagesId) $pagesId = '_';
		$pageControl->addClass(self::CLASS_PAGE);
		$pageControl->addClass($pagesId);
		$pageControl->addClass(self::CLASS_PAGE . '-P' . $pageNumber);
		return $this;
	}

	/**
	 * Add a Pager Button for a Paging Behavior
	 *
	 * @param Control $pagerControl
	 * @param int $pagingAction
	 * @param string $pagesId
	 * @return \FML\Script\Script
	 */
	public function addPager(Control $pagerControl, $pagingAction, $pagesId = null) {
		if (!($pagerControl instanceof Scriptable)) {
			trigger_error('Scriptable Control needed as PagerControl for Pages!');
			return $this;
		}
		$pagingAction = (int) $pagingAction;
		if (!$pagesId) $pagesId = '_';
		$pagerControl->setScriptEvents(true);
		$pagerControl->addClass(self::CLASS_PAGER);
		$pagerControl->addClass(self::CLASS_PAGER . '-I' . $pagesId);
		$pagerControl->addClass(self::CLASS_PAGER . '-A' . $pagingAction);
		$this->setInclude('TextLib', 'TextLib');
		$this->pages = true;
		return $this;
	}

	/**
	 * Add a Label that shows the current Page Number
	 *
	 * @param Label $pageLabel
	 * @param string $pagesId
	 * @return \FML\Script\Script
	 */
	public function addPageLabel(Label $pageLabel, $pagesId = null) {
		if (!$pagesId) $pagesId = '_';
		$pageLabel->addClass(self::CLASS_PAGELABEL);
		$pageLabel->addClass($pagesId);
		return $this;
	}

	/**
	 * Add a Button Behavior that will open the Built-In Player Profile
	 *
	 * @param Control $profileControl
	 * @param string $playerLogin
	 * @return \FML\Script\Script
	 */
	public function addProfileButton(Control $profileControl, $playerLogin) {
		if (!($profileControl instanceof Scriptable)) {
			trigger_error('Scriptable Control needed as ClickControl for Profiles!');
			return $this;
		}
		$profileControl->setScriptEvents(true);
		$profileControl->addClass(self::CLASS_PROFILE);
		if ($playerLogin) {
			$profileControl->addClass(self::CLASS_PROFILE . '-' . $playerLogin);
		}
		$this->setInclude('TextLib', 'TextLib');
		$this->profile = true;
		return $this;
	}

	/**
	 * Add a Button Behavior that will open the Built-In Map Info
	 *
	 * @param Control $mapInfoControl
	 * @return \FML\Script\Script
	 */
	public function addMapInfoButton(Control $mapInfoControl) {
		if (!($mapInfoControl instanceof Scriptable)) {
			trigger_error('Scriptable Control needed as ClickControl for Map Info!');
			return $this;
		}
		$mapInfoControl->setScriptEvents(true);
		$mapInfoControl->addClass(self::CLASS_MAPINFO);
		$this->mapInfo = true;
		return $this;
	}

	/**
	 * Create the Script XML Tag
	 *
	 * @param \DOMDocument $domDocument
	 * @return \DOMElement
	 */
	public function render(\DOMDocument $domDocument) {
		$scriptXml = $domDocument->createElement($this->tagName);
		$scriptText = $this->buildScriptText();
		$scriptComment = $domDocument->createComment($scriptText);
		$scriptXml->appendChild($scriptComment);
		return $scriptXml;
	}

	/**
	 * Build the complete Script Text
	 *
	 * @return string
	 */
	private function buildScriptText() {
		$scriptText = "";
		$scriptText .= $this->getHeaderComment();
		$scriptText .= $this->getIncludes();
		$scriptText .= $this->getConstants();
		if ($this->tooltips) $scriptText .= $this->getTooltipLabels();
		if ($this->menus) $scriptText .= $this->getMenuLabels();
		if ($this->pages) $scriptText .= $this->getPagesLabels();
		if ($this->profile) $scriptText .= $this->getProfileLabels();
		if ($this->mapInfo) $scriptText .= $this->getMapInfoLabels();
		$scriptText .= $this->getMainFunction();
		return $scriptText;
	}

	/**
	 * Get the Header Comment
	 *
	 * @return string
	 */
	private function getHeaderComment() {
		$headerComment = file_get_contents(__DIR__ . '/Parts/Header.txt');
		return $headerComment;
	}

	/**
	 * Get the Includes
	 *
	 * @return string
	 */
	private function getIncludes() {
		$includesText = PHP_EOL;
		foreach ($this->includes as $namespace => $file) {
			$includesText .= "#Include \"{$file}\" as {$namespace}" . PHP_EOL;
		}
		return $includesText;
	}

	/**
	 * Get the Constants
	 *
	 * @return string
	 */
	private function getConstants() {
		$this->buildTooltipConstants();
		$constantsText = PHP_EOL;
		foreach ($this->constants as $name => $value) {
			$constantsText .= "#Const {$name} {$value}" . PHP_EOL;
		}
		return $constantsText;
	}

	/**
	 * Build the Constants needed for tooltips
	 */
	private function buildTooltipConstants() {
		$constantText = "[";
		$index = 0;
		$count = count($this->tooltipTexts);
		foreach ($this->tooltipTexts as $tooltipId => $tooltipTexts) {
			$constantText .= "\"{$tooltipId}\" => [";
			$subIndex = 0;
			$subCount = count($tooltipTexts);
			foreach ($tooltipTexts as $hoverId => $text) {
				$constantText .= "\"{$hoverId}\" => \"{$text}\"";
				if ($subIndex < $subCount - 1) $constantText .= ", ";
				$subIndex++;
			}
			$constantText .= "]";
			if ($index < $count - 1) $constantText .= ", ";
			$index++;
		}
		$constantText .= "]";
		$this->setConstant(self::CONSTANT_TOOLTIPTEXTS, $constantText);
	}

	/**
	 * Get the Tooltip Labels
	 *
	 * @return string
	 */
	private function getTooltipLabels() {
		$mouseOverScript = "
if (!Event.Control.HasClass(\"" . self::CLASS_TOOLTIPS . "\")) break;
if (Event.Control.HasClass(\"" . self::OPTION_TOOLTIP_ONCLICK . "\")) break;
declare Invert = Event.Control.HasClass(\"" . self::OPTION_TOOLTIP_INVERT . "\");
foreach (ControlClass in Event.Control.ControlClasses) {
	declare TooltipControl <=> Page.GetFirstChild(ControlClass);
	if (TooltipControl == Null) continue;
	TooltipControl.Visible = !Invert;
}";
		$mouseOutScript = "
if (!Event.Control.HasClass(\"" . self::CLASS_TOOLTIPS . "\")) break;
declare FML_Clicked for Event.Control = False;
declare StayOnClick = Event.Control.HasClass(\"" . self::OPTION_TOOLTIP_STAYONCLICK . "\");
if (StayOnClick && FML_Clicked) break;
declare Invert = Event.Control.HasClass(\"" . self::OPTION_TOOLTIP_INVERT . "\");
foreach (ControlClass in Event.Control.ControlClasses) {
	declare TooltipControl <=> Page.GetFirstChild(ControlClass);
	if (TooltipControl == Null) continue;
	TooltipControl.Visible = Invert;
}";
		$mouseClickScript = "
if (!Event.Control.HasClass(\"" . self::CLASS_TOOLTIPS . "\")) break;
declare Show = False;
declare OnClick = Event.Control.HasClass(\"" . self::OPTION_TOOLTIP_ONCLICK . "\");
if (OnClick) {
	Show = !Event.Control.Visible;
} else {
	declare StayOnClick = Event.Control.HasClass(\"" . self::OPTION_TOOLTIP_STAYONCLICK . "\");
	if (StayOnClick) {
		declare FML_Clicked for Event.Control = False;
		FML_Clicked = !FML_Clicked;
		if (FML_Clicked) break;
		Show = False;
	} else {
		break;
	}
}
declare Invert = Event.Control.HasClass(\"" . self::OPTION_TOOLTIP_INVERT . "\");
foreach (ControlClass in Event.Control.ControlClasses) {
	declare TooltipControl <=> Page.GetFirstChild(ControlClass);
	if (TooltipControl == Null) continue;
	TooltipControl.Visible = Show && !Invert;
}";
		$tooltipsLabels = Builder::getLabelImplementationBlock(self::LABEL_MOUSEOVER, $mouseOverScript);
		$tooltipsLabels .= Builder::getLabelImplementationBlock(self::LABEL_MOUSEOUT, $mouseOutScript);
		$tooltipsLabels .= Builder::getLabelImplementationBlock(self::LABEL_MOUSECLICK, $mouseClickScript);
		return $tooltipsLabels;
	}

	/**
	 * Get the Menu Labels
	 *
	 * @return string
	 */
	private function getMenuLabels() {
		$mouseClickScript = "
if (Event.Control.HasClass(\"" . self::CLASS_MENUBUTTON . "\")) {
	declare Text MenuIdClass;
	declare Text MenuControlId;
	foreach (ControlClass in Event.Control.ControlClasses) {
		declare ClassParts = TextLib::Split(\"-\", ControlClass);
		if (ClassParts.count <= 1) continue;
		MenuIdClass = ClassParts[0];
		MenuControlId = ClassParts[1];
		break;
	}
	Page.GetClassChildren(MenuIdClass, Page.MainFrame, True);
	foreach (MenuControl in Page.GetClassChildren_Result) {
		if (!MenuControl.HasClass(\"" . self::CLASS_MENU . "\")) continue;
		if (MenuControlId != MenuControl.ControlId) {
			MenuControl.Hide();
		} else {
			MenuControl.Show();
		}
	}
}";
		$menuLabels = Builder::getLabelImplementationBlock(self::LABEL_MOUSECLICK, $mouseClickScript);
		return $menuLabels;
	}

	/**
	 * Get the Pages Labels
	 *
	 * @return string
	 */
	private function getPagesLabels() {
		$pagesNumberPrefix = self::CLASS_PAGE . '-P';
		$pagesNumberPrefixLength = strlen($pagesNumberPrefix);
		$pagesScript = "
if (Event.Control.HasClass(\"" . self::CLASS_PAGER . "\")) {
	declare Text PagesId;
	declare Integer PagingAction;
	foreach (ControlClass in Event.Control.ControlClasses) {
		declare ClassParts = TextLib::Split(\"-\", ControlClass);
		if (ClassParts.count <= 1) continue;
		if (ClassParts[0] != \"" . self::CLASS_PAGER . "\") continue;
		switch (TextLib::SubText(ClassParts[1], 0, 1)) {
			case \"I\": {
				PagesId = TextLib::SubText(ClassParts[1], 1, 99);
			}
			case \"A\": {
				PagingAction = TextLib::ToInteger(TextLib::SubText(ClassParts[1], 1, 99));
			}
		}
	}
	declare FML_PagesLastScriptStart for This = FML_ScriptStart;
	declare FML_MinPageNumber for This = Integer[Text];
	declare FML_MaxPageNumber for This = Integer[Text];
	declare FML_PageNumber for This = Integer[Text];
	if (FML_PagesLastScriptStart != FML_ScriptStart || !FML_PageNumber.existskey(PagesId) || !FML_MinPageNumber.existskey(PagesId) || !FML_MaxPageNumber.existskey(PagesId)) {
		Page.GetClassChildren(PagesId, Page.MainFrame, True);
		foreach (PageControl in Page.GetClassChildren_Result) {
			if (!PageControl.HasClass(\"" . self::CLASS_PAGE . "\")) continue;
			foreach (ControlClass in PageControl.ControlClasses) {
				if (TextLib::SubText(ControlClass, 0, {$pagesNumberPrefixLength}) != \"{$pagesNumberPrefix}\") continue;
				declare PageNumber = TextLib::ToInteger(TextLib::SubText(ControlClass, {$pagesNumberPrefixLength}, 99));
				if (!FML_MinPageNumber.existskey(PagesId) || PageNumber < FML_MinPageNumber[PagesId]) {
					FML_MinPageNumber[PagesId] = PageNumber;
				}
				if (!FML_MaxPageNumber.existskey(PagesId) || PageNumber > FML_MaxPageNumber[PagesId]) {
					FML_MaxPageNumber[PagesId] = PageNumber;
				}
				break;
			}
		}
		FML_PageNumber[PagesId] = FML_MinPageNumber[PagesId];
	}
	FML_PageNumber[PagesId] += PagingAction;
	if (FML_PageNumber[PagesId] < FML_MinPageNumber[PagesId]) {
		FML_PageNumber[PagesId] = FML_MinPageNumber[PagesId];
	}
	if (FML_PageNumber[PagesId] > FML_MaxPageNumber[PagesId]) {
		FML_PageNumber[PagesId] = FML_MaxPageNumber[PagesId];
	}
	FML_PagesLastScriptStart = FML_ScriptStart;
	Page.GetClassChildren(PagesId, Page.MainFrame, True);
	foreach (PageControl in Page.GetClassChildren_Result) {
		if (!PageControl.HasClass(\"" . self::CLASS_PAGE . "\")) continue;
		declare PageNumber = -1;
		foreach (ControlClass in PageControl.ControlClasses) {
			if (TextLib::SubText(ControlClass, 0, {$pagesNumberPrefixLength}) != \"{$pagesNumberPrefix}\") continue;
			PageNumber = TextLib::ToInteger(TextLib::SubText(ControlClass, {$pagesNumberPrefixLength}, 99));
			break;
		}
		if (PageNumber != FML_PageNumber[PagesId]) {
			PageControl.Hide();
		} else {
			PageControl.Show();
		}
	}
	Page.GetClassChildren(\"" . self::CLASS_PAGELABEL . "\", Page.MainFrame, True);
	foreach (PageControl in Page.GetClassChildren_Result) {
		if (!PageControl.HasClass(PagesId)) continue;
		declare PageLabel <=> (PageControl as CMlLabel);
		PageLabel.Value = FML_PageNumber[PagesId]^\"/\"^FML_MaxPageNumber[PagesId];
	}
}";
		$pagesLabels = Builder::getLabelImplementationBlock(self::LABEL_MOUSECLICK, $pagesScript);
		return $pagesLabels;
	}

	/**
	 * Get the Profile Labels
	 *
	 * @return string
	 */
	private function getProfileLabels() {
		$profileScript = "
if (Event.Control.HasClass(\"" . self::CLASS_PROFILE . "\")) {
	declare Login = LocalUser.Login;
	foreach (ControlClass in Event.Control.ControlClasses) {
		declare ClassParts = TextLib::Split(\"-\", ControlClass);
		if (ClassParts.count <= 1) continue;
		if (ClassParts[0] != \"" . self::CLASS_PROFILE . "\") continue;
		Login = ClassParts[1];
		break;
	}
	ShowProfile(Login);
}";
		$profileLabels = Builder::getLabelImplementationBlock(self::LABEL_MOUSECLICK, $profileScript);
		return $profileLabels;
	}

	/**
	 * Get the Map Info Labels
	 *
	 * @return string
	 */
	private function getMapInfoLabels() {
		$mapInfoScript = "
if (Event.Control.HasClass(\"" . self::CLASS_MAPINFO . "\")) {
	ShowCurChallengeCard();
}";
		$mapInfoLabels = Builder::getLabelImplementationBlock(self::LABEL_MOUSECLICK, $mapInfoScript);
		return $mapInfoLabels;
	}

	/**
	 * Get the Main Function
	 *
	 * @return string
	 */
	private function getMainFunction() {
		$mainFunction = file_get_contents(__DIR__ . '/Parts/Main.txt');
		return $mainFunction;
	}

	/**
	 * Return the Array of additional optional Parameters
	 *
	 * @param array $args
	 * @param int $offset
	 * @return array
	 */
	private function spliceParameters(array $params, $offset) {
		$args = array_splice($params, $offset);
		if (!$args) return $args;
		$parameters = array();
		foreach ($args as $arg) {
			if (is_array($arg)) {
				foreach ($arg as $key => $value) {
					$parameters[$key] = $value;
				}
			}
			else {
				$parameters[$arg] = true;
			}
		}
		return $parameters;
	}
}
