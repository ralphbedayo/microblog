<?php


namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Repository\Traits\CacheableRepository;

class BaseRepository extends \Prettus\Repository\Eloquent\BaseRepository
{
    use CacheableRepository;

    /**
     * Define the maximum amount of entries per page that is returned.
     * Set to 0 to "disable" this feature
     */
    protected $maxPaginationLimit = 0;

    /**
     * @inheritDoc
     */
    public function model()
    {
        return Model::class;
    }

    /**
     * @throws RepositoryException
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function paginate($limit = null, $columns = ['*'], $method = "paginate")
    {
        // the priority is for the function parameter, if not available then take
        // it from the request if available and if not keep it null.
        $limit = $limit ?: request()->get('limit');

        // check, if skipping pagination is allowed and the requested by the user
        if ($limit == "0") {
            return parent::all($columns);
        }

        // check for the maximum entries per pagination
        if (   is_int($this->maxPaginationLimit)
            && $this->maxPaginationLimit > 0
            && $limit > $this->maxPaginationLimit
        ) {
            $limit = $this->maxPaginationLimit;
        }

        return parent::paginate($limit, $columns, $method);
    }
}
