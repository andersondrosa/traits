<?php

namespace AndersonDRosa\Traits;

trait Listener
{
    protected $_binds = array();

    public function bind($key, \Closure $fn)
    {
        return $this->_binds[$key][] = $fn;
    }

    public function unbindAll($key = null)
    {
        if ($key) {
            $this->_binds[$key] = array();
        } else {
            $this->_binds = array();
        }
        return $this;
    }

    public function fire($key, array $args)
    {
        if (!array_key_exists($key, $this->_binds)) {
            return $this;
        }

        foreach ($this->_binds[$key] as $fn) {
            call_user_func_array($fn, $args);
        }

        return $this;
    }
}
