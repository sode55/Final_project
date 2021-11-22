<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $comments = [
            ['title' => 'دسترسی آسان', 'content' => 'دسترسی اسان و مداوم ، ارا‌‌ٔيه خدمات بسیار آسان شده است.', 'company_id' => 1,
                'created_at' => '2021-10-08 ', 'updated_at' => '2021-10-08'],
            ['title' => 'آرامش خیال', 'content' => 'از طریق این سایت تهیه بلیط و ارايه خدمات به مشتریان با آرامش خیال همراه است.', 'company_id' => 2,
                'created_at' => '2021-10-08 ', 'updated_at' => '2021-10-08'],
            ['title' => 'به روز بودن', 'content' => 'آرایه خدمات به روز شما باعث رضایت مشتریان و اراپه خدمات بهتر از جانب ما می شود.', 'company_id' => 3,
                'created_at' => '2021-10-08', 'updated_at' => '2021-10-08'],

        ];
        Comment::insert($comments);
    }

}
