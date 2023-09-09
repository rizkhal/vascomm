<?php

namespace App\Abstract;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Rizkhal\Inertable\Inertable as BaseRizkhalInertable;
use Rizkhal\Inertable\Utils\ColumnAttributes;

abstract class Inertable extends BaseRizkhalInertable
{
    public function applyInertable(Request $request): LengthAwarePaginator
    {
        $query = $this->query();

        $query = $this->applySorting($request, $query);

        $query = $this->applySearchFilter($request, $query);

        return $query->paginate($this->perPage())->withQueryString()->through(fn ($model) => $this->through($model));
    }

    private function through(Model $model): array
    {
        $items = [];

        foreach ($this->columnsMerged() as $column) {
            if (ColumnAttributes::hasRelation($column->column)) {
                if (ColumnAttributes::hasMultipleRelation($column->column)) {
                    if ($this->getColumn($column->column)->hasFormatCallback()) {
                        $items[$column->column] = app()->call($this->getColumn($column->column)->getFormatCallback(), ['value' => $model->{$column->column}, 'row' => $model]);
                    } else {
                        [$relationName_1, $relationName_2, $relationAttribute_1] = explode('.', $column->column);
                        $items[$column->column] = $model->{$relationName_1}?->{$relationName_2}?->{$relationAttribute_1};
                    }
                } else {
                    if ($this->getColumn($column->column)->hasFormatCallback()) {
                        $items[$column->column] = app()->call($this->getColumn($column->column)->getFormatCallback(), ['value' => $model->{$column->column}, 'row' => $model]);
                    } else {
                        [$relationName, $relationAttribute] = explode('.', $column->column);
                        $items[$column->column] = $model->{$relationName}?->{$relationAttribute};
                    }
                }
            } else {
                if ($this->getColumn($column->column)->hasFormatCallback()) {
                    $items[$column->column] = app()->call($this->getColumn($column->column)->getFormatCallback(), ['value' => $model->{$column->column}, 'row' => $model]);
                } else {
                    $items[$column->column] = $model->{$column->column};
                }
            }
        }

        return $items;
    }
}
