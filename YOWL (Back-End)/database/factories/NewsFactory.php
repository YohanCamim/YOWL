<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(6,true),
            'content' => $this->faker->paragraphs(3,true),
            'imageUrl'=> $this->faker->imageUrl(100,100,'city'),
            'url' => $this->faker->url(),
            'category_id' => $this->faker->randomDigit(),
            'author_id' => $this->faker->numberBetween($min=1, $max=6),
        ];
    }
}
