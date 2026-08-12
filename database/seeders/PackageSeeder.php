<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Package;
use App\Models\PackageComponent;
use App\Models\PackageLevel;
use Illuminate\Support\Str;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Clear Existing Package Data
        |--------------------------------------------------------------------------
        */

        PackageComponent::query()->delete();
        PackageLevel::query()->delete();
        Package::query()->delete();

        /*
        |--------------------------------------------------------------------------
        | PACKAGE 1
        |--------------------------------------------------------------------------
        */

        $package1 = Package::create([
            'name' => 'Package 1',
            'slug' => 'package-1',
            'code' => 'PKG001',
            'price' => 1750,
            'joining_amount' => 1750,
            'renewal_amount' => 1750,
            'short_description' => '6 Level Structure',
            'description' => 'Package 1 with 6 level income structure.',
            'image' => null,
            'icon' => null,
            'is_popular' => 0,
            'is_featured' => 0,
            'sort_order' => 1,
            'status' => 1,
        ]);

        /*
        | Package 1 - Levels
        |
        | Level | Team | Income | Total | Company | Company Total
        |
        | 1     | 3    | 250    | 750   | 150     | 450
        | 2     | 9    | 250    | 2250  | 150     | 1350
        | 3     | 27   | 250    | 6750  | 150     | 4050
        | 4     | 81   | 250    | 20250 | 150     | 12150
        | 5     | 243  | 300    | 72900 | 150     | 36450
        | 6     | 729  | 300    | 218700| 150     | 109350
        */

        $this->createLevels($package1->id, [
            [
                'level' => 1,
                'team' => 3,
                'income' => 250,
                'total' => 750,
                'company' => 150,
                'company_total' => 450,
            ],
            [
                'level' => 2,
                'team' => 9,
                'income' => 250,
                'total' => 2250,
                'company' => 150,
                'company_total' => 1350,
            ],
            [
                'level' => 3,
                'team' => 27,
                'income' => 250,
                'total' => 6750,
                'company' => 150,
                'company_total' => 4050,
            ],
            [
                'level' => 4,
                'team' => 81,
                'income' => 250,
                'total' => 20250,
                'company' => 150,
                'company_total' => 12150,
            ],
            [
                'level' => 5,
                'team' => 243,
                'income' => 300,
                'total' => 72900,
                'company' => 150,
                'company_total' => 36450,
            ],
            [
                'level' => 6,
                'team' => 729,
                'income' => 300,
                'total' => 218700,
                'company' => 150,
                'company_total' => 109350,
            ],
        ]);

        /*
        | Package 1 - Components
        */

        $this->createComponents($package1->id, [
            [
                'component_type' => 'direct',
                'name' => 'Direct Income',
                'code' => 'DIRECT',
                'amount' => 0,
                'level' => null,
            ],
            [
                'component_type' => 'company',
                'name' => 'Company Income',
                'code' => 'COMPANY',
                'amount' => 150,
                'level' => null,
            ],
            [
                'component_type' => 'expense',
                'name' => 'Expense',
                'code' => 'EXPENSE',
                'amount' => 0,
                'level' => null,
            ],
            [
                'component_type' => 'sharing',
                'name' => 'Sharing',
                'code' => 'SHARING',
                'amount' => 1600,
                'level' => null,
            ],
            [
                'component_type' => 'bonus',
                'name' => 'Bonus',
                'code' => 'BONUS',
                'amount' => 0,
                'level' => null,
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | PACKAGE 2
        |--------------------------------------------------------------------------
        */

        $package2 = Package::create([
            'name' => 'Package 2',
            'slug' => 'package-2',
            'code' => 'PKG002',
            'price' => 5000,
            'joining_amount' => 5000,
            'renewal_amount' => 5000,
            'short_description' => '6 Level Structure',
            'description' => 'Package 2 with 6 level income structure.',
            'image' => null,
            'icon' => null,
            'is_popular' => 0,
            'is_featured' => 0,
            'sort_order' => 2,
            'status' => 1,
        ]);

        /*
        | Package 2 - Levels
        */

        $this->createLevels($package2->id, [
            [
                'level' => 1,
                'team' => 3,
                'income' => 300,
                'total' => 900,
                'company' => 500,
                'company_total' => 1500,
            ],
            [
                'level' => 2,
                'team' => 9,
                'income' => 300,
                'total' => 2700,
                'company' => 500,
                'company_total' => 4500,
            ],
            [
                'level' => 3,
                'team' => 27,
                'income' => 300,
                'total' => 8100,
                'company' => 500,
                'company_total' => 13500,
            ],
            [
                'level' => 4,
                'team' => 81,
                'income' => 300,
                'total' => 24300,
                'company' => 500,
                'company_total' => 40500,
            ],
            [
                'level' => 5,
                'team' => 243,
                'income' => 450,
                'total' => 109350,
                'company' => 500,
                'company_total' => 121500,
            ],
            [
                'level' => 6,
                'team' => 729,
                'income' => 450,
                'total' => 328050,
                'company' => 500,
                'company_total' => 364500,
            ],
        ]);

        /*
        | Package 2 - Components
        */

        $this->createComponents($package2->id, [
            [
                'component_type' => 'direct',
                'name' => 'Direct Income',
                'code' => 'DIRECT',
                'amount' => 500,
                'level' => null,
            ],
            [
                'component_type' => 'company',
                'name' => 'Company Income',
                'code' => 'COMPANY',
                'amount' => 500,
                'level' => null,
            ],
            [
                'component_type' => 'expense',
                'name' => 'Expense',
                'code' => 'EXPENSE',
                'amount' => 1900,
                'level' => null,
            ],
            [
                'component_type' => 'sharing',
                'name' => 'Sharing',
                'code' => 'SHARING',
                'amount' => 2600,
                'level' => null,
            ],
            [
                'component_type' => 'bonus',
                'name' => 'Bonus',
                'code' => 'BONUS',
                'amount' => 0,
                'level' => null,
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | PACKAGE 3
        |--------------------------------------------------------------------------
        */

        $package3 = Package::create([
            'name' => 'Package 3',
            'slug' => 'package-3',
            'code' => 'PKG003',
            'price' => 1750,
            'joining_amount' => 1750,
            'renewal_amount' => 1750,
            'short_description' => '6 Level Structure',
            'description' => 'Package 3 with 6 level income structure.',
            'image' => null,
            'icon' => null,
            'is_popular' => 1,
            'is_featured' => 1,
            'sort_order' => 3,
            'status' => 1,
        ]);

        /*
        | Package 3 - Levels
        */

        $this->createLevels($package3->id, [
            [
                'level' => 1,
                'team' => 5,
                'income' => 250,
                'total' => 1250,
                'company' => 150,
                'company_total' => 750,
            ],
            [
                'level' => 2,
                'team' => 25,
                'income' => 250,
                'total' => 6250,
                'company' => 150,
                'company_total' => 3750,
            ],
            [
                'level' => 3,
                'team' => 125,
                'income' => 250,
                'total' => 31250,
                'company' => 150,
                'company_total' => 18750,
            ],
            [
                'level' => 4,
                'team' => 625,
                'income' => 250,
                'total' => 156250,
                'company' => 150,
                'company_total' => 93750,
            ],
            [
                'level' => 5,
                'team' => 3125,
                'income' => 300,
                'total' => 937500,
                'company' => 150,
                'company_total' => 468750,
            ],
            [
                'level' => 6,
                'team' => 15625,
                'income' => 300,
                'total' => 4687500,
                'company' => 150,
                'company_total' => 2343750,
            ],
        ]);

        /*
        | Package 3 - Components
        */

        $this->createComponents($package3->id, [
            [
                'component_type' => 'direct',
                'name' => 'Direct Income',
                'code' => 'DIRECT',
                'amount' => 0,
                'level' => null,
            ],
            [
                'component_type' => 'company',
                'name' => 'Company Income',
                'code' => 'COMPANY',
                'amount' => 150,
                'level' => null,
            ],
            [
                'component_type' => 'expense',
                'name' => 'Expense',
                'code' => 'EXPENSE',
                'amount' => 0,
                'level' => null,
            ],
            [
                'component_type' => 'sharing',
                'name' => 'Sharing',
                'code' => 'SHARING',
                'amount' => 1600,
                'level' => null,
            ],
            [
                'component_type' => 'bonus',
                'name' => 'Bonus',
                'code' => 'BONUS',
                'amount' => 0,
                'level' => null,
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | PACKAGE 4
        |--------------------------------------------------------------------------
        */

        $package4 = Package::create([
            'name' => 'Package 4',
            'slug' => 'package-4',
            'code' => 'PKG004',
            'price' => 5000,
            'joining_amount' => 5000,
            'renewal_amount' => 5000,
            'short_description' => '6 Level Structure',
            'description' => 'Package 4 with 6 level income structure.',
            'image' => null,
            'icon' => null,
            'is_popular' => 0,
            'is_featured' => 0,
            'sort_order' => 4,
            'status' => 1,
        ]);

        /*
        | Package 4 - Levels
        */

        $this->createLevels($package4->id, [
            [
                'level' => 1,
                'team' => 5,
                'income' => 300,
                'total' => 1500,
                'company' => 500,
                'company_total' => 2500,
            ],
            [
                'level' => 2,
                'team' => 25,
                'income' => 300,
                'total' => 7500,
                'company' => 500,
                'company_total' => 12500,
            ],
            [
                'level' => 3,
                'team' => 125,
                'income' => 300,
                'total' => 37500,
                'company' => 500,
                'company_total' => 62500,
            ],
            [
                'level' => 4,
                'team' => 625,
                'income' => 300,
                'total' => 187500,
                'company' => 500,
                'company_total' => 312500,
            ],
            [
                'level' => 5,
                'team' => 3125,
                'income' => 450,
                'total' => 1406250,
                'company' => 500,
                'company_total' => 1562500,
            ],
            [
                'level' => 6,
                'team' => 15625,
                'income' => 450,
                'total' => 7031250,
                'company' => 500,
                'company_total' => 7812500,
            ],
        ]);

        /*
        | Package 4 - Components
        */

        $this->createComponents($package4->id, [
            [
                'component_type' => 'direct',
                'name' => 'Direct Income',
                'code' => 'DIRECT',
                'amount' => 500,
                'level' => null,
            ],
            [
                'component_type' => 'company',
                'name' => 'Company Income',
                'code' => 'COMPANY',
                'amount' => 500,
                'level' => null,
            ],
            [
                'component_type' => 'expense',
                'name' => 'Expense',
                'code' => 'EXPENSE',
                'amount' => 1900,
                'level' => null,
            ],
            [
                'component_type' => 'sharing',
                'name' => 'Sharing',
                'code' => 'SHARING',
                'amount' => 2600,
                'level' => null,
            ],
            [
                'component_type' => 'bonus',
                'name' => 'Bonus',
                'code' => 'BONUS',
                'amount' => 0,
                'level' => null,
            ],
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Create Levels
    |--------------------------------------------------------------------------
    */

    private function createLevels(int $packageId, array $levels): void
    {
        foreach ($levels as $item) {

            PackageLevel::create([
                'package_id' => $packageId,

                'level' => $item['level'],

                'name' => 'Level ' . $item['level'],

                'calculation_type' => 'fixed',

                'amount' => $item['income'],

                'percentage' => null,

                /*
                | Team count from your image
                */
                'minimum_business' => $item['team'],

                /*
                | Total income from your image
                */
                'maximum_income' => $item['total'],

                'description' =>
                    'Team: ' . number_format($item['team']) .
                    ' | Income: ₹' . number_format($item['income']) .
                    ' | Total: ₹' . number_format($item['total']) .
                    ' | Company: ₹' . number_format($item['company']) .
                    ' | Company Total: ₹' . number_format($item['company_total']),

                'sort_order' => $item['level'],

                'status' => 1,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Store Company Level Value
            |--------------------------------------------------------------------------
            |
            | Your package_levels table does not have a company column.
            | Therefore company level amount is stored in package_components
            | using the level column.
            |
            */

            PackageComponent::create([
                'package_id' => $packageId,
                'component_type' => 'company',
                'name' => 'Company Income - Level ' . $item['level'],
                'code' => 'COMPANY_L' . $item['level'],
                'calculation_type' => 'fixed',
                'amount' => $item['company'],
                'percentage' => null,
                'level' => $item['level'],
                'minimum_amount' => null,
                'maximum_amount' => null,
                'is_mandatory' => 0,
                'description' =>
                    'Company income for Level ' . $item['level'] .
                    '. Team: ' . number_format($item['team']) .
                    ', Total: ₹' . number_format($item['company_total']),
                'sort_order' => 100 + $item['level'],
                'status' => 1,
            ]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Create Components
    |--------------------------------------------------------------------------
    */

    private function createComponents(int $packageId, array $components): void
    {
        foreach ($components as $index => $item) {

            PackageComponent::create([
                'package_id' => $packageId,

                'component_type' => $item['component_type'],

                'name' => $item['name'],

                'code' => $item['code'],

                'calculation_type' => 'fixed',

                'amount' => $item['amount'],

                'percentage' => null,

                'level' => $item['level'],

                'minimum_amount' => null,

                'maximum_amount' => null,

                'is_mandatory' => 0,

                'description' => $item['name'] . ' for ' . $this->getPackageName($packageId),

                'sort_order' => $index + 1,

                'status' => 1,
            ]);
        }
    }

    private function getPackageName(int $packageId): string
    {
        return Package::where('id', $packageId)->value('name') ?? 'Package';
    }
}