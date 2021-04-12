<?php

namespace Core;

/** used in conjunction with the Model class */
class SqlParams extends Model
{
    public function orderParams(string $params): ?string
    {
        return $this->sql .= " ORDER BY {$params} ";
    }

    /** pagination */
    public function limitParams(string $type): string
    {
        switch($type) {
            case "sqlsrv":
                return $this->sql .= " OFFSET :offset ROWS FETCH NEXT :limit ROWS ONLY";
                break;
            case "mysql":
                return $this->sql .= " LIMIT :limit OFFSET :offset";
        }
    }
}
