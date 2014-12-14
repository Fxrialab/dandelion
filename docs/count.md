# Count

Count record

```
public function count($model, $array)
    {
        if (!empty($model) && is_array($array) && count($array) > 0)
        {
            $condition = "";
            $operator = " AND ";
            foreach ($array as $key => $v)
            {
                $condition = $condition . $operator . $key . " = ?";
                $value[] = $v;
            }
            $condition = substr($condition, strlen($operator));

            return Model::get($model)->countByCondition($condition, $value);
        }
        else
        {
            return false;
        }
    }
```
