<?php

namespace Database\Factories;

use App\Enums\CommentType;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use MarcReichel\IGDBLaravel\Models\Game;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $userIds = User::get('id')->toArray();
        $gamesIds = Game::orderBy('first_release_date', 'desc')->get()->slice(0,10)->pluck('id')->toArray();
        $idRandomUser = array_rand($userIds);

        return [
            'comment' => $this->faker->realText(),
            'game_id' => $gamesIds[array_rand($gamesIds)],
            'user_id' => $userIds[$idRandomUser]['id'],
            'type' => Arr::random(CommentType::getValues()),
        ];
    }
}
