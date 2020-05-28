<?php

namespace Modules\Rarv\Button;

use Modules\Rarv\Parser\VariableParser;

class Button implements \ArrayAccess
{
    protected $url;
    protected $label;
    protected $color;
    protected $icon;
    protected $attributes = [];

    protected $class = '';

    public $weight = 0;

    protected $permission = true;
    protected $policy = null;

    public function __construct($label, $url, $color = 'primary', $icon = null)
    {
        $this->label = $label;
        $this->url   = $url;
        $this->color = $color;
        $this->icon  = $icon;
    }

    /**
     * @return mixed
     */
    public function getUrl($object = null)
    {
        $parser = new VariableParser();
        $url    = $parser->parse($this->url, $object);

        return $url;
    }

    /**
     * @param mixed $url
     *
     * @return self
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed $label
     *
     * @return self
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param mixed $color
     *
     * @return self
     */
    public function setColor($color)
    {
        if (!in_array($color, ['success', 'danger', 'warning', 'info', 'primary'])) {
            throw new \Exception('Invalid color specified', -1);
        }

        $this->color = $color;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param mixed $icon
     *
     * @return self
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    public function setAttributes(array $atts)
    {
        $this->attributes = $atts;

        return $this;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function getAttribute($key, $default = null)
    {
        if (!isset($this->attributes[$key])) {
            return $default;
        }

        return $this->attributes[$key];
    }

    public function offsetExists($offset)
    {
        #
    }

    public function offsetSet($offset, $value)
    {
        data_set($this, $offset, $value);
    }

    public function offsetGet($offset)
    {
        return data_get($this, $offset);
    }

    public function offsetUnset($offset)
    {
        data_set($this, $offset, null);
    }

    public function getAttributesLine()
    {
        $data = [];

        foreach ($this->getAttributes() as $key => $value) {
            $data[] = $key . '="' . $value . '"';
        }

        return implode(' ', $data);
    }

    public function permission($permission)
    {
        $this->permission = value($permission);

        if ($this->permission !== true and $this->permission !== false) {
            throw new \Exception('Permission must return a boolean value', -1);
        }

        return $this;
    }

    public function hasPermission()
    {
        return $this->permission;
    }

    /**
     * @return mixed
     */
    public function getPolicy()
    {
        return $this->policy;
    }

    /**
     * @param mixed $policy
     *
     * @return self
     */
    public function setPolicy($policy)
    {
        $this->policy = $policy;

        return $this;
    }

    // @todo Test
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    // @todo Test
    public function getClass()
    {
        return $this->class;
    }
}
