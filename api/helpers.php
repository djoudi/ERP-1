<?php 


function REQUEST($hash, $default = null)
{
	return isset($_REQUEST[$hash])? $_REQUEST[$hash]: $default;
}

function GET($hash, $default = null)
{
	return isset($_GET[$hash])? $_GET[$hash]: $default;
}


function POST($hash, $default = null)
{
	return isset($_POST[$hash])? $_POST[$hash]: $default;
}


function reportarFalha($Exception)
{
    header('HTTP/1.1 503 Service Temporarily Unavailable');
    header('Status: 503 Service Temporarily Unavailable');
    header('Retry-After: 60');

    echo json_encode(array(
        "success" => false,
        "data" => $Exception->getMessage()
    ));

    die();
}


function obterConexao()
{
    global $DB;
    
    if ($DB)
        return $DB;

    $dbhost="127.0.0.1";
    $dbuser="root";
    $dbpass="gildasio";
    $dbname="topclaro_erp";
    $DB = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);  
    $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $DB;
}


function obterUsuarioPorSessao($sessao_id)
{
    $sql = "SELECT * FROM usuarios INNER JOIN pessoas USING (pessoa_id) INNER JOIN sessoes USING (usuario_id) WHERE sessoes.hash = :hash";
    try
    {             
        $db = obterConexao();   
        $stmt = $db->prepare($sql);
        $stmt->bindParam("hash", $sessao_id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);

    } catch(PDOException $e) {
        reportFailure($e);
    }
}



function obterSessao()
{
	$headers = getallheaders();
	if (isset($headers['Authorization']))
		return $headers['Authorization'];

	return ($get = GET('sessao_id',false))?$get: POST('sessao_id',false);
}

