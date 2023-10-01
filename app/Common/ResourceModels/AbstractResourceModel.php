<?php

namespace App\Common\ResourceModels;

use ReflectionClass;
use JsonSerializable;
use ReflectionProperty;
use Illuminate\Support\Str;

abstract class AbstractResourceModel implements JsonSerializable
{
    protected const SKIP = [];

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize()
    {
        $reflect = new ReflectionClass($this);
        $props = $reflect->getProperties(ReflectionProperty::IS_PUBLIC);
        $propMap = [];

        foreach ($props as $prop) {
            $propName = $prop->getName();

            if (!in_array($propName, static::SKIP)) {
                $propMap[$propName] = Str::snake($propName);
            }
        }

        $result = [];

        foreach ($propMap as $originName => $transformName) {
            $result[$transformName] = $this->{$originName};
        }

        return $result;
    }
}
