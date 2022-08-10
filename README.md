Component Fileversion
=====================

Gerenciador de versões de arquivos.

Instalação
----------

É recomendado instalar **component-fileversion** através do [composer](http://getcomposer.org).

```json
{
    "require": {
        "lidercap/framework-component-fileversion": "dev-master"
    },
    "repositories": [
        {
            "type": "vcs",
            "url":  "git@github.com:lidercap/framework-component-fileversion.git"
        }
    ]
}
```

Iniciando o componente
----------------------

##### 1) Passando caminho do arquivo como parâmetro do construtor

```php
<?php

$filepath    = '/path/to/my/file.txt';
$fileversion = new \Lidercap\Component\Fileversion($filepath);

```

##### 2) Passando caminho do arquivo por método específico

```php
<?php

$fileversion = new \Lidercap\Component\Fileversion($filepath);
$fileversion->setPath('/path/to/my/file.txt');

```

Obtendo a versão atual do arquivo
---------------------------------

Obtém o número da versão atual do arquivo.

Caso o arquivo não exista, ou não tenha sido versionado ainda, a versão retornada será "1".

```php
<?php

$filepath    = '/path/to/my/file.txt';
$fileversion = new \Lidercap\Component\Fileversion($filepath);

$version = $fileversion->version();
var_dump($version); // 1

```

Verificando se o arquivo foi modificado
---------------------------------------

Verifica se a versão atual do arquivo tem diferenças em relação a sua versão anterior.

```php
<?php

$filepath    = '/path/to/my/file.txt';
$fileversion = new \Lidercap\Component\Fileversion($filepath);

var_dump($fileversion->isUpdated()); // TRUE | FALSE

```

Listando todas as versões do arquivo
------------------------------------

```php
<?php

$filepath    = '/path/to/my/file.txt';
$fileversion = new \Lidercap\Component\Fileversion($filepath);

var_dump($fileversion->fetch()); // [1, 2, 3...]

```

Escrevendo no arquivo
---------------------

Ao escrever no arquivo, uma nova versão do mesmo é gerada, 
sempre deixando a versão anterior inalterada.

```php
<?php

$filepath    = '/path/to/my/file.txt';
$fileversion = new \Lidercap\Component\Fileversion($filepath);

$content = 'Conteúdo do arquivo';
$fileversion->write($content);

```

Obtendo o conteúdo da versão atual do arquivo
---------------------------------------------

```php
<?php

$filepath    = '/path/to/my/file.txt';
$fileversion = new \Lidercap\Component\Fileversion($filepath);

$content = 'Conteúdo do arquivo';
$fileversion->write($content);

var_dump($fileversion->read()); // Conteúdo do arquivo

```

Deletando uma versão
--------------------

```php
<?php

$filepath    = '/path/to/my/file.txt';
$fileversion = new \Lidercap\Component\Fileversion($filepath);
$fileversion->delete(1);

```

Limpando versões antigas em lote
--------------------------------

Limpa todas as versões anteriores do arquivo, mas mantém o número de versões que o usuário especificar.

```php
<?php

$filepath    = '/path/to/my/file.txt';
$fileversion = new \Lidercap\Component\Fileversion($filepath);

$fileversion->clear(5); // Deleta todas, mantendo somente as 5 últimas

// ou

$fileversion->clear(); // Default "3".

```

Desenvolvimento e Testes
------------------------

Dependências:

 * PHP 5.5.x ou superior
 * Composer
 * Git
 * Make

Para rodar a suite de testes, você deve instalar as dependências externas do projeto e então rodar o PHPUnit.

    $ make install
    $ make test    (sem relatório de coverage)
    $ make testdox (com relatório de coverage)

Responsáveis técnicos
---------------------

 * **Leonardo Thibes: <lthibes@lidercap.com.br>**
 * **Gabriel Specian: <gspecian@lidercap.com.br>**
