# FindByAttributes

This is find an record by conditions. Default as AND operator in condition

 ```
 public function findByAttributes($model, $array)
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

            return Model::get($model)->findOne($condition, $value);
        }
        else
        {
            return false;
        }
    }```

Example:

 ```
$this->facade->findByAttributes('user', array('username'=>'userA', 'email'=>'userA@gmail.com'));```

