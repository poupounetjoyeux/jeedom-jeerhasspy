<?php

class JeerhasspyResponse
{
    private $isSuccess;
    private $result;
    private $message;

    public function setSuccess($_result = null)
    {
        $this->isSuccess = true;
        $this->result = $_result;
        $this->message = null;
        return $this;
    }

    public function setImpossibleConnectionError($_uri)
    {
        $this->setError('{{Impossible de se connecter à l\'assistant Rhasspy}} ' . $_uri);
        return $this;
    }

    public function setError($_message = null)
    {
        $this->isSuccess = false;
        $this->result = null;
        if ($_message == null) {
            $this->message = '{{Une exception non gérée s\'est produite}}';
        } else {
            $this->message = $_message;
        }
        return $this;
    }

    public function fromResult(self $_result)
    {
        $this->isSuccess = $_result->isSuccess;
        $this->message = $_result->message;
        $this->result = $_result->result;
        return $this;
    }

    public function isSuccess()
    {
        return $this->isSuccess;
    }

    public function getResult()
    {
        return $this->result;
    }

    public function getJsonResult()
    {
        return JeerhasspyUtils::jsonResult($this->result);
    }

    public function getMessage()
    {
        return $this->message;
    }
}