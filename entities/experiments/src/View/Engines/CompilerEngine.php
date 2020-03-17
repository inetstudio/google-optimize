<?php

namespace InetStudio\GoogleOptimizePackage\Experiments\View\Engines;

use Illuminate\Support\Facades\Session;
use Illuminate\View\Compilers\CompilerInterface;
use Illuminate\View\Engines\CompilerEngine as BaseCompilerEngine;

class CompilerEngine extends BaseCompilerEngine
{
    /**
     * @var array
     */
    protected $dynamicViews = [];

    /**
     * CompilerEngine constructor.
     *
     * @param  CompilerInterface  $compiler
     */
    public function __construct(CompilerInterface $compiler)
    {
        parent::__construct($compiler);

        $dynamicViews = Session::get('google_optimize_experiments', []);

        if (method_exists($this->compiler, 'setDynamicViews')) {
            $this->compiler->setDynamicViews($dynamicViews['views']);
        }

        $this->dynamicViews = $dynamicViews['views'];
    }

    /**
     * Get the evaluated contents of the view.
     *
     * @param  string  $path
     * @param  array  $data
     * @return string
     */
    public function get($path, array $data = [])
    {
        $this->lastCompiled[] = (isset($this->dynamicViews[$path])) ? 'dynamic_'.$path : $path;

        // If this given view has expired, which means it has simply been edited since
        // it was last compiled, we will re-compile the views so we can evaluate a
        // fresh copy of the view. We'll pass the compiler the path of the view.
        if ($this->compiler->isExpired($path)) {
            $this->compiler->compile($path);
        }

        // Once we have the path to the compiled file, we will evaluate the paths with
        // typical PHP just like any other templates. We also keep a stack of views
        // which have been rendered for right exception messages to be generated.
        $results = $this->evaluatePath($this->compiler->getCompiledPath($path), $data);

        array_pop($this->lastCompiled);

        return $results;
    }
}
