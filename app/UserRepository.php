<?php

namespace App;

use App\User;

class UserRepository
{
    /**
     * Atributos por los que se puede filtar.
     *
     * @var array
     */
    protected $filters = [
        'name', 'role',
    ];

	/**
	 * Devuelve una instancia del modelo del repositorio.
	 * 
	 * @return User
	 */
	public function getModel()
	{
		return new User;
	}

    public function search(array $data = array(), $paginate = false)
    {
        $data = array_only($data, $this->filters);
        $data = array_filter($data, 'strlen');
        $q = $this->getModel()->select();

        foreach ($data as $field => $value) {
            $filterMethod = 'filterBy' . studly_case($field);

            if(method_exists(get_called_class(), $filterMethod)) {
                $this->$filterMethod($q, $value);
            }
            else {
                $q->where($field, $data[$field]);
            }
        }

        $q->orderBy('name', 'asc');

        return $paginate
            ? $q->paginate(10)->appends($data)
            : $q->get();
    }

    public function filterByName($q, $value)
    {
    	$q->where('name', 'LIKE', "%{$value}%");
    }
}