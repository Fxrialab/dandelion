<?php

class DataFacade
{

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
            return Model::get($model)->save($data);
        else
            return false;
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
            return Model::get($model)->load($recordID);
        else
            return false;
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
            return Model::get($model)->find($id);
        else
            return false;
    }

    /**
     * This is find an record by conditions. Default as AND operator in condition
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
    }

    /**
     * This is find an or many record by conditions. Default as AND operator in condition
     *
     * Here is an inline example:
     * <code>
     * <?php
     * $this->facade->findAllAttributes('user', array('username'=>'userA', 'email'=>'userA@gmail.com'));
     * ?>
     * </code>
     * @param string $model
     * @param array $array
     * @return bool|array
     */
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
            $array = get_object_vars($object);
            if (count($array) > 1)
            {
                $select = $array['select'];
                array_shift($array);
                $conditions = "";
                $operator = " AND ";
                foreach ($array as $key => $v)
                {
                    $conditions = $conditions . $operator . $key . " = ?";
                    $value[] = $v;
                }
                $conditions = substr($conditions, strlen($operator));
                $conditions = $conditions . (!isset($select) ? "" : " " . $select);

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
    }

    /**
     * Update record is determine by id
     *
     * Here is an inline example:
     * <code>
     * <?php
     * $this->facade->updateByPk('status', '14:1');
     * ?>
     * </code>
     * @param string $model
     * @param string $id
     * @param $record
     * @return bool
     */
    public function updateByPk($model, $id, $record)
    {
        if (!empty($model) && !empty($id) && !empty($record))
            return Model::get($model)->update($id, $record);
        else
            return false;
    }

    /**
     * Update record is determine by conditions. Default as AND operator in condition
     *
     * Here is an inline example:
     * <code>
     * <?php
     * $data = array('comment'=>5, 'content'=>'none');
     * $this->facade->updateByAttributes('user', $data, array('username'=>'userA', 'email'=>'userA@gmail.com'));
     * ?>
     * </code>
     * @param string $model
     * @param array $data
     * @param array $array
     * @return bool
     */
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
    }

    /**
     * Delete record is determine by id
     *
     * Here is an inline example:
     * <code>
     * <?php
     * $this->facade->deleteByPk('status', '14:1');
     * ?>
     * </code>
     * @param string $model
     * @param string $id
     * @return bool
     */
    public function deleteByPk($model, $id)
    {
        if (!empty($model) && !empty($id))
            return Model::get($model)->delete($id);
        else
            return false;
    }

    /**
     * Delete record is determine by conditions. Default as AND operator in condition
     *
     * Here is an inline example:
     * <code>
     * <?php
     * $this->facade->deleteByAttributes('user', array('username'=>'userA', 'email'=>'userA@gmail.com'));
     * ?>
     * </code>
     * @param string $model
     * @param array $array
     * @return bool
     */
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
    }

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

}
