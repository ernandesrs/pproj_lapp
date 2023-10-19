<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Role::create([
            'name' => 'Super user',
            'protected' => true,
            'is_super' => true,
            'manageables' => $this->getManageables()
        ]);

        \App\Models\Role::create([
            'name' => 'Administrator',
            'protected' => false,
            'is_super' => false
        ]);

        \App\Models\Role::create([
            'name' => 'Visitor',
            'protected' => false,
            'is_super' => false
        ]);
    }

    /**
     * Get manageables
     *
     * @return array
     */
    private function getManageables()
    {
        $manageables = [];

        foreach (\App\Models\Role::manageables as $manageableName => $manageableActions) {
            $mActions = [];

            foreach ($manageableActions as $actionKey => $actionValue) {
                $mActions[$actionKey] = true;
            }

            $manageables[str_replace('\\', '_', $manageableName)] = $mActions;
        }

        return $manageables;
    }
}
