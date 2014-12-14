# FindAllAttributes

This is find an or many record by conditions. Default as AND operator in condition

```
 public function findAllAttributes($model, $array)
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

            return Model::get($model)->findByCondition($condition, $value);
        }
        else
        {
            return false;
        }
    }```

Example:

```
$this->facade->findAllAttributes('user', array('username'=>'userA', 'email'=>'userA@gmail.com'));```


