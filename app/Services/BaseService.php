<?php

namespace App\Services;

use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Facades\DB;

abstract class BaseService
{
    /**
     * @var BaseRepository;
     */
    protected $mainRepository;

    /**
     * Load relationship
     * @var array
     */
    protected $with_load = [];

    /**
     * @var array
     */
    protected $filter = [];

    /**
     * @var Builder
     */
    protected $builder;

    public function find($id)
    {
        return $this->mainRepository->find($id);
    }

    /**
     * @param $id
     * @param  array  $options
     *
     * @return BaseRepository|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function findOr404($id, $options = [])
    {
        $entity = $this->mainRepository->find($id);

        if ($entity) {
            foreach ($options as $key => $value) {
                if ($entity->$key != $value) {
                    abort(404);
                }
            }

            return $entity;
        }

        abort(404);
    }

    public function all()
    {
        return $this->mainRepository->all();
    }

    public function prepareInsertOrUpdate($attributes)
    {
        foreach ($attributes as $key => $input) {
            if ($input instanceof UploadedFile) {
                $name = uniqid() . "-" . time() . '.' . $input->getClientOriginalExtension();

                $path = date('Y').date('m').date('d');

                Storage::putFileAs($path, $input, $name);
                $attributes[$key] = $path . "/" . $name;
            }
        }

        return $attributes;
    }

    public function update($id, array $attributes, array $options = [])
    {
        $attributes = $this->prepareInsertOrUpdate($attributes);

        return $this->mainRepository->update($id, $attributes, $options);
    }

    public function create($attributes)
    {
        $attributes = $this->prepareInsertOrUpdate($attributes);

        return $this->mainRepository->create($attributes);
    }

    public function inserts($data)
    {
        $this->mainRepository->inserts($data);
    }

    public function destroy($id)
    {
        return $this->mainRepository->delete($id);
    }

    public function paginate($limit = PAGE_LIMIT, $options = [])
    {
        $options['limit'] = $limit;
        $this->makeBuilder($options);

        return $this->endFilter();
    }

    public function filter($options = [])
    {
        $this->makeBuilder($options);

        return $this->endFilter();
    }

    public function makeBuilder($has_change = [])
    {
        $this->makeFilter($has_change);

        $this->builder = $this->mainRepository->makeModel()->with($this->with_load);
    }

    public function makeFilter($has_change = [])
    {
        $this->with_load = $has_change['with_load'] ?? $this->with_load;

        $this->filter = $this->requestParse($has_change);

        return $this->filter;
    }

    public function endFilter()
    {
        $this->builder = $this->mainRepository->whereBuilder($this->filter, $this->builder);
        $this->builder = $this->mainRepository->orderBuilder($this->filter->get('sort'), $this->builder);

        if ($this->filter->has('fields')) {
            $this->builder = $this->builder->select($this->filter->get('fields'));
        }

        if ($this->filter->has('all')) {
            return $this->builder->get();
        }

        if ($this->filter->has('get')) {
            $limit = $this->filter->get('get', 0);
            if (is_numeric($limit) && $limit > 0) {
                return $this->builder->limit($limit)->get();
            }
            return $this->builder->get();
        }

        if ($this->filter->has('limit') && $this->filter->get('limit') == false) {
            return $this->builder->get();
        }

        return $this->builder->paginate($this->filter->get('limit'));
    }

    public function cleanFilterBuilder(array $key)
    {
        $this->filter = $this->filter->forget($key);
    }

    public function requestParse($has_change = [])
    {
        $all_request = $this->filterRequest(app('request'));

        $result = collect($all_request['filter']);

        $result = $result->merge(['sort' => $all_request['sort'], 'limit' => $all_request['limit']]);

        if (!empty($has_change)) {
            unset($has_change['with_load']);
            $result = $result->merge($has_change);
        }

        return $result;
    }

    public function filterRequest(Request $request)
    {

        $result['filter']   = [];
        $result['download'] = ($request->input('download', false) === 'true') ? true : false;

        // Get and sanitize filters from the URL
        $limit = $request->get('limit');
        if (empty($limit)) {
            $limit = config('settings.paginate');
        }
        $result['limit'] = $limit;
        if ($raw_filters = $request->all()) {
            Arr::forget($raw_filters, ['token', 'sort', 'fields', 'page', 'limit', 'download', 'with_load']);
            foreach ($raw_filters as $k => $v) {
                if (is_array($v)) {
                    $result['filter'][$k] = array_filter($v, function ($elm) {
                        return filter_var($elm, FILTER_SANITIZE_MAGIC_QUOTES);
                    });
                } else {
                    $v = trim($v);
                    if (strlen($v) == 0) {
                        continue;
                    }
                    if(!empty($request->search)) {
                        $keywords = explode(',', $request->search);
                        foreach ($keywords as &$keyword) {
                            $keyword = filter_var(trim($keyword), FILTER_SANITIZE_MAGIC_QUOTES);
                        }
                        $result['filter']['search'] = $keywords;
                    } else {
                        $result['filter'][$k] = filter_var($v, FILTER_SANITIZE_MAGIC_QUOTES);
                    }
                }
            }
        }

        $result['sort'] = $this->parseSorting($request->input('sort'));

        $result['fields'] = ['*'];

        if ($request->has('fields')) {
            $fields           = explode(',', $request->get('fields'));
            $result['fields'] = array_filter(array_map('trim', $fields));
        }

        return $result;
    }

    public function parseSorting($string)
    {
        $result = [];

        $sort = explode(',', $string);
        $sort = array_map(function ($s) {
            $s = filter_var($s, FILTER_SANITIZE_STRING);
            return trim($s);
        }, $sort);
        foreach ($sort as $expr) {
            if (empty($expr)) {
                continue;
            }
            if ('-' == substr($expr, 0, 1)) {
                $result[substr($expr, 1)] = 'DESC';
            } else {
                $result[$expr] = 'ASC';
            }
        }
        return $result;
    }
}
