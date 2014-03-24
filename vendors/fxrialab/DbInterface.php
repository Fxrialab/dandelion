<?php
/**
 * Created by PhpStorm.
 * User: huynhtuvinh87
 * Date: 3/21/14
 * Time: 9:17 AM
 */
interface DbInterface
{
    public function create($data);
    
    public function findByCondition($conditions, $values);
    
    public function findOne($conditions, $values);
//
//    public function save($data);
//
//    public function update($data);
//
//    public function delete($data);
//
//    public function deleteById($data);
//
//    public function find($data);
//
//    public function findAll($data);
//
//    public function getClusterID();
}