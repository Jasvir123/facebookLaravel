<?php

namespace App\Repositories;

use App\Models\Setting;

class SettingRepository implements SettingRepositoryInterface
{

    protected $setting;

    public function __construct(Setting $setting)
    {
        $this->setting = $setting;
    }

    public function getAll()
    {
        return $this->setting::get();
    }

    public function find($id)
    {
        return $this->setting->find($id);
    }

    public function create($data)
    {
        return $this->setting->create($data);
    }

    public function update($id, $data)
    {
        return $this->setting->where('id', $id)->update($data);
    }

    public function delete($setting)
    {
        return $setting->delete();
    }
}
