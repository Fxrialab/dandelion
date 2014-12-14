# UpdateByAttributes

Update record is determine by conditions. Default as AND operator in condition

```
public function updateByAttributes($model, $data, $array)
    {

        if (!empty($model) && is_array($data) && is_array($array) && count($array) > 0)
        {
            $condition = "";
            $operator = " AND ";
            foreach ($array as $key => $v)
            {

                $condition = $condition . $operator . $key . " = ?";
                $value[] = $v;
            }
            $condition = substr($condition, strlen($operator));
            $update = Model::get($model)->updateByCondition($data, $condition, $value);
            if ($update == 1)
                return str_replace(array('!', '@', '#', '$', '%'), '', $value[0]);
        }
        else
        {
            return false;
        }
    }```

Example:

 ```
  <?php
    $data = array();
    $this->facade->updateByAttributes('user', $data, array('username'=>'userA', 'email'=>'userA@gmail.com'));
    ?>```

