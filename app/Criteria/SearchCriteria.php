<?php

namespace App\Criteria;

use Log;
use Schema;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class SearchCriteria.
 *
 * @package namespace App\Criteria;
 */
class SearchCriteria extends RequestCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param string              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $fieldsSearchable = $repository->getFieldsSearchable();
        foreach ($fieldsSearchable as $field => $condition) {
            if (is_numeric($field)) {
                $fieldsSearchable[$condition] = "=";
                unset($fieldsSearchable[$field]);
            }
        }
        $modelFields = Schema::getColumnListing($model->getTable());
        $model = $model->when(!is_null($this->request->search), function ($query) use ($fieldsSearchable, $modelFields) {
                            $query->where(function ($query) use ($fieldsSearchable, $modelFields) {
                                foreach ($fieldsSearchable as $field => $condition) {
                                    if ($condition === 'like' || $condition === 'ilike') {
                                        $explodes = explode('.', $field);

                                        if(count($explodes) === 1) {
                                            $query->orWhere($field, 'like', '%'.$this->request->search.'%');
                                        } else {
                                            $relation = $explodes[0];
                                            $relationField = $explodes[1];
                                            try {
                                                $query->orWhereHas($relation, function ($query) use ($relationField) {
                                                    $query->where($relationField, 'like', '%'.$this->request->search.'%');
                                                });
                                            } catch (\Throwable $th) {
                                                Log::info($th->getMessage());
                                            }
                                        }
                                    } else {
                                        if (!in_array($field, ['status']) && in_array($field, $modelFields)) {
                                            $query->orWhere($field, $this->request->search);
                                        }
                                    }
                                }
                            });
                        })
                        ->when(count($this->request->except('search')), function ($query) use ($fieldsSearchable, $model) {
                            foreach (array_keys($this->request->except('search')) as $field) {

                                if (!is_null($this->request->$field)) {
                                    if (in_array($field, array_keys($fieldsSearchable))) {
                                        $query->where($field, $this->request->$field);
                                    } else {
                                        if (in_array(str_replace('_', '.', $field), array_keys($fieldsSearchable))) {
                                            $explodes = explode('_', $field);
                                            if(count($explodes) === 2) {
                                                $relation = $explodes[0];
                                                $relationField = $explodes[1];
                                                try {
                                                    $query->whereHas($relation, function ($query) use ($field, $relationField) {
                                                        $query->where($relationField, $this->request->$field);
                                                    });
                                                } catch (\Throwable $th) {
                                                    Log::info($th->getMessage());
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        });

        return $model;
    }
}
