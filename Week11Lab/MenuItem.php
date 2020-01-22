<?php
    class MenuItem
    {
        private $itemName;
        private $description;
        private $price;

        public function __construct($it, $des, $pr)
        {
            $this->itemName = $it;
            $this->description = $des;
            $this->price = $pr;
        }

        public function getItemName()
        {
            return $this->itemName;
        }
        public function getDescription()
        {
            return $this->description;
        }
        public function getPrice()
        {
            return $this->price;
        }
    }
