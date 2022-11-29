<?php

namespace App\Repositories;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

abstract class BaseRepository
{
    /**
     * @var Builder
     */
    protected $model;

    protected $all_columns;

    public function __construct()
    {
        $this->model = $this->makeModel();
    }

    /**
     * @return BaseModel|mixed
     */
    public function makeModel()
    {
        return app($this->model());
    }

    /**
     * @return BaseModel::class
     */
    abstract public function model();

    /**
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * @param  array  $attributes
     *
     * @return $this|Model
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * @param $id
     * @param array $attributes
     * @param array $options
     *
     * @return BaseRepository|bool|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static[]
     */
    public function update($id, array $attributes, array $options = [])
    {
        $result = $this->find($id);
        if ($result) {
            $result->update($attributes, $options);

            return $result;
        }

        return false;
    }

    /**
     * @param $id
     *
     * @return bool
     */
    public function delete($id)
    {
        $result = $this->find($id);
        if ($result) {
            try {
                $result->delete();
            } catch (\Exception $e) {
                return false;
            }

            return true;
        }

        return false;
    }

    /**
     * @param array $columns
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all($columns = ['*'])
    {
        return $this->model->all($columns);
    }

    /**
     * @param $limit
     * @param array $option
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($limit, $option = [])
    {
        return $this->model->paginate($limit);
    }

    /**
     * Get columns filter
     */
    public function getFilterLikeColumns()
    {
        return [];
    }

    public function whereBuilder($conditions, Builder $builder)
    {
        if ($conditions instanceof Collection) {
            $conditions = $conditions->filter(function ($value, $key) {
                return (empty($value) && $value !== '0') ? false : true;
            })->all();
        }
        $cols = $this->getFilterLikeColumns();
        foreach ($conditions as $field => $value) {
            if ($field === 'search') {
                $builder->where(function ($subQuery) use ($value, $cols) {
                    foreach ($value as $val) {
                        $subQuery->orWhere(function ($subQuery2) use ($val, $cols) {
                            foreach ($cols as $col) {
                                $subQuery2->orWhere($col, 'LIKE', '%'.$val.'%');
                            }
                        });
                    }
                });
            } elseif (is_array($value) && !empty($value) && count($value) > 2) {
                list($field, $condition, $val) = $value;
                if (!$this->isFillable($field)) {
                    continue;
                }
                $builder = $builder->where($field, $condition, $val);
            } else {
                if (!$this->isFillable($field)) {
                    continue;
                }
                $builder = $builder->where($field, '=', $value);
            }
        }

        return $builder;
    }

    public function orderBuilder($sorts, Builder $builder)
    {
        $fillables = $this->getFillable();

        if (empty($sorts) && in_array('id', $fillables)) {
            $sorts = ['id' => 'DESC'];
        }

        if (isset($sorts) AND !empty($sorts)) {
            foreach ($sorts as $k => $v) {
                $pos = strpos($k, '.');
                if($pos == 0){
                    if (!in_array($k, $fillables)) {
                        continue;
                    }
                    $k = $this->model->getTable() . '.' .$k;
                }

                $builder = $builder->orderBy($k, $v);
            }
        }

        return $builder;
    }

    public function getFillable()
    {
        $fillables  = $this->model->getFillable();
        $primaryKey = $this->model->getKeyName();
        $createdAt  = $this->model->getCreatedAtColumn();
        $updatedAt  = $this->model->getUpdatedAtColumn();
        if (!in_array($primaryKey, $fillables)) {
            array_push($fillables, $primaryKey, $createdAt, $updatedAt);
        }

        $this->all_columns = $fillables;

        return $fillables;
    }

    public function isFillable($key)
    {
        if (!$this->all_columns) {
            $this->getFillable();
        }

        if (!in_array($key, $this->all_columns)) {
            return false;
        }

        return true;
    }

    /**
     * @param  array  $dataInsert
     * @return bool
     */
    public function inserts(array $dataInsert)
    {
        return $this->model->insert($dataInsert);
    }
}
