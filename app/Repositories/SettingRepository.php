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

    public function getCurrentDaySettings()
    {
        $today = date('Y-m-d');
        return $this->setting->whereDate('created_at', $today)->first();
    }

    public function checkOrCreateForCurrentDay($data)
    {
        $setting = $this->getCurrentDaySettings();

        if (!$setting) {
            $setting = $this->setting->create([
                'maxLikesCount' => $data['maxLikes'],
                'maxPostsCount' => $data['maxPosts'],
            ]);
        } else {
            $setting->maxLikesCount = $data['maxLikes'];
            $setting->maxPostsCount = $data['maxPosts'];
            $setting->save();
        }

        return $setting;
    }
}
