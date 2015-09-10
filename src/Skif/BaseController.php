<?php

namespace Skif;

class BaseController
{
    protected $context_is_known = false;
    protected $requested_id = null;
    protected $url_table = 'url';

    public function getRequestedId()
    {
        if (!$this->context_is_known) {
            $this->readContext();
        }

        return $this->requested_id;
    }

    protected function readContext()
    {
        $alias = \Skif\UrlManager::$current_url;

        $query = 'SELECT id FROM ' . $this->url_table . ' WHERE url = ?';
        $this->requested_id = \Skif\DB\DBWrapper::readField($query, array($alias));

        $this->context_is_known = true;
    }

}