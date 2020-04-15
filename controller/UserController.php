<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controller;


use engine\abstraction\Controller;
use engine\http\Session;

class UserController extends Controller{
    private $session;
    //put your code here
    public function __construct() {
        parent::__construct();

        $this->session = new Session();
    }
    
    public function create(){
        $this->response->view('help/index');
    }
    
    public function save(){
        // post(requestData,tipeData yang diinginkan(string,angka),validasi satuan(null,string,number))

        $namaDepan = $this->request->post('namaDepan','string','null');
        $namaBelakang = $this->request->post('namaBelakang','string','null');
        $umur = $this->request->post('umur','string','null');
        
        $exampleValidation = [
            $namaDepan => 'number/null/string',
            $namaBelakang => 'number/null/string',
            $umur => 'number/null'
        ];
        
        // validasi dengan data kelompok
        //$this->request->validation($exampleValidation);
        
        $model = new ModelExample();
        
        $model->fields = [$namaDepan,$namaBelakang,$umur];
        $model->save();
        
        $this->response->redirect('help/','data berhasil ditambah');
        
    }
    
    function update() {
        $id = $this->request->post('id','null');
        $namaDepan = $this->request->post('namaDepan','null');
        $namaBelakang = $this->request->post('namaBelakang','null');
        $umur = $this->request->post('umur','number');
        
        $model = new ModelExample();
        
        $model->fields = [$namaDepan,$namaBelakang,$umur];
        $model->update($id);
        
        $this->response->redirect('help/','data berhasil diperbarui');
    }
    
    function remove() {
        $id = $this->request->get(1);
        
        $model = new ModelExample();
        
        $model->remove($id);
        
        $this->response->redirect('help/','data berhasil di hapus');
    }
    
    function search() {
        $colom = $this->request->post('sort','mhsID');
        $type = $this->request->post('type','ASC');
        
        echo $colom;
        echo $type;
        
        $this->response->redirect('help/1/column/'.$colom.'/tipe/'.$type.'/');
    }

    function login(){
        
        $username = $this->request->post('email','null');
        $password = $this->request->post('password','null');

        $user = new \model\User();

        $user->select($user->getTable())->where()->comparing("username",$username)->ready();

        $row = $user->getStatement()->fetch();

        if($row){
            
            $user = new \model\User();
            $user->select($user->getTable())->where()->comparing("username",$username)
            ->and()->comparing("password",$password)->ready();

            $rowWithPassword = $user->getStatement()->fetch();

            if($rowWithPassword){

                $pegawai = new \model\Pegawai();
                $pegawai->select($pegawai->getTable())->where()
                ->comparing("nip",$rowWithPassword['nip'])->ready();

                $rowPegawai = $pegawai->getStatement()->fetch();

                $this->session->set('hak_akses',$rowWithPassword['hak_akses']);

                $this->session->set('nip',$rowPegawai['nip']);
                $this->session->set('nama_pegawai',$rowPegawai['nama_pegawai']);
                $this->session->set('gambar',$rowPegawai['foto']);
                
                $this->response->redirect('');
            }else{
                $this->response->back('password yang dimasukan salah');
            }
        }else{
            $this->response->back('username tidak ditemukan');
        }
    }

    function logout(){
        session_destroy();

        $this->response->redirect('User/Login/');
    }
    
}
