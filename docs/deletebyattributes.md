# DeleteByAttributes

Delete record is determine by conditions. Default as AND operator in condition

```
public function deleteByAttributes($model, $array)
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

            return Model::get($model)->deleteByCondition($condition, $value);
        }
        else
        {
            return false;
        }
    }```

Example:

 ```
<?php
    $this->facade->deleteByAttributes('user', array('username'=>'userA', 'email'=>'userA@gmail.com'));
  ?>```

