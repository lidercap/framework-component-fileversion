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
     *
     * @return string
     */
    public function setPath($path);

    /**
     * Verifica se a versão atual do arquivo tem
     * diferenças em relação a sua versão anterior.
     *
     * @return bool
     */
    public function isUpdated();

    /**
     * Verifica se a versão atual do arquivo está
     * desatualizada em relação a sua versão anterior.
     *
     * @return bool
     */
    public function isOutdated();

    /**
     * Obtém o número da versão atual do arquivo.
     *
     * @return int
     */
    public function version();

    /**
     * Lista todas as versões do arquivo.
     *
     * @return array
     */
    public function fetch();

    /**
     * Obtém o conteúdo do arquivo.
     *
     * @return string
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
     * Apaga do disco todas as versões do arquivo,
     * Mantendo somente o número de versões especificado.
     *
     * @param int $keep
     *
     * @return $this
     */
    public function clear($keep = 3);
}
