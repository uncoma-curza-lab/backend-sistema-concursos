<?php

namespace app\models\traits;

trait FindBySlug
{
    public function findBySlug(string $slug) 
    {
        return $this->where(['=', 'code', $slug])->one();
    }
}
