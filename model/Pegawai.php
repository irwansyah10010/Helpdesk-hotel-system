<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace model;

use engine\abstraction\Model;

class Pegawai extends Model {

    // Field yg di masukan ialah yang tidak mempunyai atribut Auto Increment
    function __construct() {
        $this->initial();
        
        $this->setPrimaryKey('nip');
        
        $this->setTable("pegawai");
        
        $this->setField(['nip','nama_pegawai','kode_departement','jabatan','email','tanggal_lahir','foto']);
        
    }
}