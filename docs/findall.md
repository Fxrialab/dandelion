
# FindAll

This is find all record with condition as object.

 ```
public function findAll($model, $object)
    {
        if (!empty($model) && is_object($object))
        {
            $array = get_object_vars($object);

            if (count($array) > 1)
            {
                $select = $array['select'];
                array_shift($array);
                //add OR operator if condition have exist
                if (array_key_exists('OR',$array)){
                    $operatorOR = 'OR '.$array['OR'];
                    unset($array['OR']);
                }

                $conditions = "";
                $operator = " AND ";
                foreach ($array as $key => $v)
                {
                    $conditions = $conditions . $operator . $key . " = ?";
                    $value[] = $v;
                }
                $conditions = substr($conditions, strlen($operator));
                $conditions = $conditions . (!isset($operatorOR) ? "" : " " . $operatorOR).(!isset($select) ? "" : " " . $select);

                return Model::get($model)->findByCondition($conditions, $value);
            }
            else
            {
                $select = $array['select'];
                $conditions = (!isset($select) ? "" : " " . $select);

                return Model::get($model)->findCustomers($conditions);
            }
        }
        else
        {
            return false;
        }
    }```


Example:

```
    <?php
     $obj = new ObjectHandler();
     $obj->email = 'userA@gmail.com';
     $obj->select = "ORDER BY published ASC";
     $this->facade->findAll('status', $obj);
     ?>```

