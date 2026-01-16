<?php

require_once 'BaseModel.php';

class Category extends BaseModel
{
    private $is_active = 1;
    private $name;

    function getTableName()
    {
        return 'categories';
    }

    protected function addNewRec()
    {
        $param = array(
            ':name' => $this->name);

        return $this->pm->run("INSERT INTO " . $this->getTableName() . "(name) values(:name)", $param);
    }

   



   protected function updateRec()
    {
        $param = [
            ':name' => $this->name,
            ':is_active' => $this->is_active,
            ':id' => $this->id
        ];

        return $this->pm->run(
            "UPDATE categories SET name = :name, is_active = :is_active WHERE id = :id",
            $param
        );
    }


public function saveCall ($category_name,$is_active,$id) {

$existingCategory = $this->getCategoryByCategory($category_name,$id);

        if ($existingCategory) {
           
            return false; 
        }

        $this->id     = $id;
        $this->name         = $category_name;
        $this->is_active        = $is_active;
        $result = $this->save();
        if ($result) {
        return true;
     } else {
        return false;
     }

}

    

    function add_new_category($category_name)
    {
        $existingCategory = $this->getCategoryByCategory($category_name);

        if ($existingCategory) {
           
            return false; 
        }

       $this->name = $category_name;
       $categoryResult= $this->save();

        if ($categoryResult) {
            return $categoryResult; 
        } else {
            return false; 
        }
    }

    public function getCategoryByCategory($category_name, $categoryId=null){

    
    $param = [
        ':name' => $category_name 
    ];

    $query = "SELECT * FROM " . $this->getTableName() . " 
              WHERE name = :name";

    if ($categoryId !== null) {
        $query .= " AND id != :categoryId";
        $param[':categoryId'] = $categoryId;
    }

    $result = $this->pm->run($query, $param);

    return $result;

    }

   
public function setId($id) {
    $this->id = $id;
}
 
  public function getAllCategory()
{

    return $this->pm->run("
        SELECT * FROM " . $this->getTableName() . " 
    ");
}

 public function getCategoryByCtgId($id)
{
    $param = array(':id' => $id);

    return $this->pm->run("
        SELECT * FROM " . $this->getTableName() . " 
        WHERE id = :id
    ", $param,true);
}







public function deleteRec($id)
    {
        $param = array(':id' => $id);
        return $this->pm->run("DELETE FROM " . $this->getTableName() . " WHERE id = :id", $param);
    }


  public function getCategories()
{
    $sql = "SELECT id, name FROM categories WHERE is_active = 1 ORDER BY name ASC";
    return $this->pm->run($sql);
}


 

    


    
}
