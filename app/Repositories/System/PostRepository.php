<?php
/**
 * @author Chrisostomos Bakouras.
 */

namespace App\Repositories\System;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;

/**
 * Interface PostRepository
 *
 * Contains only method signatures for methods related to the Post object
 *
 * @package App\Repositories
 */
interface PostRepository extends Repository
{
    public function findBySlug($postSlug);

    public function findAllWithTypePaginated($type = 'post', $perPage = 20);

    public function eagerLoadAllPaginated($with, $query, $perPage = 20);

    public function eagerLoadOne($with, $id);

    public function syncCategories($id, $array = array());

    public function syncCategoriesToModel(Model $post, $array = array());

    public function findDistinctStatus($type);

    public function forceDeleteAuthorPosts($author);
}
