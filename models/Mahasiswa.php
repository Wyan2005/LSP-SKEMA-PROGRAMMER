<?php

require_once "Model.php";
require_once "DataInterface.php";

class Mahasiswa extends Model implements DataInterface
{
    public function tambah($data)
    {
        $nim = $data['nim'];
        $nama = $data['nama'];
        $prodi = $data['prodi'];
        $angkatan = $data['angkatan'];

        $query = "INSERT INTO mahasiswa (nim,nama,prodi,angkatan)
                  VALUES ('$nim','$nama','$prodi','$angkatan')";

        return mysqli_query($this->conn, $query);
    }

    public function update($id, $data)
    {
        $query = "UPDATE mahasiswa SET
                  nim='{$data['nim']}',
                  nama='{$data['nama']}',
                  prodi='{$data['prodi']}',
                  angkatan='{$data['angkatan']}'
                  WHERE id='$id'";

        return mysqli_query($this->conn, $query);
    }

    public function hapus($id)
    {
        $query = "DELETE FROM mahasiswa WHERE id='$id'";
        return mysqli_query($this->conn, $query);
    }
}