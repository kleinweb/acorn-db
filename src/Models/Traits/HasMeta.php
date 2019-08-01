<?php

namespace TinyPixel\Acorn\Database\Models\Traits;

use TinyPixel\Acorn\Support\Utility;

trait HasMeta
{
    public function getMeta($meta_key = false)
    {
        $meta_value = '';

        if ($meta_key) {
            $meta_value = $this->meta()->where('meta_key', $meta_key)->pluck('meta_value')->first();

            if (Utility::isSerialized($meta_value)) {
                $meta_value = unserialize($meta_value);
            }
        }

        return $meta_value;
    }

    public function setMeta($key, $value)
    {
        $value = is_array($value) ? serialize($value) : $value;
        $meta  = $this->meta()->firstOrCreate(['meta_key' => $key]);
        $meta  = $this->meta()->where(['meta_key' => $key])->update(['meta_value' => $value]);

        return $this;
    }

    public function deleteMeta($meta_key = false)
    {
        if ($meta_key) {
            $this->meta()->where('meta_key', $meta_key)->delete();
        }
    }
}
