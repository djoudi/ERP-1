<?php
session_start();
header('Content-type: application/json');
require 'Slim/Slim.php';
require 'helpers.php';

$app = new Slim();

# Adiciona nova sessão
$app->post('/sessao', 'criarSessao');

# Leitura dos dados do Cliente
$app->get('/clientes/'/*,autorizar(Permissoes::Usuario)*/, 'listarClientes');
$app->post('/clientes/'/*,autorizar(Permissoes::Usuario)*/, 'criarClientes');


try
{
   $app->run();  
} 
catch(Exception $e)
{
   reportarFalha($e);  
}


class Permissoes
{
    const Administrador = -1;
    const Usuario = 1;
    const PosVenda = 3;
}

/**
 * Authorise function, used as Slim Route Middlewear (http://www.slimframework.com/documentation/stable#routing-middleware)
 */
function autorizar($permissao = Permissoes::Usuario) {

    return function () use ( $permissao ) {

        // Get the Slim framework object
        $app = Slim::getInstance();
        
        $sessao = obterSessao();

        if($sessao)
        {
            $usuario = obterUsuarioPorSessao($sessao);
            if ($usuario)
            {
                if (strtotime($usuario['data_login'])+3600*2 < time())
                {
                    destruirSessao(); 
                    return $app->halt(401);
                }

                if ($usuario['ip'] != $_SERVER["REMOTE_ADDR"])
                {

                    $app->halt(401,json_encode(array(
                       'sucesso'   => false,
                       'status'    => 'Sessao inválida'
                     )));
                }

                if ($usuario['permissao'] & $permissao)
                    return true;

                else
                    $app->halt(403, json_encode(array(
                       'sucesso'   => false,
                       'status'    => 'Permissão insuficiente'
                     )));
            }
            else
                $app->halt(401,json_encode(array(
               'sucesso'   => false,
               'status'    => 'Usuário não autenticado'
             )));
                

        }
        else {
            $app->halt(401, json_encode(array(
               'sucesso'   => false,
               'status'    => 'Usuário não autenticado'
             )));
        }
    };
}


function criarSessao()
{
    $app = Slim::getInstance();
    if (($email = POST('email', false)) && ($senha = POST('senha', false)))
    {

        $sql = "SELECT * FROM usuarios INNER JOIN pessoas USING (pessoa_id) WHERE pessoas.email = :email AND usuarios.senha = :senha ";

        try
        {             
            $senha = md5($senha);
            $db = obterConexao();   
            $stmt = $db->prepare($sql);
            $stmt->bindParam("email", $email);
            $stmt->bindParam("senha", $senha);
            $stmt->execute();

            $login = $stmt->fetch(PDO::FETCH_ASSOC);

        } catch(PDOException $e) {
            reportarFalha($e);
        }

        if ($login)
        {
            $sessao_id = obterSessao();
            if ($sessao_id)
            {
                return $app->halt(201, json_encode(array(
                   'sucesso'   => true,
                   'data'      => array('session_id' => $sessao['hash']),
                 )));
            }

            try
            {
                $sql = "SELECT * FROM usuarios INNER JOIN pessoas USING (pessoa_id) INNER JOIN sessoes USING (usuario_id) WHERE usuario_id = :usuario_id
                ";

                $stmt = $db->prepare($sql);
                $stmt->bindParam("usuario_id", $login['usuario_id']);
                $stmt->execute();
                $sessao = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($sessao)
                {
                    return $app->halt(201, json_encode(array(
                       'sucesso'   => true,
                       'data'      => array('session_id' => $sessao['hash']),
                     )));
                }

            }catch(PDOException $e) {}

            try
            {
                $sql = "INSERT INTO sessoes (hash, usuario_id, ip, data_login) VALUES (:hash, :usuario_id, :ip, :data_login)";

                $sessao_id = session_id();
                $time=time();
                $sessao_id=base64_encode(substr($sessao_id.md5($time),0,255));
                $date = date('Y-m-d H:i:s',$time);

                $stmt = $db->prepare($sql);

                $stmt->bindParam("data_login", $date);
                $stmt->bindParam("hash", $sessao_id);
                $stmt->bindParam("usuario_id", $login['usuario_id']);
                $stmt->bindParam("ip", $_SERVER["REMOTE_ADDR"]);
                $stmt->execute();

                return $app->halt(201, json_encode(array(
                   'sucesso'   => true,
                   'data'      => array('session_id' => $sessao_id),
                 )));


            } catch(PDOException $e) {
                reportarFalha($e);
            }
        }
        else
            $app->halt(403, json_encode(array(
               'sucesso'   => false,
               'status'    => 'Login ou senha inválidos'
             )));
    }
}


function destruirSessao()
{
    $app = Slim::getInstance();

    $sessao = obterSessao();
    if($sessao)
    {
        $usuario = obterUsuarioPorSessao($sessao);
        $sql = "DELETE FROM sessoes WHERE hash = :hash";

        try
        {
            $db = obterConexao();   
            $stmt = $db->prepare($sql);
            $stmt->bindParam("hash", $sessao);   
            $stmt->execute();

            echo json_encode(array(
               'sucesso'   => true
             ));

        } catch(PDOException $e) {
            reportarFalha($e);
        }
    }

}

function listarClientes()
{

    # Início da construção da Query
	$sql = "SELECT * FROM clientes ";

	# Certificando que não haverá sobrecarga desnecessária no servidor
    $pagination  = " ORDER BY ". GET("order"  , "razaoSocial");
    $pagination .= " LIMIT " .intval(GET("limit"  , 10));
    $pagination .= " OFFSET ".intval(GET("offset" , 0)); 

    try {
        $db = obterConexao();

        $stmt = $db->query("SELECT count(*) as total FROM ($sql) as t ");
        $count = intval( current(current($stmt->fetchAll(PDO::FETCH_ASSOC))) );
        $stmt = $db->query($sql.$pagination);
        $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db = null;

        echo json_encode(array(
               'sucesso'   => true,
               'data'      => $clientes,
               'total'     => $count
             ));

    } catch(PDOException $e) {
        reportarFalha($e);
    }
}



function criarClientes()
{
    $app = Slim::getInstance();



    $attr =
        array(
            "cliente_id"       => $_POST["cliente_id"];      
            "responsavel"      => $_POST["responsavel"];     
            "cnpj"             => $_POST["cnpj"];            
            "razaoSocial"      => $_POST["razaoSocial"];     
            "endereco"         => $_POST["endereco"];        
            "senhaAtendimento" => $_POST["senhaAtendimento"];
            "numeroCliente"    => $_POST["numeroCliente"];   
            "usuarioGestor"    => $_POST["usuarioGestor"];   
            "senhaGestor"      => $_POST["senhaGestor"];     
        );
     # Início da construção da Query
    $sql = "INSERT INTO clientes ("+array_keys($attr)+") ";

    # Certificando que não haverá sobrecarga desnecessária no servidor
    $pagination  = " ORDER BY ". GET("order"  , "razaoSocial");
    $pagination .= " LIMIT " .intval(GET("limit"  , 10));
    $pagination .= " OFFSET ".intval(GET("offset" , 0)); 

    try {
        $db = obterConexao();

        $stmt = $db->query("SELECT count(*) as total FROM ($sql) as t ");
        $count = intval( current(current($stmt->fetchAll(PDO::FETCH_ASSOC))) );
        $stmt = $db->query($sql.$pagination);
        $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db = null;

        echo json_encode(array(
               'sucesso'   => true,
               'data'      => $clientes,
               'total'     => $count
             ));

    } catch(PDOException $e) {
        reportarFalha($e);
    }
}