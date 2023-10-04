<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->randomElement([
                'موبایل سامسونگ',
                'لپ تاپ سونی',
                'لپ تاپ فوجیتسو',
                'مچبند شیائومی',
                'اسپیکر هارمن کاردن',
                'مودم ADSL',
                'پاور بانک',
                'دوربین',
                'کابل صدا',
                'باتری موبایل',
                'کتابخوان',
                'ال جی مانیتور',
                'تبلت سامسونگ',
            ]),
            'description' => 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است چاپگرها و متون بلکه .',

            'image' => 'https://via.placeholder.com/286x180?text=Image',
            'price' => $this->faker->randomElement([
                150000 , 450000 , 252000 , 2521000 , 250000 , 150000 , 850000 , 650000, 450000 , 950000 , 410000 , 320000
            ]),
            'stock'=> $this->faker->randomDigitNotNull
        ];
    }
}
