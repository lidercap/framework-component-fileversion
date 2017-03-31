<?php

namespace Lidercap\Component\Fileversion;

/**
 * @codeCoverageIgnore
 */
trait FileversionAware
{
    /**
     * @var FileversionInterface
     */
    protected $fileVersion;

    /**
     * @param FileversionInterface $fileVersion
     */
    public function setFileVersion(FileversionInterface $fileVersion)
    {
        $this->fileVersion = $fileVersion;
    }
}
