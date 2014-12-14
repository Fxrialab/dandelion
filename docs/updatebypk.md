# UpdateByPk

Update record is determine by id

```
 public function updateByPk($model, $id, $record)
    {
        if (!empty($model) && !empty($id) && !empty($record))
            return Model::get($model)->update($id, $record);
        else
            return false;
    }
```

Example:

 ```
    <?php
     $this->facade->updateByPk('status', '14:1');
    ?>```

