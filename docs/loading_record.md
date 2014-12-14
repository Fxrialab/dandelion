# Loading record

This is find a record with determine id

```
public function findByPk($model, $id)
    {
        if (!empty($model) && !empty($id))
            return Model::get($model)->find($id);
        else
            return false;
    }```

Example:

```
$this->facade->findByPk('status', '14:1');```

