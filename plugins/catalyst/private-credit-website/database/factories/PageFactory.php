<?php

namespace Catalyst\PrivateCreditWebsite\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Catalyst\PrivateCreditWebsite\Models\Page;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Catalyst\PrivateCreditWebsite\Models\Page>
 */
class PageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Page::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        ];
    }
}
