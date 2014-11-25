<?php
/**
 * Created by PhpStorm.
 * User: splitice
 * Date: 25-11-2014
 * Time: 6:57 PM
 */

namespace Radical\Database\Model\Pagination;


use Elastica\Client;
use Elastica\Exception\NotImplementedException;
use Elastica\Query;
use Elastica\Search;
use Radical\Web\Pagination\IPaginationSource;

class ELSAdapter implements IPaginationSource {
    private $query;
    private $client;

    function __construct(Query\Builder $query, Client $client){
        $this->query = clone $query;
        $this->client = $client;
    }
    function get_where($field, $value){
        throw new NotImplementedException();
    }
    function get_limit($start, $count){
        $this->query->from($start);
        $this->query->size($count);

        $search = new Search($this->client);
        return $search->search($this->query->toArray())->getResults();
    }
    function getCount(){
        $search = new Search($this->client);
        $count = $search->count($this->query->toArray());
        return $count->count();
    }
} 