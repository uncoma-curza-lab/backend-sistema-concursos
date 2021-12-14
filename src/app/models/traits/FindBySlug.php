<?php

namespace app\models\traits;

trait FindBySlug
{
    public function filterQueryBySlug(string $slug)
    {
        return $this->where(['=', 'code', $slug]);
    }

    public function findBySlug(string $slug) 
    {
        return $this->filterQueryBySlug($slug)->one();
    }
}
