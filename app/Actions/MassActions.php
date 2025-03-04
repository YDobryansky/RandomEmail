<?php
/**
 * Create: Volodymyr
 */

namespace App\Actions;

use App\Models\ToolItemHistory;

class MassActions
{
    protected array $items = [];

    public function __construct(protected string $model)
    {
    }

    public function add(array $data): static
    {
        $this->items[] = $data;
        return $this;
    }

    public function insert()
    {
        if (empty($this->items)) {
            return null;
        }
        $result = $this->model::insert($this->items);
        $this->items = [];
        return $result;
    }

    public function upsert(array $unique, array $update)
    {
        if (empty($this->items)) {
            return null;
        }
        $result = $this->model::upsert($this->items, $unique, $update);
        $this->items = [];
        return $result;
    }
}
