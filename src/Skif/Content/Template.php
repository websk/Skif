<?php

namespace Skif\Content;


class Template implements
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
    protected $title;
    protected $css;
    protected $def;
    protected $layout_template_file;

    const DB_TABLE_NAME = 'template';

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getCss()
    {
        return $this->css;
    }

    /**
     * @param mixed $css
     */
    public function setCss($css)
    {
        $this->css = $css;
    }

    /**
     * @return mixed
     */
    public function getDef()
    {
        return $this->def;
    }

    /**
     * @param mixed $def
     */
    public function setDef($def)
    {
        $this->def = $def;
    }

    /**
     * @return mixed
     */
    public function getLayoutTemplateFile()
    {
        return $this->layout_template_file;
    }

    public function getLayoutTemplateFilePath()
    {
        return 'layouts/' . $this->layout_template_file;
    }

    /**
     * @param mixed $layout_template_file
     */
    public function setLayoutTemplateFile($layout_template_file)
    {
        $this->layout_template_file = $layout_template_file;
    }

}