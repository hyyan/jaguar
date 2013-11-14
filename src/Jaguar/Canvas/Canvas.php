<?php

/*
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Jaguar\Canvas;

use Jaguar\Dimension;
use Jaguar\Exception\Canvas\CanvasCreationException;
use Jaguar\Canvas\Factory\JpegFactory;
use Jaguar\Canvas\Factory\GifFactory;
use Jaguar\Canvas\Factory\PngFactory;
use Jaguar\Canvas\Factory\GdFactory;

class Canvas extends AbstractCanvas {

    const TYPE_PNG = 'factory.png';
    const TYPE_JPEG = 'factory.jpeg';
    const TYPE_GIF = 'factory.gif';
    const TYPE_GD = 'factory.gd2';

    private $factories = array();
    private $activeFactoryName = null;
    private $activeCanvas = null;

    /**
     * Constrcut new canvas
     * 
     * @param \Jaguar\Dimension $dimension
     * @param string $factoryName factory name
     * 
     * @throws \Jaguar\Exception\InvalidDimensionException
     * @throws \Jaguar\Exception\Canvas\CanvasCreationException
     */
    public function __construct(Dimension $dimension = null, $factoryName = self::TYPE_PNG) {
        $this->__initFactories__();
        $this->setType($factoryName);
        parent::__construct($dimension);
    }

    /** i factories */
    protected function __initFactories__() {
        $this->addFactory(self::TYPE_JPEG, new JpegFactory())
                ->addFactory(self::TYPE_GIF, new GifFactory())
                ->addFactory(self::TYPE_PNG, new PngFactory())
                ->addFactory(self::TYPE_GD, new GdFactory());
    }

    /**
     * Set canvas factory
     * 
     * @param string $name factory's name
     * 
     * @return \Jaguar\Canvas\Canvas
     * @throws \InvalidArgumentException
     */
    public function setType($name) {
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
    public function getActiveFactoryName() {
        return $this->activeFactoryName;
    }

    /**
     * Get atcive factory instance
     * 
     * @return \Jaguar\Canvas\CanvasFactory
     */
    public function getActiveFactory() {
        return $this->getFactory($this->getActiveFactoryName());
    }

    /**
     * Get instance of the active canvas which the current canvas wraps
     * 
     * @return \Jaguar\Canvas\CanvasInterface
     */
    public function getActiveCanvas() {
        return $this->activeCanvas;
    }

    /**
     * Add new factory
     * 
     * @param string $name factory name
     * @param \Jaguar\Canvas\CanvasFactory $factory factory instance
     * 
     * @return \Jaguar\Canvas\Canvas 
     */
    public function addFactory($name, CanvasFactory $factory) {
        $this->factories[$name] = $factory;
        return $this;
    }

    /**
     * Add array of factories
     * 
     * @param array $factories
     * 
     * @return \Jaguar\Canvas\Canvas
     */
    public function setFactory(array $factories) {
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
     * @return \Jaguar\Canvas\CanvasFactory|false false if not found
     */
    public function getFactory($name) {
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
    public function removeFactory($name) {
        if ($this->hasFactory($name)) {
            unset($this->factories[$name]);
            return true;
        }
        return false;
    }

    /**
     * Check if the given factory name is registered
     * 
     * @param string $name tyep name
     * @return boolean true if found false otherwise
     */
    public function hasFactory($name) {
        return isset($this->factories[$name]) ? true : false;
    }

    /**
     * Get all registered factories
     * 
     * @return array
     */
    public function getFactories() {
        return $this->factories;
    }

    /**
     * Get canvas mime type
     * 
     * @return string
     */
    public function getMimeType() {
        return $this->getActiveFactory()->getMimeType();
    }

    /**
     * Get canvas extension
     * 
     * @param boolean $includeDot true to inlcude dot false to ignore it
     * 
     * @return string
     */
    public function getExtension($includeDot = true) {
        return $this->getActiveFactory()->getExtension($includeDot);
    }

    /**
     * Output raw canvas directly to the browser
     * 
     * <b>Note : </b>
     * The write header for every canvas type will be send also
     * 
     * @throws \Jaguar\Exception\Canvas\CanvasEmptyException
     */
    public function show() {
        $this->assertEmpty();
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
     * {@inheritdoc}
     */
    public function setHandler($handler) {
        $this->getActiveCanvas()->setHandler($handler);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getHandler() {
        return $this->getActiveCanvas()->getHandler();
    }

    /**
     * {@inheritdoc}
     */
    public function fromCanvas(CanvasInterface $canvas) {
        if (!($canvas instanceof self)) {
            throw new \InvalidArgumentException(
            'FromCanvas Accepts Only Instance OF "\Jaguar\Canvas\Canvas"'
            );
        }
        $this->setType($canvas->getActiveFactoryName());
        $this->setHandler($canvas->getHandler());
        return $this;
    }

    public function __clone() {
        
    }
    /**
     * {@inheritdoc}
     */
    protected function doGetCopy() {
        $clone = new self();
        $clone->setFactory($this->getFactories());
        $clone->setType($this->getActiveFactoryName());
        $clone->create($this->getDimension());
        $clone->paste($this);
        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    protected function doSave($path) {
        $this->getActiveCanvas()->save($path);
    }

    /**
     * {@inheritdoc}
     * 
     * @codeCoverageIgnore
     */
    protected function getToStringProperties() {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function destroy() {
        $this->getActiveCanvas()->destroy();
    }

    /**
     * {@inheritdoc}
     */
    public function __toString() {
        return (string) $this->getActiveCanvas();
    }

    /**
     * {@inheritdoc}
     */
    protected function doLoadFromFile($file) {
        $throw = true;
        if ($this->getActiveFactory()->isSupported($file)) {
            $this->getActiveCanvas()->fromFile($file);
        } else {
            $found = false;
            foreach ($this->getFactories() as $name => $factory) {
                if ($factory->isSupported($file)) {
                    $this->setType($name);
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