<?php
namespace Dic\Container\Foundations;

use Psr\Container\ContainerInterface;
use Dic\Container\Exceptions\NotFoundException;
use Dic\Container\Exceptions\ContainerException;

class Container implements ContainerInterface
{
    private array $entries = [];

	/**
	 * Finds an entry of the container by its identifier and returns it.
	 *
	 * @param string $id Identifier of the entry to look for.
	 *
	 * @return mixed Entry.
	 */
	public function get(string $id) 
    {
        // throw new NotFoundException('class "' . $id . '" does not exist');
        if($this->has($id)){
            $entry = $this->entries[$id];
    
            return $entry($this);
        }

        return $this->resolve($id);
	}
	
	/**
	 * Returns true if the container can return an entry for the given identifier.
	 * Returns false otherwise.
	 * 
	 * `has($id)` returning true does not mean that `get($id)` will not throw an exception.
	 * It does however mean that `get($id)` will not throw a `NotFoundExceptionInterface`.
	 *
	 * @param string $id Identifier of the entry to look for.
	 *
	 * @return bool
	 */
	public function has(string $id): bool 
    {
        return isset($this->entries[$id]);
	}

    public function set(string $id, callable $concrete)
    {
        $this->entries[$id] = $concrete;
    }

    public function resolve($id)
    {

        // 1- Inspect that we are trying to get from the container
        $reflectionClass = new \ReflectionClass($id);

        if(! $reflectionClass->isInstantiable()){
            throw new ContainerException('Class "' . $id . '" is not instantiable');
        }
        // 2- Inspect the constructor of the class
        $constructor = $reflectionClass->getConstructor();
        if(! $constructor){
            return new $id;
        }
        // 3- Inspect the constructor parameters (dependencies)
        $parameters = $constructor->getParameters();
        if(! $parameters){
            return new $id;
        }

        // 4- If the parameter constructor is a class then try to resolve that class using the container
        $dependencies = array_map(function( \ReflectionParameter $params) use($id){ 
            $name = $params->getName();
            $type = $params->getType();
            if(!$type){
                throw new ContainerException(    
                    "Failed to resolve class '{$id}' because param '{$name}' is missing a type hint"
                );
            }
            
            if($type instanceof \ReflectionUnionType){
                throw new ContainerException(    
                    "Failed to resolve class '{$id}' because of union type for param '{$name}' "
                );
            }

            if($type instanceof \ReflectionNamedType && !$type->isBuiltin()){
                return $this->get($type->getName());
            }

            throw new ContainerException(    
                "Failed to resolve class '{$id}' because invalid param '{$name}' "
            );
        },$parameters);

        return $reflectionClass->newInstanceArgs($dependencies);
    
    }
}