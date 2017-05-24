# amigo-x

# **Como faço funcionar?** #
É muito simples! Para executar este projeto é necessário usar o [Composer](https://getcomposer.org/).
Para instalar siga os seguintes passos:

**Windows:**
Execute o [Composer-Setup.exe](https://getcomposer.org/doc/00-intro.md#installation-windows)

**Ubuntu:**
Rode o seguinte comando no terminal como **root**: ```curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer```

Uma vez instalado, clone o projeto para a sua máquina na pasta de sua preferência
```
git clone https://github.com/kaioramos/amigo-x.git
```
Entre pela linha de comando na pasta amigo-x e rode o comando:
```
composer install
```
E aguarde o download das dependências.

**Importar banco**
Importe o banco amigo-x.sql que esta na pasta amigo-x/database

**Configure a conexão com o banco**
Na pasta amigo-x/api/conf terá o arquivo config.php altere as linhas para que esteja como seu banco local

**Configure o caminho do WS**
Na pasta amigo-x/app/views/js no arquivo ocApp na linha 22 mude o BASEURL para que fique com mesmo caminho da pasta do projeto

# Pronto!
