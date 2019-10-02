<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
//CAjax::Init();
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Page\Asset;
Asset::getInstance()->addCss("https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css");
Asset::getInstance()->addCss("https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css");
Asset::getInstance()->addJs("https://code.jquery.com/jquery-1.9.1.min.js");
Asset::getInstance()->addJs("https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js");
Asset::getInstance()->addJs("https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js");
if( !Loader::includeModule("disk") ) {
   throw new \Exception('Не загружены модули необходимые для работы компонента');
}
$arResult["GROUP_ID"] = $arParams["GROUP_ID"];
$arResult["FOLDER_ITEM"] = array();

$rsStorage = \Bitrix\Disk\Storage::getList(
  array('filter' => array(
        "ENTITY_ID" => $arResult["GROUP_ID"],
        "ENTITY_TYPE" => 'Bitrix\\Disk\\ProxyType\\Group'
        )
  )
);
if($arStorage = $rsStorage->Fetch())
{
  $urlManager = \Bitrix\Disk\Driver::getInstance()->getUrlManager();

  if($_POST["folderid"]){
    $folder = \Bitrix\Disk\Folder::getByID($_POST["folderid"]);
  }else{
    $folder = \Bitrix\Disk\Folder::getByID($arStorage['ROOT_OBJECT_ID']);
  }
  if($folder){
    $folderCnt = 0;
    $children = array();
    $childrenRows = \Bitrix\Disk\Internals\FolderTable::getChildren($folder->getRealObjectId(), $parameters);
    foreach ($childrenRows as $childrenRow):
      $children[$folderCnt] = $childrenRow;
      $url = $urlManager->getUrlFocusController('openFileDetail', array('fileId' => $childrenRow["REAL_OBJECT_ID"]));
      $children[$folderCnt]["THIS_URL"] = $url;

      $iFileId = $childrenRow["REAL_OBJECT_ID"];
      $file = \Bitrix\Disk\File::loadById($iFileId);
      if ( !is_object($file) )
      {

      }else{
        $urlManager = \Bitrix\Disk\Driver::getInstance()->getUrlManager();
        $children[$folderCnt]["THIS_URL_DOWNLOAD"] = $urlManager->getUrlForDownloadFile($file);
        $children[$folderCnt]["THIS_ATTR"] = $viewerDataAttr = \Bitrix\Disk\Ui\Viewer::getAttributesByObject($file);
      }


      $folderCnt++;
    endforeach;
  }
  $folderCnt = 0;
  foreach($children as $item):
    $arResult["FOLDER_ITEM"][$folderCnt] = $item;
    $folderCnt++;
  endforeach;
}
$this->IncludeComponentTemplate();
