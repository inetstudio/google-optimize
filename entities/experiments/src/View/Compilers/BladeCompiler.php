<?php

namespace InetStudio\GoogleOptimizePackage\Experiments\View\Compilers;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\View\Compilers\BladeCompiler as BaseBladeCompiler;

class BladeCompiler extends BaseBladeCompiler
{
    /**
     * @var array
     */
    protected $dynamicViews = [];

    /**
     * Set dynamic views content.
     *
     * @param  array  $views
     */
    public function setDynamicViews(array $views = []): void
    {
        $this->dynamicViews = $views;
    }

    /**
     * Get dynamic views content.
     *
     * @return array
     */
    public function getDynamicViews(): array
    {
        return $this->dynamicViews;
    }

    /**
     * Compile the view at the given path.
     *
     * @param  null  $path
     *
     * @throws FileNotFoundException
     */
    public function compile($path = null)
    {
        if ($path) {
            $this->setPath($path);
        }

        if (! is_null($this->cachePath)) {
            $viewContent = (isset($this->dynamicViews[$path]))
                ? $this->dynamicViews[$path]
                : $this->files->get($this->getPath());

            $contents = $this->compileString($viewContent);

            if (! empty($this->getPath())) {
                $contents = $this->appendFilePath($contents);
            }

            $this->files->put(
                $this->getCompiledPath($this->getPath()), $contents
            );
        }
    }

    /**
     * Get the path to the compiled version of a view.
     *
     * @param  string  $path
     * @return string
     */
    public function getCompiledPath($path)
    {
        $content = $this->dynamicViews[$path] ?? '';

        return $this->cachePath.'/'.sha1($path.$content).'.php';
    }

    /**
     * Append the file path to the compiled string.
     *
     * @param  string  $contents
     * @return string
     */
    protected function appendFilePath($contents)
    {
        $tokens = $this->getOpenAndClosingPhpTokens($contents);

        if ($tokens->isNotEmpty() && $tokens->last() !== T_CLOSE_TAG) {
            $contents .= ' ?>';
        }

        $path = $this->getPath();
        $path = (isset($this->dynamicViews[$path])) ? 'dynamic_'.$path : $path;

        return $contents."<?php /**PATH {$path} ENDPATH**/ ?>";
    }
}
