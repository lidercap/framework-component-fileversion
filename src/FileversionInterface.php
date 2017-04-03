<?php

namespace Lidercap\Component\Fileversion;

/**
 * Interface para controladores de versão de arquivo.
 */
interface FileversionInterface
{
    /**
     * @param string $path Caminho para o arquivo.
     */
    public function __construct($path = null);

    /**
     * @return string
     */
    public function getPath();

    /**
     * @param string $path Caminho para o arquivo.
     */
    public function setPath($path);

    /**
     * Lista todas as versões do arquivo.
     *
     * @return array
     */
    public function versions();

    /**
     * Obtém o número da versão atual do arquivo.
     *
     * Caso o arquivo não exista, ou não tenha sido
     * versionado ainda, a versão retornada será "1".
     *
     * @return int
     */
    public function version();

    /**
     * Verifica se a versão atual do arquivo tem
     * diferenças em relação a sua versão anterior.
     *
     * @return bool
     */
    public function isUpdated();

    /**
     * Obtém o conteúdo da versão mais atual do arquivo.
     *
     * @return string|false
     */
    public function read();

    /**
     * Escreve no arquivo, gerando uma nova versão.
     *
     * @param string $contents
     *
     * @return $this
     */
    public function write($contents);

    /**
     * Apaga uma versão específica do arquivo.
     *
     * @param int $version
     *
     * @return $this
     */
    public function delete($version);

    /**
     * Apaga do disco todas as versões do arquivo,
     * mantendo somente o número de versões especificado.
     *
     * @param int $keep
     *
     * @return $this
     */
    public function clear($keep = 3);
}
