<?php

interface DataInterface
{
    public function tambah($data);
    public function update($id, $data);
    public function hapus($id);
}