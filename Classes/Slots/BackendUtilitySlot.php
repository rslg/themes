<?php
namespace KayStrobach\Themes\Slots;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * This class automatically adds the theme TSConfig for the current page
 * to the Page TSConfig either by using a signal slot.
 */
class BackendUtilitySlot extends \TYPO3\CMS\Backend\Configuration\TsConfigParser {

	/**
	 * Retrieves the theme TSConfig for the given page.
	 *
	 * @param $TSdataArray
	 * @param int $pageUid
	 * @param $rootLine
	 * @param $returnPartArray
	 * @return string The found TSConfig or an empty string.
	 */
	public function getPagesTSconfigPreInclude($TSdataArray, $pageUid, $rootLine, $returnPartArray) {

		$pageUid = (int)$pageUid;

		if ($pageUid === 0) {
			return NULL;
		}

		/** @var \KayStrobach\Themes\Domain\Repository\ThemeRepository $themeRepository */
		$themeRepository = GeneralUtility::makeInstance('KayStrobach\Themes\\Domain\\Repository\\ThemeRepository');
		$theme = $themeRepository->findByPageOrRootline($pageUid);

		if (!isset($theme)) {
			return '';
		}

		array_unshift($TSdataArray, $theme->getTSConfig());

		return array(
			$TSdataArray,
			$pageUid,
			$rootLine,
			$returnPartArray
		);
	}
}
