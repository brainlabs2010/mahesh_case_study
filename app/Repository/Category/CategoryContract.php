<?php

namespace App\Repository\Category;

interface CategoryContract
{
    /**
     * Get all categorys
     *
     * @param  array  $relations
     * @return mixed
     */
    public function all(array $relations = []): mixed;

    /**
     * create category
     *
     * @param  array  $data
     * @return mixed
     */
    public function create(array $data): mixed;

    /**
     * Remove given category.
     *
     * @param  int  $id
     * @return mixed
     */
    public function delete(int $id);

    /**
     * Get category by id.
     *
     * @param  int  $id
     * @param  array  $relations
     * @return mixed
     */
    public function getById(int $id, array $relations = []): mixed;

    /**
     * Update category by given id.
     *
     * @param  int  $id
     * @param  array  $data
     * @return mixed
     */
    public function update(int $id, array $data): mixed;
}