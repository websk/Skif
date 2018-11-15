<?php

namespace Skif;

use Websk\Skif\DBWrapper;

/**
 * Class BaseController
 * @package Skif
 */
class BaseController
{
    /** @var bool */
    protected $context_is_known = false;
    /** @var null|int */
    protected $requested_id = null;
    /** @var string */
    protected $url_table = 'url';

    /**
     * @return null|int
     */
    public function getRequestedId()
    {
        if (!$this->context_is_known) {
            $this->readContext();
        }

        return $this->requested_id;
    }

    protected function readContext()
    {
        $alias = UrlManager::$current_url;

        $this->requested_id = self::getEntityIdByAlias($alias);

        $this->context_is_known = true;
    }

    /**
     * @param string $alias
     * @return int
     */
    protected function getEntityIdByAlias(string $alias)
    {
        $query = 'SELECT id FROM ' . $this->url_table . ' WHERE url = ?';
        return (int)DBWrapper::readField($query, array($alias));
    }
}
