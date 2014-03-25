<?php

interface IDataModel
{
    function save($data, $excludes = '');

    function load($id);

    function findOne($conditions, $values);
    
    function findByCondition($conditions, $values);

    function findAll();

    function update($recordID, $record);

    function updateByCondition($data, $conditions, $values);

    function count($conditions, $values);

    function delete($recordID);

    function deleteByCondition($conditions, $values);
}