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
     * Lista todas as versões do arquivo.
     *
     * @return array
     */
    public function versions()
    {
        if (!strlen($this->path)) {
            return [1];
        }

        $files    = glob($this->path . '.*');
        $versions = [];

        foreach ($files as $file) {
            $version = @explode('.', basename($file));
            $version = end($version);

            if (!is_numeric($version)) {
                continue;
            }

            array_push($versions, (int)$version);
        }

        if (count($versions) !== 0) {
            sort($versions, SORT_NUMERIC);
        } else {
            $versions = [1];
        }

        return $versions;
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
        $versions = $this->versions();

        return (int)end($versions);
    }

    /**
     * Verifica se a versão atual do arquivo tem
     * diferenças em relação a sua versão anterior.
     *
     * @return bool
     */
    public function isUpdated()
    {
        $versions = $this->versions();
        $count    = count($versions);

        if ($count === 1) {
            return false;
        }

        $current = md5_file($this->path . '.' . $versions[$count - 1]);
        $prior   = md5_file($this->path . '.' . $versions[$count - 2]);

        return ($current !== $prior);
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
        if (file_exists($path)) {
            $path = $this->path . '.' . ($this->version() + 1);
        }

        file_put_contents($path, $contents);

        return $this;
    }

    /**
     * Apaga uma versão específica do arquivo.
     *
     * @param int $version
     *
     * @return $this
     */
    public function delete($version)
    {
        @unlink($this->path . '.' . $version);

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
        $versions = $this->versions();
        if (count($versions) <= $keep) {
            return $this;
        }

        $kill = (count($versions) - $keep);
        array_splice($versions, $kill);

        foreach ($versions as $version) {
            $this->delete($version);
        }

        return $this;
    }
}
