<?php
require_once __DIR__."/security.php";
class Auction
{
    public $db;
    public function __construct() {
        $config = is_file(__DIR__.'/config.local.php') ? require __DIR__.'/config.local.php' : [];
        $host=getenv('AUCTION_DB_HOST') ?: ($config['host']??'127.0.0.1');
        $name=getenv('AUCTION_DB_NAME') ?: ($config['name']??'dbauction_portfolio');
        $user=getenv('AUCTION_DB_USER') ?: ($config['user']??'');
        $pass=getenv('AUCTION_DB_PASS'); if ($pass===false) $pass=$config['pass']??'';
        if (!$user) throw new RuntimeException('Konfigurasi database belum tersedia.');
        $this->db=new PDO("mysql:host=$host;dbname=$name;charset=utf8mb4",$user,$pass,[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_EMULATE_PREPARES=>false,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]);
    }
    private function authenticate($table,$name,$password) {
        $q=$this->db->prepare("SELECT id,password FROM $table WHERE nama=?"); $q->execute([$name]); $row=$q->fetch();
        $hash=$row['password']??'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
        $valid=password_verify($password,$hash);
        return $row && $valid ? ['id'=>$row['id']] : false;
    }
    public function cekLoginUser($usn,$pw) { return $this->authenticate('tbuser',$usn,$pw); }
    public function cekLoginAdmin($usn,$pw) { return $this->authenticate('tbadmin',$usn,$pw); }

    public function tampilkanDataUser()
    {
        $query = $this->db->prepare(
            "SELECT id,nama,no_rekening FROM tbuser"
        );

        $query->execute();

        $data = $query->fetchAll();

        return $data;
    }

    public function simpanLogin($a, $b, $c)
    {
        $query = $this->db->prepare(
            "INSERT INTO tbuser (nama,password,no_rekening) VALUES(:nama, :password, :no_rekening)"
        );
        $query->bindParam(":nama", $a);
        $b = password_hash($b, PASSWORD_DEFAULT);
        $query->bindParam(":password", $b);
        $query->bindParam(":no_rekening", $c);

        if ($query->execute())
            return true;
        else
            return false;
    }

    public function tampilkanDataUserById($id)
    {
        $query = $this->db->prepare(
            "SELECT id,nama,no_rekening FROM tbuser WHERE id=:id"
        );
        $query->bindParam(":id", $id);
        $query->execute();
        $data = $query->fetchAll();
        return $data;
    }

    public function hapusDataUser($id)
    {
        $query = $this->db->prepare(
            "DELETE FROM tbuser WHERE id=:id AND NOT EXISTS (SELECT 1 FROM tb_bid WHERE user_id=tbuser.id)"
        );
        $query->bindParam(":id", $id);

        $query->execute();
        return $query->rowCount() === 1;
    }

    public function tampilkanBarang()
    {
        $query = $this->db->prepare(
            "SELECT id, foto_barang, nama_barang, deskripsi_barang, harga_awal 
            FROM tbbarang 
            WHERE status_lelang IN ('on_going')"
        );

        $query->execute();

        $data = $query->fetchAll();

        return $data;
    }


    public function tampilkanDetailBarangById($id)
    {
        $query = $this->db->prepare(
            "SELECT * FROM tbbarang WHERE id=:id AND status_lelang IN ('on_going','sold','paid','closed')"
        );
        $query->bindParam(":id", $id);
        $query->execute();
        $data = $query->fetchAll();
        return $data;
    }

    public function ajukanBarang($a, $b, $c, $d, $e, $f, $owner)
    {
        $f = 'pending';
        $query = $this->db->prepare(
            "INSERT INTO tbbarang (nama_barang, deskripsi_barang, harga_awal, harga_buyout, foto_barang, status_lelang, id_pemilik) VALUES(:nama_barang, :deskripsi_barang, :harga_awal, :harga_buyout, :foto_barang, :status_lelang, :owner)"
        );
        $query->bindParam(":nama_barang", $a);
        $query->bindParam(":deskripsi_barang", $b);
        $query->bindParam(":harga_awal", $c);
        $query->bindParam(":harga_buyout", $d);
        $query->bindParam(":foto_barang", $e);
        $query->bindParam(":status_lelang", $f);
        $query->bindParam(":owner", $owner);

        if ($query->execute())
            return true;
        else
            return false;
    }

    public function tampilkanVerifBarang()
    {
        $query = $this->db->prepare(
            "SELECT * FROM tbbarang WHERE status_lelang = 'pending'"
        );


        $query->execute();

        $data = $query->fetchAll();

        return $data;
    }

    public function hapusDataPengajuan($id)
    {
        $query = $this->db->prepare(
            "DELETE FROM tbbarang WHERE id=:id AND status_lelang='pending'"
        );
        $query->bindParam(":id", $id);

        $query->execute();
        return $query->rowCount() === 1;
    }

    public function pengajuanDiterima($a)
    {
        $query = $this->db->prepare(
            "UPDATE tbbarang SET status_lelang='on_going' WHERE id=:id AND status_lelang='pending'"
        );
        $query->bindParam(":id", $a);

        $query->execute();
        return $query->rowCount() === 1;
    }

