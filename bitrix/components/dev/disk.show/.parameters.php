<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

if( !Loader::includeModule("socialnetwork") ) {
    throw new \Exception('Не загружены модули необходимые для работы компонента');
}

$arGroup = array();
$arSelect = array("ID","NAME");
$arFilter = array("CHECK_PERMISSIONS" => "Y");
$arRes = CSocNetGroup::GetList(array(), $arFilter, false, array(), $arSelect);
while($object = $arRes->GetNext()){

  $arGroup[$object['ID']] = $object['NAME'];
}

$arComponentParameters = array(
  "GROUPS" => array(
    "SETTINGS" => array(
      "NAME" => Loc::getMessage('GROUPS_NAME_PARAMETERS'),
      "SORT" => 100,
    ),
  ),
  "PARAMETERS" => array(

    "GROUP_ID" => array(
      "PARENT" => "SETTINGS",
      "NAME" => Loc::getMessage("GROUP_ID_NAME"),
      "TYPE" => "LIST",
      "VALUES" => $arGroup,
    ),

    "AJAX_MODE" => "Y",

    "SEF_MODE" => array(
      "news" => array(
        "NAME" => Loc::getMessage("SEF_PAGE"),
        "DEFAULT" => "",
        "VARIABLES" => array(),
      ),
      "section" => array(
        "NAME" => Loc::getMessage("SEF_PAGE_SECTION"),
        "DEFAULT" => "",
        "VARIABLES" => array("SECTION_ID"),
      ),
      "detail" => array(
        "NAME" => Loc::getMessage("SEF_PAGE_DETAIL"),
        "DEFAULT" => "#ELEMENT_ID#/",
        "VARIABLES" => array("ELEMENT_ID", "SECTION_ID"),
      ),
    ),

  ),
);
