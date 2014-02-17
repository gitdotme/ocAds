<?php
set_time_limit(0);

$step = isset($_GET['step']) ? intval($_GET['step']) : NULL;
?>
<!DOCTYPE html>
<html>
    <head>
        <title>ocAds Installer</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="robots" content="noindex, nofollow">
        <link rel="stylesheet" type="text/css" href="css/common.css">
        <script type="text/javascript" src="../assets/js/jquery.min.js"></script>
        <script type="text/javascript" src="../assets/js/common.js"></script>
    </head>
    <body>
        <div id="wrap">
            <div id="header">
                <p><img src="../assets/img/logo-large.gif" alt="ocAds"></p>
            </div>
            <div id="steps">
                <h1>Steps</h1>
                <ul>
                    <li>
                        <div class="circleText<?php echo ( ! $step OR $step == 1) ? ' active' : ''; ?>"><div>1</div></div>
                    </li>
                    <li>
                        <div class="circleText<?php echo ( $step == 2) ? ' active' : ''; ?>"><div>2</div></div>
                    </li>
                    <li>
                        <div class="circleText<?php echo ( $step == 3) ? ' active' : ''; ?>"><div>3</div></div>
                    </li>
                    <li>
                        <div class="circleText<?php echo ( $step == 4) ? ' active' : ''; ?>"><div>4</div></div>
                    </li>
                    <li>
                        <div class="circleText<?php echo ( $step == 5) ? ' active' : ''; ?>"><div>5</div></div>
                    </li>
                </ul>
            </div>
            <div id="content">
