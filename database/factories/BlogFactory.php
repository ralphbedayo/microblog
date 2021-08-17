<?php


namespace Database\Factories;


use App\Constants\BlogConstants;
use App\Constants\UserConstants;
use App\Models\Blog;
use App\Models\Comment;
use App\Models\User;
use Closure;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Blog::class;

    /**
     * @inheritDoc
     */
    public function definition()
    {
        $oAuthorData = User::where('user_type', '=', UserConstants::BLOGGER_USER_TYPE)->inRandomOrder()->first();

        return [
            'author_id'   => $oAuthorData->id,
            'category_id' => $this->faker->numberBetween(1, 10),
            'content'     => $this->faker->paragraph(15),
            'title'       => $this->faker->realText(25)
        ];
    }

//    public function configure()
//    {
//        return $this->afterCreating(function (Blog $blog) {
//            Comment::factory()->count(5)->specificBlog((int)$blog->id);
//        });
//    }
}
