<?php

use Botble\Base\Models\MetaBox as MetaBoxModel;
use Botble\Base\Supports\BaseSeeder;
use Botble\Gallery\Models\Gallery as GalleryModel;
use Botble\Gallery\Models\GalleryMeta;
use Botble\Language\Models\LanguageMeta;
use Botble\Slug\Models\Slug;
use Faker\Factory;

class GallerySeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->uploadFiles('galleries');

        GalleryModel::truncate();
        GalleryMeta::truncate();
        Slug::where('reference_type', GalleryModel::class)->delete();
        MetaBoxModel::where('reference_type', GalleryModel::class)->delete();
        LanguageMeta::where('reference_type', GalleryModel::class)->delete();

        $faker = Factory::create();

        $data = [
            'en_US' => [
                [
                    'name' => 'Perfect',
                ],
                [
                    'name' => 'New Day',
                ],
                [
                    'name' => 'Happy Day',
                ],
                [
                    'name' => 'Nature',
                ],
                [
                    'name' => 'Morning',
                ],
                [
                    'name' => 'Photography',
                ],
            ],
            'vi'    => [
                [
                    'name' => 'Hoàn hảo',
                ],
                [
                    'name' => 'Ngày mới',
                ],
                [
                    'name' => 'Ngày hạnh phúc',
                ],
                [
                    'name' => 'Thiên nhiên',
                ],
                [
                    'name' => 'Buổi sáng',
                ],
                [
                    'name' => 'Nghệ thuật',
                ],
            ],
        ];

        foreach ($data as $locale => $galleries) {
            foreach ($galleries as $index => $item) {
                $item['description'] = $faker->text(150);
                $item['image'] = 'galleries/' . ($index + 1) . '.jpg';
                $item['user_id'] = 1;
                $item['is_featured'] = true;

                $gallery = GalleryModel::create($item);

                Slug::create([
                    'reference_type' => GalleryModel::class,
                    'reference_id'   => $gallery->id,
                    'key'            => Str::slug($gallery->name),
                    'prefix'         => SlugHelper::getPrefix(GalleryModel::class),
                ]);

                $images = [];
                for ($i = 0; $i < 10; $i++) {
                    $images[] = [
                        'img'         => 'galleries/' . ($i + 1) . '.jpg',
                        'description' => $faker->text(150),
                    ];
                }

                GalleryMeta::create([
                    'images'         => json_encode($images),
                    'reference_id'   => $gallery->id,
                    'reference_type' => GalleryModel::class,
                ]);

                $originValue = md5($gallery->id . GalleryModel::class . time());

                $languageMeta = LanguageMeta::where([
                    'reference_id'   => $index + 1,
                    'reference_type' => GalleryModel::class,
                ])->first();

                if ($languageMeta) {
                    $originValue = $languageMeta->lang_meta_origin;
                }

                LanguageMeta::insert([
                    'reference_id'     => $gallery->id,
                    'reference_type'   => GalleryModel::class,
                    'lang_meta_code'   => $locale,
                    'lang_meta_origin' => $originValue,
                ]);
            }
        }
    }
}
