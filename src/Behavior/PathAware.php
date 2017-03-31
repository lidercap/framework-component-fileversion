<?php

namespace Lidercap\Component\Fileversion\Behavior;

trait PathAware
{
    /**
     * @var string
     */
    protected $path;

    /**
     * @param string $path Caminho para o arquivo.
     *
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $this->suffixRemove($path);

        return $this;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Remove a versão do caminho ou nome do arquivo quando necessário.
     *
     * @param string $path
     *
     * @return string
     **/
    protected function suffixRemove($path)
    {
        $exploded = (array)@explode('.', $path);
        $version  = end($exploded);

        if (is_numeric($version)) {
            $path = str_replace('.' . $version, '', $path);
        }

        return $path;
    }
}
