<?php

/*
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar;

use Jaguar\Dimension;
use Jaguar\Exception\CanvasCreationException;
use Jaguar\Factory\JpegFactory;
use Jaguar\Factory\GifFactory;
use Jaguar\Factory\PngFactory;
use Jaguar\Factory\GdFactory;

class Canvas extends AbstractCanvas
{
    const Format_PNG = 'factory.png';
    const Format_JPEG = 'factory.jpeg';
    const Format_GIF = 'factory.gif';
    const Format_GD = 'factory.gd2';

    private $factories = array();
    private $activeCanvas = null;
    private $activeFactoryName = null;

    /**
     * construct new canvas
     *
     * @param \Jaguar\Dimension|\Jaguar\CanvasInterface|file|null $source
     * @param string                                              $factoryName factory name
     *
     * @throws \Jaguar\Exception\InvalidDimensionException
     * @throws \Jaguar\Exception\CanvasCreationException
     */
    public function __construct($source = null, $factoryName = self::Format_PNG)
    {
        $this->__initFactories__();
        $this->setFormat($factoryName);
        parent::__construct($source);
    }

    /** init factories */
    protected function __initFactories__()
    {
        $this->setFactory(array(
            self::Format_JPEG => new JpegFactory()
            , self::Format_GIF => new GifFactory()
            , self::Format_PNG => new PngFactory()
            , self::Format_GD => new GdFactory()
        ));
    }

    /**
     * Set canvas factory
     *
     * @param string $name factory's name
     *
     * @return \Jaguar\Canvas
     * @throws \InvalidArgumentException
     */
    public function setFormat($name)
    {
        if (!$this->hasFactory($name)) {
            throw new \InvalidArgumentException(sprintf(
                    'Invalid Canvas Factory "%s"', $name
            ));
        }
        $this->activeFactoryName = $name;
        $this->activeCanvas = $this->getFactory($name)->getCanvas();

        return $this;
    }

    /**
     * Get the name of the active factory
     *
     * @return string
     */
    public function getActiveFactoryName()
    {
        return $this->activeFactoryName;
    }

    /**
     * Get atcive factory instance
     *
     * @return \Jaguar\CanvasFactory
     */
    public function getActiveFactory()
    {
        return $this->getFactory($this->getActiveFactoryName());
    }

    /**
     * Get instance of the active canvas which the current canvas wraps
     *
     * @return \Jaguar\CanvasInterface
     */
    public function getActiveCanvas()
    {
        return $this->activeCanvas;
    }

    /**
     * Add new factory
     *
     * @param string                $name    factory name
     * @param \Jaguar\CanvasFactory $factory factory instance
     *
     * @return \Jaguar\Canvas
     */
    public function addFactory($name, CanvasFactory $factory)
    {
        $this->factories[$name] = $factory;

        return $this;
    }

    /**
     * Add array of factories
     *
     * @param array $factories
     *
     * @return \Jaguar\Canvas
     */
    public function setFactory(array $factories)
    {
        foreach ($factories as $name => $factory) {
            $this->addFactory($name, $factory);
        }

        return $this;
    }

    /**
     * Get factory by its name
     *
     * @param string $name factory name
     *
     * @return \Jaguar\CanvasFactory|false false if not found
     */
    public function getFactory($name)
    {
        if ($this->hasFactory($name)) {
            return $this->factories[$name];
        }

        return false;
    }

    /**
     * Remove factory by its name
     *
     * @param string $name factory name
     *
     * @return boolean true if removed false otherwise
     */
    public function removeFactory($name)
    {
        if ($this->hasFactory($name)) {
            unset($this->factories[$name]);

            return true;
        }

        return false;
    }

    /**
     * Check if the given factory name is registered
     *
     * @param  string  $name tyep name
     * @return boolean true if found false otherwise
     */
    public function hasFactory($name)
    {
        return isset($this->factories[$name]) ? true : false;
    }

    /**
     * Get all registered factories
     *
     * @return array
     */
    public function getFactories()
    {
        return $this->factories;
    }

    /**
     * Get canvas mime type
     *
     * @return string
     */
    public function getMimeType()
    {
        return $this->getActiveFactory()->getMimeType();
    }

    /**
     * Get canvas extension
     *
     * @param boolean $includeDot true to inlcude dot false to ignore it
     *
     * @return string
     */
    public function getExtension($includeDot = true)
    {
        return $this->getActiveFactory()->getExtension($includeDot);
    }

    /**
     * Output raw canvas directly to the browser
     *
     * <b>Note : </b>
     * The write header for every canvas Format will be send also
     */
    public function show()
    {
        try {
            header(sprintf('Content-Type: %s', $this->getMimeType(), true));
            $this->save(null);
        } catch (\Exception $ex) {
            header(sprintf('Content-Type: text/html'), true);
            /* rethrow it */
            throw $ex;
        }
    }

    /**
     * Call metgod from the current active canvas
     *
     * @param string $name
     * @param mixed  $arguments
     */
    public function __call($name, $arguments)
    {
        if (!method_exists($this->getActiveCanvas(), $name)) {
            throw new \RuntimeException(sprintf(
                    'Call To Undefined Method "%s" From "%s"'
                    , get_class($this->getActiveCanvas()) . '::' . $name
                    , __METHOD__
            ));
        }
        $return = call_user_func_array(
                array($this->getActiveCanvas(), $name)
                , $arguments
        );
        if ($return instanceof CanvasInterface) {
            return $this;
        }

        return $return;
    }

    /**
     * {@inheritdoc}
     */
    public function fromCanvas(CanvasInterface $canvas)
    {
        $this->getActiveCanvas()->fromCanvas($canvas);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setHandler($handler)
    {
        $this->getActiveCanvas()->setHandler($handler);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getHandler()
    {
        return $this->getActiveCanvas()->getHandler();
    }

    /**
     * {@inheritdoc}
     */
    public function isHandlerSet()
    {
        return $this->getActiveCanvas()->isHandlerSet();
    }

    /**
     * {@inheritdoc}
     */
    public function __clone()
    {
        if ($this->isHandlerSet()) {
            $this->activeCanvas = $this->getActiveCanvas()->getCopy();
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function doSave($path)
    {
        $this->getActiveCanvas()->save($path);
    }

    /**
     * {@inheritdoc}
     *
     * @codeCoverageIgnore
     */
    protected function getToStringProperties()
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return (string) $this->getActiveCanvas();
    }

    /**
     * {@inheritdoc}
     */
    protected function doLoadFromFile($file)
    {
        $throw = true;
        if ($this->getActiveFactory()->isSupported($file)) {
            $this->getActiveCanvas()->fromFile($file);
        } else {
            $found = false;
            foreach ($this->getFactories() as $name => $factory) {
                if ($factory->isSupported($file)) {
                    $this->setFormat($name);
                    $this->getActiveCanvas()->fromFile($file);
                    $found = true;
                    break;
                }
            }
            $throw = $found;
        }

        if (!$throw) {
            throw new CanvasCreationException(sprintf(
                    'Unsupported Canvas - Unable To Load Canvas From "%s"', $file
            ));
        }

        return $this;
    }

}
