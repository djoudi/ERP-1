<?php


function objectToArray($d) {
	if (is_object($d)) {
		// Gets the properties of the given object
		// with get_object_vars function
		$d = get_object_vars($d);
	}

	if (is_array($d)) {
		/*
		* Return array converted to object
		* Using __FUNCTION__ (Magic constant)
		* for recursive call
		*/
		return array_map(__FUNCTION__, $d);
	}
	else {
		// Return array
		return $d;
	}
}

Validator::extend("cpf",function($attribute, $value, $parameters)
{
	$cpf = $value;
	/*
	Etapa 1: Cria um array com apenas os digitos numéricos, 
	isso permite receber o cpf em diferentes formatos 
	como "000.000.000-00", "00000000000", "000 000 000 00"
	*/
	$j=0;
	for($i=0; $i<(strlen($cpf)); $i++)
	{
		if(is_numeric($cpf[$i]))
		{
			$num[$j]=$cpf[$i];
			$j++;
		}
	}
	/*
	Etapa 2: Conta os dí­gitos, 
	um cpf válido possui 11 dí­gitos numéricos.
	*/
	if(count($num)!=11)
	{
		return false;
	}
	/*
	Etapa 3: Combinaí§íµes como 00000000000 e 22222222222 embora 
	não sejam cpfs reais resultariam em cpfs 
	válidos após o calculo dos dí­gitos verificares e 
	por isso precisam ser filtradas nesta parte.
	*/
	else
	{
		for($i=0; $i<10; $i++)
		{
			if ($num[0]==$i && $num[1]==$i && $num[2]==$i && $num[3]==$i && $num[4]==$i && $num[5]==$i && $num[6]==$i && $num[7]==$i && $num[8]==$i)
			{
				return false;
				break;
			}
		}
	}
	/*
	Etapa 4: Calcula e compara o 
	primeiro dí­gito verificador.
	*/
	if(!isset($isCpfValid))
	{
		$j=10;
		for($i=0; $i<9; $i++)
		{
			$multiplica[$i]=$num[$i]*$j;
			$j--;
		}
		$soma = array_sum($multiplica);	
		$resto = $soma%11;			
		if($resto<2)
		{
			$dg=0;
		}
		else
		{
			$dg=11-$resto;
		}
		if($dg!=$num[9])
		{
			return false;
		}
	}
	/*
	Etapa 5: Calcula e compara o 
	segundo dí­gito verificador.
	*/
	if(!isset($isCpfValid))
	{
		$j=11;
		for($i=0; $i<10; $i++)
		{
			$multiplica[$i]=$num[$i]*$j;
			$j--;
		}
		$soma = array_sum($multiplica);
		$resto = $soma%11;

		if($resto<2)
			$dg=0;

		else
			$dg=11-$resto;

		if($dg!=$num[10])
			return false;

		else
			return true;
	}

	//Etapa 6: Retorna o Resultado em um valor booleano.
	return true;
});

Validator::extend("cnpj",function($attribute, $value, $parameters)
{
	$cnpj = $value;
		/*
			Etapa 1: Cria um array com apenas os digitos numéricos, 
			isso permite receber o cnpj em diferentes 
			formatos como "00.000.000/0000-00", "00000000000000", "00 000 000 0000 00" 
			etc...
		*/
			$j=0;
			for($i=0; $i<(strlen($cnpj)); $i++)
			{
				if(is_numeric($cnpj[$i]))
				{
					$num[$j]=$cnpj[$i];
					$j++;
				}
			}
	//Etapa 2: Conta os dí­gitos, um Cnpj válido possui 14 dí­gitos numéricos.
			if(count($num)!=14)
			{
				return false;
			}
	/*
	Etapa 3: O níºmero 00000000000 embora não seja um cnpj real resultaria 
	um cnpj válido após o calculo dos dí­gitos verificares 
	e por isso precisa ser filtradas nesta etapa.
	*/
	if ($num[0]==0 && $num[1]==0 && $num[2]==0 && $num[3]==0 && $num[4]==0 && $num[5]==0 && $num[6]==0 && $num[7]==0 && $num[8]==0 && $num[9]==0 && $num[10]==0 && $num[11]==0)
	{
		return false;
	}
	//Etapa 4: Calcula e compara o primeiro dí­gito verificador.
	else
	{
		$j=5;
		for($i=0; $i<4; $i++)
		{
			$multiplica[$i]=$num[$i]*$j;
			$j--;
		}
		$soma = array_sum($multiplica);
		$j=9;
		for($i=4; $i<12; $i++)
		{
			$multiplica[$i]=$num[$i]*$j;
			$j--;
		}
		$soma = array_sum($multiplica);	
		$resto = $soma%11;			
		if($resto<2)
		{
			$dg=0;
		}
		else
		{
			$dg=11-$resto;
		}
		if($dg!=$num[12])
		{
			return false;
		} 
	}
	//Etapa 5: Calcula e compara o segundo dí­gito verificador.
	if(!isset($isCnpjValid))
	{
		$j=6;
		for($i=0; $i<5; $i++)
		{
			$multiplica[$i]=$num[$i]*$j;
			$j--;
		}
		$soma = array_sum($multiplica);
		$j=9;
		for($i=5; $i<13; $i++)
		{
			$multiplica[$i]=$num[$i]*$j;
			$j--;
		}
		$soma = array_sum($multiplica);	
		$resto = $soma%11;			
		if($resto<2)
		{
			$dg=0;
		}
		else
		{
			$dg=11-$resto;
		}
		if($dg!=$num[13])
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	//Etapa 6: Retorna o Resultado em um valor booleano.
	return true;
});

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

ClassLoader::addDirectories(array(

	app_path().'/controllers',
	app_path().'/models',
	app_path().'/database/seeds',

	));

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a rotating log file setup which creates a new file each day.
|
*/

Log::useDailyFiles(__DIR__.'/../storage/logs/log.txt');

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

App::error(function(Exception $exception, $code)
{
	Log::error($exception);
});

/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/


require __DIR__.'/../filters.php';