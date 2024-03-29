<?php

use Botble\Base\Supports\BaseSeeder;
use Botble\Block\Models\Block;
use Botble\Language\Models\LanguageMeta;
use Faker\Factory;

class StaticBlockSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        Block::truncate();
        if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
            LanguageMeta::where('reference_type', Block::class)->delete();
        }

        for ($i = 0; $i < 5; $i++) {
            $name = $faker->name;
            Block::create([
                'name'        => $name,
                'alias'       => Str::slug($name),
                'description' => $faker->text(50),
                'content'     => $faker->text(500),
            ]);
        }

        if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
            Artisan::call('cms:language:sync', ['class' => Block::class]);
        }
    }
}
