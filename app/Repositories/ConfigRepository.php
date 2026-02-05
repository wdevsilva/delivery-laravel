<?php

namespace App\Repositories;

use App\Models\ConfigModel;

class ConfigRepository
{
    public function getConfig()
    {
        return ConfigModel::first();
    }
}
