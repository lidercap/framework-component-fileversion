<?php

namespace Lidercap\Component\Fileversion\Behavior;

/**
 * @codeCoverageIgnore
 */
trait PathAware
{
    /**
     * @var string
     */
    protected $path;

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path Caminho para o arquivo.
     */
    public function setPath($path)
    {
        $this->path = $path;
    }
}
