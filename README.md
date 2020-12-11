<h1>Baixe e instale o wampServer 2.5</h1>

Atenção: O PHP 5 é pré requisito para rodar a aplicação, caso tenha uma versão mais recente do WampServer instalada reinstale a versão abaixo.
https://sourceforge.net/projects/wampserver/files/WampServer%202/Wampserver%202.5/wampserver2.5-Apache-2.4.9-Mysql-5.6.17-php5.5.12-64b.exe/download


<h1>Configurando o zend famework 2</h1>
	<h2>1 - Caminho do PHP no sistema (apenas windows).</h2>	
	
	IMPORTANTE: Seu PHP não será reconhecido como comando interno ou externo, pois seu PHP.exe não foi configurado como variável do ambiente do windows. Para resolver isto siga os procedimentos abaixo:
	
	1 – Clique com o botão direito em Meu Computador
	2 – Propriedades
	3 – Configurações Avançadas ou Aba Avançado
	4 – Variáveis de Ambiente
	5 – Procure e clique em “Path” e depois no botão “Editar”
	6 – Adicione ao final do que estiver lá o caminho do php: ;C:\wamp\bin\php\php5.5.12
	7 – ok, ok, ok

<h2>2 - Configurando o Servidor Apache para mod_rewrite</h2>
	
	1 – Abra o arquivo httpd. conf do Apache, normalmente ele se encontra dentro da pasta conf dentro do diretório de instalação do Apache. (C:\wamp\bin\apache\apache2.4.9\conf\httpd.conf)
	2 – Procure pela linha #LoadModule rewrite_module modules/mod_rewrite.so e retire o sustenido (#) inicial.
	3 – Procure pela Tag <Directory>
	4 – Dentro desta troque Options FollowSymLinks por Options FollowSymLinks Includes
	5 – Troque AllowOverride None por AllowOverride All
	6 – Agora procure pela Tag <Directory "c:/wamp/www/"> que dependendo de sua instalação pode estar diferente, mas que é onde se encontra as configurações da pasta raiz do apache
	7 – Tendo encontrado esta Tag, troque Options Indexes por Options Indexes FollowSymLinks
	8 – Troque AllowOverride None por AllowOverride All
	9 – No final do arquivo adicione a linha "AccessFileName .htaccess" e estamos com o Apache configurado para mod_rewrite.


<h2>3 - Criando um Virtual Host para simular servidor remoto</h2>
	
	1 – Abra o arquivo C:\wamp\bin\apache\apache2.4.9\conf\httpd.conf
	2 – Procure pelas linhas: 
	# Include conf/extra/httpd-vhosts.conf
	Retire o sustenido  '#' no início da linha.
	3 – Abra o arquivo C:\wamp\bin\apache\apache2.4.9\conf\extra\httpd-vhosts.conf e cole o código abaixo no final do arquivo: 
	<VirtualHost *:80>
	    DocumentRoot "C:/wamp/www/dealerSites"
	    ServerName dealersites.local
	    ErrorLog "logs/dealersites-error.log"
	    CustomLog "logs/dealersites-access.log" common
	</VirtualHost>
	4 – Salve todos os arquivos e reinicie o wampServer.
	5 – Execute o notepad como administrador e abra o arquivo: C:\windows\system32\drivers\etc\hosts. Caso o arquivo não apareça altere a opção “documentos de 		texto (*.txt)” para “todos os tipos de arquivo” na caixa de busca. 
	6 – No final do arquivo insira a linha: 
		127.0.0.1    dealersites.local
	
<h2>4 – Configurando o projeto dealerSites</h2>
	
	1 – Faça download do projeto em:
	https://github.com/arenasam/dealersites
	2 – Crie uma pasta chamada “dealerSites” em C:\wamp\www e descompacte todos os arquivos do projeto para esta pasta.
	3 – Abra o prompt de comando:
		1 – Aperte “Windows”, digite “cmd” e pressione enter.
		2 – Navegue até a pasta  C:\wamp\www\dealerSites (digite: “cd..” para voltar uma pasta e “cd nomeDaPasta”) para entrar em uma pasta. Ex, se você está em “c:” digite “cd wamp/www/dealerSites”.
	4 – Digite o comando “php composer.phar install”

<h2>5 – Configurando a base de dados</h2>

	1 – Abra o navegador e digite (http://dealersites.local/phpmyadmin).	
	2 – No canto superior esquerdo clique no link “New”.
	3 – Na caixa de texto nome da base de dados, digite “bd_dealer_sites ”, na caixa de seleção selecione a opção “utf8_general_ci” e clique no botão “Criar”.
	4 – A base de dados irá aparecer a lista abaixo, clique no link “bd_dealer_sites”.
	5 – Selecione a opção “Importar” no menu superior.
	6 – Selecione o arquivo “C:\wamp\www\dealerSites\sql\bd_dealer_sites.sql” e clique em “Executar”.


<h1>6 - Ativando cache do MySql - Opcional</h1>

	1 - Abra o arquivo "C:\wamp\bin\mysql\mysql5.6.17\my.ini".
	2 - Adicione as linhas no final do arquivo.
		query_cache_type=1
		query_cache_size=20M
	3 - Reinicie o wampServer.
		
	
Acesse  http://dealersites.local em seu navegador.

Créditos: https://gilbertoalbino.com/zf2-tutorial-zend-framework-2-parte-01/#more-1066
