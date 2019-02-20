<?php

namespace WebSK\Skif\Blocks;

use WebSK\Auth\Auth;
use WebSK\Entity\InterfaceEntity;
use WebSK\Logger\Logger;
use WebSK\Model\ActiveRecord;
use WebSK\Model\FactoryTrait;
use WebSK\Model\InterfaceDelete;
use WebSK\Model\InterfaceFactory;
use WebSK\Model\InterfaceLoad;
use WebSK\Model\InterfaceSave;
use WebSK\DB\DBWrapper;

/**
 * Class Block
 * @package WebSK\Skif\Blocks
 */
class Block implements
    InterfaceLoad,
    InterfaceFactory,
    InterfaceSave,
    InterfaceDelete,
    InterfaceEntity
{
    use ActiveRecord;
    use FactoryTrait;

    const DB_TABLE_NAME = 'blocks';

    const BLOCK_REGION_NONE = -1;

    const BLOCK_NO_CACHE = -1;
    const BLOCK_CACHE_PER_USER = 2;
    const BLOCK_CACHE_PER_PAGE = 4;
    const BLOCK_CACHE_GLOBAL = 8;

    const BLOCK_FORMAT_TYPE_PLAIN = 3;
    const BLOCK_FORMAT_TYPE_HTML = 4;
    const BLOCK_FORMAT_TYPE_PHP = 5;

    protected $id;
    protected $template_id = 1;
    protected $weight = 1;
    protected $page_region_id = self::BLOCK_REGION_NONE;
    protected $pages = '+ ^';
    protected $title = '';
    protected $cache = self::BLOCK_CACHE_GLOBAL;
    protected $body = '';
    protected $format = self::BLOCK_FORMAT_TYPE_PLAIN;

    public static $active_record_ignore_fields_arr = array(
    );

    public function getEditorUrl()
    {
        if (!$this->getId()) {
            return '/admin/blocks/edit/new';
        }

        return '/admin/blocks/edit/' . $this->getId();
    }

    /**
     * Был ли загружен блок
     * @return bool
     */
    public function isLoaded()
    {
        return !empty($this->id);
    }

    /**
     * ID блока
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPageRegionId()
    {
        if ($this->page_region_id == null) {
            return self::BLOCK_REGION_NONE;
        }

        return $this->page_region_id;
    }

    /**
     * @param mixed $page_region_id
     */
    public function setPageRegionId($page_region_id)
    {
        $this->page_region_id = $page_region_id;
    }

    /**
     * Вес блока
     * @return int
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param int $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Содержимое блока
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * Формат блока
     * @return int
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param int $format
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }

    /**
     * Условия видимости для блока
     * @return string
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * @param string $pages
     */
    public function setPages($pages)
    {
        $this->pages = $pages;
    }

    /**
     * @return mixed
     */
    public function getTemplateId()
    {
        return $this->template_id;
    }

    /**
     * @param mixed $template_id
     */
    public function setTemplateId($template_id)
    {
        $this->template_id = $template_id;
    }

    /**
     * Контекст кэширования
     * @return int
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * @param int $cache
     */
    public function setCache($cache)
    {
        $this->cache = $cache;
    }

    public function getBlockRoleIdsArr()
    {
        $query = "SELECT id FROM " . BlockRole::DB_TABLE_NAME . " WHERE block_id = ?";
        $block_role_ids_arr = DBWrapper::readColumn(
            $query,
            array($this->getId())
        );

        return $block_role_ids_arr;
    }

    public function getRoleIdsArr()
    {
        $block_role_ids_arr = $this->getBlockRoleIdsArr();

        $role_ids_arr = array();

        foreach ($block_role_ids_arr as $block_role_id) {
            $block_role_obj = BlockRole::factory($block_role_id);

            $role_ids_arr[] = $block_role_obj->getRoleId();
        }

        return $role_ids_arr;
    }

    /**
     * Выполняет PHP код в блоке и возвращает результат
     * @return string
     */
    public function evalContentPHPBlock()
    {
        ob_start();
        print eval('?>'. $this->getBody());
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }

    public function deleteBlocksRoles()
    {
        $block_role_ids_arr = $this->getBlockRoleIdsArr();

        foreach ($block_role_ids_arr as $block_role_id) {
            $block_role_obj = BlockRole::factory($block_role_id);

            $block_role_obj->delete();
        }
    }

    /**
     * @param $id
     */
    public static function afterUpdate($id)
    {
        $block_obj = self::factory($id);

        Logger::logObjectEvent($block_obj, 'изменение', Auth::getCurrentUserId());
    }

    public function afterDelete()
    {
        $this->deleteBlocksRoles();

        BlockUtils::clearBlockIdsArrByPageRegionIdCache($this->getPageRegionId(), $this->getTemplateId());
        BlockUtils::clearBlockIdsArrByPageRegionIdCache(self::BLOCK_REGION_NONE, $this->getTemplateId());

        self::removeObjFromCacheById($this->getId());

        Logger::logObjectEvent($this, 'удаление', Auth::getCurrentUserId());
    }
}
