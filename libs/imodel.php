<?php
    /******* NOs permite definir metodos que despues deben ser implementados */
    interface IModel{
        public function save();
        public function getAll();
        public function get($id);
        public function delete($id);
        public function update();
        public function from($array);
    }

?>