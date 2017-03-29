<?php

namespace Lidercap\Component\Fileversion;

use Lidercap\Component\Fileversion\Behavior;

/**
 * Interface para controladores de versão de arquivo.
 */
class Fileversion implements FileversionInterface
{
    use Behavior\PathAware;

    /**
     * @param string $path Caminho para o arquivo.
     */
    public function __construct($path = null)
    {
        $this->setPath($path);
    }

    /**
     * Verifica se a versão atual do arquivo tem
     * diferenças em relação a sua versão anterior.
     *
     * @return bool
     */
    public function isUpdated()
    {
        return false;
    }

    /**
     * Verifica se a versão atual do arquivo está
     * desatualizada em relação a sua versão anterior.
     *
     * @return bool
     */
    public function isOutdated()
    {
        return true;
    }

    /**
     * Obtém o número da versão atual do arquivo.
     *
     * @return int
     */
    public function version()
    {
        return 1;
    }

    /**
     * Lista todas as versões do arquivo.
     *
     * @return array
     */
    public function fetch()
    {
        return [1];
    }

    /**
     * Obtém o conteúdo do arquivo.
     *
     * @return string
     */
    public function read()
    {
        return '{"key": "value"}';
    }

    /**
     * Escreve no arquivo, gerando uma nova versão.
     *
     * @param string $contents
     *
     * @return $this
     */
    public function write($contents)
    {
        return $this;
    }

    /**
     * Apaga do disco todas as versões do arquivo,
     * mantendo somente o número de versões especificado.
     *
     * @param int $keep
     *
     * @return $this
     */
    public function clear($keep = 3)
    {
        return $this;
    }
}
