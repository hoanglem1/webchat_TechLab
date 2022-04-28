<?php
namespace App\Model\Table;

use Cake\ORM\Table;
// the Text class
use Cake\Utility\Text;
// the EventInterface class
use Cake\Event\EventInterface;
// the Validator class
use Cake\Validation\Validator;


class T_feedTable extends Table
{
    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'create_at' => 'new',
                    'update_at' => 'always'     
                ],
            ]
        ]);
    }
    public function beforeSave(EventInterface $event, $entity, $options)
{
    
}

    public function validationDefault(Validator $validator): Validator
{
    $validator
        ->notEmptyString('name')
        ->minLength('name', 1)
        ->maxLength('name', 255);

    $validator
        ->allowEmptyFile('video')
        ->add( 'video', [
        'mimeType' => [
            'rule' => [ 'mimeType', [ 'video/mp4' ] ],
            'message' => 'Please upload only video.',
        ],
        'fileSize' => [
            'rule' => [ 'fileSize', '<=', '1000MB' ],
            'message' => 'file size must be less than 1000MB.',
        ],
    ] );    
    $validator
        ->allowEmptyFile('image')
        ->add( 'image', [
        'mimeType' => [
            'rule' => [ 'mimeType', [ 'image/jpg', 'image/png', 'image/jpeg'] ],
            'message' => 'Please upload only video.',
        ],
        'fileSize' => [
            'rule' => [ 'fileSize', '<=', '5MB' ],
            'message' => 'file size must be less than 5MB.',
        ],
    ] );     
                                
    return $validator;
}
}