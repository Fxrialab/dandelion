<?php
class DataFacade {

    /**
     * Save data to record
     *
     * @param string $model This is name of model need save data
     * @param array $data This is data for save
     * @return string
     */
    public function save($model, $data)
    {
        if (!empty($model) && is_array($data))
            $result = Model::get($model)->save($data);
        else
            $result = false;

        return $result;
    }

    /**
     * Loading record on model
     *
     * @param string $model
     * @param string $recordID
     * @return array
     */
    public function load($model, $recordID)
    {
        if (!empty($model) && is_string($recordID))
            $result = Model::get($model)->load($recordID);
        else
            $result = false;

        return $result;
    }

    /**
     * This is find a record with determine id
     *
     * Here is an inline example:
     * <code>
     * <?php
     * $this->facade->findByPk('status', '14:1');
     * ?>
     * </code>
     * @param string $model
     * @param string $id
     * @return bool|object
     */
    public function findByPk($model, $id)
    {
        if (!empty($model) && !empty($id))
            $result = Model::get($model)->find($id);
        else
            $result = false;

        return $result;
    }

    /**
     * This is find an or many record by conditions
     *
     * Here is an inline example:
     * <code>
     * <?php
     * $this->facade->findByAttributes('user', array('username'=>'userA', 'email'=>'userA@gmail.com'));
     * ?>
     * </code>
     * @param string $model
     * @param array $array
     * @return bool|array
     */
    public function findByAttributes($model, $array)
    {
        if (!empty($model) && is_array($array))
        {
            $condition  = "";
            $operator   = " AND ";
            foreach ($array as $key => $v) {
                $condition = $condition.$operator.$key." = ?";
                $value[] = $v;
            }
            $condition = substr($condition,strlen($operator));

            return Model::get($model)->findByCondition($condition, $value);
        }else {
            return false;
        }
    }

    /**
     * This is find all record with condition as object
     *
     * Here is an inline example:
     * <code>
     * <?php
     * $obj = new ObjectHandler();
     * $obj->email = 'userA@gmail.com';
     * $obj->select = "ORDER BY published ASC";
     * $this->facade->findAll('status', $obj);
     * ?>
     * </code>
     * @param string $model
     * @param object $object
     * @return bool|array
     */
    public function findAll($model, $object)
    {
        if (!empty($model) && is_object($object))
        {
            $array  = get_object_vars($object);
            if (count($array) > 1)
            {
                $select = $array['select'];
                array_shift($array);
                $condition  = "";
                $operator   = " AND ";
                foreach ($array as $key => $v) {
                    $condition = $condition.$operator.$key." = ?";
                    $value[] = $v;
                }
                $condition = substr($condition,strlen($operator));
                $condition = $condition . (!isset($select) ? "" : " " .$select);

                return Model::get($model)->findByCondition($condition, $value);
            }else
                return false;
        }else {
            return false;
        }
    }

}
