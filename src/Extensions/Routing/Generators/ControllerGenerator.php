<?php namespace Denaje\Extensions\Routing\Generators;

use Illuminate\Routing\Generators\ControllerGenerator as CG;

class ControllerGenerator extends CG
{
    /**
     * Get the controller class stub.
     *
     * @param  string  $controller
     * @return string
     */
    protected function getController($controller)
    {
        $stub = $this->files->get(__DIR__.'/stubs/controller.stub');

        // We will explode out the controller name on the namespace delimiter so we
        // are able to replace a namespace in this stub file. If no namespace is
        // provided we'll just clear out the namespace place-holder locations.
        $segments = explode('\\', $controller);

        $stub = $this->replaceNamespace($segments, $stub);

        return str_replace('{{class}}', last($segments), $stub);
    }

    /**
     * Add the method stubs to the controller.
     *
     * @param  string  $stub
     * @param  array   $options
     * @return string
     */
    protected function addMethods($stub, array $options)
    {
        // Once we have the applicable methods, we can just spin through those methods
        // and add each one to our array of method stubs. Then we will implode them
        // them all with end-of-line characters and return the final joined list.
        $stubs = $this->getMethodStubs($options);

        $methods = implode(PHP_EOL, $stubs);

        return str_replace('{{methods}}', $methods, $stub);
    }

    /**
     * Get all of the method stubs for the given options.
     *
     * @param  array  $options
     * @return array
     */
    protected function getMethodStubs($options)
    {
        $stubs = array();

        // Each stub is conveniently kept in its own file so we can just grab the ones
        // we need from disk to build the controller file. Once we have them all in
        // an array we will return this list of methods so they can be joined up.
        foreach ($this->getMethods($options) as $method) {
            $stubs[] = $this->files->get(__DIR__."/stubs/{$method}.stub");
        }

        return $stubs;
    }
}
