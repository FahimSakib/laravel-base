<?php

use App\Models\Module;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    protected $data = [
        ['menu_id' => 1, 'type' => 1, 'module_name' => null, 'divider_title' => 'Menus', 'icon_class' => null, 'url' => null, 'order' => 1, 'parent_id' => null],
        ['menu_id' => 1, 'type' => 2, 'module_name' => 'Dassboard', 'divider_title' => null, 'icon_class' => 'fas fa-techometer-alt', 'url' => '/', 'order' => 2, 'parent_id' => null],
        ['menu_id' => 1, 'type' => 1, 'module_name' => null, 'divider_title' => 'System', 'icon_class' => null, 'url' => null, 'order' => 3, 'parent_id' => null],
        ['menu_id' => 1, 'type' => 2, 'module_name' => 'Menu', 'divider_title' => null, 'icon_class' => 'fas fa-th-list', 'url' => 'menu', 'order' => 4, 'parent_id' => null],
        ['menu_id' => 1, 'type' => 2, 'module_name' => 'Setting', 'divider_title' => null, 'icon_class' => 'fas fa-cogs', 'url' => 'setting', 'order' => 5, 'parent_id' => null],
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Module::insert($this->data);
    }
}