    public function tampilkanBarangUrut()
    {
        $query = $this->db->prepare(
            "SELECT id, nama_barang, deskripsi_barang, harga_awal, harga_buyout, status_lelang
            FROM tbbarang 
            ORDER BY status_lelang;"
        );

        $query->execute();

        $data = $query->fetchAll();

        return $data;
    }

    public function ajukanBid($id,$amount,$uid) {
        $this->db->beginTransaction();
        try {
            $q=$this->db->prepare('SELECT * FROM tbbarang WHERE id=? FOR UPDATE'); $q->execute([$id]); $item=$q->fetch();
            $q=$this->db->prepare('SELECT id FROM tbuser WHERE id=? FOR UPDATE'); $q->execute([$uid]); $user=$q->fetch();
            $highest=$this->getHighestBid($id);
            if (!$user || !$item || $item['status_lelang']!=='on_going' || (int)$item['id_pemilik']===$uid || $amount<=max((float)$item['harga_awal'],(float)($highest['bid_amount']??0)) || $amount>$item['harga_buyout']) { $this->db->rollBack(); return false; }
            $q=$this->db->prepare('INSERT INTO tb_bid(id_barang,bid_amount,user_id) VALUES(?,?,?)'); $q->execute([$id,$amount,$uid]);
            if ($amount >= $item['harga_buyout']) { $q=$this->db->prepare("UPDATE tbbarang SET status_lelang='sold',harga_akhir=? WHERE id=?"); $q->execute([$amount,$id]); }
            $this->db->commit(); return true;
        } catch (Throwable $e) { if ($this->db->inTransaction()) $this->db->rollBack(); throw $e; }
    }

    public function getAllItems()
    {
        
        $query = $this->db->prepare("SELECT * FROM tbbarang");

        $query->execute();

        $data = $query->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    public function tampilkanBidsByBarangId($id_barang)
    {
        $query = $this->db->prepare("SELECT b.bid_amount, b.created_at, u.nama
        FROM tb_bid b
        JOIN tbuser u ON b.user_id = u.id
        WHERE b.id_barang = :id_barang
        ORDER BY b.created_at DESC");
        $query->bindParam(":id_barang", $id_barang, PDO::PARAM_INT); 
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }



    public function getHighestBid($id_barang)
    {
        $query = $this->db->prepare("
        SELECT b.bid_amount, b.user_id, u.nama AS nama_pengguna 
        FROM tb_bid b
        JOIN tbuser u ON b.user_id = u.id
        WHERE b.id_barang = :id_barang 
        ORDER BY b.bid_amount DESC, b.id ASC 
        LIMIT 1
    ");
        $query->bindParam(":id_barang", $id_barang);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function prosesPembayaran($id,$uid) {
        $this->db->beginTransaction();
        try {
            $q=$this->db->prepare('SELECT status_lelang FROM tbbarang WHERE id=? FOR UPDATE'); $q->execute([$id]); $item=$q->fetch(); $bid=$this->getHighestBid($id);
            if (!$item || $item['status_lelang']!=='sold' || !$bid || (int)$bid['user_id']!==$uid) { $this->db->rollBack(); return false; }
            $q=$this->db->prepare("UPDATE tbbarang SET status_lelang='paid' WHERE id=? AND status_lelang='sold'"); $q->execute([$id]); $this->db->commit(); return true;
        } catch(Throwable $e) { if ($this->db->inTransaction()) $this->db->rollBack(); throw $e; }
    }

    public function akhiriLelang($id) {
        $this->db->beginTransaction();
        try {
            $q=$this->db->prepare('SELECT status_lelang FROM tbbarang WHERE id=? FOR UPDATE'); $q->execute([$id]); $item=$q->fetch(); $bid=$this->getHighestBid($id);
            if (!$item || $item['status_lelang']!=='on_going') { $this->db->rollBack(); return false; }
            $q=$this->db->prepare('UPDATE tbbarang SET status_lelang=?,harga_akhir=? WHERE id=?'); $q->execute([$bid?'sold':'closed',$bid['bid_amount']??null,$id]); $this->db->commit(); return true;
        } catch(Throwable $e) { if ($this->db->inTransaction()) $this->db->rollBack(); throw $e; }
    }

    public function tampilkanBarangFull()
    {
        $query = $this->db->prepare(
            "SELECT id, foto_barang, nama_barang, deskripsi_barang, harga_awal, harga_buyout, status_lelang 
        FROM tbbarang WHERE status_lelang IN ('on_going')
       "
        );

        $query->execute();

        $data = $query->fetchAll();

        return $data;
    }


    public function tampilkanBarangSold()
    {
        $query = $this->db->prepare(
            "SELECT id, foto_barang, nama_barang, deskripsi_barang, harga_awal, harga_buyout, status_lelang 
        FROM tbbarang 
        WHERE status_lelang IN ('sold')"
        );

        $query->execute();

        $data = $query->fetchAll();

        return $data;
    }

}
