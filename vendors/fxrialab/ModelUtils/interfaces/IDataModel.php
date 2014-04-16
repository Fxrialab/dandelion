<?php

interface IDataModel
{
    function save($data);

    function load($id);

    function find($id);
    
    function findByCondition($conditions, $values);

    function findCustomers($conditions);

    function update($id, $record);

    function updateByCondition($data, $conditions, $values);

    function countByCondition($conditions, $values);

    function delete($recordID);

    function deleteByCondition($conditions, $values);
}