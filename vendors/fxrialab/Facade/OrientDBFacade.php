<?php

/**
 * <ul>
 * <li>{$facade = new OrientDBFacade();}</li>
 * <li>{findAll():$facade->findAll()}</li>
 * <li>{findByPk():$facade->findByPk($id)}</li>
 * <li>{findByAttributes():$facade->findByAttributes(array())}</li>
 * <li>{findAllAttributes():$facade->findAllByAttributes(array())}</li>
 * <li>{count:$facade->count()}</li>
 * </ul>
 */
class OrientDBFacade {

    function findAll($model, $params = array()) {
        foreach ($params as $key => $v) {
            $k[] = $key;
            $value[] = $v;
        }
        if (count($params) == 1) {
            $model = Model::get($model)->findByCondition("$k[0] = '" . $value[0] . "' ORDER BY published DESC LIMIT 4");
        } else {
            $model = Model::get($model)->findByCondition("$k[0] = '" . $value[0] . "' AND $k[1] = '" . $value[1] . "' ORDER BY published DESC LIMIT 4");
        }
        return $model;
    }

    function findByPk($model, $params) {
        return Model::get($model)->findOne("@rid = ?", array($params));
    }

    function loadingPost($model,$limit,$offset) {
        $model = Model::get($model)->findByCondition("type='post' ORDER BY published DESC LIMIT  " . $limit . " OFFSET " . $offset);
        return $model;
    }

    function findAllAttributes($model, $params = array()) {
        foreach ($params as $key => $v) {
            $k[] = $key;
            $value[] = $v;
        }
        if (count($params) == 1) {
            $model = Model::get($model)->findByCondition("$k[0] = '" . $value[0]);
        } else {
            $model = Model::get($model)->findByCondition("$k[0] = '" . $value[0] . "' AND $k[1] = '" . $value[1] . "'");
        }
        return $model;
    }

    function findByAttributes($model, $params = array()) {
        foreach ($params as $key => $v) {
            $k[] = $key;
            $value[] = $v;
        }

        if (count($params) == 1)
            $model = Model::get($model)->findOne("$k[0] = ?", array($value[0]));
        else
            $model = Model::get($model)->findOne("$k[0] = ? AND $k[1] = ?", array($value[0], $value[1]));
        return $model;
    }

    function count($model, $params) {
        return Model::get($model)->count("post = ?", array($params));
    }

}
