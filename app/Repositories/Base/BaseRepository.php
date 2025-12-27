<?php

namespace App\Repositories\Base;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getAll(): Collection
    {
        return $this->model->all();
    }

    public function getById(int $id): ?Model
    {
        return $this->model->find($id);
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): ?Model
    {
        $record = $this->getById($id);

        if ($record) {
            $record->update($data);
            return $record->fresh();
        }

        return null;
    }

    public function delete(int $id): bool
    {
        $record = $this->getById($id);

        if ($record) {
            return $record->delete();
        }

        return false;
    }
}
