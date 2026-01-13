<?php
require_once __DIR__.'/../helpers/AppManager.php';

abstract class BaseModel
{
    protected $pm;
    protected $id;
 

    public function __construct()
    {
        $this->pm = AppManager::getPM();
    }

    abstract protected function getTableName();

    abstract protected function addNewRec();

    abstract protected function updateRec();

    public function getAll()
    {
        return $this->pm->run("SELECT * FROM " . $this->getTableName());
    }

    public function getById($id)
    {
        $param = array(':id' => $id);
        return $this->pm->run("SELECT * FROM " . $this->getTableName() . " WHERE id = :id", $param, true);
    }

   
    public function startTransaction()
    {
        return $this->pm->run("START TRANSACTION");
    }

    public function commit()
    {
        return $this->pm->run("COMMIT");
    }

    public function rollback()
    {
        return $this->pm->run("ROLLBACK");
    }

    public function save()
    {
        if (isset($this->id) && $this->id > 0) {
            return $this->updateRec();
        } else {
            return $this->addNewRec();
        }
    }

 public function deleteRec($id)
    {
        $param = array(':id' => $id);
        return $this->pm->run("DELETE FROM " . $this->getTableName() . " WHERE id = :id", $param);
    }
}
