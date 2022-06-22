<?php

namespace App\Repository\Category;

use App\Models\Category;

class CategoryRepository implements CategoryContract
{
    private Category $category;

    /**
     * @param  Category  $category
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * @inheritDoc
     */
    public function all(array $relations = []): mixed
    {
        return $this->category->with($relations)->paginate();
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): mixed
    {
        return $this->category->create($data);
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id)
    {
        $category = $this->getById($id);
        return $category->delete();
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id, array $relations = []): mixed
    {
        return $this->category->with($relations)->findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function update(int $id, array $data): mixed
    {
        $category = $this->getById($id);
        return tap($category)->update($data);
    }
}