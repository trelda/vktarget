<?php

namespace App\Http\Controllers\Post;


use App\Http\Filters\PostFilter;
use App\Models\Network;
use App\Models\Post;
use App\Http\Requests\Post\IndexRequest;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;

class IndexController extends BaseController
{
    //TODO: {{ $posts->withQueryString()->links() }}
    public function __invoke(IndexRequest $request)
    {
        //$data = $request->validated();
        //$filter = app()->make(PostFilter::class, ['queryParams' => array_filter($data)]);
        //$posts = Post::filter($filter)->paginate(10);
        //$posts = Post::orderBy('id', 'desc')->paginate(10);
/*
        $posts = Network::where('networks.user_id', '=', Auth()->user()->id)
                        ->join('members', function (JoinClause $join) {
                          $join->on('members.id', '=', DB::Raw('
                               SELECT
                                   MAX(`id`)
                               FROM
                                   `members`
                               WHERE
                                   `group_id` = `networks.group_id`
                               GROUP BY
                                   `group_id`
                         '));
                          
                        })
                        ->paginate(10);


                        ->join('posts', function (JoinClause $join) {

                          $join->on('posts.group_id', '=', 'networks.group_id')
                            ->select(
                              MAX('id'),
                              'post_id',
                              'group_id',
                              MAX('date'),
                              'text',
                              'caption',
                              'is_repost',
                              MAX('views'),
                              MAX('likes'),
                              MAX('reposts')
                            )
                            ->groupBy('group_id', 'post_id', 'text', 'is_repost', 'caption');
                        })


*/


        $posts = DB::select(
    'SELECT
        `Net`.`group_id`,
        `Net`.`group_name`,
        `Post`.*,
        `Member`.`members`
    FROM
        `networks` Net
    JOIN
      (
        SELECT 
            MAX(ID) `id`,
            `post_id`,
            `group_id`,
            max(date) `date`,
            `text`,
            `caption`,
            `is_repost`,
            MAX(views) `views`,
            MAX(likes) `likes`,
            MAX(reposts) `reposts`
        FROM `posts`
        GROUP BY `group_id`, `post_id`, `text`, `is_repost`, `caption`
      ) as Post ON `Post`.`group_id` = `Net`.`group_id`
    JOIN 
      (
        SELECT `members`,
        `id` mId
        FROM `members`
      ) as Member on Member.mId = 
        (
          SELECT max(`id`) 
          FROM `members` 
          WHERE `group_id` = `Net`.`group_id` 
          GROUP BY `group_id`
        ) 
    WHERE `Net`.`user_id` = ' . Auth()->user()->id);

        //dd($posts);
        return view('post.index', compact('posts'));
    }
}

/*
last: 

SELECT
    `N`.`group_id`,
    `N`.`group_name`,
    `P`.`date`,
    `P`.`post_id`,
    `P`.`views`,
    `P`.`likes`,
    `P`.`reposts`,
    `P`.`is_repost`,
    (SELECT `text` FROM `posts` dep WHERE dep.id=P.id) PostText, 
    (SELECT `members` FROM `members` mem WHERE mem.group_id=N.group_id limit 1) GrMembers
FROM
    `networks` N
JOIN
  (
	SELECT 
      	MAX(ID) `id`,
		`post_id`,
        `group_id`,
        max(date) `date`,
      	`text`,
        `is_repost`,
		MAX(views) `views`,
      	MAX(likes) `likes`,
      	MAX(reposts) `reposts`
	FROM `posts`
	GROUP BY `group_id`, `post_id`, `text`, `is_repost`
  ) as P ON `P`.`group_id` = `N`.`group_id`
WHERE `N`.`user_id` = '1' AND `N`.`group_id` = '203643049';
*/