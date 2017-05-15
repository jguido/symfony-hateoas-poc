<?php


namespace AppBundle\Helper;

use Hateoas\Configuration\Relation;
use Hateoas\Representation\PaginatedRepresentation;
use Hateoas\Representation\CollectionRepresentation;


class CollectionHelper
{


    private $array;
    private $embeddedRel;
    private $route;
    private $routeParameters = [];
    private $size;
    private $startPage;
    private $nbOfPages;
    private $limit;
    private $relations;

    private $pageQueryParameter;
    private $limitQueryParameter;

    /**
     * CollectionHelper constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param array $array
     * @param $embeddedRel
     * @return CollectionHelper
     */
    public function withCollection(array $array, $embeddedRel): self
    {
        $this->array = $array;
        $this->size = count($array);
        $this->embeddedRel = $embeddedRel;

        return $this;
    }

    /**
     * @param array $relation
     * @return CollectionHelper
     */
    public function withRelations(array $relation = []) : self
    {
        $this->relations = $relation;

        return $this;
    }

    /**
     * @param $name
     * @param $path
     * @return CollectionHelper
     */
    public function addRelations($name, $path) : self
    {
        $this->relations[] = new Relation($name, $path);

        return $this;
    }

    /**
     * @param $route
     * @return CollectionHelper
     */
    public function withRouteDefinition($route): self
    {
        $this->route = $route;

        return $this;

    }

    /**
     * @param $startPage
     * @param $nbOfPages
     * @param $limit
     * @param string $pageQueryParameter
     * @param string $limitQueryParameter
     * @return CollectionHelper
     */
    public function withPagination($startPage, $nbOfPages, $limit, $pageQueryParameter = 'page', $limitQueryParameter = 'limit'): self
    {
        $this->startPage = $startPage;
        $this->nbOfPages = $nbOfPages;
        $this->limit = $limit;
        $this->pageQueryParameter = $pageQueryParameter;
        $this->limitQueryParameter = $limitQueryParameter;

        return $this;
    }

    /**
     * @param bool $withAbsoluteLinks
     * @return PaginatedRepresentation
     */
    public function buildCollection($withAbsoluteLinks = false) : PaginatedRepresentation
    {
        return new PaginatedRepresentation(
            new CollectionRepresentation(
                $this->array,
                $this->embeddedRel, // embedded rel
                null,
                null,
                null,
                $this->relations
            ),
            $this->route, // route
            $this->routeParameters, // route parameters
            $this->startPage,       // page number
            $this->limit,      // limit
            $this->nbOfPages,       // total pages
            $this->pageQueryParameter,  // page route parameter name, optional, defaults to 'page'
            $this->limitQueryParameter, // limit route parameter name, optional, defaults to 'limit'
            $withAbsoluteLinks,   // generate relative URIs, optional, defaults to `false`
            $this->size       // total collection size, optional, defaults to `null`
        );
    }
}