<?php

namespace Database\Seeders;

use App\Repository\SettingRepository;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    private  $settingRepository;
    public function  __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository=$settingRepository;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting=[
            'task_order'=>'desc',
            'dashboard_color'=>'white',
            'number_of_task'=>3,
        ];
        foreach ($setting as $key=>$value)
        {
            if(!$this->settingRepository->exitsByKey($key))
            {
                $this->settingRepository->saveSetting([
                    'key' => $key,
                    'default_value' => $value,
                ]);
            }

        }

    }
}
