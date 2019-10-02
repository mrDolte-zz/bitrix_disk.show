<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

CJSCore::Init(['viewer']);
$this->setFrameMode(true);
?>


<?if($arResult["FOLDER_ITEM"]):?>
<?
$bxajaxid = CAjax::GetComponentID($component->__name, $component->__template->__name, $component->arParams['AJAX_OPTION_ADDITIONAL']);
?>
<ul class="list-group folder-list">
  <?foreach($arResult["FOLDER_ITEM"] as $folderItem):?>

  <li id="db-items_<?=$folderItem["REAL_OBJECT_ID"];?>" class="folder-list__list-item list-group-item list-group-item-action">

    <div id="disk-viewer_<?=$folderItem["REAL_OBJECT_ID"];?>" data-ajax-id="<?=$bxajaxid?>" <?if(!$folderItem["TYPE_FILE"]):?>data-show-more=""<?endif;?> data-realobjectid="<?=$folderItem["REAL_OBJECT_ID"];?>">
      <?if($folderItem["TYPE_FILE"]):?>
      <a <?//$folderItem["THIS_ATTR"];?> href="<?=$folderItem["THIS_URL"];?>" target="_blank"><?endif;?>
      <i class="fa <?if($folderItem["TYPE_FILE"]):?>fa-file<?else:?>fa-folder<?endif;?>" aria-hidden="true"></i><?=$folderItem["NAME"];?>
      <?if($folderItem["TYPE_FILE"]):?></a><?endif;?>
    </div>

  </li>
<script>
BX.ready(function(){
var obImageView = BX.viewElementBind(
   'db-items_<?=$folderItem["REAL_OBJECT_ID"];?>',
   {showTitle: true, lockScroll: false},
   function(node){
      return BX.type.isElementNode(node) && (node.getAttribute('data-bx-viewer'));
   }
);
});
</script>
  <?endforeach;?>
</ul>
<?endif;?>
