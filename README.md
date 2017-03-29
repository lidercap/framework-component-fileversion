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
            "url":  "git@bitbucket.org:lidercap/framework-component-fileversion.git"
        }
    ]
}
```

NOME DA FUNÇÃO
--------------

Descrição da função.

```php
<?php

// Coloque aqui exemplos de uso

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

 * **André Sabino: <asabino@lidercap.com.br>**
 * **Fernando Villaça: <fvillaca@lidercap.com.br>**
 * **Leonardo Thibes: <lthibes@lidercap.com.br>**
