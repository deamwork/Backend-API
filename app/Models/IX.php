<?php

namespace App\Models;

use Elasticquent\ElasticquentTrait;
use Illuminate\Database\Eloquent\Model;

class IX extends Model {

    use ElasticquentTrait;

    /**
     * The elasticsearch settings.
     *
     * @var array
     */
    protected $indexSettings = [
        'analysis' => [
            'analyzer' => [
                'string_lowercase' => [
                    'tokenizer' => 'keyword',
                    'filter' => [ 'asciifolding', 'lowercase', 'custom_replace' ],
                ],
            ],
            'filter' => [
                'custom_replace' => [
                    'type' => 'pattern_replace',
                    'pattern' => "[^a-z0-9 ]",
                    'replacement' => "",
                ],
            ],
        ],
    ];

    /**
     * The elasticsearch mappings.
     *
     * @var array
     */
    protected $mappingProperties = [
        'name' => [
            'type' => 'string',
            'analyzer' => 'string_lowercase'
        ],
        'name_full  ' => [
            'type' => 'string',
            'analyzer' => 'string_lowercase'
        ],
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ixs';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['id', 'peeringdb_id', 'created_at', 'updated_at'];

    public function members()
    {
        return $this->hasMany('App\Models\IXMember', 'ix_peeringdb_id', 'peeringdb_id');
    }

}
