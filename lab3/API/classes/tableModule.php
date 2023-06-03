<?php
require_once "singleton.php";

abstract class TableModule
{
    abstract protected function getTableName(): string;



    public function uploadImage(){

        $uploadDir = $_SERVER['DOCUMENT_ROOT'].'/lab3/API/images/';
        $filename=basename($_FILES['file']['name']);
        $uploadFile = $uploadDir.$filename;
        $type=pathinfo($uploadFile, PATHINFO_EXTENSION);
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf','');
        if (in_array($type, $allowTypes)) {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $uploadFile))
                $response=['upload-image'=>'yes'];
            else
                $response=['upload-image'=>'no'];
        }
        else
            $response=['upload-image'=>'no'];
        return  $response;
    }
    public function deleteImage($id)
    {
        $query= 'SELECT * FROM '. $this->getTableName(). ' WHERE id='.$id;
        $query = Singleton::prepare($query);
        $query->execute([]);
        $result = array();
        while ($slice = $query->fetch()) {
            $result[] = $slice;
        }
        if (file_exists($_SERVER['DOCUMENT_ROOT'].'/lab3/API/images/'.$result[0]["img_path"])) {
            unlink($_SERVER['DOCUMENT_ROOT'] . '/lab3/API/images/' . $result[0]["img_path"]);
        }
    }
    /**
     * @param int $id
     * @throws PDOException
     */
    public function delete($id)
    {
        $sql = "DELETE FROM " . $this->getTableName() . " WHERE id=:id";
        $query = Singleton::prepare($sql);
        if (!$query->execute(array(":id" => $id))) {
            throw new PDOException("При удалении произошла ошибка!");
        }
    }
    /**
     * @param array $fields
     * @return array
     */
    public function read($needCountries=false,$countryFilter='default',$fields = array())
    {
        $sql = "SELECT * FROM " . $this->getTableName();
        if ($needCountries===true)
            $sql= "SELECT childrens.*,countries.country FROM childrens LEFT JOIN countries ON childrens.country = countries.id ";
        if ($countryFilter !== 'default')
        {
            if ($countryFilter)
                $sql.=  ' WHERE childrens.country='.$countryFilter;

        }
        foreach ($fields as $key => $field) {
            $sql .= "AND " . $key . "=" . $field . " ";
        }
        $query = Singleton::prepare($sql);
        $query->execute([]);
        $result = array();
        while ($slice = $query->fetch()) {
            $result[] = $slice;
        }
        return $result;
    }
    /**
     * @param array $field
     * @return array
     */

    /**
     * @param array $fields
     * @throws PDOException
     */
    public function create($fields)
    {
        $keys = [];
        $keyparam = [];
        $arField = [];
        foreach ($fields as $key => $field) {
            $keys[] = " " . $key;
            $keyparam[] = " :" . $key;
            $arField[":" . $key] = $field;
        }
        $keys = implode(", ", $keys);
        $keys = "(" . $keys . ")";
        $keyparam = implode(", ", $keyparam);
        $keyparam = "(" . $keyparam . ")";
        $sql = "INSERT INTO " . $this->getTableName() . " " . $keys . " VALUE " . $keyparam;
        $query = Singleton::prepare($sql);
        if (!$query->execute($arField)) {
            throw new PDOException("При добавлении произошла ошибка!");
        }
    }
    /**
     * @param array $fields
     * @throws PDOException
     */
    public function update($fields)
    {
        $keyparam = [];
        $arField = [];
        foreach ($fields as $key => $field) {
            if ($key != "id") {
                $keyparam[] = " `$key`=:" . $key;
            }
            $arField[":" . $key] = $field;
        }
        $keyparam = implode(", ", $keyparam);
        $sql = "UPDATE " . $this->getTableName() . " SET " . $keyparam . " WHERE id=:id";
        $query = Singleton::prepare($sql);
        if (!$query->execute($arField)) {
            throw new PDOException("При обновлении произошла ошибка!");
        }
    }

    /**
     * @param int $id
     * @return bool
     */
    public function exists($id): bool
    {
        $query = Singleton::prepare("SELECT * FROM " . $this->getTableName() . " WHERE id=" . $id);
        $query->execute([]);
        $find = $query->fetch();
        return boolval($find);
    }
    /**
     * @return int
     */
    public function lastID():int
    {
        $query = Singleton::prepare("SELECT MAX(ID) FROM " . $this->getTableName());
        $query->execute([]);
        $find = $query->fetch();
        return intval($find["MAX(ID)"]);
    }
}