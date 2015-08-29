<?php
/*
 * This file is part of Flarum.
 *
 * (c) Toby Zerner <toby.zerner@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flarum\Core\Discussions\Search\Fulltext;

use Flarum\Core\Posts\Post;

class MySqlFulltextLikeModeDriver implements Driver
{
    /**
     * {@inheritdoc}
     */
    public function match($string)
    {

        $discussionIds = Post::where('type', 'comment')
            ->where('content', 'like', '%'.$string.'%')
            ->lists('discussion_id', 'id');

        $relevantPostIds = [];

        foreach ($discussionIds as $postId => $discussionId) {
            $relevantPostIds[$discussionId][] = $postId;
        }

        return $relevantPostIds;
    }
}