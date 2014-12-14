# DeleteByPk

Delete record is determine by id

```
public function deleteByPk($model, $id)
    {
        if (!empty($model) && !empty($id))
            return Model::get($model)->delete($id);
        else
            return false;
    }```

Example:

```
   <?php
    $this->facade->deleteByPk('status', '14:1');
   ?>
```
