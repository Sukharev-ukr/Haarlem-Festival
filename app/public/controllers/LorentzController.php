<?php
// app/public/controllers/LorentzController.php

require_once __DIR__ . '/../models/LorentzModel.php';

class LorentzController {
    private $model;

    public function __construct() {
        $this->model = new LorentzModel();
    }

    public function getLorentzData() {
        return $this->model->getLorentzData();
    }
}