<?php
switch ($step)
{
    default:
    case 1:
        $fail = array();
        
        if (version_compare(PHP_VERSION, '5.0.0', '<'))
        {
            $fail['php'] = TRUE;
        }
        
        if ( ! function_exists('mysqli_connect'))
        {
            $fail['mysqli'] = TRUE;
        }
        
        if ( ! function_exists('curl_version'))
        {
            $fail['curl'] = TRUE;
        }
        
        if ( ! ini_get('allow_url_fopen'))
        {
            $fail['allow_url_fopen'] = TRUE;
        }
        
        if ( ! ini_get('allow_url_fopen'))
        {
            $fail['allow_url_fopen'] = TRUE;
        }
        
        if ( ! function_exists('gd_info'))
        {
            $fail['gd'] = TRUE;
        }
        
        if ( ! function_exists('imagettftext'))
        {
            $fail['ttf'] = TRUE;
        }
        
        if ( ! function_exists('imagettftext'))
        {
            $fail['ttf'] = TRUE;
        }
        
        if ( ! is_writable('../app/config/config.php'))
        {
            $fail['config'] = TRUE;
        }
        
        if ( ! is_writable('../app/config/database.php'))
        {
            $fail['database'] = TRUE;
        }
        
        echo '<h2>Requirements</h2>
                <div class="formPart">
                    <p class="requirement"><strong>PHP 5 or greater</strong> '.(isset($fail['php']) ? '<span class="failed">FAILED</span>': '<span class="passed">OK</span>').'</p>
                </div>
                <div class="formPart">
                    <p class="requirement"><strong>Mysqli (PHP)</strong> '.(isset($fail['mysqli']) ? '<span class="failed">FAILED</span>': '<span class="passed">OK</span>').'</p>
                </div>
                <div class="formPart">
                    <p class="requirement"><strong>cURL Library (PHP)</strong> '.(isset($fail['curl']) ? '<span class="failed">FAILED</span>': '<span class="passed">OK</span>').'</p>
                </div>
                <div class="formPart">
                    <p class="requirement"><strong>allow_url_fopen = 1 (PHP)</strong> '.(isset($fail['allow_url_fopen']) ? '<span class="failed">FAILED</span>': '<span class="passed">OK</span>').'</p>
                </div>
                <div class="formPart">
                    <p class="requirement"><strong>GD Library (PHP)</strong> '.(isset($fail['gd']) ? '<span class="failed">FAILED</span>': '<span class="passed">OK</span>').'</p>
                </div>
                <div class="formPart">
                    <p class="requirement"><strong>TTF Support (PHP)</strong> '.(isset($fail['ttf']) ? '<span class="failed">FAILED</span>': '<span class="passed">OK</span>').'</p>
                </div>
                <div class="formPart">
                    <p class="requirement"><strong>Writable (config/config.php)</strong> '.(isset($fail['config']) ? '<span class="failed">FAILED</span>': '<span class="passed">OK</span>').'</p>
                </div>
                <div class="formPart">
                    <p class="requirement"><strong>Writable (config/database.php)</strong> '.(isset($fail['database']) ? '<span class="failed">FAILED</span>': '<span class="passed">OK</span>').'</p>
                </div>';
        
        if (empty($fail))
        {
            echo '<div class="formPart">
                    <p class="requirement"><p class="passed">You could go to the next step.</p></p>
                </div>
                <div class="formPart">
                    <button class="inputSubmit" onclick="goURL(\'/install/?step=2\')">Next Step</button>
                </div>';
        }
        else
        {
            echo '<div class="formPart">
                    <p class="requirement"><p class="failed">Please fix that failed requirements to go to the next step.</p></p>
                </div>
                <div class="formPart">
                    <button class="inputSubmit" onclick="goURL(document.location)">Refresh</button>
                </div>';
        }
        break;
    
    case 2:
        echo '<h2>API Key</h2>';
        
        $error = NULL;
        $success = FALSE;
        
        if ($_POST)
        {
            if (isset($_POST['apiKey']) AND $_POST['apiKey'])
            {
                $json_get = @file_get_contents('http://git.me/api/check_key?key='.urlencode($_POST['apiKey']));
                if ($json_get)
                {
                    $config = @file_get_contents('../app/config/config.php');
                    $config = str_replace("\$config['apiKey'] = '';", "\$config['apiKey'] = '".htmlspecialchars($_POST['apiKey'])."';", $config);
                    $put = @file_put_contents('../app/config/config.php', $config);
                    
                    if ($put !== FALSE)
                    {
                        $success = TRUE;
                    }
                    else
                    {
                        $error = 'Your config could not be setted.';
                    }
                }
                else
                {
                    $error = 'API key is invalid.';
                }
            }
            else
            {
                $error = 'API key is required.';
            }
        }
        
        if ($error)
        {
            echo '<div class="error">'.$error.'</div>';
        }
        
        if ( ! $success)
        {
            echo '
                <form method="post">
                    <div class="info">
                        <p>ocAds uses <a href="http://git.me" rel="nofollow">git.me</a>\'s API service.</p>
                        <p>If you do not have an API key, please <a href="http://git.me/developers" rel="nofollow">click here</a> to take a new.</p>
                    </div>
                    <div class="formPart">
                        <label for="fApiKey">Your API Key</label>
                        <input type="text" name="apiKey" id="fApiKey" value="'.(isset($_POST['apiKey']) ? htmlspecialchars($_POST['apiKey']) : '').'" class="inputMedium">
                    </div>
                    <div class="formPart">
                        <button class="inputSubmit">Submit</button>
                    </div>
                </form>';
        }
        else
        {
            echo '<div class="formPart">
                    <p class="requirement"><p class="passed">You could go to the next step.</p></p>
                </div>
                <div class="formPart">
                    <button class="inputSubmit" onclick="goURL(\'/install/?step=3\')">Next Step</button>
                </div>';
        }
        break;
        
    case 3:
        echo '<h2>Database</h2>';
        
        $error = NULL;
        $success = FALSE;
        
        if ($_POST)
        {
            if ($_POST['host'] AND $_POST['user'] AND $_POST['pass'] AND $_POST['name'])
            {
                $db = @new mysqli($_POST['host'], $_POST['user'], $_POST['pass'], $_POST['name']);
                if ( ! $db->connect_errno)
                {
                    $sql = @file_get_contents('sql/ocads.sql');
                    if ($sql)
                    {
                        $query = $db->multi_query($sql);
                        
                        if ($query)
                        {
                            $config = @file_get_contents('../app/config/database.php');
                            $config = str_replace("\$database['host'] = '';", "\$database['host'] = '".htmlspecialchars($_POST['host'])."';", $config);
                            $config = str_replace("\$database['user'] = '';", "\$database['user'] = '".htmlspecialchars($_POST['user'])."';", $config);
                            $config = str_replace("\$database['pass'] = '';", "\$database['pass'] = '".htmlspecialchars($_POST['pass'])."';", $config);
                            $config = str_replace("\$database['name'] = '';", "\$database['name'] = '".htmlspecialchars($_POST['name'])."';", $config);
                            $put = @file_put_contents('../app/config/database.php', $config);
                            
                            if ($put !== FALSE)
                            {
                                $success = TRUE;
                            }
                            else
                            {
                                $error = 'Your config could not be setted.';
                            }
                        }
                        else
                        {
                            $error = 'SQL could not be dumped.';
                        }
                    }
                    else
                    {
                        $error = 'SQL file not found in install directory.';
                    }
                }
                else
                {
                    $error = 'Could not be connected to database.';
                }
            }
            else
            {
                $error = 'You must fill in all of the fields.';
            }
        }
        
        if ($error)
        {
            echo '<div class="error">'.$error.'</div>';
        }
        
        if ( ! $success)
        {
            echo '
                <form method="post">
                    <div class="formPart">
                        <label for="fHost">DB Host</label>
                        <input type="text" name="host" id="fHost" value="'.(isset($_POST['host']) ? htmlspecialchars($_POST['host']) : '').'" class="inputMedium">
                    </div>
                    <div class="formPart">
                        <label for="fUser">DB User</label>
                        <input type="text" name="user" id="fUser" value="'.(isset($_POST['user']) ? htmlspecialchars($_POST['user']) : '').'" class="inputMedium">
                    </div>
                    <div class="formPart">
                        <label for="fPass">DB Password</label>
                        <input type="password" name="pass" id="fPass" value="'.(isset($_POST['pass']) ? htmlspecialchars($_POST['pass']) : '').'" class="inputMedium">
                    </div>
                    <div class="formPart">
                        <label for="fName">DB Name</label>
                        <input type="text" name="name" id="fName" value="'.(isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '').'" class="inputMedium">
                    </div>
                    <div class="formPart">
                        <button class="inputSubmit">Submit</button>
                    </div>
                </form>';
        }
        else
        {
            echo '<div class="formPart">
                    <p class="requirement"><p class="passed">You could go to the next step.</p></p>
                </div>
                <div class="formPart">
                    <button class="inputSubmit" onclick="goURL(\'/install/?step=4\')">Next Step</button>
                </div>';
        }
        break;
        
    case 4:
        echo '<h2>Base URL</h2>';
        
        $error = NULL;
        $success = FALSE;
        
        if ($_POST)
        {
            if (isset($_POST['baseURL']) AND $_POST['baseURL'])
            {
                if (filter_var($_POST['baseURL'], FILTER_VALIDATE_URL))
                {
                    $config = @file_get_contents('../app/config/config.php');
                    $config = str_replace("\$config['baseURL'] = '';", "\$config['baseURL'] = '".htmlspecialchars($_POST['baseURL'])."';", $config);
                    $put = @file_put_contents('../app/config/config.php', $config);
                    
                    if ($put !== FALSE)
                    {
                        $success = TRUE;
                    }
                    else
                    {
                        $error = 'Your config could not be setted.';
                    }
                }
                else
                {
                    $error = 'URL is invalid.';
                }
            }
            else
            {
                $error = 'You must fill in the URL field.';
            }
        }
        
        if ($error)
        {
            echo '<div class="error">'.$error.'</div>';
        }
        
        if ( ! $success)
        {
            echo '
                <form method="post">
                    <div class="formPart">
                        <label for="fBaseURL">URL</label>
                        <input type="text" name="baseURL" id="fBaseURL" value="'.(isset($_POST['baseURL']) ? htmlspecialchars($_POST['baseURL']) : 'http://').'" class="inputLarge">
                    </div>
                    <div class="formPart">
                        <button class="inputSubmit">Submit</button>
                    </div>
                </form>';
        }
        else
        {
            echo '<div class="formPart">
                    <p class="requirement"><p class="passed">You could go to the next step.</p></p>
                </div>
                <div class="formPart">
                    <button class="inputSubmit" onclick="goURL(\'/install/?step=5\')">Next Step</button>
                </div>';
        }
        break;
        
    case 5:
        $error = NULL;
        $success = FALSE;
        
        if ($_POST)
        {
            if ($_POST['senderName'] AND $_POST['senderEmail'] AND $_POST['contactEmail'])
            {
                if ( ! filter_var($_POST['senderEmail'], FILTER_VALIDATE_EMAIL))
                {
                    $error = 'Sender email is not valid.';
                }
                
                if ( ! filter_var($_POST['contactEmail'], FILTER_VALIDATE_EMAIL))
                {
                    $error = 'Contact email is not valid.';
                }
                
                if ( ! $error)
                {
                    $config = @file_get_contents('../app/config/config.php');
                    $config = str_replace("\$config['senderName'] = '';", "\$config['senderName'] = '".htmlspecialchars($_POST['senderName'])."';", $config);
                    $config = str_replace("\$config['senderEmail'] = '';", "\$config['senderEmail'] = '".htmlspecialchars($_POST['senderEmail'])."';", $config);
                    $config = str_replace("\$config['contactEmail'] = '';", "\$config['contactEmail'] = '".htmlspecialchars($_POST['contactEmail'])."';", $config);
                    $put = @file_put_contents('../app/config/config.php', $config);
                    
                    if ($put !== FALSE)
                    {
                        $success = TRUE;
                    }
                    else
                    {
                        $error = 'Your config could not be setted.';
                    }
                }
            }
            else
            {
                $error = 'You must fill in all of the fields.';
            }
        }
        
        if ($error)
        {
            echo '<div class="error">'.$error.'</div>';
        }
        
        if ( ! $success)
        {
            echo '<h2>Email</h2>
                <form method="post">
                    <div class="formPart">
                        <label for="fSenderName">Sender Name</label>
                        <input type="text" name="senderName" id="fSenderName" value="'.(isset($_POST['senderName']) ? htmlspecialchars($_POST['senderName']) : '').'" class="inputMedium">
                    </div>
                    <div class="formPart">
                        <label for="fSenderEmail">Sender Email</label>
                        <input type="text" name="senderEmail" id="fSenderEmail" value="'.(isset($_POST['senderEmail']) ? htmlspecialchars($_POST['senderEmail']) : '').'" class="inputMedium">
                    </div>
                    <div class="formPart">
                        <label for="fContactEmail">Contact Email</label>
                        <input type="text" name="contactEmail" id="fContactEmail" value="'.(isset($_POST['contactEmail']) ? htmlspecialchars($_POST['contactEmail']) : '').'" class="inputMedium">
                    </div>
                    <div class="formPart">
                        <button class="inputSubmit">Submit</button>
                    </div>
                </form>';
        }
        else
        {
            echo '<h2>Done</h2>
                <div class="formPart">
                    <p class="requirement"><p class="passed">All steps were completed.</p></p>
                    <p class="requirement"><p class="passed">You must delete <strong>install</strong> folder to continue.</p></p>
                </div>';
        }
        break;
}
?>
            </div>
        </div>
    </body>
</html>