<?php
namespace App\Wiki;

class Selector {

    private $id = 1;
    private $idMax = 1;

    function __construct(int $idMax) {
        $this->idMax = $idMax;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }
    
    /**
     * next -> Next page
     *
     * @return int Return the page number
     */
    public function next(): int 
    {
        $id2 = $this->id;
        $id2++;
        if ($id2 <= $this->idMax) {
            return $id2;
        } else {
            return $this->id;
        }
    }
        
    /**
     * previously > Last page
     *
     * @return int Return the page number
     */
    public function previously(): int 
    {
        if ($this->id != 1 && $this->id != 0) {
            $this->id -= 1;
            return $this->id;
        } else {
            return $this->id;
        }
    }

    public function getId(): int
    {
        return $this->id;
    }
    
    public function getIdMax(): int
    {
        return $this->idMax;
    }
}

