<?php


namespace Database\Factories;


use App\Constants\UserConstants;
use App\Models\Blog;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * @inheritDoc
     */
    public function definition()
    {
        $oCommentAuthorData = User::where('user_type', '=', UserConstants::BLOGGER_USER_TYPE)->inRandomOrder()->first();
        $oBlogData = Blog::inRandomOrder()->first();

        return [
            'blog_id' => $oBlogData->id,
            'comment_author_id' => $oCommentAuthorData->id,
            'content' => $this->faker->paragraph()
        ];

    }

    public function specificBlog($mId)
    {
        return $this->state(function (array $attributes) use ($mId) {
            return [
                'blog_id' => $mId
            ];
        });
    }
}
