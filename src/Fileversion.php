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
     * Obtém o número da versão atual do arquivo.
     *
     * Caso o arquivo não exista, ou não tenha sido
     * versionado ainda, a versão retornada será "1".
     *
     * @return int
     */
    public function version()
    {
        $versions = $this->fetch();

        return end($versions);
    }

    /**
     * Lista todas as versões do arquivo.
     *
     * @return array
     */
    public function fetch()
    {
        if (!strlen($this->path)) {
            return [1];
        }

        $direcory = dirname($this->path);
        $iterator = new \DirectoryIterator($direcory);
        $versions = [];

        foreach ($iterator as $file) {
            if (!$file->isDot()) {

                $filename = basename($file->getPathName());
                $version  = @explode('.', $filename);
                $version  = end($version);

                if (!is_numeric($version)) {
                    continue;
                }

                if ($this->suffixRemove($file->getPathName()) !== $this->suffixRemove($this->path)) {
                    continue;
                }

                array_push($versions, $version);
            }
        }

        return (count($versions) !== 0) ? $versions : [1];
    }

    /**
     * Obtém o conteúdo da versão mais atual do arquivo.
     *
     * @return string|false
     */
    public function read()
    {
        $path = $this->path . '.' . $this->version();
        if (!file_exists($path)) {
            return false;
        }

        return file_get_contents($path);
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
        $path = $this->path . '.' . $this->version();
        if (!file_exists($path)) {
            file_put_contents($path, $contents);
            return $this;
        }

        $path = $this->path . '.' . $this->version() + 1;
        file_put_contents($path, $contents);

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
