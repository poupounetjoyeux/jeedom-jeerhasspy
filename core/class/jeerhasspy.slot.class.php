<?php

class JeerhasspySlot
{
    private $id;
    private $name;
    private $isSync;
    private $configuration;

    public function getId()
    {
        return $this->id;
    }

    public function setId($_id)
    {
        $this->id = $_id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($_name)
    {
        $this->name = str_replace(' ', '', $_name);
    }

    public function getIsSync()
    {
        return JeerhasspyUtils::toBool($this->isSync);
    }

    public function setIsSync($_isSYnc)
    {
        $this->isSync = JeerhasspyUtils::boolToInteger($_isSYnc);
    }

    public function getConfiguration()
    {
        return $this->configuration;
    }

    public function setConfiguration($_configuration)
    {
        $this->configuration = $_configuration;
    }

    public function save()
    {
        return DB::save($this);
    }

    public function remove()
    {
        DB::remove($this);
    }

    public function update($_slot)
    {
        $result = new JeerhasspyResponse();
        if (!isset($_slot['name']) || trim($_slot['name']) === '') {
            return $result->setError('{{Un slot requiert un nom}}');
        }
        $this->setName($_slot['name']);
        $this->setIsSync(JeerhasspyUtils::boolToInteger($_slot['isSync']));
        $this->setConfiguration($_slot['configuration']);
        return $result->setSuccess();
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'isSync' => JeerhasspyUtils::toBool($this->getIsSync()),
            'configuration' => $this->getConfiguration()
        ];
    }

    public static function all()
    {
        $sql = 'SELECT ' . DB::buildField(__CLASS__) . '
		FROM ' . __CLASS__;
        return DB::Prepare($sql, array(), DB::FETCH_TYPE_ALL, PDO::FETCH_CLASS, __CLASS__);
    }

    public static function byId($_id)
    {
        $values = array(
            'id' => $_id,
        );
        $sql = 'SELECT ' . DB::buildField(__CLASS__) . '
		FROM ' . __CLASS__ . ' WHERE id=:id';
        $_slot = DB::Prepare($sql, $values, DB::FETCH_TYPE_ROW, PDO::FETCH_CLASS, __CLASS__);
        if (!$_slot) {
            return null;
        }
        return $_slot;
    }
}