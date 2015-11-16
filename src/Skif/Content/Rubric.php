<?php

namespace Skif\Content;


class Rubric implements
    \Skif\Model\InterfaceLoad,
    \Skif\Model\InterfaceFactory,
    \Skif\Model\InterfaceSave,
    \Skif\Model\InterfaceDelete,
    \Skif\Model\InterfaceLogger
{
    use \Skif\Util\ActiveRecord;
    use \Skif\Model\FactoryTrait;

    protected $id;
    protected $name;
    protected $comment;
    protected $content_type_id;
    protected $template_id;
    protected $url;
    protected $content_ids_arr;

    public static $active_record_ignore_fields_arr = array(
        'content_ids_arr',
    );

    const DB_TABLE_NAME = 'rubrics';

    public function getEditorUrl()
    {
        $content_type_obj = \Skif\Content\ContentType::factory($this->getContentTypeId());

        return '/admin/content/' . $content_type_obj->getType() . '/rubrics/edit/' . $this->getId();
    }

    public function getDeleteUrl()
    {
        $content_type_obj = \Skif\Content\ContentType::factory($this->getContentTypeId());

        return '/admin/content/' . $content_type_obj->getType() . '/rubrics/delete/' . $this->getId();
    }

    public function load($id)
    {
        $is_loaded = \Skif\Util\ActiveRecordHelper::loadModelObj($this, $id);
        if (!$is_loaded) {
            return false;
        }

        $query = "SELECT content_id FROM " . \Skif\Content\ContentRubrics::DB_TABLE_NAME ." WHERE rubric_id = ?";
        $this->content_ids_arr = \Skif\DB\DBWrapper::readColumn(
            $query,
            array($this->id)
        );

        return true;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return mixed
     */
    public function getContentTypeId()
    {
        return $this->content_type_id;
    }

    /**
     * @param mixed $content_type_id
     */
    public function setContentTypeId($content_type_id)
    {
        $this->content_type_id = $content_type_id;
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

    public function getRelativeTemplateId()
    {
        if ($this->getTemplateId()) {
            return $this->getTemplateId();
        }

        $content_type_obj = \Skif\Content\ContentType::factory($this->getContentTypeId());

        return $content_type_obj->getTemplateId();
    }

    /**
     * @return mixed
     */
    public function getContentIdsArr()
    {
        return $this->content_ids_arr;
    }

    public function beforeDelete()
    {
        $content_ids_arr = $this->getContentIdsArr();

        if ($content_ids_arr) {
            return 'Нельзя удалить рубрику ' . $this->getName() . ', т.к. она связана с материалами';
        }

        return true;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function generateUrl()
    {
        if (!$this->getName()) {
            return '';
        }

        $title_for_url = \Skif\Translit::translit($this->getName());

        $new_url = $title_for_url;
        $new_url = '/' . ltrim($new_url, '/');

        $new_url = substr($new_url, 0, 255);

        $unique_new_url = \Skif\UrlManager::getUniqueUrl($new_url);
        \Skif\Utils::assert($unique_new_url);

        return $unique_new_url;
    }

    public static function afterUpdate($rubric_id)
    {
        $rubric_obj = \Skif\Content\Rubric::factory($rubric_id);

        self::removeObjFromCacheById($rubric_id);

        \Skif\Content\ContentType::afterUpdate($rubric_obj->getContentTypeId());
    }

    public function afterDelete()
    {
        self::removeObjFromCacheById($this->getId());

        \Skif\Content\ContentType::afterUpdate($this->getContentTypeId());
    }

}